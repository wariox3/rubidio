<?php

namespace App\Controller\Crm;

use App\Entity\Estudio;
use App\Entity\Implementacion;
use App\Entity\ImplementacionDetalle;
use App\Form\Type\EstudioType;
use App\Form\Type\ImplementacionDetalleImplementadorType;
use App\Form\Type\ImplementacionType;
use App\Formatos\FormatoActaCapacitacion;
use App\Formatos\FormatoActaTerminacion;
use App\Formatos\FormatoPlanTrabajo;
use App\Utilidades\Mensajes;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Dompdf\Dompdf;
use Dompdf\Options;

class EstudioController extends AbstractController
{

    /**
     * @Route("/crm/estudio/lista", name="crm_estudio_lista")
     */
    public function lista(Request $request, PaginatorInterface $paginator)
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

        }
        $arEstudios = $paginator->paginate($em->getRepository(Estudio::class)->lista(), $request->query->getInt('page', 1), 500);
        return $this->render('Crm/Estudio/lista.html.twig', [
            'arEstudios' => $arEstudios,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/crm/estudio/nuevo/{id}", name="crm_estudio_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arEstudio = new Estudio();
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
        return $this->render('Crm/Estudio/nuevo.html.twig', [
            'arEstudio' => $arEstudio,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/crm/estudio/detalle/{id}", name="crm_estudio_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arEstudio = $em->getRepository(Estudio::class)->find($id);
        $session = new Session();
        $arrModulo = [
            'TODOS' => '',
            'Cartera' => 'CAR',
            'CRM' => 'CRM',
            'Financiero' => 'FIN',
            'General' => 'GEN',
            'Inventario' => 'INV',
            'Juridico' => 'JUR',
            'RHumano' => 'RHU',
            'Tesoreria' => 'TES',
            'Transporte' => 'TTE',
            'Turnos' => 'TUR'];
        $form = $this->createFormBuilder()
            ->add('btnImprimir', SubmitType::class, array('label' => 'Imprimir', 'attr' => ['class' => 'btn btn-primary btn-sm']))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
//            if ($form->get('btnFiltrar')->isClicked()) {
//                $session->set('filtroImplementacionEstadoCapacitado', $form->get('estadoCapacitado')->getData());
//                $session->set('filtroImplementacionModulo', $form->get('modulo')->getData());
//                $session->set('filtroImplementacionDetalleEstadoTerminado', $form->get('estadoTerminado')->getData());
//            }
            if ($form->get('btnImprimir')->isClicked()) {
//                $arrSeleccionados = $request->request->get('ChkSeleccionar');
//                if (!is_null($arrSeleccionados)) {
                    // Configure Dompdf según sus necesidades
                    $pdfOptions = new Options();
                    $pdfOptions->set('defaultFont', 'Arial');
                    // Crea una instancia de Dompdf con nuestras opciones
                    $dompdf = new Dompdf($pdfOptions);
                    $dompdf->set_base_path("/www/public/css/");
                    // Recupere el HTML generado en nuestro archivo twig
//                    dd($arEstudio->getClienteRel());
                    $html = $this->renderView('pdf/crm/detalle.html.twig', [
                        'title' => "Welcome to our PDF Test",
                        'arEstudio' => $arEstudio,
                    ]);
                    // Cargar HTML en Dompdf
                    $dompdf->loadHtml($html);
                    // (Opcional) Configure el tamaño del papel y la orientación 'vertical' o 'vertical'
                    $dompdf->setPaper('A4', 'portrait');
                    // Renderiza el HTML como PDF
                    $dompdf->render();
                    // Envíe el PDF generado al navegador (descarga forzada)
                    $dompdf->stream("mypdf.pdf", [
                        "Attachment" => true,

                    ]);

//                    if (count($arrSeleccionados) >= 1 && count($arrSeleccionados) <= 7) {
//                        $formatoCapacitacion = new FormatoActaCapacitacion();
//                        $formatoCapacitacion->Generar($em, $id, $arrSeleccionados);
//                    } else {
//                        Mensajes::info("La cantidad de temas es mayor a 7, seleccionar menos");
//                    }
//                } else {
//                    Mensajes::error("No hay registros seleccionados");
            }
//            }
//            if ($form->get('btnImprimirActaTerminacion')->isClicked()) {
//                $validarTemasFinalizados = $em->getRepository(ImplementacionDetalle::class)->temasCapacitados($id);
//                if ($validarTemasFinalizados == true) {
//                    $formatoCapacitacion = new FormatoActaTerminacion();
//                    $formatoCapacitacion->Generar($em, $id, $arImplementacion->getCodigoClienteFk());
//                } else {
//                    Mensajes::error("No se puede imprimir el acta de finalizacion ya que hay temas pendientes por capacitar");
//                }
//            }
//            if ($form->get('btnImprimirPlanTrabajo')->isClicked()) {
//                $formatoPlanTrabajo = new FormatoPlanTrabajo();
//                $formatoPlanTrabajo->Generar($em, $id);
//            }
        }
        $arEstudioDetalles = [];
        return $this->render('Crm/Estudio/detalle.html.twig', [
            'arEstudio' => $arEstudio,
            'arEstudioDetalles' => $arEstudioDetalles,
            'form' => $form->createView()]);
    }

    /**
     * @Route("/implementacion/implementacion/detalle/nuevo/{id}", name="implementacion_implementacion_detalle_nuevo")
     */
    public function detalleNuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arImplementacionDetalle = $em->getRepository(ImplementacionDetalle::class)->find($id);
        $form = $this->createForm(ImplementacionDetalleImplementadorType::class, $arImplementacionDetalle);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arImplementacionDetalle = $form->getData();
                $em->persist($arImplementacionDetalle);
                $em->flush();
                echo "<script languaje='javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        return $this->render('Implementacion/Implementacion/detalleNuevo.html.twig', [
            'arImplementacionDetalle' => $arImplementacionDetalle,
            'form' => $form->createView()
        ]);
    }

}
