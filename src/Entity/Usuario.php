<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="usuario")
 */
class Usuario implements UserInterface, \Serializable
{


    /**
     * @ORM\Column(name="codigo_usuario_pk",type="string")
     * @ORM\Id
     */
    private $codigoUsuarioPk;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $nombres;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $apellidos;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $clave;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $verificado;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $token;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $correo;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $telefono;

    /**
     * @ORM\Column(name="codigo_rol_fk", type="string", length=200, nullable=true)
     */
    private $codigoRolFk;

    /**
     * @ORM\Column(name="adicionar_tarea", type="boolean", nullable=true, options={"default" : false})
     */
    private $adicionarTarea = false;

    /**
     * @ORM\Column(name="estado_inactivo", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoInactivo = false;

    /**
     * @ORM\Column(name="control", type="boolean", nullable=true)
     */
    private $control;

    /**
     * @ORM\Column(name="soporte", type="boolean", options={"default" : false})
     */
    private $soporte;

    /**
     * @ORM\Column(name="codigo_cliente_fk", type="integer", nullable=true)
     */
    private $codigoClienteFk;

    /**
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="usuariosClienteRel")
     * @ORM\JoinColumn(name="codigo_cliente_fk", referencedColumnName="codigo_cliente_pk")
     */
    private $clienteRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tarea", mappedBy="usuarioRel")
     */
    protected $tareasUsuarioRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Usuario", mappedBy="usuarioRel")
     */
    protected $casosRespuestasUsuarioRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Caso", mappedBy="usuarioRel")
     */
    protected $casosUsuarioRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CasoEscalado", mappedBy="usuarioRel")
     */
    protected $casosEscaladosUsuarioRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CasoEscalado", mappedBy="usuarioDestinoRel")
     */
    protected $casosEscaladosUsuarioDestinoRel;

//    /**
//     * @ORM\OneToMany(targetEntity="App\Entity\CasoGestion", mappedBy="usuarioRel")
//     */
//    private $casosGestionadosUsuarioRel;

    /**
     * Se implementan métodos de la clase User del core de Symfony además de los metodos de la entidad própia.
     *
     */
    public function serialize()
    {
        return serialize(array(
            $this->codigoUsuarioPk,
            $this->clave
        ));
    }

    public function unserialize($serialized)
    {
        list(
            $this->codigoUsuarioPk,
            $this->clave

            ) = unserialize($serialized);
    }

    public function getUsername()
    {
        return $this->getCodigoUsuarioPk();
    }

    public function getRoles()
    {
        $roles = explode(",", $this->getCodigoRolFk());
        return $roles;
    }

