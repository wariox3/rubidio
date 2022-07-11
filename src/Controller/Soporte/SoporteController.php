<?php

namespace App\Controller\Soporte;

use App\Entity\Archivo;
use App\Entity\Cliente;
use App\Entity\Soporte;
use App\Form\Type\SoporteSolucionType;
use App\Form\Type\SoporteType;
use App\Utilidades\Dubnio;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityRepository;

class SoporteController extends AbstractController
{

    /**
     * @Route("/soporte/soporte/nuevo/{id}", name="soporte_soporte_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arSoporte = new Soporte();
        if ($id != 0) {
            $arSoporte = $em->getRepository(Soporte::class)->find($id);
        }
        $form = $this->createForm(SoporteType::class, $arSoporte);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arSoporte = $form->getData();
                if($id == 0) {
                    $arSoporte->setFecha(new \DateTime('now'));
                }
                $em->persist($arSoporte);
                $em->flush();
                return $this->redirect($this->generateUrl('soporte_soporte_lista'));
            }
        }
        $arClientesSuspendidos = $em->getRepository(Cliente::class)->clientesSuspendidos();
        return $this->render('Soporte/Soporte/nuevo.html.twig', [
            'arSoporte' => $arSoporte,
            'arClientesSuspendidos' => $arClientesSuspendidos,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/soporte/soporte/lista", name="soporte_soporte_lista")
     */
    public function lista(Request $request,  PaginatorInterface $paginator) {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $arrayPropiedadesCliente = array(
            'class' => Cliente::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->orderBy('c.nombreCorto', 'ASC');
            },
            'choice_label' => 'nombreCorto',
            'required' => false,
            'placeholder' => "TODOS",

        );
        if ($session->get('filtroSoporteCodigoCliente')) {
            $arrayPropiedadesCliente['data'] = $em->getReference("App\Entity\Cliente", $session->get('filtroSoporteCodigoCliente'));
        }

        if ($session->get('filtroSoporteEstadoSolucionado') == null) {
            $session->set('filtroSoporteEstadoSolucionado', 0);
        }

        $form = $this->createFormBuilder()
            ->add('clienteRel', EntityType::class, $arrayPropiedadesCliente)
            ->add('estadoAtendido', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroSoporteEstadoAtendido'), 'required' => false])
            ->add('estadoSolucionado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroSoporteEstadoSolucionado'), 'required' => false])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroSoporteEstadoAtendido', $form->get('estadoAtendido')->getData());
                $session->set('filtroSoporteEstadoSolucionado', $form->get('estadoSolucionado')->getData());
                $arCliente = $form->get('clienteRel')->getData();
                if ($arCliente) {
                    $session->set('filtroSoporteCodigoCliente', $arCliente->getCodigoClientePk());
                } else {
                    $session->set('filtroSoporteCodigoCliente', null);
                }
            }
            if ($request->request->get('OpAtender')) {
                $codigo = $request->request->get('OpAtender');
                $arSoporte = $em->getRepository(Soporte::class)->find($codigo);
                $arSoporte->setEstadoAtendido(1);
                $arSoporte->setFechaAtendido(new \DateTime('now'));
                $em->persist($arSoporte);
                $em->flush();
            }
        }
        $arSoportes = $paginator->paginate($em->getRepository(Soporte::class)->lista(), $request->query->getInt('page', 1), 250);
        return $this->render('Soporte/Soporte/lista.html.twig', [
            'arSoportes' => $arSoportes,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/soporte/soporte/detalle/{id}", name="soporte_soporte_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arSoporte = $em->getRepository(Soporte::class)->find($id);
        $form = $this->createFormBuilder()
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->request->get('OpDescargar')) {
                $codigoFichero = $request->request->get('OpDescargar');
                $respuesta = $em->getRepository(Archivo::class)->descargar($codigoFichero);
                if(!$respuesta['error']) {
                    $response = new Response();
                    $response->headers->set('Cache-Control', 'private');
                    $response->headers->set('Content-type', $respuesta['tipo']);
                    $response->headers->set('Content-Disposition', 'attachment; filename="' . $respuesta['nombre'] . '";');
                    $response->headers->set('Content-length', $respuesta['tamano']);
                    $response->sendHeaders();
                    $response->setContent($respuesta['contenido']);
                    return $response;
                }
            }
        }
        $arArchivos = $em->getRepository(Archivo::class)->lista("soporte", $id);
        return $this->render('Soporte/Soporte/detalle.html.twig', [
            'arSoporte' => $arSoporte,
            'arArchivos' => $arArchivos,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/soporte/soporte/solucion/{id}", name="soporte_soporte_solucion")
     */
    public function solucion(Request $request, Dubnio $correo, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arSoporte = $em->getRepository(Soporte::class)->find($id);

        $form = $this->createForm(SoporteSolucionType::class, $arSoporte);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arSoporte = $form->getData();
                $arSoporte->setFechaSolucion(new \DateTime('now'));
                $arSoporte->setEstadoSolucionado(1);
                $em->persist($arSoporte);
                $em->flush();
                if($arSoporte->getCorreo()) {
                    $respuesta = $correo->enviarCorreo($arSoporte->getCorreo(), 'Atencion a solicitud de soporte' . ' - ' . $arSoporte->getCodigoSoportePk(),
                        $this->renderView(
                            'Soporte/Soporte/correoSolucion.html.twig',
                            array('arSoporte' => $arSoporte)
                        ));
                }

                echo "<script languaje='javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        return $this->render('Soporte/Soporte/solucion.html.twig', [
            'form' => $form->createView()
        ]);
    }


}
