<?php

namespace Hollo\BindBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * HostQueueRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class HostQueueRepository extends EntityRepository
{
  public function findQueued()
  {
    return $this->_em->createQueryBuilder()
      ->add('select', 'mq')
      ->add('from', 'HolloBindBundle:ModQueue mq')
      ->leftJoin('mq.host_queue', 'hq')
      ->where('hq.completed IS NULL')
      ->getQuery()
      ->getResult();
  }
}