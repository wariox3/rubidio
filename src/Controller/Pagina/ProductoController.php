<?php

namespace App\Controller\Pagina;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductoController extends AbstractController
{

    /**
     * @Route("/producto/erp", name="producto_erp")
     */
    public function erp(): Response {
        return $this->render('Pagina/Producto/erp.html.twig');
    }

}