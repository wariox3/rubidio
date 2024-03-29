<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="modulo")
 * @ORM\Entity(repositoryClass="App\Repository\ModuloRepository")
 */
class Modulo
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_modulo_pk", type="string", length=20)
     */
    private $codigoModuloPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="orden", type="integer", options={"default" : 0})
     */
    private $orden = 0;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tema", mappedBy="moduloRel")
     */
    protected $temasModuloRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Recurso", mappedBy="moduloRel")
     */
    protected $recursosModuloRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Funcionalidad", mappedBy="moduloRel")
     */
    protected $funcionalidadesModuloRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Requisito", mappedBy="requisitoRel")
     */
    protected $requisitosModuloRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EstudioDetalle", mappedBy="moduloRel")
     */
    protected $estudiosDetallesModuloRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Caso", mappedBy="moduloRel")
     */
    protected $casosModuloRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ImplementacionDetalle", mappedBy="moduloRel")
     */
    protected $implementacionesDetallesModuloRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ContratoModulo", mappedBy="moduloRel")
     */
    protected $contratosModulosModuloRel;

    /**
     * @return mixed
     */
    public function getCodigoModuloPk()
    {
        return $this->codigoModuloPk;
    }

    /**
     * @param mixed $codigoModuloPk
     */
    public function setCodigoModuloPk($codigoModuloPk): void
    {
        $this->codigoModuloPk = $codigoModuloPk;
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
    public function getTemasModuloRel()
    {
        return $this->temasModuloRel;
    }

    /**
     * @param mixed $temasModuloRel
     */
    public function setTemasModuloRel($temasModuloRel): void
    {
        $this->temasModuloRel = $temasModuloRel;
    }

    /**
     * @return mixed
     */
    public function getRecursosModuloRel()
    {
        return $this->recursosModuloRel;
    }

    /**
     * @param mixed $recursosModuloRel
     */
    public function setRecursosModuloRel($recursosModuloRel): void
    {
        $this->recursosModuloRel = $recursosModuloRel;
    }

    /**
     * @return mixed
     */
    public function getFuncionalidadesModuloRel()
    {
        return $this->funcionalidadesModuloRel;
    }

    /**
     * @param mixed $funcionalidadesModuloRel
     */
    public function setFuncionalidadesModuloRel($funcionalidadesModuloRel): void
    {
        $this->funcionalidadesModuloRel = $funcionalidadesModuloRel;
    }

    /**
     * @return mixed
     */
    public function getRequisitosModuloRel()
    {
        return $this->requisitosModuloRel;
    }

    /**
     * @param mixed $requisitosModuloRel
     */
    public function setRequisitosModuloRel($requisitosModuloRel): void
    {
        $this->requisitosModuloRel = $requisitosModuloRel;
    }

    /**
     * @return mixed
     */
    public function getEstudiosDetallesModuloRel()
    {
        return $this->estudiosDetallesModuloRel;
    }

    /**
     * @param mixed $estudiosDetallesModuloRel
     */
    public function setEstudiosDetallesModuloRel($estudiosDetallesModuloRel): void
    {
        $this->estudiosDetallesModuloRel = $estudiosDetallesModuloRel;
    }

    /**
     * @return mixed
     */
    public function getCasosModuloRel()
    {
        return $this->casosModuloRel;
    }

    /**
     * @param mixed $casosModuloRel
     */
    public function setCasosModuloRel($casosModuloRel): void
    {
        $this->casosModuloRel = $casosModuloRel;
    }

    /**
     * @return mixed
     */
    public function getImplementacionesDetallesModuloRel()
    {
        return $this->implementacionesDetallesModuloRel;
    }

    /**
     * @param mixed $implementacionesDetallesModuloRel
     */
    public function setImplementacionesDetallesModuloRel($implementacionesDetallesModuloRel): void
    {
        $this->implementacionesDetallesModuloRel = $implementacionesDetallesModuloRel;
    }

    /**
     * @return int
     */
    public function getOrden(): int
    {
        return $this->orden;
    }

    /**
     * @param int $orden
     */
    public function setOrden(int $orden): void
    {
        $this->orden = $orden;
    }

    /**
     * @return mixed
     */
    public function getContratosModulosModuloRel()
    {
        return $this->contratosModulosModuloRel;
    }

    /**
     * @param mixed $contratosModulosModuloRel
     */
    public function setContratosModulosModuloRel($contratosModulosModuloRel): void
    {
        $this->contratosModulosModuloRel = $contratosModulosModuloRel;
    }


}
