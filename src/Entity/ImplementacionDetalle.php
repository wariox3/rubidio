<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="implementacion_detalle")
 * @ORM\Entity(repositoryClass="App\Repository\ImplementacionDetalleRepository")
 */
class ImplementacionDetalle
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_implementacion_detalle_pk", type="integer")
     */
    private $codigoImplementacionDetallePk;

    /**
     * @ORM\Column(name="codigo_implementacion_fk", type="integer", nullable=true)
     */
    private $codigoImplementacionFk;

    /**
     * @ORM\Column(name="codigo_modulo_fk", type="string", length=20, nullable=true)
     */
    private $codigoModuloFk;

    /**
     * @ORM\Column(name="codigo_requisito_fk", type="integer", nullable=true)
     */
    private $codigoRequisitoFk;

    /**
     * @ORM\Column(name="codigo_funcionalidad_fk", type="integer", nullable=true)
     */
    private $codigoFuncionalidadFk;

    /**
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="fecha_compromiso", type="datetime", nullable=true)
     */
    private $fechaCompromiso;

    /**
     * @ORM\Column(name="orden", type="integer", nullable=true)
     */
    private $orden = 0;

    /**
     * @ORM\Column(name="estado_inicio", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoInicio = false;

    /**
     * @ORM\Column(name="estado_capacitado", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoCapacitado = false;

    /**
     * @ORM\Column(name="estado_terminado", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoTerminado = false;

    /**
     * @ORM\Column(name="comentario", type="text", nullable=true)
     */
    private $comentario;

    /**
     * @ORM\Column(name="comentario_implementador", type="text", nullable=true)
     */
    private $comentarioImplementador;

    /**
     * @ORM\Column(name="responsable", type="string", length=200, nullable=true)
     */
    private $responsable;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Implementacion", inversedBy="implementacionesDetallesImplementacionRel")
     * @ORM\JoinColumn(name="codigo_implementacion_fk", referencedColumnName="codigo_implementacion_pk")
     */
    private $implementacionRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Requisito", inversedBy="implementacionesRequisitoRel")
     * @ORM\JoinColumn(name="codigo_requisito_fk", referencedColumnName="codigo_requisito_pk")
     */
    private $requisitoRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Funcionalidad", inversedBy="implementacionesFuncionalidadRel")
     * @ORM\JoinColumn(name="codigo_funcionalidad_fk", referencedColumnName="codigo_funcionalidad_pk")
     */
    private $funcionalidadRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Modulo", inversedBy="implementacionesModuloRel")
     * @ORM\JoinColumn(name="codigo_modulo_fk", referencedColumnName="codigo_modulo_pk")
     */
    private $moduloRel;

    /**
     * @return mixed
     */
    public function getCodigoImplementacionDetallePk()
    {
        return $this->codigoImplementacionDetallePk;
    }

    /**
     * @param mixed $codigoImplementacionDetallePk
     */
    public function setCodigoImplementacionDetallePk($codigoImplementacionDetallePk): void
    {
        $this->codigoImplementacionDetallePk = $codigoImplementacionDetallePk;
    }

    /**
     * @return mixed
     */
    public function getCodigoImplementacionFk()
    {
        return $this->codigoImplementacionFk;
    }

    /**
     * @param mixed $codigoImplementacionFk
     */
    public function setCodigoImplementacionFk($codigoImplementacionFk): void
    {
        $this->codigoImplementacionFk = $codigoImplementacionFk;
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
    public function getCodigoTemaFk()
    {
        return $this->codigoTemaFk;
    }

    /**
     * @param mixed $codigoTemaFk
     */
    public function setCodigoTemaFk($codigoTemaFk): void
    {
        $this->codigoTemaFk = $codigoTemaFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoResponsableFk()
    {
        return $this->codigoResponsableFk;
    }

    /**
     * @param mixed $codigoResponsableFk
     */
    public function setCodigoResponsableFk($codigoResponsableFk): void
    {
        $this->codigoResponsableFk = $codigoResponsableFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoAccionFk()
    {
        return $this->codigoAccionFk;
    }

    /**
     * @param mixed $codigoAccionFk
     */
    public function setCodigoAccionFk($codigoAccionFk): void
    {
        $this->codigoAccionFk = $codigoAccionFk;
    }

    /**
     * @return mixed
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * @param mixed $orden
     */
    public function setOrden($orden): void
    {
        $this->orden = $orden;
    }

    /**
     * @return mixed
     */
    public function getEstadoInicio()
    {
        return $this->estadoInicio;
    }

    /**
     * @param mixed $estadoInicio
     */
    public function setEstadoInicio($estadoInicio): void
    {
        $this->estadoInicio = $estadoInicio;
    }

    /**
     * @return mixed
     */
    public function getEstadoCapacitado()
    {
        return $this->estadoCapacitado;
    }

    /**
     * @param mixed $estadoCapacitado
     */
    public function setEstadoCapacitado($estadoCapacitado): void
    {
        $this->estadoCapacitado = $estadoCapacitado;
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
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * @param mixed $comentario
     */
    public function setComentario($comentario): void
    {
        $this->comentario = $comentario;
    }

    /**
     * @return mixed
     */
    public function getComentarioImplementador()
    {
        return $this->comentarioImplementador;
    }

    /**
     * @param mixed $comentarioImplementador
     */
    public function setComentarioImplementador($comentarioImplementador): void
    {
        $this->comentarioImplementador = $comentarioImplementador;
    }

    /**
     * @return mixed
     */
    public function getImplementacionRel()
    {
        return $this->implementacionRel;
    }

    /**
     * @param mixed $implementacionRel
     */
    public function setImplementacionRel($implementacionRel): void
    {
        $this->implementacionRel = $implementacionRel;
    }

    /**
     * @return mixed
     */
    public function getTemaRel()
    {
        return $this->temaRel;
    }

    /**
     * @param mixed $temaRel
     */
    public function setTemaRel($temaRel): void
    {
        $this->temaRel = $temaRel;
    }

    /**
     * @return mixed
     */
    public function getResponsableRel()
    {
        return $this->responsableRel;
    }

    /**
     * @param mixed $responsableRel
     */
    public function setResponsableRel($responsableRel): void
    {
        $this->responsableRel = $responsableRel;
    }

    /**
     * @return mixed
     */
    public function getAccionRel()
    {
        return $this->accionRel;
    }

    /**
     * @param mixed $accionRel
     */
    public function setAccionRel($accionRel): void
    {
        $this->accionRel = $accionRel;
    }

    /**
     * @return mixed
     */
    public function getFechaCompromiso()
    {
        return $this->fechaCompromiso;
    }

    /**
     * @param mixed $fechaCompromiso
     */
    public function setFechaCompromiso($fechaCompromiso): void
    {
        $this->fechaCompromiso = $fechaCompromiso;
    }

    /**
     * @return mixed
     */
    public function getCodigoRequisitoFk()
    {
        return $this->codigoRequisitoFk;
    }

    /**
     * @param mixed $codigoRequisitoFk
     */
    public function setCodigoRequisitoFk($codigoRequisitoFk): void
    {
        $this->codigoRequisitoFk = $codigoRequisitoFk;
    }

    /**
     * @return mixed
     */
    public function getRequisitoRel()
    {
        return $this->requisitoRel;
    }

    /**
     * @param mixed $requisitoRel
     */
    public function setRequisitoRel($requisitoRel): void
    {
        $this->requisitoRel = $requisitoRel;
    }

    /**
     * @return mixed
     */
    public function getCodigoFuncionalidadFk()
    {
        return $this->codigoFuncionalidadFk;
    }

    /**
     * @param mixed $codigoFuncionalidadFk
     */
    public function setCodigoFuncionalidadFk($codigoFuncionalidadFk): void
    {
        $this->codigoFuncionalidadFk = $codigoFuncionalidadFk;
    }

    /**
     * @return mixed
     */
    public function getFuncionalidadRel()
    {
        return $this->funcionalidadRel;
    }

    /**
     * @param mixed $funcionalidadRel
     */
    public function setFuncionalidadRel($funcionalidadRel): void
    {
        $this->funcionalidadRel = $funcionalidadRel;
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
