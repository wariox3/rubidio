<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="estudio_detalle")
 * @ORM\Entity(repositoryClass="App\Repository\EstudioDetalleRepository")
 */
class EstudioDetalle
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_estudio_detalle_pk", type="integer")
     */
    private $codigoEstudioDetallePk;

    /**
     * @ORM\Column(name="codigo_estudio_fk", type="integer", nullable=true)
     */
    private $codigoEstudioFk;

    /**
     * @ORM\Column(name="fecha_validacion", type="datetime", nullable=true)
     */
    private $fechaValidacion;

    /**
     * @ORM\Column(name="codigo_modulo_fk", type="string", length=20, nullable=true)
     */
    private $codigoModuloFk;

    /**
     * @ORM\Column(name="responsable", type="string", length=200)
     */
    private $responsable;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Estudio", inversedBy="estudiosDetallesEstudioRel")
     * @ORM\JoinColumn(name="codigo_estudio_fk", referencedColumnName="codigo_estudio_pk")
     */
    private $estudioRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Modulo", inversedBy="estudiosDetallesModuloRel")
     * @ORM\JoinColumn(name="codigo_modulo_fk", referencedColumnName="codigo_modulo_pk")
     */
    private $moduloRel;

    /**
     * @return mixed
     */
    public function getCodigoEstudioDetallePk()
    {
        return $this->codigoEstudioDetallePk;
    }

    /**
     * @param mixed $codigoEstudioDetallePk
     */
    public function setCodigoEstudioDetallePk($codigoEstudioDetallePk): void
    {
        $this->codigoEstudioDetallePk = $codigoEstudioDetallePk;
    }

    /**
     * @return mixed
     */
    public function getCodigoEstudioFk()
    {
        return $this->codigoEstudioFk;
    }

    /**
     * @param mixed $codigoEstudioFk
     */
    public function setCodigoEstudioFk($codigoEstudioFk): void
    {
        $this->codigoEstudioFk = $codigoEstudioFk;
    }

    /**
     * @return mixed
     */
    public function getFechaValidacion()
    {
        return $this->fechaValidacion;
    }

    /**
     * @param mixed $fechaValidacion
     */
    public function setFechaValidacion($fechaValidacion): void
    {
        $this->fechaValidacion = $fechaValidacion;
    }

    /**
     * @return mixed
     */
    public function getCodigoModuloFk()
    {
        return $this->codigoModuloFk;
    }

    /**
     * @param mixed $codigoModuloFk
     */
    public function setCodigoModuloFk($codigoModuloFk): void
    {
        $this->codigoModuloFk = $codigoModuloFk;
    }

    /**
     * @return mixed
     */
    public function getEstudioRel()
    {
        return $this->estudioRel;
    }

    /**
     * @param mixed $estudioRel
     */
    public function setEstudioRel($estudioRel): void
    {
        $this->estudioRel = $estudioRel;
    }

    /**
     * @return mixed
     */
    public function getModuloRel()
    {
        return $this->moduloRel;
    }

    /**
     * @param mixed $moduloRel
     */
    public function setModuloRel($moduloRel): void
    {
        $this->moduloRel = $moduloRel;
    }

    /**
     * @return mixed
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * @param mixed $responsable
     */
    public function setResponsable($responsable): void
    {
        $this->responsable = $responsable;
    }



}
