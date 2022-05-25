<?php

namespace App\Controller\Soporte;

use App\Entity\Configuracion;
use App\Entity\Devolucion;
use App\Entity\Documentacion;
use App\Entity\Obligacion;
use App\Entity\Tarea;
use App\Entity\Vigencia;
use App\Entity\Caso;
use App\Form\Type\CasoEditarType;
use App\Form\Type\CasoEscaladoType;
use App\Form\Type\CasoSolucionType;
use App\Form\Type\DocumentacionType;
use App\Form\Type\ObligacionType;
use App\Form\Type\CasoType;
use App\Form\Type\VigenciaType;
use App\Formatos\Documentancion;
use App\Servicios\Correo;
use App\Utilidades\Mensajes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use function PHPSTORM_META\type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityRepository;

class DocumentacionController extends AbstractController
{

    /**
     * @Route("/soporte/documentacion/nuevo/{id}", name="soporte_documentacion_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arDocumentacion = new Documentacion();
        if ($id != 0) {
            $arDocumentacion = $em->getRepository(Documentacion::class)->find($id);
        }
        $form = $this->createForm(DocumentacionType::class, $arDocumentacion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arDocumentacion = $form->getData();
                $em->persist($arDocumentacion);
                $em->flush();
                return $this->redirect($this->generateUrl('soporte_documentacion_lista'));
            }
        }
        return $this->render('Soporte/Documentacion/nuevo.html.twig', [
            'arDocumentacion' => $arDocumentacion,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/soporte/documentacion/lista", name="soporte_documentacion_lista")
     */
    public function lista(Request $request)
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('btnImprimir', SubmitType::class, ['label' => 'Imprimir', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('modulo', TextType::class, ['data' => $session->get('filtroDocumentacionModulo'), 'required' => false])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroDocumentacionModulo', $form->get('modulo')->getData());
            }
            if ($form->get('btnImprimir')->isClicked()) {
                $formatoDocumentacion = new Documentancion();
                $formatoDocumentacion->Generar($em);
            }

        }
        $arDocumentaciones = $paginator->paginate($em->getRepository(Documentacion::class)->lista(), $request->query->getInt('page', 1), 500);
        return $this->render('Soporte/Documentacion/lista.html.twig', [
            'arDocumentaciones' => $arDocumentaciones,
            'form' => $form->createView()
        ]);
    }

}
