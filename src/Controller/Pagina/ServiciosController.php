<?php

namespace App\Controller\Pagina;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiciosController extends AbstractController
{

    /**
     * @Route("/servicio/soporte", name="servicio_soporte")
     */
    public function soporte(): Response {
        return $this->render('Pagina/Servicio/soporte.html.twig');
    }

    /**
     * @Route("/servicio/consultoria", name="servicio_consultoria")
     */
    public function consultoria(): Response {
        return $this->render('Pagina/Servicio/consultoria.html.twig');
    }

    /**
     * @Route("/servicio/capacitacion", name="servicio_capacitacion")
     */
    public function capacitacion(): Response {
        return $this->render('Pagina/Servicio/capacitacion.html.twig');
    }

    /**
     * @Route("/servicio/nube", name="servicio_nube")
     */
    public function nube(): Response {
        return $this->render('Pagina/Servicio/nube.html.twig');
    }

    /**
     * @Route("/servicio/implementacion", name="servicio_implementacion")
     */
    public function implementacion(): Response {
        return $this->render('Pagina/Servicio/implementacion.html.twig');
    }

    /**
     * @Route("/servicio/medida", name="servicio_medida")
     */
    public function medida(): Response {
        return $this->render('Pagina/Servicio/medida.html.twig');
    }

}