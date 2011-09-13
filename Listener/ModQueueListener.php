<?php

namespace Hollo\BindBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class ModQueueListener
{
  private $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function onRecordAdd(\Hollo\BindBundle\Event\FilterRecordEvent $event)
  {
    $queue = new \Hollo\BindBundle\Entity\ModQueue();
    $queue->setDomain($event->getRecord()->getDomain());
    $queue->setType('record.add');

    $this->em->persist($queue);
    $this->em->flush();
  }

  public function onRecordDel(\Hollo\BindBundle\Event\FilterRecordEvent $event)
  {
    $queue = new \Hollo\BindBundle\Entity\ModQueue();
    $queue->setDomain($event->getRecord()->getDomain());
    $queue->setType('record.delete');

    $this->em->persist($queue);
    $this->em->flush();
  }

  public function onRecordMod(\Hollo\BindBundle\Event\FilterRecordEvent $event)
  {
    $queue = new \Hollo\BindBundle\Entity\ModQueue();
    $queue->setDomain($event->getRecord()->getDomain());
    $queue->setType('record.modified');

    $this->em->persist($queue);
    $this->em->flush();
  }

  public function onDomainAdd(\Hollo\BindBundle\Event\FilterDomainEvent $event)
  {
    $queue = new \Hollo\BindBundle\Entity\ModQueue();
    $queue->setDomain($event->getDomain());
    $queue->setType('domain.add');

    $this->em->persist($queue);
    $this->em->flush();
  }

  public function onDomainDel(\Hollo\BindBundle\Event\FilterDomainEvent $event)
  {
    $queue = new \Hollo\BindBundle\Entity\ModQueue();
    $queue->setType('domain.delete');

    $this->em->persist($queue);
    $this->em->flush();
  }

  public function onDomainMod(\Hollo\BindBundle\Event\FilterDomainEvent $event)
  {
    $queue = new \Hollo\BindBundle\Entity\ModQueue();
    $queue->setDomain($event->getDomain());
    $queue->setType('domain.modified');

    $this->em->persist($queue);
    $this->em->flush();
  }
}
