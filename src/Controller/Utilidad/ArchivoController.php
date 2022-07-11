<?php

namespace App\Controller\Utilidad;

use App\Entity\Archivo;
use App\Entity\ArchivoTipo;
use App\Entity\Cliente;
use App\Entity\Directorio;
use App\Entity\Soporte;
use App\Form\Type\SoporteSolucionType;
use App\Form\Type\SoporteType;
use App\Utilidades\Dubnio;
use App\Utilidades\Mensajes;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityRepository;

class ArchivoController extends AbstractController
{

    /**
     * @Route("/utilidad/archivo/lista/{tipo}/{codigo}", name="utilidad_archivo_lista")
     */
    public function lista(Request $request, $tipo, $codigo) {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()
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
        $arArchivos = $em->getRepository(Archivo::class)->lista($tipo, $codigo);
        return $this->render('Utilidades/archivo/lista.html.twig', [
            'arArchivos' => $arArchivos,
            'tipo' => $tipo,
            'codigo' => $codigo,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/utilidad/archivo/cargar/{tipo}/{codigo}", name="utilidad_archivo_cargar")
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
            if ($form->get('btnCargar')->isClicked()) {
                $objArchivo = $form['attachment']->getData();
                if ($objArchivo->getSize()) {
                    $peso = $objArchivo->getSize() / 1000000;
                    if ($peso <= 6) {
                        $extension = $objArchivo->getClientOriginalExtension();
                        $nombre = $objArchivo->getClientOriginalName();
                        $tamano = $objArchivo->getSize();
                        $mimeType = $objArchivo->getClientMimeType();
                        $descripcion = $form->get('descripcion')->getData();
                        $archivoTemporal = $objArchivo->getPathName();
                        $respuesta = $em->getRepository(DocFichero::class)->carga($codigoModelo, $codigo, $extension, $nombre, $tamano, $mimeType, $descripcion, $archivoTemporal);
                        if(!$respuesta['error']) {
                            if ($codigoModelo == 'TteGuia') {
                                $arGuia = $em->getRepository(TteGuia::class)->find($codigo);
                                if ($arGuia) {
                                    $arGuia->setEstadoDigitalizado(1);
                                    $em->persist($arGuia);
                                    $em->flush();
                                }
                            }
                            return $this->redirect($this->generateUrl('documental_utilidad_archivo_lista', array('codigoModelo' => $codigoModelo, 'codigo' => $codigo)));
                        } else {
                            Mensajes::error($respuesta['errorMensaje']);
                        }
                    } else {
                        Mensajes::error("El archivo tiene un tamaño mayor al permitido");
                    }
                } else {
                    Mensajes::error("El archivo tiene un tamaño mayor al permitido");
                }
            }
        }
        return $this->render('Utilidades/archivo/cargar.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
