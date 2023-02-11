<?php

namespace App\Repository;

use App\Entity\ContratoModulo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ContratoModuloRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContratoModulo::class);
    }

    public function contratoImprimir($codigoContrato)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(ContratoModulo::class, 'cm')
            ->select('cm.codigoContratoModuloPk')
            ->addSelect('m.nombre as moduloNombre')
            ->leftJoin('cm.moduloRel', 'm')
            ->where("cm.codigoContratoFk = {$codigoContrato}");
        $arContratosModulos = $queryBuilder->getQuery()->getResult();
        return $arContratosModulos;
    }
}