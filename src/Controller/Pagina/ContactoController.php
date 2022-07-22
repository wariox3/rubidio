<?php

namespace App\Controller\Pagina;

use App\Entity\ContactoSitio;
use App\Entity\Error;
use App\Entity\Soporte;
use App\Entity\Usuario;
use App\Form\Type\ContactoSitioType;
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
    public function contacto(Request $request, ManagerRegistry $doctrine, Dubnio $dubnio): Response {
        $em = $doctrine->getManager();
        $arContacto = new ContactoSitio();
        $arContacto->setFecha(new \DateTime('now'));
        $form = $this->createForm(ContactoSitioType::class, $arContacto);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arContacto = $form->getData();
                $em->persist($arContacto);
                $em->flush();
                $html = "Un cliente se ha comunicado con nosotros nombre: {$arContacto->getNombre()} empresa: {$arContacto->getEmpresa()}";
                $dubnio->enviarCorreo("maestradaz3@gmail.com", "Se han contactado con semantica", $html);
                return $this->redirectToRoute('contacto_informacion', ['id' => $arContacto->getCodigoContactoSitioPk()]);
            }
        }
        return $this->render('Pagina/Contacto/contacto.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/contacto/informacion/{id}", name="contacto_informacion")
     */
    public function soporteAsesorInformacion($id): Response
    {
        return $this->render('Pagina/Contacto/contactoInformacion.html.twig', [
            'codigoContacto' => $id
        ]);
    }
}