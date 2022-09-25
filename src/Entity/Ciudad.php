<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="ciudad")
 * @ORM\Entity(repositoryClass="App\Repository\CiudadRepository")
 */
class Ciudad
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_ciudad_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoCiudadPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="codigo_departamento_fk", type="integer")
     */
    private $codigoDepartamentoFk;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Departamento", inversedBy="ciudadesDepartamentoRel")
     * @ORM\JoinColumn(name="codigo_departamento_fk", referencedColumnName="codigo_departamento_pk")
     */
    private $departamentoRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contacto", mappedBy="ciudadRel")
     */
    protected $contactosCiudadRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contacto", mappedBy="ciudadIdentificacionRel")
     */
    protected $contactosCiudadIdentificacionRel;

    /**
     * @return mixed
     */
    public function getCodigoCiudadPk()
    {
        return $this->codigoCiudadPk;
    }

    /**
     * @param mixed $codigoCiudadPk
     */
    public function setCodigoCiudadPk($codigoCiudadPk): void
    {
        $this->codigoCiudadPk = $codigoCiudadPk;
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
    public function getCodigoDepartamentoFk()
    {
        return $this->codigoDepartamentoFk;
    }

    /**
     * @param mixed $codigoDepartamentoFk
     */
    public function setCodigoDepartamentoFk($codigoDepartamentoFk): void
    {
        $this->codigoDepartamentoFk = $codigoDepartamentoFk;
    }

    /**
     * @return mixed
     */
    public function getDepartamentoRel()
    {
        return $this->departamentoRel;
    }

    /**
     * @param mixed $departamentoRel
     */
    public function setDepartamentoRel($departamentoRel): void
    {
        $this->departamentoRel = $departamentoRel;
    }

    /**
     * @return mixed
     */
    public function getContactosCiudadRel()
    {
        return $this->contactosCiudadRel;
    }

    /**
     * @param mixed $contactosCiudadRel
     */
    public function setContactosCiudadRel($contactosCiudadRel): void
    {
        $this->contactosCiudadRel = $contactosCiudadRel;
    }

    /**
     * @return mixed
     */
    public function getContactosCiudadIdentificacionRel()
    {
        return $this->contactosCiudadIdentificacionRel;
    }

    /**
     * @param mixed $contactosCiudadIdentificacionRel
     */
    public function setContactosCiudadIdentificacionRel($contactosCiudadIdentificacionRel): void
    {
        $this->contactosCiudadIdentificacionRel = $contactosCiudadIdentificacionRel;
    }



}
