<?php

namespace Hollo\BindBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hollo\BindBundle\Entity\ModQueue
 *
 * @ORM\Table(name="dns_mod_queue")
 * @ORM\Entity(repositoryClass="Hollo\BindBundle\Entity\ModQueueRepository")
 */
class ModQueue
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
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;

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
     * Set created_at
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }

    /**
     * Get created_at
     *
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
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
