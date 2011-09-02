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
    $queue = $this->em->getRepository('HolloBindBundle:ModQueue')->findAll();

    foreach ($queue as $item) {
      switch ($item->getType()) {
      case 'domain.add':
        $this->bind->writeConfig();
        $this->bind->writeZoneConfig($item->getDomain());
        break;
      case 'domain.modified':
        $this->bind->writeZoneConfig($item->getDomain());
        break;
      case 'domain.delete':
        $this->bind->writeConfig();
        break;
      case 'record.add':
      case 'record.modified':
      case 'record.delete':
        $this->bind->writeZoneConfig($item->getDomain());
        break;
      }

      $item->setCompleted(true);
      $this->em->persist($item);
    }

    $this->em->flush();
  }
}
