<?php

namespace App\Repository;

use App\Entity\CasoEscalado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CasoEscaladoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CasoEscalado::class);
    }

    public function lista($codigoCaso)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(CasoEscalado::class, 'ce')
            ->select('ce.codigoCasoEscaladoPk')
            ->addselect('ce.fecha')
            ->addSelect('ce.comentario')
            ->addSelect('ce.codigoUsuarioFk')
            ->addSelect('ce.codigoUsuarioDestinoFk')
            ->where("ce.codigoCasoFk = {$codigoCaso}");
        $arCasoEscalados = $queryBuilder->getQuery()->getResult();
        return $arCasoEscalados;
    }

}