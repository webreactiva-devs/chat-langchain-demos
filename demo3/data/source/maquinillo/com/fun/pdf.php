<?php
// Clase extendida para generar PDF a traves de FPDF www.fpdf.org

define('ROOT_FPDF', $_SERVER['DOCUMENT_ROOT'].'/com/scripts/fpdf');
define('FPDF_FONTPATH', ROOT_FPDF.'/font/');
require(ROOT_FPDF.'/fpdf.php');

class PDF extends FPDF {

var $B;
var $I;
var $U;
var $HREF;
var $IMG;
var $P;
var $list;
var $intag;
var $inattr;

function PDF($orientation='P',$unit='mm',$format='A4')
{
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    //Iniciación de variables
    $this->B=0;
    $this->I=0;
    $this->U=0;
    $this->HREF='';
	$this->IMG=0;
	$this->P=0;
	$this->H3=0;
	$this->list=0;
	$this->intag=0;
	$this->inattr=0;
}

//Cabecera de página
function Header() {
	global $title, $refPrintURL;
	
	//Logo
    $this->Image($_SERVER['DOCUMENT_ROOT'].'/media/boulesis_top_imprimir.png',10,8,50,'','','http://www.boulesis.com');
	
	//Movernos a la derecha
    $this->Cell(80);
    //$this->SetX((210-($w-60))/2);
	
	//Cuadro de cabecera
	$this->SetFont('Arial','',11);
	$this->Cell(0,8,'Boulesis.com :: Versión imprimible',0,'','R');
	$this->Ln(5);
	$this->SetFont('Arial','I',10);
	$this->SetTextColor(0,0,255);
    $this->SetFont('','IU');
	$this->Cell(0,8,$refPrintURL,0,'','R',0,$refPrintURL);
	$this->Ln(10);
    //Colores de los bordes, fondo y texto
    $this->SetTextColor(0);
	//Título
	$this->SetFont('Arial','B',15);
	//Calculamos ancho y posición del título.
    $w=$this->GetStringWidth($title)+6;
    $this->SetX((210-$w)/2);
	
    $this->MultiCell($w,9,$title,0,'C',0);
    //Salto de línea
    $this->Ln(2);

}

//Pie de página
function Footer() {
    //Posición: a 1,5 cm del final
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
	//Borde
	$this->SetDrawColor(0);
	$this->SetLineWidth(.2);
    //Número de página
    $this->Cell(0,10,'Página '.$this->PageNo().' de {nb}','T',0,'C');
}

function ChapterTitle($num,$label)
{
    //Arial 12
    $this->SetFont('Arial','B',13);
    //Color de fondo
	$this->SetTextColor(0,51,204);
	//Borde
	$this->SetDrawColor(51,154,255);
	$this->SetLineWidth(.7);
    //Título
    $this->MultiCell(0,6,"$num . $label",'B','L',0);
	$this->SetTextColor(0);
    //Salto de línea
    $this->Ln(5);
}

function ChapterBody($text)
{
    //Times 12
    $this->SetFont('Times','',12);
    //Imprimimos el texto
	$this->WriteHTML($text);
    //Salto de línea
    $this->Ln();
}

function PrintChapter($num,$title,$text)
{
    $this->AddPage();
    $this->ChapterTitle($num,$title);
    $this->ChapterBody($text);
}

function WriteHTML($html)
{
    //Intérprete de HTML
    $html=str_replace("\n",' ',$html);
    $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
            //Text
			if($this->inattr){
            	if($this->HREF)
              	  $this->PutLink($this->HREF,$e);
			}
			elseif($this->list && !$this->intag)
				$this->MultiCellBlt(100,5,chr(149),$e);
            else
                $this->Write(5,$e);
        }
        else
        {
            //Etiqueta
            if($e{0}=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else
            {
                //Extraer atributos
                $a2=explode(' ',$e);
				//$a2=preg_split('/"(.*)"/U',$e,-1,PREG_SPLIT_DELIM_CAPTURE);
                $tag=strtoupper(array_shift($a2));
                $attr=array();
                foreach($a2 as $v)
                    if(ereg('^([^=]*)=["\']?([^"\']*)["\']?$',$v,$a3)){
                        $attr[strtoupper($a3[1])]=$a3[2];
						$this->inattr=1;
						}
                $this->OpenTag($tag,$attr);
            }
        }
    }
}

