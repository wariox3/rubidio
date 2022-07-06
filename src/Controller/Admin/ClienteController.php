<?php

namespace App\Controller\Admin;

use App\Entity\Cliente;
use App\Form\Type\ClienteType;
use Doctrine\ORM\EntityRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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
//            ->add('btnVerificar', SubmitType::class, $arrBtnVerificar)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('btnVerificar')->isClicked()){
                $arCliente->setEstadoVerificado(1);
                $em->persist($arCliente);
                $em->flush();
            }
            return $this->redirect($this->generateUrl('admin_tarea_detalle', ['id' => $id]));
        }
        return $this->render('Admin/Cliente/detalle.html.twig', [
            'arCliente' => $arCliente,
            'form' => $form->createView()
        ]);
    }


}