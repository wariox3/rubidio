<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="implementacion")
 * @ORM\Entity(repositoryClass="App\Repository\ImplementacionRepository")
 */
class Implementacion
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_implementacion_pk", type="integer")
     */
    private $codigoImplementacionPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=100, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="lider_cliente", type="string", length=100, nullable=true)
     */
    private $liderCliente;

    /**
     * @ORM\Column(name="celular_lider", type="string", length=50, nullable=true)
     */
    private $celularLider;

    /**
     * @ORM\Column(name="correo_lider", type="string", length=100, nullable=true)
     */
    private $correoLider;

    /**
     * @ORM\Column(name="codigo_cliente_fk", type="integer", nullable=true)
     */
    private $codigoClienteFk;

    /**
     * @ORM\Column(name="codigo_implementador_fk", type="integer", nullable=true)
     */
    private $codigoImplementadorFk;

    /**
     * @ORM\Column(name="general", type="boolean", nullable=true, options={"default" : false})
     */
    private $general = false;

    /**
     * @ORM\Column(name="recurso_humano", type="boolean", nullable=true, options={"default" : false})
     */
    private $recursoHumano = false;

    /**
     * @ORM\Column(name="turnos", type="boolean", nullable=true, options={"default" : false})
     */
    private $turnos = false;

    /**
     * @ORM\Column(name="inventario", type="boolean", nullable=true, options={"default" : false})
     */
    private $inventario = false;

    /**
     * @ORM\Column(name="tesoreria", type="boolean", nullable=true, options={"default" : false})
     */
    private $tesoreria = false;

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
     * @ORM\Column(name="juridico", type="boolean", nullable=true, options={"default" : false})
     */
    private $juridico = false;

    /**
     * @ORM\Column(name="estado_terminado", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoTerminado = false;

    /**
     * @ORM\Column(name="cantidad_detalles", type="integer", options={"default" : 0})
     */
    private $cantidadDetalles = 0;

    /**
     * @ORM\Column(name="tiempo", type="integer", options={"default" : 0})
     */
    private $tiempo = 0;

    /**
     * @ORM\Column(name="cantidad_detalles_terminados", type="integer", options={"default" : 0})
     */
    private $cantidadDetallesTerminados = 0;

    /**
     * @ORM\Column(name="tiempo_terminado", type="integer", options={"default" : 0})
     */
    private $tiempoTerminado = 0;

    /**
     * @ORM\Column(name="porcentaje_detalles", type="integer", options={"default" : 0})
     */
    private $porcentajeDetalles = 0;

    /**
     * @ORM\Column(name="porcentaje_tiempo", type="integer", options={"default" : 0})
     */
    private $porcentajeTiempo = 0;

    /**
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="implementacionesClienteRel")
     * @ORM\JoinColumn(name="codigo_cliente_fk", referencedColumnName="codigo_cliente_pk")
     */
    private $clienteRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Implementador", inversedBy="implementacionesImplementadorRel")
     * @ORM\JoinColumn(name="codigo_implementador_fk", referencedColumnName="codigo_implementador_pk")
     */
    private $implementadorRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ImplementacionDetalle", mappedBy="implementacionRel")
     */
    protected $implementacionesDetallesImplementacionRel;

    /**
     * @return mixed
     */
    public function getCodigoImplementacionPk()
    {
        return $this->codigoImplementacionPk;
    }

    /**
     * @param mixed $codigoImplementacionPk
     */
    public function setCodigoImplementacionPk($codigoImplementacionPk): void
    {
        $this->codigoImplementacionPk = $codigoImplementacionPk;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getImplementacionesDetallesImplementacionRel()
    {
        return $this->implementacionesDetallesImplementacionRel;
    }

    /**
     * @param mixed $implementacionesDetallesImplementacionRel
     */
    public function setImplementacionesDetallesImplementacionRel($implementacionesDetallesImplementacionRel): void
    {
        $this->implementacionesDetallesImplementacionRel = $implementacionesDetallesImplementacionRel;
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
    public function getGeneral()
    {
        return $this->general;
    }

    /**
     * @param mixed $general
     */
    public function setGeneral($general): void
    {
        $this->general = $general;
    }

    /**
     * @return mixed
     */
    public function getRecursoHumano()
    {
        return $this->recursoHumano;
    }

    /**
     * @param mixed $recursoHumano
     */
    public function setRecursoHumano($recursoHumano): void
    {
        $this->recursoHumano = $recursoHumano;
    }

    /**
     * @return mixed
     */
    public function getTurnos()
    {
        return $this->turnos;
    }

    /**
     * @param mixed $turnos
     */
    public function setTurnos($turnos): void
    {
        $this->turnos = $turnos;
    }

    /**
     * @return mixed
     */
    public function getLiderCliente()
    {
        return $this->liderCliente;
    }

    /**
     * @param mixed $liderCliente
     */
    public function setLiderCliente($liderCliente): void
    {
        $this->liderCliente = $liderCliente;
    }

    /**
     * @return mixed
     */
    public function getCelularLider()
    {
        return $this->celularLider;
    }

    /**
     * @param mixed $celularLider
     */
    public function setCelularLider($celularLider): void
    {
        $this->celularLider = $celularLider;
    }

    /**
     * @return mixed
     */
    public function getCorreoLider()
    {
        return $this->correoLider;
    }

    /**
     * @param mixed $correoLider
     */
    public function setCorreoLider($correoLider): void
    {
        $this->correoLider = $correoLider;
    }

    /**
     * @return mixed
     */
    public function getInventario()
    {
        return $this->inventario;
    }

    /**
     * @param mixed $inventario
     */
    public function setInventario($inventario): void
    {
        $this->inventario = $inventario;
    }

    /**
     * @return mixed
     */
    public function getTesoreria()
    {
        return $this->tesoreria;
    }

    /**
     * @param mixed $tesoreria
     */
    public function setTesoreria($tesoreria): void
    {
        $this->tesoreria = $tesoreria;
    }

    /**
     * @return mixed
     */
    public function getCartera()
    {
        return $this->cartera;
    }

    /**
     * @param mixed $cartera
     */
    public function setCartera($cartera): void
    {
        $this->cartera = $cartera;
    }

    /**
     * @return mixed
     */
    public function getEstadoTerminado()
    {
        return $this->estadoTerminado;
    }

    /**
     * @param mixed $estadoTerminado
     */
    public function setEstadoTerminado($estadoTerminado): void
    {
        $this->estadoTerminado = $estadoTerminado;
    }

    /**
     * @return mixed
     */
    public function getCodigoImplementadorFk()
    {
        return $this->codigoImplementadorFk;
    }

    /**
     * @param mixed $codigoImplementadorFk
     */
    public function setCodigoImplementadorFk($codigoImplementadorFk): void
    {
        $this->codigoImplementadorFk = $codigoImplementadorFk;
    }

    /**
     * @return mixed
     */
    public function getImplementadorRel()
    {
        return $this->implementadorRel;
    }

    /**
     * @param mixed $implementadorRel
     */
    public function setImplementadorRel($implementadorRel): void
    {
        $this->implementadorRel = $implementadorRel;
    }

    /**
     * @return mixed
     */
    public function getCrm()
    {
        return $this->crm;
    }

    /**
     * @param mixed $crm
     */
    public function setCrm($crm): void
    {
        $this->crm = $crm;
    }

    /**
     * @return mixed
     */
    public function getFinanciero()
    {
        return $this->financiero;
    }

    /**
     * @param mixed $financiero
     */
    public function setFinanciero($financiero): void
    {
        $this->financiero = $financiero;
    }

    /**
     * @return mixed
     */
    public function getJuridico()
    {
        return $this->juridico;
    }

    /**
     * @param mixed $juridico
     */
    public function setJuridico($juridico): void
    {
        $this->juridico = $juridico;
    }

    /**
     * @return int
     */
    public function getCantidadDetalles(): int
    {
        return $this->cantidadDetalles;
    }

    /**
     * @param int $cantidadDetalles
     */
    public function setCantidadDetalles(int $cantidadDetalles): void
    {
        $this->cantidadDetalles = $cantidadDetalles;
    }

    /**
     * @return int
     */
    public function getTiempo(): int
    {
        return $this->tiempo;
    }

    /**
     * @param int $tiempo
     */
    public function setTiempo(int $tiempo): void
    {
        $this->tiempo = $tiempo;
    }

    /**
     * @return int
     */
    public function getCantidadDetallesTerminados(): int
    {
        return $this->cantidadDetallesTerminados;
    }

    /**
     * @param int $cantidadDetallesTerminados
     */
    public function setCantidadDetallesTerminados(int $cantidadDetallesTerminados): void
    {
        $this->cantidadDetallesTerminados = $cantidadDetallesTerminados;
    }

    /**
     * @return int
     */
    public function getTiempoTerminado(): int
    {
        return $this->tiempoTerminado;
    }

    /**
     * @param int $tiempoTerminado
     */
    public function setTiempoTerminado(int $tiempoTerminado): void
    {
        $this->tiempoTerminado = $tiempoTerminado;
    }

    /**
     * @return int
     */
    public function getPorcentajeDetalles(): int
    {
        return $this->porcentajeDetalles;
    }

    /**
     * @param int $porcentajeDetalles
     */
    public function setPorcentajeDetalles(int $porcentajeDetalles): void
    {
        $this->porcentajeDetalles = $porcentajeDetalles;
    }

    /**
     * @return int
     */
    public function getPorcentajeTiempo(): int
    {
        return $this->porcentajeTiempo;
    }

    /**
     * @param int $porcentajeTiempo
     */
    public function setPorcentajeTiempo(int $porcentajeTiempo): void
    {
        $this->porcentajeTiempo = $porcentajeTiempo;
    }

    /**
     * @return bool
     */
    public function getTransporte(): bool
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


}
