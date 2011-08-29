<?php

namespace Hollo\BindBundle\Helper;

class Queue
{
  private $em;
  private $event_dispatcher;
  private $bind;

  public function __construct($em, $event_dispatcher, $bind)
  {
    $this->em = $em;
    $this->event_dispatcher = $event_dispatcher;
    $this->bind = $bind;
  }

  public function processQueue()
  {
    $this->processModQueue();
  }

  private function processModQueue()
  {
    $queue = $this->em->getRepository('HolloBindBundle:ModQueue')->findAll();

    foreach ($queue as $domain) {
      $event = new \Hollo\BindBundle\Event\FilterDomainEvent($domain->getDomain());
      $this->event_dispatcher->dispatch(\Hollo\BindBundle\Event\Events::onDomainMod, $event);

      $domain->setCompleted(true);
      $this->em->persist($domain);

      if ($domain->getType() == 'add')
        $this->bind->writeConfig();
    }

    $this->em->flush();
  }
}
