<?php


namespace App\Controller\Api;


use App\Entity\Cliente;
use App\Entity\Error;
use App\Utilidades\Dubnio;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class ErrorController extends AbstractFOSRestController
{
    /**
     * @return array
     * @Rest\Post("/api/error/nuevo")
     */
    public function nuevo(Request $request, Dubnio $dubnio) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            $codigoCliente = $raw['codigoCliente']??null;
            $mensaje = $raw['mensaje']??null;
            $codigo = $raw['codigo']??null;
            $ruta = $raw['ruta']??null;
            $archivo = $raw['archivo']??null;
            $traza = $raw['traza']??null;
            $linea = $raw['linea']??null;
            $usuario = $raw['usuario']??null;
            $email = $raw['email']??null;
            $arCliente = null;
            $arError = new Error();
            $arError->setFecha(new \DateTime('now'));
            $arError->setMensaje($mensaje);
            $arError->setCodigo($codigo);
            $arError->setRuta($ruta);
            $arError->setArchivo($archivo);
            $arError->setTraza($traza);
            $arError->setLinea($linea);
            $arError->setUsuario($usuario);
            $arError->setEmail($email);
            if($codigoCliente) {
                $arCliente = $em->getRepository(Cliente::class)->find($codigoCliente);
                if($arCliente) {
                    $arError->setClienteRel($arCliente);
                }
            }

            $em->persist($arError);
            $em->flush();
            if($arCliente) {
                if($arCliente->getCorreoError()) {
                    $html = $this->renderView('Utilidades/correoError.html.twig', ['arError' => $arError]);
                    $dubnio->enviarCorreo("Se ha generado un error", $html, $arCliente->getCorreoError());
                }
            }
            return [
                'estado' => "ok",
            ];
        } catch (\Exception $e) {
            return [
                'error' => "Ocurrio un error en la api " . $e->getMessage(),
            ];
        }
    }

}
