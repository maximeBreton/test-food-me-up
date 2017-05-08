<?php

namespace FoodMeUp\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="FoodMeUp\Entity\FoodGroupRepository")
 * @ORM\Table(name="food_group")
 */
class FoodGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=4)
     */
    private $origgpcd;

    /**
     * @ORM\OneToMany(targetEntity="FoodMeUp\Entity\Food", mappedBy="FoodGroup", cascade={"persist"})
     */
    private $foods;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $origgpfr;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $origgpeng;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $createdDate;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $updatedDate;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->foods = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set origgpcd
     *
     * @param string $origgpcd
     *
     * @return FoodGroup
     */
    public function setOriggpcd($origgpcd)
    {
        $this->origgpcd = $origgpcd;

        return $this;
    }

    /**
     * Get origgpcd
     *
     * @return string
     */
    public function getOriggpcd()
    {
        return $this->origgpcd;
    }

    /**
     * Set origgpfr
     *
     * @param string $origgpfr
     *
     * @return FoodGroup
     */
    public function setOriggpfr($origgpfr)
    {
        $this->origgpfr = $origgpfr;

        return $this;
    }

    /**
     * Get origgpfr
     *
     * @return string
     */
    public function getOriggpfr()
    {
        return $this->origgpfr;
    }

    /**
     * Set origgpeng
     *
     * @param string $origgpeng
     *
     * @return FoodGroup
     */
    public function setOriggpeng($origgpeng)
    {
        $this->origgpeng = $origgpeng;

        return $this;
    }

    /**
     * Get origgpeng
     *
     * @return string
     */
    public function getOriggpeng()
    {
        return $this->origgpeng;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return FoodGroup
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
     * @return FoodGroup
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
     * Add food
     *
     * @param \FoodMeUp\Entity\Food $food
     *
     * @return FoodGroup
     */
    public function addFood(\FoodMeUp\Entity\Food $food)
    {
        $this->foods[] = $food;

        return $this;
    }

    /**
     * Remove food
     *
     * @param \FoodMeUp\Entity\Food $food
     */
    public function removeFood(\FoodMeUp\Entity\Food $food)
    {
        $this->foods->removeElement($food);
    }

    /**
     * Get foods
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFoods()
    {
        return $this->foods;
    }
}
