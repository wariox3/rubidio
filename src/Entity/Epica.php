<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="proyecto_epica")
 * @ORM\Entity(repositoryClass="App\Repository\EpicaRepository")
 */
class Epica
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_epica_pk", type="integer")
     */
    private $codigoEpicaPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=100, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="codigo_proyecto_fk", type="integer", nullable=true)
     */
    private $codigoProyectoFk;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Proyecto", inversedBy="epicasProyectoRel")
     * @ORM\JoinColumn(name="codigo_proyecto_fk", referencedColumnName="codigo_proyecto_pk")
     */
    private $proyectoRel;

    /**
     * @return mixed
     */
    public function getCodigoEpicaPk()
    {
        return $this->codigoEpicaPk;
    }

    /**
     * @param mixed $codigoEpicaPk
     */
    public function setCodigoEpicaPk($codigoEpicaPk): void
    {
        $this->codigoEpicaPk = $codigoEpicaPk;
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
    public function getCodigoProyectoFk()
    {
        return $this->codigoProyectoFk;
    }

    /**
     * @param mixed $codigoProyectoFk
     */
    public function setCodigoProyectoFk($codigoProyectoFk): void
    {
        $this->codigoProyectoFk = $codigoProyectoFk;
    }

    /**
     * @return mixed
     */
    public function getProyectoRel()
    {
        return $this->proyectoRel;
    }

    /**
     * @param mixed $proyectoRel
     */
    public function setProyectoRel($proyectoRel): void
    {
        $this->proyectoRel = $proyectoRel;
    }


}
