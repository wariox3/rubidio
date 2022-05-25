<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DocumentacionRepository")
 */
class Documentacion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", name="codigo_documentacion_pk")
     */
    private $codigoDocumentacionPk;

    /**
     * @ORM\Column(name="titulo", type="string", length=200, nullable=true)
     */
    private $titulo;

    /**
     * @ORM\Column(name="codigo_modelo_fk", type="string", length=80, nullable=true)
     */
    private $codigoModeloFk;

    /**
     * @ORM\Column(name="codigo_modulo_fk", length=80, type="string", nullable=true)
     */
    private $codigoModuloFk;

    /**
     * @ORM\Column(name="codigo_funcion_fk", length=30, type="string", nullable=true)
     */
    private $codigoFuncionFk;

    /**
     * @ORM\Column(name="codigo_grupo_fk", length=50, type="string", nullable=true)
     */
    private $codigoGrupoFk;

    /**
     * @ORM\Column(name="fecha_actualizacion", type="date", nullable=true)
     */
    private $fechaActualizacion;

    /**
     * @ORM\Column(name="video", type="string", length=500, nullable=true)
     */
    private $video;

    /**
     * @ORM\Column(name="ruta", length=1000, type="string")
     */
    private $ruta;

    /**
     * @ORM\Column(name="contenido", type="text", nullable=true)
     */
    private $contenido;

    /**
     * @ORM\Column(name="orden", type="integer", nullable=true)
     */
    private $orden = 0;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tema", mappedBy="documentacionRel")
     */
    protected $temasDocumentacionRel;

    /**
     * @return mixed
     */
    public function getCodigoDocumentacionPk()
    {
        return $this->codigoDocumentacionPk;
    }

    /**
     * @param mixed $codigoDocumentacionPk
     */
    public function setCodigoDocumentacionPk($codigoDocumentacionPk): void
    {
        $this->codigoDocumentacionPk = $codigoDocumentacionPk;
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
    public function getCodigoModeloFk()
    {
        return $this->codigoModeloFk;
    }

    /**
     * @param mixed $codigoModeloFk
     */
    public function setCodigoModeloFk($codigoModeloFk): void
    {
        $this->codigoModeloFk = $codigoModeloFk;
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
    public function getCodigoFuncionFk()
    {
        return $this->codigoFuncionFk;
    }

    /**
     * @param mixed $codigoFuncionFk
     */
    public function setCodigoFuncionFk($codigoFuncionFk): void
    {
        $this->codigoFuncionFk = $codigoFuncionFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoGrupoFk()
    {
        return $this->codigoGrupoFk;
    }

    /**
     * @param mixed $codigoGrupoFk
     */
    public function setCodigoGrupoFk($codigoGrupoFk): void
    {
        $this->codigoGrupoFk = $codigoGrupoFk;
    }

    /**
     * @return mixed
     */
    public function getFechaActualizacion()
    {
        return $this->fechaActualizacion;
    }

    /**
     * @param mixed $fechaActualizacion
     */
    public function setFechaActualizacion($fechaActualizacion): void
    {
        $this->fechaActualizacion = $fechaActualizacion;
    }

    /**
     * @return mixed
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param mixed $video
     */
    public function setVideo($video): void
    {
        $this->video = $video;
    }

    /**
     * @return mixed
     */
    public function getRuta()
    {
        return $this->ruta;
    }

    /**
     * @param mixed $ruta
     */
    public function setRuta($ruta): void
    {
        $this->ruta = $ruta;
    }

    /**
     * @return mixed
     */
    public function getContenido()
    {
        return $this->contenido;
    }

    /**
     * @param mixed $contenido
     */
    public function setContenido($contenido): void
    {
        $this->contenido = $contenido;
    }

    /**
     * @return mixed
     */
    public function getTemasDocumentacionRel()
    {
        return $this->temasDocumentacionRel;
    }

    /**
     * @param mixed $temasDocumentacionRel
     */
    public function setTemasDocumentacionRel($temasDocumentacionRel): void
    {
        $this->temasDocumentacionRel = $temasDocumentacionRel;
    }

    /**
     * @return mixed
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * @param mixed $orden
     */
    public function setOrden($orden): void
    {
        $this->orden = $orden;
    }




}
