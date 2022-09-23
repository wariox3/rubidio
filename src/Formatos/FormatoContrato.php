<?php

namespace App\Formatos;

use App\Entity\Contrato;
use App\Entity\Estudio;
use App\Entity\EstudioDetalle;
use App\Entity\Funcionalidad;
use App\Entity\Requisito;

class FormatoContrato extends \FPDF
{
    public static $em;
    public static $codigoContrato;
    public function Generar($em, $codigoContrato)
    {
        ob_clean();
        self::$em = $em;
        self::$codigoContrato = $codigoContrato;
        $pdf = new FormatoContrato();
        $pdf->AddPage();
        $pdf->AliasNbPages();
        $pdf->SetFont('Times', '', 12);
        $this->Body($pdf);
        $pdf->Output("contrato{$codigoContrato}.pdf", 'D');
    }

    public function Header()
    {

    }

    public function Body($pdf)
    {

        $fecha = new \DateTime('now');
        $pdf->Image('../public/imagenes/logoSemantica.jpg', 20, 13, 40, 25, 'JPG');
        $pdf->SetXY(110, 13);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(80, 4, utf8_decode("COMERCIAL"), 0, 0, 'R', 0);
        $pdf->SetXY(110, 18);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(80, 4, utf8_decode("ESTUDIO FUNCIONALIDAD"), 0, 0, 'R', 0);
        $pdf->SetXY(110, 22);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(40, 4, utf8_decode("Código: SD-CM-0002"  ), 0, 0, 'L', 0);
        $pdf->Cell(40, 4, utf8_decode("Versión: 001"  ), 0, 0, 'R', 0);
        $pdf->SetXY(110, 26);
        $pdf->Cell(40, 4, utf8_decode("Tipo Doc: Formato"  ), 0, 0, 'L', 0);
        $pdf->Cell(40, 4, utf8_decode("Fecha: {$fecha->format('Y-m-d')}"  ), 0, 0, 'R', 0);
        $pdf->SetXY(110, 30);
        $pdf->Cell(40, 4, utf8_decode("Clasificación: interna"  ), 0, 0, 'L', 0);
        $pagina = "Página {$pdf->PageNo()}";
        $pdf->Cell(40, 4, utf8_decode($pagina), 0, 0, 'R', 0);

        $arContrato = self::$em->getRepository(Contrato::class)->imprimir(self::$codigoContrato);
        $pdf->SetXY(10, 30);
        $pdf->MultiCell(0,5,$this->texto());
        // Salto de línea
        $this->Ln();

    }

    public function Footer()
    {
        $this->SetFont('Arial', '', 8);
        $this->Text(170, 290, utf8_decode('Página ') . $this->PageNo() . ' de {nb}');
    }

    private function texto() {
        $texto = "Prueba";
        return $texto;
    }
}