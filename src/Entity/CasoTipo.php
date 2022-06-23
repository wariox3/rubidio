<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CasoTipoRepository")
 */
class CasoTipo
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_caso_tipo_pk", type="string", length=3)
     */
    private $codigoCasoTipoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=100, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Caso", mappedBy="casoTipoRel")
     */
    protected $casosCasoTipoRel;

    /**
     * @return mixed
     */
    public function getCodigoCasoTipoPk()
    {
        return $this->codigoCasoTipoPk;
    }

    /**
     * @param mixed $codigoCasoTipoPk
     */
    public function setCodigoCasoTipoPk($codigoCasoTipoPk): void
    {
        $this->codigoCasoTipoPk = $codigoCasoTipoPk;
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
    public function getCasosCasoTipoRel()
    {
        return $this->casosCasoTipoRel;
    }

    /**
     * @param mixed $casosCasoTipoRel
     */
    public function setCasosCasoTipoRel($casosCasoTipoRel): void
    {
        $this->casosCasoTipoRel = $casosCasoTipoRel;
    }
}

