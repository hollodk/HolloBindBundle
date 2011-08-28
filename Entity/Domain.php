<?php

namespace Hollo\BindBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hollo\BindBundle\Entity\Domain
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Hollo\BindBundle\Entity\DomainRepository")
 */
class Domain
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
     * @var string $domain
     *
     * @ORM\Column(name="domain", type="string", length=255)
     */
    private $domain;

    /**
     * @var string $address
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var string $password
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string $ns1
     *
     * @ORM\Column(name="ns1", type="string", length=255)
     */
    private $ns1;

    /**
     * @var string $ns2
     *
     * @ORM\Column(name="ns2", type="string", length=255)
     */
    private $ns2;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;


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
     * Set domain
     *
     * @param string $domain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    /**
     * Get domain
     *
     * @return string 
     */
    public function getDomain()
    {
        return $this->domain;
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

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set ns1
     *
     * @param string $ns1
     */
    public function setNs1($ns1)
    {
        $this->ns1 = $ns1;
    }

    /**
     * Get ns1
     *
     * @return string 
     */
    public function getNs1()
    {
        return $this->ns1;
    }

    /**
     * Set ns2
     *
     * @param string $ns2
     */
    public function setNs2($ns2)
    {
        $this->ns2 = $ns2;
    }

    /**
     * Get ns2
     *
     * @return string 
     */
    public function getNs2()
    {
        return $this->ns2;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription()
    {
        return $this->description;
    }
}