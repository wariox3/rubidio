<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="contacto")
 * @ORM\Entity(repositoryClass="App\Repository\ContactoRepository")
 */
class Contacto
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_contacto_pk", type="integer")
     */
    private $codigoContactoPk;

    /**
     * @ORM\Column(name="codigo_contacto_tipo_fk", type="string", length=3, nullable=true)
     */
    private $codigoContactoTipoFk;

    /**
     * @ORM\Column(name="codigo_cliente_fk", type="integer", nullable=true)
     */
    private $codigoClienteFk;

    /**
     * @ORM\Column(name="nombre", type="string", length=200, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="cargo", type="string", length=200, nullable=true)
     */
    private $cargo;

    /**
     * @ORM\Column(name="correo", type="string", length=200, nullable=true)
     */
    private $correo;

    /**
     * @ORM\Column(name="telefono", type="string", length=100, nullable=true, nullable=true)
     */
    private $telefono;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ContactoTipo", inversedBy="contactosContactoTipoRel")
     * @ORM\JoinColumn(name="codigo_contacto_tipo_fk", referencedColumnName="codigo_contacto_tipo_pk")
     */
    private $contactoTipoRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cliente", inversedBy="contactosClienteRel")
     * @ORM\JoinColumn(name="codigo_cliente_fk", referencedColumnName="codigo_cliente_pk")
     */
    private $clienteRel;

    /**
     * @return mixed
     */
    public function getCodigoContactoPk()
    {
        return $this->codigoContactoPk;
    }

    /**
     * @param mixed $codigoContactoPk
     */
    public function setCodigoContactoPk($codigoContactoPk): void
    {
        $this->codigoContactoPk = $codigoContactoPk;
    }

    /**
     * @return mixed
     */
    public function getCodigoContactoTipoFk()
    {
        return $this->codigoContactoTipoFk;
    }

    /**
     * @param mixed $codigoContactoTipoFk
     */
    public function setCodigoContactoTipoFk($codigoContactoTipoFk): void
    {
        $this->codigoContactoTipoFk = $codigoContactoTipoFk;
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
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * @param mixed $cargo
     */
    public function setCargo($cargo): void
    {
        $this->cargo = $cargo;
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
    public function getContactoTipoRel()
    {
        return $this->contactoTipoRel;
    }

    /**
     * @param mixed $contactoTipoRel
     */
    public function setContactoTipoRel($contactoTipoRel): void
    {
        $this->contactoTipoRel = $contactoTipoRel;
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



}
