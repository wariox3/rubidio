<?php

namespace App\Repository;

use App\Entity\Requisito;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RequisitoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Requisito::class);
    }

    public function lista()
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Requisito::class, 'r')
            ->select('r.codigoRequisitoPk')
            ->addSelect('r.nombre')
            ->addSelect('r.codigoModuloFk')
            ->orderBy('r.codigoModuloFk');
        $arRequisitos = $queryBuilder->getQuery()->getResult();
        return $arRequisitos;
    }

    public function imprimirEstudio($codigoModulo)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Requisito::class, 'r')
            ->select('r.codigoRequisitoPk')
            ->addSelect('r.nombre')
            ->where("r.codigoModuloFk = '{$codigoModulo}'");
        $arRequisitos = $queryBuilder->getQuery()->getResult();
        return $arRequisitos;
    }
}