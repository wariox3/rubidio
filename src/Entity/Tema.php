<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tema")
 * @ORM\Entity(repositoryClass="App\Repository\TemaRepository")
 */
class Tema
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_tema_pk", type="integer")
     */
    private $codigoTemaPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=200, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="descripcion", type="string", length=2000, nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(name="codigo_modulo_fk", type="string", length=20, nullable=true)
     */
    private $codigoModuloFk;

    /**
     * @ORM\Column(name="codigo_responsable_fk", type="string", length=20, nullable=true)
     */
    private $codigoResponsableFk;

    /**
     * @ORM\Column(name="codigo_accion_fk", type="string", length=20, nullable=true)
     */
    private $codigoAccionFk;

    /**
     * @ORM\Column(name="requerido", type="boolean", nullable=true, options={"default" : false})
     */
    private $requerido = false;

    /**
     * @ORM\Column(name="orden", type="integer", nullable=true)
     */
    private $orden = 0;

    /**
     * @ORM\Column(name="suborden", type="integer", nullable=true)
     */
    private $suborden = 0;

    /**
     * @ORM\Column(name="tiempo", type="integer", nullable=true)
     */
    private $tiempo = 0;

    /**
     * @ORM\Column(name="codigo_documentacion_fk", type="integer", nullable=true)
     */
    private $codigoDocumentacionFk;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Modulo", inversedBy="temasModuloRel")
     * @ORM\JoinColumn(name="codigo_modulo_fk", referencedColumnName="codigo_modulo_pk")
     */
    private $moduloRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Responsable", inversedBy="temasResponsableRel")
     * @ORM\JoinColumn(name="codigo_responsable_fk", referencedColumnName="codigo_responsable_pk")
     */
    private $responsableRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Accion", inversedBy="temasAccionRel")
     * @ORM\JoinColumn(name="codigo_accion_fk", referencedColumnName="codigo_accion_pk")
     */
    private $accionRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Documentacion", inversedBy="temasDocumentacionRel")
     * @ORM\JoinColumn(name="codigo_documentacion_fk", referencedColumnName="codigo_documentacion_pk")
     */
    private $documentacionRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ImplementacionDetalle", mappedBy="temaRel")
     */
    protected $implementacionesDetallesTemaRel;

    /**
     * @return mixed
     */
    public function getCodigoTemaPk()
    {
        return $this->codigoTemaPk;
    }

    /**
     * @param mixed $codigoTemaPk
     */
    public function setCodigoTemaPk($codigoTemaPk): void
    {
        $this->codigoTemaPk = $codigoTemaPk;
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
    public function getCodigoResponsableFk()
    {
        return $this->codigoResponsableFk;
    }

    /**
     * @param mixed $codigoResponsableFk
     */
    public function setCodigoResponsableFk($codigoResponsableFk): void
    {
        $this->codigoResponsableFk = $codigoResponsableFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoAccionFk()
    {
        return $this->codigoAccionFk;
    }

    /**
     * @param mixed $codigoAccionFk
     */
    public function setCodigoAccionFk($codigoAccionFk): void
    {
        $this->codigoAccionFk = $codigoAccionFk;
    }

    /**
     * @return mixed
     */
    public function getRequerido()
    {
        return $this->requerido;
    }

    /**
     * @param mixed $requerido
     */
    public function setRequerido($requerido): void
    {
        $this->requerido = $requerido;
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

    /**
     * @return mixed
     */
    public function getSuborden()
    {
        return $this->suborden;
    }

    /**
     * @param mixed $suborden
     */
    public function setSuborden($suborden): void
    {
        $this->suborden = $suborden;
    }

    /**
     * @return mixed
     */
    public function getTiempo()
    {
        return $this->tiempo;
    }

    /**
     * @param mixed $tiempo
     */
    public function setTiempo($tiempo): void
    {
        $this->tiempo = $tiempo;
    }

    /**
     * @return mixed
     */
    public function getCodigoDocumentacionFk()
    {
        return $this->codigoDocumentacionFk;
    }

    /**
     * @param mixed $codigoDocumentacionFk
     */
    public function setCodigoDocumentacionFk($codigoDocumentacionFk): void
    {
        $this->codigoDocumentacionFk = $codigoDocumentacionFk;
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
    public function getResponsableRel()
    {
        return $this->responsableRel;
    }

    /**
     * @param mixed $responsableRel
     */
    public function setResponsableRel($responsableRel): void
    {
        $this->responsableRel = $responsableRel;
    }

    /**
     * @return mixed
     */
    public function getAccionRel()
    {
        return $this->accionRel;
    }

    /**
     * @param mixed $accionRel|
     */
    public function setAccionRel($accionRel): void
    {
        $this->accionRel = $accionRel;
    }

    /**
     * @return mixed
     */
    public function getDocumentacionRel()
    {
        return $this->documentacionRel;
    }

    /**
     * @param mixed $documentacionRel
     */
    public function setDocumentacionRel($documentacionRel): void
    {
        $this->documentacionRel = $documentacionRel;
    }

    /**
     * @return mixed
     */
    public function getImplementacionesDetallesTemaRel()
    {
        return $this->implementacionesDetallesTemaRel;
    }

    /**
     * @param mixed $implementacionesDetallesTemaRel
     */
    public function setImplementacionesDetallesTemaRel($implementacionesDetallesTemaRel): void
    {
        $this->implementacionesDetallesTemaRel = $implementacionesDetallesTemaRel;
    }

}
