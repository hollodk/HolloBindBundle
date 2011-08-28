<?php

namespace Hollo\BindBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hollo\BindBundle\Entity\DelQueue
 *
 * @ORM\Table(name="dns_del_queue")
 * @ORM\Entity(repositoryClass="Hollo\BindBundle\Entity\DelQueueRepository")
 */
class DelQueue
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer $domain_id
     *
     * @ORM\Column(name="domain_id", type="integer")
     */
    private $domain_id;

    /**
     * @var boolean $completed
     *
     * @ORM\Column(name="completed", type="boolean")
     */
    private $completed;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set domain_id
     *
     * @param integer $domainId
     */
    public function setDomainId($domainId)
    {
        $this->domain_id = $domainId;
    }

    /**
     * Get domain_id
     *
     * @return integer
     */
    public function getDomainId()
    {
        return $this->domain_id;
    }

    /**
     * Set completed
     *
     * @param boolean $completed
     */
    public function setCompleted($completed)
    {
        $this->completed = $completed;
    }

    /**
     * Get completed
     *
     * @return boolean
     */
    public function getCompleted()
    {
        return $this->completed;
    }
}
