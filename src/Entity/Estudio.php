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
     * @ORM\Column(name="inventario", type="boolean", nullable=true, options={"default" : false})
     */
    private $inventario = false;

    /**
     * @ORM\Column(name="compra", type="boolean", nullable=true, options={"default" : false})
     */
    private $compra = false;

    /**
     * @ORM\Column(name="tesoreria", type="boolean", nullable=true, options={"default" : false})
     */
    private $tesoreria = false;

    /**
     * @ORM\Column(name="venta", type="boolean", nullable=true, options={"default" : false})
     */
    private $venta = false;

    /**
     * @ORM\Column(name="cartera", type="boolean", nullable=true, options={"default" : false})
     */
    private $cartera = false;

    /**
     * @ORM\Column(name="crm", type="boolean", nullable=true, options={"default" : false})
     */
    private $crm = false;

    /**
     * @ORM\Column(name="financiero", type="boolean", nullable=true, options={"default" : false})
     */
    private $financiero = false;

    /**
     * @ORM\Column(name="transporte", type="boolean", nullable=true, options={"default" : false})
     */
    private $transporte = false;

    /**
     * @ORM\Column(name="turno", type="boolean", nullable=true, options={"default" : false})
     */
    private $turno = false;

    /**
     * @ORM\Column(name="recurso_humano", type="boolean", nullable=true, options={"default" : false})
     */
    private $recursoHumano = false;

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
    public function isInventario(): bool
    {
        return $this->inventario;
    }

    /**
     * @param bool $inventario
     */
    public function setInventario(bool $inventario): void
    {
        $this->inventario = $inventario;
    }

    /**
     * @return bool
     */
    public function isCompra(): bool
    {
        return $this->compra;
    }

    /**
     * @param bool $compra
     */
    public function setCompra(bool $compra): void
    {
        $this->compra = $compra;
    }

    /**
     * @return bool
     */
    public function isTesoreria(): bool
    {
        return $this->tesoreria;
    }

    /**
     * @param bool $tesoreria
     */
    public function setTesoreria(bool $tesoreria): void
    {
        $this->tesoreria = $tesoreria;
    }

    /**
     * @return bool
     */
    public function isVenta(): bool
    {
        return $this->venta;
    }

    /**
     * @param bool $venta
     */
    public function setVenta(bool $venta): void
    {
        $this->venta = $venta;
    }

    /**
     * @return bool
     */
    public function isCartera(): bool
    {
        return $this->cartera;
    }

    /**
     * @param bool $cartera
     */
    public function setCartera(bool $cartera): void
    {
        $this->cartera = $cartera;
    }

    /**
     * @return bool
     */
    public function isCrm(): bool
    {
        return $this->crm;
    }

    /**
     * @param bool $crm
     */
    public function setCrm(bool $crm): void
    {
        $this->crm = $crm;
    }

    /**
     * @return bool
     */
    public function isFinanciero(): bool
    {
        return $this->financiero;
    }

    /**
     * @param bool $financiero
     */
    public function setFinanciero(bool $financiero): void
    {
        $this->financiero = $financiero;
    }

    /**
     * @return bool
     */
    public function isTransporte(): bool
    {
        return $this->transporte;
    }

    /**
     * @param bool $transporte
     */
    public function setTransporte(bool $transporte): void
    {
        $this->transporte = $transporte;
    }

    /**
     * @return bool
     */
    public function isTurno(): bool
    {
        return $this->turno;
    }

    /**
     * @param bool $turno
     */
    public function setTurno(bool $turno): void
    {
        $this->turno = $turno;
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
     * @return bool
     */
    public function isRecursoHumano(): bool
    {
        return $this->recursoHumano;
    }

    /**
     * @param bool $recursoHumano
     */
    public function setRecursoHumano(bool $recursoHumano): void
    {
        $this->recursoHumano = $recursoHumano;
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



}
