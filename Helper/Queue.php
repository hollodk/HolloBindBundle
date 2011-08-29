<?php

namespace Hollo\BindBundle\Helper;

class Queue
{
  private $em;
  private $event_dispatcher;

  public function __construct($em, $event_dispatcher)
  {
    $this->em = $em;
    $this->event_dispatcher = $event_dispatcher;
  }

  public function processQueue()
  {
    $this->processModQueue();
    $this->processAddQueue();
    $this->processDelQueue();
  }

  private function processAddQueue()
  {
    $queue = $this->em->getRepository('HolloBindBundle:AddQueue')->findBy(array(
      'completed' => 0
    ));

    foreach ($queue as $zone) {
      $domain = new \Hollo\BindBundle\Entity\Domain();
      $domain->setDomain($zone->getDomain());
      $domain->setAddress($zone->getAddress());
      $domain->setPassword($zone->getPassword());
      $domain->setDescription($zone->getDescription());
      $domain->setNs1($zone->getNs1());
      $domain->setNs2($zone->getNs2());

      $record = new \Hollo\BindBundle\Entity\Record();
      $record->setDomain($domain);
      $record->setName('www');
      $record->setType('A');
      $record->setAddress($zone->getAddress());

      $zone->setCompleted(1);

      $this->em->persist($domain);
      $this->em->persist($record);
      $this->em->persist($zone);

      $this->em->flush();

      $event = new \Hollo\BindBundle\Event\FilterDomainEvent($domain);
      $this->event_dispatcher->dispatch(\Hollo\BindBundle\Event\Events::onDomainAdd, $event);
    }
  }

  private function processDelQueue()
  {
  }

  private function processModQueue()
  {
  }
}
