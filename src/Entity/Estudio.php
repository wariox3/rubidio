<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="estudio")
 * @ORM\Entity(repositoryClass="App\Repository\EstudioRepository")
 */
class Estudio
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_estudio_pk", type="integer")
     */
    private $codigoEstudioPk;

    /**
     * @ORM\Column(name="codigo_cliente_fk", type="integer", nullable=true)
     */
    private $codigoClienteFk;

    /**
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @ORM\Column(name="responsable", type="string", length=200)
     */
    private $responsable;

    /**
     * @ORM\Column(name="estado_terminado", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoTerminado = false;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cliente", inversedBy="estudiosClienteRel")
     * @ORM\JoinColumn(name="codigo_cliente_fk", referencedColumnName="codigo_cliente_pk")
     */
    private $clienteRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EstudioDetalle", mappedBy="estudioRel")
     */
    protected $estudiosDetallesEstudioRel;

    /**
     * @return mixed
     */
    public function getCodigoEstudioPk()
    {
        return $this->codigoEstudioPk;
    }

    /**
     * @param mixed $codigoEstudioPk
     */
    public function setCodigoEstudioPk($codigoEstudioPk): void
    {
        $this->codigoEstudioPk = $codigoEstudioPk;
    }

    /**
     * @return mixed
     */
    public function getCodigoClienteFk()
    {
        return $this->codigoClienteFk;
    }

    /**
     * @param mixed $codigoClienteFk
     */
    public function setCodigoClienteFk($codigoClienteFk): void
    {
        $this->codigoClienteFk = $codigoClienteFk;
    }

    /**
     * @return bool
     */
    public function isEstadoTerminado(): bool
    {
        return $this->estadoTerminado;
    }

    /**
     * @param bool $estadoTerminado
     */
    public function setEstadoTerminado(bool $estadoTerminado): void
    {
        $this->estadoTerminado = $estadoTerminado;
    }

    /**
     * @return mixed
     */
    public function getClienteRel()
    {
        return $this->clienteRel;
    }

    /**
     * @param mixed $clienteRel
     */
    public function setClienteRel($clienteRel): void
    {
        $this->clienteRel = $clienteRel;
    }

    /**
     * @return mixed
     */
    public function getEstudiosDetallesEstudioRel()
    {
        return $this->estudiosDetallesEstudioRel;
    }

    /**
     * @param mixed $estudiosDetallesEstudioRel
     */
    public function setEstudiosDetallesEstudioRel($estudiosDetallesEstudioRel): void
    {
        $this->estudiosDetallesEstudioRel = $estudiosDetallesEstudioRel;
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
