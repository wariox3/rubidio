<?php

namespace App\Controller\Implementacion;

use App\Entity\Caso;
use App\Entity\Configuracion;
use App\Entity\Devolucion;
use App\Entity\Implementacion;
use App\Entity\ImplementacionDetalle;
use App\Entity\Obligacion;
use App\Entity\Tarea;
use App\Entity\Vigencia;
use App\Entity\Soporte;
use App\Form\Type\ImplementacionDetalleImplementadorType;
use App\Form\Type\SoporteSolucionType;
use App\Form\Type\ObligacionType;
use App\Form\Type\SoporteType;
use App\Form\Type\TareaType;
use App\Form\Type\VigenciaType;
use App\Formatos\FormatoActaCapacitacion;
use App\Formatos\FormatoActaTerminacion;
use App\Formatos\FormatoPlanTrabajo;
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

class ImplementacionController extends AbstractController
{
    /**
     * @Route("/implementacion/implementacion/nuevo/{id}", name="implementacion_implementacion_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arImplementacionDetalle = $em->getRepository(ImplementacionDetalle::class)->find($id);
        $form = $this->createForm(ImplementacionDetalleImplementadorType::class, $arImplementacionDetalle);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arImplementacionDetalle = $form->getData();
                $em->persist($arImplementacionDetalle);
                $em->flush();
                echo "<script languaje='javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        return $this->render('Implementacion/Implementacion/nuevo.html.twig', [
            'arImplementacionDetalle' => $arImplementacionDetalle,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/implementacion/implementacion/lista", name="implementacion_implementacion_lista")
     */
    public function lista(Request $request)
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->request->get('OpActualizar')) {
                $codigo = $request->request->get('OpActualizar');
                $arImplementacion = $em->getRepository(Implementacion::class)->find($codigo);
                if ($arImplementacion->getGeneral()) {
                    $em->getRepository(Implementacion::class)->actualizar($codigo, 'GEN');
                }
                if ($arImplementacion->getRecursoHumano()) {
                    $em->getRepository(Implementacion::class)->actualizar($codigo, 'RHU');
                }
                if ($arImplementacion->getTurnos()) {
                    $em->getRepository(Implementacion::class)->actualizar($codigo, 'TUR');
                }
                if ($arImplementacion->getCartera()) {
                    $em->getRepository(Implementacion::class)->actualizar($codigo, 'CAR');
                }
                if ($arImplementacion->getTesoreria()) {
                    $em->getRepository(Implementacion::class)->actualizar($codigo, 'TES');
                }
                if ($arImplementacion->getCrm()) {
                    $em->getRepository(Implementacion::class)->actualizar($codigo, 'CRM');
                }
                if ($arImplementacion->getFinanciero()) {
                    $em->getRepository(Implementacion::class)->actualizar($codigo, 'FIN');
                }
                if ($arImplementacion->getInventario()) {
                    $em->getRepository(Implementacion::class)->actualizar($codigo, 'INV');
                }
                if ($arImplementacion->getJuridico()) {
                    $em->getRepository(Implementacion::class)->actualizar($codigo, 'JUR');
                }
                if ($arImplementacion->getTransporte()) {
                    $em->getRepository(Implementacion::class)->actualizar($codigo, 'TTE');
                }
                $em->getRepository(Implementacion::class)->resumen($codigo);
            }
        }
        $arImplementaciones = $paginator->paginate($em->getRepository(Implementacion::class)->lista(), $request->query->getInt('page', 1), 500);
        return $this->render('Implementacion/Implementacion/lista.html.twig', [
            'arImplementaciones' => $arImplementaciones,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/implementacion/implementacion/detalle/{id}", name="implementacion_implementacion_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $paginator = $this->get('knp_paginator');
        $em = $this->getDoctrine()->getManager();
        $arImplementacion = $em->getRepository(Implementacion::class)->find($id);
        $session = new Session();
        $arrModulo = [
            'TODOS' => '',
            'Cartera' => 'CAR',
            'CRM' => 'CRM',
            'Financiero' => 'FIN',
            'General' => 'GEN',
            'Inventario' => 'INV',
            'Juridico' => 'JUR',
            'RHumano' => 'RHU',
            'Tesoreria' => 'TES',
            'Transporte' => 'TTE',
            'Turnos' => 'TUR'];
        $form = $this->createFormBuilder()
            ->add('modulo', ChoiceType::class, ['choices' => $arrModulo, 'data' => $session->get('filtroImplementacionModulo'), 'required' => false])
            ->add('estadoCapacitado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroImplementacionEstadoCapacitado'), 'required' => false])
            ->add('estadoTerminado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroImplementacionEstadoTerminado'), 'required' => false])
            ->add('btnFiltrar', SubmitType::class, array('label' => 'Filtrar'))
            ->add('btnImprimir', SubmitType::class, array('label' => 'Imprimir acta capacitación', 'attr' => ['class' => 'btn btn-primary btn-sm']))
            ->add('btnImprimirActaTerminacion', SubmitType::class, array('label' => 'Imprimir acta terminacion', 'attr' => ['class' => 'btn btn-default btn-sm']))
            ->add('btnImprimirPlanTrabajo', SubmitType::class, array('label' => 'Imprimir plan de trabajo', 'attr' => ['class' => 'btn btn-default btn-sm']))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroImplementacionEstadoCapacitado', $form->get('estadoCapacitado')->getData());
                $session->set('filtroImplementacionModulo', $form->get('modulo')->getData());
                $session->set('filtroImplementacionDetalleEstadoTerminado', $form->get('estadoTerminado')->getData());
            }
            if ($form->get('btnImprimir')->isClicked()) {
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                if (!is_null($arrSeleccionados)) {
                    if (count($arrSeleccionados) >= 1 && count($arrSeleccionados) <= 7) {
                        $formatoCapacitacion = new FormatoActaCapacitacion();
                        $formatoCapacitacion->Generar($em, $id, $arrSeleccionados);
                    } else {
                        Mensajes::info("La cantidad de temas es mayor a 7, seleccionar menos");
                    }
                } else {
                    Mensajes::error("No hay registros seleccionados");
                }
            }
            if ($form->get('btnImprimirActaTerminacion')->isClicked()) {
                $validarTemasFinalizados = $em->getRepository(ImplementacionDetalle::class)->temasCapacitados($id);
                if ($validarTemasFinalizados == true) {
                    $formatoCapacitacion = new FormatoActaTerminacion();
                    $formatoCapacitacion->Generar($em, $id, $arImplementacion->getCodigoClienteFk());
                } else {
                    Mensajes::error("No se puede imprimir el acta de finalizacion ya que hay temas pendientes por capacitar");
                }
            }
            if ($form->get('btnImprimirPlanTrabajo')->isClicked()) {
                $formatoPlanTrabajo = new FormatoPlanTrabajo();
                $formatoPlanTrabajo->Generar($em, $id);
            }
        }
        $arImplementacionDetalles = $em->getRepository(ImplementacionDetalle::class)->lista($id);
        return $this->render('Implementacion/Implementacion/detalle.html.twig', ['arImplementacion' => $arImplementacion,
            'arImplementacionDetalles' => $arImplementacionDetalles,
            'form' => $form->createView()]);
    }

}
