<?php

namespace App\Repository;

use App\Entity\Devolucion;
use App\Entity\Norma;

use App\Entity\Tarea;
use App\Utilidades\AyudaEliminar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\Persistence\ManagerRegistry;

class TareaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tarea::class);
    }

    public function lista()
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Tarea::class, 't')
            ->select('t.codigoTareaPk')
            ->addSelect('t.fecha')
            ->addSelect('t.codigoUsuarioFk')
            ->addSelect('t.codigoPrioridadFk')
            ->addSelect('t.codigoCasoFk')
            ->addSelect('t.descripcion')
            ->addSelect('t.estadoEjecucion')
            ->addSelect('t.estadoTerminado')
            ->addSelect('t.estadoVerificado')
            ->addSelect('t.estadoDevolucion')
            ->addSelect('t.fechaEntrega')
            ->addSelect('p.nombre as proyectoNombre')
            ->leftJoin('t.proyectoRel', 'p')
            ->orderBy('t.fecha', 'DESC');

        if ($session->get('filtroTareaCodigoProyecto')) {
            $queryBuilder->andWhere('t.codigoProyectoFk=' . $session->get('filtroTareaCodigoProyecto'));
        }
        switch ($session->get('filtroTareaEstadoEjecucion')) {
            case '0':
                $queryBuilder->andWhere("t.estadoEjecucion = 0");
                break;
            case '1':
                $queryBuilder->andWhere("t.estadoEjecucion = 1");
                break;
        }

        switch ($session->get('filtroTareaEstadoTerminado')) {
            case '0':
                $queryBuilder->andWhere("t.estadoTerminado = 0");
                break;
            case '1':
                $queryBuilder->andWhere("t.estadoTerminado = 1");
                break;
        }

        switch ($session->get('filtroTareaEstadoVerificado')) {
            case '0':
                $queryBuilder->andWhere("t.estadoVerificado = 0");
                break;
            case '1':
                $queryBuilder->andWhere("t.estadoVerificado = 1");
                break;
        }
        return $queryBuilder;
    }

    public function listaUsuario($codigoUsuario)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Tarea::class, 't')
            ->select('t.codigoTareaPk')
            ->addSelect('t.fecha')
            ->addSelect('t.codigoUsuarioFk')
            ->addSelect('t.codigoPrioridadFk')
            ->addSelect('t.codigoCasoFk')
            ->addSelect('t.descripcion')
            ->addSelect('t.fechaEntrega')
            ->addSelect('t.estadoEjecucion')
            ->addSelect('t.estadoTerminado')
            ->addSelect('t.estadoVerificado')
            ->addSelect('t.estadoDevolucion')
            ->where("t.codigoUsuarioFk = '${codigoUsuario}'");
        switch ($session->get('filtroTareaEstadoEjecucion')) {
            case '0':
                $queryBuilder->andWhere("t.estadoEjecucion = 0");
                break;
            case '1':
                $queryBuilder->andWhere("t.estadoEjecucion = 1");
                break;
        }

        switch ($session->get('filtroTareaEstadoTerminado')) {
            case '0':
                $queryBuilder->andWhere("t.estadoTerminado = 0");
                break;
            case '1':
                $queryBuilder->andWhere("t.estadoTerminado = 1");
                break;
        }

        switch ($session->get('filtroTareaEstadoVerificado')) {
            case '0':
                $queryBuilder->andWhere("t.estadoVerificado = 0");
                break;
            case '1':
                $queryBuilder->andWhere("t.estadoVerificado = 1");
                break;
        }
        return $queryBuilder;
    }

    public function caso($codigoCaso)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Tarea::class, 't')
            ->select('t.codigoTareaPk')
            ->addSelect('t.fecha')
            ->addSelect('t.codigoUsuarioFk')
            ->addSelect('t.codigoPrioridadFk')
            ->addSelect('t.descripcion')
            ->addSelect('t.comentarioTerminado')
            ->addSelect('t.estadoEjecucion')
            ->addSelect('t.estadoTerminado')
            ->addSelect('t.estadoVerificado')
            ->addSelect('t.estadoDevolucion')
            ->addSelect('t.fechaEntrega')
            ->addSelect('p.nombre as proyectoNombre')
            ->leftJoin('t.proyectoRel', 'p')
            ->where('t.codigoCasoFk=' . $codigoCaso)
            ->orderBy('t.fecha', 'DESC');
        return $queryBuilder->getQuery()->getResult();
    }

    public function resumenUsuario($codigoUsuario)
    {
        $arrDatos = ['tareas' => 0, 'devoluciones' => 0, 'tareasVerificadas' => 0];
        $em = $this->getEntityManager();
        $fecha = new \DateTime('now');
        $ultimoDia = date("d", (mktime(0, 0, 0, $fecha->format('m') + 1, 1, $fecha->format('Y')) - 1));
        $fechaDesde = $fecha->format('Y') . "-" . $fecha->format('m') . "-01";
        $fechaHasta = $fecha->format('Y') . "-" . $fecha->format('m') . "-" . $ultimoDia;

        $queryBuilder = $em->createQueryBuilder()->from(Tarea::class, 't')
            ->select('COUNT(t.codigoTareaPk)')
            ->where("t.codigoUsuarioFk = '${codigoUsuario}'")
            ->andWhere("t.fecha >='" . $fechaDesde . " 00:00:00' AND t.fecha <= '" . $fechaHasta . " 23:59:59'");

        $arrTareas = $queryBuilder->getQuery()->getResult();
        if ($arrTareas) {
            $arrDatos['tareas'] = $arrTareas[0][1];
        }

        $queryBuilder = $em->createQueryBuilder()->from(Tarea::class, 't')
            ->select('COUNT(t.codigoTareaPk)')
            ->where("t.codigoUsuarioFk = '${codigoUsuario}'")
            ->andWhere('t.estadoVerificado = 1')
            ->andWhere("t.fecha >='" . $fechaDesde . " 00:00:00' AND t.fecha <= '" . $fechaHasta . " 23:59:59'");

        $arrTareas = $queryBuilder->getQuery()->getResult();
        if ($arrTareas) {
            $arrDatos['tareasVerificadas'] = $arrTareas[0][1];
        }

        $queryBuilder = $em->createQueryBuilder()->from(Devolucion::class, 'd')
            ->select('COUNT(d.codigoDevolucionPk)')
            ->join('d.tareaRel', 't')
            ->where("t.codigoUsuarioFk = '${codigoUsuario}'")
            ->andWhere("d.fecha >='" . $fechaDesde . " 00:00:00' AND d.fecha <= '" . $fechaHasta . " 23:59:59'");

        $arrDevoluciones = $queryBuilder->getQuery()->getResult();
        if ($arrDevoluciones) {
            $arrDatos['devoluciones'] = $arrDevoluciones[0][1];
        }
        return $arrDatos;
    }

}