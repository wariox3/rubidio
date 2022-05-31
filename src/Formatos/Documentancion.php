<?php

namespace App\Formatos;

use App\Entity\Cliente;
use App\Entity\Documentacion;
use App\Entity\Implementacion;
use App\Entity\ImplementacionDetalle;
use Symfony\Component\HttpFoundation\Response;


class Documentancion extends \FPDF
{

    public static $em;
    public static $codigoImplementacion;
    public static $temas;
    public static $imagen;
    protected $HREF;

    public function Generar($em)
    {
        ob_clean();
        self::$em = $em;
        $pdf = new Documentancion();
        $pdf->AddPage();
        $pdf->AliasNbPages();
        $pdf->SetFont('Times', '', 12);
        $this->Body($pdf);
        $pdf->Output("Documentacion.pdf", 'D');
    }

    public function Header()
    {
        $this->SetFont('Arial', '', 5);
        $date = new \DateTime('now');
        $this->Text(168, 8, $date->format('Y-m-d H:i:s') . ' [Cromo | ERP]');
        $this->SetFillColor(200, 200, 200);
        $this->SetFont('Arial', 'B', 10);
        $this->SetXY(53, 10);

        try {
            $imagen = self::getLogo();
            $this->Image($imagen['imagen'], 12, 10, 40, 25,$imagen['extension']);
        } catch (\Exception $exception) {
        }
        $this->Cell(147, 7, utf8_decode("DOCUMENTACIÓN SEMANTICA ERP"), 0, 0, 'C', 1);
        $this->Ln(4);
    }

