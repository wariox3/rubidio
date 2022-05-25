<?php


namespace App\Repository;


use App\Entity\Archivo;
use App\Entity\Directorio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DirectorioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Directorio::class);
    }

    public function devolverDirectorio($tipo, $clase) {
        $em = $this->getEntityManager();
        $directorio = "";
        $arDirectorio = $em->getRepository(Directorio::class)->findOneBy(array('tipo' => $tipo, 'clase' => $clase));
        if($arDirectorio) {
            if($arDirectorio->getNumeroArchivos() >= 50000) {
                $arDirectorio->setNumeroArchivos(1);
                $arDirectorio->setDirectorio($arDirectorio->getDirectorio()+1);
                $em->persist($arDirectorio);
                $directorio = $arDirectorio->getDirectorio();
            } else {
                $arDirectorio->setNumeroArchivos($arDirectorio->getNumeroArchivos()+1);
                $directorio = $arDirectorio->getDirectorio();
            }
        } else {
            $arDirectorio = new Directorio();
            $arDirectorio->setDirectorio(1);
            $arDirectorio->setNumeroArchivos(1);
            $arDirectorio->setTipo($tipo);
            $arDirectorio->setClase($clase);
            $em->persist($arDirectorio);
            $directorio = "1";
        }
        $em->flush();
        return $directorio;
    }
}