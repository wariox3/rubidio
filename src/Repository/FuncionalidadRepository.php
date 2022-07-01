<?php

namespace App\Repository;

use App\Entity\Funcionalidad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class FuncionalidadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Funcionalidad::class);
    }

    public function lista($raw)
    {
        $em = $this->getEntityManager();
        $filtros = $raw['filtros'] ?? null;
        $modulo = null;
        if ($filtros) {
            $modulo = $filtros['modulo'] ?? null;
        }
        $queryBuilder = $em->createQueryBuilder()->from(Funcionalidad::class, 'f')
            ->select('f.codigoFuncionalidadPk')
            ->addSelect('f.codigoModuloFk')
            ->addSelect('f.nombre')
            ->addSelect('m.nombre as moduloNombre')
            ->leftJoin('f.moduloRel', 'm')
            ->orderBy('f.codigoModuloFk', 'ASC');
        if ($modulo) {
            $queryBuilder->andWhere("f.codigoModuloFk = '{$modulo}'");
        }
        $arFuncionalidades = $queryBuilder->getQuery()->getResult();
        return $arFuncionalidades;
    }
}