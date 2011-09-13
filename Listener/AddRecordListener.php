<?php

namespace Hollo\BindBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class AddRecordListener
{
  private $em;
  private $nameservers;

  public function __construct($em, $nameservers)
  {
    $this->em = $em;
    $this->nameservers = $nameservers;
  }

  public function onDomainAdd(\Hollo\BindBundle\Event\FilterDomainEvent $event)
  {
    $domain = $event->getDomain();

    foreach ($this->nameservers as $ns) {
      $record = new \Hollo\BindBundle\Entity\Record;
      $record->setDomain($domain);
      $record->setAddress($ns);
      $record->setType('NS');
      $this->em->persist($record);
    }

    $this->em->flush();
  }
}
