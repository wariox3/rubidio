<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="soporte_llamada")
 * @ORM\Entity(repositoryClass="App\Repository\SoporteLLamadaRepository")
 */
class SoporteLLamada
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_implementacion_detalle_pk", type="integer")
     */
    private $codigoSoporteLLamadaPk;

    /**
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="fecha_llamada", type="datetime", nullable=true)
     */
    private $fechaLLamada;

    /**
     * @ORM\Column(name="comentarios", type="string", length=250, nullable=true)
     */
    private $comentarios;

    /**
     * @ORM\Column(name="codigo_soporte_fk", type="integer", nullable=true)
     */
    private $codigoSoporteFk;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Soporte", inversedBy="soporteLLamadasSoporteRel")
     * @ORM\JoinColumn(name="codigo_soporte_fk", referencedColumnName="codigo_soporte_pk")
     */
    private $soporteRel;

    /**
     * @return mixed
     */
    public function getCodigoSoporteLLamadaPk()
    {
        return $this->codigoSoporteLLamadaPk;
    }

    /**
     * @param mixed $codigoSoporteLLamadaPk
     */
    public function setCodigoSoporteLLamadaPk($codigoSoporteLLamadaPk): void
    {
        $this->codigoSoporteLLamadaPk = $codigoSoporteLLamadaPk;
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
    public function getFechaLLamada()
    {
        return $this->fechaLLamada;
    }

    /**
     * @param mixed $fechaLLamada
     */
    public function setFechaLLamada($fechaLLamada): void
    {
        $this->fechaLLamada = $fechaLLamada;
    }

    /**
     * @return mixed
     */
    public function getComentarios()
    {
        return $this->comentarios;
    }

    /**
     * @param mixed $comentarios
     */
    public function setComentarios($comentarios): void
    {
        $this->comentarios = $comentarios;
    }

    /**
     * @return mixed
     */
    public function getCodigoSoporteFk()
    {
        return $this->codigoSoporteFk;
    }

    /**
     * @param mixed $codigoSoporteFk
     */
    public function setCodigoSoporteFk($codigoSoporteFk): void
    {
        $this->codigoSoporteFk = $codigoSoporteFk;
    }

    /**
     * @return mixed
     */
    public function getSoporteRel()
    {
        return $this->soporteRel;
    }

    /**
     * @param mixed $soporteRel
     */
    public function setSoporteRel($soporteRel): void
    {
        $this->soporteRel = $soporteRel;
    }



}