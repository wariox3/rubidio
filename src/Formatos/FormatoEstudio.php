<?php

namespace App\Formatos;

use App\Entity\Estudio;
use App\Entity\EstudioDetalle;
use App\Entity\Funcionalidad;
use App\Entity\Requisito;

class FormatoEstudio extends \FPDF
{
    public static $em;
    public static $codigoEstudio;
    public function Generar($em, $codigoEstudio)
    {
        ob_clean();
        self::$em = $em;
        self::$codigoEstudio = $codigoEstudio;
        $pdf = new FormatoEstudio();
        $pdf->AddPage();
        $pdf->AliasNbPages();
        $pdf->SetFont('Times', '', 12);
        $this->Body($pdf);
        $pdf->Output("estudio{$codigoEstudio}.pdf", 'D');
    }

    public function Header()
    {

    }

    public function Body($pdf)
    {

        $fecha = new \DateTime('now');
        $pdf->Image('../public/imagenes/logoSemantica.jpg', 20, 13, 40, 25, 'JPG');
        $pdf->SetXY(110, 13);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(80, 4, utf8_decode("OPERACIÓN"), 0, 0, 'R', 0);
        $pdf->SetXY(110, 18);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(80, 4, utf8_decode("USUARIO PORTAL AUTOGESTIÓN"), 0, 0, 'R', 0);
        $pdf->SetXY(110, 22);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(40, 4, utf8_decode("Código: SD-OP-0001"  ), 0, 0, 'C', 0);
        $pdf->Cell(40, 4, utf8_decode("Versión: 001"  ), 0, 0, 'R', 0);
        $pdf->SetXY(110, 26);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(40, 4, utf8_decode("Tipo Doc: Formato"  ), 0, 0, 'C', 0);
        $pdf->Cell(40, 4, utf8_decode("Fecha: {$fecha->format('Y-m-d')}"  ), 0, 0, 'R', 0);
        $pdf->SetXY(110, 30);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(40, 4, utf8_decode("Clasificación: interna"  ), 0, 0, 'C', 0);
        $pagina = "Página {$pdf->PageNo()}";
        $pdf->Cell(40, 4, utf8_decode($pagina), 0, 0, 'R', 0);

        $arEstudio = self::$em->getRepository(Estudio::class)->imprimir(self::$codigoEstudio);
        $ejeX = 20;
        $ejeY = 50;
        $pdf->SetFont('Arial', '', 12);
        $pdf->Text($ejeX, $ejeY, utf8_decode("Medellín, Antioquia {$arEstudio['fecha']->format('M j \d\e Y')}"));
        $ejeY += 10;
        $pdf->Text($ejeX, $ejeY, utf8_decode("Señores"));
        $ejeY += 5;
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Text($ejeX, $ejeY, utf8_decode($arEstudio['clienteNombreCorto']?$arEstudio['clienteNombreCorto']:$arEstudio['empresa']));
        $ejeY += 15;
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Text($ejeX, $ejeY, utf8_decode("Asunto: "));
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY($ejeX+20, $ejeY-4);
        $pdf->MultiCell(150, 5, utf8_decode("Estudio de viabilidad y factibilidad funcionalidades vs Procesos y necesidades de nuestro cliente"), 0, 'j', false);

        $ejeY += 10;
        $pdf->SetXY($ejeX, $ejeY);
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(168, 5, utf8_decode("Para continuar el proceso comercial entre las partes queremos garantizar que nuestros productos cumplan con las siguientes condiciones:"), 0, 'j', false);
        $ejeY += 15;
        $pdf->SetXY($ejeX, $ejeY);
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(168, 5, utf8_decode("Factibilidad: Es el que hace una empresa para determinar la posibilidad de poder desarrollar un proyecto que espera implementar. No obstante, este tipo de estudio le permite a la empresa conocer si el proyecto que espera emprender le pueda resultar favorable o desfavorable. También le ayuda a establecer el tipo de estrategias que le pueden ayudar para que pueda llegar a alcanzar el éxito. "), 0, 'J', false);
        $ejeY += 35;
        $pdf->SetXY($ejeX, $ejeY);
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(168, 5, utf8_decode("Viabilidad: Es un análisis de investigación en el que se tienen en cuenta todos los factores relevantes que afectan al proyecto -incluyendo las consideraciones económicas, técnicas, legales, planificación- para determinar la probabilidad de completar el proyecto con éxito. Del mismo modo, un estudio de viabilidad también está diseñado para identificar posibles problemas que puedan surgir al llevar a cabo el proyecto. "), 0, 'J', false);
        $ejeY += 35;
        $pdf->SetXY($ejeX, $ejeY);
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(168, 5, utf8_decode("Con la firma de este documento el cliente garantiza que es viable y factible implementar el Software. No olvide revisar los compromisos de las partes ya que serán parte integral del contrato de implementacion. Las caracteristicas tecnicas en detalle las puede encontrar en www.semantica.com.co"), 0, 'J', false);

        $ejeY += 40;
        $pdf->Text($ejeX, $ejeY, "Atentamente.");

        $ejeY += 30;
        $pdf->SetXY($ejeX, $ejeY);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Text(20, $ejeY, utf8_decode("MARIO ANDRES ESTRADA ZULUAGA"));
        $pdf->Text(120, $ejeY, utf8_decode($arEstudio['responsable']));

        $ejeY +=5;
        $pdf->SetFont('Arial', '', 12);
        $pdf->Text(20, $ejeY, utf8_decode("Representante Legal"));
        $pdf->Text(120, $ejeY, utf8_decode("Responsable cliente"));

        $ejeY +=5;
        $pdf->SetXY($ejeX, $ejeY);
        $pdf->Text(20, $ejeY, utf8_decode("investigacion@semantica.com.co"));

        $arEstudioDetalles = self::$em->getRepository(EstudioDetalle::class)->imprimirEstudio(self::$codigoEstudio);
        foreach ($arEstudioDetalles as $arEstudioDetalle){
            $pdf->AddPage();


            $pdf->SetFont('Arial', 'B', 16);
            $pdf->SetY(20);
            $pdf->Cell(184, 4, strtoupper($arEstudioDetalle['moduloNombre']), 0, 0, 'C', 0);
            $pdf->Ln();

            $pdf->SetFillColor(200, 200, 200);
            $pdf->SetTextColor(0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetLineWidth(.2);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetXY(20,30);
            $pdf->Cell(150, 6, utf8_decode("FUNCIONALIDAD"), 1, 0, 'C', 1);
            $pdf->Cell(24, 6, utf8_decode("REVISADO"), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetX(20);
            $pdf->Cell(50, 6, utf8_decode("Funcion"), 1, 0, 'C', 1);
            $pdf->Cell(100, 6, utf8_decode("Caracteristica"), 1, 0, 'C', 1);
            $pdf->Cell(12, 6, utf8_decode("SI"), 1, 0, 'C', 1);
            $pdf->Cell(12, 6, utf8_decode("NO"), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetFont('Arial', '', 12);
            $arFuncionalidades = self::$em->getRepository(Funcionalidad::class)->imprimirEstudio($arEstudioDetalle['codigoModuloFk']);
            foreach ($arFuncionalidades as $arFuncionalidad) {
                $pdf->SetX(20);
                $pdf->Cell(50, 6, utf8_decode($arFuncionalidad['codigoFuncionFk']), 1, 0, 'L', 0);
                $pdf->Cell(100, 6, utf8_decode($arFuncionalidad['nombre']), 1, 0, 'L', 0);
                $pdf->Cell(12, 6, '', 1, 0, 'C', 0);
                $pdf->Cell(12, 6, '', 1, 0, 'C', 0);
                $pdf->Ln();
            }
            $pdf->Ln(20);

            // Requisitos
            $pdf->SetFillColor(200, 200, 200);
            $pdf->SetTextColor(0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetLineWidth(.2);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetX(20);
            $pdf->Cell(150, 6, utf8_decode("REQUISITOS"), 1, 0, 'C', 1);
            $pdf->Cell(24, 6, utf8_decode("REVISADO"), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetX(20);
            $pdf->Cell(150, 6, utf8_decode(""), 1, 0, 'C', 1);
            $pdf->Cell(12, 6, utf8_decode("SI"), 1, 0, 'C', 1);
            $pdf->Cell(12, 6, utf8_decode("NO"), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetFont('Arial', '', 12);
            $arFuncionalidades = self::$em->getRepository(Requisito::class)->imprimirEstudio($arEstudioDetalle['codigoModuloFk']);
            foreach ($arFuncionalidades as $arFuncionalidad) {
                $pdf->SetX(20);
                $pdf->Cell(150, 6, utf8_decode($arFuncionalidad['nombre']), 1, 0, 'L', 0);
                $pdf->Cell(12, 6, '', 1, 0, 'C', 0);
                $pdf->Cell(12, 6, '', 1, 0, 'C', 0);
                $pdf->Ln();
            }

            $pdf->Ln(30);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetX(20);
            $pdf->Cell(120, 6, utf8_decode("FIRMA RESPONSABLE VALIDACION"), 'T', 0, 'L', 1);
            $pdf->Ln();
            $pdf->SetX(20);
            $pdf->Cell(120, 6, utf8_decode($arEstudioDetalle['responsable']), 0, 0, 'L', 1);


        }


    }

    public function Footer()
    {
        $this->SetFont('Arial', '', 8);
        $this->Text(170, 290, utf8_decode('Página ') . $this->PageNo() . ' de {nb}');
    }
}