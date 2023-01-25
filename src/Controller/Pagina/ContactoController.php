<?php

namespace App\Controller\Pagina;

use App\Entity\ContactoSitio;
use App\Form\Type\ContactoSitioType;
use App\Utilidades\Dubnio;
use App\Utilidades\Mensajes;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => "6LfZKSkkAAAAALoYLR5kXrs0OJdfZ9eJ4m6o3aU6", 'response' => $request->request->get('token'))));
                $respuesta = curl_exec($ch);
                curl_close($ch);
                $respuesta = json_decode($respuesta, true);
                if($respuesta["success"] == '1' && $respuesta["action"] == $request->request->get('action') && $respuesta["score"] >= 0.5) {
                    $arContacto = $form->getData();
                    $em->persist($arContacto);
                    $em->flush();
                    $html = "Un cliente se ha comunicado con nosotros nombre: {$arContacto->getNombre()} empresa: {$arContacto->getEmpresa()} mensaje: {$arContacto->getDescripcion()}";
                    $dubnio->enviarCorreo("maestradaz3@gmail.com", "Se han contactado con semantica", $html);
                    return $this->redirectToRoute('contacto_informacion', ['id' => $arContacto->getCodigoContactoSitioPk()]);
                } else {
                    Mensajes::error("Lo siento, parece que eres un Robot");
                }
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