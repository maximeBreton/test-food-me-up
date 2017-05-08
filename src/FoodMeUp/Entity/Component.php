<?php

namespace FoodMeUp\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="component")
 */
class Component
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", length=6, nullable=true)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     */
    private $cOrigcpnmabr;

    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     */
    private $cEngcpnamabr;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $ecompid;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $infdstag;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $createdDate;
    
    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $updatedDate;
    
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
     * Set cOrigcpnmabr
     *
     * @param string $cOrigcpnmabr
     *
     * @return Component
     */
    public function setCOrigcpnmabr($cOrigcpnmabr)
    {
        $this->cOrigcpnmabr = $cOrigcpnmabr;

        return $this;
    }

    /**
     * Get cOrigcpnmabr
     *
     * @return string
     */
    public function getCOrigcpnmabr()
    {
        return $this->cOrigcpnmabr;
    }

    /**
     * Set cEngcpnamabr
     *
     * @param string $cEngcpnamabr
     *
     * @return Component
     */
    public function setCEngcpnamabr($cEngcpnamabr)
    {
        $this->cEngcpnamabr = $cEngcpnamabr;

        return $this;
    }

    /**
     * Get cEngcpnamabr
     *
     * @return string
     */
    public function getCEngcpnamabr()
    {
        return $this->cEngcpnamabr;
    }

    /**
     * Set ecompid
     *
     * @param string $ecompid
     *
     * @return Component
     */
    public function setEcompid($ecompid)
    {
        $this->ecompid = $ecompid;

        return $this;
    }

    /**
     * Get ecompid
     *
     * @return string
     */
    public function getEcompid()
    {
        return $this->ecompid;
    }

    /**
     * Set infdstag
     *
     * @param string $infdstag
     *
     * @return Component
     */
    public function setInfdstag($infdstag)
    {
        $this->infdstag = $infdstag;

        return $this;
    }

    /**
     * Get infdstag
     *
     * @return string
     */
    public function getInfdstag()
    {
        return $this->infdstag;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return Component
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set updatedDate
     *
     * @param \DateTime $updatedDate
     *
     * @return Component
     */
    public function setUpdatedDate($updatedDate)
    {
        $this->updatedDate = $updatedDate;

        return $this;
    }

    /**
     * Get updatedDate
     *
     * @return \DateTime
     */
    public function getUpdatedDate()
    {
        return $this->updatedDate;
    }
}
