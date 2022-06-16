<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="articulo")
 * @ORM\Entity(repositoryClass="App\Repository\ArticuloRepository")
 */
class Articulo
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_articulo_pk", type="integer")
     */
    private $codigoArticuloPk;

    /**
     * @ORM\Column(name="fuente", type="string", length=1000, nullable=true)
     */
    private $fuente;

    /**
     * @ORM\Column(name="autor", type="string", length=1000, nullable=true)
     */
    private $autor;

    /**
     * @ORM\Column(name="titulo", type="text", nullable=true)
     */
    private $titulo;

    /**
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(name="url", type="text", nullable=true)
     */
    private $url;

    /**
     * @ORM\Column(name="url_imagen", type="text", nullable=true)
     */
    private $urlImagen;

    /**
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="estado_autorizado", type="boolean", options={"default" : false})
     */
    private $estadoAutorizado = false;

    /**
     * @return mixed
     */
    public function getCodigoArticuloPk()
    {
        return $this->codigoArticuloPk;
    }

    /**
     * @param mixed $codigoArticuloPk
     */
    public function setCodigoArticuloPk($codigoArticuloPk): void
    {
        $this->codigoArticuloPk = $codigoArticuloPk;
    }

    /**
     * @return mixed
     */
    public function getFuente()
    {
        return $this->fuente;
    }

    /**
     * @param mixed $fuente
     */
    public function setFuente($fuente): void
    {
        $this->fuente = $fuente;
    }

    /**
     * @return mixed
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * @param mixed $autor
     */
    public function setAutor($autor): void
    {
        $this->autor = $autor;
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
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url): void
    {
        $this->url = $url;
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
     * @return bool
     */
    public function isEstadoAutorizado(): bool
    {
        return $this->estadoAutorizado;
    }

    /**
     * @param bool $estadoAutorizado
     */
    public function setEstadoAutorizado(bool $estadoAutorizado): void
    {
        $this->estadoAutorizado = $estadoAutorizado;
    }


}
