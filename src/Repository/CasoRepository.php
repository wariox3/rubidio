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
            ->addSelect('c.solucion')
            ->addSelect('c.comentarioPostergado')
            ->addSelect('c.respuestaPostergado')
            ->addSelect('p.nombre as prioridadNombre')
            ->addSelect('c.estadoAtendido')
            ->addSelect('c.estadoDesarrollo')
            ->addSelect('c.estadoEscalado')
            ->addSelect('c.estadoSolucionado')
            ->addSelect('c.estadoPostergado')
            ->addSelect('cli.nombreCorto as clienteNombreCorto')
            ->addSelect('ct.nombre')
            ->leftJoin('c.prioridadRel', 'p')
            ->leftJoin('c.casoTipoRel', 'ct')
            ->leftJoin('c.clienteRel', 'cli');

        if ($session->get('filtroCasoCodigoCliente')) {
            $queryBuilder->andWhere('c.codigoClienteFk=' . $session->get('filtroCasoCodigoCliente'));
        }

        if ($session->get('filtroCasoCodogoTipo')) {
            $queryBuilder->andWhere("ct.codigoCasoTipoPk = {$session->get('filtroCasoCodogoTipo')} ");
        }

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

        switch ($session->get('filtroCasoEstadoSolucionado')) {
            case '0':
                $queryBuilder->andWhere("c.estadoSolucionado = 0");
                break;
            case '1':
                $queryBuilder->andWhere("c.estadoSolucionado = 1");
                break;
        }

        switch ($session->get('filtroCasoEstadoPostergado')) {
            case '0':
                $queryBuilder->andWhere("c.estadoPostergado = 0");
                break;
            case '1':
                $queryBuilder->andWhere("c.estadoPostergado = 1");
                break;
        }

        return $queryBuilder;
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
            ->addSelect('c.solucion')
            ->addSelect('c.comentarioPostergado')
            ->addSelect('c.respuestaPostergado')
            ->addSelect('p.nombre as prioridadNombre')
            ->addSelect('c.estadoAtendido')
            ->addSelect('c.estadoDesarrollo')
            ->addSelect('c.estadoEscalado')
            ->addSelect('c.estadoSolucionado')
            ->addSelect('c.estadoPostergado')
            ->leftJoin('c.prioridadRel', 'p')
            ->where("c.codigoClienteFk = ${codigoCliente}");
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

        switch ($session->get('filtroCasoEstadoSolucionado')) {
            case '0':
                $queryBuilder->andWhere("c.estadoSolucionado = 0");
                break;
            case '1':
                $queryBuilder->andWhere("c.estadoSolucionado = 1");
                break;
        }

        return $queryBuilder;
    }


}