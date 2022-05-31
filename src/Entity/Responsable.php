<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="responsable")
 * @ORM\Entity(repositoryClass="App\Repository\ResponsableRepository")
 */
class Responsable
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_responsable_pk", type="string", length=20)
     */
    private $codigoResponsablePk;

    /**
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ImplementacionDetalle", mappedBy="responsableRel")
     */
    protected $implementacionesDetallesResponsableRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tema", mappedBy="responsableRel")
     */
    protected $temasResponsableRel;

    /**
     * @return mixed
     */
    public function getCodigoResponsablePk()
    {
        return $this->codigoResponsablePk;
    }

    /**
     * @param mixed $codigoResponsablePk
     */
    public function setCodigoResponsablePk($codigoResponsablePk): void
    {
        $this->codigoResponsablePk = $codigoResponsablePk;
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
    public function getImplementacionesDetallesResponsableRel()
    {
        return $this->implementacionesDetallesResponsableRel;
    }

    /**
     * @param mixed $implementacionesDetallesResponsableRel
     */
    public function setImplementacionesDetallesResponsableRel($implementacionesDetallesResponsableRel): void
    {
        $this->implementacionesDetallesResponsableRel = $implementacionesDetallesResponsableRel;
    }

    /**
     * @return mixed
     */
    public function getTemasResponsableRel()
    {
        return $this->temasResponsableRel;
    }

    /**
     * @param mixed $temasResponsableRel
     */
    public function setTemasResponsableRel($temasResponsableRel): void
    {
        $this->temasResponsableRel = $temasResponsableRel;
    }



}
