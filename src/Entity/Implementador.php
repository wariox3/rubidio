<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="implementador")
 * @ORM\Entity(repositoryClass="App\Repository\ImplementadorRepository")
 */
class Implementador
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_implementador_pk", type="integer")
     */
    private $codigoImplementadorPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=200, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="telefono", type="string", length=100, nullable=true)
     */
    private $telefono;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Implementacion", mappedBy="implementadorRel")
     */
    protected $implementacionesImplementadorRel;

    /**
     * @return mixed
     */
    public function getCodigoImplementadorPk()
    {
        return $this->codigoImplementadorPk;
    }

    /**
     * @param mixed $codigoImplementadorPk
     */
    public function setCodigoImplementadorPk($codigoImplementadorPk): void
    {
        $this->codigoImplementadorPk = $codigoImplementadorPk;
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
    public function getImplementacionesImplementadorRel()
    {
        return $this->implementacionesImplementadorRel;
    }

    /**
     * @param mixed $implementacionesImplementadorRel
     */
    public function setImplementacionesImplementadorRel($implementacionesImplementadorRel): void
    {
        $this->implementacionesImplementadorRel = $implementacionesImplementadorRel;
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



}
