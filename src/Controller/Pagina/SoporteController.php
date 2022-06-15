<?php

namespace App\Controller\Pagina;

use App\Entity\Archivo;
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

class SoporteController extends AbstractController
{

    /**
     * @Route("/soporte", name="soporte")
     */
    public function soporte(): Response {
        return $this->render('Pagina/soporte.html.twig');
    }

    /**
     * @Route("/soporte/asesor", name="soporte_asesor")
     */
    public function soporteAsesor(Request $request, ManagerRegistry $doctrine): Response {
        $em = $doctrine->getManager();
        $arSoporte = new Soporte();
        $arSoporte->setFecha(new \DateTime('now'));
        $form = $this->createForm(SoporteExternoType::class, $arSoporte);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arSoporte = $form->getData();
                $em->persist($arSoporte);
                $em->flush();
                $parametros = $request->files;
                foreach ($parametros as $archivos) {
                    foreach ($archivos as $archivo) {
                        $prueba = $archivo;
                        $extension = $archivo->getClientOriginalExtension();
                        $nombre = $archivo->getClientOriginalName();
                        $tamano = $archivo->getSize();
                        $mimeType = $archivo->getClientMimeType();
                        $archivoTemporal = $archivo->getPathName();
                        $em->getRepository(Archivo::class)->carga("soporte", $arSoporte->getCodigoSoportePk(), $extension, $nombre, $tamano, $mimeType, null, $archivoTemporal);
                    }
                }
                return $this->redirectToRoute('soporte_asesor_informacion', ['id' => $arSoporte->getCodigoSoportePk()]);
            }
        }
        return $this->render('Pagina/soporteAsesor.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/soporte/asesor/informacion/{id}", name="soporte_asesor_informacion")
     */
    public function soporteAsesorInformacion($id): Response {
        return $this->render('Pagina/soporteAsesorInformacion.html.twig', [
            'codigoSoporte' => $id
        ]);
    }

    /**
     * @Route("/soporte/asesor/detalle/{id}", name="soporte_asesor_detalle")
     */
    public function soporteAsesorDetalle(Request $request, ManagerRegistry $doctrine, $id): Response {
        $em = $doctrine->getManager();
        $arSoporte = [];
        if($id) {
            $arSoporte = $em->getRepository(Soporte::class)->find($id);
        }
        $formBuscar = $this->createFormBuilder()
            ->add('codigoSoporte', TextType::class)
            ->add('buscar', SubmitType::class)
            ->getForm();
        $formBuscar->handleRequest($request);
        if ($formBuscar->isSubmitted() && $formBuscar->isValid()) {
            if ($formBuscar->get('buscar')->isClicked()) {
                $codigoSoporte = $formBuscar->get('codigoSoporte')->getData();
                $arSoporte = $em->getRepository(Soporte::class)->find($codigoSoporte);
            }
        }
        return $this->render('Pagina/soporteAsesorDetalle.html.twig', [
            'arSoporte' => $arSoporte,
            'formBuscar' => $formBuscar->createView()
        ]);
    }

    /**
     * @Route("/soporte/comosehace", name="soporte_comosehace")
     */
    public function comoSeHace(): Response{
        return $this->render('Pagina/comoSeHace.html.twig');
    }

}