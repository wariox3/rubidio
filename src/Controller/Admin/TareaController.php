<?php

namespace App\Controller\Admin;


use App\Entity\Caso;
use App\Entity\Devolucion;
use App\Entity\Obligacion;
use App\Entity\Proyecto;
use App\Entity\Vigencia;
use App\Entity\Tarea;
use App\Form\Type\DevolucionType;
use App\Form\Type\ObligacionType;
use App\Form\Type\TareaType;
use App\Form\Type\VigenciaType;
use App\Utilidades\Mensajes;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use function PHPSTORM_META\type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class TareaController extends AbstractController
{

    /**
     * @Route("/admin/tarea/nuevo/{id}/{codigoCaso}", name="admin_tarea_nuevo")
     */
    public function nuevo(Request $request, $id, $codigoCaso)
    {
        $em = $this->getDoctrine()->getManager();
        $arTarea = new Tarea();
        if ($id != 0) {
            $arTarea = $em->getRepository(Tarea::class)->find($id);
        }
        $form = $this->createForm(TareaType::class, $arTarea);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arTarea = $form->getData();
                if($id == 0) {
                    if($codigoCaso != 0) {
                        $arCaso = $em->getRepository(Caso::class)->find($codigoCaso);
                        $arCaso->setEstadoDesarrollo(1);
                        $em->persist($arCaso);
                        $arTarea->setCasoRel($arCaso);
                    }
                    $arTarea->setFecha(new \DateTime('now'));
                }
                $em->persist($arTarea);
                $em->flush();
                if($id == 0 && $codigoCaso != 0) {
                    return $this->redirect($this->generateUrl('soporte_caso_lista'));
                } else {
                    return $this->redirect($this->generateUrl('admin_tarea_detalle', array('id' => $arTarea->getCodigoTareaPk())));
                }

            }
        }
        return $this->render('Admin/Tarea/nuevo.html.twig', [
            'arTarea' => $arTarea,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/tarea/lista", name="admin_tarea_lista")
     */
    public function lista(Request $request,  PaginatorInterface $paginator) {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $arrayPropiedadesProyecto = array(
            'class' => 'App\Entity\Proyecto',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('p')
                    ->orderBy('p.nombre', 'ASC');
            },
            'choice_label' => 'nombre',
            'required' => false,
            'empty_data' => "",
            'placeholder' => "TODOS",
            'data' => ""
        );
        if ($session->get('filtroTareaCodigoProyecto')) {
            $arrayPropiedadesProyecto['data'] = $em->getReference("App\Entity\Proyecto", $session->get('filtroTareaCodigoProyecto'));
        }

        $form = $this->createFormBuilder()
            ->add('proyectoRel', EntityType::class, $arrayPropiedadesProyecto)
            ->add('estadoEjecucion', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroTareaEstadoEjecucion'), 'required' => false])
            ->add('estadoTerminado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroTareaEstadoTerminado'), 'required' => false])
            ->add('estadoVerificado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroTareaEstadoVerificado'), 'required' => false])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $arProyecto = $form->get('proyectoRel')->getData();
                if ($arProyecto) {
                    $session->set('filtroTareaCodigoProyecto', $arProyecto->getCodigoProyectoPk());
                } else {
                    $session->set('filtroTareaCodigoProyecto', null);
                }
                $session->set('filtroTareaEstadoEjecucion', $form->get('estadoEjecucion')->getData());
                $session->set('filtroTareaEstadoTerminado', $form->get('estadoTerminado')->getData());
                $session->set('filtroTareaEstadoVerificado', $form->get('estadoVerificado')->getData());
            }

            if($form->get('btnEliminar')->isClicked()){
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                $this->get('UtilidadesModelo')->eliminar(Tarea::class, $arrSeleccionados);
                return $this->redirect($this->generateUrl('admin_tarea_lista'));
            }
        }
        $arTareas = $paginator->paginate($em->getRepository(Tarea::class)->lista(), $request->query->getInt('page', 1), 500);
        return $this->render('Admin/Tarea/lista.html.twig', [
            'arTareas' => $arTareas,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/tarea/detalle/{id}", name="admin_tarea_detalle")
     */
    public function detalle(Request $request,  PaginatorInterface $paginator, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arTarea = $em->getRepository(Tarea::class)->find($id);
        $arrBtnVerificar = ['label' => 'Verificar', 'disabled' => true, 'attr' => ['class' => 'btn btn-sm btn-default']];
        if ($arTarea->getEstadoTerminado()) {
            if(!$arTarea->getEstadoVerificado()) {
                $arrBtnVerificar['disabled'] = false;
            }
        }

        $form = $this->createFormBuilder()
            ->add('btnVerificar', SubmitType::class, $arrBtnVerificar)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('btnVerificar')->isClicked()){
                $arTarea->setEstadoVerificado(1);
                $em->persist($arTarea);
                $em->flush();
            }
            return $this->redirect($this->generateUrl('admin_tarea_detalle', ['id' => $id]));
        }
        $arCaso = null;
        if($arTarea->getCodigoCasoFk()) {
            $arCaso = $em->getRepository(Caso::class)->find($arTarea->getCodigoCasoFk());
        }
        $arDevoluciones = $em->getRepository(Devolucion::class)->findBy(array('codigoTareaFk' => $id));
        return $this->render('Admin/Tarea/detalle.html.twig', [
            'arTarea' => $arTarea,
            'arDevoluciones' => $arDevoluciones,
            'arCaso' => $arCaso,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/tarea/devolucion/{codigoTarea}/{id}", name="admin_tarea_devolucion")
     */
    public function devolucion(Request $request, $codigoTarea, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arTarea = $em->getRepository(Tarea::class)->find($codigoTarea);
        $arDeVolucion = new Devolucion();
        if ($id != 0) {
            $arDeVolucion = $em->getRepository(Devolucion::class)->find($id);
        } else {
            $arDeVolucion->setFecha(new \DateTime('now'));
            $arDeVolucion->setTareaRel($arTarea);
        }
        $form = $this->createForm(DevolucionType::class, $arDeVolucion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arDeVolucion = $form->getData();
                $em->persist($arDeVolucion);

                $arTarea->setEstadoTerminado(0);
                $arTarea->setEstadoEjecucion(0);
                $arTarea->setEstadoDevolucion(1);
                $em->persist($arTarea);
                $em->flush();
                echo "<script languaje='javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        return $this->render('Admin/Tarea/devolucion.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
