<?php

namespace App\Repository;

use App\Entity\Accion;
use App\Entity\ImplementacionDetalle;
use App\Entity\Implementacion;
use App\Entity\Responsable;
use App\Entity\Tema;
use App\Utilidades\Mensajes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Implementacion::class, 'i')
            ->select('i.codigoImplementacionPk')
            ->addSelect('i.nombre')
            ->addSelect('i.liderCliente')
            ->addSelect('i.celularLider')
            ->addSelect('i.correoLider')
            ->addSelect('i.estadoTerminado')
            ->addSelect('i.cantidadDetalles')
            ->addSelect('i.cantidadDetallesTerminados')
            ->addSelect('i.tiempo')
            ->addSelect('i.tiempoTerminado')
            ->addSelect('i.porcentajeDetalles')
            ->addSelect('i.porcentajeTiempo')
            ->where("i.codigoClienteFk = {$codigoCliente}");
        $arImplementaciones = $queryBuilder->getQuery()->getResult();
        return $arImplementaciones;
    }

    public function lista()
    {
        $session = new Session();
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Implementacion::class, 'i')
            ->select('i.codigoImplementacionPk')
            ->addSelect('i.nombre')
            ->addSelect('i.liderCliente')
            ->addSelect('i.celularLider')
            ->addSelect('i.correoLider')
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
        if ($session->get('filtroImplementacionCodigoCliente')) {
            $queryBuilder->andWhere('i.codigoClienteFk = ' . $session->get('filtroImplementacionCodigoCliente'));
        }
        switch ($session->get('filtroImplementacionEstadoTerminado')) {
            case '0':
                $queryBuilder->andWhere("i.estadoTerminado = 0");
                break;
            case '1':
                $queryBuilder->andWhere("i.estadoTerminado = 1");
                break;
        }
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

    public function terminar($arImplementacion)
    {
        $em = $this->getEntityManager();
        if($arImplementacion->isEstadoTerminado() == 0) {
            $arImplementacionDetalles = $em->getRepository(ImplementacionDetalle::class)->findBy(['codigoImplementacionFk' => $arImplementacion->getCodigoImplementacionPk(), 'estadoTerminado' => 0]);
            if(!$arImplementacionDetalles) {
                $arImplementacion->setEstadoTerminado(1);
                $em->persist($arImplementacion);
                $em->flush();
            } else {
                Mensajes::error('Se deben cerrar todos los detalles antes de terminar la implementacion');
            }
        } else {
            Mensajes::error('La implementacion ya esta terminada');
        }
    }
}