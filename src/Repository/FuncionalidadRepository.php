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
            ->addSelect('f.codigoFuncionFk')
            ->addSelect('m.nombre as moduloNombre')
            ->leftJoin('f.moduloRel', 'm')
            ->orderBy('f.codigoModuloFk', 'ASC')
            ->addOrderBy('f.orden', 'ASC');
        if ($modulo) {
            $queryBuilder->andWhere("f.codigoModuloFk = '{$modulo}'");
        }
        $arFuncionalidades = $queryBuilder->getQuery()->getResult();
        return $arFuncionalidades;
    }

    public function imprimirEstudio($codigoModulo)
    {
        $em = $this->getEntityManager();
        $filtros = $raw['filtros'] ?? null;
        $queryBuilder = $em->createQueryBuilder()->from(Funcionalidad::class, 'f')
            ->select('f.codigoFuncionalidadPk')
            ->addSelect('f.nombre')
            ->addSelect('f.codigoFuncionFk')
            ->where("f.codigoModuloFk = '{$codigoModulo}'")
            ->andWhere("f.estudio = 1")
            ->orderBy('f.orden', 'ASC');
        $arFuncionalidades = $queryBuilder->getQuery()->getResult();
        return $arFuncionalidades;
    }

    public function detalleEstudio($codigoModulo)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Funcionalidad::class, 'f')
            ->select('f.codigoFuncionalidadPk')
            ->addSelect('f.nombre')
            ->addSelect('f.codigoFuncionFk')
            ->addSelect('f.urlYouTube')
            ->where("f.codigoModuloFk = '{$codigoModulo}'")
            ->andWhere("f.estudio = 1")
            ->orderBy('f.orden', 'ASC');
        $arFuncionalidades = $queryBuilder->getQuery()->getResult();
        return $arFuncionalidades;
    }
}