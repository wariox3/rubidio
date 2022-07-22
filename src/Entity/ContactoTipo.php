<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CasoTipoRepository")
 */
class ContactoTipo
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_contacto_tipo_pk", type="string", length=3)
     */
    private $codigoContactoTipoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=100, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contacto", mappedBy="contactoTipoRel")
     */
    protected $contactosContactoTipoRel;

    /**
     * @return mixed
     */
    public function getCodigoContactoTipoPk()
    {
        return $this->codigoContactoTipoPk;
    }

    /**
     * @param mixed $codigoContactoTipoPk
     */
    public function setCodigoContactoTipoPk($codigoContactoTipoPk): void
    {
        $this->codigoContactoTipoPk = $codigoContactoTipoPk;
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
    public function getContactosContactoTipoRel()
    {
        return $this->contactosContactoTipoRel;
    }

    /**
     * @param mixed $contactosContactoTipoRel
     */
    public function setContactosContactoTipoRel($contactosContactoTipoRel): void
    {
        $this->contactosContactoTipoRel = $contactosContactoTipoRel;
    }

}

