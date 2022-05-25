<?php

namespace App\Formatos;

use App\Entity\Cliente;
use App\Entity\Configuracion;
use App\Entity\Implementacion;
use App\Entity\ImplementacionDetalle;
use Symfony\Component\HttpFoundation\Response;


class  FormatoPlanTrabajo extends \FPDF
{

    public static $em;
    public static $codigoImplementacion;
    public static $codigoCliente;
    public static $temas;
    public static $imagen;

    public function Generar($em, $codigoImplementacion)
    {
        ob_clean();
        self::$em = $em;
        self::$codigoImplementacion = $codigoImplementacion;
        $pdf = new FormatoPlanTrabajo();
        $pdf->AddPage();
        $pdf->AliasNbPages();
        $pdf->SetFont('Times', '', 12);
        $this->Body($pdf);
        $pdf->Output("planTrabajo.pdf", 'D');


    }

    public function Header()
    {
        $this->SetFont('Arial', '', 5);
        $date = new \DateTime('now');
        $this->Text(168, 8, $date->format('Y-m-d H:i:s') . ' [Cromo | ERP]');
        $this->SetFillColor(200, 200, 200);
        $this->SetFont('Arial', 'B', 10);
        //Logo
        $this->SetXY(53, 10);

        try {
            $imagen = self::getLogo();
            $this->Image($imagen['imagen'], 12, 10, 40, 25,$imagen['extension']);
        } catch (\Exception $exception) {
        }
        $this->Cell(147, 7, utf8_decode("PLAN DE TRABAJO IMPLEMENTACION"), 0, 0, 'C', 1);
        //INFORMACIÓN EMPRESA
        $this->SetXY(53, 18);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(20, 4, "EMPRESA:", 0, 0, 'L', 1);
        $this->Cell(100, 4, utf8_decode("SEMANTICA DIGITAL S.A.S"), 0, 0, 'L', 0);
        $this->SetXY(53, 22);
        $this->Cell(20, 4, "NIT:", 0, 0, 'L', 1);
        $this->Cell(100, 4, "901192048 - 4 ", 0, 0, 'L', 0);
        $this->SetXY(53, 26);
        $this->Cell(20, 4, utf8_decode("DIRECCIÓN:"), 0, 0, 'L', 1);
        $this->Cell(100, 4, "CALLE 34 Nro. 66A - 33 OFICINA 201" , 0, 0, 'L', 0);
        $this->SetXY(53, 30);
        $this->Cell(20, 4, utf8_decode("TELÉFONO:"), 0, 0, 'L', 1);
        $this->Cell(100, 4, "5578945" , 0, 0, 'L', 0);
        $this->Ln(10);
    }


    public function Body($pdf)
    {
        //$arImplementacion = self::$em->getRepository(Implementacion::class)->find(self::$codigoImplementacion);
        $header = array('MODULO', 'COMPROMISO', 'TER', 'TEMA', 'DESCRIPCIÓN');
        $pdf->SetFillColor(200, 200, 200);
        $pdf->SetTextColor(0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetLineWidth(.2);
        $pdf->SetFont('Arial', 'B', 7);

        //Creamos la cabecera de la tabla.
        $w = array(25, 22, 7, 40, 100);
        for ($i = 0; $i < count($header); $i++) {
            $pdf->Cell($w[$i], 4, utf8_decode($header[$i]), 1, 0, 'C', 1);
        }
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 7);
        $arImplementacionDetalles = self::$em->getRepository(ImplementacionDetalle::class)->formatoPlanTrabajo(self::$codigoImplementacion);
        foreach ($arImplementacionDetalles AS $arImplementacionDetalle) {
            $pdf->Cell(25, 4, $arImplementacionDetalle['moduloNombre'], 1, 0, 'L');
            $pdf->Cell(22, 4, $arImplementacionDetalle['fechaCompromiso']?$arImplementacionDetalle['fechaCompromiso']->format('Y-m-d H:i'):"", 1,0, 'L');
            $pdf->Cell(7, 4, $arImplementacionDetalle['estadoTerminado']?"SI":"NO", 1,0, 'L');
            $pdf->Cell(40, 4, utf8_decode($arImplementacionDetalle['temaNombre']), 1, 0, 'L');
            //$pdf->Cell(100, 4, substr(utf8_decode($arImplementacionDetalle->getTemaRel()->getDescripcion()), 0, 110), 1, 0, 'L');
            $pdf->MultiCell(100, 4, utf8_decode($arImplementacionDetalle['temaDescripcion']), 1);
        }
        $pdf->Ln();

        $pdf->Cell(80, 10, "Para tener en cuenta: La inasistencia a los compromisos sin previo aviso, da por terminado el tema", 0, 0, 'L');
        //$pdf->SetXY(110,260);
        //$pdf->Cell(80, 10, "FIRMA CLIENTE", 'T', 1, 'C');
    }

    public function Footer()
    {
        $this->SetFont('Arial', '', 8);
        $this->Text(170, 290, utf8_decode('Página ') . $this->PageNo() . ' de {nb}');
    }

    public function getLogo(){
        $arConfiguracion = self::$em->getRepository(Configuracion::class)->find(1);
        try {
            if(!self::$imagen){
                $imagenBase64 = base64_encode(stream_get_contents($arConfiguracion->getLogo()));
                $imagen = "data:image/png';base64," . $imagenBase64;
                self::$imagen = $imagen;
            }else{
                $imagen=self::$imagen;
            }

            return [
                'imagen' => $imagen,
                'extension' => 'png',
            ];
        } catch (\Exception $exception) {
        }
    }
}
