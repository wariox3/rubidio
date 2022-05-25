<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Forms\Type\FormTypeLogin;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function accesoAction(Request $request, AuthenticationUtils $authenticationUtils){

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();


        return $this->render('Login/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));

//        $form = $this->createForm(FormTypeLogin::class, null, array(
//            'action' => $this->generateUrl("acceso"),
//            )
//        );
//
//        $form->handleRequest($request);
//
//        // replace this example code with whatever you need
//        return $this->render('Loginlogin.html.twig', [
//            'form' => $form->createView(),
//        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction(){
        throw new \RuntimeException('Esta funcion jamas debe ser llamada directamente');
    }


}
