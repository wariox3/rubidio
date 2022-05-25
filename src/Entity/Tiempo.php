<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tiempo")
 * @ORM\Entity(repositoryClass="App\Repository\TiempoRepository")
 */
class Tiempo
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_tiempo_pk", type="integer")
     */
    private $codigoTiempoPk;

    /**
     * @ORM\Column(name="codigo_tarea_fk", type="integer", nullable=true)
     */
    private $codigoTareaFk;

    /**
     * @ORM\Column(name="inicio", type="datetime", nullable=true)
     */
    private $inicio;

    /**
     * @ORM\Column(name="fin", type="datetime", nullable=true)
     */
    private $fin;

    /**
     * @ORM\Column(name="hora", type="float", options={"default" : 0})
     */
    private $hora = 0;

    /**
     * @ORM\Column(name="minuto", type="float", options={"default" : 0})
     */
    private $minuto = 0;

    /**
     * @ORM\Column(name="estado_terminado", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoTerminado = false;

    /**
     * @ORM\ManyToOne(targetEntity="Tarea", inversedBy="tiemposTareaRel")
     * @ORM\JoinColumn(name="codigo_tarea_fk", referencedColumnName="codigo_tarea_pk")
     */
    private $tareaRel;

    /**
     * @return mixed
     */
    public function getCodigoTiempoPk()
    {
        return $this->codigoTiempoPk;
    }

    /**
     * @param mixed $codigoTiempoPk
     */
    public function setCodigoTiempoPk($codigoTiempoPk): void
    {
        $this->codigoTiempoPk = $codigoTiempoPk;
    }

    /**
     * @return mixed
     */
    public function getCodigoTareaFk()
    {
        return $this->codigoTareaFk;
    }

    /**
     * @param mixed $codigoTareaFk
     */
    public function setCodigoTareaFk($codigoTareaFk): void
    {
        $this->codigoTareaFk = $codigoTareaFk;
    }

    /**
     * @return mixed
     */
    public function getInicio()
    {
        return $this->inicio;
    }

    /**
     * @param mixed $inicio
     */
    public function setInicio($inicio): void
    {
        $this->inicio = $inicio;
    }

    /**
     * @return mixed
     */
    public function getFin()
    {
        return $this->fin;
    }

    /**
     * @param mixed $fin
     */
    public function setFin($fin): void
    {
        $this->fin = $fin;
    }

    /**
     * @return mixed
     */
    public function getTareaRel()
    {
        return $this->tareaRel;
    }

    /**
     * @param mixed $tareaRel
     */
    public function setTareaRel($tareaRel): void
    {
        $this->tareaRel = $tareaRel;
    }

    /**
     * @return mixed
     */
    public function getEstadoTerminado()
    {
        return $this->estadoTerminado;
    }

    /**
     * @param mixed $estadoTerminado
     */
    public function setEstadoTerminado($estadoTerminado): void
    {
        $this->estadoTerminado = $estadoTerminado;
    }

    /**
     * @return mixed
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * @param mixed $hora
     */
    public function setHora($hora): void
    {
        $this->hora = $hora;
    }

    /**
     * @return mixed
     */
    public function getMinuto()
    {
        return $this->minuto;
    }

    /**
     * @param mixed $minuto
     */
    public function setMinuto($minuto): void
    {
        $this->minuto = $minuto;
    }



}
