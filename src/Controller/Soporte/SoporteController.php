<?php

namespace App\Controller\Soporte;

use App\Entity\Archivo;
use App\Entity\Cliente;
use App\Entity\Modulo;
use App\Entity\Soporte;
use App\Entity\SoporteLLamada;
use App\Form\Type\SoporteLLamadaType;
use App\Form\Type\SoporteSolucionType;
use App\Form\Type\SoporteType;
use App\Utilidades\Dubnio;
use App\Utilidades\Mensajes;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityRepository;

class SoporteController extends AbstractController
{

    /**
     * @Route("/soporte/soporte/nuevo/{id}", name="soporte_soporte_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arSoporte = new Soporte();
        if ($id != 0) {
            $arSoporte = $em->getRepository(Soporte::class)->find($id);
        }
        $form = $this->createForm(SoporteType::class, $arSoporte);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arSoporte = $form->getData();
                if ($id == 0) {
                    $arSoporte->setFecha(new \DateTime('now'));
                }
                $em->persist($arSoporte);
                $em->flush();
                return $this->redirect($this->generateUrl('soporte_soporte_lista'));
            }
        }
        $arClientesSuspendidos = $em->getRepository(Cliente::class)->clientesSuspendidos();
        return $this->render('Soporte/Soporte/nuevo.html.twig', [
            'arSoporte' => $arSoporte,
            'arClientesSuspendidos' => $arClientesSuspendidos,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/soporte/soporte/lista", name="soporte_soporte_lista")
     */
    public function lista(Request $request, PaginatorInterface $paginator)
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $arrayPropiedadesCliente = array(
            'class' => Cliente::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->orderBy('c.nombreCorto', 'ASC');
            },
            'choice_label' => 'nombreCorto',
            'required' => false,
            'placeholder' => "TODOS",

        );
        if ($session->get('filtroSoporteCodigoCliente')) {
            $arrayPropiedadesCliente['data'] = $em->getReference("App\Entity\Cliente", $session->get('filtroSoporteCodigoCliente'));
        }

        if ($session->get('filtroSoporteEstadoSolucionado') == null) {
            $session->set('filtroSoporteEstadoSolucionado', 0);
        }

        $form = $this->createFormBuilder()
            ->add('clienteRel', EntityType::class, $arrayPropiedadesCliente)
            ->add('moduloRel', EntityType::class, array(
                'class' => Modulo::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'required' => false,
                'placeholder' => "TODOS",

            ))
            ->add('codigo', TextType::class, ['data' => $session->get('filtroSoporteCodigo'), 'required' => false])

            ->add('estadoAtendido', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroSoporteEstadoAtendido'), 'required' => false])
            ->add('estadoSolucionado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroSoporteEstadoSolucionado'), 'required' => false])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroSoporteEstadoAtendido', $form->get('estadoAtendido')->getData());
                $session->set('filtroSoporteEstadoSolucionado', $form->get('estadoSolucionado')->getData());
                $session->set('filtroSoporteCodigo', $form->get('codigo')->getData());

                $arCliente = $form->get('clienteRel')->getData();
                if ($arCliente) {
                    $session->set('filtroSoporteCodigoCliente', $arCliente->getCodigoClientePk());
                } else {
                    $session->set('filtroSoporteCodigoCliente', null);
                }

                $arModulo = $form->get('moduloRel')->getData();
                if ($arModulo) {
                    $session->set('filtroSoporteModulo', $arModulo->getCodigoModuloPk());
                } else {
                    $session->set('filtroSoporteModulo', null);
                }
            }
            if ($request->request->get('OpAtender')) {
                $codigo = $request->request->get('OpAtender');
                $arSoporte = $em->getRepository(Soporte::class)->find($codigo);
                $arSoporte->setEstadoAtendido(1);
                $arSoporte->setFechaAtendido(new \DateTime('now'));
                $em->persist($arSoporte);
                $em->flush();
            }
        }
        $arSoportes = $paginator->paginate($em->getRepository(Soporte::class)->lista(), $request->query->getInt('page', 1), 250);
        return $this->render('Soporte/Soporte/lista.html.twig', [
            'arSoportes' => $arSoportes,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/soporte/soporte/detalle/{id}", name="soporte_soporte_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arSoporte = $em->getRepository(Soporte::class)->find($id);
        $form = $this->createFormBuilder()
            ->add('btnEliminarLLamadas', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->request->get('OpDescargar')) {
                $codigoFichero = $request->request->get('OpDescargar');
                $respuesta = $em->getRepository(Archivo::class)->descargar($codigoFichero);
                if (!$respuesta['error']) {
                    $response = new Response();
                    $response->headers->set('Cache-Control', 'private');
                    $response->headers->set('Content-type', $respuesta['tipo']);
                    $response->headers->set('Content-Disposition', 'attachment; filename="' . $respuesta['nombre'] . '";');
                    $response->headers->set('Content-length', $respuesta['tamano']);
                    $response->sendHeaders();
                    $response->setContent($respuesta['contenido']);
                    return $response;
                }
            }
            if ($form->get('btnEliminarLLamadas')->isClicked()) {
                $arrDetallesSeleccionados = $request->request->get('ChkSeleccionar');
                $em->getRepository(SoporteLLamada::class)->eliminar($arrDetallesSeleccionados);
            }
        }
        $arArchivos = $em->getRepository(Archivo::class)->lista("soporte", $id);
        $arLlamadas = $em->getRepository(SoporteLLamada::class)->lista($id);
        return $this->render('Soporte/Soporte/detalle.html.twig', [
            'arSoporte' => $arSoporte,
            'arArchivos' => $arArchivos,
            'arLlamadas' => $arLlamadas,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/soporte/soporte/solucion/{id}", name="soporte_soporte_solucion")
     */
    public function solucion(Request $request, Dubnio $correo, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arSoporte = $em->getRepository(Soporte::class)->find($id);
        $form = $this->createForm(SoporteSolucionType::class, $arSoporte);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arSoporte = $form->getData();
                $arSoporte->setFechaSolucion(new \DateTime('now'));
                $arSoporte->setEstadoSolucionado(1);
                $em->persist($arSoporte);
                $em->flush();
                if ($arSoporte->getCorreo()) {
                    $respuesta = $correo->enviarCorreo($arSoporte->getCorreo(), 'Atencion a solicitud de soporte' . ' - ' . $arSoporte->getCodigoSoportePk(),
                        $this->renderView(
                            'Soporte/Soporte/correoSolucion.html.twig',
                            array('arSoporte' => $arSoporte)
                        ));
                }

                echo "<script type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        $bloqueado = false;
        $respuesta = $correo->bloqueo($arSoporte->getCorreo());
        if($respuesta) {
            if($respuesta->error == false) {
                $bloqueado = $respuesta->bloqueado;
            }
        }
        if($bloqueado) {
            Mensajes::error("El correo {$arSoporte->getCorreo()} electronico esta bloqueado");
        } else {
            Mensajes::info("Correo {$arSoporte->getCorreo()} habilitado para envio de la respuesta");
        }
        return $this->render('Soporte/Soporte/solucion.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/soporte/soporte/llamada/{codigoSoporte}/{id}", name="soporte_soporte_llamada")
     */
    public function llamada(Request $request, $codigoSoporte, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arSoporte = $em->getRepository(Soporte::class)->find($codigoSoporte);
        $arSoporteLLamada = new SoporteLLamada();
        if($id != 0){
            $arSoporteLLamada = $em->getRepository(SoporteLLamada::class)->find($id);
        } else {
            $arSoporteLLamada->setSoporteRel($arSoporte);
            $arSoporteLLamada->setFecha(new \DateTime('now'));
            $arSoporteLLamada->setFechaLLamada(new \DateTime('now'));
        }
        $form = $this->createForm(SoporteLLamadaType::class, $arSoporteLLamada);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arCaso = $form->getData();
                $em->persist($arCaso);
                $em->flush();
                echo "<script type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        return $this->render('Soporte/Soporte/llamada.html.twig', [
            '$arSoporteLLamada' => $arSoporteLLamada,
            'form' => $form->createView()
        ]);
    }
}
