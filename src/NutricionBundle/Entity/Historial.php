<?php

namespace NutricionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Volumenes
 *
 * @ORM\Table(name="Historial")
 * @ORM\Entity(repositoryClass="NutricionBundle\Repository\HistorialRepository")
 */
class Historial
{


     /**
     * @ORM\ManyToOne(targetEntity="Planilla", inversedBy="volumenes")
     * @ORM\JoinColumn(name="idafiliado", referencedColumnName="id")
     */

    protected $planilla;
    

    /**
     * @ORM\ManyToOne(targetEntity="Periodocierre", inversedBy="volumenes")
     * @ORM\JoinColumn(name="idperiodocierre", referencedColumnName="id")
     */
    protected $periodocierre;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="idafiliado", type="integer", nullable=true)
     */
    private $idafiliado;

    /**
     * @var string
     *
     * @ORM\Column(name="monto", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $monto;

    /**
     * @var int
     *
     * @ORM\Column(name="pv", type="integer", nullable=true)
     */
    private $pv;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

    /**
     * @var int
     *
     * @ORM\Column(name="idperiodocierre", type="integer", nullable=true)
     */
    private $idperiodocierre;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idafiliado
     *
     * @param integer $idafiliado
     *
     * @return Volumenes
     */
    public function setIdafiliado($idafiliado)
    {
        $this->idafiliado = $idafiliado;

        return $this;
    }

    /**
     * Get idafiliado
     *
     * @return int
     */
    public function getIdafiliado()
    {
        return $this->idafiliado;
    }

    /**
     * Set monto
     *
     * @param string $monto
     *
     * @return Volumenes
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;

        return $this;
    }

    /**
     * Get monto
     *
     * @return string
     */
    public function getMonto()
    {
        return $this->monto;
    }

    /**
     * Set pv
     *
     * @param integer $pv
     *
     * @return Volumenes
     */
    public function setPv($pv)
    {
        $this->pv = $pv;

        return $this;
    }

    /**
     * Get pv
     *
     * @return int
     */
    public function getPv()
    {
        return $this->pv;
    }

   

    /**
     * Set planilla
     *
     * @param \NutricionBundle\Entity\Planilla $planilla
     *
     * @return Volumenes
     */
    public function setPlanilla(\NutricionBundle\Entity\Planilla $planilla = null)
    {
        $this->planilla = $planilla;

        return $this;
    }

    /**
     * Get planilla
     *
     * @return \NutricionBundle\Entity\Planilla
     */
    public function getPlanilla()
    {
        return $this->planilla;
    }

      /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Volumenes
     */
    public function setFecha($fecha)
    {
        $this->fecha = new \DateTime(date('Y-m-d'));

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set idperiodocierre
     *
     * @param integer $idperiodocierre
     *
     * @return Volumenes
     */
    public function setIdperiodocierre($idperiodocierre)
    {
        $this->idperiodocierre = $idperiodocierre;

        return $this;
    }

    /**
     * Get idperiodocierre
     *
     * @return integer
     */
    public function getIdperiodocierre()
    {
        return $this->idperiodocierre;
    }

    /**
     * Set periodocierre
     *
     * @param \NutricionBundle\Entity\Periodocierre $periodocierre
     *
     * @return Volumenes
     */
    public function setPeriodocierre(\NutricionBundle\Entity\Periodocierre $periodocierre = null)
    {
        $this->periodocierre = $periodocierre;

        return $this;
    }

    /**
     * Get periodocierre
     *
     * @return \NutricionBundle\Entity\Periodocierre
     */
    public function getPeriodocierre()
    {
        return $this->periodocierre;
    }


    public function __toString()
   {
      return strval($this->getId());
   }
}
