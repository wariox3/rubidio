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
            ->addSelect('c.codigoSetPruebasNominas');
        $arClientes = $queryBuilder->getQuery()->getResult();
        return $arClientes;
    }

}