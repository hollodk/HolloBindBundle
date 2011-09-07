<?php

namespace Hollo\BindBundle\Helper;

class Bind
{
  private $em;
  private $templating;
  private $hostmaster;
  private $config_file;
  private $zone_path;
  private $bind_init;

  public function __construct($em, $templating, $hostmaster, $config_file, $zone_path, $bind_init)
  {
    $this->em = $em;
    $this->templating = $templating;
    $this->hostmaster = $hostmaster;
    $this->config_file = $config_file;
    $this->zone_path = $zone_path;
    $this->bind_init = $bind_init;
  }

  public function reloadDomain()
  {
    exec($this->bind_init.' reload');
  }

  public function writeConfig()
  {
    $output = $this->templating->render('HolloBindBundle:Bind:named.conf.txt', array(
      'zone_path' => $this->zone_path
    ));

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
    $this->reloadDomain();
  }

  public function buildDomains()
  {
    $domains = $this->em->getRepository('HolloBindBundle:Domain')->findAll();

    foreach ($domains as $domain) {
      $this->writeDomainConfig($domain);
    }
  }

  public function getDomainConfig($domain)
  {
    $output = $this->templating->render('HolloBindBundle:Bind:zone.conf.txt', array(
      'ns1' => $domain->getNs1(),
      'ns2' => $domain->getNs2(),
      'hostmaster' => $this->hostmaster,
      'serial' => time()
    ));

    foreach ($domain->getRecords() as $record) {
      $name = ($record->getName() != '') ? $record->getName() : '@';

      switch ($record->getType()) {
        case 'A':
          $output .= $name."\t\t3H\tIN\tA\t".$record->getAddress().PHP_EOL;
          break;
        case 'CNAME':
          $output .= $name."\t\t3H\tIN\tCNAME\t".$record->getAddress().PHP_EOL;
          break;
        case 'MX':
          $output .= $name."\t\t3H\tIN\tMX\t".$record->getPriority()."\t".$record->getAddress().PHP_EOL;
          break;
      }
    }

    return $output;
  }

  public function writeDomainConfig($domain)
  {
    $letter = substr($domain->getDomain(), 0, 1);

    if (!file_exists($this->zone_path.'/'.$letter))
      mkdir($this->zone_path.'/'.$letter, 0755);

    $output = $this->getDomainConfig($domain);

    file_put_contents($this->zone_path.'/'.$letter.'/'.$domain->getDomain(), $output);
    $this->reloadDomain();
  }
}
