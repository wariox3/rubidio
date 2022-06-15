<?php

namespace App\Controller\Pagina;

use App\Entity\Error;
use App\Entity\Soporte;
use App\Entity\Usuario;
use App\Form\Type\ContactoType;
use App\Form\Type\SoporteExternoType;
use App\Utilidades\Dubnio;
use App\Utilidades\Mensajes;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
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