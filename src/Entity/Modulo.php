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
     * @ORM\OneToMany(targetEntity="App\Entity\Tema", mappedBy="moduloRel")
     */
    protected $temasModuloRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Soporte", mappedBy="moduloRel")
     */
    protected $soportesModuloRel;

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
    public function getSoportesModuloRel()
    {
        return $this->soportesModuloRel;
    }

    /**
     * @param mixed $soportesModuloRel
     */
    public function setSoportesModuloRel($soportesModuloRel): void
    {
        $this->soportesModuloRel = $soportesModuloRel;
    }



}
