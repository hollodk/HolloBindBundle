<?php

namespace Hollo\BindBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hollo\BindBundle\Entity\HostQueue
 *
 * @ORM\Table(name="dns_host_queue")
 * @ORM\Entity(repositoryClass="Hollo\BindBundle\Entity\HostQueueRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class HostQueue
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
     * @var boolean $host
     *
     * @ORM\Column(name="host", type="string")
     */
    private $host;

    /**
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity="ModQueue")
     * @ORM\JoinColumn(name="mod_queue_id", referencedColumnName="id", onDelete="cascade")
     */
    private $mod_queue;


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
     * Set host
     *
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * Get host
     *
     * @return string
     */
    public function getHost()
    {
        return $this->host;
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
     * Set mod_queue
     *
     * @param Hollo\BindBundle\Entity\ModQueue $modQueue
     */
    public function setModQueue(\Hollo\BindBundle\Entity\ModQueue $modQueue)
    {
        $this->mod_queue = $modQueue;
    }

    /**
     * Get mod_queue
     *
     * @return Hollo\BindBundle\Entity\ModQueue
     */
    public function getModQueue()
    {
        return $this->mod_queue;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
      $this->setCompleted(true);
      $this->setCreatedAt(new \DateTime());
    }
}
