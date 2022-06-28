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
     * @ORM\ManyToOne(targetEntity="App\Entity\Modulo", inversedBy="funcionalidadesModuloRel")
     * @ORM\JoinColumn(name="codigo_modulo_fk", referencedColumnName="codigo_modulo_pk")
     */
    private $moduloRel;

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



}
