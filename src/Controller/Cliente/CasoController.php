<?php

namespace App\Controller\Cliente;

use App\Entity\Archivo;
use App\Entity\Caso;
use App\Form\Type\CasoPostergadoType;
use App\Form\Type\CasoType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class CasoController extends AbstractController
{

    /**
     * @Route("/cliente/caso/nuevo/{id}", name="cliente_caso_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arCaso = new Caso();
        if ($id != 0) {
            $arCaso = $em->getRepository(Caso::class)->find($id);
        } else {
            $arCaso->setContacto($this->getUser()->getNombres() . " " . $this->getUser()->getApellidos());
            $arCaso->setTelefono($this->getUser()->getTelefono());
            $arCaso->setCorreo($this->getUser()->getCorreo());
        }
        $form = $this->createForm(CasoType::class, $arCaso);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arCaso = $form->getData();
                if($id == 0) {
                    $arCaso->setClienteRel($this->getUser()->getClienteRel());
                    $arCaso->setFecha(new \DateTime('now'));
                }

                $em->persist($arCaso);
                $em->flush();
                return $this->render('Cliente/Caso/nuevoMensaje.html.twig', [
                ]);
            }
        }
        return $this->render('Cliente/Caso/nuevo.html.twig', [
            'arCaso' => $arCaso,
            'form' => $form->createView(),
            'clase' => array('clase' => 2, 'codigo' => $id),
        ]);
    }

    /**
     * @Route("/cliente/caso/lista", name="cliente_caso_lista")
     */
    public function lista(Request $request,  PaginatorInterface $paginator) {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()
            ->add('estadoAtendido', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroCasoEstadoAtendido'), 'required' => false])
            ->add('estadoDesarrollo', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroCasoEstadoDesarrollo'), 'required' => false])
            ->add('estadoEscalado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroCasoEstadoEscalado'), 'required' => false])
            ->add('estadoSolucionado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => 0, 'required' => false])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroCasoEstadoAtendido', $form->get('estadoAtendido')->getData());
                $session->set('filtroCasoEstadoDesarrollo', $form->get('estadoDesarrollo')->getData());
                $session->set('filtroCasoEstadoEscalado', $form->get('estadoEscalado')->getData());
                $session->set('filtroCasoEstadoSolucionado', $form->get('estadoSolucionado')->getData());
            }
        }
        $session->set('filtroCasoEstadoSolucionado', $form->get('estadoSolucionado')->getData());
        $arCasos = $paginator->paginate($em->getRepository(Caso::class)->listaCliente($this->getUser()->getCodigoClienteFk()), $request->query->getInt('page', 1), 500);
        return $this->render('Cliente/Caso/lista.html.twig', [
            'arCasos' => $arCasos,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/cliente/caso/detalle/{id}", name="cliente_caso_detalle")
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
        $arArchivos = $em->getRepository(Archivo::class)->lista(2, $id);
        return $this->render('Cliente/Caso/detalle.html.twig', [
            'arCaso' => $arCaso,
            'form' => $form->createView(),
            'arArchivos' => $arArchivos
        ]);
    }

    /**
     * @Route("/cliente/caso/postergado/{id}", name="cliente_caso_postergado")
     */
    public function postergado(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arCaso = new Caso();
        if ($id != 0) {
            $arCaso = $em->getRepository(Caso::class)->find($id);
        }
        $form = $this->createForm(CasoPostergadoType::class, $arCaso);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arCaso = $form->getData();
                $em->persist($arCaso);
                $em->flush();
                echo "<script languaje='javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        return $this->render('Cliente/Caso/postergado.html.twig', [
            'arCaso' => $arCaso,
            'form' => $form->createView()
        ]);
    }

}
