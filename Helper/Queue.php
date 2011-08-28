<?php

namespace Hollo\BindBundle\Helper;

class Queue
{
  private $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function processAddQueue()
  {
  }

  public function processDelQueue()
  {
  }

  public function processModQueue()
  {
  }
}
