<?php

namespace App\Repository;

use App\Entity\Articulo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ArticuloRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Articulo::class);
    }

    public function lista()
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Articulo::class, 'a')
            ->select('a.codigoArticuloPk')
            ->addSelect('a.titulo')
            ->addSelect('a.fecha')
            ->addSelect('a.descripcion')
            ->addSelect('a.url')
            ->addSelect('a.urlImagen')
            ->where('a.estadoAutorizado = 1')
            ->setMaxResults(3);
        $arrArticulos = $queryBuilder->getQuery()->getResult();
        return $arrArticulos;
    }
}