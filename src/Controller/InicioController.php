<?php

namespace App\Controller;

use App\Entity\Error;
use App\Entity\Soporte;
use App\Entity\Usuario;
use App\Form\Type\ContactoType;
use App\Form\Type\SoporteExternoType;
use App\Utilidades\Dubnio;
use App\Utilidades\Mensajes;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InicioController extends AbstractController
{
    /**
     * @Route("/", name="inicio")
     */
    public function inicio(): Response {
        return $this->render('Inicio/inicio.html.twig');
    }

    /**
     * @Route("/soporte", name="soporte")
     */
    public function soporte(): Response {
        return $this->render('Inicio/soporte.html.twig');
    }

    /**
     * @Route("/soporte/asesor", name="soporte_asesor")
     */
    public function soporteAsesor(Request $request, ManagerRegistry $doctrine): Response {
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
                return $this->redirectToRoute('soporte_asesor_informacion', ['id' => $arSoporte->getCodigoSoportePk()]);
            }
        }
        return $this->render('Inicio/soporteAsesor.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/soporte/asesor/informacion/{id}", name="soporte_asesor_informacion")
     */
    public function soporteAsesorInformacion($id): Response {
        return $this->render('Inicio/soporteAsesorInformacion.html.twig', [
            'codigoSoporte' => $id
        ]);
    }

    /**
     * @Route("/soporte/asesor/detalle/{id}", name="soporte_asesor_detalle")
     */
    public function soporteAsesorDetalle(Request $request, ManagerRegistry $doctrine, $id): Response {
        $em = $doctrine->getManager();
        $arSoporte = [];
        if($id) {
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
        return $this->render('Inicio/soporteAsesorDetalle.html.twig', [
            'arSoporte' => $arSoporte,
            'formBuscar' => $formBuscar->createView()
        ]);
    }

    /**
     * @Route("/soporte/comosehace", name="soporte_comosehace")
     */
    public function comoSeHace(): Response{
        return $this->render('Inicio/comoSeHace.html.twig');
    }

    /**
     * @Route("/contacto", name="contacto")
     */
    public function contacto(Request $request, ManagerRegistry $doctrine): Response {
        $em = $doctrine->getManager();
        $arSoporte = new Soporte();
        $arSoporte->setFecha(new \DateTime('now'));
        $form = $this->createForm(ContactoType::class, $arSoporte);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arSoporte = $form->getData();
                $em->persist($arSoporte);
                $em->flush();
                return $this->redirectToRoute('soporte_asesor_informacion', ['id' => $arSoporte->getCodigoSoportePk()]);
            }
        }
        return $this->render('Inicio/contacto.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/inicio/admin", name="inicio_admin")
     */
    public function admin(Dubnio $dubnio): Response
    {
        $em = $this->getDoctrine();
        $roles = $this->getUser()->getRoles();
        $soporteSinAtender = 0;
        $soporteSinSolucionar = 0;
        $soporteDia = 0;
        $soporteMes = 0;
        $arErrores = [];
        if (in_array('ROLE_SOPORTE', $roles) || in_array('ROLE_ADMIN', $roles)) {
            $soporteSinAtender = $em->getRepository(Soporte::class)->cantidadSoportesSinAtender();
            $soporteSinSolucionar = $em->getRepository(Soporte::class)->cantidadSoportesSinSolucion();
            $soporteDia = $em->getRepository(Soporte::class)->cantidadSoportesDia();
            $soporteMes = $em->getRepository(Soporte::class)->cantidadSoportesMes();
            $arErrores = $em->getRepository(Error::class)->resumenErrores();
        }
        return $this->render('Inicio/admin.html.twig', [
            'soporteSinAtender' => $soporteSinAtender,
            'soporteSinSolucionar' => $soporteSinSolucionar,
            'soporteDia' => $soporteDia,
            'soporteMes' => $soporteMes,
            'arErrores' => $arErrores
        ]);
    }

    /**
     * @Route("/inicio/usuario/perfil/clave/{codigoUsuario}", name="inicio_usuario_perfil_nuevo_clave")
     */
    public function cambiarContrasena(Request $request, $codigoUsuario): Response
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()
            ->add('txtNuevaClave', PasswordType::class, ['required' => true])
            ->add('txtConfirmacionClave', PasswordType::class, ['required' => true])
            ->add('btnActualizar', SubmitType::class, ['label' => 'Actualizar', 'attr' => ['class' => 'btn btn-sm btn-primary']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->get('btnActualizar')->isClicked()) {
                $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
                if ($arUsuario) {
                    if ($codigoUsuario === $this->getUser()->getCodigoUsuarioPk()) {
                        $claveNueva = $form->get('txtNuevaClave')->getData();
                        $claveConfirmacion = $form->get('txtConfirmacionClave')->getData();
                        if ($claveNueva == $claveConfirmacion) {
                            $arUsuario->setClave($claveNueva);
                            $em->persist($arUsuario);
                            $em->flush();
                            Mensajes::success("Cambio clave correcto");
                            echo "<script type='text/javascript'>window.close();window.opener.location.reload();</script>";
                        } else {
                            Mensajes::error("Las claves ingresadas deben ser iguales");
                        }
                    } else {
                        Mensajes::error("No se puede cambiar la clave de otro usuario");
                    }
                } else {
                    Mensajes::error("El usuario no existe");
                }
            }
        }

        return $this->render('Inicio/cambioClave.html.twig', [
            'form' => $form->createView()
        ]);
    }

}