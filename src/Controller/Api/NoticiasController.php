<?php


namespace App\Controller\Api;


use App\Entity\Noticia;
use App\Utilidades\Noticias;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;


class NoticiasController extends AbstractFOSRestController
{
	/**
	 * @Rest\Post("/api/noticas/lista")
	 */
	public function lista(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$raw = json_decode($request->getContent(), true);
		$arRegistros = $em->getRepository(Noticia::class)->apiLista();
		return $arRegistros;
	}

    /**
     * @Rest\Post("/api/noticias/listamovil")
     */
    public function listaMovil(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        return $em->getRepository(Noticia::class)->apiListaMovil();
    }

    /**
     * @Rest\Get("/api/noticas/extraer")
     */
    public function extraer(Noticias $noticias)
    {
        $noticias->extraer();
        return [
            'error' => false
        ];
    }
}