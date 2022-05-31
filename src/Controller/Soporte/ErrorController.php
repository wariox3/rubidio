<?php

namespace App\Controller\Soporte;

use App\Entity\Cliente;
use App\Entity\Error;
use App\Entity\Obligacion;
use App\Entity\Vigencia;
use App\Form\Type\ObligacionType;
use App\Form\Type\VigenciaType;
use App\Utilidades\Dubnio;
use Doctrine\ORM\EntityRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class ErrorController extends AbstractController
{

    /**
     * @Route("/soporte/error/lista", name="soporte_error_lista")
     */
    public function lista(Request $request, Dubnio $dubnio, PaginatorInterface $paginator)
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $arrayPropiedadesUsuario = array(
            'class' => 'App\Entity\Usuario',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->orderBy('u.codigoUsuarioPk', 'ASC');
            },
            'choice_label' => 'codigoUsuarioPk',
            'required' => false,
            'placeholder' => "TODOS",
        );
        $arrayPropiedadesCliente = array(
            'class' => Cliente::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->orderBy('c.codigoClientePk', 'ASC');
            },
            'choice_label' => 'nombreCorto',
            'required' => false,
            'placeholder' => "TODOS",
        );
        if ($session->get('filtroErrorCodigoUsuario')) {
            $arrayPropiedadesUsuario['data'] = $em->getReference("App\Entity\Usuario", $session->get('filtroErrorCodigoUsuario'));
        }
        if ($session->get('filtroErrorCodigoCliente')) {
            $arrayPropiedadesCliente['data'] = $em->getReference("App\Entity\Cliente", $session->get('filtroErrorCodigoCliente'));
        }

        if ($session->get('filtroErrorEstadoSolucionado') == null) {
            $session->set('filtroErrorEstadoSolucionado', 0);
        }
        $form = $this->createFormBuilder()
            ->add('usuarioRel', EntityType::class, $arrayPropiedadesUsuario)
            ->add('clienteRel', EntityType::class, $arrayPropiedadesCliente)
            ->add('estadoAtendido', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroErrorEstadoAtendido'), 'required' => false])
            ->add('estadoSolucionado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroErrorEstadoSolucionado'), 'required' => false])
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-danger']])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $arUsuario = $form->get('usuarioRel')->getData();
                if ($arUsuario) {
                    $session->set('filtroErrorCodigoUsuario', $arUsuario->getCodigoUsuarioPK());
                } else {
                    $session->set('filtroErrorCodigoUsuario', null);
                }
                $arCliente = $form->get('clienteRel')->getData();
                if ($arCliente) {
                    $session->set('filtroErrorCodigoCliente', $arCliente->getCodigoClientePK());
                } else {
                    $session->set('filtroErrorCodigoCliente', null);
                }
                $session->set('filtroErrorEstadoAtendido', $form->get('estadoAtendido')->getData());
                $session->set('filtroErrorEstadoSolucionado', $form->get('estadoSolucionado')->getData());
            }
            if ($form->get('btnEliminar')->isClicked()) {
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                if ($arrSeleccionados) {
                    foreach ($arrSeleccionados as $codigo) {
                        $arError = $em->getRepository(Error::class)->find($codigo);
                        if ($arError) {
                            $em->remove($arError);
                        }
                    }
                    $em->flush();
                }
            }
            if ($request->request->get('OpAtender')) {
                $codigo = $request->request->get('OpAtender');
                $arError = $em->getRepository(Error::class)->find($codigo);
                $arError->setEstadoAtendido(1);
                $em->persist($arError);
                $em->flush();
            }
            if ($request->request->get('OpSolucionar')) {
                $codigo = $request->request->get('OpSolucionar');
                $arError = $em->getRepository(Error::class)->find($codigo);
                $arError->setEstadoAtendido(1);
                $arError->setEstadoSolucionado(1);
                $em->persist($arError);
                $em->flush();
                if (filter_var($arError->getEmail(), FILTER_VALIDATE_EMAIL)) {
                    $html = $this->renderView('Utilidades/correoErrorCliente.html.twig', ['arError' => $arError]);
                    $dubnio->enviarCorreo("Hemos solucionado un error", $html, $arError->getEmail());
                }
            }
        }
        $arErrores = $paginator->paginate($em->getRepository(Error::class)->lista(), $request->query->getInt('page', 1), 50);
        return $this->render('Soporte/Error/lista.html.twig', [
            'arErrores' => $arErrores,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/soporte/error/detalle/{id}", name="soporte_error_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arError = $em->getRepository(Error::class)->find($id);

        $form = $this->createFormBuilder()
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('cliente_caso_detalle', ['id' => $id]));
        }
        $trazas = json_decode($arError->getTraza());
        return $this->render('Soporte/Error/detalle.html.twig', [
            'arError' => $arError,
            'trazas' => $trazas,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/soporte/error/asignar/{id}", name="soporte_error_asignar")
     */
    public function asignarUsuario(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arError = $em->getRepository(Error::class)->find($id);
        $arrayPropiedadesUsuario = array(
            'class' => 'App\Entity\Usuario',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->where('u.adicionarTarea = 1')
                    ->andWhere('u.estadoInactivo = 0')
                    ->orderBy('u.codigoUsuarioPk', 'ASC');
            },
            'choice_label' => 'codigoUsuarioPk',
            'required' => false,
            'empty_data' => "",
            'placeholder' => "TODOS",
            'data' => ""
        );
        $form = $this->createFormBuilder()
            ->add('usuarioRel', EntityType::class, $arrayPropiedadesUsuario)
            ->add('guardar', SubmitType::class, ['label' => 'Guardar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $arUsuario = $form->get('usuarioRel')->getData();
            $arError->setUsuarioSoluciona($arUsuario->getCodigoUsuarioPk());
            $em->persist($arError);
            $em->flush();
            echo "<script languaje='javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";
        }
        return $this->render('Soporte/Error/asignar.html.twig', [
            'arError' => $arError,
            'form' => $form->createView()
        ]);
    }

}
