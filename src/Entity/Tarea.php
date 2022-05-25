<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tarea")
 * @ORM\Entity(repositoryClass="App\Repository\TareaRepository")
 */
class Tarea
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_tarea_pk", type="integer")
     */
    private $codigoTareaPk;

    /**
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="fecha_entrega", type="datetime", nullable=true)
     */
    private $fechaEntrega;

    /**
     * @ORM\Column(name="descripcion", type="string", length=5000, nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(name="comentario_terminado", type="string", length=5000, nullable=true)
     */
    private $comentarioTerminado;

    /**
     * @ORM\Column(name="codigo_usuario_fk", type="string")
     */
    private $codigoUsuarioFk;

    /**
     * @ORM\Column(name="codigo_prioridad_fk", type="string", length=20, nullable=true)
     */
    private $codigoPrioridadFk;

    /**
     * @ORM\Column(name="codigo_proyecto_fk", type="integer", nullable=true)
     */
    private $codigoProyectoFk;

    /**
     * @ORM\Column(name="estado_ejecucion", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoEjecucion = false;

    /**
     * @ORM\Column(name="estado_terminado", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoTerminado = false;

    /**
     * @ORM\Column(name="estado_verificado", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoVerificado = false;

    /**
     * @ORM\Column(name="estado_devolucion", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoDevolucion = false;

    /**
     * @ORM\Column(name="codigo_caso_fk", type="integer", nullable=true)
     */
    private $codigoCasoFk;

    /**
     * @ORM\Column(name="hora", type="float", options={"default" : 0})
     */
    private $hora = 0;

    /**
     * @ORM\Column(name="minuto", type="float", options={"default" : 0})
     */
    private $minuto = 0;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="tareasUsuarioRel")
     * @ORM\JoinColumn(name="codigo_usuario_fk", referencedColumnName="codigo_usuario_pk")
     */
    private $usuarioRel;

    /**
     * @ORM\ManyToOne(targetEntity="Prioridad", inversedBy="tareasPrioridadRel")
     * @ORM\JoinColumn(name="codigo_prioridad_fk", referencedColumnName="codigo_prioridad_pk")
     */
    private $prioridadRel;

    /**
     * @ORM\ManyToOne(targetEntity="Proyecto", inversedBy="tareasProyectoRel")
     * @ORM\JoinColumn(name="codigo_proyecto_fk", referencedColumnName="codigo_proyecto_pk")
     */
    private $proyectoRel;

    /**
     * @ORM\ManyToOne(targetEntity="Caso", inversedBy="tareasCasoRel")
     * @ORM\JoinColumn(name="codigo_caso_fk", referencedColumnName="codigo_caso_pk")
     */
    private $casoRel;

    /**
     * @ORM\OneToMany(targetEntity="Devolucion", mappedBy="tareaRel")
     */
    protected $devolucionesTareaRel;

    /**
     * @ORM\OneToMany(targetEntity="Tiempo", mappedBy="tareaRel")
     */
    protected $tiemposTareaRel;

    /**
     * @return mixed
     */
    public function getCodigoTareaPk()
    {
        return $this->codigoTareaPk;
    }

    /**
     * @param mixed $codigoTareaPk
     */
    public function setCodigoTareaPk($codigoTareaPk): void
    {
        $this->codigoTareaPk = $codigoTareaPk;
    }

    /**
     * @return mixed
     */
    public function getEstadoEjecucion()
    {
        return $this->estadoEjecucion;
    }

    /**
     * @param mixed $estadoEjecucion
     */
    public function setEstadoEjecucion($estadoEjecucion): void
    {
        $this->estadoEjecucion = $estadoEjecucion;
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
    public function getEstadoVerificado()
    {
        return $this->estadoVerificado;
    }

    /**
     * @param mixed $estadoVerificado
     */
    public function setEstadoVerificado($estadoVerificado): void
    {
        $this->estadoVerificado = $estadoVerificado;
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
    public function getCodigoUsuarioFk()
    {
        return $this->codigoUsuarioFk;
    }

    /**
     * @param mixed $codigoUsuarioFk
     */
    public function setCodigoUsuarioFk($codigoUsuarioFk): void
    {
        $this->codigoUsuarioFk = $codigoUsuarioFk;
    }

    /**
     * @return mixed
     */
    public function getUsuarioRel()
    {
        return $this->usuarioRel;
    }

    /**
     * @param mixed $usuarioRel
     */
    public function setUsuarioRel($usuarioRel): void
    {
        $this->usuarioRel = $usuarioRel;
    }

    /**
     * @return mixed
     */
    public function getCodigoPrioridadFk()
    {
        return $this->codigoPrioridadFk;
    }

    /**
     * @param mixed $codigoPrioridadFk
     */
    public function setCodigoPrioridadFk($codigoPrioridadFk): void
    {
        $this->codigoPrioridadFk = $codigoPrioridadFk;
    }

    /**
     * @return mixed
     */
    public function getPrioridadRel()
    {
        return $this->prioridadRel;
    }

    /**
     * @param mixed $prioridadRel
     */
    public function setPrioridadRel($prioridadRel): void
    {
        $this->prioridadRel = $prioridadRel;
    }

    /**
     * @return mixed
     */
    public function getDevolucionesTareaRel()
    {
        return $this->devolucionesTareaRel;
    }

    /**
     * @param mixed $devolucionesTareaRel
     */
    public function setDevolucionesTareaRel($devolucionesTareaRel): void
    {
        $this->devolucionesTareaRel = $devolucionesTareaRel;
    }

    /**
     * @return mixed
     */
    public function getEstadoDevolucion()
    {
        return $this->estadoDevolucion;
    }

    /**
     * @param mixed $estadoDevolucion
     */
    public function setEstadoDevolucion($estadoDevolucion): void
    {
        $this->estadoDevolucion = $estadoDevolucion;
    }

    /**
     * @return mixed
     */
    public function getCodigoProyectoFk()
    {
        return $this->codigoProyectoFk;
    }

    /**
     * @param mixed $codigoProyectoFk
     */
    public function setCodigoProyectoFk($codigoProyectoFk): void
    {
        $this->codigoProyectoFk = $codigoProyectoFk;
    }

    /**
     * @return mixed
     */
    public function getProyectoRel()
    {
        return $this->proyectoRel;
    }

    /**
     * @param mixed $proyectoRel
     */
    public function setProyectoRel($proyectoRel): void
    {
        $this->proyectoRel = $proyectoRel;
    }

    /**
     * @return mixed
     */
    public function getFechaEntrega()
    {
        return $this->fechaEntrega;
    }

    /**
     * @param mixed $fechaEntrega
     */
    public function setFechaEntrega($fechaEntrega): void
    {
        $this->fechaEntrega = $fechaEntrega;
    }

    /**
     * @return mixed
     */
    public function getCodigoCasoFk()
    {
        return $this->codigoCasoFk;
    }

    /**
     * @param mixed $codigoCasoFk
     */
    public function setCodigoCasoFk($codigoCasoFk): void
    {
        $this->codigoCasoFk = $codigoCasoFk;
    }

    /**
     * @return mixed
     */
    public function getCasoRel()
    {
        return $this->casoRel;
    }

    /**
     * @param mixed $casoRel
     */
    public function setCasoRel($casoRel): void
    {
        $this->casoRel = $casoRel;
    }

    /**
     * @return mixed
     */
    public function getComentarioTerminado()
    {
        return $this->comentarioTerminado;
    }

    /**
     * @param mixed $comentarioTerminado
     */
    public function setComentarioTerminado($comentarioTerminado): void
    {
        $this->comentarioTerminado = $comentarioTerminado;
    }

    /**
     * @return mixed
     */
    public function getTiemposTareaRel()
    {
        return $this->tiemposTareaRel;
    }

    /**
     * @param mixed $tiemposTareaRel
     */
    public function setTiemposTareaRel($tiemposTareaRel): void
    {
        $this->tiemposTareaRel = $tiemposTareaRel;
    }

    /**
     * @return mixed
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * @param mixed $hora
     */
    public function setHora($hora): void
    {
        $this->hora = $hora;
    }

    /**
     * @return mixed
     */
    public function getMinuto()
    {
        return $this->minuto;
    }

    /**
     * @param mixed $minuto
     */
    public function setMinuto($minuto): void
    {
        $this->minuto = $minuto;
    }



}
