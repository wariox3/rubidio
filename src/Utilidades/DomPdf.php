<?php

namespace App\Utilidades;

use Dompdf\Options;

class DomPdf
{

    public function __construct()
    {

    }

    public function generarPdf($html, $nombreArchivo)
    {
        $pdfOptions = new Options();
        $pdfOptions->set(array('defaultFont' => 'Arial', 'isPhpEnabled' => TRUE, 'isHtml5ParserEnabled' => true));
        $pdfOptions->setIsRemoteEnabled(true);
        // Crea una instancia de Dompdf con nuestras opciones
        $dompdf = new \Dompdf\Dompdf($pdfOptions);
        // Cargar HTML en Dompdf

//        dd($html);
        $dompdf->loadHtml($html);

        // (Opcional) Configure el tamaño del papel y la orientación 'vertical' o 'vertical'
        $dompdf->setPaper('A4', 'portrait');

        // Renderiza el HTML como PDF
        $dompdf->render();
//        $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
//        $dompdf->getCanvas()->page_text(72, 18, "Header: {PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));

        // Envíe el PDF generado al navegador (descarga forzada)
        $dompdf->stream("{$nombreArchivo}.pdf", [
            "Attachment" => true
        ]);
    }

}