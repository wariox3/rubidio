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
        $pdf->SetXY(15, 50);
        $pdf->MultiCell(0,5, utf8_decode($this->texto()));
        // Salto de línea
        $this->Ln();

    }

    public function Footer()
    {
        $this->SetFont('Arial', '', 8);
        $this->Text(170, 290, utf8_decode('Página ') . $this->PageNo() . ' de {nb}');
    }

    private function texto() {
        $texto = "CONTRATO DE ARRENDAMIENTO SOFTWARE DENOMINADO SEMANTICA ERP 
Entre los suscritos a saber: SEMANTICA DIGITAL S.A.S, sociedad comercial legalmente constituida, identificada con Nit. 901.192.048-4, constituida por documento privado del 21 de junio de 2018, registrada en la Cámara de Comercio de Medellín con matrícula mercantil No. 21-619976-12 en el libro 9, bajo el número 289, representada legalmente en este acto por MARIO ANDRÉS ESTRADA ZULUAGA, mayor de edad, vecino y domiciliado en calle 34 N 66A-33 Oficina 201, identificado con la cédula de ciudadanía 70.143.08 quien en adelante se denominará EL LICENCIANTE, de una parte, y de la otra __________________________, identificado con la cédula de ciudadanía Nro. _________________ de __________, domiciliado en ____________, quien para efectos del presente contrato se denominará el LICENCIATARIO, se ha celebrado el siguiente contrato de licencia de uso del soporte lógico (software), indicado en líneas anteriores, el cual se regirá́ por las siguientes clausulas: 
CLAUSULA PRIMERA: OBJETO: EL LICENCIANTE se compromete a conceder al LICENCIATARIO la licencia de uso no exclusiva, del soporte lógico o software denominado Semántica ERP. 
CLAUSULA SEGUNDA: CARACTERÍSTICAS DEL SOFTWARE. El programa que se entrega al LICENCIATARIO a título de licencia, comprende las siguientes características generales:
Financiero y, contabilidad.
Inventario
Recurso humano, nomina, seguridad social
Compras
Facturación y ventas
CRM
Cartera y tesorería
El LICENCIATARIO declara conocer y aceptar los contenidos y funciones del software descrito. 
CLAUSULA TERCERA: CONDICIONES GENERALES DEL SERVICIO: Los servicios se prestarán en los siguientes términos y condiciones generales:
EL LICENCIANTE responderá por la calidad del trabajo desarrollado con la diligencia exigible a una empresa experta en la realización de los trabajos objeto del contrato.
Ambas partes responderán de las infracciones en que pudiera incurrir en el caso que destinen los datos personales a otra finalidad, los comuniquen a un tercero, o en general, los utilicen de forma irregular. 
EL LICENCIANTE deberá adoptar las medidas de índole técnicas y organizativas necesarias que garanticen la seguridad de los datos de carácter personal y eviten su alteración, pérdida, tratamiento o acceso no autorizado, habida cuenta del estado de la tecnología, la naturaleza de los datos almacenados o del medio físico o natural. A estos efectos EL CONTRATISTA deberá aplicar los niveles de seguridad de acuerdo a la naturaleza de los datos que trate.
CLAUSULA CUARTA - CONDICIONES ESPECÍFICAS DE LA PRESTACIÓN DEL SERVICIO: EL CONTRATISTA prestara los servicios en los siguientes términos y condiciones específicos:
EL LICENCIANTE dispondrá de una dirección de acceso para que EL LICENCIATARIO use el software.
Mantenimiento a las bases de datos del software llamado “SEMANTICA ERP”.
Actualización al producto “SEMANTICA ERP” en relación con la normatividad colombiana.
Adecuación de nuevos cambios y métodos que permitan tener un mejor proceso en el desempeño del producto “SEMANTICA ERP”.
CLAUSULA QUINTA - CESIÓN: Dado que el presente contrato lo celebra el CONTRATANTE en consideración a las calidades profesionales del CONTRATISTA, teniendo por lo tanto el carácter de “Intuito Persona”, El CONTRATISTA no podrá ceder en todo o en parte el presente contrato sin la previa autorización escrita del CONTRATANTE.

CLAUSULA SEXTA: CLAUSULA DE CONFIDENCIALIDAD. EL CONTRATISTA se obliga a no divulgar, entregar y/o hacer uso en beneficio propio o de alguna otra persona natural o jurídica, de la información adquirida acerca de EL CONTRATANTE, incluyendo conocimiento sobre las actividades, planes, programas, productos y documentos a que hubiere tenido acceso y a mantener el más alto grado de confidencialidad en relación con ésta información.
Esta información no podrá ser revelada a terceros bajo ninguna circunstancia, sin que medie autorización escrita de EL CONTRATANTE, a menos que dicha información sea de público conocimiento en el momento de ser revelada o que la parte receptora la hubiera conocido por un tercero de buena fe, con derecho de disposición sobre esa información. En caso de que EL CONTRATISTA sea requerido a dar esa información por orden de autoridad competente, éste notificará inmediatamente a EL CONTRATANTE de tal situación.
La información confidencial incluye, pero no se limita a: 1) Información técnica, jurídica y financiera de EL CONTRATANTE. 2.) Políticas y estrategias empresariales. 3.) Metodologías y procesos, 4.) Planes de productos y servicios, 5.) Información de precios, 6.) Información de mercadeo, análisis y proyecciones. 7.) Secretos empresariales, 8.) Knowhow. 9.) Frecuencias utilizadas por CONTRATANTE.  10.) Nombres y datos de EL CONTRATANTE.
EL CONTRATISTA se compromete y obliga a que durante toda la vigencia del contrato y hasta un tiempo de cinco (5) años posteriores a su terminación, no comunicará a terceros ni usará en su provecho o en el de terceros las informaciones que por razón de su encargo haya podido conocer, las cuales son estrictamente de naturaleza reservada y cuya divulgación puede ocasionar perjuicios a EL CONTRATANTE.

