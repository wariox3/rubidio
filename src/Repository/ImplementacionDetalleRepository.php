<?php

namespace App\Repository;

use App\Entity\ImplementacionDetalle;
use App\Entity\Norma;

use App\Entity\Implementacion;
use App\Entity\Tarea;
use App\Utilidades\AyudaEliminar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\Persistence\ManagerRegistry;

class ImplementacionDetalleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImplementacionDetalle::class);
    }

    public function lista($codigoImplementacion)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(ImplementacionDetalle::class, 'id')
            ->select('id.codigoImplementacionDetallePk')
            ->addSelect('id.fecha')
            ->addSelect('id.fechaCompromiso')
            ->addSelect('id.estadoCapacitado')
            ->addSelect('id.estadoTerminado')
            ->addSelect('id.estadoInicio')
            ->addSelect('id.comentario')
            ->addSelect('id.comentarioImplementador')
            ->addSelect('id.codigoTemaFk')
            ->addSelect("t.tiempo")
            ->addSelect('t.nombre as temaNombre')
            ->addSelect('t.descripcion as temaDescripcion')
            ->addSelect('t.codigoDocumentacionFk')
            ->addSelect('m.nombre as moduloNombre')
            ->addSelect('a.nombre as accionNombre')
            ->addSelect('a.codigoAccionPk')
            ->addSelect('r.nombre as responsableNombre')
            ->leftJoin('id.implementacionRel', 'i')
            ->leftJoin('id.temaRel', 't')
            ->leftJoin('t.moduloRel', 'm')
            ->leftJoin('id.accionRel', 'a')
            ->leftJoin('id.responsableRel', 'r')
            ->where("id.codigoImplementacionFk = {$codigoImplementacion}")
            ->orderBy('t.codigoModuloFk', 'ASC')
            ->addOrderBy('t.orden', 'ASC');

        switch ($session->get('filtroImplementacionDetalleEstadoTerminado')) {
            case '0':
                $queryBuilder->andWhere("id.estadoTerminado = 0");
                break;
            case '1':
                $queryBuilder->andWhere("id.estadoTerminado = 1");
                break;
        }

        switch ($session->get('filtroImplementacionEstadoCapacitado')) {
            case '0':
                $queryBuilder->andWhere("id.estadoCapacitado = 0");
                break;
            case '1':
                $queryBuilder->andWhere("id.estadoCapacitado = 1");
                break;
        }

        if ($session->get('filtroImplementacionModulo')) {
            $queryBuilder->andWhere("t.codigoModuloFk = '" . $session->get('filtroImplementacionModulo') . "'");
        }

        return $queryBuilder->getQuery()->getResult();
    }

    public function listaDetalle($codigoImplementacion, $raw)
    {
        $em = $this->getEntityManager();
        $filtros = $raw['filtros'] ?? null;
        $codigoModulo = null;
        $estadoCapacitado = null;
        $estadoTerminado = null;
        if ($filtros) {
            $codigoModulo = $filtros['codigoModulo'] ?? null;
            $estadoCapacitado = $filtros['estadoCapacitado'] ?? null;
            $estadoTerminado = $filtros['estadoTerminado'] ?? null;
        }
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(ImplementacionDetalle::class, 'id')
            ->select('id.codigoImplementacionDetallePk')
            ->addSelect('id.fechaCompromiso')
            ->addSelect('id.fechaCapacitacion')
            ->addSelect('id.codigoRequisitoFk')
            ->addSelect('id.codigoModuloFk')
            ->addSelect('id.codigoRequisitoFk')
            ->addSelect('id.codigoFuncionalidadFk')
            ->addSelect('id.comentario')
            ->addSelect('id.comentarioImplementador')
            ->addSelect('id.estadoTerminado')
            ->addSelect('id.estadoCapacitado')
            ->addSelect('id.responsable')
            ->addSelect('re.nombre as requisitoNombre')
            ->addSelect('fu.nombre as funcionalidadNombre')
            ->leftJoin('id.requisitoRel', 're')
            ->leftJoin('id.funcionalidadRel', 'fu')
            ->leftJoin('id.moduloRel', 'mod')
            ->where("id.codigoImplementacionFk = {$codigoImplementacion}")
            ->orderBy('id.requisito', 'DESC')
            ->addOrderBy('mod.orden', 'ASC')
            ->addOrderBy('re.orden', 'ASC');
        switch ($estadoCapacitado) {
            case '0':
                $queryBuilder->andWhere("id.estadoCapacitado = 0");
                break;
            case '1':
                $queryBuilder->andWhere("id.estadoCapacitado = 1");
                break;
        }
        switch ($estadoTerminado) {
            case '0':
                $queryBuilder->andWhere("id.estadoTerminado = 0");
                break;
            case '1':
                $queryBuilder->andWhere("id.estadoTerminado = 1");
                break;
        }
        if ($codigoModulo) {
            $queryBuilder->andWhere("id.codigoModuloFk = '{$codigoModulo}'");
        }

        return $queryBuilder->getQuery()->getResult();
    }

    public function listaCliente($codigoCliente)
    {
        $session = new Session();
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(ImplementacionDetalle::class, 'id')
            ->select('id.codigoImplementacionDetallePk')
            ->addSelect('id.fechaCompromiso')
            ->addSelect('id.codigoRequisitoFk')
            ->addSelect('id.codigoModuloFk')
            ->addSelect('id.codigoRequisitoFk')
            ->addSelect('id.codigoFuncionalidadFk')
            ->addSelect('id.comentario')
            ->addSelect('id.comentarioImplementador')
            ->addSelect('id.estadoTerminado')
            ->addSelect('id.estadoCapacitado')
            ->addSelect('id.responsable')
            ->addSelect('re.nombre as requisitoNombre')
            ->addSelect('fu.nombre as funcionalidadNombre')
            ->addSelect('m.nombre as moduloNombre')
            ->leftJoin('id.requisitoRel', 're')
            ->leftJoin('id.funcionalidadRel', 'fu')
            ->leftJoin('id.moduloRel', 'm')
            ->leftJoin('id.implementacionRel', 'i')
            ->where("i.codigoClienteFk = {$codigoCliente}")
            ->orderBy('id.requisito', 'DESC')
            ->addOrderBy('m.orden', 'ASC')
            ->addOrderBy('re.orden', 'ASC');
        switch ($session->get('filtroImplementacionEstadoCapacitado')) {
            case '0':
                $queryBuilder->andWhere("id.estadoCapacitado = 0");
                break;
            case '1':
                $queryBuilder->andWhere("id.estadoCapacitado = 1");
                break;
        }
        switch ($session->get('filtroImplementacionEstadoTerminado')) {
            case '0':
                $queryBuilder->andWhere("id.estadoTerminado = 0");
                break;
            case '1':
                $queryBuilder->andWhere("id.estadoTerminado = 1");
                break;
        }
        if ($session->get('filtroImplementacionCodigoModulo')) {
            $queryBuilder->andWhere("id.codigoModuloFk = '{$session->get('filtroImplementacionCodigoModulo')}' ");
        }
        $arImplementacionesDetalles = $queryBuilder->getQuery()->getResult();
        return $arImplementacionesDetalles;
    }
}