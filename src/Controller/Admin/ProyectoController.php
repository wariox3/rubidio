<?php

namespace App\Controller\Admin;


use App\Entity\Devolucion;
use App\Entity\Obligacion;
use App\Entity\Tarea;
use App\Entity\Vigencia;
use App\Entity\Proyecto;
use App\Form\Type\DevolucionType;
use App\Form\Type\ObligacionType;
use App\Form\Type\ProyectoType;
use App\Form\Type\VigenciaType;
use App\Utilidades\Mensajes;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use function PHPSTORM_META\type;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class ProyectoController extends AbstractController
{
    /**
     * @Route("/admin/proyecto/lista", name="admin_proyecto_lista")
     */
    public function lista(Request $request,  PaginatorInterface $paginator) {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        }
        $arProyectos = $paginator->paginate($em->getRepository(Proyecto::class)->lista(), $request->query->getInt('page', 1), 500);
        return $this->render('Admin/Proyecto/lista.html.twig', [
            'arProyectos' => $arProyectos,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/proyecto/detalle/{id}", name="admin_proyecto_detalle")
     */
    public function detalle(Request $request,  PaginatorInterface $paginator, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arProyecto = $em->getRepository(Proyecto::class)->find($id);

        $form = $this->createFormBuilder()
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('admin_proyecto_detalle', ['id' => $id]));
        }
        $arTareas = $em->getRepository(Tarea::class)->findBy(array('codigoProyectoFk' => $id, 'estadoVerificado' => 0));
        return $this->render('Admin/Proyecto/detalle.html.twig', [
            'arProyecto' => $arProyecto,
            'arTareas' => $arTareas,
            'form' => $form->createView()
        ]);
    }


}
