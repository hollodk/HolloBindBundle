<?php

namespace Hollo\BindBundle\Helper;

class Bind
{
  private $em;
  private $templating;
  private $hostmaster;
  private $primary_nameserver;
  private $config_file;
  private $config_path;
  private $zone_path;
  private $bind_init;

  public function __construct($em, $templating, $hostmaster, $primary_nameserver, $config_file, $config_path, $zone_path, $bind_init)
  {
    $this->em = $em;
    $this->templating = $templating;
    $this->hostmaster = $hostmaster;
    $this->primary_nameserver = $primary_nameserver;
    $this->config_file = $config_file;
    $this->config_path = $config_path;
    $this->config_path = $config_path;
    $this->zone_path = $zone_path;
    $this->bind_init = $bind_init;
  }

  public function getZonePath()
  {
    return $this->zone_path;
  }

  public function getConfigFile()
  {
    return $this->config_file;
  }

  public function getConfigPath()
  {
    return $this->config_path;
  }

  public function getBindInit()
  {
    return $this->bind_init;
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

    $this->writeFile($this->config_path.'/'.$this->config_file, $output);
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
      'hostmaster' => $this->hostmaster,
      'primary_nameserver' => $this->primary_nameserver,
      'serial' => time()
    ));

    foreach ($domain->getRecords() as $record) {

      switch ($record->getType()) {
        case 'NS':
          $output .= $record->getName()."\t\tIN\tNS\t".$record->getAddress().PHP_EOL;
          break;
        case 'A':
          $output .= $record->getName()."\t\tIN\tA\t".$record->getAddress().PHP_EOL;
          break;
        case 'CNAME':
          $output .= $record->getName()."\t\tIN\tCNAME\t".$record->getAddress().PHP_EOL;
          break;
        case 'MX':
          $output .= $record->getName()."\t\tIN\tMX\t".$record->getPriority()."\t".$record->getAddress().PHP_EOL;
          break;
        case 'PTR':
          $output .= $record->getName()."\t\tIN\tPTR\t".$record->getAddress().PHP_EOL;
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

    $this->writeFile($this->zone_path.'/'.$letter.'/'.$domain->getDomain(), $output);
    $this->reloadDomain();
  }

  private function writeFile($file, $content)
  {
    file_put_contents($file, $content);
  }

  private function reloadDomain()
  {
    exec($this->bind_init.' reload');
  }
}
