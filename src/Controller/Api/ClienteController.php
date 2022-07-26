<?php


namespace App\Controller\Api;


use App\Entity\Cliente;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


class ClienteController extends AbstractFOSRestController
{
	/**
	 * @Rest\Post("/api/cliente/servicio")
	 */
	public function servicio(Request $request)
	{
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoOperador = $raw['codigoOperador'] ?? null;
        if ($codigoOperador) {
            return $em->getRepository(Cliente::class)->apiConectarServicio($codigoOperador);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
	}

}