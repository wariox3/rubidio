<?php


namespace App\Controller\Documental;


use App\Entity\Archivo;
use App\Entity\ArchivoTipo;
use App\Entity\Ciudad;
use App\Entity\Directorio;
use App\Form\Type\CiudadType;
use App\Utilidades\Mensajes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Response;

class   DocumentalController extends AbstractController
{
    /**
     * @Route("/documental/archivo/lista/{tipo}/{codigo}", name="documental_archivo_lista")
     */
    public function listaAction(Request $request, $tipo, $codigo)
    {
        $em = $this->getDoctrine()->getManager();
        $arArchivos = $em->getRepository(Archivo::class)->lista($tipo, $codigo);
        return $this->render('documental/archivo/lista.html.twig', array(
            'arArchivos' => $arArchivos,
            'tipo' => $tipo,
            'codigo' => $codigo
        ));
    }

    /**
     * @Route("/documental/archivo/cargar/{tipo}/{codigo}", name="documental_archivo_cargar")
     */
    public function cargarAction(Request $request, $tipo, $codigo)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()
            ->add('attachment', fileType::class)
            ->add('descripcion', textType::class, array('required' => false))
            ->add('comentarios', TextareaType::class, array('required' => false))
            ->add('BtnCargar', SubmitType::class, array('label' => 'Cargar'))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('BtnCargar')->isClicked()) {
                $objArchivo = $form['attachment']->getData();
                if ($objArchivo->getSize()) {
                    $arArchivo = new Archivo();
                    $arArchivo->setNombre($objArchivo->getClientOriginalName());
                    $arArchivo->setExtensionOriginal($objArchivo->getClientOriginalExtension());
                    $arArchivo->setTamano($objArchivo->getSize());
                    $arArchivo->setTipo($objArchivo->getClientMimeType());
                    $arArchivo->setCodigoArchivoTipoFk($tipo);
                    $arArchivo->setCodigo($codigo);
                    $arArchivo->setUsuario($this->getUser()->getUsername());
                    $dateFecha = new \DateTime('now');
                    $arArchivo->setFecha($dateFecha);
                    $arArchivo->setDescripcion($form->get('descripcion')->getData());
                    $arArchivo->setComentarios($form->get('comentarios')->getData());
                    $directorio = $em->getRepository(Directorio::class)->devolverDirectorio("A", $tipo);
                    $arArchivo->setDirectorio($directorio);
                    $arArchivo->setArchivoTipoRel($em->getReference(ArchivoTipo::class, $tipo));
                    $error = false;
                    $directorioDestino = "/almacenamientorubidio/archivo/" . $tipo . "/" . $directorio . "/";
                    if (!file_exists($directorioDestino)) {
                        if (!mkdir($directorioDestino, 0777, true)) {
                            Mensajes::error('Fallo al crear directorio...' . $directorioDestino);
                            $error = true;
                        }
                    }
                    if ($error == false) {
                        $em->persist($arArchivo);
                        $em->flush();
                        $strArchivo = $arArchivo->getCodigoArchivoPk() . "_" . $objArchivo->getClientOriginalName();
                        $form['attachment']->getData()->move($directorioDestino, $strArchivo);
                    }
                    return $this->redirect($this->generateUrl('documental_archivo_lista', array('tipo' => $tipo, 'codigo' => $codigo)));
                } else {
                    Mensajes::error("El archivo tiene un tamaño mayor al permitido");
                }
            }
        }
        return $this->render('documental/archivo/cargar.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/documental/archivo/descargar/{codigoArchivo}", name="documental_archivo_descargar")
     */
    public function descargarAction($codigoArchivo)
    {
        $em = $this->getDoctrine()->getManager();
        $arArchivo = $em->getRepository(Archivo::class)->find($codigoArchivo);
        $strRuta = "/almacenamientorubidio/archivo/" . $arArchivo->getCodigoArchivoTipoFk() . "/" . $arArchivo->getDirectorio() . "/" . $arArchivo->getCodigoArchivoPk() . "_" . $arArchivo->getNombre();
        $response = new Response();

        // Set headers
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', $arArchivo->getTipo());
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $arArchivo->getNombre() . '";');
        $response->headers->set('Content-length', $arArchivo->getTamano());
        $response->sendHeaders();
        if (file_exists($strRuta)) {
            $response->setContent(readfile($strRuta));
        } else {
            echo "<script>alert('No existe el archivo en el servidor a pesar de estar asociado en base de datos, por favor comuniquese con soporte');window.close()</script>";
        }
        return $response;

    }

    /**
     * @Route("/documental/archivo/eliminar/{tipo}/{codigo}", name="documental_archivo_eliminar")
     */
    public function EliminarAction($tipo, $codigo)
    {
        $em = $this->getDoctrine()->getManager();

        $arArchivo = $em->getRepository(Archivo::class)->find($codigo);
        if (!$arArchivo) {
            return $this->redirect($this->generateUrl('documental_archivo_lista', array('tipo' => $tipo, 'codigo' => $codigo)));
        }
        $strRuta = "/almacenamientocobalto/archivo/" . $arArchivo->getCodigoArchivoTipoFk() . "/" . $arArchivo->getDirectorio() . "/" . $arArchivo->getCodigoArchivoPk() . "_" . $arArchivo->getNombre();
        if (file_exists($strRuta)) {
            unlink($strRuta);
        }
        $em->remove($arArchivo);
        $em->flush();
        return $this->redirect($this->generateUrl('documental_archivo_lista', array('tipo' => $tipo, 'codigo' => $codigo)));
    }

    /**
     * @Route("/documental/archivo/ver/{tipo}/{codigo}", name="documental_archivo_ver")
     */
    public function verAction(Request $request, $tipo, $codigo)
    {
        $em = $this->getDoctrine()->getManager();
        $arArchivos = $em->getRepository(Archivo::class)->lista($tipo, $codigo);
        return $this->render('documental/archivo/ver.html.twig', array(
            'arArchivos' => $arArchivos,
            'tipo' => $tipo,
            'codigo' => $codigo
        ));
    }

}