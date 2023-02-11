<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="contrato")
 * @ORM\Entity(repositoryClass="App\Repository\ContratoRepository")
 */
class Contrato
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_contrato_pk", type="integer")
     */
    private $codigoContratoPk;

    /**
     * @ORM\Column(name="codigo_cliente_fk", type="integer", nullable=true)
     */
    private $codigoClienteFk;

    /**
     * @ORM\Column(name="codigo_contacto_representante_fk", type="integer", nullable=true)
     */
    private $codigoContactoRepresentanteFk;

    /**
     * @ORM\Column(name="codigo_contrato_tipo_fk", type="string", length=3, nullable=true)
     */
    private $codigoContratoTipoFk;

    /**
     * @ORM\Column(name="codigo_modalidad_fk", type="string", length=20, nullable=true)
     */
    private $codigoModalidadFk;

    /**
     * @ORM\Column(name="fecha_inicio", type="date", nullable=true)
     */
    private $fechaInicio;

    /**
     * @ORM\Column(name="numero", type="string", length=50, nullable=true)
     */
    private $numero;

    /**
     * @ORM\Column(name="numero_oferta", type="string", length=50, nullable=true)
     */
    private $numeroOferta;

    /**
     * @ORM\Column(name="vr_implementacion", type="float", options={"default":0})
     */
    private $vrImplementacion = 0.0;

    /**
     * @ORM\Column(name="vr_arrendamiento", type="float", options={"default":0})
     */
    private $vrArrendamiento = 0.0;

    /**
     * @ORM\Column(name="vr_electronico", type="float", options={"default":0})
     */
    private $vrElectronico = 0.0;

    /**
     * @ORM\Column(name="vr_electronico_unidad", type="float", options={"default":0})
     */
    private $vrElectronicoUnidad = 0.0;

    /**
     * @ORM\Column(name="numero_electronicos", type="integer", options={"default":0})
     */
    private $numeroElectronicos = 0;

    /**
     * @ORM\Column(name="numero_empleados", type="integer", options={"default":0})
     */
    private $numeroEmpleados = 0;

    /**
     * @ORM\Column(name="numero_usuarios", type="integer", options={"default":0})
     */
    private $numeroUsuarios = 0;

    /**
     * @ORM\Column(name="numero_guias", type="integer", options={"default":0})
     */
    private $numeroGuias = 0;

    /**
     * @ORM\Column(name="objeto_implementacion", type="string", length=500, nullable=true)
     */
    private $objetoImplementacion;

    /**
     * @ORM\Column(name="implementacion", type="boolean", nullable=true, options={"default" : false})
     */
    private $implementacion = false;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cliente", inversedBy="contratosClienteRel")
     * @ORM\JoinColumn(name="codigo_cliente_fk", referencedColumnName="codigo_cliente_pk")
     */
    private $clienteRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Contacto", inversedBy="contratosContactoRepresentanteRel")
     * @ORM\JoinColumn(name="codigo_contacto_representante_fk", referencedColumnName="codigo_contacto_pk")
     */
    private $contactoRepresentanteRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ContratoTipo", inversedBy="contratosContratoTipoRel")
     * @ORM\JoinColumn(name="codigo_contrato_tipo_fk", referencedColumnName="codigo_contrato_tipo_pk")
     */
    private $contratoTipoRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Modalidad", inversedBy="contratosModalidadRel")
     * @ORM\JoinColumn(name="codigo_modalidad_fk", referencedColumnName="codigo_modalidad_pk")
     */
    private $modalidadRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ContratoModulo", mappedBy="contratoRel")
     */
    protected $contratosModulosContratoRel;

    /**
     * @return mixed
     */
    public function getCodigoContratoPk()
    {
        return $this->codigoContratoPk;
    }

    /**
     * @param mixed $codigoContratoPk
     */
    public function setCodigoContratoPk($codigoContratoPk): void
    {
        $this->codigoContratoPk = $codigoContratoPk;
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
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     */
    public function setNumero($numero): void
    {
        $this->numero = $numero;
    }

    /**
     * @return mixed
     */
    public function getNumeroOferta()
    {
        return $this->numeroOferta;
    }

    /**
     * @param mixed $numeroOferta
     */
    public function setNumeroOferta($numeroOferta): void
    {
        $this->numeroOferta = $numeroOferta;
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
    public function getCodigoContactoRepresentanteFk()
    {
        return $this->codigoContactoRepresentanteFk;
    }

    /**
     * @param mixed $codigoContactoRepresentanteFk
     */
    public function setCodigoContactoRepresentanteFk($codigoContactoRepresentanteFk): void
    {
        $this->codigoContactoRepresentanteFk = $codigoContactoRepresentanteFk;
    }

    /**
     * @return mixed
     */
    public function getContactoRepresentanteRel()
    {
        return $this->contactoRepresentanteRel;
    }

    /**
     * @param mixed $contactoRepresentanteRel
     */
    public function setContactoRepresentanteRel($contactoRepresentanteRel): void
    {
        $this->contactoRepresentanteRel = $contactoRepresentanteRel;
    }

    /**
     * @return float
     */
    public function getVrArrendamiento(): float
    {
        return $this->vrArrendamiento;
    }

    /**
     * @param float $vrArrendamiento
     */
    public function setVrArrendamiento(float $vrArrendamiento): void
    {
        $this->vrArrendamiento = $vrArrendamiento;
    }

    /**
     * @return int
     */
    public function getNumeroEmpleados(): int
    {
        return $this->numeroEmpleados;
    }

    /**
     * @param int $numeroEmpleados
     */
    public function setNumeroEmpleados(int $numeroEmpleados): void
    {
        $this->numeroEmpleados = $numeroEmpleados;
    }

    /**
     * @return int
     */
    public function getNumeroUsuarios(): int
    {
        return $this->numeroUsuarios;
    }

    /**
     * @param int $numeroUsuarios
     */
    public function setNumeroUsuarios(int $numeroUsuarios): void
    {
        $this->numeroUsuarios = $numeroUsuarios;
    }

    /**
     * @return int
     */
    public function getNumeroGuias(): int
    {
        return $this->numeroGuias;
    }

    /**
     * @param int $numeroGuias
     */
    public function setNumeroGuias(int $numeroGuias): void
    {
        $this->numeroGuias = $numeroGuias;
    }

    /**
     * @return mixed
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * @param mixed $fechaInicio
     */
    public function setFechaInicio($fechaInicio): void
    {
        $this->fechaInicio = $fechaInicio;
    }

    /**
     * @return float
     */
    public function getVrElectronico(): float
    {
        return $this->vrElectronico;
    }

    /**
     * @param float $vrElectronico
     */
    public function setVrElectronico(float $vrElectronico): void
    {
        $this->vrElectronico = $vrElectronico;
    }

    /**
     * @return int
     */
    public function getNumeroElectronicos(): int
    {
        return $this->numeroElectronicos;
    }

    /**
     * @param int $numeroElectronicos
     */
    public function setNumeroElectronicos(int $numeroElectronicos): void
    {
        $this->numeroElectronicos = $numeroElectronicos;
    }

    /**
     * @return float
     */
    public function getVrElectronicoUnidad(): float
    {
        return $this->vrElectronicoUnidad;
    }

    /**
     * @param float $vrElectronicoUnidad
     */
    public function setVrElectronicoUnidad(float $vrElectronicoUnidad): void
    {
        $this->vrElectronicoUnidad = $vrElectronicoUnidad;
    }

    /**
     * @return float
     */
    public function getVrImplementacion(): float
    {
        return $this->vrImplementacion;
    }

    /**
     * @param float $vrImplementacion
     */
    public function setVrImplementacion(float $vrImplementacion): void
    {
        $this->vrImplementacion = $vrImplementacion;
    }

    /**
     * @return mixed
     */
    public function getObjetoImplementacion()
    {
        return $this->objetoImplementacion;
    }

    /**
     * @param mixed $objetoImplementacion
     */
    public function setObjetoImplementacion($objetoImplementacion): void
    {
        $this->objetoImplementacion = $objetoImplementacion;
    }

    /**
     * @return bool
     */
    public function isImplementacion(): bool
    {
        return $this->implementacion;
    }

    /**
     * @param bool $implementacion
     */
    public function setImplementacion(bool $implementacion): void
    {
        $this->implementacion = $implementacion;
    }

    /**
     * @return mixed
     */
    public function getCodigoContratoTipoFk()
    {
        return $this->codigoContratoTipoFk;
    }

    /**
     * @param mixed $codigoContratoTipoFk
     */
    public function setCodigoContratoTipoFk($codigoContratoTipoFk): void
    {
        $this->codigoContratoTipoFk = $codigoContratoTipoFk;
    }

    /**
     * @return mixed
     */
    public function getContratoTipoRel()
    {
        return $this->contratoTipoRel;
    }

    /**
     * @param mixed $contratoTipoRel
     */
    public function setContratoTipoRel($contratoTipoRel): void
    {
        $this->contratoTipoRel = $contratoTipoRel;
    }

    /**
     * @return mixed
     */
    public function getContratosModulosContratoRel()
    {
        return $this->contratosModulosContratoRel;
    }

    /**
     * @param mixed $contratosModulosContratoRel
     */
    public function setContratosModulosContratoRel($contratosModulosContratoRel): void
    {
        $this->contratosModulosContratoRel = $contratosModulosContratoRel;
    }

    /**
     * @return mixed
     */
    public function getCodigoModalidadFk()
    {
        return $this->codigoModalidadFk;
    }

    /**
     * @param mixed $codigoModalidadFk
     */
    public function setCodigoModalidadFk($codigoModalidadFk): void
    {
        $this->codigoModalidadFk = $codigoModalidadFk;
    }

    /**
     * @return mixed
     */
    public function getModalidadRel()
    {
        return $this->modalidadRel;
    }

    /**
     * @param mixed $modalidadRel
     */
    public function setModalidadRel($modalidadRel): void
    {
        $this->modalidadRel = $modalidadRel;
    }


}
