<?php

namespace App\Repository;

use App\Entity\Accion;
use App\Entity\ImplementacionDetalle;
use App\Entity\Norma;

use App\Entity\Implementacion;
use App\Entity\Responsable;
use App\Entity\Soporte;
use App\Entity\Tarea;
use App\Entity\Tema;
use App\Utilidades\AyudaEliminar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\Persistence\ManagerRegistry;

class ImplementacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Implementacion::class);
    }

    public function listaCliente($codigoCliente)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(ImplementacionDetalle::class, 'id')
            ->select('id.codigoImplementacionDetallePk')
            ->addSelect('id.fecha')
            ->addSelect('id.estadoCapacitado')
            ->addSelect('id.estadoTerminado')
            ->addSelect('id.estadoInicio')
            ->addSelect('id.comentario')
            ->addSelect('id.comentarioImplementador')
            ->addSelect('id.codigoTemaFk')
            ->addSelect('t.codigoDocumentacionFk')
            ->addSelect('t.nombre as temaNombre')
            ->addSelect('t.descripcion as temaDescripcion')
            ->addSelect('m.nombre as moduloNombre')
            ->addSelect('a.nombre as accionNombre')
            ->addSelect('r.nombre as responsableNombre')
            ->leftJoin('id.implementacionRel', 'i')
            ->leftJoin('id.temaRel', 't')
            ->leftJoin('t.moduloRel', 'm')
            ->leftJoin('id.accionRel', 'a')
            ->leftJoin('id.responsableRel', 'r')
            ->where("i.codigoClienteFk = ${codigoCliente}")
            ->orderBy('t.orden', 'ASC')
            ->addOrderBy('t.suborden', 'ASC');

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
        if ($session->get('filtroImplementacionModulo')) {
            $queryBuilder->andWhere("t.codigoModuloFk = '" . $session->get('filtroImplementacionModulo') . "'");
        }
        return $queryBuilder;
    }

    public function lista()
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Implementacion::class, 'i')
            ->select('i.codigoImplementacionPk')
            ->addSelect('i.nombre')
            ->addSelect('i.liderCliente')
            ->addSelect('i.celularLider')
            ->addSelect('i.correoLider')
            ->addSelect('i.general')
            ->addSelect('i.recursoHumano')
            ->addSelect('i.turnos')
            ->addSelect('i.inventario')
            ->addSelect('i.cartera')
            ->addSelect('i.tesoreria')
            ->addSelect('i.juridico')
            ->addSelect('i.crm')
            ->addSelect('i.financiero')
            ->addSelect('i.estadoTerminado')
            ->addSelect('i.cantidadDetalles')
            ->addSelect('i.cantidadDetallesTerminados')
            ->addSelect('i.tiempo')
            ->addSelect('i.tiempoTerminado')
            ->addSelect('i.porcentajeDetalles')
            ->addSelect('i.porcentajeTiempo')
            ->addSelect('c.nombreCorto as clienteNombreCorto')
            ->leftJoin('i.clienteRel', 'c')
            ->orderBy('i.codigoImplementacionPk', 'DESC');
        $arImplementaciones = $queryBuilder->getQuery()->getResult();
        return $arImplementaciones;
    }

    public function actualizar($codigoImplementacion, $modulo)
    {
        $em = $this->getEntityManager();
        $arImplementacion = $em->getRepository(Implementacion::class)->find($codigoImplementacion);
        $queryBuilder = $em->createQueryBuilder()->from(Tema::class, 't')
            ->select('t.codigoTemaPk')
            ->addSelect('t.codigoResponsableFk')
            ->addSelect('t.codigoAccionFk')
            ->where("t.codigoModuloFk='{$modulo}'")
            ->andWhere('t.requerido = 1');
        $arTemas = $queryBuilder->getQuery()->getResult();
        foreach ($arTemas as $arTema) {
            $arImplementacionDetalle = $em->getRepository(ImplementacionDetalle::class)->findOneBy(['codigoImplementacionFk' => $codigoImplementacion, 'codigoTemaFk' => $arTema['codigoTemaPk']]);
            if (!$arImplementacionDetalle) {
                $arImplementacionDetalle = new ImplementacionDetalle();
                $arImplementacionDetalle->setImplementacionRel($arImplementacion);
                $arImplementacionDetalle->setTemaRel($em->getReference(Tema::class, $arTema['codigoTemaPk']));
                $arImplementacionDetalle->setResponsableRel($em->getReference(Responsable::class, $arTema['codigoResponsableFk']));
                $arImplementacionDetalle->setAccionRel($em->getReference(Accion::class, $arTema['codigoAccionFk']));
                $em->persist($arImplementacionDetalle);
            }
        }
        $em->flush();
    }

    public function resumen($codigoImplementacion)
    {
        $em = $this->getEntityManager();
        $arImplementacion = $em->getRepository(Implementacion::class)->find($codigoImplementacion);
        $queryBuilder = $em->createQueryBuilder()->from(ImplementacionDetalle::class, 'id')
            ->select('COUNT(id.codigoImplementacionDetallePk) AS cantidad')
            ->addSelect('SUM(t.tiempo) as tiempo')
            ->leftJoin('id.temaRel', 't')
            ->where("id.codigoImplementacionFk = {$codigoImplementacion}");
        $arrDatosTotal = $queryBuilder->getQuery()->getSingleResult();
        $detalles = intval($arrDatosTotal['cantidad']);
        $tiempo = intval($arrDatosTotal['tiempo']);
        $queryBuilder = $em->createQueryBuilder()->from(ImplementacionDetalle::class, 'id')
            ->select('COUNT(id.codigoImplementacionDetallePk) AS cantidad')
            ->addSelect('SUM(t.tiempo) as tiempo')
            ->leftJoin('id.temaRel', 't')
            ->where("id.codigoImplementacionFk = {$codigoImplementacion}")
            ->andWhere('id.estadoTerminado = 0');
        $arrDatosTerminados = $queryBuilder->getQuery()->getSingleResult();
        $detallesTerminados = intval($arrDatosTerminados['cantidad']);
        $tiempoTerminado = intval($arrDatosTerminados['tiempo']);
        $arImplementacion->setCantidadDetalles($detalles);
        $arImplementacion->setCantidadDetallesTerminados($detallesTerminados);
        $arImplementacion->setTiempo($tiempo);
        $arImplementacion->setTiempoTerminado($tiempoTerminado);
        $porcentajeDetalles = 0;
        if ($detalles > 0) {
            $porcentajeDetalles = ($detallesTerminados / $detalles) * 100;
        }
        $porcentajeTiempo = 0;
        if ($tiempo > 0) {
            $porcentajeTiempo = ($tiempoTerminado / $tiempo) * 100;
        }
        $arImplementacion->setPorcentajeDetalles($porcentajeDetalles);
        $arImplementacion->setPorcentajeTiempo($porcentajeTiempo);
        $em->persist($arImplementacion);
        $em->flush();
    }
}