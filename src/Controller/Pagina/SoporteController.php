<?php

namespace App\Controller\Pagina;

use App\Entity\Archivo;
use App\Entity\Caso;
use App\Entity\CasoTipo;
use App\Entity\Documentacion;
use App\Entity\Funcionalidad;
use App\Entity\Modulo;
use App\Entity\Prioridad;
use App\Entity\Recurso;
use App\Form\Type\CasoSoporteType;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function soporte(Request $request, ManagerRegistry $em): Response
    {

        $arCasoConsultado = null;
        $formBuscar = $this->createFormBuilder()
            ->add('codigoCaso', TextType::class, array('data' => '', 'required' => false))
            ->add('buscar', SubmitType::class)
            ->getForm();
        $formBuscar->handleRequest($request);
        if ($formBuscar->isSubmitted() && $formBuscar->isValid()) {
            if ($formBuscar->get('buscar')->isClicked()) {
                $codigoCaso = $formBuscar->get('codigoCaso')->getData();
                if($codigoCaso){
                    $arCasoConsultado = $em->getRepository(Caso::class)->find($codigoCaso);
                }
            }
        }
        return $this->render('Pagina/Soporte/soporte.html.twig', [
            'arCasoConsultado' => $arCasoConsultado,
            'formBuscar' => $formBuscar->createView(),
        ]);
    }

    /**
     * @Route("/soporte/nuevo/{tipo}", name="soporte_nuevo")
     */
    public function nuevo(Request $request, ManagerRegistry $doctrine, $tipo): Response
    {
        $em = $doctrine->getManager();
        $arCaso = new Caso();
        $arCaso->setFecha(new \DateTime('now'));
        $arCaso->setCasoTipoRel($em->getReference(CasoTipo::class, $tipo));
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
                return $this->redirect($this->generateUrl('soporte_casoinformacion', ['codigoCaso' => $arCaso->getCodigoCasoPk()]));
            }
        }
        return $this->render('Pagina/Soporte/nuevo.html.twig', [
            'form' => $form->createView(),
            'arCaso'=> $arCaso,
        ]);
    }

    /**
     * @Route("/soporte/casoinformacion/{codigoCaso}", name="soporte_casoinformacion")
     */
    public function casoExitoso (Request $request, $codigoCaso): Response
    {
        return $this->render('Pagina/Soporte/casoInformacion.html.twig', [
            'codigoCaso' => $codigoCaso
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
     * @Route("/soporte/documentacio/recursos/lista", name="soporte_documentacion_recursos")
     */
    public function documentacion(Request $request, PaginatorInterface $paginator)
    {
        $raw = [];
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()
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
            if ($request->request->get('OpDescargarRecurso')) {
                $codigoDescargar = $request->request->get('OpDescargarRecurso');
                $respuesta = $em->getRepository(Archivo::class)->descargar($codigoDescargar);
                if (!$respuesta['error']) {
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
     * @Route("/soporte/documentacion/detalle/{id}", name="soporte_documentacion_detalle")
     */
    public function documentacionDetalle(Request $request, PaginatorInterface $paginator, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $arDocumentacionDetalles = $em->getRepository(Documentacion::class)->documentacionDetalle($id);
        return $this->render('Pagina/Soporte/documentacionDetalle.html.twig', [
            'arDocumentacionDetalles' => $arDocumentacionDetalles,
        ]);
    }

    /**
     * @Route("/soporte/politicasprivacidad", name="soporte_politicas_privacidad")
     */
    public function politicasPrivacidad(Request $request): Response{
        return $this->render('Pagina/Soporte/politicasDePrivacidad.html.twig');
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