    public function Body($pdf)
    {
        $pdf->SetX(10);
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(200, 200, 200);
        $arDocumentaciones = self::$em->getRepository(Documentacion::class)->findAll();
        $contador = 1;
        foreach ($arDocumentaciones as $arDocumentacion) {
            //FILA 1
            $intY = 25;
            $pdf->SetXY(80, $intY);
            $pdf->SetFont('Arial', 'B', 15);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->Cell(50, 4, utf8_decode($arDocumentacion->getTitulo() . " ".  $arDocumentacion->getCodigoModuloFk()), 0, 0, 'C', 1);
            $pdf->SetXY(10, $intY+ 10);
            $pdf->SetFont('Arial', '', 9);
            $pdf->SetFillColor(272, 272, 272);
            $contenido = nl2br(html_entity_decode($arDocumentacion->getContenido()));
            $pdf->WriteHTML(utf8_decode($contenido));
            if ($contador < $arDocumentaciones) {
                $pdf->AddPage();
            }
            $contador++;
        }


        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 7);
    }

    function WriteHTML($html)
    {
        //HTML parser
        $this->B=0;
        $this->I=0;
        $this->U=0;
        $this->HREF='';
        $this->fontlist=array('arial', 'times', 'courier', 'helvetica', 'symbol');
        $this->issetfont=false;
        $this->issetcolor=false;
        $html=strip_tags($html,"<b><u><i><a><img><p><br><strong><em><font><tr><blockquote><div>");
        $html=str_replace("\n",' ',$html);
        $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
        foreach($a as $i=>$e)
        {
            if($i%2==0)
            {
                //Text
                if($this->HREF)
                    $this->PutLink($this->HREF,$e);
                else
                    $this->Write(5,stripslashes($this->txtentities($e)));
            }
            else
            {
                //Tag
                if($e[0]=='/')
                    $this->CloseTag(strtoupper(substr($e,1)));
                else
                {
                    //Extract attributes
                    $a2=explode(' ',$e);
                    $tag=strtoupper(array_shift($a2));
                    $attr=array();
                    foreach($a2 as $v)
                    {
                        if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                            $attr[strtoupper($a3[1])]=$a3[2];
                    }
                    $this->OpenTag($tag,$attr);
                }
            }
        }
    }

    function OpenTag($tag, $attr)
    {
        //Opening tag
        switch($tag){
            case 'STRONG':
                $this->SetStyle('B',true);
                break;
            case 'EM':
                $this->SetStyle('I',true);
                break;
            case 'B':
            case 'I':
            case 'U':
                $this->SetStyle($tag,true);
                break;
            case 'A':
                $this->HREF=$attr['HREF'];
                break;
            case 'IMG':
                if(isset($attr['SRC']) && (isset($attr['WIDTH']) || isset($attr['HEIGHT']))) {
                    if(!isset($attr['WIDTH']))
                        $attr['WIDTH'] = 0;
                    if(!isset($attr['HEIGHT']))
                        $attr['HEIGHT'] = 0;
                    $this->Image($attr['SRC'], $this->GetX(), $this->GetY(), px2mm($attr['WIDTH']), px2mm($attr['HEIGHT']));
                }
                break;
            case 'TR':
            case 'BLOCKQUOTE':
            case 'BR':
                $this->Ln(5);
                break;
            case 'P':
                $this->Ln(10);
                break;
            case 'FONT':
                if (isset($attr['COLOR']) && $attr['COLOR']!='') {
                    $coul= $this->hex2dec($attr['COLOR']);
                    $this->SetTextColor($coul['R'],$coul['V'],$coul['B']);
                    $this->issetcolor=true;
                }
                if (isset($attr['FACE']) && in_array(strtolower($attr['FACE']), $this->fontlist)) {
                    $this->SetFont(strtolower($attr['FACE']));
                    $this->issetfont=true;
                }
                break;
        }
    }

    function CloseTag($tag)
    {
        //Closing tag
        if($tag=='STRONG')
            $tag='B';
        if($tag=='EM')
            $tag='I';
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,false);
        if($tag=='A')
            $this->HREF='';
        if($tag=='FONT'){
            if ($this->issetcolor==true) {
                $this->SetTextColor(0);
            }
            if ($this->issetfont) {
                $this->SetFont('arial');
                $this->issetfont=false;
            }
        }
    }

    function SetStyle($tag, $enable)
    {
        //Modify style and select corresponding font
        $this->$tag+=($enable ? 1 : -1);
        $style='';
        foreach(array('B','I','U') as $s)
        {
            if($this->$s>0)
                $style.=$s;
        }
        $this->SetFont('',$style);
    }

    function PutLink($URL, $txt)
    {
        //Put a hyperlink
        $this->SetTextColor(0,0,255);
        $this->SetStyle('U',true);
        $this->Write(5,$txt,$URL);
        $this->SetStyle('U',false);
        $this->SetTextColor(0);
    }

    function hex2dec($couleur = "#000000"){
        $R = substr($couleur, 1, 2);
        $rouge = hexdec($R);
        $V = substr($couleur, 3, 2);
        $vert = hexdec($V);
        $B = substr($couleur, 5, 2);
        $bleu = hexdec($B);
        $tbl_couleur = array();
        $tbl_couleur['R']=$rouge;
        $tbl_couleur['V']=$vert;
        $tbl_couleur['B']=$bleu;
        return $tbl_couleur;
    }

    //conversion pixel -> millimeter at 72 dpi
    function px2mm($px){
        return $px*25.4/72;
    }

    function txtentities($html){
        $trans = get_html_translation_table(HTML_ENTITIES);
        $trans = array_flip($trans);
        return strtr($html, $trans);
    }

    public function getLogo(){
        $arCliente = self::$em->getRepository(Cliente::class)->find(5);
        try {
            if(!self::$imagen){
                $imagenBase64 = base64_encode(stream_get_contents($arCliente->getLogo()));
                $imagen = "data:image/png';base64," . $imagenBase64;
                self::$imagen = $imagen;
            }else{
                $imagen=self::$imagen;
            }

            return [
                'imagen' => $imagen,
                'extension' => $arCliente->getExtension(),
            ];
        } catch (\Exception $exception) {
        }
    }
}