CLAUSULA SEPTIMA: ACUERDO DE NIVEL DE SERVICIO: El Servicio prestado por el CONTRATISTA se realizará por personal especializado en cada materia. El personal del CONTRATISTA acudirá provisto de todo el material necesario, adecuado y actualizado, para prestar el servicio. Los tiempos de respuesta se fijan a continuación:
Crítica o error técnico: 6 horas hábiles. Se entiende por incidencia crítica en el marco de la prestación de los servicios, aquellas que afectan significativamente a EL CONTRATANTE y lo imposibilite para el uso del software.
Grave: 8 horas hábiles. Se entiende por incidencia grave en el marco de la prestación de los servicios, aquellos que dificultan moderadamente las actividades informáticas de EL CONTRATANTE, en opinión de ambas partes. 
Leve: 2 días hábiles. Se entiende por incidencia leve cuando se limitan a entorpecer el trabajo o anomalías que se muestran de manera aleatoria, en opinión de ambas partes.
CLAUSULA OCTAVA: VIGENCIA Y DURACION: La validez de este contrato está regulada por la legislación vigente y su término de duración es de un (1) año contado a partir del  01 de diciembre de 2020

CLAUSULA NOVENA: PRECIO Y FACTURACIÓN. El CONTRATANTE pagara al CONTRATISTA mensualmente UN MILLON DE PESOS ($1.000.000) más impuestos de ley por el objeto del contrato. Los cuales se empiezan a facturar con el inicio del proceso de implementación.
PARÁGRAFO PRIMERO: La facturación se realizara mes anticipado y será presentada a El CONTRATANTE dentro de los primeros 15 días de cada mes.
PARÁGRAFO SEGUNDO: El pago de la factura se hará mediante transferencia bancaria a la cuenta de ahorros N° 551-956141-04 de  Bancolombia  a nombre de SEMANTICA DIGITAL S.A.S.
PARÁGRAFO TERCERO: En el momento que EL CONTRATANTE incumpla las obligaciones generadas en la cláusula novena, faculta al CONTRATISTA a suspender el servicio entre tanto no haga el pago pendiente más el interés causado.

CLAUSULA DÉCIMA - MODIFICACIÓN: Las Partes podrán modificar el contrato de mutuo acuerdo y por escrito.
CLAUSULA DÉCIMA PRIMERA  - RESOLUCIÓN: Las Partes podrán resolver el Contrato, con derecho a la indemnización de daños y perjuicios causados, en caso de incumplimiento de las obligaciones establecidas en el mismo.
CLAUSULA DÉCIMA SEGUNDA - REGIMEN JURÍDICO: El presente contrato tiene carácter mercantil, no existiendo en ningún caso vínculo laboral alguno entre el CONTRATANTE y el personal del CONTRATISTA que preste concretamente los servicios.
  
CLAUSULA DÉCIMA TERCERA: Las partes manifiestan que aceptan libremente todas y cada una las cláusulas contenidas en el presente contrato de CONTRATO DE ARRENDAMIENTO SOFTWARE DENOMINADO SEMANTICA ERP, y que este contrato deje sin efectos los que se hayan suscrito previamente las partes y por el mismo objeto. 
En señal de conformidad se firma el presente documento en dos ejemplares, el día 25  de Marzo del año 2022. 



MARIO ANDRÉS ESTRADA ZULUAGA	GALLARDO AGUDELO MAURICIO
C.C. 70.143.086					C.C. 8.032.743
Representante Legal					Representante Legal
SEMANTICA DIGITAL S.A.S.		LOGIMAG S.A.S
EL CONTRATISTA					EL CONTRATANTE";
        return $texto;
    }
}