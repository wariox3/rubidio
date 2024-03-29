<?php

namespace App\Controller\Admin;

use App\Entity\ContratoModulo;
use App\Entity\ContratoTipo;
use App\Entity\Requisito;
use App\Form\Type\ContratoImplementacionType;
use App\Formatos\FormatoContrato2;
use App\Entity\Cliente;
use App\Entity\Contacto;
use App\Entity\Contrato;
use App\Form\Type\ClienteType;
use App\Form\Type\ContactoType;
use App\Form\Type\ContratoType;
use App\Utilidades\DomPdf;
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
            ->add('btnRequisito', SubmitType::class, ['label' => 'Imprimir requisitos', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnEliminar')->isClicked()) {
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                $em->getRepository(Contacto::class)-> eliminar($arrSeleccionados);
            }
            if ($form->get('btnRequisito')->isClicked()) {
                $arRequisitos = $em->getRepository(Requisito::class)->imprimirLista();
                $html = $this->renderView('Admin/Cliente/formatoRequisitos.html.twig', [
                    'arRequisitos' => $arRequisitos,
//                    'arrContratosModulos' => $arrContratosModulos
                ]);
                $domPdf = new DomPdf();
                $domPdf->generarPdf($html, "Requisitos");;
            }
            if ($request->request->get('OpImprimir')) {
                $codigo = $request->request->get('OpImprimir');
                $arContratoImprimir = $em->getRepository(Contrato::class)->imprimir($codigo);
                if($arContratoImprimir) {
                    if($arContratoImprimir['codigoContratoTipoFk'] == "ARR") {
                        $html = $this->renderView('Admin/Cliente/formatoContrato.html.twig', ['arContrato' => $arContratoImprimir]);
                        $domPdf = new DomPdf();
                        $domPdf->generarPdf($html, "contratoArrendamiento{$codigo}");
                    } else {
                        $arrContratosModulos = $em->getRepository(ContratoModulo::class)->contratoImprimir($codigo);
                        $html = $this->renderView('Admin/Cliente/formatoContratoImplementacion.html.twig', [
                            'arContrato' => $arContratoImprimir,
                            'arrContratosModulos' => $arrContratosModulos]);
                        $domPdf = new DomPdf();
                        $domPdf->generarPdf($html, "contratoImplementacion{$codigo}");
                    }

                }
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
     * @Route("/admin/cliente/contacto/nuevo/{codigoClinete}/{id}", name="admin_cliente_contacto_nuevo")
     */
    public function contactoNuevo(Request $request, $codigoClinete, $id)
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
     * @Route("/admin/cliente/contrato/nuevo/{codigoCliente}/{tipo}/{id}", name="admin_cliente_contrato_nuevo")
     */
    public function contratoNuevo(Request $request, $codigoCliente, $tipo, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arContrato = $em->getRepository(Contrato::class)->find($id);
        if ($arContrato == null) {
            $arContratoTipo = $em->getRepository(ContratoTipo::class)->find($tipo);
            $arCliente = $em->getRepository(Cliente::class)->find($codigoCliente);
            $arContrato = new Contrato();
            $arContrato->setClienteRel($arCliente);
            $arContrato->setContratoTipoRel($arContratoTipo);
        }
        if($tipo == "ARR") {
            $form = $this->createForm(ContratoType::class, $arContrato);
        } else {
            $form = $this->createForm(ContratoImplementacionType::class, $arContrato);
        }
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arContrato = $form->getData();
                $em->persist($arContrato);
                $em->flush();
                echo "<script type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        if($tipo == "ARR") {
            return $this->render('Admin/Cliente/contratoNuevo.html.twig', [
                'arContrato' => $arContrato,
                'form' => $form->createView()
            ]);
        } else {
            return $this->render('Admin/Cliente/contratoNuevoImplementacion.html.twig', [
                'arContrato' => $arContrato,
                'form' => $form->createView()
            ]);
        }

    }

}