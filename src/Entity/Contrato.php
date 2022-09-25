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
     * @ORM\Column(name="vr_arrendamiento", type="float", options={"default":0})
     */
    private $vrArrendamiento = 0.0;

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


}
