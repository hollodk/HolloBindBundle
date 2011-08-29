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
     * @var boolean $completed
     *
     * @ORM\Column(name="completed", type="boolean")
     */
    private $completed;

    /**
     * @var boolean $type
     *
     * @ORM\Column(name="type", type="string")
     */
    private $type;

    /**
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity="Domain")
     * @ORM\JoinColumn(name="domain_id", referencedColumnName="id", onDelete="cascade")
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
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
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
