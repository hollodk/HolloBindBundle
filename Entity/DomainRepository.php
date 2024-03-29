<?php

namespace Hollo\BindBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * DomainRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DomainRepository extends EntityRepository
{
  public function getRecords(\Hollo\BindBundle\Entity\Domain $domain, array $types)
  {
    $where = '';
    foreach ($types as $type) {
      $where .= 'r.type = :'.$type.' OR ';
    }
    $where = preg_replace("/OR $/", "", $where);

    $query = "SELECT r FROM HolloBindBundle:Record r WHERE r.domain = :domain AND (".$where.")";

    $q = $this->_em->createQuery($query)
      ->setParameter('domain', $domain->getId());

    foreach ($types as $type) {
      $q->setParameter($type, $type);
    }

    return $q->getResult();
  }
}
