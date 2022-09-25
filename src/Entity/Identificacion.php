<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IdentificacionRepository")
 */
class Identificacion
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_identificacion_pk", type="string", length=3, unique=true)
     */
    private $codigoIdentificacionPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=30, nullable=true)
     * @Assert\Length(max = 30, maxMessage="El campo no puede contener más de 30 caracteres")
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contacto", mappedBy="identificacionRel")
     */
    protected $contactosIdentificacionRel;

    /**
     * @return mixed
     */
    public function getCodigoIdentificacionPk()
    {
        return $this->codigoIdentificacionPk;
    }

    /**
     * @param mixed $codigoIdentificacionPk
     */
    public function setCodigoIdentificacionPk($codigoIdentificacionPk): void
    {
        $this->codigoIdentificacionPk = $codigoIdentificacionPk;
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
    public function getContactosIdentificacionRel()
    {
        return $this->contactosIdentificacionRel;
    }

    /**
     * @param mixed $contactosIdentificacionRel
     */
    public function setContactosIdentificacionRel($contactosIdentificacionRel): void
    {
        $this->contactosIdentificacionRel = $contactosIdentificacionRel;
    }



}

