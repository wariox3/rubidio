<?php


namespace App\Repository;


use App\Entity\Archivo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;

class ArchivoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Archivo::class);
    }

    public function lista()
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(DocMasivo::class, 'm')
            ->select('m.codigoMasivoPk')
            ->addSelect('m.identificador')
            ->where('m.codigoMasivoPk <> 0');
        if ($session->get('filtroDocMasivoIdentificador') != '') {
            $queryBuilder->andWhere("m.identificador = {$session->get('filtroDocMasivoIdentificador')}");
        }
        return $queryBuilder;
    }

    public function listaArchivo($tipo, $codigo)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Archivo::class, 'a')
            ->select('a.codigoArchivoPk')
            ->addSelect('a.codigo')
            ->addSelect('a.nombre')
            ->addSelect('a.fecha')
            ->addSelect('a.descripcion')
            ->addSelect('a.usuario')
            ->where("a.codigoArchivoTipoFk = '" . $tipo . "'")
            ->andWhere("a.codigo = '" . $codigo . "'");
        $arArchivos = $queryBuilder->getQuery()->getResult();
        return $arArchivos;
    }

    public function validarExistencia($tipo, $codigo):bool
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Archivo::class, 'a')
            ->select('a.codigoArchivoPk as archivo')
            ->where("a.codigoArchivoTipoFk = '" . $tipo . "'")
            ->andWhere("a.codigo = '" . $codigo . "'");
        $arArchivos = $queryBuilder->getQuery()->getResult();
        if (count($arArchivos) > 0){
            return true;
        }else {
            return false;
        }
    }
}