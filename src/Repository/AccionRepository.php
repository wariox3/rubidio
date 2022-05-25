<?php

namespace App\Repository;

use App\Entity\Accion;
use App\Utilidades\AyudaEliminar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AccionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Accion::class);
    }


}