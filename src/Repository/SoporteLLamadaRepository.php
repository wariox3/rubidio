<?php

namespace App\Repository;

use App\Entity\Soporte;
use App\Entity\SoporteLLamada;
use App\Utilidades\Mensajes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SoporteLLamadaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SoporteLLamada::class);
    }

    public function lista($codigoSoporte)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(SoporteLLamada::class, 'sll')
            ->select('sll.codigoSoporteLLamadaPk')
            ->addselect('sll.fecha')
            ->addSelect('sll.fechaLLamada')
            ->addSelect('sll.comentarios')
            ->where("sll.codigoSoporteFk = {$codigoSoporte}");
        $arSoporteLLamadas = $queryBuilder->getQuery()->getResult();
        return $arSoporteLLamadas;
    }

    public function eliminar($arrDetallesSeleccionados)
    {
        $em = $this->getEntityManager();
        if ($arrDetallesSeleccionados) {
            if (count($arrDetallesSeleccionados)) {
                foreach ($arrDetallesSeleccionados as $codigo) {
                    $arSoporteLLamada = $em->getRepository(SoporteLLamada::class)->find($codigo);
                    if ($arSoporteLLamada) {
                        $soporte = $em->getRepository(Soporte::class)->find($arSoporteLLamada->getCodigoSoporteFk());
                        if($soporte->getEstadoSolucionado() == 0 ){
                            $em->remove($arSoporteLLamada);
                        } else {
                            Mensajes::error('No se puede eliminar, el soporte ya esta solucionado o atendido');
                        }
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