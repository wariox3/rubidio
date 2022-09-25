<?php

namespace App\Repository;

use App\Entity\Caso;
use App\Entity\Cliente;
use App\Entity\Norma;

use App\Entity\Tarea;
use App\Utilidades\AyudaEliminar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\Persistence\ManagerRegistry;

class ClienteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cliente::class);
    }

    public function lista()
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Cliente::class, 'c')
            ->select('c.codigoClientePk')
            ->addSelect('c.nombreCorto')
            ->addSelect('c.setPruebas')
            ->addSelect('c.setPruebasNomina')
            ->addSelect('c.suscriptor')
            ->addSelect('c.empleador')
            ->addSelect('c.nominaElectronica')
            ->addSelect('c.facturacionElectronica')
            ->where('c.facturacionElectronica = 1 OR c.nominaElectronica = 1');
        $arClientes = $queryBuilder->getQuery()->getResult();
        return $arClientes;
    }

    public function listaSoporte()
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Cliente::class, 'c')
            ->select('c.codigoClientePk')
            ->addSelect('c.nombreCorto')
            ->addSelect('c.nombreExtendido')
            ->addSelect('c.telefono')
            ->addSelect('c.direccion')
            ->addSelect('c.nit')
            ->addSelect('c.digitoVerificacion')
            ->addSelect('c.suscriptor')
            ->addSelect('c.empleador')
            ->addSelect('c.facturacionElectronica')
            ->addSelect('c.nominaElectronica')
            ->addSelect('c.setPruebas')
            ->addSelect('c.setPruebasNomina')
            ->addSelect('c.correoError')
            ->addSelect('c.codigoSetPruebas')
            ->addSelect('c.codigoSetPruebasNominas')
            ->addSelect('c.servicioSoporte')
            ->addSelect('c.fechaSuspension');

        if ($session->get('filtroSoporteClienteCodigoCliente')) {
            $queryBuilder->andWhere("c.codigoClientePk = '{$session->get('filtroSoporteClienteCodigoCliente')}' ");
        }

        $arClientes = $queryBuilder->getQuery()->getResult();

        return $arClientes;
    }


    public function listaAdministracion()
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Cliente::class, 'c')
            ->select('c.codigoClientePk')
            ->addSelect('c.nombreCorto')
            ->addSelect('c.nombreExtendido')
            ->addSelect('c.telefono')
            ->addSelect('c.direccion')
            ->addSelect('c.nit')
            ->addSelect('c.digitoVerificacion')
            ->addSelect('c.suscriptor')
            ->addSelect('c.empleador')
            ->addSelect('c.facturacionElectronica')
            ->addSelect('c.nominaElectronica')
            ->addSelect('c.setPruebas')
            ->addSelect('c.setPruebasNomina')
            ->addSelect('c.correoError')
            ->addSelect('c.codigoSetPruebas')
            ->addSelect('c.codigoSetPruebasNominas')
            ->addSelect('c.servicioSoporte')
            ->addSelect('c.fechaSuspension')
        ->orderBy('c.codigoClientePk', 'DESC');

        if ($session->get('filtroClienteNombre')) {
            $queryBuilder->andWhere("c.nombreCorto = '{$session->get('filtroClienteNombre')}' ");
        }

        $arClientes = $queryBuilder->getQuery()->getResult();
        return $arClientes;
    }

    public function clientesSuspendidos()
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Cliente::class, 'c')
            ->select('c.codigoClientePk')
            ->addSelect('c.nombreCorto')
            ->where('c.servicioSoporte = 0');
        $arClientes = $queryBuilder->getQuery()->getResult();
        return $arClientes;
    }

    public function apiVerificarSoporte($codigoCliente)
    {
        $em = $this->getEntityManager();
        $arCliente = $em->getRepository(Cliente::class)->find($codigoCliente);
        if($arCliente) {
            return [
                "error" => false,
                "soporte" => $arCliente->isServicioSoporte()
            ];
        } else {
            return [
                "error" => true,
                "errorMensaje" => "El cliente no existe"
            ];
        }
    }

    public function apiConectarServicio($codigoCliente)
    {
        $em = $this->getEntityManager();
        $arCliente = $em->getRepository(Cliente::class)->find($codigoCliente);
        if ($arCliente) {
            return [
                'error' => false,
                'nombre' => $arCliente->getNombreCorto(),
                'puntoServicio' => $arCliente->getPuntoServicio(),
                'puntoServicioToken' => $arCliente->getPuntoServicioToken()
            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe el operador"
            ];
        }
    }
}