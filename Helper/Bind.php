<?php

namespace Hollo\BindBundle\Helper;

class Bind
{
  private $em;
  private $templating;

  public function __construct($em, $templating)
  {
    $this->em = $em;
    $this->templating = $templating;
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
  file "{$letter}/{$domain->getDomain()};
}


EOF;
    }

    file_put_contents('/tmp/named.conf', $output);
  }

  public function rebuildZones()
  {
    $domains = $this->em->getRepository('HolloBindBundle:Domain')->findAll();

    foreach ($domains as $domain) {
      $this->writeZone($domain);
    }
  }

  public function writeZone($domain, $return = false)
  {
    $letter = substr($domain->getDomain(), 0, 1);

    if (!file_exists('/var/named/'.$letter) && !$return)
      mkdir('/var/named/'.$letter, 0755);

    $output = $this->templating->render('HolloBindBundle:Bind:zone.conf.txt', array(
      'ns1' => 'ns1.hollo.dk',
      'ns2' => 'ns2.hollo.dk',
      'hostmaster' => 'ns1.hollo.dk',
      'serial' => time()
    ));

    foreach ($domain->getRecords() as $record) {
      switch ($record->getType()) {
        case 'A':
          $output .= $record->getName()."\tA\t".$record->getAddress()."\n";
          break;
        case 'CNAME':
          $output .= $record->getName()."\tCNAME\t".$record->getAddress()."\n";
          break;
        case 'MX':
          $output .= "\tMX\t".$record->getPriority()."\t".$record->getAddress()."\n";
          break;
      }
    }

    file_put_contents('/var/named/'.$letter.'/'.$domain->getDomain(), $output);
  }
}
