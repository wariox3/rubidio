<?php

namespace App\Controller\Soporte;

use App\Entity\Documentacion;
use App\Form\Type\DocumentacionType;
use App\Formatos\Documentancion;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class DocumentacionController extends AbstractController
{

    /**
     * @Route("/soporte/documentacion/nuevo/{id}", name="soporte_documentacion_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arDocumentacion = new Documentacion();
        if ($id != 0) {
            $arDocumentacion = $em->getRepository(Documentacion::class)->find($id);
        }
        $form = $this->createForm(DocumentacionType::class, $arDocumentacion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arDocumentacion = $form->getData();
                $em->persist($arDocumentacion);
                $em->flush();
                return $this->redirect($this->generateUrl('soporte_documentacion_lista'));
            }
        }
        return $this->render('Soporte/Documentacion/nuevo.html.twig', [
            'arDocumentacion' => $arDocumentacion,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/soporte/documentacion/lista", name="soporte_documentacion_lista")
     */
    public function lista(Request $request,  PaginatorInterface $paginator)
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()
            ->add('btnImprimir', SubmitType::class, ['label' => 'Imprimir', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('modulo', TextType::class, ['data' => $session->get('filtroDocumentacionModulo'), 'required' => false])
            ->add('modelo', TextType::class, ['data' => $session->get('filtroDocumentacionModelo'), 'required' => false])
            ->add('grupo', TextType::class, ['data' => $session->get('filtroDocumentacionGrupo'), 'required' => false])
            ->add('titulo', TextType::class, ['data' => $session->get('filtroDocumentacionTitulo'), 'required' => false])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroDocumentacionModulo', $form->get('modulo')->getData());
                $session->set('filtroDocumentacionModelo', $form->get('modelo')->getData());
                $session->set('filtroDocumentacionGrupo', $form->get('grupo')->getData());
                $session->set('filtroDocumentacionTitulo', $form->get('titulo')->getData());
            }
            if ($form->get('btnImprimir')->isClicked()) {
                $formatoDocumentacion = new Documentancion();
                $formatoDocumentacion->Generar($em);
            }

        }
        $arDocumentaciones = $paginator->paginate($em->getRepository(Documentacion::class)->lista(), $request->query->getInt('page', 1), 500);
        return $this->render('Soporte/Documentacion/lista.html.twig', [
            'arDocumentaciones' => $arDocumentaciones,
            'form' => $form->createView()
        ]);
    }

}
