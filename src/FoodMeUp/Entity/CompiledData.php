<?php

namespace FoodMeUp\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="compiled_data")
 */
class CompiledData
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="FoodMeUp\Entity\Food")
     * @ORM\JoinColumn(name="origfdcd", referencedColumnName="origfdcd")
     */
    private $food;

    /**
     * @ORM\ManyToOne(targetEntity="FoodMeUp\Entity\Component")
     */
    private $component;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $selvalTexte;

    /**
     * @ORM\Column(type="integer", length=5, nullable=true)
     */
    private $valMin;

    /**
     * @ORM\Column(type="integer", length=5, nullable=true)
     */
    private $valMax;

    /**
     * @ORM\Column(type="string", length=1, nullable=true)
     */
    private $cceurofir;

    /**
     * @ORM\Column(type="integer", length=10, nullable=true)
     */
    private $source;


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
     * Set selvalTexte
     *
     * @param string $selvalTexte
     *
     * @return CompiledData
     */
    public function setSelvalTexte($selvalTexte)
    {
        $this->selvalTexte = $selvalTexte;

        return $this;
    }

    /**
     * Get selvalTexte
     *
     * @return string
     */
    public function getSelvalTexte()
    {
        return $this->selvalTexte;
    }

    /**
     * Set valMin
     *
     * @param integer $valMin
     *
     * @return CompiledData
     */
    public function setValMin($valMin)
    {
        $this->valMin = $valMin;

        return $this;
    }

    /**
     * Get valMin
     *
     * @return integer
     */
    public function getValMin()
    {
        return $this->valMin;
    }

    /**
     * Set valMax
     *
     * @param integer $valMax
     *
     * @return CompiledData
     */
    public function setValMax($valMax)
    {
        $this->valMax = $valMax;

        return $this;
    }

    /**
     * Get valMax
     *
     * @return integer
     */
    public function getValMax()
    {
        return $this->valMax;
    }

    /**
     * Set cceurofir
     *
     * @param string $cceurofir
     *
     * @return CompiledData
     */
    public function setCceurofir($cceurofir)
    {
        $this->cceurofir = $cceurofir;

        return $this;
    }

    /**
     * Get cceurofir
     *
     * @return string
     */
    public function getCceurofir()
    {
        return $this->cceurofir;
    }

    /**
     * Set source
     *
     * @param integer $source
     *
     * @return CompiledData
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return integer
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set food
     *
     * @param \FoodMeUp\Entity\Food $food
     *
     * @return CompiledData
     */
    public function setFood(\FoodMeUp\Entity\Food $food = null)
    {
        $this->food = $food;

        return $this;
    }

    /**
     * Get food
     *
     * @return \FoodMeUp\Entity\Food
     */
    public function getFood()
    {
        return $this->food;
    }

    /**
     * Set component
     *
     * @param \FoodMeUp\Entity\Component $component
     *
     * @return CompiledData
     */
    public function setComponent(\FoodMeUp\Entity\Component $component = null)
    {
        $this->component = $component;

        return $this;
    }

    /**
     * Get component
     *
     * @return \FoodMeUp\Entity\Component
     */
    public function getComponent()
    {
        return $this->component;
    }
}
