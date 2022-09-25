<?php

namespace App\Utilidades;

use Dompdf\Options;

class DomPdf
{

    public function __construct()
    {

    }

    public function generarPdf($html, $nombreArchivo) {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Crea una instancia de Dompdf con nuestras opciones
        $dompdf = new \Dompdf\Dompdf($pdfOptions);

        // Cargar HTML en Dompdf
        $dompdf->loadHtml($html);

        // (Opcional) Configure el tamaño del papel y la orientación 'vertical' o 'vertical'
        $dompdf->setPaper('A4', 'portrait');

        // Renderiza el HTML como PDF
        $dompdf->render();

        // Envíe el PDF generado al navegador (descarga forzada)
        $dompdf->stream("{$nombreArchivo}.pdf", [
            "Attachment" => true
        ]);
    }

}