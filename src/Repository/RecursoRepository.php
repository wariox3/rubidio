<?php

namespace App\Repository;

use App\Entity\Articulo;
use App\Entity\Recurso;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RecursoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recurso::class);
    }

    public function lista()
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Recurso::class, 'r')
            ->select('r.codigoRecursoPk')
            ->addSelect('r.fecha')
            ->addSelect('r.titulo')
            ->addSelect('r.url')
            ->addSelect('r.autor')
            ->addSelect('m.nombre as moduloNombre')
            ->leftJoin('r.moduloRel', 'm')
            ->orderBy('r.codigoModuloFk');
        $arrRecursos = $queryBuilder->getQuery()->getResult();
        return $arrRecursos;
    }
}