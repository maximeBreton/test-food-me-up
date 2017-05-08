<?php

namespace FoodMeUp\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="FoodMeUp\Entity\FoodRepository")
 * @ORM\Table(name="food")
 */
class Food
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=6)
     */
    private $origfdcd;

    /**
     * @ORM\ManyToOne(targetEntity="FoodMeUp\Entity\FoodGroup", inversedBy="foods")
     * @ORM\JoinColumn(name="origgpcd", referencedColumnName="origgpcd")
     */
    private $foodGroup;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $origfdnm;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $engfdnam;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $createdDate;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $updatedDate;

    /**
     * Set origfdcd
     *
     * @param integer $origfdcd
     *
     * @return Food
     */
    public function setOrigfdcd($origfdcd)
    {
        $this->origfdcd = $origfdcd;

        return $this;
    }

    /**
     * Get origfdcd
     *
     * @return integer
     */
    public function getOrigfdcd()
    {
        return $this->origfdcd;
    }

    /**
     * Set origfdnm
     *
     * @param string $origfdnm
     *
     * @return Food
     */
    public function setOrigfdnm($origfdnm)
    {
        $this->origfdnm = $origfdnm;

        return $this;
    }

    /**
     * Get origfdnm
     *
     * @return string
     */
    public function getOrigfdnm()
    {
        return $this->origfdnm;
    }

    /**
     * Set engfdnam
     *
     * @param string $engfdnam
     *
     * @return Food
     */
    public function setEngfdnam($engfdnam)
    {
        $this->engfdnam = $engfdnam;

        return $this;
    }

    /**
     * Get engfdnam
     *
     * @return string
     */
    public function getEngfdnam()
    {
        return $this->engfdnam;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return Food
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
     * @return Food
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

    /**
     * Set foodGroup
     *
     * @param \FoodMeUp\Entity\FoodGroup $foodGroup
     *
     * @return Food
     */
    public function setFoodGroup(\FoodMeUp\Entity\FoodGroup $foodGroup = null)
    {
        $this->foodGroup = $foodGroup;

        return $this;
    }

    /**
     * Get foodGroup
     *
     * @return \FoodMeUp\Entity\FoodGroup
     */
    public function getFoodGroup()
    {
        return $this->foodGroup;
    }
}
