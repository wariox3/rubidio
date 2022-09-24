<?php

namespace App\Controller\Admin;

use App\Formatos\FormatoContrato2;
use App\Entity\Cliente;
use App\Entity\Contacto;
use App\Entity\Contrato;
use App\Form\Type\ClienteType;
use App\Form\Type\ContactoType;
use App\Form\Type\ContratoType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class ClienteController extends AbstractController
{
    /**
     * @Route("/admin/cliente/lista", name="admin_cliente_lista")
     */
    public function lista(Request $request,  PaginatorInterface $paginator) {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()
            ->add('nombre', TextType::class, ['data' => '','required' => false])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroClienteNombre', $form->get('nombre')->getData());
            }
        }
        $arClientes = $paginator->paginate($em->getRepository(Cliente::class)->listaAdministracion(), $request->query->getInt('page', 1), 500);
        return $this->render('Admin/Cliente/lista.html.twig', [
            'arClientes' => $arClientes,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/cliente/nuevo/{id}", name="admin_cliente_nuevo")
     */
    public function nuevo(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $arCliente = new Cliente();
        if ($id != 0) {
            $arCliente = $em->getRepository(Cliente::class)->find($id);
        }
        $form = $this->createForm(ClienteType::class, $arCliente);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arCliente = $form->getData();
                $em->persist($arCliente);
                $em->flush();
                return $this->redirect($this->generateUrl('admin_cliente_detalle', array('id' => $arCliente->getCodigoClientePk())));
            }
        }
        return $this->render('Admin/Cliente/nuevo.html.twig', [
            'arCliente' => $arCliente,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/cliente/detalle/{id}", name="admin_cliente_detalle")
     */
    public function detalle(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $arCliente = $em->getRepository(Cliente::class)->find($id);
        $form = $this->createFormBuilder()
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnEliminar')->isClicked()) {
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                $em->getRepository(Contacto::class)-> eliminar($arrSeleccionados);
            }
            if ($request->request->get('OpImprimir')) {
                $codigo = $request->request->get('OpImprimir');
//                $formato = new FormatoContrato();
//                $formato->Generar($em, $codigo);
                $formato = new FormatoContrato2();
                $formato->Generar($em, $codigo);

            }
        }
        $arContactos = $em->getRepository(Contacto::class)->lista($id);
        $arContratos= $em->getRepository(Contrato::class)->lista($id);
        return $this->render('Admin/Cliente/detalle.html.twig', [
            'arCliente' => $arCliente,
            'arContactos' => $arContactos,
            'arContratos' => $arContratos,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/cliente/contacto/nuevo/{codigoClinete}/{id}", name="admin_cliente_clienta_nuevo")
     */
    public function detalleNuevo(Request $request, $codigoClinete, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arContacto = $em->getRepository(Contacto::class)->find($id);
        $arCliente = $em->getRepository(Cliente::class)->find($codigoClinete);
        if ($arContacto == null) {
            $arContacto = new Contacto();
            $arContacto->setClienteRel($arCliente);
        }
        $form = $this->createForm(ContactoType::class, $arContacto);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arContacto = $form->getData();
                $em->persist($arContacto);
                $em->flush();
                echo "<script type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        return $this->render('Admin/Cliente/contactoNuevo.html.twig', [
            'arContacto' => $arContacto,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/cliente/contrato/nuevo/{codigoClinete}/{id}", name="admin_cliente_contrato_nuevo")
     */
    public function contratoNuevo(Request $request, $codigoClinete, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arContrato = $em->getRepository(Contrato::class)->find($id);
        $arCliente = $em->getRepository(Cliente::class)->find($codigoClinete);
        if ($arContrato == null) {
            $arContrato = new Contrato();
            $arContrato->setClienteRel($arCliente);
        }
        $form = $this->createForm(ContratoType::class, $arContrato);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arContrato = $form->getData();
                $em->persist($arContrato);
                $em->flush();
                echo "<script type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        return $this->render('Admin/Cliente/contratoNuevo.html.twig', [
            'arContrato' => $arContrato,
            'form' => $form->createView()
        ]);
    }

}