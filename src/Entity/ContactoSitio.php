<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="contacto_sitio")
 * @ORM\Entity(repositoryClass="App\Repository\ContactoSitioRepository")
 */
class ContactoSitio
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_contacto_sitio_pk", type="integer")
     */
    private $codigoContactoSitioPk;

    /**
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="nombre", type="string", length=200, nullable=true)
     */
    private $nombre ;

    /**
     * @ORM\Column(name="correo", type="string", length=200, nullable=true)
     * @Assert\Email(message = "El correo electrónico no es válido.")
     */
    private $correo;

    /**
     * @ORM\Column(name="telefono", type="string", length=100, nullable=true, nullable=true)
     */
    private $telefono;

    /**
     * @ORM\Column(name="empresa", type="string", length=200, nullable=true, nullable=true)
     */
    private $empresa;

    /**
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(name="estado_atendido", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoAtendido = false;

    /**
     * @return mixed
     */
    public function getCodigoContactoSitioPk()
    {
        return $this->codigoContactoSitioPk;
    }

    /**
     * @param mixed $codigoContactoSitioPk
     */
    public function setCodigoContactoSitioPk($codigoContactoSitioPk): void
    {
        $this->codigoContactoSitioPk = $codigoContactoSitioPk;
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
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * @param mixed $empresa
     */
    public function setEmpresa($empresa): void
    {
        $this->empresa = $empresa;
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



}
