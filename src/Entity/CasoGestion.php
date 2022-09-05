<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="caso_gestion")
 * @ORM\Entity(repositoryClass="App\Repository\CasoGestionRepository")
 */
class CasoGestion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_caso_gestion_pk", type="integer")
     */
    private $codigoCasoGestionPk;

    /**
     * @ORM\Column(name="codigo_caso_fk", type="integer", nullable=true)
     */
    private $codigoCasoFk;

    /**
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="fecha_gestion", type="datetime", nullable=true)
     */
    private $fechaGestion;

    /**
     * @ORM\Column(name="comentario", type="string", length=1000, nullable=true)
     */
    private $comentario;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Caso", inversedBy="casosGestionesCasoRel")
     * @ORM\JoinColumn(name="codigo_caso_fk", referencedColumnName="codigo_caso_pk")
     */
    private $casoRel;

    /**
     * @return mixed
     */
    public function getCodigoCasoGestionPk()
    {
        return $this->codigoCasoGestionPk;
    }

    /**
     * @param mixed $codigoCasoGestionPk
     */
    public function setCodigoCasoGestionPk($codigoCasoGestionPk): void
    {
        $this->codigoCasoGestionPk = $codigoCasoGestionPk;
    }

    /**
     * @return mixed
     */
    public function getCodigoCasoFk()
    {
        return $this->codigoCasoFk;
    }

    /**
     * @param mixed $codigoCasoFk
     */
    public function setCodigoCasoFk($codigoCasoFk): void
    {
        $this->codigoCasoFk = $codigoCasoFk;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha): void
    {
        $this->fecha = $fecha;
    }

    /**
     * @return mixed
     */
    public function getFechaGestion()
    {
        return $this->fechaGestion;
    }

    /**
     * @param mixed $fechaGestion
     */
    public function setFechaGestion($fechaGestion): void
    {
        $this->fechaGestion = $fechaGestion;
    }

    /**
     * @return mixed
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * @param mixed $comentario
     */
    public function setComentario($comentario): void
    {
        $this->comentario = $comentario;
    }

    /**
     * @return mixed
     */
    public function getCasoRel()
    {
        return $this->casoRel;
    }

    /**
     * @param mixed $casoRel
     */
    public function setCasoRel($casoRel): void
    {
        $this->casoRel = $casoRel;
    }



}