    public function getPassword()
    {
        return $this->getClave();
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {

    }

    /**
     * @return mixed
     */
    public function getCodigoUsuarioPk()
    {
        return $this->codigoUsuarioPk;
    }

    /**
     * @param mixed $codigoUsuarioPk
     */
    public function setCodigoUsuarioPk($codigoUsuarioPk): void
    {
        $this->codigoUsuarioPk = $codigoUsuarioPk;
    }

    /**
     * @return mixed
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * @param mixed $correo
     */
    public function setCorreo($correo): void
    {
        $this->correo = $correo;
    }

    /**
     * @return mixed
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * @param mixed $nombres
     */
    public function setNombres($nombres): void
    {
        $this->nombres = $nombres;
    }

    /**
     * @return mixed
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * @param mixed $apellidos
     */
    public function setApellidos($apellidos): void
    {
        $this->apellidos = $apellidos;
    }

    /**
     * @return mixed
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * @param mixed $clave
     */
    public function setClave($clave): void
    {
        $this->clave = $clave;
    }

    /**
     * @return mixed
     */
    public function getVerificado()
    {
        return $this->verificado;
    }

    /**
     * @param mixed $verificado
     */
    public function setVerificado($verificado): void
    {
        $this->verificado = $verificado;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token): void
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getCodigoRolFk()
    {
        return $this->codigoRolFk;
    }

    /**
     * @param mixed $codigoRolFk
     */
    public function setCodigoRolFk($codigoRolFk): void
    {
        $this->codigoRolFk = $codigoRolFk;
    }

    /**
     * @return mixed
     */
    public function getControl()
    {
        return $this->control;
    }

    /**
     * @param mixed $control
     */
    public function setControl($control): void
    {
        $this->control = $control;
    }

    /**
     * @return mixed
     */
    public function getTareasUsuarioRel()
    {
        return $this->tareasUsuarioRel;
    }

    /**
     * @param mixed $tareasUsuarioRel
     */
    public function setTareasUsuarioRel($tareasUsuarioRel): void
    {
        $this->tareasUsuarioRel = $tareasUsuarioRel;
    }

    /**
     * @return mixed
     */
    public function getCodigoClienteFk()
    {
        return $this->codigoClienteFk;
    }

    /**
     * @param mixed $codigoClienteFk
     */
    public function setCodigoClienteFk($codigoClienteFk): void
    {
        $this->codigoClienteFk = $codigoClienteFk;
    }

    /**
     * @return mixed
     */
    public function getClienteRel()
    {
        return $this->clienteRel;
    }

    /**
     * @param mixed $clienteRel
     */
    public function setClienteRel($clienteRel): void
    {
        $this->clienteRel = $clienteRel;
    }

    /**
     * @return mixed
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @param mixed $telefono
     */
    public function setTelefono($telefono): void
    {
        $this->telefono = $telefono;
    }

    /**
     * @return mixed
     */
    public function getAdicionarTarea()
    {
        return $this->adicionarTarea;
    }

    /**
     * @param mixed $adicionarTarea
     */
    public function setAdicionarTarea($adicionarTarea): void
    {
        $this->adicionarTarea = $adicionarTarea;
    }

    /**
     * @return mixed
     */
    public function getEstadoInactivo()
    {
        return $this->estadoInactivo;
    }

    /**
     * @param mixed $estadoInactivo
     */
    public function setEstadoInactivo($estadoInactivo): void
    {
        $this->estadoInactivo = $estadoInactivo;
    }

    /**
     * @return mixed
     */
    public function getCasosRespuestasUsuarioRel()
    {
        return $this->casosRespuestasUsuarioRel;
    }

    /**
     * @param mixed $casosRespuestasUsuarioRel
     */
    public function setCasosRespuestasUsuarioRel($casosRespuestasUsuarioRel): void
    {
        $this->casosRespuestasUsuarioRel = $casosRespuestasUsuarioRel;
    }

    /**
     * @return mixed
     */
    public function getCasosUsuarioRel()
    {
        return $this->casosUsuarioRel;
    }

    /**
     * @param mixed $casosUsuarioRel
     */
    public function setCasosUsuarioRel($casosUsuarioRel): void
    {
        $this->casosUsuarioRel = $casosUsuarioRel;
    }

    /**
     * @return mixed
     */
    public function getSoporte()
    {
        return $this->soporte;
    }

    /**
     * @param mixed $soporte
     */
    public function setSoporte($soporte): void
    {
        $this->soporte = $soporte;
    }

    /**
     * @return mixed
     */
    public function getCasosEscaladosUsuarioRel()
    {
        return $this->casosEscaladosUsuarioRel;
    }

    /**
     * @param mixed $casosEscaladosUsuarioRel
     */
    public function setCasosEscaladosUsuarioRel($casosEscaladosUsuarioRel): void
    {
        $this->casosEscaladosUsuarioRel = $casosEscaladosUsuarioRel;
    }

    /**
     * @return mixed
     */
    public function getCasosEscaladosUsuarioDestinoRel()
    {
        return $this->casosEscaladosUsuarioDestinoRel;
    }

    /**
     * @param mixed $casosEscaladosUsuarioDestinoRel
     */
    public function setCasosEscaladosUsuarioDestinoRel($casosEscaladosUsuarioDestinoRel): void
    {
        $this->casosEscaladosUsuarioDestinoRel = $casosEscaladosUsuarioDestinoRel;
    }

    /**
     * @return mixed
     */
    public function getCasosGestionadosUsuarioRel()
    {
        return $this->casosGestionadosUsuarioRel;
    }

    /**
     * @param mixed $casosGestionadosUsuarioRel
     */
    public function setCasosGestionadosUsuarioRel($casosGestionadosUsuarioRel): void
    {
        $this->casosGestionadosUsuarioRel = $casosGestionadosUsuarioRel;
    }


}
