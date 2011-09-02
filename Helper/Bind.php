<?php

namespace Hollo\BindBundle\Helper;

class Bind
{
  private $em;
  private $templating;
  private $hostmaster;
  private $config_file;
  private $zone_path;

  public function __construct($em, $templating, $hostmaster, $config_file, $zone_path)
  {
    $this->em = $em;
    $this->templating = $templating;
    $this->hostmaster = $hostmaster;
    $this->config_file = $config_file;
    $this->zone_path = $zone_path;
  }

  public function reloadZone($domain)
  {
  }

  public function writeConfig()
  {
    $output = $this->templating->render('HolloBindBundle:Bind:named.conf.txt');

    $domains = $this->em->getRepository('HolloBindBundle:Domain')->findAll();
    foreach ($domains as $domain) {
      $letter = substr($domain->getDomain(),0,1);

      $output .= <<<EOF
zone "{$domain->getDomain()}" {
  type master;
  file "{$letter}/{$domain->getDomain()}";
};


EOF;
    }

    file_put_contents($this->config_file, $output);
  }

  public function buildZones()
  {
    $domains = $this->em->getRepository('HolloBindBundle:Domain')->findAll();

    foreach ($domains as $domain) {
      $this->writeZoneConfig($domain);
    }
  }

  public function getZoneConfig($domain)
  {
    $output = $this->templating->render('HolloBindBundle:Bind:zone.conf.txt', array(
      'ns1' => $domain->getNs1(),
      'ns2' => $domain->getNs2(),
      'hostmaster' => $this->hostmaster,
      'serial' => time()
    ));

    foreach ($domain->getRecords() as $record) {
      switch ($record->getType()) {
        case 'A':
          $output .= $record->getName()."\tA\t".$record->getAddress().PHP_EOL;
          break;
        case 'CNAME':
          $output .= $record->getName()."\tCNAME\t".$record->getAddress().PHP_EOL;
          break;
        case 'MX':
          $output .= "\tMX\t".$record->getPriority()."\t".$record->getAddress().PHP_EOL;
          break;
      }
    }

    return $output;
  }

  public function writeZoneConfig($domain)
  {
    $letter = substr($domain->getDomain(), 0, 1);

    if (!file_exists($this->zone_path.'/'.$letter))
      mkdir($this->zone_path.'/'.$letter, 0755);

    $output = $this->getZoneConfig($domain);

    file_put_contents($this->zone_path.'/'.$letter.'/'.$domain->getDomain(), $output);
  }
}
