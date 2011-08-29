<?php

namespace Hollo\BindBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hollo\BindBundle\Entity\ModQueue
 *
 * @ORM\Table(name="dns_mod_queue")
 * @ORM\Entity(repositoryClass="Hollo\BindBundle\Entity\ModQueueRepository")
 * @ORM\HasLifecycleCallbacks()
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
     * @ORM\ManyToOne(targetEntity="Domain")
     */
    private $domain;


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

    /**
     * Set domain
     *
     * @param Hollo\BindBundle\Entity\Domain $domain
     */
    public function setDomain(\Hollo\BindBundle\Entity\Domain $domain)
    {
        $this->domain = $domain;
    }

    /**
     * Get domain
     *
     * @return Hollo\BindBundle\Entity\Domain
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
      $this->setCompleted(false);
      $this->setCreatedAt(new \DateTime());
    }
}
