<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="caso_respuesta")
 * @ORM\Entity(repositoryClass="App\Repository\CasoRespuestaRepository")
 */
class CasoRespuesta
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_caso_respuesta_pk", type="integer")
     */
    private $codigoCasoRespuestaPk;

    /**
     * @ORM\Column(name="codigo_caso_fk", type="integer", nullable=true)
     */
    private $codigoCasoFk;

    /**
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="comentario", type="string", length=1000, nullable=true)
     */
    private $comentario;

    /**
     * @ORM\Column(name="cliente", type="boolean", options={"default" : false})
     */
    private $cliente = false;

    /**
     * @ORM\Column(name="codigo_usuario_fk", type="string")
     */
    private $codigoUsuarioFk;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario", inversedBy="casosRespuestaUsuarioRel")
     * @ORM\JoinColumn(name="codigo_usuario_fk", referencedColumnName="codigo_usuario_pk")
     */
    private $usuarioRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Caso", inversedBy="casosRespuestasCasoRel")
     * @ORM\JoinColumn(name="codigo_caso_fk", referencedColumnName="codigo_caso_pk")
     */
    private $casoRel;

    /**
     * @return mixed
     */
    public function getCodigoCasoRespuestaPk()
    {
        return $this->codigoCasoRespuestaPk;
    }

    /**
     * @param mixed $codigoCasoRespuestaPk
     */
    public function setCodigoCasoRespuestaPk($codigoCasoRespuestaPk): void
    {
        $this->codigoCasoRespuestaPk = $codigoCasoRespuestaPk;
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

    /**
     * @return mixed
     */
    public function getCodigoUsuarioFk()
    {
        return $this->codigoUsuarioFk;
    }

    /**
     * @param mixed $codigoUsuarioFk
     */
    public function setCodigoUsuarioFk($codigoUsuarioFk): void
    {
        $this->codigoUsuarioFk = $codigoUsuarioFk;
    }

    /**
     * @return mixed
     */
    public function getUsuarioRel()
    {
        return $this->usuarioRel;
    }

    /**
     * @param mixed $usuarioRel
     */
    public function setUsuarioRel($usuarioRel): void
    {
        $this->usuarioRel = $usuarioRel;
    }

    /**
     * @return bool
     */
    public function isCliente(): bool
    {
        return $this->cliente;
    }

    /**
     * @param bool $cliente
     */
    public function setCliente(bool $cliente): void
    {
        $this->cliente = $cliente;
    }


}