<?php

namespace App\Repository;

use App\Entity\Contacto;
use App\Utilidades\Mensajes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;

class ContactoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contacto::class);
    }

    public function lista($codigoCliente)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Contacto::class, 'c')
            ->select('c.codigoContactoPk')
            ->addSelect('c.nombre')
            ->addSelect('c.cargo')
            ->addSelect('c.correo')
            ->addSelect('c.telefono')
            ->addSelect('ct.nombre as contactoTipo')
            ->leftJoin('c.contactoTipoRel', 'ct')
            ->where("c.codigoClienteFk = {$codigoCliente}")
            ->orderBy('c.codigoContactoPk');

        $arrContactos = $queryBuilder->getQuery()->getResult();
        return $arrContactos;
    }

    public function eliminar($arrDetallesSeleccionados)
    {
        $em = $this->getEntityManager();
        if ($arrDetallesSeleccionados) {
            if (count($arrDetallesSeleccionados)) {
                foreach ($arrDetallesSeleccionados as $codigo) {
                    $arRegistro = $em->getRepository(Contacto::class)->find($codigo);
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