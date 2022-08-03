<?php

namespace App\Controller\Operacion;

use App\Entity\Cliente;
use App\Entity\Estudio;
use App\Entity\EstudioDetalle;
use App\Entity\Funcionalidad;
use App\Entity\RecursoHumano\RhuPoligonoDetalle;
use App\Form\Type\EstudioDetalleType;
use App\Form\Type\EstudioType;
use App\Formatos\FormatoEstudio;
use Doctrine\ORM\EntityRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class EstudioController extends AbstractController
{

    /**
     * @Route("/operacion/estudio/lista", name="operacion_estudio_lista")
     */
    public function lista(Request $request, PaginatorInterface $paginator)
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()
            ->add('clienteRel', EntityType::class, array(
                'class' => Cliente::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.nombreCorto', 'ASC');
                },
                'required' => false,
                'choice_label' => 'nombreCorto',
                'placeholder' => 'TODOS',
            ))
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

        }
        $arEstudios = $paginator->paginate($em->getRepository(Estudio::class)->lista(), $request->query->getInt('page', 1), 500);
        return $this->render('Operacion/Estudio/lista.html.twig', [
            'arEstudios' => $arEstudios,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/operacion/estudio/nuevo/{id}", name="operacion_estudio_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arEstudio = new Estudio();
        if ($id != 0) {
            $arEstudio = $em->getRepository(Estudio::class)->find($id);
        }
        $form = $this->createForm(EstudioType::class, $arEstudio);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arEstudio = $form->getData();
                $em->persist($arEstudio);
                $em->flush();
                echo "<script type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        return $this->render('Operacion/Estudio/nuevo.html.twig', [
            'arEstudio' => $arEstudio,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/operacion/estudio/detalle/{id}", name="operacion_estudio_detalle")
     */
    public function detalle(Request $request,  PaginatorInterface $paginator, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arEstudio = $em->getRepository(Estudio::class)->find($id);
        $form = $this->createFormBuilder()
            ->add('btnImprimir', SubmitType::class, array('label' => 'Imprimir', 'attr' => ['class' => 'btn btn-primary btn-sm']))
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnImprimir')->isClicked()) {
                $formatoEstudio = new FormatoEstudio();
                $formatoEstudio->Generar($em, $id );
            }
            if ($form->get('btnEliminar')->isClicked()) {
                $arrDetallesSeleccionados = $request->request->get('ChkSeleccionar');
                $em->getRepository(EstudioDetalle::class)->eliminar($arrDetallesSeleccionados);
            }
        }
        $arEstudioDetalles = $paginator->paginate($em->getRepository(EstudioDetalle::class)->lista($id), $request->query->getInt('page', 1), 100);
        return $this->render('Operacion/Estudio/detalle.html.twig', [
            'arEstudio' => $arEstudio,
            'arEstudioDetalles' => $arEstudioDetalles,
            'form' => $form->createView()]);
    }

    /**
     * @Route("/operacion/estudio/funcionalidad/{id}", name="operacion_estudio_funcionalidad")
     */
    public function funcionalidad(Request $request,  PaginatorInterface $paginator, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arEstudioDetalle = $em->getRepository(EstudioDetalle::class)->find($id);
        $form = $this->createFormBuilder()
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnImprimir')->isClicked()) {
                $formatoEstudio = new FormatoEstudio();
                $formatoEstudio->Generar($em, $id );
            }
            if ($form->get('btnEliminar')->isClicked()) {
                $arrDetallesSeleccionados = $request->request->get('ChkSeleccionar');
                $em->getRepository(EstudioDetalle::class)->eliminar($arrDetallesSeleccionados);
            }
        }
        $arFuncionalidades = $paginator->paginate($em->getRepository(Funcionalidad::class)->detalleEstudio($arEstudioDetalle->getCodigoModuloFk()), $request->query->getInt('page', 1), 100);
        return $this->render('Operacion/Estudio/funcionalidad.html.twig', [
            'arEstudioDetalle' => $arEstudioDetalle,
            'arFuncionalidades' => $arFuncionalidades,
            'form' => $form->createView()]);
    }

    /**
     * @Route("/operacion/estudio/detalle/nuevo/{codigoEstudio}/{id}", name="operacion_estudio_detalle_nuevo")
     */
    public function detalleNuevo(Request $request, $codigoEstudio, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arEstudioDetalle = new EstudioDetalle();
        $arEstudio = $em->getRepository(Estudio::class)->find($codigoEstudio);
        if ($id != 0) {
            $arEstudioDetalle = $em->getRepository(EstudioDetalle::class)->find($id);
        }

        $form = $this->createForm(EstudioDetalleType::class, $arEstudioDetalle);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arImplementacionDetalle = $form->getData();
                $arEstudioDetalle->setEstudioRel($arEstudio);
                $em->persist($arImplementacionDetalle);
                $em->flush();
                echo "<script type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        return $this->render('Operacion/Estudio/detalleNuevo.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
