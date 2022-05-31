<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="caso")
 * @ORM\Entity(repositoryClass="App\Repository\CasoRepository")
 */
class Caso
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_caso_pk", type="integer")
     */
    private $codigoCasoPk;

    /**
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="compromiso", type="date", nullable=true)
     */
    private $compromiso;

    /**
     * @ORM\Column(name="fecha_solucion", type="datetime", nullable=true)
     */
    private $fechaSolucion;

    /**
     * @ORM\Column(name="codigo_cliente_fk", type="integer", nullable=true)
     */
    private $codigoClienteFk;

    /**
     * @ORM\Column(name="contacto", type="string", length=200, nullable=true)
     */
    private $contacto;

    /**
     * @ORM\Column(name="correo", type="string", length=200, nullable=true)
     */
    private $correo;

    /**
     * @ORM\Column(name="telefono", type="string", length=100, nullable=true, nullable=true)
     */
    private $telefono;

    /**
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(name="solucion", type="text", nullable=true)
     */
    private $solucion;

    /**
     * @ORM\Column(name="comentario_postergado", type="text", nullable=true)
     */
    private $comentarioPostergado;

    /**
     * @ORM\Column(name="respuesta_postergado", type="text", nullable=true)
     */
    private $respuestaPostergado;

    /**
     * @ORM\Column(name="escalado", type="text", nullable=true)
     */
    private $escalado;

    /**
     * @ORM\Column(name="codigo_prioridad_fk", type="string", length=20, nullable=true)
     */
    private $codigoPrioridadFk;

    /**
     * @ORM\Column(name="estado_atendido", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoAtendido = false;

    /**
     * @ORM\Column(name="estado_solucionado", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoSolucionado = false;

    /**
     * @ORM\Column(name="estado_escalado", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoEscalado = false;

    /**
     * @ORM\Column(name="estado_desarrollo", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoDesarrollo = false;

    /**
     * @ORM\Column(name="estado_postergado", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoPostergado = false;

    /**
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="casosClienteRel")
     * @ORM\JoinColumn(name="codigo_cliente_fk", referencedColumnName="codigo_cliente_pk")
     */
    private $clienteRel;

    /**
     * @ORM\ManyToOne(targetEntity="Prioridad", inversedBy="casosPrioridadRel")
     * @ORM\JoinColumn(name="codigo_prioridad_fk", referencedColumnName="codigo_prioridad_pk")
     */
    private $prioridadRel;

    /**
     * @ORM\OneToMany(targetEntity="Tarea", mappedBy="casoRel")
     */
    protected $tareasCasoRel;

    /**
     * @return mixed
     */
    public function getCodigoCasoPk()
    {
        return $this->codigoCasoPk;
    }

    /**
     * @param mixed $codigoCasoPk
     */
    public function setCodigoCasoPk($codigoCasoPk): void
    {
        $this->codigoCasoPk = $codigoCasoPk;
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
    public function getCompromiso()
    {
        return $this->compromiso;
    }

    /**
     * @param mixed $compromiso
     */
    public function setCompromiso($compromiso): void
    {
        $this->compromiso = $compromiso;
    }

    /**
     * @return mixed
     */
    public function getFechaSolucion()
    {
        return $this->fechaSolucion;
    }

    /**
     * @param mixed $fechaSolucion
     */
    public function setFechaSolucion($fechaSolucion): void
    {
        $this->fechaSolucion = $fechaSolucion;
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
    public function getContacto()
    {
        return $this->contacto;
    }

    /**
     * @param mixed $contacto
     */
    public function setContacto($contacto): void
    {
        $this->contacto = $contacto;
    }

    /**
     * @return mixed
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * @param mixed $correo
     */
    public function setCorreo($correo): void
    {
        $this->correo = $correo;
    }

    /**
     * @return mixed
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @param mixed $telefono
     */
    public function setTelefono($telefono): void
    {
        $this->telefono = $telefono;
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
    public function getSolucion()
    {
        return $this->solucion;
    }

    /**
     * @param mixed $solucion
     */
    public function setSolucion($solucion): void
    {
        $this->solucion = $solucion;
    }

    /**
     * @return mixed
     */
    public function getEscalado()
    {
        return $this->escalado;
    }

    /**
     * @param mixed $escalado
     */
    public function setEscalado($escalado): void
    {
        $this->escalado = $escalado;
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
    public function getEstadoAtendido()
    {
        return $this->estadoAtendido;
    }

    /**
     * @param mixed $estadoAtendido
     */
    public function setEstadoAtendido($estadoAtendido): void
    {
        $this->estadoAtendido = $estadoAtendido;
    }

    /**
     * @return mixed
     */
    public function getEstadoSolucionado()
    {
        return $this->estadoSolucionado;
    }

    /**
     * @param mixed $estadoSolucionado
     */
    public function setEstadoSolucionado($estadoSolucionado): void
    {
        $this->estadoSolucionado = $estadoSolucionado;
    }

    /**
     * @return mixed
     */
    public function getEstadoEscalado()
    {
        return $this->estadoEscalado;
    }

    /**
     * @param mixed $estadoEscalado
     */
    public function setEstadoEscalado($estadoEscalado): void
    {
        $this->estadoEscalado = $estadoEscalado;
    }

    /**
     * @return mixed
     */
    public function getEstadoDesarrollo()
    {
        return $this->estadoDesarrollo;
    }

    /**
     * @param mixed $estadoDesarrollo
     */
    public function setEstadoDesarrollo($estadoDesarrollo): void
    {
        $this->estadoDesarrollo = $estadoDesarrollo;
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
    public function getTareasCasoRel()
    {
        return $this->tareasCasoRel;
    }

    /**
     * @param mixed $tareasCasoRel
     */
    public function setTareasCasoRel($tareasCasoRel): void
    {
        $this->tareasCasoRel = $tareasCasoRel;
    }

    /**
     * @return mixed
     */
    public function getComentarioPostergado()
    {
        return $this->comentarioPostergado;
    }

    /**
     * @param mixed $comentarioPostergado
     */
    public function setComentarioPostergado($comentarioPostergado): void
    {
        $this->comentarioPostergado = $comentarioPostergado;
    }

    /**
     * @return mixed
     */
    public function getEstadoPostergado()
    {
        return $this->estadoPostergado;
    }

    /**
     * @param mixed $estadoPostergado
     */
    public function setEstadoPostergado($estadoPostergado): void
    {
        $this->estadoPostergado = $estadoPostergado;
    }

    /**
     * @return mixed
     */
    public function getRespuestaPostergado()
    {
        return $this->respuestaPostergado;
    }

    /**
     * @param mixed $respuestaPostergado
     */
    public function setRespuestaPostergado($respuestaPostergado): void
    {
        $this->respuestaPostergado = $respuestaPostergado;
    }




}
