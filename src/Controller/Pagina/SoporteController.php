<?php

namespace App\Controller\Pagina;

use App\Entity\Archivo;
use App\Entity\Caso;
use App\Entity\CasoTipo;
use App\Entity\Documentacion;
use App\Entity\Error;
use App\Entity\Funcionalidad;
use App\Entity\Modulo;
use App\Entity\Prioridad;
use App\Entity\Recurso;
use App\Entity\Soporte;
use App\Entity\Usuario;
use App\Form\Type\CasoSoporteType;
use App\Form\Type\ContactoSitioType;
use App\Form\Type\SoporteExternoType;
use App\Utilidades\Dubnio;
use App\Utilidades\Mensajes;
use Doctrine\ORM\EntityRepository;
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
        return $this->render('Pagina/Soporte/soporte.html.twig');
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
                return $this->render('Pagina/Soporte/soporteAsesorInformacion.html.twig', [
                    'codigoSoporte' => $arSoporte->getCodigoSoportePk()
                ]);
            }
        }
        return $this->render('Pagina/Soporte/soporteAsesor.html.twig', [
            'form' => $form->createView()
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
        return $this->render('Pagina/Soporte/soporteAsesorDetalle.html.twig', [
            'arSoporte' => $arSoporte,
            'formBuscar' => $formBuscar->createView()
        ]);
    }

    /**
     * @Route("/soporte/comosehace", name="soporte_comosehace")
     */
    public function comoSeHace(): Response
    {
        return $this->render('Pagina/Soporte/comoSeHace.html.twig');
    }

    /**
     * @Route("/soporte/falla", name="soporte_falla")
     */
    public function falla(Request $request, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $arCaso = new Caso();
        $arCaso->setFecha(new \DateTime('now'));
        $arCaso->setCasoTipoRel($em->getReference(CasoTipo::class, 'ERR'));
        $arCaso->setPrioridadRel($em->getReference(Prioridad::class, 'CRI'));
        $form = $this->createForm(CasoSoporteType::class, $arCaso);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arCaso = $form->getData();
                $em->persist($arCaso);
                $em->flush();
                $parametros = $request->files;
                foreach ($parametros as $archivos) {
                    foreach ($archivos as $archivo) {
                        $extension = $archivo->getClientOriginalExtension();
                        $nombre = $archivo->getClientOriginalName();
                        $tamano = $archivo->getSize();
                        $mimeType = $archivo->getClientMimeType();
                        $archivoTemporal = $archivo->getPathName();
                        $em->getRepository(Archivo::class)->carga("caso", $arCaso->getCodigoCasoPk(), $extension, $nombre, $tamano, $mimeType, null, $archivoTemporal);
                    }
                }
                return $this->render('Pagina/Soporte/casoInformacion.html.twig', ['codigoCaso' => $arCaso->getCodigoCasoPk()]);
            }
        }
        return $this->render('Pagina/Soporte/falla.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/soporte/consultoria", name="soporte_consultoria")
     */
    public function consultoria(Request $request, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $arCaso = new Caso();
        $arCaso->setFecha(new \DateTime('now'));
        $arCaso->setCasoTipoRel($em->getReference(CasoTipo::class, 'CES'));
        $arCaso->setPrioridadRel($em->getReference(Prioridad::class, 'NOR'));
        $form = $this->createForm(CasoSoporteType::class, $arCaso);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arCaso = $form->getData();
                $em->persist($arCaso);
                $em->flush();
                $parametros = $request->files;
                foreach ($parametros as $archivos) {
                    foreach ($archivos as $archivo) {
                        $extension = $archivo->getClientOriginalExtension();
                        $nombre = $archivo->getClientOriginalName();
                        $tamano = $archivo->getSize();
                        $mimeType = $archivo->getClientMimeType();
                        $archivoTemporal = $archivo->getPathName();
                        $em->getRepository(Archivo::class)->carga("caso", $arCaso->getCodigoCasoPk(), $extension, $nombre, $tamano, $mimeType, null, $archivoTemporal);
                    }
                }
                return $this->render('Pagina/Soporte/casoInformacion.html.twig', ['codigoCaso' => $arCaso->getCodigoCasoPk()]);
            }
        }
        return $this->render('Pagina/Soporte/consultoria.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/soporte/desarrollo", name="soporte_desarrollo")
     */
    public function desarrollo(Request $request, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $arCaso = new Caso();
        $arCaso->setFecha(new \DateTime('now'));
        $arCaso->setCasoTipoRel($em->getReference(CasoTipo::class, 'DES'));
        $arCaso->setPrioridadRel($em->getReference(Prioridad::class, 'NOR'));
        $form = $this->createForm(CasoSoporteType::class, $arCaso);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arCaso = $form->getData();
                $em->persist($arCaso);
                $em->flush();
                $parametros = $request->files;
                foreach ($parametros as $archivos) {
                    foreach ($archivos as $archivo) {
                        $extension = $archivo->getClientOriginalExtension();
                        $nombre = $archivo->getClientOriginalName();
                        $tamano = $archivo->getSize();
                        $mimeType = $archivo->getClientMimeType();
                        $archivoTemporal = $archivo->getPathName();
                        $em->getRepository(Archivo::class)->carga("caso", $arCaso->getCodigoCasoPk(), $extension, $nombre, $tamano, $mimeType, null, $archivoTemporal);
                    }
                }
                return $this->render('Pagina/Soporte/casoInformacion.html.twig', ['codigoCaso' => $arCaso->getCodigoCasoPk()]);
            }
        }
        return $this->render('Pagina/Soporte/desarrollo.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/soporte/solicitud", name="soporte_solicitud")
     */
    public function solicitud(Request $request, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $arCaso = new Caso();
        $arCaso->setFecha(new \DateTime('now'));
        $arCaso->setCasoTipoRel($em->getReference(CasoTipo::class, 'SOL'));
        $arCaso->setPrioridadRel($em->getReference(Prioridad::class, 'NOR'));
        $form = $this->createForm(CasoSoporteType::class, $arCaso);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arCaso = $form->getData();
                $em->persist($arCaso);
                $em->flush();
                $parametros = $request->files;
                foreach ($parametros as $archivos) {
                    foreach ($archivos as $archivo) {
                        $extension = $archivo->getClientOriginalExtension();
                        $nombre = $archivo->getClientOriginalName();
                        $tamano = $archivo->getSize();
                        $mimeType = $archivo->getClientMimeType();
                        $archivoTemporal = $archivo->getPathName();
                        $em->getRepository(Archivo::class)->carga("caso", $arCaso->getCodigoCasoPk(), $extension, $nombre, $tamano, $mimeType, null, $archivoTemporal);
                    }
                }
                return $this->render('Pagina/Soporte/casoInformacion.html.twig', ['codigoCaso' => $arCaso->getCodigoCasoPk()]);
            }
        }
        return $this->render('Pagina/Soporte/solicitud.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/soporte/descarga", name="soporte_descarga")
     */
    public function descarga(Request $request, ManagerRegistry $doctrine): Response
    {
        return $this->render('Pagina/Soporte/descarga.html.twig');
    }

    /**
     * @Route("/soporte/documentacion", name="soporte_documentacion")
     */
    public function documentacion(Request $request, PaginatorInterface $paginator)
    {
        $raw = [];
        $em = $this->getDoctrine()->getManager();
//        $arrModulos = [
//            'Todos' => null,
//            'Cartera' => 'Cartera',
//            'Crm' => 'CRM',
//            'Documental' => 'Documental',
//            'Financiero' => 'Fiannciero',
//            'General' => 'General',
//            'INV' => 'Inventario',
//            'RecursoHumano' => 'RecursoHumano',
//            'Seguridad' => 'Seguridad',
//            'TES' => 'Tesoreria',
//            'Transporte' => 'Transporte',
//            'Turno' => 'Turno',
//            'VEN' => 'Venta',
//            'COM' => 'Compra'
//        ];
        $form = $this->createFormBuilder()
//            ->add('modulo', ChoiceType::class, ['choices' => $arrModulos, 'required' => false, 'data' => $arrModulos ? $arrModulos : null])
            ->add('modulo', EntityType::class, array(
                'class' => Modulo::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('d')
                        ->orderBy('d.nombre', 'ASC');
                },
                'required' => false,
                'choice_label' => 'nombre',
                'placeholder' => 'TODOS',
            ))
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $raw['filtros'] = $this->getFiltros($form);
                $arModulo = $form->get('modulo')->getData();
                if (is_object($arModulo)) {
                    $raw['filtros']['modulo'] = $arModulo->getCodigoModuloPk();
                } else {
                    $raw['filtros']['modulo'] = $arModulo;
                }
            }
        }
        $arDocumentaciones = $paginator->paginate($em->getRepository(Documentacion::class)->lista($raw), $request->query->getInt('page', 1), 100);
        $arRecursos = $em->getRepository(Recurso::class)->lista();
        $arFuncionalidades = $em->getRepository(Funcionalidad::class)->lista($raw);
        return $this->render('Pagina/Soporte/documentacion.html.twig', [
            'arDocumentaciones' => $arDocumentaciones,
            'arRecursos' => $arRecursos,
            'arFuncionalidades' => $arFuncionalidades,
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
        return $this->render('Pagina/Soporte/documentacionDetalle.html.twig', [
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