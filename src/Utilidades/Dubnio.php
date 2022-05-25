<?php

namespace App\Utilidades;

class Dubnio
{

    public function __construct()
    {

    }

    public function enviarCorreo($asunto, $mensaje, $correo) {
        $datosJson = json_encode([
            "correo" => $correo,
            "asunto" => $asunto,
            "contenido" => $mensaje
        ]);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://104.248.81.122/dubnio/public/index.php/api/correo/enviar');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datosJson);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($datosJson))
        );
        curl_exec($ch);
        curl_close($ch);
    }

}