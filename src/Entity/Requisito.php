<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="requisito")
 * @ORM\Entity(repositoryClass="App\Repository\RequisitoRepository")
 */
class Requisito
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_requisito_pk", type="integer")
     */
    private $codigoRequisitoPk;

    /**
     * @ORM\Column(name="codigo_modulo_fk", type="string", length=20, nullable=true)
     */
    private $codigoModuloFk;

    /**
     * @ORM\Column(name="nombre", type="string", length=500, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Modulo", inversedBy="requisitosModuloRel")
     * @ORM\JoinColumn(name="codigo_modulo_fk", referencedColumnName="codigo_modulo_pk")
     */
    private $requisitoRel;

    /**
     * @return mixed
     */
    public function getCodigoRequisitoPk()
    {
        return $this->codigoRequisitoPk;
    }

    /**
     * @param mixed $codigoRequisitoPk
     */
    public function setCodigoRequisitoPk($codigoRequisitoPk): void
    {
        $this->codigoRequisitoPk = $codigoRequisitoPk;
    }

    /**
     * @return mixed
     */
    public function getCodigoModuloFk()
    {
        return $this->codigoModuloFk;
    }

    /**
     * @param mixed $codigoModuloFk
     */
    public function setCodigoModuloFk($codigoModuloFk): void
    {
        $this->codigoModuloFk = $codigoModuloFk;
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
    public function getRequisitoRel()
    {
        return $this->requisitoRel;
    }

    /**
     * @param mixed $requisitoRel
     */
    public function setRequisitoRel($requisitoRel): void
    {
        $this->requisitoRel = $requisitoRel;
    }


}
