<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
* @ORM\Table(name="configuracion")
* @ORM\Entity(repositoryClass="App\Repository\ConfiguracionRepository")
*/
class Configuracion
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_configuracion_pk", type="integer")
     */
    private $codigoConfiguracionPk;

    /**
     * @ORM\Column(name="correo_soporte", type="string", length=255, nullable =true)
     */
    private $correoSoporte;

    /**
     * @ORM\Column(name="logo", type="blob", nullable=true)
     */
    private $logo;

    /**
     * @return mixed
     */
    public function getCodigoConfiguracionPk()
    {
        return $this->codigoConfiguracionPk;
    }

    /**
     * @param mixed $codigoConfiguracionPk
     */
    public function setCodigoConfiguracionPk($codigoConfiguracionPk): void
    {
        $this->codigoConfiguracionPk = $codigoConfiguracionPk;
    }

    /**
     * @return mixed
     */
    public function getCorreoSoporte()
    {
        return $this->correoSoporte;
    }

    /**
     * @param mixed $correoSoporte
     */
    public function setCorreoSoporte($correoSoporte): void
    {
        $this->correoSoporte = $correoSoporte;
    }

    /**
     * @return mixed
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param mixed $logo
     */
    public function setLogo($logo): void
    {
        $this->logo = $logo;
    }




}
