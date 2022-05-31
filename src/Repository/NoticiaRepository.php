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
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Noticia::class, 'n')
            ->select('n.codigoNoticiaPk as codigoNoticia')
            ->addSelect('n.descripcion')
            ->addSelect('n.fecha')
            ->addSelect('n.titulo')
            ->addSelect('n.urlImagen')
            ->where('n.movil = 0')
            ->andWhere('n.estadoInactivo = 0')
            ->orderBy('n.fecha', 'DESC');
        $arrNoticias = $queryBuilder->getQuery()->getResult();
        return $arrNoticias;
    }

    public function apiListaMovil()
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Noticia::class, 'n')
            ->select('n.codigoNoticiaPk as codigoNoticia')
            ->addSelect('n.descripcion')
            ->addSelect('n.fecha')
            ->addSelect('n.titulo')
            ->addSelect('n.urlImagen')
            ->where('n.movil = 1')
            ->andWhere('n.estadoInactivo = 0')
            ->orderBy('n.fecha', 'DESC');
        $arrNoticias = $queryBuilder->getQuery()->getResult();
        return [
            'noticias' => $arrNoticias
        ];
    }
}