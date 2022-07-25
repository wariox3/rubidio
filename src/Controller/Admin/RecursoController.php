<?php

namespace App\Controller\Admin;

use App\Entity\Modulo;
use App\Entity\Recurso;
use App\Form\Type\RecursoType;
use Doctrine\ORM\EntityRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class RecursoController extends AbstractController
{

    /**
     * @Route("/admin/recurso/lista", name="admin_recurso_lista")
     */
    public function lista(Request $request, PaginatorInterface $paginator)
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()
            ->add('moduloRel', EntityType::class, array(
                'class' => Modulo::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'required' => false,
                'placeholder' => "TODOS",
            ))
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $arModulo = $form->get('moduloRel')->getData();
                if ($arModulo) {
                    $session->set('filtroRecursoCodigoModulo', $arModulo->getCodigoModuloPk());
                } else {
                    $session->set('filtroRecursoCodigoModulo', null);
                }
            }
            if ($form->get('btnEliminar')->isClicked()) {
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                if ($arrSeleccionados) {
                    foreach ($arrSeleccionados as $codigo) {
                        $arError = $em->getRepository(Recurso::class)->find($codigo);
                        if ($arError) {
                            $em->remove($arError);
                        }
                    }
                    $em->flush();
                }
            }
        }
        $arRecursos = $paginator->paginate($em->getRepository(Recurso::class)->lista(), $request->query->getInt('page', 1), 500);
        return $this->render('Admin/Recurso/lista.html.twig', [
            'arRecursos' => $arRecursos,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/recurso/nuevo/{id}", name="admin_recurso_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arRecurso = new recurso();
        if ($id != 0) {
            $arRecurso = $em->getRepository(recurso::class)->find($id);
        } else {
            $arRecurso->setFecha(new \DateTime('now'));
        }
        $form = $this->createForm(RecursoType::class, $arRecurso);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $em->persist($arRecurso);
                $em->flush();
                return $this->redirect($this->generateUrl('admin_recurso_detalle', array('id' => $arRecurso->getCodigorecursoPk())));
            }
        }
        return $this->render('Admin/Recurso/nuevo.html.twig', [
            'arRecurso' => $arRecurso,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/recurso/detalle/{id}", name="admin_recurso_detalle")
     */
    public function detalle(Request $request, PaginatorInterface $paginator, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arRecurso = $em->getRepository(Recurso::class)->find($id);
        $form = $this->createFormBuilder()
            ->getForm();
        $form->handleRequest($request);
        return $this->render('Admin/Recurso/detalle.html.twig', [
            'documentacion' => 352,
            'arRecurso' => $arRecurso,
            'form' => $form->createView()
        ]);
    }

}