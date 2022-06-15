<?php

namespace App\Repository;

use App\Entity\Accion;
use App\Entity\Caso;
use App\Entity\Documentacion;
use App\Utilidades\AyudaEliminar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;

class DocumentacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Documentacion::class);
    }

    public function lista($raw)
    {
        $filtros = $raw['filtros'] ?? null;
        $modulo = null;
        if ($filtros) {
            $modulo = $filtros['modulo'] ?? null;
        }
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Documentacion::class, 'd')
            ->select('d.codigoDocumentacionPk')
            ->addSelect('d.codigoModeloFk')
            ->addSelect('d.codigoModuloFk')
            ->addSelect('d.codigoFuncionFk')
            ->addSelect('d.codigoGrupoFk')
            ->addSelect('d.titulo')
            ->addSelect('d.ruta')
            ->addSelect('d.contenido')
            ->addSelect('d.fechaActualizacion')
            ->orderBy('d.codigoModuloFk', 'ASC')
            ->addOrderBy('d.codigoFuncionFk', 'ASC');
        if ($modulo) {
            $queryBuilder->andWhere("d.codigoModuloFk = '{$modulo}'");
        }
        $arDocumentaciones = $queryBuilder->getQuery()->getResult();
        return $arDocumentaciones;
    }

    public function documentacionDetalle($id)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Documentacion::class, 'd')
            ->select('d.codigoDocumentacionPk')
            ->addSelect('d.titulo')
            ->addSelect('d.fechaActualizacion')
            ->addSelect('d.contenido')
            ->addSelect('d.ruta')
            ->Where("d.codigoDocumentacionPk = {$id}");
        return $queryBuilder->getQuery()->getResult();
    }

}