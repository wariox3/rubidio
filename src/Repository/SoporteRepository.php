<?php

namespace App\Repository;

use App\Entity\Norma;
use App\Entity\Soporte;
use App\Utilidades\AyudaEliminar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;

class SoporteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Soporte::class);
    }

    public function lista()
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Soporte::class, 's')
            ->select('s.codigoSoportePk')
            ->addSelect('s.fecha')
            ->addSelect('s.fechaAtendido')
            ->addSelect('s.fechaSolucion')
            ->addSelect('s.contacto')
            ->addSelect('s.telefono')
            ->addSelect('s.correo')
            ->addSelect('s.descripcion')
            ->addSelect('s.solucion')
            ->addSelect('s.estadoAtendido')
            ->addSelect('s.estadoSolucionado')
            ->addSelect('c.nombreCorto as clienteNombreCorto')
            ->leftJoin('s.clienteRel', 'c')
            ->orderBy('s.fecha', 'DESC');

        if ($session->get('filtroSoporteCodigoCliente')) {
            $queryBuilder->andWhere('s.codigoClienteFk=' . $session->get('filtroSoporteCodigoCliente'));
        }

        switch ($session->get('filtroSoporteEstadoAtendido')) {
            case '0':
                $queryBuilder->andWhere("s.estadoAtendido = 0");
                break;
            case '1':
                $queryBuilder->andWhere("s.estadoAtendido = 1");
                break;
        }

        switch ($session->get('filtroSoporteEstadoSolucionado')) {
            case '0':
                $queryBuilder->andWhere("s.estadoSolucionado = 0");
                break;
            case '1':
                $queryBuilder->andWhere("s.estadoSolucionado = 1");
                break;
        }
        return $queryBuilder;
    }

    public function soportes($codigoCliente)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Soporte::class, 's')
            ->select('s.codigoSoportePk')
            ->addSelect('s.fecha')
            ->addSelect('s.fechaAtendido')
            ->addSelect('s.fechaSolucion')
            ->addSelect('s.contacto')
            ->addSelect('s.telefono')
            ->addSelect('s.correo')
            ->addSelect('s.descripcion')
            ->addSelect('s.solucion')
            ->addSelect('s.estadoAtendido')
            ->addSelect('s.estadoSolucionado')
            ->addSelect('c.nombreCorto as clienteNombreCorto')
            ->leftJoin('s.clienteRel', 'c')
            ->orderBy('s.fecha', 'DESC')
            ->where("c.codigoClientePk = {$codigoCliente}");

        switch ($session->get('filtroSoporteEstadoAtendido')) {
            case '0':
                $queryBuilder->andWhere("s.estadoAtendido = 0");
                break;
            case '1':
                $queryBuilder->andWhere("s.estadoAtendido = 1");
                break;
        }

        switch ($session->get('filtroSoporteEstadoSolucionado')) {
            case '0':
                $queryBuilder->andWhere("s.estadoSolucionado = 0");
                break;
            case '1':
                $queryBuilder->andWhere("s.estadoSolucionado = 1");
                break;
        }
        return $queryBuilder->getQuery()->getResult();
    }

    public function cantidadSoportesSinAtender()
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Soporte::class, 's')
            ->select('COUNT(s.codigoSoportePk)')
            ->where("s.estadoAtendido = 0");
        $cantidad = $queryBuilder->getQuery()->getSingleResult();
        return $cantidad[1];
    }

    public function cantidadSoportesSinSolucion()
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Soporte::class, 's')
            ->select('COUNT(s.codigoSoportePk)')
            ->where("s.estadoSolucionado = 0")
            ->andWhere("s.estadoAtendido = 1");
        $cantidad = $queryBuilder->getQuery()->getSingleResult();
        return $cantidad[1];
    }

    public function cantidadSoportesDia()
    {
        $em = $this->getEntityManager();
        $fecha = new \DateTime('now');
        $queryBuilder = $em->createQueryBuilder()->from(Soporte::class, 's')
            ->select('COUNT(s.codigoSoportePk)')
            ->where("s.fecha >= '" . $fecha->format('Y-m-d') . " 00:00:00'")
            ->andWhere("s.fecha <='" . $fecha->format('Y-m-d') . " 23:59:59'");
        $cantidad = $queryBuilder->getQuery()->getSingleResult();
        return $cantidad[1];
    }

    public function cantidadSoportesMes()
    {
        $em = $this->getEntityManager();
        $fecha = new \DateTime('now');
        $ultimoDia = date("d", (mktime(0, 0, 0, $fecha->format('m') + 1, 1, $fecha->format('Y')) - 1));
        $queryBuilder = $em->createQueryBuilder()->from(Soporte::class, 's')
            ->select('COUNT(s.codigoSoportePk)')
            ->where("s.fecha >= '" . $fecha->format('Y-m') . "-1 00:00:00'")
            ->andWhere("s.fecha <='" . $fecha->format('Y-m') . "-{$ultimoDia} 23:59:59'");
        $cantidad = $queryBuilder->getQuery()->getSingleResult();
        return $cantidad[1];
    }


}