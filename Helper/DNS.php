<?php

namespace Hollo\BindBundle\Helper;

class DNS
{
  private $em;

  public function __construct($em)
  {
    $this->em = $em;
  }
}
