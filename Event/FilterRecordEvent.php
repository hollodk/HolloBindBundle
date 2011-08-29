<?php

namespace Hollo\BindBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterRecordEvent extends Event
{
  protected $record;

  public function __construct(\Hollo\BindBundle\Entity\Record $record)
  {
    $this->record = $record;
  }

  public function getRecord()
  {
    return $this->record;
  }
}
