<?php

namespace Hollo\BindBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class ModQueueListener
{
  private $em;
  private $bind;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function onRecordAdd(\Hollo\BindBundle\Event\FilterRecordEvent $event)
  {
    $queue = new \Hollo\BindBundle\Entity\ModQueue();
    $queue->setDomain($event->getRecord()->getDomain());
    $queue->setType('modified');

    $this->em->persist($queue);
    $this->em->flush();
  }
}
