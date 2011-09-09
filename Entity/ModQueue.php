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
     * @ORM\OneToMany(targetEntity="HostQueue", mappedBy="mod_queue")
     */
    private $host_queue;


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
     * Add host_queue
     *
     * @param Hollo\BindBundle\Entity\HostQueue $hostQueue
     */
    public function addHostQueue(\Hollo\BindBundle\Entity\HostQueue $hostQueue)
    {
        $this->host_queue[] = $hostQueue;
    }

    /**
     * Get host_queue
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getHostQueue()
    {
        return $this->host_queue;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
    }
    public function __construct()
    {
        $this->host_queue = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
