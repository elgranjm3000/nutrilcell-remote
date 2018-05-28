<?php

namespace NutricionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Periodocierre
 *
 * @ORM\Table(name="periodocierre")
 * @ORM\Entity(repositoryClass="NutricionBundle\Repository\PeriodocierreRepository")
 */
class Periodocierre
{
    /**
     * @ORM\OneToMany(targetEntity="Volumenes", mappedBy="periodocierre")
     */
    protected $volumenes;
 
    public function __construct()
    {
        $this->volumenes = new ArrayCollection();
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Date
     *
     * @ORM\Column(name="fechadesde", type="date")     
     */
    private $fechadesde;

    /**
     * @var \Date
     *
     * @ORM\Column(name="fechahasta", type="date")
     */
    private $fechahasta;
   

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
     * Set fechadesde
     *
     * @param \DateTime $fechadesde
     *
     * @return Periodocierre
     */
    public function setFechadesde($fechadesde)
    {
        $this->fechadesde = $fechadesde;
        //$this->fechadesde = new \Date();
//            $this->fechadesde = new \DateTime();



        return $this;
    }

    /**
     * Get fechadesde
     *
     * @return \DateTime
     */
    public function getFechadesde()
    {
        return $this->fechadesde;
    }

    /**
     * Set fechahasta
     *
     * @param \DateTime $fechahasta
     *
     * @return Periodocierre
     */
    public function setFechahasta($fechahasta)
    {
       $this->fechahasta = $fechahasta;
  //$this->fechahasta = new \DateTime();


        return $this;
    }

    /**
     * Get fechahasta
     *
     * @return \DateTime
     */
    public function getFechahasta()
    {
        return $this->fechahasta;
    }

    /**
     * Add volumene
     *
     * @param \NutricionBundle\Entity\Volumenes $volumene
     *
     * @return Periodocierre
     */
    public function addVolumene(\NutricionBundle\Entity\Volumenes $volumene)
    {
        $this->volumenes[] = $volumene;

        return $this;
    }

    /**
     * Remove volumene
     *
     * @param \NutricionBundle\Entity\Volumenes $volumene
     */
    public function removeVolumene(\NutricionBundle\Entity\Volumenes $volumene)
    {
        $this->volumenes->removeElement($volumene);
    }

    /**
     * Get volumenes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVolumenes()
    {
        return $this->volumenes;
    }


    public function __toString()
   {
      return strval($this->getId());
   }
}