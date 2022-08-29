<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="funcionalidad")
 * @ORM\Entity(repositoryClass="App\Repository\FuncionalidadRepository")
 */
class Funcionalidad
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_funcionalidad_pk", type="integer")
     */
    private $codigoFuncionalidadPk;

    /**
     * @ORM\Column(name="codigo_modulo_fk", type="string", length=20, nullable=true)
     */
    private $codigoModuloFk;

    /**
     * @ORM\Column(name="nombre", type="string", length=500, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="codigo_funcion_fk", type="string", length=20, nullable=true)
     */
    private $codigoFuncionFk;

    /**
     * @ORM\Column(name="orden", type="integer", nullable=true)
     */
    private $orden = 0;

    /**
     * @ORM\Column(name="estudio", type="boolean", nullable=true, options={"default" : false})
     */
    private $estudio = false;

    /**
     * @ORM\Column(name="url_you_tube", type="string", length=1000, nullable=true)
     */
    private $urlYouTube;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Modulo", inversedBy="funcionalidadesModuloRel")
     * @ORM\JoinColumn(name="codigo_modulo_fk", referencedColumnName="codigo_modulo_pk")
     */
    private $moduloRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ImplementacionDetalle", mappedBy="funcionalidadRel")
     */
    protected $implementacionesFuncionalidadRel;

    /**
     * @return mixed
     */
    public function getCodigoFuncionalidadPk()
    {
        return $this->codigoFuncionalidadPk;
    }

    /**
     * @param mixed $codigoFuncionalidadPk
     */
    public function setCodigoFuncionalidadPk($codigoFuncionalidadPk): void
    {
        $this->codigoFuncionalidadPk = $codigoFuncionalidadPk;
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
    public function getModuloRel()
    {
        return $this->moduloRel;
    }

    /**
     * @param mixed $moduloRel
     */
    public function setModuloRel($moduloRel): void
    {
        $this->moduloRel = $moduloRel;
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
     * @return int
     */
    public function getOrden(): int
    {
        return $this->orden;
    }

    /**
     * @param int $orden
     */
    public function setOrden(int $orden): void
    {
        $this->orden = $orden;
    }

    /**
     * @return bool
     */
    public function isEstudio(): bool
    {
        return $this->estudio;
    }

    /**
     * @param bool $estudio
     */
    public function setEstudio(bool $estudio): void
    {
        $this->estudio = $estudio;
    }

    /**
     * @return mixed
     */
    public function getUrlYouTube()
    {
        return $this->urlYouTube;
    }

    /**
     * @param mixed $urlYouTube
     */
    public function setUrlYouTube($urlYouTube): void
    {
        $this->urlYouTube = $urlYouTube;
    }

    /**
     * @return mixed
     */
    public function getImplementacionesFuncionalidadRel()
    {
        return $this->implementacionesFuncionalidadRel;
    }

    /**
     * @param mixed $implementacionesFuncionalidadRel
     */
    public function setImplementacionesFuncionalidadRel($implementacionesFuncionalidadRel): void
    {
        $this->implementacionesFuncionalidadRel = $implementacionesFuncionalidadRel;
    }



}
