<?php

namespace Hollo\BindBundle\Helper;

class Bind
{
  private $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function reloadZone($domain_id)
  {
  }

  public function writeConfig()
  {
  }

  public function rebuildZones()
  {
  }

  public function writeZone($domain_id, $return = false)
  {
  }
}
