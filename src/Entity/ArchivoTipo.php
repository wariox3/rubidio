<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArchivoTipoRepository")
 */
class ArchivoTipo
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_archivo_tipo_pk", type="string", length=50)
     */
    private $codigoArchivoTipoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=100, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="Archivo", mappedBy="archivoTipoRel")
     */
    protected $archivosArchivoTipoRel;

    /**
     * @return mixed
     */
    public function getCodigoArchivoTipoPk()
    {
        return $this->codigoArchivoTipoPk;
    }

    /**
     * @param mixed $codigoArchivoTipoPk
     */
    public function setCodigoArchivoTipoPk($codigoArchivoTipoPk): void
    {
        $this->codigoArchivoTipoPk = $codigoArchivoTipoPk;
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
    public function getArchivosArchivoTipoRel()
    {
        return $this->archivosArchivoTipoRel;
    }

    /**
     * @param mixed $archivosArchivoTipoRel
     */
    public function setArchivosArchivoTipoRel($archivosArchivoTipoRel): void
    {
        $this->archivosArchivoTipoRel = $archivosArchivoTipoRel;
    }

}

