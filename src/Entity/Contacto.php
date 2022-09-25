<?php

namespace App\Entity;

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
     * @ORM\Column(name="codigo_identificacion_fk", type="string", length=3, nullable=true)
     */
    private $codigoIdentificacionFk;

    /**
     * @ORM\Column(name="numero_identificacion", type="string", length=20, nullable=true)
     */
    private $numeroIdentificacion;

    /**
     * @ORM\Column(name="codigo_ciudad_identificacion_fk", type="integer", nullable=true)
     */
    private $codigoCiudadIdentificacionFk;

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
     * @ORM\Column(name="direccion", type="string", length=200, nullable=true)
     */
    private $direccion;

    /**
     * @ORM\Column(name="codigo_ciudad_fk", type="integer", nullable=true)
     */
    private $codigoCiudadFk;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Identificacion", inversedBy="contactosIdentificacionRel")
     * @ORM\JoinColumn(name="codigo_identificacion_fk", referencedColumnName="codigo_identificacion_pk")
     */
    private $identificacionRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ciudad", inversedBy="contactosCiudadRel")
     * @ORM\JoinColumn(name="codigo_ciudad_fk", referencedColumnName="codigo_ciudad_pk")
     */
    private $ciudadRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ciudad", inversedBy="contactosCiudadIdentificacionRel")
     * @ORM\JoinColumn(name="codigo_ciudad_identificacion_fk", referencedColumnName="codigo_ciudad_pk")
     */
    private $ciudadIdentificacionRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contrato", mappedBy="contactoRepresentanteRel")
     */
    protected $contratosContactoRepresentanteRel;

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

    /**
     * @return mixed
     */
    public function getCodigoIdentificacionFk()
    {
        return $this->codigoIdentificacionFk;
    }

    /**
     * @param mixed $codigoIdentificacionFk
     */
    public function setCodigoIdentificacionFk($codigoIdentificacionFk): void
    {
        $this->codigoIdentificacionFk = $codigoIdentificacionFk;
    }

    /**
     * @return mixed
     */
    public function getNumeroIdentificacion()
    {
        return $this->numeroIdentificacion;
    }

    /**
     * @param mixed $numeroIdentificacion
     */
    public function setNumeroIdentificacion($numeroIdentificacion): void
    {
        $this->numeroIdentificacion = $numeroIdentificacion;
    }

    /**
     * @return mixed
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param mixed $direccion
     */
    public function setDireccion($direccion): void
    {
        $this->direccion = $direccion;
    }

    /**
     * @return mixed
     */
    public function getCodigoCiudadFk()
    {
        return $this->codigoCiudadFk;
    }

    /**
     * @param mixed $codigoCiudadFk
     */
    public function setCodigoCiudadFk($codigoCiudadFk): void
    {
        $this->codigoCiudadFk = $codigoCiudadFk;
    }

    /**
     * @return mixed
     */
    public function getIdentificacionRel()
    {
        return $this->identificacionRel;
    }

    /**
     * @param mixed $identificacionRel
     */
    public function setIdentificacionRel($identificacionRel): void
    {
        $this->identificacionRel = $identificacionRel;
    }

    /**
     * @return mixed
     */
    public function getCiudadRel()
    {
        return $this->ciudadRel;
    }

    /**
     * @param mixed $ciudadRel
     */
    public function setCiudadRel($ciudadRel): void
    {
        $this->ciudadRel = $ciudadRel;
    }

    /**
     * @return mixed
     */
    public function getContratosContactoRepresentanteRel()
    {
        return $this->contratosContactoRepresentanteRel;
    }

    /**
     * @param mixed $contratosContactoRepresentanteRel
     */
    public function setContratosContactoRepresentanteRel($contratosContactoRepresentanteRel): void
    {
        $this->contratosContactoRepresentanteRel = $contratosContactoRepresentanteRel;
    }

    /**
     * @return mixed
     */
    public function getCodigoCiudadIdentificacionFk()
    {
        return $this->codigoCiudadIdentificacionFk;
    }

    /**
     * @param mixed $codigoCiudadIdentificacionFk
     */
    public function setCodigoCiudadIdentificacionFk($codigoCiudadIdentificacionFk): void
    {
        $this->codigoCiudadIdentificacionFk = $codigoCiudadIdentificacionFk;
    }

    /**
     * @return mixed
     */
    public function getCiudadIdentificacionRel()
    {
        return $this->ciudadIdentificacionRel;
    }

    /**
     * @param mixed $ciudadIdentificacionRel
     */
    public function setCiudadIdentificacionRel($ciudadIdentificacionRel): void
    {
        $this->ciudadIdentificacionRel = $ciudadIdentificacionRel;
    }



}
