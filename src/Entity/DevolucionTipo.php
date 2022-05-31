<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="devolucion_tipo")
 * @ORM\Entity(repositoryClass="App\Repository\DevolucionTipoRepository")
 */
class DevolucionTipo
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_devolucion_tipo_pk", type="integer")
     */
    private $codigoDevolucionTipoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=100, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="Devolucion", mappedBy="devolucionTipoRel")
     */
    protected $devolucionesDevolucionTipoRel;

    /**
     * @return mixed
     */
    public function getCodigoDevolucionTipoPk()
    {
        return $this->codigoDevolucionTipoPk;
    }

    /**
     * @param mixed $codigoDevolucionTipoPk
     */
    public function setCodigoDevolucionTipoPk($codigoDevolucionTipoPk): void
    {
        $this->codigoDevolucionTipoPk = $codigoDevolucionTipoPk;
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
    public function getDevolucionesDevolucionTipoRel()
    {
        return $this->devolucionesDevolucionTipoRel;
    }

    /**
     * @param mixed $devolucionesDevolucionTipoRel
     */
    public function setDevolucionesDevolucionTipoRel($devolucionesDevolucionTipoRel): void
    {
        $this->devolucionesDevolucionTipoRel = $devolucionesDevolucionTipoRel;
    }




}
