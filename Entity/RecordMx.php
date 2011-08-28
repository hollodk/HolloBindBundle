<?php

namespace Hollo\BindBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hollo\BindBundle\Entity\RecordMx
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Hollo\BindBundle\Entity\RecordMxRepository")
 */
class RecordMx
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
     * @var smallint $priority
     *
     * @ORM\Column(name="priority", type="smallint")
     */
    private $priority;

    /**
     * @var string $address
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;


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
     * Set priority
     *
     * @param smallint $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * Get priority
     *
     * @return smallint 
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set address
     *
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }
}