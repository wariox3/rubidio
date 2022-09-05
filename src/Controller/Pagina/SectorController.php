<?php

namespace App\Controller\Pagina;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SectorController extends AbstractController
{

    /**
     * @Route("/sector/transporte", name="sector_transporte")
     */
    public function transporte(): Response {
        return $this->render('Pagina/Sector/transporte.html.twig');
    }

    /**
     * @Route("/sector/vigilancia", name="sector_vigilancia")
     */
    public function vigilancia(): Response {
        return $this->render('Pagina/Sector/vigilancia.html.twig');
    }

    /**
     * @Route("/sector/comercializacion", name="sector_comercializacion")
     */
    public function comercializacion(): Response {
        return $this->render('Pagina/Sector/comercializacion.html.twig');
    }
}