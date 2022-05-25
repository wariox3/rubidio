<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DirectorioRepository")
 */
class Directorio
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $codigoDirectorioPk;

    /**
     * @ORM\Column(name="tipo", type="string", length=1, nullable=true)
     */
    private $tipo;

    /**
     * @ORM\Column(name="clase", type="string", length=50, nullable=true)
     */
    private $clase;

    /**
     * @ORM\Column(name="directorio", type="integer", options={"default" : 0})
     */
    private $directorio = 0;

    /**
     * @ORM\Column(name="numero_archivos", type="integer", options={"default" : 0})
     */
    private $numeroArchivos = 0;

    /**
     * @return mixed
     */
    public function getCodigoDirectorioPk()
    {
        return $this->codigoDirectorioPk;
    }

    /**
     * @param mixed $codigoDirectorioPk
     */
    public function setCodigoDirectorioPk($codigoDirectorioPk): void
    {
        $this->codigoDirectorioPk = $codigoDirectorioPk;
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo): void
    {
        $this->tipo = $tipo;
    }

    /**
     * @return mixed
     */
    public function getClase()
    {
        return $this->clase;
    }

    /**
     * @param mixed $clase
     */
    public function setClase($clase): void
    {
        $this->clase = $clase;
    }

    /**
     * @return int
     */
    public function getDirectorio(): int
    {
        return $this->directorio;
    }

    /**
     * @param int $directorio
     */
    public function setDirectorio(int $directorio): void
    {
        $this->directorio = $directorio;
    }

    /**
     * @return int
     */
    public function getNumeroArchivos(): int
    {
        return $this->numeroArchivos;
    }

    /**
     * @param int $numeroArchivos
     */
    public function setNumeroArchivos(int $numeroArchivos): void
    {
        $this->numeroArchivos = $numeroArchivos;
    }

}

