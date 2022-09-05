<?php

namespace App\Entity;

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
     * @ORM\Column(name="codigo_caso_tipo_fk", type="string", length=3, nullable=true)
     */
    private $codigoCasoTipoFk;

    /**
     * @ORM\Column(name="compromiso", type="date", nullable=true)
     */
    private $compromiso;

    /**
     * @ORM\Column(name="fecha_cerrado", type="datetime", nullable=true)
     */
    private $fechaCerrado;

    /**
     * @ORM\Column(name="fecha_atendido", type="datetime", nullable=true)
     */
    private $fechaAtendido;

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
     * @ORM\Column(name="escalado", type="text", nullable=true)
     */
    private $escalado;

    /**
     * @ORM\Column(name="codigo_prioridad_fk", type="string", length=20, nullable=true)
     */
    private $codigoPrioridadFk;

    /**
     * @ORM\Column(name="cliente_ingreso", type="string", length=200, nullable=true)
     */
    private $clienteIngreso;

    /**
     * @ORM\Column(name="estado_atendido", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoAtendido = false;

    /**
     * @ORM\Column(name="estado_escalado", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoEscalado = false;

    /**
     * @ORM\Column(name="estado_desarrollo", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoDesarrollo = false;

    /**
     * @ORM\Column(name="estado_cerrado", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoCerrado = false;

    /**
     * @ORM\Column(name="estado_respuesta", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoRespuesta = false;

    /**
     * @ORM\Column(name="codigo_modulo_fk", type="string", length=20, nullable=true)
     */
    private $codigoModuloFk;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\CasoTipo", inversedBy="casosCasoTipoRel")
     * @ORM\JoinColumn(name="codigo_caso_tipo_fk", referencedColumnName="codigo_caso_tipo_pk")
     */
    private $casoTipoRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Modulo", inversedBy="casosModuloRel")
     * @ORM\JoinColumn(name="codigo_modulo_fk", referencedColumnName="codigo_modulo_pk")
     */
    private $moduloRel;

    /**
     * @ORM\OneToMany(targetEntity="Tarea", mappedBy="casoRel")
     */
    protected $tareasCasoRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CasoGestion", mappedBy="casoRel")
     */
    protected $casosGestionesCasoRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CasoRespuesta", mappedBy="casoRel")
     */
    protected $casosRespuestasCasoRel;

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
    public function getCodigoCasoTipoFk()
    {
        return $this->codigoCasoTipoFk;
    }

    /**
     * @param mixed $codigoCasoTipoFk
     */
    public function setCodigoCasoTipoFk($codigoCasoTipoFk): void
    {
        $this->codigoCasoTipoFk = $codigoCasoTipoFk;
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
    public function getFechaCerrado()
    {
        return $this->fechaCerrado;
    }

    /**
     * @param mixed $fechaCerrado
     */
    public function setFechaCerrado($fechaCerrado): void
    {
        $this->fechaCerrado = $fechaCerrado;
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
    public function getClienteIngreso()
    {
        return $this->clienteIngreso;
    }

    /**
     * @param mixed $clienteIngreso
     */
    public function setClienteIngreso($clienteIngreso): void
    {
        $this->clienteIngreso = $clienteIngreso;
    }

    /**
     * @return bool
     */
    public function isEstadoAtendido(): bool
    {
        return $this->estadoAtendido;
    }

    /**
     * @param bool $estadoAtendido
     */
    public function setEstadoAtendido(bool $estadoAtendido): void
    {
        $this->estadoAtendido = $estadoAtendido;
    }

    /**
     * @return bool
     */
    public function isEstadoEscalado(): bool
    {
        return $this->estadoEscalado;
    }

    /**
     * @param bool $estadoEscalado
     */
    public function setEstadoEscalado(bool $estadoEscalado): void
    {
        $this->estadoEscalado = $estadoEscalado;
    }

    /**
     * @return bool
     */
    public function isEstadoDesarrollo(): bool
    {
        return $this->estadoDesarrollo;
    }

    /**
     * @param bool $estadoDesarrollo
     */
    public function setEstadoDesarrollo(bool $estadoDesarrollo): void
    {
        $this->estadoDesarrollo = $estadoDesarrollo;
    }

    /**
     * @return bool
     */
    public function isEstadoCerrado(): bool
    {
        return $this->estadoCerrado;
    }

    /**
     * @param bool $estadoCerrado
     */
    public function setEstadoCerrado(bool $estadoCerrado): void
    {
        $this->estadoCerrado = $estadoCerrado;
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
    public function getCasoTipoRel()
    {
        return $this->casoTipoRel;
    }

    /**
     * @param mixed $casoTipoRel
     */
    public function setCasoTipoRel($casoTipoRel): void
    {
        $this->casoTipoRel = $casoTipoRel;
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
    public function getCasosGestionesCasoRel()
    {
        return $this->casosGestionesCasoRel;
    }

    /**
     * @param mixed $casosGestionesCasoRel
     */
    public function setCasosGestionesCasoRel($casosGestionesCasoRel): void
    {
        $this->casosGestionesCasoRel = $casosGestionesCasoRel;
    }

    /**
     * @return mixed
     */
    public function getCasosRespuestasCasoRel()
    {
        return $this->casosRespuestasCasoRel;
    }

    /**
     * @param mixed $casosRespuestasCasoRel
     */
    public function setCasosRespuestasCasoRel($casosRespuestasCasoRel): void
    {
        $this->casosRespuestasCasoRel = $casosRespuestasCasoRel;
    }

    /**
     * @return bool
     */
    public function isEstadoRespuesta(): bool
    {
        return $this->estadoRespuesta;
    }

    /**
     * @param bool $estadoRespuesta
     */
    public function setEstadoRespuesta(bool $estadoRespuesta): void
    {
        $this->estadoRespuesta = $estadoRespuesta;
    }

    /**
     * @return mixed
     */
    public function getFechaAtendido()
    {
        return $this->fechaAtendido;
    }

    /**
     * @param mixed $fechaAtendido
     */
    public function setFechaAtendido($fechaAtendido): void
    {
        $this->fechaAtendido = $fechaAtendido;
    }



}
