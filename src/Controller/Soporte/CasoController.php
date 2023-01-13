<?php

namespace App\Controller\Soporte;
use App\Entity\Caso;
use App\Entity\CasoEscalado;
use App\Entity\CasoGestion;
use App\Entity\CasoRespuesta;
use App\Entity\CasoTipo;
use App\Entity\Cliente;
use App\Entity\Tarea;
use App\Entity\Usuario;
use App\Form\Type\CasoEditarAtenderType;
use App\Form\Type\CasoEditarType;
use App\Form\Type\CasoEscaladoType;
use App\Form\Type\CasoGestionType;
use App\Form\Type\CasoRespuestaType;
use App\Form\Type\CasoTareaType;
use App\Utilidades\Dubnio;
use App\Utilidades\Mensajes;
use Doctrine\ORM\EntityRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
                return $this->redirect($this->generateUrl('soporte_caso_lista'));
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
    public function lista(Request $request,  PaginatorInterface $paginator, Dubnio $dubnio)
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
            $arrayPropiedadesCliente['data'] = $em->getReference(Cliente::class, $session->get('filtroCasoCodigoCliente'));
        }
        if ($session->get('filtroCasoEstadoCerrado') == null) {
            $session->set('filtroCasoEstadoCerrado', 0);
        }
        if ($session->get('filtroCasoEstadoDesarrollo') == null) {
            $session->set('filtroCasoEstadoDesarrollo', 0);
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
            ->add('usuarioDestino', EntityType::class, [
                'class' => Usuario::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.soporte = 1')
                        ->orderBy('u.nombres', 'ASC');
                },
                'choice_label' => function ($er) {
                    $campo = $er->getNombres() . ' ' . $er->getApellidos();
                    return $campo;
                },
                'placeholder' => 'TODOS',
                'required' => false,
                'attr' => ['class' => 'to-select-2'],
            ])
            ->add('codigoCaso', TextType::class, ['data' => $session->get('filtroCodigoCaso'), 'required' => false])
            ->add('estadoDesarrollo', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroCasoEstadoDesarrollo'), 'required' => false])
            ->add('estadoEscalado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroCasoEstadoEscalado'), 'required' => false])
            ->add('estadoRespuesta', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroCasoEstadoRespuesta'), 'required' => false])
            ->add('estadoCerrado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroCasoEstadoCerrado'), 'required' => false])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroCodigoCaso', $form->get('codigoCaso')->getData());
                $session->set('filtroCasoEstadoRespuesta', $form->get('estadoRespuesta')->getData());
                $session->set('filtroCasoEstadoDesarrollo', $form->get('estadoDesarrollo')->getData());
                $session->set('filtroCasoEstadoEscalado', $form->get('estadoEscalado')->getData());
                $session->set('filtroCasoEstadoCerrado', $form->get('estadoCerrado')->getData());
                $arUsuario = $form->get('usuarioDestino')->getData();
                if ($arUsuario) {
                    $session->set('filtroCasoUsuario', $arUsuario->getCodigoUsuarioPk());
                } else {
                    $session->set('filtroCasoUsuario', null);
                }
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
                        $arCaso->setFechaAtendido(new \DateTime('now'));
                        if(!$arCaso->getUsuarioRel()) {
                            $arCaso->setUsuarioRel($em->getReference(Usuario::class, $this->getUser()->getUsername()));
                        }
                        $em->persist($arCaso);
                        $em->flush();
                        if (strlen($arCaso->getTelefono()) == 10) {
                            $arrMensajes[] = [
                                "numero" => $arCaso->getTelefono(),
                                "soporte" => $arCaso->getCodigoCasoPk(),
                                "mensaje" => "Soporte técnico Semántica Digital, estamos atendiendo su caso, uno de nuestros consultores se pondrá en contacto",
                                "modelo" => "Soporte",
                                "codigoDocumento" => $arCaso->getCodigoCasoPk()
                            ];
                            $dubnio->sms($arrMensajes);
                        }
                    } else {
                        Mensajes::error("Debe asignarle un cliente antes de atender");
                    }
                }
            }
        }
        $arCasosAtender = $em->getRepository(Caso::class)->listaAtender();
        $arCasos = $paginator->paginate($em->getRepository(Caso::class)->lista(), $request->query->getInt('page', 1), 50);
        return $this->render('Soporte/Caso/lista.html.twig', [
            'arCasos' => $arCasos,
            'arCasosAtender' => $arCasosAtender,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/soporte/caso/detalle/{id}", name="soporte_caso_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arCaso = $em->getRepository(Caso::class)->find($id);
        $arrBtnCerrar = ['label' => 'Cerrar', 'disabled' => false];
        if ($arCaso->isEstadoCerrado()) {
            $arrBtnCerrar['disabled'] = true;
        }
        $form = $this->createFormBuilder()
            ->add('btnEliminarGestion', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnCerrar', SubmitType::class, $arrBtnCerrar)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnEliminarGestion')->isClicked()) {
                $arrDetallesSeleccionados = $request->request->get('ChkSeleccionar');
                $em->getRepository(CasoGestion::class)->eliminar($arrDetallesSeleccionados);
            }
            if ($form->get('btnCerrar')->isClicked()) {
                if($arCaso->isEstadoAtendido()) {
                    $arCaso->setEstadoCerrado(1);
                    $arCaso->setFechaCerrado(new \DateTime('now'));
                    $em->persist($arCaso);
                    $em->flush();
                } else {
                    Mensajes::error('El caso no esta atendido');
                }
            }
            return $this->redirect($this->generateUrl('soporte_caso_detalle', ['id' => $id]));
        }
        $arTareas = $em->getRepository(Tarea::class)->caso($id);
        $arGestiones = $em->getRepository(CasoGestion::class)->lista($id);
        $arRespuestas = $em->getRepository(CasoRespuesta::class)->lista($id);
        $arEscalados = $em->getRepository(CasoEscalado::class)->lista($id);
        return $this->render('Soporte/Caso/detalle.html.twig', [
            'arCaso' => $arCaso,
            'arTareas' => $arTareas,
            'arGestiones' => $arGestiones,
            'arRespuestas' => $arRespuestas,
            'arEscalados' => $arEscalados,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/soporte/caso/atender/{id}", name="soporte_caso_atender")
     */
    public function atender(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arCaso = new Caso();
        if ($id != 0) {
            $arCaso = $em->getRepository(Caso::class)->find($id);
        }
        $form = $this->createForm(CasoEditarAtenderType::class, $arCaso);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arCaso = $form->getData();
                $em->persist($arCaso);
                $em->flush();
                return $this->redirect($this->generateUrl('soporte_caso_lista'));
            }
        }
        return $this->render('Soporte/Caso/atender.html.twig', [
            'arCaso' => $arCaso,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/soporte/caso/gestion/{codigoCaso}/{id}", name="soporte_caso_gestion")
     */
    public function gestion(Request $request, $codigoCaso, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arCaso = $em->getRepository(Caso::class)->find($codigoCaso);
        $arCasoGestion = new CasoGestion();
        if($id != 0){
            $arCasoGestion = $em->getRepository(CasoGestion::class)->find($id);
        } else {
            $arCasoGestion->setCasoRel($arCaso);
            $arCasoGestion->setFecha(new \DateTime('now'));
            $arCasoGestion->setFechaGestion(new \DateTime('now'));
        }
        $form = $this->createForm(CasoGestionType::class, $arCasoGestion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arCasoGestion = $form->getData();
                $arCasoGestion->setUsuarioRel($em->getReference(Usuario::class, $this->getUser()->getUsername()));
                $em->persist($arCasoGestion);
                $em->flush();
                echo "<script type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        return $this->render('Soporte/Caso/gestion.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/soporte/caso/respuesta/{codigoCaso}/{id}", name="soporte_caso_respuesta")
     */
    public function respuesta(Request $request, Dubnio $dubnio, $codigoCaso, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arCaso = $em->getRepository(Caso::class)->find($codigoCaso);
        $arCasoRespuesta = new CasoRespuesta();
        if($id != 0){
            $arCasoRespuesta = $em->getRepository(CasoRespuesta::class)->find($id);
        } else {
            $arCasoRespuesta->setUsuarioRel($em->getReference(Usuario::class, $this->getUser()->getUsername()));
            $arCasoRespuesta->setCasoRel($arCaso);
            $arCasoRespuesta->setFecha(new \DateTime('now'));
        }
        $form = $this->createForm(CasoRespuestaType::class, $arCasoRespuesta);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arCasoRespuesta = $form->getData();
                $em->persist($arCasoRespuesta);
                if($id == 0 || $id == "0"){
                    $arCaso->setEstadoRespuesta(1);
                }
                $em->flush();
                $respuesta = $dubnio->enviarCorreo($arCaso->getCorreo(), 'Respuesta caso' . ' - ' . $arCaso->getCodigoCasoPk(),
                    $this->renderView(
                        'Soporte/Caso/correoRespuesta.html.twig', [
                            'arCaso' => $arCaso,
                            'usuarioRespuesta' => $this->getUser()->getNombres() . $this->getUser()->getApellidos(),
                            'respuesta' => $arCasoRespuesta->getComentario()
                            ]));
                if (strlen($arCaso->getTelefono()) == 10) {
                    $arrMensajes[] = [
                        "numero" => $arCaso->getTelefono(),
                        "soporte" => $arCaso->getCodigoCasoPk(),
                        "mensaje" => "Semántica Digital, uno de nuestros agentes le a dado respuesta a su caso: {$arCaso->getCodigoCasoPk()}, consulte la mesa de ayuda para verificar la respuesta",
                        "modelo" => "Soporte",
                        "codigoDocumento" => $arCaso->getCodigoCasoPk()
                    ];
                    $dubnio->sms($arrMensajes);
                }
                echo "<script type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        $bloqueado = false;
        $respuesta = $dubnio->bloqueo($arCaso->getCorreo());
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
        return $this->render('Soporte/Caso/respuesta.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/soporte/caso/escalado/{codigoCaso}/{id}", name="soporte_caso_escalado")
     */
    public function escalado(Request $request, Dubnio $dubnio, $codigoCaso, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arCaso = $em->getRepository(Caso::class)->find($codigoCaso);
        $arCasoEscalado = new CasoEscalado();
        if($id != 0){
            $arCasoEscalado = $em->getRepository(CasoEscalado::class)->find($id);
        } else {
            $arCasoEscalado->setUsuarioRel($em->getReference(Usuario::class, $this->getUser()->getUsername()));
            $arCasoEscalado->setCasoRel($arCaso);
            $arCasoEscalado->setFecha(new \DateTime('now'));
        }
        $form = $this->createForm(CasoEscaladoType::class, $arCasoEscalado);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arCasoEscalado = $form->getData();
                $em->persist($arCasoEscalado);
                $arCaso->setUsuarioRel($arCasoEscalado->getUsuarioDestinoRel());
                $arCaso->setEstadoEscalado(1);
                $em->flush();
                if($arCasoEscalado->getUsuarioDestinoRel()->getCorreo()) {
                    $respuesta = $dubnio->enviarCorreo($arCasoEscalado->getUsuarioDestinoRel()->getCorreo(), 'Caso escalado ' . ' - ' . $arCaso->getCodigoCasoPk(),
                        $this->renderView(
                            'Soporte/Caso/correoEscalado.html.twig', [
                        'arCaso' => $arCaso,
                        'usuario' => $arCasoEscalado->getUsuarioDestinoRel()->getCodigoUsuarioPk(),
                        'usuarioEmisor' => $arCasoEscalado->getUsuarioRel()->getCodigoUsuarioPk(),
                        'usuarioNombre' => $arCasoEscalado->getUsuarioDestinoRel()->getNombres() . $arCasoEscalado->getUsuarioDestinoRel()->getApellidos(),
                        'comentario' => $arCasoEscalado->getComentario()
                        ]));
                }
                echo "<script type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        return $this->render('Soporte/Caso/escalado.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/soporte/caso/tarea/{codigoCaso}/{id}", name="soporte_caso_tarea")
     */
    public function tarea(Request $request, Dubnio $dubnio, $codigoCaso, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arCaso = $em->getRepository(Caso::class)->find($codigoCaso);
        $arCasoTarea = new Tarea();
        if($id != 0){
            $arCasoTarea = $em->getRepository(Tarea::class)->find($id);
        } else {
            $arCasoTarea->setCasoRel($arCaso);
            $arCasoTarea->setFecha(new \DateTime('now'));
        }
        $form = $this->createForm(CasoTareaType::class, $arCasoTarea);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arCasoTarea = $form->getData();
                $em->persist($arCasoTarea);
                $em->flush();
                echo "<script type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        return $this->render('Soporte/Caso/tarea.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
