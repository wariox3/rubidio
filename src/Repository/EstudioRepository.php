<?php

namespace App\Repository;

use App\Entity\Estudio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EstudioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Estudio::class);
    }

    public function lista()
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Estudio::class, 'e')
            ->select('e.codigoEstudioPk')
            ->addSelect('e.fecha')
            ->addSelect('e.responsable')
            ->addSelect('e.estadoTerminado')
            ->addSelect('c.nombreCorto as clienteNombreCorto')
            ->leftJoin('e.clienteRel', 'c')
            ->orderBy('e.codigoEstudioPk', 'DESC');
        $arEstudios = $queryBuilder->getQuery()->getResult();
        return $arEstudios;
    }

    public function modulos($codigoEstudioPk)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Estudio::class, 'e')
            ->select('e.inventario')
            ->addSelect('e.compra')
            ->addSelect('e.tesoreria')
            ->addSelect('e.venta')
            ->addSelect('e.cartera')
            ->addSelect('e.crm')
            ->addSelect('e.financiero')
            ->addSelect('e.transporte')
            ->addSelect('e.turno')
            ->addSelect('e.recursoHumano')
            ->where("e.codigoEstudioPk = {$codigoEstudioPk}");
        $arEstudios = $queryBuilder->getQuery()->getSingleResult();

        return $arEstudios;
    }

    public function imprimir($codigoEstudio)
    {
        $em = $this->getEntityManager();
        $arEstudio = [];
        $queryBuilder = $em->createQueryBuilder()->from(Estudio::class, 'e')
            ->select('e.codigoEstudioPk')
            ->addSelect('e.fecha')
            ->addSelect('e.responsable')
            ->addSelect('e.estadoTerminado')
            ->addSelect('c.nombreCorto as clienteNombreCorto')
            ->addSelect('c.nombreExtendido as clienteNombreExtendido')
            ->leftJoin('e.clienteRel', 'c')
            ->where("e.codigoEstudioPk = {$codigoEstudio}")
            ->orderBy('e.codigoEstudioPk', 'DESC');
        $arEstudios = $queryBuilder->getQuery()->getResult();
        if($arEstudios) {
            $arEstudio = $arEstudios[0];
        }
        return $arEstudio;
    }

}