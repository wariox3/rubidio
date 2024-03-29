<?php

namespace App\Controller;

use App\Entity\Articulo;
use App\Entity\Caso;
use App\Entity\Error;
use App\Entity\Tarea;
use App\Entity\Usuario;
use App\Utilidades\Dubnio;
use App\Utilidades\Mensajes;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InicioController extends AbstractController
{
    /**
     * @Route("/", name="inicio")
     */
    public function inicio(ManagerRegistry $doctrine): Response {
        $em = $doctrine->getManager();
        $arArticulos = $em->getRepository(Articulo::class)->lista();
        $arrNoticias = [];
        return $this->render('Inicio/inicio.html.twig', [
            'arArticulos' => $arArticulos
        ]);
    }

    /**
     * @Route("/inicio/admin", name="inicio_admin")
     */
    public function admin(Dubnio $dubnio): Response
    {
        $em = $this->getDoctrine();
        $roles = $this->getUser()->getRoles();
        $arErrores = [];
        if (in_array('ROLE_SOPORTE', $roles) || in_array('ROLE_ADMIN', $roles)) {
            $arErrores = $em->getRepository(Error::class)->resumenErrores();
        }
        $arTareasPendientes = $em->getRepository(Tarea::class)->listaInicio($this->getUser()->getCodigoUsuarioPk());
        return $this->render('Inicio/admin.html.twig', [
            'arErrores' => $arErrores,
            'arTareas' => $arTareasPendientes
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