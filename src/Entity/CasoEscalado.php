<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="caso_escalado")
 * @ORM\Entity(repositoryClass="App\Repository\CasoEscaladoRepository")
 */
class CasoEscalado
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_caso_escalado_pk", type="integer")
     */
    private $codigoCasoEscaladoPk;

    /**
     * @ORM\Column(name="codigo_caso_fk", type="integer", nullable=true)
     */
    private $codigoCasoFk;

    /**
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="comentario", type="text", nullable=true)
     */
    private $comentario;

    /**
     * @ORM\Column(name="codigo_usuario_fk", type="string")
     */
    private $codigoUsuarioFk;

    /**
     * @ORM\Column(name="codigo_usuario_destino_fk", type="string")
     */
    private $codigoUsuarioDestinoFk;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario", inversedBy="casosEscaladosUsuarioRel")
     * @ORM\JoinColumn(name="codigo_usuario_fk", referencedColumnName="codigo_usuario_pk")
     */
    private $usuarioRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario", inversedBy="casosEscaladosUsuarioDestinoRel")
     * @ORM\JoinColumn(name="codigo_usuario_destino_fk", referencedColumnName="codigo_usuario_pk")
     */
    private $usuarioDestinoRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Caso", inversedBy="casosEscaladosCasoRel")
     * @ORM\JoinColumn(name="codigo_caso_fk", referencedColumnName="codigo_caso_pk")
     */
    private $casoRel;

    /**
     * @return mixed
     */
    public function getCodigoCasoEscaladoPk()
    {
        return $this->codigoCasoEscaladoPk;
    }

    /**
     * @param mixed $codigoCasoEscaladoPk
     */
    public function setCodigoCasoEscaladoPk($codigoCasoEscaladoPk): void
    {
        $this->codigoCasoEscaladoPk = $codigoCasoEscaladoPk;
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
    public function getCodigoUsuarioDestinoFk()
    {
        return $this->codigoUsuarioDestinoFk;
    }

    /**
     * @param mixed $codigoUsuarioDestinoFk
     */
    public function setCodigoUsuarioDestinoFk($codigoUsuarioDestinoFk): void
    {
        $this->codigoUsuarioDestinoFk = $codigoUsuarioDestinoFk;
    }

    /**
     * @return mixed
     */
    public function getUsuarioDestinoRel()
    {
        return $this->usuarioDestinoRel;
    }

    /**
     * @param mixed $usuarioDestinoRel
     */
    public function setUsuarioDestinoRel($usuarioDestinoRel): void
    {
        $this->usuarioDestinoRel = $usuarioDestinoRel;
    }



}