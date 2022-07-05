<?php

namespace App\Formatos;

use App\Entity\Estudio;

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
        $pdf->SetFont('Arial', '', 10);
        $date = new \DateTime('now');
        $ejeX = 20;
        $ejeY = 8;
        $pdf->Text($ejeX, $ejeY, utf8_decode("Medellín, Antioquia {$date->format('Y-m-d H:i:s')}"));
        $ejeY += 10;
        $pdf->Text($ejeX, $ejeY, utf8_decode("Señor"));
        $ejeY += 5;
        $pdf->Text($ejeX, $ejeY, "pepito perez");
        $ejeY += 5;
        $pdf->Text($ejeX, $ejeY, "Gerente Operativo");
        $ejeY += 5;
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Text($ejeX, $ejeY, "CONCESIONARIA COVIAL S.A.");
        $ejeY += 15;
        $pdf->SetFont('Arial', '', 10);
        $pdf->Text($ejeX, $ejeY, utf8_decode("Asunto: Viabilidad y factibilidad de nuestros procesos técnicos Semántica ERP vs Procesos administrativos."));
        $ejeY += 5;
        $pdf->SetXY($ejeX, $ejeY);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(168, 5, utf8_decode("Para continuar el proceso comercial entre las partes queremos garantizar que nuestro producto Semántica ERP cumpla con las siguientes condiciones:"), 0, 'j', false);
        $ejeY += 15;
        $pdf->SetXY($ejeX, $ejeY);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(168, 5, utf8_decode("Estudio factibilidad: Es el que hace una empresa para determinar la posibilidad de poder desarrollar un proyecto que espera implementar. No obstante, este tipo de estudio le permite a la empresa conocer si el proyecto que espera emprender le pueda resultar favorable o desfavorable. También le ayuda a establecer el tipo de estrategias que le pueden ayudar para que pueda llegar a alcanzar el éxito. "), 0, 'J', false);
        $ejeY += 35;
        $pdf->SetXY($ejeX, $ejeY);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(168, 5, utf8_decode("Estudio viabilidad: Es un análisis de investigación en el que se tienen en cuenta todos los factores relevantes que afectan al proyecto -incluyendo las consideraciones económicas, técnicas, legales, planificación- para determinar la probabilidad de completar el proyecto con éxito. Del mismo modo, un estudio de viabilidad también está diseñado para identificar posibles problemas que puedan surgir al llevar a cabo el proyecto. "), 0, 'J', false);
        $ejeY += 35;
        $pdf->SetXY($ejeX, $ejeY);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(168, 5, utf8_decode("Con la firma de este documento el cliente garantiza que es viable y factible implementar el Software. No olvide revisar los compromisos de las partes ya que serán parte integral del contrato entre las partes."), 0, 'J', false);

        $ejeY += 20;
        $pdf->Text($ejeX, $ejeY, "Atentamente.");

        $pdf->SetXY($ejeX, 200);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(80, 10, "MARIO ANDRES ESTRADA ZULUAGA", 0, 1, 'L');
        $pdf->SetXY($ejeX, 205);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(80, 10, "Representante Legal", 0, 1, 'L');
        $pdf->SetXY($ejeX, 210);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(80, 10, "investigacion@semantica.com.co", 0, 1, 'L');
        $pdf->SetXY(100,200);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(80, 10, "PEPITO DE LOS PALOTES ", 0, 1, 'L');
        $pdf->SetXY(100, 205);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(80, 10, "Responsable cliente", 0, 1, 'L');

        $arModulos = self::$em->getRepository(Estudio::class)->modulos(self::$codigoEstudio);

        foreach ($arModulos as $nombreModulo => $modulo){
            if($modulo){
                $pdf->AddPage();
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(184, 4, strtoupper($nombreModulo), 0, 0, 'C', 0);
                $pdf->Ln();
                $pdf->setY(16);
                $header = array('FUNCIONALIDAD', 'VALIDADO');
                $pdf->SetFillColor(200, 200, 200);
                $pdf->SetTextColor(0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetLineWidth(.2);
                $pdf->SetFont('Arial', 'B', 7);

                //Creamos la cabecera de la tabla.
                $w = array(140, 44);
                for ($i = 0; $i < count($header); $i++) {
                    $pdf->SetFont('Arial', '', 12);
                    $pdf->Cell($w[$i], 6, utf8_decode($header[$i]), 1, 0, 'C', 1);
                }

                $header = array('Funcion', 'Nombre', 'SI', 'NO');
                $pdf->SetFillColor(200, 200, 200);
                $pdf->SetTextColor(0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetLineWidth(.2);
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->SetY(22);
                //Creamos la cabecera de la tabla.
                $w = array(30, 110, 22, 22);
                for ($i = 0; $i < count($header); $i++) {
                    $pdf->SetFont('Arial', '', 12);
                    $pdf->Cell($w[$i], 6, utf8_decode($header[$i]), 1, 0, 'C', 1);
                }


                $contenido = [
                    ['funcion' => 'Movimiento', 'nombre'=> 'Solicitud'],
                    ['funcion' => 'Movimiento', 'nombre'=> 'Entradas'],
                    ['funcion' => 'Movimiento', 'nombre'=> 'Salidas'],
                    ['funcion' => 'Movimiento', 'nombre'=> 'Traslado'],
                    ['funcion' => 'Movimiento', 'nombre'=> "Entrada control 'comodato'"],
                    ['funcion' => 'Movimiento', 'nombre'=> "Salida control 'comodato'"],
                    ['funcion' => 'Movimiento', 'nombre'=> 'Entrega'],
                    ['funcion' => 'Administración', 'nombre'=> 'Bodega, ubicacion, tercero'],
                    ['funcion' => 'Administración', 'nombre'=> 'Clasificación de los ítem por línea, grupo subgrupo'],
                    ['funcion' => 'Administración', 'nombre'=> 'Marca'],
                    ['funcion' => 'Proceso', 'nombre'=> 'Sincronizar puestos (turnos) con ubicación'],
                    ['funcion' => 'Proceso', 'nombre'=> 'Traslado masivo'],
                    ['funcion' => 'Informe', 'nombre'=> 'Kardex'],
                    ['funcion' => 'Informe', 'nombre'=> 'Inventario valorizado a un corte'],
                    ['funcion' => 'Informe', 'nombre'=> 'Existencia por ítem'],
                    ['funcion' => 'Informe', 'nombre'=> 'Existencia por lote'],
                    ['funcion' => 'Informe', 'nombre'=> 'Existencia con datos de puesto'],
                    ['funcion' => 'Informe', 'nombre'=> 'Rotación item'],
                    ['funcion' => 'Informe', 'nombre'=> 'Control de stock'],
                ];
                $pdf->Ln();
                foreach ($contenido as $item){
                    $pdf->SetFont('Arial', '', 12);
                    $pdf->Cell(30, 6, utf8_decode($item['funcion']), 1, 0, 'L', 0);
                    $pdf->SetFont('Arial', '', 12);
                    $pdf->Cell(110, 6, utf8_decode($item['nombre']), 1, 0, 'L', 0);
                    $pdf->Cell(22, 6, '', 1, 0, 'C', 0);
                    $pdf->Cell(22, 6, '', 1, 0, 'C', 0);
                    $pdf->Ln();
                }
            }


        }


    }

    public function Footer()
    {
        $this->SetFont('Arial', '', 8);
        $this->Text(170, 290, utf8_decode('Página ') . $this->PageNo() . ' de {nb}');
    }
}