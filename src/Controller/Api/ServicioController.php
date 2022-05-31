<?php


namespace App\Controller\Api;


use App\Entity\Cliente;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


class ServicioController extends AbstractFOSRestController
{
	/**
	 * @Rest\Post("/api/servicio/verificar")
	 */
	public function lista(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$raw = json_decode($request->getContent(), true);
		$codigoCliente = $raw['codigoCliente']??null;
        if($codigoCliente) {
            return $em->getRepository(Cliente::class)->apiVerificarSoporte($codigoCliente);
        } else {
            return [
                'error' => true,
                'errorMensaje' => "Faltan datos para el consumo de la api"

            ];
        }
	}

}