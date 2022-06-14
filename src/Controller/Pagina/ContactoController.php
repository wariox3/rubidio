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

class ContactoController extends AbstractController
{

    /**
     * @Route("/contacto", name="contacto")
     */
    public function contacto(Request $request, ManagerRegistry $doctrine): Response {
        $em = $doctrine->getManager();
        $arSoporte = new Soporte();
        $arSoporte->setFecha(new \DateTime('now'));
        $form = $this->createForm(ContactoType::class, $arSoporte);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arSoporte = $form->getData();
                $em->persist($arSoporte);
                $em->flush();
                return $this->redirectToRoute('soporte_asesor_informacion', ['id' => $arSoporte->getCodigoSoportePk()]);
            }
        }
        return $this->render('Pagina/contacto.html.twig', [
            'form' => $form->createView()
        ]);
    }


}