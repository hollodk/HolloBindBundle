<?php

namespace Hollo\BindBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class WriteZoneListener
{
  private $em;
  private $bind;

  public function __construct($em, $bind)
  {
    $this->em = $em;
    $this->bind = $bind;
  }

  public function onRecordAdd(\Hollo\BindBundle\Event\FilterRecordEvent $event)
  {
    $this->bind->writeZone($event->getRecord()->getDomain());
  }

  public function onDomainMod(\Hollo\BindBundle\Event\FilterDomainEvent $event)
  {
    $this->bind->writeZone($event->getDomain());
  }
}
