<?php

namespace App\Repository;

use App\Entity\Contrato;
use App\Utilidades\Funciones;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ContratoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contrato::class);
    }

    public function lista($codigoCliente)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Contrato::class, 'c')
            ->select('c.codigoContratoPk')
            ->addSelect('c.numero')
            ->addSelect('c.numeroOferta')
            ->addSelect('c.vrArrendamiento')
            ->addSelect('c.vrElectronico')
            ->addSelect('c.numeroUsuarios')
            ->addSelect('c.numeroGuias')
            ->addSelect('c.numeroEmpleados')
            ->addSelect('c.numeroElectronicos')
            ->addSelect('c.fechaInicio')
            ->addSelect('cr.nombre as contactoRepresentanteNombre')
            ->leftJoin('c.contactoRepresentanteRel', 'cr')
            ->where("c.codigoClienteFk = {$codigoCliente}");
        $arrContratos = $queryBuilder->getQuery()->getResult();
        return $arrContratos;
    }

    public function imprimir($codigoContrato)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Contrato::class, 'c')
            ->select('c.codigoContratoPk')
            ->addSelect('c.numero')
            ->addSelect('c.numeroOferta')
            ->addSelect('c.vrArrendamiento')
            ->addSelect('c.vrElectronico')
            ->addSelect('c.numeroElectronicos')
            ->addSelect('c.numeroUsuarios')
            ->addSelect('c.numeroGuias')
            ->addSelect('c.numeroEmpleados')
            ->addSelect('c.fechaInicio')
            ->addSelect('cr.nombre as representanteNombre')
            ->addSelect('cr.codigoIdentificacionFk as representanteCodigoIdentificacionFk')
            ->addSelect('cr.numeroIdentificacion as representanteNumeroIdentificacion')
            ->addSelect('cr.direccion as representanteDireccion')
            ->addSelect('crc.nombre as representanteCiudad')
            ->addSelect('crci.nombre as representanteCiudadIdentificacion')
            ->addSelect('cli.nombreExtendido as clienteNombreExtendido')
            ->addSelect('cli.nit as clienteNit')
            ->addSelect('cli.digitoVerificacion as clienteDigitoVerificacion')
            ->leftJoin('c.contactoRepresentanteRel', 'cr')
            ->leftJoin('cr.ciudadRel', 'crc')
            ->leftJoin('cr.ciudadIdentificacionRel', 'crci')
            ->leftJoin('c.clienteRel', 'cli')
            ->where("c.codigoContratoPk = {$codigoContrato}");
        $arContratos = $queryBuilder->getQuery()->getResult();
        if($arContratos) {
            $arContrato = $arContratos[0];
            $arContrato['valorLetras'] = $arContrato['vrArrendamiento']?Funciones::devolverNumeroLetras($arContrato['vrArrendamiento']):'CERO';
            $arContrato['valorLetrasElectronico'] = $arContrato['vrElectronico']?Funciones::devolverNumeroLetras($arContrato['vrElectronico']):'CERO';
        }
        return $arContrato;
    }

}