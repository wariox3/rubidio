<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModalidadRepository")
 */
class Modalidad
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_modalidad_pk", type="string", length=20)
     */
    private $codigoModalidadPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contrato", mappedBy="modalidadRel")
     */
    protected $contratosModalidadRel;

    /**
     * @return mixed
     */
    public function getCodigoModalidadPk()
    {
        return $this->codigoModalidadPk;
    }

    /**
     * @param mixed $codigoModalidadPk
     */
    public function setCodigoModalidadPk($codigoModalidadPk): void
    {
        $this->codigoModalidadPk = $codigoModalidadPk;
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
    public function getContratosModalidadRel()
    {
        return $this->contratosModalidadRel;
    }

    /**
     * @param mixed $contratosModalidadRel
     */
    public function setContratosModalidadRel($contratosModalidadRel): void
    {
        $this->contratosModalidadRel = $contratosModalidadRel;
    }

}
