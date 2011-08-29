<?php

namespace Hollo\BindBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class WriteConfigListener
{
  private $em;
  private $bind;

  public function __construct($em, $bind)
  {
    $this->em = $em;
    $this->bind = $bind;
  }

  public function onDomainAdd(\Hollo\BindBundle\Event\FilterDomainEvent $event)
  {
    $this->bind->writeConfig();
  }
}
