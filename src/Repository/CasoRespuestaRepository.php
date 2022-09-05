<?php

namespace App\Repository;

use App\Entity\CasoGestion;
use App\Entity\CasoRespuesta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CasoRespuestaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CasoRespuesta::class);
    }

    public function lista($codigoCaso)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(CasoRespuesta::class, 'cr')
            ->select('cr.codigoCasoRespuestaPk')
            ->addselect('cr.fecha')
            ->addSelect('cr.comentario')
            ->addSelect('cr.codigoUsuarioFk')
            ->where("cr.codigoCasoFk = {$codigoCaso}");
        $arCasoRespuestas = $queryBuilder->getQuery()->getResult();
        return $arCasoRespuestas;
    }

}