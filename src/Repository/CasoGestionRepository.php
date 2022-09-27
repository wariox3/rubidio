<?php

namespace App\Repository;

use App\Entity\CasoGestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CasoGestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CasoGestion::class);
    }

    public function lista($codigoCaso)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(CasoGestion::class, 'cg')
            ->select('cg.codigoCasoGestionPk')
            ->addselect('cg.fecha')
            ->addSelect('cg.fechaGestion')
            ->addSelect('cg.comentario')
            ->addSelect('cg.codigoUsuarioFk')
            ->where("cg.codigoCasoFk = {$codigoCaso}");
        $arCasoGestiones = $queryBuilder->getQuery()->getResult();
        return $arCasoGestiones;
    }

    public function eliminar($arrDetallesSeleccionados) {
        $em = $this->getEntityManager();
        if ($arrDetallesSeleccionados) {
            foreach ($arrDetallesSeleccionados as $codigo) {
                $arCasoGestion = $em->getRepository(CasoGestion::class)->find($codigo);
                if ($arCasoGestion) {
                    $em->remove($arCasoGestion);
                }
            }
            $em->flush();
        }
    }
}