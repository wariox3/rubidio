<?php

namespace App\Repository;

use App\Entity\Caso;
use App\Entity\Norma;

use App\Entity\Noticia;
use App\Entity\Tarea;
use App\Utilidades\AyudaEliminar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;

class NoticiaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Noticia::class);
    }

    public function apiLista()
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Noticia::class, 'n')
            ->select('n.codigoNoticiaPk as codigoNoticia')
            ->addSelect('n.descripcion')
            ->addSelect('n.fecha')
            ->addSelect('n.titulo')
            ->addSelect('n.urlImagen')
            ->orderBy('n.fecha', 'DESC');

        return $queryBuilder->getQuery()->getResult();

    }
}