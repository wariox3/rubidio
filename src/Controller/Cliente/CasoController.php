<?php

namespace App\Controller\Cliente;

use App\Entity\Archivo;
use App\Entity\Caso;
use App\Entity\CasoGestion;
use App\Entity\CasoRespuesta;
use App\Entity\Usuario;
use App\Form\Type\CasoPostergadoType;
use App\Form\Type\CasoRespuestaType;
use App\Form\Type\CasoType;
use App\Utilidades\Dubnio;
use App\Utilidades\Mensajes;
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
            ->add('estadoCerrado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => 0, 'required' => false])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroCasoEstadoAtendido', $form->get('estadoAtendido')->getData());
                $session->set('filtroCasoEstadoDesarrollo', $form->get('estadoDesarrollo')->getData());
                $session->set('filtroCasoEstadoEscalado', $form->get('estadoEscalado')->getData());
                $session->set('filtroCasoEstadoCerrado', $form->get('estadoCerrado')->getData());
            }
        }
        $session->set('filtroCasoEstadoCerrado', $form->get('estadoCerrado')->getData());
        $arCasos = $paginator->paginate($em->getRepository(Caso::class)->listaCliente($this->getUser()->getCodigoClienteFk()), $request->query->getInt('page', 1), 500);
        return $this->render('Cliente/Caso/lista.html.twig', [
            'arCasos' => $arCasos,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/cliente/caso/detalle/{id}", name="cliente_caso_detalle")
     */
    public function detalle(Request $request, $id)
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
        $arRespuestas = $em->getRepository(CasoRespuesta::class)->lista($id);
        $arGestiones = $em->getRepository(CasoGestion::class)->lista($id);
        return $this->render('Cliente/Caso/detalle.html.twig', [
            'arCaso' => $arCaso,
            'arArchivos' => $arArchivos,
            'arGestiones' => $arGestiones,
            'arRespuestas' => $arRespuestas,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/cliente/caso/respuesta/{codigoCaso}/{id}", name="cliente_caso_respuesta")
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
            $arCasoRespuesta->setCliente(1);
        }
        $form = $this->createForm(CasoRespuestaType::class, $arCasoRespuesta);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arCasoRespuesta = $form->getData();
                $em->persist($arCasoRespuesta);
                if($id == 0 || $id == "0"){
                    $arCaso->setEstadoRespuesta(0);
                }
                $em->flush();
                echo "<script type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        return $this->render('Soporte/Caso/respuesta.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
