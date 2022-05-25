<?php

namespace App\Utilidades;

use App\Entity\Vigencia;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Modelo
{
    private $em;
/*
*/
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function eliminar($entidad, $arrSeleccionados){
        try{
            $em = $this->em;
             if ($arrSeleccionados && is_array($arrSeleccionados)) {
                 foreach ($arrSeleccionados as $codigo) {
                     $ar = $em->getRepository($entidad)->find($codigo);
                     if ($ar) {
                         $em->remove($ar);
                     }
                 }
                 $em->flush();
             }
         } catch (\Exception $ex) {
            Mensajes::error("El registro tiene registros relacionados");
         }
    }

}