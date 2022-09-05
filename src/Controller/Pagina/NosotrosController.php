<?php

namespace App\Controller\Pagina;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NosotrosController extends AbstractController
{

    /**
     * @Route("/nosotros", name="nosotros")
     */
    public function contacto(): Response {
        return $this->render('Pagina/Nosotros/nosotros.html.twig');
    }


}