function OpenTag($tag,$attr)
{
    //Etiqueta de apertura
    if($tag=='B' or $tag=='STRONG' or $tag=='H3' or $tag=='H4')
        $this->SetStyle('B',true);
    if($tag=='I' or $tag=='EM')
        $this->SetStyle('I',true);
    if($tag=='U')
        $this->SetStyle('U',true);
    if($tag=='A')
        $this->HREF=$attr['HREF'];
	$this->intag = 1;
    if($tag=='BR'){
        $this->Ln(5);
		$this->intag = 0;
	}
	if($tag=='IMG'){
		$this->IMG = 1;
		$this->putImage($attr);
		$this->intag = 0;		
	}
	if($tag=='LI'){
		$this->SetList(true);
		$this->intag = 0;
		}
}

function CloseTag($tag)
{
    //Etiqueta de cierre
    if($tag=='B' or $tag=='STRONG' or $tag=='H3' or $tag=='H4')
        $this->SetStyle('B',false);
    if($tag=='I' or $tag=='EM'){
        $this->SetStyle('I',false);
		}
    if($tag=='U'){
        $this->SetStyle('U',false);
		}
    if($tag=='A'){
        $this->HREF='';	
		}
	if($tag=='P' || $tag{0}=='H')
		$this->Ln(10);
	if($tag=='LI'){
		$this->Ln(5);
		$this->SetList(false);
		$this->intag = 0;
		}
	
}

function SetStyle($tag,$enable)
{
    //Modificar estilo y escoger la fuente correspondiente
    $this->$tag+=($enable ? 1 : -1);
    $style='';
    foreach(array('B','I','U') as $s)
        if($this->$s>0)
            $style.=$s;
    $this->SetFont('',$style);
}

function SetList($enable)
{
	$this->list+=($enable ? 1 : -1);
}

//MultiCell with bullet
function MultiCellBlt($w,$h,$blt,$text,$border=0,$align='L',$fill=0)
{
	//Get bullet width including margins
    $blt_width = $this->GetStringWidth($blt)+$this->cMargin*2;

    //Save x
    //$bak_x = $this->x;

    //Output bullet
    $this->Cell($blt_width,$h,$blt,0,'',$fill);
    //Output text
    //$this->MultiCell($w-$blt_width,$h,$text,$border,$align,$fill);
	$this->Write($h,$text);
	
    //Restore x
   // $this->x = $bak_x;
    }

function PutLink($URL,$txt)
{
    //Escribir un hiper-enlace
    $this->SetTextColor(0,0,255);
    $this->SetStyle('U',true);
    $this->Write(5,$txt,$URL);
    $this->SetStyle('U',false);
    $this->SetTextColor(0);
	$this->inattr=0;
}
function putImage($attr)
{
    //Ruta total de la imagen
	$imgsrc = $_SERVER['DOCUMENT_ROOT'].$attr['SRC'];
	//Calcular el tamño de la imagen
	$size = GetImageSize($imgsrc);
	$sizemm = px2mm($size[0], $size[1]);
	//Posicion
	$y = $this->GetY();
	$x = (210-$sizemm[0])/2;
	
	$this->MultiCell($sizemm[0]+5, $sizemm[1]+5, $this->Image($imgsrc, $x, $y+2, $sizemm[0], $sizemm[1]), 0, 'C');
	//$this->Image($imgsrc, 10, $y, $sizemm[0], $sizemm[1]);
	// Pie de foto
	/*if($attr['ALT'])
		$this->MultiCell($sizemm[0],6,$attr['ALT'], 0, 'C');*/
	$this->Ln(5);
	$this->inattr=0;
}
} // END class


// Funcion que convierte el tamño de pixels a milimetros
function px2mm($width, $height, $dpi = '96') {

   // Convierte a centimetros
   $w = $width * 2.54 / $dpi;
   $h = $height * 2.54 / $dpi;
   
   // Convierte a milimetros  y crea la variable de salida
   $px2mm[0] = $w*10;
   $px2mm[0] = sprintf("%.2f", $px2mm[0]);
   $px2mm[1] = $h*10;
   $px2mm[1] = sprintf("%.2f", $px2mm[1]);
      
   return $px2mm;
}




?>