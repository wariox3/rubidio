<?php

namespace App\Controller\Pagina;

use App\Entity\Archivo;
use App\Entity\Documentacion;
use App\Entity\Error;
use App\Entity\Soporte;
use App\Entity\Usuario;
use App\Form\Type\ContactoType;
use App\Form\Type\SoporteExternoType;
use App\Utilidades\Dubnio;
use App\Utilidades\Mensajes;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class SoporteController extends AbstractController
{

    /**
     * @Route("/soporte", name="soporte")
     */
    public function soporte(): Response
    {
        return $this->render('Pagina/soporte.html.twig');
    }

    /**
     * @Route("/soporte/asesor", name="soporte_asesor")
     */
    public function soporteAsesor(Request $request, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $arSoporte = new Soporte();
        $arSoporte->setFecha(new \DateTime('now'));
        $form = $this->createForm(SoporteExternoType::class, $arSoporte);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arSoporte = $form->getData();
                $em->persist($arSoporte);
                $em->flush();
                $parametros = $request->files;
                foreach ($parametros as $archivos) {
                    foreach ($archivos as $archivo) {
                        $extension = $archivo->getClientOriginalExtension();
                        $nombre = $archivo->getClientOriginalName();
                        $tamano = $archivo->getSize();
                        $mimeType = $archivo->getClientMimeType();
                        $archivoTemporal = $archivo->getPathName();
                        $em->getRepository(Archivo::class)->carga("soporte", $arSoporte->getCodigoSoportePk(), $extension, $nombre, $tamano, $mimeType, null, $archivoTemporal);
                    }
                }
                return $this->redirectToRoute('soporte_asesor_informacion', ['id' => $arSoporte->getCodigoSoportePk()]);
            }
        }
        return $this->render('Pagina/soporteAsesor.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/soporte/asesor/informacion/{id}", name="soporte_asesor_informacion")
     */
    public function soporteAsesorInformacion($id): Response
    {
        return $this->render('Pagina/soporteAsesorInformacion.html.twig', [
            'codigoSoporte' => $id
        ]);
    }

    /**
     * @Route("/soporte/asesor/detalle/{id}", name="soporte_asesor_detalle")
     */
    public function soporteAsesorDetalle(Request $request, ManagerRegistry $doctrine, $id): Response
    {
        $em = $doctrine->getManager();
        $arSoporte = [];
        if ($id) {
            $arSoporte = $em->getRepository(Soporte::class)->find($id);
        }
        $formBuscar = $this->createFormBuilder()
            ->add('codigoSoporte', TextType::class)
            ->add('buscar', SubmitType::class)
            ->getForm();
        $formBuscar->handleRequest($request);
        if ($formBuscar->isSubmitted() && $formBuscar->isValid()) {
            if ($formBuscar->get('buscar')->isClicked()) {
                $codigoSoporte = $formBuscar->get('codigoSoporte')->getData();
                $arSoporte = $em->getRepository(Soporte::class)->find($codigoSoporte);
            }
        }
        return $this->render('Pagina/soporteAsesorDetalle.html.twig', [
            'arSoporte' => $arSoporte,
            'formBuscar' => $formBuscar->createView()
        ]);
    }

    /**
     * @Route("/soporte/comosehace", name="soporte_comosehace")
     */
    public function comoSeHace(): Response
    {
        return $this->render('Pagina/comoSeHace.html.twig');
    }

    /**
     * @Route("/soporte/documentacion", name="soporte_documentacion")
     */
    public function documentacion(Request $request, PaginatorInterface $paginator)
    {
        $raw = [];
        $em = $this->getDoctrine()->getManager();
        $arrModulos = [
            'Todos' => null,
            'Cartera' => 'Cartera',
            'Crm' => 'CRM',
            'Documental' => 'Documental',
            'Financiero' => 'Fiannciero',
            'General' => 'General',
            'Inventario' => 'Inventario',
            'RecursoHumano' => 'RecursoHumano',
            'Seguridad' => 'Seguridad',
            'Tesoreria' => 'Tesoreria',
            'Transporte' => 'Transporte',
            'Turno' => 'Turno'
        ];
        $form = $this->createFormBuilder()
            ->add('modulo', ChoiceType::class, ['choices' => $arrModulos, 'required' => false, 'data' => $arrModulos ? $arrModulos : null])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $raw['filtros'] = $this->getFiltros($form);
            }
        }
        $arDocumentaciones = $paginator->paginate($em->getRepository(Documentacion::class)->lista($raw), $request->query->getInt('page', 1), 100);
        return $this->render('Pagina/documentacion.html.twig', [
            'arDocumentaciones' => $arDocumentaciones,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/soporte/documentacion/{id}", name="soporte_documentacion_detalle")
     */
    public function documentacionDetalle(Request $request, PaginatorInterface $paginator, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $arDocumentacionDetalles = $em->getRepository(Documentacion::class)->documentacionDetalle($id);
        return $this->render('Pagina/documentacionDetalle.html.twig', [
            'arDocumentacionDetalles' => $arDocumentacionDetalles,
        ]);
    }

    public function getFiltros($form)
    {
        $session = new Session();
        $filtro = [
            'modulo' => $form->get('modulo')->getData(),
        ];
        $session->set('filtroDocumentacion', $filtro);
        return $filtro;
    }

}