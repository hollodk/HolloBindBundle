<?php

namespace Hollo\BindBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class AddRecordListener
{
  private $em;
  private $ns1;
  private $ns2;

  public function __construct($em, $ns1, $ns2)
  {
    $this->em = $em;
    $this->ns1 = $ns1;
    $this->ns2 = $ns2;
  }

  public function onDomainAdd(\Hollo\BindBundle\Event\FilterDomainEvent $event)
  {
    $domain = $event->getDomain();

    $record = new \Hollo\BindBundle\Entity\Record;
    $record->setDomain($domain);
    $record->setAddress($this->ns1);
    $record->setType('NS');
    $this->em->persist($record);

    $record = new \Hollo\BindBundle\Entity\Record;
    $record->setDomain($domain);
    $record->setAddress($this->ns2);
    $record->setType('NS');
    $this->em->persist($record);

    $this->em->flush();
  }
}
