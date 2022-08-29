<?php

namespace App\Controller\Operacion;

use App\Entity\Funcionalidad;
use App\Entity\Implementacion;
use App\Entity\ImplementacionDetalle;
use App\Entity\Requisito;
use App\Form\Type\ImplementacionDetalleImplementadorType;
use App\Form\Type\ImplementacionType;
use App\Formatos\FormatoActaCapacitacion;
use App\Formatos\FormatoActaTerminacion;
use App\Formatos\FormatoPlanTrabajo;
use App\Utilidades\Mensajes;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class ImplementacionController extends AbstractController
{

    /**
     * @Route("/operacion/implementacion/lista", name="operacion_implementacion_lista")
     */
    public function lista(Request $request,  PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

        }
        $arImplementaciones = $paginator->paginate($em->getRepository(Implementacion::class)->lista(), $request->query->getInt('page', 1), 500);
        return $this->render('Operacion/Implementacion/lista.html.twig', [
            'arImplementaciones' => $arImplementaciones,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/operacion/implementacion/nuevo/{id}", name="operacion_implementacion_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arImplementacion = new Implementacion();
        $form = $this->createForm(ImplementacionType::class, $arImplementacion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arImplementacion = $form->getData();
                $em->persist($arImplementacion);
                $em->flush();
                return $this->redirect($this->generateUrl('operacion_implementacion_lista'));
            }
        }
        return $this->render('Operacion/Implementacion/nuevo.html.twig', [
            'arImplementacion' => $arImplementacion,
            'form' => $form->createView()
        ]);
    }

    /**
         * @Route("/operacion/implementacion/detalle/{id}", name="operacion_implementacion_detalle")
     */
    public function detalle(Request $request,  PaginatorInterface $paginator, $id)
    {
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
            ->add('btnImprimirActaTerminacion', SubmitType::class, array('label' => 'Imprimir acta terminacion', 'attr' => ['class' => 'btn btn-default btn-sm']))
            ->add('btnImprimirPlanTrabajo', SubmitType::class, array('label' => 'Imprimir plan de trabajo', 'attr' => ['class' => 'btn btn-default btn-sm']))
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-danger']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroImplementacionEstadoCapacitado', $form->get('estadoCapacitado')->getData());
                $session->set('filtroImplementacionModulo', $form->get('modulo')->getData());
                $session->set('filtroImplementacionDetalleEstadoTerminado', $form->get('estadoTerminado')->getData());
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
            if ($form->get('btnEliminar')->isClicked()) {
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                if ($arrSeleccionados) {
                    foreach ($arrSeleccionados as $codigo) {
                        $arError = $em->getRepository(ImplementacionDetalle::class)->find($codigo);
                        if ($arError) {
                            $em->remove($arError);
                        }
                    }
                    $em->flush();
                }
            }
        }
        $arImplementacionDetalle = $em->getRepository(ImplementacionDetalle::class)->listaDetalle($id);
        return $this->render('Operacion/Implementacion/detalle.html.twig', ['arImplementacion' => $arImplementacion,
            'arImplementacionDetalles' => $arImplementacionDetalle,
            'form' => $form->createView()]);
    }

    /**
     * @Route("/operacion/implementacion/detalle/nuevo/{id}", name="operacion_implementacion_detalle_nuevo")
     */
    public function detalleNuevo(Request $request, $id)
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
                echo "<script type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        return $this->render('Operacion/Implementacion/detalleNuevo.html.twig', [
            'arImplementacionDetalle' => $arImplementacionDetalle,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/operacion/implementacion/detalle/nuevo/requisito/{id}", name="operacion_implementacion_detalle_nuevo_requisito")
     */
    public function detalleNuevoRequisito(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arImplementacion = $em->getRepository(Implementacion::class)->find($id);
        $form = $this->createFormBuilder()
            ->add('btnGuardar', SubmitType::class, array('label' => 'Guardar'))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnGuardar')->isClicked()) {
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                foreach ($arrSeleccionados as $codigo) {
                    $arRequisito = $em->getRepository(Requisito::class)->find($codigo);
                    $arImplementacionDetalle = new ImplementacionDetalle();
                    $arImplementacionDetalle->setImplementacionRel($arImplementacion);
                    $arImplementacionDetalle->setRequisitoRel($arRequisito);
                    $arImplementacionDetalle->setCodigoModuloFk($arRequisito->getCodigoModuloFk());
                    $em->persist($arImplementacionDetalle);
                }
                $em->flush();
            }
            echo "<script type='text/javascript'>window.close();window.opener.location.reload();</script>";
        }
        $arRequisitos = $em->getRepository(Requisito::class)->lista();
        return $this->render('Operacion/Implementacion/detalleNuevoRequisito.html.twig', [
            'arRequisitos' => $arRequisitos,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/operacion/implementacion/detalle/nuevo/funcionalidad/{id}", name="operacion_implementacion_detalle_nuevo_funcionalidad")
     */
    public function detalleNuevoFuncionalidad(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arImplementacion = $em->getRepository(Implementacion::class)->find($id);
        $form = $this->createFormBuilder()
            ->add('btnGuardar', SubmitType::class, array('label' => 'Guardar'))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnGuardar')->isClicked()) {
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                foreach ($arrSeleccionados as $codigo) {
                    $arFuncionalidad = $em->getRepository(Funcionalidad::class)->find($codigo);
                    $arImplementacionDetalle = new ImplementacionDetalle();
                    $arImplementacionDetalle->setImplementacionRel($arImplementacion);
                    $arImplementacionDetalle->setFuncionalidadRel($arFuncionalidad);
                    $arImplementacionDetalle->setCodigoModuloFk($arFuncionalidad->getCodigoModuloFk());
                    $em->persist($arImplementacionDetalle);
                }
                $em->flush();
            }
            echo "<script type='text/javascript'>window.close();window.opener.location.reload();</script>";
        }
        $arFuncionalidades = $em->getRepository(Funcionalidad::class)->lista(null);
        return $this->render('Operacion/Implementacion/detalleNuevoFuncionalidad.html.twig', [
            'arFuncionalidades' => $arFuncionalidades,
            'form' => $form->createView()
        ]);
    }
}
