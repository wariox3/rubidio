<?php

namespace App\Repository;

use App\Entity\Caso;
use App\Entity\Norma;
use App\Utilidades\AyudaEliminar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;

class CasoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Caso::class);
    }

    public function lista()
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Caso::class, 'c')
            ->select('c.codigoCasoPk')
            ->addSelect('c.fecha')
            ->addSelect('c.compromiso')
            ->addSelect('c.contacto')
            ->addSelect('c.descripcion')
            ->addSelect('c.estadoAtendido')
            ->addSelect('c.estadoDesarrollo')
            ->addSelect('c.estadoEscalado')
            ->addSelect('c.estadoCerrado')
            ->addSelect('c.estadoRespuesta')
            ->addSelect('c.clienteIngreso')
            ->addSelect('c.codigoUsuarioFk')
            ->addSelect('cli.nombreCorto as clienteNombreCorto')
            ->addSelect('cli.servicioSoporte')
            ->addSelect('ct.nombre')
            ->addSelect('p.nombre as prioridadNombre')
            ->leftJoin('c.prioridadRel', 'p')
            ->leftJoin('c.casoTipoRel', 'ct')
            ->leftJoin('c.clienteRel', 'cli')
            ->where('c.estadoAtendido = 1')
            ->orderBy('c.codigoCasoPk', 'DESC');

        if ($session->get('filtroCasoUsuario')) {
            $queryBuilder->andWhere("c.codigoUsuarioFk = '{$session->get('filtroCasoUsuario')}'");
        }

        if ($session->get('filtroCasoCodigoCliente')) {
            $queryBuilder->andWhere('c.codigoClienteFk=' . $session->get('filtroCasoCodigoCliente'));
        }

        if ($session->get('filtroCasoCodigoTipo')) {
            $queryBuilder->andWhere("ct.codigoCasoTipoPk = '{$session->get('filtroCasoCodigoTipo')}' ");
        }

        switch ($session->get('filtroCasoEstadoDesarrollo')) {
            case '0':
                $queryBuilder->andWhere("c.estadoDesarrollo = 0");
                break;
            case '1':
                $queryBuilder->andWhere("c.estadoDesarrollo = 1");
                break;
        }

        switch ($session->get('filtroCasoEstadoEscalado')) {
            case '0':
                $queryBuilder->andWhere("c.estadoEscalado = 0");
                break;
            case '1':
                $queryBuilder->andWhere("c.estadoEscalado = 1");
                break;
        }

        switch ($session->get('filtroCasoEstadoCerrado')) {
            case '0':
                $queryBuilder->andWhere("c.estadoCerrado = 0");
                break;
            case '1':
                $queryBuilder->andWhere("c.estadoCerrado = 1");
                break;
        }
        switch ($session->get('filtroCasoEstadoRespuesta')) {
            case '0':
                $queryBuilder->andWhere("c.estadoRespuesta = 0");
                break;
            case '1':
                $queryBuilder->andWhere("c.estadoRespuesta = 1");
                break;
        }
        $arCasos = $queryBuilder->getQuery()->getResult();
        return $arCasos;
    }

    public function listaAtender()
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Caso::class, 'c')
            ->select('c.codigoCasoPk')
            ->addSelect('c.fecha')
            ->addSelect('c.compromiso')
            ->addSelect('c.contacto')
            ->addSelect('c.descripcion')
            ->addSelect('c.estadoAtendido')
            ->addSelect('c.estadoDesarrollo')
            ->addSelect('c.estadoEscalado')
            ->addSelect('c.estadoCerrado')
            ->addSelect('c.clienteIngreso')
            ->addSelect('c.codigoUsuarioFk')
            ->addSelect('cli.nombreCorto as clienteNombreCorto')
            ->addSelect('cli.servicioSoporte')
            ->addSelect('ct.nombre')
            ->addSelect('p.nombre as prioridadNombre')
            ->leftJoin('c.prioridadRel', 'p')
            ->leftJoin('c.casoTipoRel', 'ct')
            ->leftJoin('c.clienteRel', 'cli')
            ->where('c.estadoAtendido = 0');
        $arCasos = $queryBuilder->getQuery()->getResult();
        return $arCasos;
    }

    public function listaCliente($codigoCliente)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Caso::class, 'c')
            ->select('c.codigoCasoPk')
            ->addSelect('c.fecha')
            ->addSelect('c.compromiso')
            ->addSelect('c.contacto')
            ->addSelect('c.descripcion')
            ->addSelect('c.estadoAtendido')
            ->addSelect('c.estadoDesarrollo')
            ->addSelect('c.estadoEscalado')
            ->addSelect('c.estadoRespuesta')
            ->addSelect('c.estadoCerrado')
            ->addSelect('c.codigoUsuarioFk')
            ->addSelect('ct.nombre as casoTipoNombre')
            ->addSelect('p.nombre as prioridadNombre')
            ->leftJoin('c.prioridadRel', 'p')
            ->leftJoin('c.casoTipoRel', 'ct')
            ->where("c.codigoClienteFk = {$codigoCliente}")
            ->orderBy('c.codigoCasoPk', 'DESC');
        switch ($session->get('filtroCasoEstadoAtendido')) {
            case '0':
                $queryBuilder->andWhere("c.estadoAtendido = 0");
                break;
            case '1':
                $queryBuilder->andWhere("c.estadoAtendido = 1");
                break;
        }

        switch ($session->get('filtroCasoEstadoDesarrollo')) {
            case '0':
                $queryBuilder->andWhere("c.estadoDesarrollo = 0");
                break;
            case '1':
                $queryBuilder->andWhere("c.estadoDesarrollo = 1");
                break;
        }

        switch ($session->get('filtroCasoEstadoEscalado')) {
            case '0':
                $queryBuilder->andWhere("c.estadoEscalado = 0");
                break;
            case '1':
                $queryBuilder->andWhere("c.estadoEscalado = 1");
                break;
        }

        switch ($session->get('filtroCasoEstadoCerrado')) {
            case '0':
                $queryBuilder->andWhere("c.estadoCerrado = 0");
                break;
            case '1':
                $queryBuilder->andWhere("c.estadoCerrado = 1");
                break;
        }

        return $queryBuilder;
    }


}