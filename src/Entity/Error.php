<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ErrorRepository")
 */
class Error
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_error_pk", type="integer", unique=true)
     */
    private $codigoErrorPk;

    /**
     * @ORM\Column(name="codigo_cliente_fk", type="integer", nullable=true)
     */
    private $codigoClienteFk;

    /**
     * @ORM\Column(name="mensaje", type="text", nullable=true)
     */
    private $mensaje;

    /**
     * @ORM\Column(name="codigo", type="integer", nullable=true)
     */
    private $codigo;

    /**
     * @ORM\Column(name="linea", type="integer", nullable=true)
     */
    private $linea;

    /**
     * @ORM\Column(name="ruta", type="string", length=500, nullable=true)
     */
    private $ruta;

    /**
     * @ORM\Column(name="archivo", type="string", length=500, nullable=true)
     */
    private $archivo;

    /**
     * @ORM\Column(name="traza", type="text", nullable=true)
     */
    private $traza;

    /**
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="usuario", type="string", length=100, nullable=true)
     */
    private $usuario;

    /**
     * @ORM\Column(name="email", type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(name="estado_atendido", type="boolean", nullable=true)
     */
    private $estadoAtendido = false;

    /**
     * @ORM\Column(name="estado_solucionado", type="boolean", nullable=true)
     */
    private $estadoSolucionado  = false;

    /**
     * @ORM\Column(name="usuario_soluciona", type="string", length=100, nullable=true)
     */
    private $usuarioSoluciona;

    /**
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="erroresClienteRel")
     * @ORM\JoinColumn(name="codigo_cliente_fk", referencedColumnName="codigo_cliente_pk")
     */
    protected $clienteRel;

    /**
     * @return mixed
     */
    public function getCodigoErrorPk()
    {
        return $this->codigoErrorPk;
    }

    /**
     * @param mixed $codigoErrorPk
     */
    public function setCodigoErrorPk($codigoErrorPk): void
    {
        $this->codigoErrorPk = $codigoErrorPk;
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
    public function getMensaje()
    {
        return $this->mensaje;
    }

    /**
     * @param mixed $mensaje
     */
    public function setMensaje($mensaje): void
    {
        $this->mensaje = $mensaje;
    }

    /**
     * @return mixed
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param mixed $codigo
     */
    public function setCodigo($codigo): void
    {
        $this->codigo = $codigo;
    }

    /**
     * @return mixed
     */
    public function getLinea()
    {
        return $this->linea;
    }

    /**
     * @param mixed $linea
     */
    public function setLinea($linea): void
    {
        $this->linea = $linea;
    }

    /**
     * @return mixed
     */
    public function getRuta()
    {
        return $this->ruta;
    }

    /**
     * @param mixed $ruta
     */
    public function setRuta($ruta): void
    {
        $this->ruta = $ruta;
    }

    /**
     * @return mixed
     */
    public function getArchivo()
    {
        return $this->archivo;
    }

    /**
     * @param mixed $archivo
     */
    public function setArchivo($archivo): void
    {
        $this->archivo = $archivo;
    }

    /**
     * @return mixed
     */
    public function getTraza()
    {
        return $this->traza;
    }

    /**
     * @param mixed $traza
     */
    public function setTraza($traza): void
    {
        $this->traza = $traza;
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
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario($usuario): void
    {
        $this->usuario = $usuario;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
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
    public function getUsuarioSoluciona()
    {
        return $this->usuarioSoluciona;
    }

    /**
     * @param mixed $usuarioSoluciona
     */
    public function setUsuarioSoluciona($usuarioSoluciona): void
    {
        $this->usuarioSoluciona = $usuarioSoluciona;
    }



}