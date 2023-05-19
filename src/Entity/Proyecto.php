<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="proyecto")
 * @ORM\Entity(repositoryClass="App\Repository\ProyectoRepository")
 */
class Proyecto
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_proyecto_pk", type="integer")
     */
    private $codigoProyectoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=100, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="Tarea", mappedBy="proyectoRel")
     */
    protected $tareasProyectoRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Epica", mappedBy="proyectoRel")
     */
    protected $epicasProyectoRel;

    /**
     * @return mixed
     */
    public function getCodigoProyectoPk()
    {
        return $this->codigoProyectoPk;
    }

    /**
     * @param mixed $codigoProyectoPk
     */
    public function setCodigoProyectoPk($codigoProyectoPk): void
    {
        $this->codigoProyectoPk = $codigoProyectoPk;
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
    public function getTareasProyectoRel()
    {
        return $this->tareasProyectoRel;
    }

    /**
     * @param mixed $tareasProyectoRel
     */
    public function setTareasProyectoRel($tareasProyectoRel): void
    {
        $this->tareasProyectoRel = $tareasProyectoRel;
    }

    /**
     * @return mixed
     */
    public function getEpicasProyectoRel()
    {
        return $this->epicasProyectoRel;
    }

    /**
     * @param mixed $epicasProyectoRel
     */
    public function setEpicasProyectoRel($epicasProyectoRel): void
    {
        $this->epicasProyectoRel = $epicasProyectoRel;
    }


}
