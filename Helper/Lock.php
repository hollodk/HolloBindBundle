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
    $lock = $this->em->getRepository('HolloBindBundle:Lock')->findOneBy(array(
      'process' => $process
    ));

    if ($lock)
      return true;

    return false;
  }

  public function createLock($process)
  {
    $lock = new \Hollo\BindBundle\Entity\Lock();
    $lock->setProcess($process);

    $this->em->persist($lock);
    $this->em->flush();
  }

  public function removeLock($process)
  {
    $lock = $this->em->getRepository('HolloBindBundle:Lock')->findOneBy(array(
      'process' => $process
    ));

    $this->em->remove($lock);
    $this->em->flush();
  }
}
