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

  public function processQueue($hostname)
  {
    $queue = $this->em->getRepository('HolloBindBundle:HostQueue')->findQueued($hostname);

    foreach ($queue as $item) {
      switch ($item->getType()) {
      case 'domain.add':
        $this->bind->writeConfig();
        $this->bind->writeDomainConfig($item->getDomain());
        break;
      case 'domain.modified':
        $this->bind->writeDomainConfig($item->getDomain());
        break;
      case 'domain.delete':
        $this->bind->writeConfig();
        break;
      case 'record.add':
      case 'record.modified':
      case 'record.delete':
        $this->bind->writeDomainConfig($item->getDomain());
        break;
      }

      $host_queue = new \Hollo\BindBundle\Entity\HostQueue();
      $host_queue->setModQueue($item);
      $host_queue->setHost($hostname);
      $this->em->persist($host_queue);
    }

    $this->em->flush();
  }
}
