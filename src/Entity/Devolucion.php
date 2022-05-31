<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="devolucion")
 * @ORM\Entity(repositoryClass="App\Repository\DevolucionRepository")
 */
class Devolucion
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_devolucion_pk", type="integer")
     */
    private $codigoDevolucionPk;

    /**
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @ORM\Column(name="descripcion", type="string", length=2000, nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(name="codigo_tarea_fk", type="integer")
     */
    private $codigoTareaFk;

    /**
     * @ORM\Column(name="codigo_devolucion_tipo_fk", type="integer")
     */
    private $codigoDevolucionTipoFk;

    /**
     * @ORM\ManyToOne(targetEntity="Tarea", inversedBy="devolucionesTareaRel")
     * @ORM\JoinColumn(name="codigo_tarea_fk", referencedColumnName="codigo_tarea_pk")
     */
    private $tareaRel;

    /**
     * @ORM\ManyToOne(targetEntity="DevolucionTipo", inversedBy="devolucionesDevolucionTipoRel")
     * @ORM\JoinColumn(name="codigo_devolucion_tipo_fk", referencedColumnName="codigo_devolucion_tipo_pk")
     */
    private $devolucionTipoRel;

    /**
     * @return mixed
     */
    public function getCodigoDevolucionPk()
    {
        return $this->codigoDevolucionPk;
    }

    /**
     * @param mixed $codigoDevolucionPk
     */
    public function setCodigoDevolucionPk($codigoDevolucionPk): void
    {
        $this->codigoDevolucionPk = $codigoDevolucionPk;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha): void
    {
        $this->fecha = $fecha;
    }

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return mixed
     */
    public function getCodigoTareaFk()
    {
        return $this->codigoTareaFk;
    }

    /**
     * @param mixed $codigoTareaFk
     */
    public function setCodigoTareaFk($codigoTareaFk): void
    {
        $this->codigoTareaFk = $codigoTareaFk;
    }

    /**
     * @return mixed
     */
    public function getTareaRel()
    {
        return $this->tareaRel;
    }

    /**
     * @param mixed $tareaRel
     */
    public function setTareaRel($tareaRel): void
    {
        $this->tareaRel = $tareaRel;
    }

    /**
     * @return mixed
     */
    public function getCodigoDevolucionTipoFk()
    {
        return $this->codigoDevolucionTipoFk;
    }

    /**
     * @param mixed $codigoDevolucionTipoFk
     */
    public function setCodigoDevolucionTipoFk($codigoDevolucionTipoFk): void
    {
        $this->codigoDevolucionTipoFk = $codigoDevolucionTipoFk;
    }

    /**
     * @return mixed
     */
    public function getDevolucionTipoRel()
    {
        return $this->devolucionTipoRel;
    }

    /**
     * @param mixed $devolucionTipoRel
     */
    public function setDevolucionTipoRel($devolucionTipoRel): void
    {
        $this->devolucionTipoRel = $devolucionTipoRel;
    }



}
