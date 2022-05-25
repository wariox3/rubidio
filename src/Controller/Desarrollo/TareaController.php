<?php

namespace App\Controller\Desarrollo;

use App\Entity\Caso;
use App\Entity\Devolucion;
use App\Entity\Obligacion;
use App\Entity\Tiempo;
use App\Entity\Vigencia;
use App\Entity\Tarea;
use App\Form\Type\ObligacionType;
use App\Form\Type\TareaType;
use App\Form\Type\VigenciaType;
use App\Utilidades\Mensajes;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use function PHPSTORM_META\type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class TareaController extends AbstractController
{

    /**
     * @Route("/desarrollo/tarea/lista", name="desarrollo_tarea_lista")
     */
    public function lista(Request $request,  PaginatorInterface $paginator) {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()
            ->add('estadoEjecucion', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroTareaEstadoEjecucion'), 'required' => false])
            ->add('estadoTerminado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => 0, 'required' => false])
            ->add('estadoVerificado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroTareaEstadoVerificado'), 'required' => false])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])

            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroTareaEstadoEjecucion', $form->get('estadoEjecucion')->getData());
                $session->set('filtroTareaEstadoTerminado', $form->get('estadoTerminado')->getData());
                $session->set('filtroTareaEstadoVerificado', $form->get('estadoVerificado')->getData());
            }
        }
        $session->set('filtroTareaEstadoTerminado', $form->get('estadoTerminado')->getData());
        $arrDatos = $em->getRepository(Tarea::class)->resumenUsuario($this->getUser()->getCodigoUsuarioPk());
        $arTareas = $paginator->paginate($em->getRepository(Tarea::class)->listaUsuario($this->getUser()->getCodigoUsuarioPk()), $request->query->getInt('page', 1), 500);
        return $this->render('Desarrollo/Tarea/lista.html.twig', [
            'arTareas' => $arTareas,
            'arrDatos' => $arrDatos,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/desarrollo/tarea/detalle/{id}", name="desarrollo_tarea_detalle")
     */
    public function detalle(Request $request,  PaginatorInterface $paginator, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arTarea = $em->getRepository(Tarea::class)->find($id);
        $arrBtnTerminar = ['label' => 'Terminar', 'disabled' => true, 'attr' => ['class' => 'btn btn-sm btn-default']];
        if (!$arTarea->getEstadoTerminado()) {
            if($arTarea->getEstadoEjecucion()) {
                $arrBtnTerminar['disabled'] = false;
            }
        }
        $form = $this->createFormBuilder()

            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('desarrollo_tarea_detalle', ['id' => $id]));
        }
        $arCaso = null;
        if($arTarea->getCodigoCasoFk()) {
            $arCaso = $em->getRepository(Caso::class)->find($arTarea->getCodigoCasoFk());
        }
        $arDevoluciones = $em->getRepository(Devolucion::class)->findBy(array('codigoTareaFk' => $id));
        $arTiempos = $em->getRepository(Tiempo::class)->findBy(array('codigoTareaFk' => $id));
        return $this->render('Desarrollo/Tarea/detalle.html.twig', [
            'arDevoluciones' => $arDevoluciones,
            'arTiempos' => $arTiempos,
            'arTarea' => $arTarea,
            'arCaso' => $arCaso,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/desarrollo/tarea/ejecutar/{id}", name="desarrollo_tarea_ejecutar")
     */
    public function ejecutar(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arTarea = $em->getRepository(Tarea::class)->find($id);

        $form = $this->createFormBuilder()
            ->add('fechaEntrega', DateTimeType::class, ['data' => $arTarea->getFecha(), 'required' => true,  'widget' => 'single_text'])
            ->add('btnEjecutar', SubmitType::class, ['label' => 'Ejecutar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnEjecutar')->isClicked()) {
                $fechaEntrega = $form->get('fechaEntrega')->getData();
                $arTarea->setEstadoEjecucion(1);
                $arTarea->setFechaEntrega($fechaEntrega);
                $em->persist($arTarea);
                $arTiempo = new Tiempo();
                $arTiempo->setTareaRel($arTarea);
                $arTiempo->setInicio(new \DateTime('now'));
                $em->persist($arTiempo);
                $em->flush();
                echo "<script languaje='javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        return $this->render('Desarrollo/Tarea/ejecutar.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/desarrollo/tarea/terminar/{id}", name="desarrollo_tarea_terminar")
     */
    public function terminar(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arTarea = $em->getRepository(Tarea::class)->find($id);
        $form = $this->createFormBuilder()
            ->add('comentarioTerminado', TextareaType::class, ['data' => $arTarea->getComentarioTerminado(), 'required' => false])
            ->add('btnTerminar', SubmitType::class, ['label' => 'Terminar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnTerminar')->isClicked()) {
                if($arTarea->getEstadoTerminado() == 0) {
                    $comentario = $form->get('comentarioTerminado')->getData();
                    $arTarea->setEstadoTerminado(1);
                    $arTarea->setComentarioTerminado($comentario);
                    $em->persist($arTarea);
                    $arTiempo = $em->getRepository(Tiempo::class)->findOneBy(array('codigoTareaFk' => $id, 'estadoTerminado' => 0));
                    if($arTiempo) {
                        $arTiempo->setFin(new \DateTime('now'));
                        $arTiempo->setEstadoTerminado(1);
                        $tiempo = $arTiempo->getInicio()->diff($arTiempo->getFin());
                        $arTiempo->setHora($tiempo->format('%h'));
                        $arTiempo->setMinuto($tiempo->format('%i'));
                        $em->persist($arTiempo);
                    }
                    $em->flush();
                    echo "<script languaje='javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";
                }
            }
        }
        return $this->render('Desarrollo/Tarea/terminar.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
