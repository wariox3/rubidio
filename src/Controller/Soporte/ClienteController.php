<?php

namespace App\Controller\Soporte;

use App\Entity\Cliente;
use App\Form\Type\ClienteType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class ClienteController extends AbstractController
{
    /**
         * @Route("/soporte/cliente/lista", name="soporte_cliente_lista")
     */
    public function lista(Request $request,  PaginatorInterface $paginator) {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $arClientes = $paginator->paginate($em->getRepository(Cliente::class)->listaSoporte(), $request->query->getInt('page', 1), 100);
        return $this->render('Soporte/Cliente/lista.html.twig', [
            'arClientes' => $arClientes,
        ]);
    }

    /**
     * @Route("/soporte/cliente/nuevo/{id}", name="soporte_cliente_nuevo")
     */
    public function nuevo(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $arCliente = $em->getRepository(Cliente::class)->find($id);
        $form = $this->createForm(ClienteType::class, $arCliente);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arCliente = $form->getData();
                $em->persist($arCliente);
                $em->flush();
                return $this->redirect($this->generateUrl('soporte_cliente_lista'));
            }
        }
        return $this->render('Soporte/Cliente/nuevo.html.twig', [
            'arCliente' => $arCliente,
            'form' => $form->createView()
        ]);
    }
}