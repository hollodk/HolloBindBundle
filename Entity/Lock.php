<?php

namespace Hollo\BindBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hollo\BindBundle\Entity\Lock
 *
 * @ORM\Table(name="dns_lock")
 * @ORM\Entity(repositoryClass="Hollo\BindBundle\Entity\LockRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Lock
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
     * @var string $process
     *
     * @ORM\Column(name="process", type="string", length=255)
     */
    private $process;

    /**
     * @var text $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;


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
     * Set process
     *
     * @param string $process
     */
    public function setProcess($process)
    {
        $this->process = $process;
    }

    /**
     * Get process
     *
     * @return string
     */
    public function getProcess()
    {
        return $this->process;
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
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
    }
}
