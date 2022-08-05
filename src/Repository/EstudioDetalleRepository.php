<?php

namespace App\Repository;

use App\Entity\EstudioDetalle;
use App\Utilidades\Mensajes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EstudioDetalleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EstudioDetalle::class);
    }

    public function lista($id)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(EstudioDetalle::class, 'ed')
            ->select('ed.codigoEstudioDetallePk')
            ->addselect('ed.codigoModuloFk')
            ->addSelect('ed.fechaValidacion')
            ->addSelect('ed.responsable')
            ->addSelect('m.nombre as modulo')
            ->leftJoin('ed.estudioRel', 'e')
            ->leftJoin('ed.moduloRel', 'm')
            ->where("ed.codigoEstudioFk = {$id}");
        return $queryBuilder->getQuery()->getResult();
    }
    public function imprimirEstudio($id)
    {
            $em = $this->getEntityManager();
            $queryBuilder = $em->createQueryBuilder()->from(EstudioDetalle::class, 'ed')
                ->select('ed.codigoEstudioDetallePk')
                ->addselect('ed.codigoModuloFk')
                ->addSelect('ed.fechaValidacion')
                ->addSelect('ed.responsable')
                ->addSelect('m.nombre as moduloNombre')
                ->leftJoin('ed.estudioRel', 'e')
                ->leftJoin('ed.moduloRel', 'm')
                ->where("ed.codigoEstudioFk = {$id}");
            $arEstudioDetalles = $queryBuilder->getQuery()->getResult();
            return $arEstudioDetalles;
    }

    public function eliminar($arrDetallesSeleccionados)
    {
        $em = $this->getEntityManager();
        if ($arrDetallesSeleccionados) {
            if (count($arrDetallesSeleccionados)) {
                foreach ($arrDetallesSeleccionados as $codigo) {
                    $arRegistro = $em->getRepository(EstudioDetalle::class)->find($codigo);
                    if ($arRegistro) {
                        $em->remove($arRegistro);
                    }
                }
                try {
                    $em->flush();
                } catch (\Exception $e) {
                    Mensajes::error('No se puede eliminar, el registro se encuentra en uso en el sistema');
                }
            }
        } else {
            Mensajes::error("No existen registros para eliminar");
        }
    }

}