<?php

namespace Hollo\BindBundle\Helper;

class Lock
{
  private $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function isLock($process)
  {
  }

  public function createLock($process)
  {
  }

  public function removeLock($process)
  {
  }
}
