<?php

namespace App\Repository;

use App\Entity\Configuracion;
use App\Utilidades\AyudaEliminar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\Persistence\ManagerRegistry;

class ConfiguracionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Configuracion::class);
    }

    public function envioCorreo()
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Configuracion::class, 'c')
            ->select('c.codigoConfiguracionPk')
            ->addSelect('c.correoSoporte')
            ->where('c.codigoConfiguracionPk = 1');
        return $queryBuilder->getQuery()->getSingleResult();

    }

}