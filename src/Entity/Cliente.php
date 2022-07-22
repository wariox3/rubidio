<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="cliente")
 * @ORM\Entity(repositoryClass="App\Repository\ClienteRepository")
 */
class Cliente
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_cliente_pk", type="integer")
     */
    private $codigoClientePk;

    /**
     * @ORM\Column(name="nombre_corto", type="string", length=100)
     */
    private $nombreCorto;

    /**
     * @ORM\Column(name="nombre_extendido", type="string", length=200, nullable=true)
     */
    private $nombreExtendido;

    /**
     * @ORM\Column(name="logo", type="blob", nullable=true)
     */
    private $logo;

    /**
     * @ORM\Column(type="string", length=5, name="extension", nullable=true)
     */
    private $extension;

    /**
     * @ORM\Column(name="telefono", type="string", length=25, nullable=true)
     */
    private $telefono;

    /**
     * @ORM\Column(name="direccion", type="string", length=120, nullable=true)
     */
    private $direccion;

    /**
     * @ORM\Column(name="nit", type="string", length=20, nullable=true)
     */
    private $nit;

    /**
     * @ORM\Column(name="digito_verificacion", type="string", length=2, nullable=true)
     */
    private $digitoVerificacion;

    /**
     * @ORM\Column(name="suscriptor", type="string", length=300, nullable=true)
     */
    private $suscriptor;

    /**
     * @ORM\Column(name="empleador", type="string", length=300, nullable=true)
     */
    private $empleador;

    /**
     * @ORM\Column(name="facturacion_electronica", type="boolean", nullable=true, options={"default" : false})
     */
    private $facturacionElectronica = false;

    /**
     * @ORM\Column(name="nomina_electronica", type="boolean", nullable=true, options={"default" : false})
     */
    private $nominaElectronica = false;

    /**
     * @ORM\Column(name="set_pruebas", type="boolean", nullable=true, options={"default" : false})
     */
    private $setPruebas = false;

    /**
     * @ORM\Column(name="set_pruebas_nomina", type="boolean", nullable=true, options={"default" : false})
     */
    private $setPruebasNomina = false;

    /**
     * @ORM\Column(name="correo_error", type="string", length=300, nullable=true)
     */
    private $correoError;

    /**
     * @ORM\Column(name="codigo_set_pruebas", type="string", length=300, nullable=true)
     */
    private $codigoSetPruebas;

    /**
     * @ORM\Column(name="codigo_set_pruebas_nominas", type="string", length=300, nullable=true)
     */
    private $codigoSetPruebasNominas;

    /**
     * @ORM\Column(name="servicio_soporte", type="boolean", nullable=true, options={"default" : true})
     */
    private $servicioSoporte = true;

    /**
     * @ORM\Column(name="fecha_suspension", type="date", nullable=true)
     */
    private $fechaSuspension;

    /**
     * @ORM\OneToMany(targetEntity="Caso", mappedBy="clienteRel")
     */
    protected $casosClienteRel;

    /**
     * @ORM\OneToMany(targetEntity="Usuario", mappedBy="clienteRel")
     */
    protected $usuariosClienteRel;

    /**
     * @ORM\OneToMany(targetEntity="Error", mappedBy="clienteRel")
     */
    protected $erroresClienteRel;

    /**
     * @ORM\OneToMany(targetEntity="Soporte", mappedBy="clienteRel")
     */
    protected $soportesClienteRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Implementacion", mappedBy="clienteRel")
     */
    protected $implementacionesClienteRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Estudio", mappedBy="clienteRel")
     */
    protected $estudiosClienteRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contacto", mappedBy="clienteRel")
     */
    protected $contactosClienteRel;

    /**
     * @return mixed
     */
    public function getCodigoClientePk()
    {
        return $this->codigoClientePk;
    }

    /**
     * @param mixed $codigoClientePk
     */
    public function setCodigoClientePk($codigoClientePk): void
    {
        $this->codigoClientePk = $codigoClientePk;
    }

    /**
     * @return mixed
     */
    public function getNombreCorto()
    {
        return $this->nombreCorto;
    }

    /**
     * @param mixed $nombreCorto
     */
    public function setNombreCorto($nombreCorto): void
    {
        $this->nombreCorto = $nombreCorto;
    }

    /**
     * @return mixed
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param mixed $logo
     */
    public function setLogo($logo): void
    {
        $this->logo = $logo;
    }

    /**
     * @return mixed
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param mixed $extension
     */
    public function setExtension($extension): void
    {
        $this->extension = $extension;
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
    public function getNit()
    {
        return $this->nit;
    }

    /**
     * @param mixed $nit
     */
    public function setNit($nit): void
    {
        $this->nit = $nit;
    }

    /**
     * @return mixed
     */
    public function getDigitoVerificacion()
    {
        return $this->digitoVerificacion;
    }

    /**
     * @param mixed $digitoVerificacion
     */
    public function setDigitoVerificacion($digitoVerificacion): void
    {
        $this->digitoVerificacion = $digitoVerificacion;
    }

    /**
     * @return mixed
     */
    public function getCasosClienteRel()
    {
        return $this->casosClienteRel;
    }

    /**
     * @param mixed $casosClienteRel
     */
    public function setCasosClienteRel($casosClienteRel): void
    {
        $this->casosClienteRel = $casosClienteRel;
    }

    /**
     * @return mixed
     */
    public function getUsuariosClienteRel()
    {
        return $this->usuariosClienteRel;
    }

    /**
     * @param mixed $usuariosClienteRel
     */
    public function setUsuariosClienteRel($usuariosClienteRel): void
    {
        $this->usuariosClienteRel = $usuariosClienteRel;
    }

    /**
     * @return mixed
     */
    public function getErroresClienteRel()
    {
        return $this->erroresClienteRel;
    }

    /**
     * @param mixed $erroresClienteRel
     */
    public function setErroresClienteRel($erroresClienteRel): void
    {
        $this->erroresClienteRel = $erroresClienteRel;
    }

    /**
     * @return mixed
     */
    public function getSoportesClienteRel()
    {
        return $this->soportesClienteRel;
    }

    /**
     * @param mixed $soportesClienteRel
     */
    public function setSoportesClienteRel($soportesClienteRel): void
    {
        $this->soportesClienteRel = $soportesClienteRel;
    }

    /**
     * @return mixed
     */
    public function getImplementacionesClienteRel()
    {
        return $this->implementacionesClienteRel;
    }

    /**
     * @param mixed $implementacionesClienteRel
     */
    public function setImplementacionesClienteRel($implementacionesClienteRel): void
    {
        $this->implementacionesClienteRel = $implementacionesClienteRel;
    }

    /**
     * @return mixed
     */
    public function getSuscriptor()
    {
        return $this->suscriptor;
    }

    /**
     * @param mixed $suscriptor
     */
    public function setSuscriptor($suscriptor): void
    {
        $this->suscriptor = $suscriptor;
    }

    /**
     * @return mixed
     */
    public function getFacturacionElectronica()
    {
        return $this->facturacionElectronica;
    }

    /**
     * @param mixed $facturacionElectronica
     */
    public function setFacturacionElectronica($facturacionElectronica): void
    {
        $this->facturacionElectronica = $facturacionElectronica;
    }

    /**
     * @return mixed
     */
    public function getSetPruebas()
    {
        return $this->setPruebas;
    }

    /**
     * @param mixed $setPruebas
     */
    public function setSetPruebas($setPruebas): void
    {
        $this->setPruebas = $setPruebas;
    }

    /**
     * @return mixed
     */
    public function getCorreoError()
    {
        return $this->correoError;
    }

    /**
     * @param mixed $correoError
     */
    public function setCorreoError($correoError): void
    {
        $this->correoError = $correoError;
    }

    /**
     * @return mixed
     */
    public function getEmpleador()
    {
        return $this->empleador;
    }

    /**
     * @param mixed $empleador
     */
    public function setEmpleador($empleador): void
    {
        $this->empleador = $empleador;
    }

    /**
     * @return bool
     */
    public function isSetPruebasNomina(): bool
    {
        return $this->setPruebasNomina;
    }

    /**
     * @param bool $setPruebasNomina
     */
    public function setSetPruebasNomina(bool $setPruebasNomina): void
    {
        $this->setPruebasNomina = $setPruebasNomina;
    }

    /**
     * @return mixed
     */
    public function getCodigoSetPruebas()
    {
        return $this->codigoSetPruebas;
    }

    /**
     * @param mixed $codigoSetPruebas
     */
    public function setCodigoSetPruebas($codigoSetPruebas): void
    {
        $this->codigoSetPruebas = $codigoSetPruebas;
    }

    /**
     * @return mixed
     */
    public function getCodigoSetPruebasNominas()
    {
        return $this->codigoSetPruebasNominas;
    }

    /**
     * @param mixed $codigoSetPruebasNominas
     */
    public function setCodigoSetPruebasNominas($codigoSetPruebasNominas): void
    {
        $this->codigoSetPruebasNominas = $codigoSetPruebasNominas;
    }

    /**
     * @return mixed
     */
    public function getNombreExtendido()
    {
        return $this->nombreExtendido;
    }

    /**
     * @param mixed $nombreExtendido
     */
    public function setNombreExtendido($nombreExtendido): void
    {
        $this->nombreExtendido = $nombreExtendido;
    }

    /**
     * @return bool
     */
    public function isNominaElectronica(): bool
    {
        return $this->nominaElectronica;
    }

    /**
     * @param bool $nominaElectronica
     */
    public function setNominaElectronica(bool $nominaElectronica): void
    {
        $this->nominaElectronica = $nominaElectronica;
    }

    /**
     * @return bool
     */
    public function isServicioSoporte(): bool
    {
        return $this->servicioSoporte;
    }

    /**
     * @param bool $servicioSoporte
     */
    public function setServicioSoporte(bool $servicioSoporte): void
    {
        $this->servicioSoporte = $servicioSoporte;
    }

    /**
     * @return mixed
     */
    public function getFechaSuspension()
    {
        return $this->fechaSuspension;
    }

    /**
     * @param mixed $fechaSuspension
     */
    public function setFechaSuspension($fechaSuspension): void
    {
        $this->fechaSuspension = $fechaSuspension;
    }

    /**
     * @return mixed
     */
    public function getEstudiosClienteRel()
    {
        return $this->estudiosClienteRel;
    }

    /**
     * @param mixed $estudiosClienteRel
     */
    public function setEstudiosClienteRel($estudiosClienteRel): void
    {
        $this->estudiosClienteRel = $estudiosClienteRel;
    }



}
