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

    public function lista()
    {
        $em = $this->getEntityManager();
        $session = new Session();
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
        if ($session->get('filtroDocumentacionModulo')) {
            $queryBuilder->andWhere("d.codigoModuloFk = '{$session->get('filtroDocumentacionModulo')}' ");
        }
        if ($session->get('filtroDocumentacionModelo')) {
            $queryBuilder->andWhere("d.codigoModeloFk = '{$session->get('filtroDocumentacionModelo')}' ");
        }
        if ($session->get('filtroDocumentacionGrupo')) {
            $queryBuilder->andWhere("d.codigoGrupoFk = '{$session->get('filtroDocumentacionGrupo')}' ");
        }
        if ($session->get('filtroDocumentacionTitulo')) {
            $queryBuilder->andWhere("d.titulo = '{$session->get('filtroDocumentacionTitulo')}' ");
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

    public function apiLista($criterio, $modulo)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Documentacion::class, 'd')
            ->select('d.codigoDocumentacionPk')
            ->addSelect('d.codigoModuloFk')
            ->addSelect('d.titulo')
            ->addSelect('d.fechaActualizacion')
            ->addSelect('d.ruta')
            ->addSelect('d.contenido')
            ->orderBy('d.orden', 'ASC');
        if ($criterio) {
            $queryBuilder->andWhere("(d.titulo LIKE '%{$criterio}%' or d.contenido LIKE '%{$criterio}%')");
        }
        if ($modulo) {
            $queryBuilder->andWhere("d.codigoModuloFk = '{$modulo}'");

        }
        $queryBuilder->setMaxResults(30);
        return $queryBuilder->getQuery()->getResult();

    }

    public function apiDetalle($id)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Documentacion::class, 'd')
            ->select('d.codigoDocumentacionPk')
            ->addSelect('d.titulo')
            ->addSelect('d.fechaActualizacion')
            ->addSelect('d.contenido')
            ->addSelect('d.ruta')
            ->Where("d.codigoDocumentacionPk = {$id}");
        return $queryBuilder->getQuery()->getResult();
    }
}