<?php

namespace App\Repository;

use App\Entity\Norma;

use App\Entity\Proyecto;
use App\Entity\Tarea;
use App\Utilidades\AyudaEliminar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\Persistence\ManagerRegistry;

class ProyectoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Proyecto::class);
    }

    public function lista()
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Proyecto::class, 'p')
            ->select('p.codigoProyectoPk')
            ->addSelect('p.nombre');
        return $queryBuilder;
    }

}