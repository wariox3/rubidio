<?php

namespace App\Controller\Cliente;

use App\Entity\ImplementacionDetalle;
use App\Entity\Implementacion;
use App\Form\Type\ImplementacionDetalleClienteType;
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
    public function lista(Request $request,  PaginatorInterface $paginator) {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $arrModulo = [
            'TODOS' => '',
            'Cartera' => 'CAR',
            'CRM' => 'CRM',
            'Financiero' => 'FIN',
            'General'=>'GEN',
            'Inventario'=>'INV',
            'Juridico'=>'JUR',
            'RHumano'=>'RHU',
            'Tesoreria'=>'TES',
            'Turnos'=>'TUR'];
        $form = $this->createFormBuilder()
            ->add('modulo', ChoiceType::class, ['choices' => $arrModulo, 'data' => $session->get('filtroImplementacionModulo'), 'required' => false])
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
        $arImplementacion = $em->getRepository(Implementacion::class)->findOneBy(['codigoClienteFk' => $this->getUser()->getCodigoClienteFk()]);
        $arImplementaciones = $paginator->paginate($em->getRepository(Implementacion::class)->listaCliente($this->getUser()->getCodigoClienteFk()), $request->query->getInt('page', 1), 500);
        return $this->render('Cliente/Implementacion/lista.html.twig', [
            'arImplementacion' => $arImplementacion,
            'arImplementacionDetalles' => $arImplementaciones,
            'form' => $form->createView()
        ]);
    }


}
