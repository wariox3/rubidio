<?php

namespace App\Controller\Operacion;

use App\Entity\Cliente;
use App\Entity\Funcionalidad;
use App\Entity\Implementacion;
use App\Entity\ImplementacionDetalle;
use App\Entity\Modulo;
use App\Entity\Requisito;
use App\Form\Type\ImplementacionDetalleType;
use App\Form\Type\ImplementacionType;
use App\Formatos\FormatoActaTerminacion;
use App\Formatos\FormatoPlanTrabajo;
use App\Utilidades\Mensajes;
use Doctrine\ORM\EntityRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
        $session = new Session();
        if ($session->get('filtroImplementacionEstadoTerminado') == null) {
            $session->set('filtroImplementacionEstadoTerminado', 0);
        }
        $form = $this->createFormBuilder()
            ->add('clienteRel', EntityType::class, array(
                'class' => Cliente::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.nombreCorto', 'ASC');
                },
                'required' => false,
                'choice_label' => 'nombreCorto',
                'placeholder' => 'TODOS',
            ))
            ->add('estadoTerminado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroImplementacionEstadoTerminado'), 'required' => false])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-danger']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnEliminar')->isClicked()) {
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                if ($arrSeleccionados) {
                    foreach ($arrSeleccionados as $codigo) {
                        $arImplementacionDetalles = $em->getRepository(ImplementacionDetalle::class)->findBy(['codigoImplementacionFk' => $codigo]);
                        if(!$arImplementacionDetalles) {
                            $arImplementacion = $em->getRepository(Implementacion::class)->find($codigo);
                            if ($arImplementacion) {
                                $em->remove($arImplementacion);
                            }
                        } else {
                            Mensajes::error("La implementacion {$codigo} tiene detalles, debe eliminarlos primero");
                            break;
                        }
                    }
                    $em->flush();
                }
            }
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroImplementacionEstadoTerminado', $form->get('estadoTerminado')->getData());
                $arCliente = $form->get('clienteRel')->getData();
                if ($arCliente) {
                    $session->set('filtroImplementacionCodigoCliente', $arCliente->getCodigoClientePk());
                } else {
                    $session->set('filtroImplementacionCodigoCliente', null);
                }
            }
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
        if ($id != 0) {
            $arImplementacion = $em->getRepository(Implementacion::class)->find($id);
        }
        $form = $this->createForm(ImplementacionType::class, $arImplementacion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arImplementacion = $form->getData();
                $em->persist($arImplementacion);
                $em->flush();
                echo "<script type='text/javascript'>window.close();window.opener.location.reload();</script>";
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
    public function detalle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arImplementacion = $em->getRepository(Implementacion::class)->find($id);
        $session = new Session();
        $arrBtnTerminar = ['label' => 'Terminar', 'disabled' => false];
        $arrBtnEliminar = ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-danger']];
        if ($arImplementacion->isEstadoTerminado()) {
            $arrBtnTerminar['disabled'] = true;
            $arrBtnEliminar['disabled'] = true;
        }
        $form = $this->createFormBuilder()
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
            ->add('btnTerminar', SubmitType::class, $arrBtnTerminar)
            ->add('estadoCapacitado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroImplementacionEstadoCapacitado'), 'required' => false])
            ->add('estadoTerminado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroImplementacionEstadoTerminado'), 'required' => false])
            ->add('btnFiltrar', SubmitType::class, array('label' => 'Filtrar'))
            ->add('btnEliminar', SubmitType::class, $arrBtnEliminar)
            ->getForm();
        $raw = [];
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $raw['filtros'] = $this->filtrosDetalle($form);
            }
            if ($form->get('btnTerminar')->isClicked()) {
                $em->getRepository(Implementacion::class)->terminar($arImplementacion);
                return $this->redirect($this->generateUrl('operacion_implementacion_detalle', ['id' => $id]));
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
        $arImplementacionDetalle = $em->getRepository(ImplementacionDetalle::class)->listaDetalle($id, $raw);
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
        $form = $this->createForm(ImplementacionDetalleType::class, $arImplementacionDetalle);
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
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnGuardar', SubmitType::class, array('label' => 'Guardar'))
            ->getForm();
        $raw = [];
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $raw['filtros'] = $this->filtros($form);
            }
            if ($form->get('btnGuardar')->isClicked()) {
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                foreach ($arrSeleccionados as $codigo) {
                    $arRequisito = $em->getRepository(Requisito::class)->find($codigo);
                    $arImplementacionDetalle = new ImplementacionDetalle();
                    $arImplementacionDetalle->setImplementacionRel($arImplementacion);
                    $arImplementacionDetalle->setRequisitoRel($arRequisito);
                    $arImplementacionDetalle->setModuloRel($em->getReference(Modulo::class, $arRequisito->getCodigoModuloFk()));
                    $em->persist($arImplementacionDetalle);
                }
                $em->flush();
                echo "<script type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }

        }
        $arRequisitos = $em->getRepository(Requisito::class)->lista($raw);
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
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnGuardar', SubmitType::class, array('label' => 'Guardar'))
            ->getForm();
        $raw = [];
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $raw['filtros'] = $this->filtros($form);
            }
            if ($form->get('btnGuardar')->isClicked()) {
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                foreach ($arrSeleccionados as $codigo) {
                    $arFuncionalidad = $em->getRepository(Funcionalidad::class)->find($codigo);
                    $arImplementacionDetalle = new ImplementacionDetalle();
                    $arImplementacionDetalle->setImplementacionRel($arImplementacion);
                    $arImplementacionDetalle->setFuncionalidadRel($arFuncionalidad);
                    $arImplementacionDetalle->setModuloRel($em->getReference(Modulo::class, $arFuncionalidad->getCodigoModuloFk()));
                    $em->persist($arImplementacionDetalle);
                }
                $em->flush();
                echo "<script type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        $arFuncionalidades = $em->getRepository(Funcionalidad::class)->lista($raw);
        return $this->render('Operacion/Implementacion/detalleNuevoFuncionalidad.html.twig', [
            'arFuncionalidades' => $arFuncionalidades,
            'form' => $form->createView()
        ]);
    }

    public function filtros($form) {
        $filtro = [
        ];
        $arModulo = $form->get('moduloRel')->getData();

        if ($arModulo) {
            $filtro['codigoModulo'] = $arModulo->getCodigoModuloPk();
        } else {
            $filtro['codigoModulo'] = null;
        }
        return $filtro;

    }

    public function filtrosDetalle($form) {
        $filtro = [
            'estadoCapacitado' => $form->get('estadoCapacitado')->getData(),
            'estadoTerminado' => $form->get('estadoTerminado')->getData()
        ];
        $arModulo = $form->get('moduloRel')->getData();

        if ($arModulo) {
            $filtro['codigoModulo'] = $arModulo->getCodigoModuloPk();
        } else {
            $filtro['codigoModulo'] = null;
        }
        return $filtro;

    }
}
