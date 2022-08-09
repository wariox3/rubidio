<?php

namespace App\Controller\Soporte;

use App\Entity\Archivo;
use App\Entity\Caso;
use App\Entity\CasoTipo;
use App\Entity\Tarea;
use App\Form\Type\CasoEditarType;
use App\Form\Type\CasoEscaladoType;
use App\Form\Type\CasoSolucionType;
use App\Utilidades\Dubnio;
use App\Utilidades\Mensajes;
use Doctrine\ORM\EntityRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class CasoController extends AbstractController
{

    /**
     * @Route("/soporte/caso/nuevo/{id}", name="soporte_caso_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arCaso = new Caso();
        if ($id != 0) {
            $arCaso = $em->getRepository(Caso::class)->find($id);
        }
        $form = $this->createForm(CasoEditarType::class, $arCaso);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arCaso = $form->getData();
                $em->persist($arCaso);
                $em->flush();
                return $this->redirect($this->generateUrl('soporte_caso_detalle', ['id' => $id]));
            }
        }
        return $this->render('Soporte/Caso/nuevo.html.twig', [
            'arCaso' => $arCaso,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/soporte/caso/lista", name="soporte_caso_lista")
     */
    public function lista(Request $request,  PaginatorInterface $paginator)
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $arrayPropiedadesCliente = array(
            'class' => 'App\Entity\Cliente',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->orderBy('c.nombreCorto', 'ASC');
            },
            'choice_label' => 'nombreCorto',
            'required' => false,
            'placeholder' => "TODOS",
        );
        if ($session->get('filtroCasoCodigoCliente')) {
            $arrayPropiedadesCliente['data'] = $em->getReference("App\Entity\Cliente", $session->get('filtroCasoCodigoCliente'));
        }

        if ($session->get('filtroCasoEstadoPostergado') == null) {
            $session->set('filtroCasoEstadoPostergado', 0);
        }
        if ($session->get('filtroCasoEstadoAtendido') == null) {
            $session->set('filtroCasoEstadoAtendido', 0);
        }

        $form = $this->createFormBuilder()
            ->add('clienteRel', EntityType::class, $arrayPropiedadesCliente)
            ->add('CasoTipoRel', EntityType::class, array(
                'class' => CasoTipo::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'placeholder' => "TODOS",
                'required' => false,
            ))
            ->add('estadoAtendido', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroCasoEstadoAtendido'), 'required' => false])
            ->add('estadoDesarrollo', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroCasoEstadoDesarrollo'), 'required' => false])
            ->add('estadoEscalado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroCasoEstadoEscalado'), 'required' => false])
            ->add('estadoSolucionado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroCasoEstadoSolucionado'), 'required' => false])
            ->add('estadoPostergado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroCasoEstadoPostergado'), 'required' => false])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroCasoEstadoAtendido', $form->get('estadoAtendido')->getData());
                $session->set('filtroCasoEstadoDesarrollo', $form->get('estadoDesarrollo')->getData());
                $session->set('filtroCasoEstadoEscalado', $form->get('estadoEscalado')->getData());
                $session->set('filtroCasoEstadoSolucionado', $form->get('estadoSolucionado')->getData());
                $session->set('filtroCasoEstadoPostergado', $form->get('estadoPostergado')->getData());
                $arCliente = $form->get('clienteRel')->getData();
                if ($arCliente) {
                    $session->set('filtroCasoCodigoCliente', $arCliente->getCodigoClientePk());
                } else {
                    $session->set('filtroCasoCodigoCliente', null);
                }
                $arCasoTipo = $form->get('CasoTipoRel')->getData();
                if ($arCasoTipo) {
                    $session->set('filtroCasoCodigoTipo', $arCasoTipo->getCodigoCasoTipoPk());
                } else {
                    $session->set('filtroCasoCodigoTipo', null);
                }
            }
            if ($request->request->get('OpAtender')) {
                $codigo = $request->request->get('OpAtender');
                $arCaso = $em->getRepository(Caso::class)->find($codigo);
                if($arCaso) {
                    if($arCaso->getClienteRel()) {
                        $arCaso->setEstadoAtendido(1);
                        $em->persist($arCaso);
                        $em->flush();
                    } else {
                        Mensajes::error("Debe asignarle un cliente antes de atender");
                    }
                }
            }
        }
        $arCasos = $paginator->paginate($em->getRepository(Caso::class)->lista(), $request->query->getInt('page', 1), 50);
        return $this->render('Soporte/Caso/lista.html.twig', [
            'arCasos' => $arCasos,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/soporte/caso/detalle/{id}", name="soporte_caso_detalle")
     */
    public function detalle(Request $request,  PaginatorInterface $paginator, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arCaso = $em->getRepository(Caso::class)->find($id);

        $form = $this->createFormBuilder()
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('cliente_caso_detalle', ['id' => $id]));
        }
        $arTareas = $em->getRepository(Tarea::class)->caso($id);
        $arArchivos = $em->getRepository(Archivo::class)->lista(2, $id);
        return $this->render('Soporte/Caso/detalle.html.twig', [
            'arCaso' => $arCaso,
            'arTareas' => $arTareas,
            'arArchivos' => $arArchivos,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/soporte/caso/solucion/{id}", name="soporte_caso_solucion")
     */
    public function solucion(Request $request, Dubnio $correo, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arCaso = $em->getRepository(Caso::class)->find($id);

        $form = $this->createForm(CasoSolucionType::class, $arCaso);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arCaso = $form->getData();
                $arCaso->setFechaSolucion(new \DateTime('now'));
                $arCaso->setEstadoAtendido(1);
                $arCaso->setEstadoSolucionado(1);
                $em->persist($arCaso);
                $em->flush();
                $respuesta = $correo->enviarCorreo($arCaso->getCorreo(), 'Solución de caso' . ' - ' . $arCaso->getCodigoCasoPk(),
                    $this->renderView(
                        'Soporte/Caso/correoSolucion.html.twig',
                        array('arCaso' => $arCaso)
                    ));
                echo "<script type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        $bloqueado = false;
        $respuesta = $correo->bloqueo($arCaso->getCorreo());
        if($respuesta) {
            if($respuesta->error == false) {
                $bloqueado = $respuesta->bloqueado;
            }
        }
        if($bloqueado) {
            Mensajes::error("El correo {$arCaso->getCorreo()} electronico esta bloqueado");
        } else {
            Mensajes::info("Correo {$arCaso->getCorreo()} habilitado para envio de la respuesta");
        }
        return $this->render('Soporte/Caso/solucion.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/soporte/caso/escalar/{id}", name="soporte_caso_escalar")
     */
    public function escalar(Request $request, $id, Dubnio $correo)
    {
        $em = $this->getDoctrine()->getManager();
        $arCaso = $em->getRepository(Caso::class)->find($id);

        $form = $this->createForm(CasoEscaladoType::class, $arCaso);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arCaso = $form->getData();
                //$arCaso->setFechaSolucion(new \DateTime('now'));
                $arCaso->setEstadoAtendido(1);
                $arCaso->setEstadoEscalado(1);
                $em->persist($arCaso);
                $em->flush();
                /*$correo->enviarCorreo($arCaso->getCorreo(), 'Caso escalado'.' - '.$arCaso->getCodigoCasoPk(),
                    $this->renderView(
                        'Soporte/Caso/correoSolucion.html.twig',
                        array('arCaso' => $arCaso)
                    ));*/
                echo "<script languaje='javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        return $this->render('Soporte/Caso/escalar.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
