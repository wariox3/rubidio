<?php

namespace App\Controller\Cliente;

use App\Entity\ImplementacionDetalle;
use App\Entity\Implementacion;
use App\Entity\Modulo;
use App\Form\Type\ImplementacionDetalleClienteType;
use App\Form\Type\ImplementacionDetalleType;
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
     * @Route("/cliente/implementacion/nuevo/{id}", name="cliente_implementacion_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arImplementacionDetalle = $em->getRepository(ImplementacionDetalle::class)->find($id);
        $form = $this->createForm(ImplementacionDetalleClienteType::class, $arImplementacionDetalle);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arImplementacionDetalle = $form->getData();
                $em->persist($arImplementacionDetalle);
                $em->flush();
                echo "<script type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        return $this->render('Cliente/Implementacion/nuevo.html.twig', [
            'arImplementacionDetalle' => $arImplementacionDetalle,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/cliente/implementacion/lista", name="cliente_implementacion_lista")
     */
    public function lista(Request $request) {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();

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
            ->add('estadoCapacitado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroImplementacionEstadoCapacitado'), 'required' => false])
            ->add('estadoTerminado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroImplementacionEstadoTerminado'), 'required' => false])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroImplementacionEstadoCapacitado', $form->get('estadoCapacitado')->getData());
                $session->set('filtroImplementacionEstadoTerminado', $form->get('estadoTerminado')->getData());
                $session->set('filtroImplementacionModulo', $form->get('modulo')->getData());
            }
        }
        $arImplementaciones = $em->getRepository(Implementacion::class)->listaCliente($this->getUser()->getCodigoClienteFk());
        $arImplementacionesDetalles = $em->getRepository(ImplementacionDetalle::class)->listaCliente($this->getUser()->getCodigoClienteFk());
        return $this->render('Cliente/Implementacion/lista.html.twig', [
            'arImplementaciones' => $arImplementaciones,
            'arImplementacionDetalles' => $arImplementacionesDetalles,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/cliente/implementacion/detalle/nuevo/{id}", name="cliente_implementacion_detalle_nuevo")
     */
    public function detalleNuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arImplementacionDetalle = $em->getRepository(ImplementacionDetalle::class)->find($id);
        $form = $this->createForm(ImplementacionDetalleClienteType::class, $arImplementacionDetalle);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arImplementacionDetalle = $form->getData();
                $em->persist($arImplementacionDetalle);
                $em->flush();
                echo "<script type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        return $this->render('Cliente/Implementacion/detalleNuevo.html.twig', [
            'arImplementacionDetalle' => $arImplementacionDetalle,
            'form' => $form->createView()
        ]);
    }

}
