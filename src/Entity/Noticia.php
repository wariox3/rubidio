<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="noticia")
 * @ORM\Entity(repositoryClass="App\Repository\NoticiaRepository")
 */
class Noticia
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_noticia_pk", type="integer")
     */
    private $codigoNoticiaPk;

    /**
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="titulo", type="string", length=200, nullable=true)
     */
    private $titulo;

    /**
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(name="url_imagen", type="text", nullable=true)
     */
    private $urlImagen;

    /**
     * @ORM\Column(name="movil", type="boolean", options={"default" : false})
     */
    private $movil = false;

    /**
     * @ORM\Column(name="estado_inactivo", type="boolean", options={"default" : false})
     */
    private $estadoInactivo = false;

    /**
     * @return mixed
     */
    public function getCodigoNoticiaPk()
    {
        return $this->codigoNoticiaPk;
    }

    /**
     * @param mixed $codigoNoticiaPk
     */
    public function setCodigoNoticiaPk($codigoNoticiaPk): void
    {
        $this->codigoNoticiaPk = $codigoNoticiaPk;
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
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @param mixed $titulo
     */
    public function setTitulo($titulo): void
    {
        $this->titulo = $titulo;
    }

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return mixed
     */
    public function getUrlImagen()
    {
        return $this->urlImagen;
    }

    /**
     * @param mixed $urlImagen
     */
    public function setUrlImagen($urlImagen): void
    {
        $this->urlImagen = $urlImagen;
    }

    /**
     * @return bool
     */
    public function isMovil(): bool
    {
        return $this->movil;
    }

    /**
     * @param bool $movil
     */
    public function setMovil(bool $movil): void
    {
        $this->movil = $movil;
    }

    /**
     * @return bool
     */
    public function isEstadoInactivo(): bool
    {
        return $this->estadoInactivo;
    }

    /**
     * @param bool $estadoInactivo
     */
    public function setEstadoInactivo(bool $estadoInactivo): void
    {
        $this->estadoInactivo = $estadoInactivo;
    }


}
