<?php

namespace App\Repository;

use App\Entity\Error;
use App\Entity\Norma;
use App\Utilidades\AyudaEliminar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;

class ErrorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Error::class);
    }

    public function lista()
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Error::class, 'e')
            ->select('e.codigoErrorPk')
            ->addSelect('e.fecha')
            ->addSelect('e.linea')
            ->addSelect('e.ruta')
            ->addSelect('e.mensaje')
            ->addSelect('e.usuario')
            ->addSelect('e.email')
            ->addSelect('e.estadoAtendido')
            ->addSelect('e.estadoSolucionado')
            ->addSelect('e.usuarioSoluciona')
            ->addSelect('c.nombreCorto as clienteNombreCorto')
            ->leftJoin('e.clienteRel', 'c')
            ->orderBy('e.fecha', 'DESC');


        if($session->get('filtroErrorCodigoUsuario')){
            $queryBuilder->andWhere("c.codigoClientePk = '{$session->get('filtroErrorCodigoUsuario')}'");
        }
        if ($session->get('filtroErrorCodigoCliente')) {
            $queryBuilder->andWhere("c.codigoClientePk = '{$session->get('filtroErrorCodigoCliente')}'");
        }
        switch ($session->get('filtroErrorEstadoAtendido')) {
            case '0':
                $queryBuilder->andWhere("e.estadoAtendido = 0");
                break;
            case '1':
                $queryBuilder->andWhere("e.estadoAtendido = 1");
                break;
        }

        switch ($session->get('filtroErrorEstadoSolucionado')) {
            case '0':
                $queryBuilder->andWhere("e.estadoSolucionado = 0");
                break;
            case '1':
                $queryBuilder->andWhere("e.estadoSolucionado = 1");
                break;
        }
        return $queryBuilder;
    }


}