<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="accion")
 * @ORM\Entity(repositoryClass="App\Repository\AccionRepository")
 */
class Accion
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_accion_pk", type="string", length=20)
     */
    private $codigoAccionPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ImplementacionDetalle", mappedBy="accionRel")
     */
    protected $implementacionesDetallesAccionRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tema", mappedBy="accionRel")
     */
    protected $temasAccionRel;

    /**
     * @return mixed
     */
    public function getCodigoAccionPk()
    {
        return $this->codigoAccionPk;
    }

    /**
     * @param mixed $codigoAccionPk
     */
    public function setCodigoAccionPk($codigoAccionPk): void
    {
        $this->codigoAccionPk = $codigoAccionPk;
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
    public function getImplementacionesDetallesAccionRel()
    {
        return $this->implementacionesDetallesAccionRel;
    }

    /**
     * @param mixed $implementacionesDetallesAccionRel
     */
    public function setImplementacionesDetallesAccionRel($implementacionesDetallesAccionRel): void
    {
        $this->implementacionesDetallesAccionRel = $implementacionesDetallesAccionRel;
    }

    /**
     * @return mixed
     */
    public function getTemasAccionRel()
    {
        return $this->temasAccionRel;
    }

    /**
     * @param mixed $temasAccionRel
     */
    public function setTemasAccionRel($temasAccionRel): void
    {
        $this->temasAccionRel = $temasAccionRel;
    }



}
