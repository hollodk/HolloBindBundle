<?php

namespace Hollo\BindBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterDomainEvent extends Event
{
  protected $domain;

  public function __construct(\Hollo\BindBundle\Entity\Domain $domain)
  {
    $this->domain = $domain;
  }

  public function getDomain()
  {
    return $this->domain;
  }
}
