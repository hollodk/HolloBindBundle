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

  public function reloadZone($domain_id)
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
  }

  public function writeZone($domain_id, $return = false)
  {
  }
}
