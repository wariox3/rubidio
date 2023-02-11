<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContratoModuloRepository")
 */
class ContratoModulo
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_contrato_modulo_pk", type="integer")
     */
    private $codigoContratoModuloPk;

    /**
     * @ORM\Column(name="codigo_contrato_fk", type="integer", nullable=true)
     */
    private $codigoContratoFk;

    /**
     * @ORM\Column(name="codigo_modulo_fk", type="string", length=20, nullable=true)
     */
    private $codigoModuloFk;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Contrato", inversedBy="contratosModulosContratoRel")
     * @ORM\JoinColumn(name="codigo_contrato_fk", referencedColumnName="codigo_contrato_pk")
     */
    private $contratoRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Modulo", inversedBy="contratosModulosModuloRel")
     * @ORM\JoinColumn(name="codigo_modulo_fk", referencedColumnName="codigo_modulo_pk")
     */
    private $moduloRel;

    /**
     * @return mixed
     */
    public function getCodigoContratoModuloPk()
    {
        return $this->codigoContratoModuloPk;
    }

    /**
     * @param mixed $codigoContratoModuloPk
     */
    public function setCodigoContratoModuloPk($codigoContratoModuloPk): void
    {
        $this->codigoContratoModuloPk = $codigoContratoModuloPk;
    }

    /**
     * @return mixed
     */
    public function getCodigoContratoFk()
    {
        return $this->codigoContratoFk;
    }

    /**
     * @param mixed $codigoContratoFk
     */
    public function setCodigoContratoFk($codigoContratoFk): void
    {
        $this->codigoContratoFk = $codigoContratoFk;
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
    public function getContratoRel()
    {
        return $this->contratoRel;
    }

    /**
     * @param mixed $contratoRel
     */
    public function setContratoRel($contratoRel): void
    {
        $this->contratoRel = $contratoRel;
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


}
