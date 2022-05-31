<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="prioridad")
 * @ORM\Entity(repositoryClass="App\Repository\PrioridadRepository")
 */
class Prioridad
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_prioridad_pk", type="string", length=20)
     */
    private $codigoPrioridadPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="orden", type="integer", nullable=true)
     */
    private $orden = 0;

    /**
     * @ORM\OneToMany(targetEntity="Tarea", mappedBy="prioridadRel")
     */
    protected $tareasPrioridadRel;

    /**
     * @ORM\OneToMany(targetEntity="Caso", mappedBy="prioridadRel")
     */
    protected $casosPrioridadRel;

    /**
     * @return mixed
     */
    public function getCodigoPrioridadPk()
    {
        return $this->codigoPrioridadPk;
    }

    /**
     * @param mixed $codigoPrioridadPk
     */
    public function setCodigoPrioridadPk($codigoPrioridadPk): void
    {
        $this->codigoPrioridadPk = $codigoPrioridadPk;
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
    public function getTareasPrioridadRel()
    {
        return $this->tareasPrioridadRel;
    }

    /**
     * @param mixed $tareasPrioridadRel
     */
    public function setTareasPrioridadRel($tareasPrioridadRel): void
    {
        $this->tareasPrioridadRel = $tareasPrioridadRel;
    }

    /**
     * @return mixed
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * @param mixed $orden
     */
    public function setOrden($orden): void
    {
        $this->orden = $orden;
    }

    /**
     * @return mixed
     */
    public function getCasosPrioridadRel()
    {
        return $this->casosPrioridadRel;
    }

    /**
     * @param mixed $casosPrioridadRel
     */
    public function setCasosPrioridadRel($casosPrioridadRel): void
    {
        $this->casosPrioridadRel = $casosPrioridadRel;
    }



}
