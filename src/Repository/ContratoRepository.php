<?php

namespace App\Repository;

use App\Entity\Contrato;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ContratoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contrato::class);
    }

    public function lista($codigoCliente)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Contrato::class, 'c')
            ->select('c.codigoContratoPk')
            ->addSelect('c.numero')
            ->addSelect('c.numeroOferta')
            ->where("c.codigoClienteFk = {$codigoCliente}");
        $arrContratos = $queryBuilder->getQuery()->getResult();
        return $arrContratos;
    }

    public function imprimir($codigoContrato)
    {
        $em = $this->getEntityManager();
        $arEstudio = [];
        $queryBuilder = $em->createQueryBuilder()->from(Contrato::class, 'c')
            ->select('c.codigoContratoPk')
            ->where("c.codigoContratoPk = {$codigoContrato}");
        $arContratos = $queryBuilder->getQuery()->getResult();
        if($arContratos) {
            $arContrato = $arContratos[0];
        }
        return $arContrato;
    }

}