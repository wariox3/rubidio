<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContratoTipoRepository")
 */
class ContratoTipo
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_contrato_tipo_pk", type="string", length=3)
     */
    private $codigoContratoTipoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=100, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contrato", mappedBy="contratoTipoRel")
     */
    protected $contratosContratoTipoRel;

    /**
     * @return mixed
     */
    public function getCodigoContratoTipoPk()
    {
        return $this->codigoContratoTipoPk;
    }

    /**
     * @param mixed $codigoContratoTipoPk
     */
    public function setCodigoContratoTipoPk($codigoContratoTipoPk): void
    {
        $this->codigoContratoTipoPk = $codigoContratoTipoPk;
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
    public function getContratosContratoTipoRel()
    {
        return $this->contratosContratoTipoRel;
    }

    /**
     * @param mixed $contratosContratoTipoRel
     */
    public function setContratosContratoTipoRel($contratosContratoTipoRel): void
    {
        $this->contratosContratoTipoRel = $contratosContratoTipoRel;
    }


}

