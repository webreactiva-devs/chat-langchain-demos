<?php
// Funciones generales

function getDateNow(){
	global $day, $month, $year, $hour, $min, $sec, $timeNow;
	$currentTime=time();
	//Comprobamos si existen las variables de tiempo y asignamos valores
	// $d $m $y pasan a través de URL
	if(!$_REQUEST['H'])
	    $hour=date("H",$currentTime);
	else
	    $hour=$_REQUEST['H'];
	if(!$_REQUEST['X'])
	    $min=date("M",$currentTime);
	else
	    $min=$_REQUEST['X'];
	if(!$_REQUEST['S'])
	    $sec=date("S",$currentTime);
	else
	    $sec=$_REQUEST['S'];
	if(!$_REQUEST['d'])
	    $day=date("j",$currentTime);
	else
	    $day=$_REQUEST['d'];
	if(!$_REQUEST['m'])
	    $month=date("n",$currentTime);
	else
	    $month=$_REQUEST['m'];
	if(!$_REQUEST['y'])
	    $year=date("Y",$currentTime);
	else
 	   $year=$_REQUEST['y'];
	  
	$timeNow = array(
		'day' => $day,
		'month' => $month,
		'year' => $year,
		'hour' => $hour,
		'min' => $min,
		'sec' => $sec
		);  
	return $timeNow;
}

// Muestra el BreadCrumb (migas de pan)
function setSitePosition($myPages, $level = 0) {
  global $pathParts, $path_Parts, $handler;
  
  //$pathParts[$level] = str_replace('.'.$path_Parts["extension"], "", $pathParts[$level]);

  if (!$level){
		$bread.='<a href="/index.php">Boulesis</a>';
  }
  foreach ( $myPages as $dir => $label ) { // $label => $path
    
	if ( ! is_array($label) ) {
	  if ( $dir && strpos($dir, $pathParts[$level])!==false){
	  	for($i=0;$i<=$level;$i++)
			$myPath .= $pathParts[$i] . '/';
		$bread .= ' &gt; <a href="/'.$myPath.'">'.$label.'</a>';
		}
    } 
	else {

	  if ( $level!=0 ){
	  	$myPath = '';
	  	for($i=0;$i<=$level;$i++){
			$myPath .= $pathParts[$i] . '/';
			
		}
	  }
	  
	  else
	  	$myPath = $pathParts[$level] . '/';

      if ( $pathParts[$level] == $dir ) { 
	  	
	  	if ($label&&$dir!='inicio'){
		  $bread .= ' &gt; <a href="/'.$myPath.'">'.$label[0].'</a>';
		}  
        $bread .= setSitePosition($label, $level +1);
      } 
	  else {
	  	if ( $label && strpos($dir, $myPath)!==false )
			$bread .= ' &gt; <a href="/'.$myPath.'">'.$label.'</a>';
      }
    }
  }
	
  return ( $bread . "\n");
}

// Comprobamos que venimos de una página de nuestro dominio
function checkReferer($myHost='', $myRefUrl=''){
	$myHost = str_replace('http://','',$myHost);
	$mySimpleHost = str_replace('www','',$myHost);
	if(ereg('(http://)(w{0,3})(\.{0,1})('.$mySimpleHost.')([^/]*)',$myRefUrl, $myAux)==true){
		return;
	}
	else{
		showError('No se puede acceder a la pagina desde ahí');
		exit();
	}
		
}

// Mostramos un error
function showError($myText = ''){

	echo '<p style="color:red;">'.$myText.'</p>'."\n";
	return; 

}

// Mostramos un error
function printError($myText = ''){

	echo '<p style="color:red;">'.$myText.'</p>'."\n";
	return; 

}

function printMenu(){
	
	global $menuFile, $selectSection;
	
	if( file_exists($menuFile) )
		include($menuFile);
	
	//if($selectSection == 'ayuda' OR $selectSection == 'filosofica' )
		//echo '<div style="height: 300px">&nbsp;</div>'; 
	
	return;	

}

function printSubmenu($mySubSection){

	global $submenuFile, $selectSubSection;

	if ($selectSubSection == $mySubSection){
		if( file_exists($submenuFile) )
			include($submenuFile);
	}
	
	return;	

}

function printPromo($mySection){
	
	include(ROOT_INC.'/promotable.inc');
	return;
	
}

function printBoulesisName($myCSS = 'blue'){
	include (ROOT_INC.'/boulesis_name_'.$myCSS.'.inc');
	return;
}


// Muestra un select con posibilidad de ser combo
// $myData: los datos del select
//	$key -> parametro para el value del option
//	$value 	-> texto de la etiqueta option
// $mySelect: opción que debe aparecer seleccionada
// $myParam: url a la que se añaden los parametros contenidos en $myData
// $myType: 'auto' -> select como combo '' -> select simple
// $myName: nombre e id del select
function printJump($myData = '', $mySelect = '', $myParam = '', $myType = 'auto', $myName = 'numchapters'){
	
	// Generamos la lista de números
	if($myData == ''){
		for($i=1;$i<=15;$i++){
			$options .= '<option value="'.$i.'" ';
			if ($mySelect == $i){
				$options .= ' selected="selected" ';
			}
			$options .= '>'.$i.'</option>'."\n";
		}
	}
	
	else{
		
		foreach ($myData as $id => $text){
			$options .= '<option value="'.sprintf($myParam, $id).'" ';
			if ($mySelect == $id){
				$options .= ' selected="selected" ';
			}
			$options .= '>'.$text.'</option>'."\n";
		}
	
	}
	if($myType == 'auto'){
		$selectjs = 'onchange="if (this.options[this.selectedIndex].value != 0){ forms[\''.$myForm.'\'].submit() }"'; 		
	}
	$html .= '<select id="'.$myName.'" name="'.$myName.'" class="formfield" '.$selectjs.'>'."\n";
	$html .= $options;
	$html .= '</select>'."\n";
	
	return $html;
	
}

function printFormJump($myData = '', $mySelect = '', $myForm = 'jump', $myParam = '', $myType = 'auto', $myName = ''){
	
	$html .= '<form id="jump" name="jump" action='.$_SERVER['REQUEST_URI'].' method="post">'."\n";
	$html .= printJump($myData, $mySelect, $myParam, $myType, $myName);
	$html .= '</form>'."\n";
	return $html;
}



function printSelectJump2($myData, $myParam = ''){
	$html = '<form name="pages" method="post" action="" id="pagesnav">'."\n";
	$html .= '	<select name="pages_nav" class="formfield2" >'."\n"; 
	// Valores del select
	foreach($myData as $id => $value){
		$id += 1;
		$html .= '	<option value="'.$myUrl.'?a='.$_GET['a'].'&p='.$id.'" ';
		if ($_GET['p']==$id){
			$html .= ' selected="selected" ';
		}
		$html .= ' >'.$value.'</option>'."\n";
	}
	$html .= '	</select>'."\n";
	$html .= '	<input type="button" name="pagesbutton" value="  Ir  " class="formbutton2" onClick="MM_jumpMenuGo(\'pages_nav\',\'parent\',0)">';
	$html .= '</form>'."\n";
	
	return $html;
}

function convertDateU2LFormat($myDate = "", $myFormat = "%d/%m/%Y"){
	setlocale(LC_ALL, "es_ES");
	$myDate = strftime($myFormat, $myDate);
	return $myDate;
}

// Reescribe las URLs tanto si funciona algun rewrite como sino
// 
// $myMode : simple ->	?var1=valor1&var2=valor2
//			 rw		->	/valor1/valor2/
function printGetUrl($myVars, $myValues, $myMode = "simple"){

	if($myMode == 'simple'){
		$delim = '?';
		$getUrl = $delim; 
		$sep = '&';
		if(is_array($myVars)){
			for($i=0;$i<count($myVars);$i++)
				$getUrl .= $myVars[$i].'='.$myValues[$i].$sep;
			$getUrl = substr($getUrl, 0, strlen($getUrl)-1);
		}
		else{
			$getUrl .= $myVars.'='.$myValues;
		}
	}
	
	elseif($myMode == 'rw'){
		$delim = '/';
		
		if(is_array($myVars)){
			for($i=0;$i<count($myValues);$i++)
				$getUrl .= $myValues[$i].$delim;
		}
		else{
			$getUrl .= $myValues.$delim;
		}		
	}
	
	return $getUrl;

}



function printLink($myLink, $myText='', $myTarget=''){

	if($myText=='')
		$myText=$myLink;

	$html='<a href="'.$myLink.'"';	if ($myTarget!='') $html.=' target="'.$myTarget.'"'; $html.='>'.$myText.'</a>';
	
	return $html;

}

function printEncEmail($email) {
	$encoded = bin2hex($email);
	$encoded = chunk_split($encoded, 2, '%');
	$encoded = '%' . substr($encoded, 0, strlen($encoded) - 1);
	return $encoded;
}


function printOptionsBox($myTitle = '', $setPrint =1, $setPdf = 1, $myUser = ''){

	global $txt;

	$options_box = & new Template(ROOT_TMPL.'/');
	if($setPrint == 1)
		$options_box->set('optionPrint', printLink('/imprimir/?url='.setSimpText2($_SERVER[REQUEST_URI],0), $txt['artimprimir']));
	$options_box->set('optionRecommend', printLink('/ayuda/recomendar/?url='.setSimpText($_SERVER[REQUEST_URI],0), $txt['artrecomendar'])); 
	if($setPdf == 1)
		$options_box->set('optionPdf', printLink('/pdf/?url='.setSimpText($_SERVER[REQUEST_URI],0), $txt['artimprimirpdf'])); 
	if($myTitle != '')
		$options_box->set('optionSearch', printLink('/buscar/?q='.setSimpText($myTitle), $txt['artbuscar'])); 
	if($myUser != '' && $myUser[1])
		$options_box->set('optionUser', $txt['artenviado'].printLink('/didactica/usuarios/?u='.$myUser[0], $myUser[1])); 
	$optionsBox = $options_box->fetch('options_box.tpl');
	return $optionsBox;
	
}

function setSimpText($myText, $lower = 1, $rawcode = 0){

	global $convertChars;
	
	//$texto=str_replace("/", "|", $texto);
	if($lower == 1)
		$myText = strtolower($myText);
							
	foreach ($convertChars as $char => $nchar)
		$myText = str_replace($char, $nchar, $myText);
		
	if ($rawcode == 1)
		$myText = rawurlencode($myText);
	else
		$myText = urlencode($myText);
		
	return $myText;
}

function setSimpText2($myText, $lower = 1, $rawcode = 0){

	global $convertChars;
	
	//$texto=str_replace("/", "|", $texto);
	if($lower == 1)
		$myText = strtolower($myText);
	
	if ($rawcode == 1)
		$myText = rawurlencode($myText);
	else
		$myText = urlencode($myText);	
		
	return $myText;
}

function setCompText($myText, $rawcode = 0){

	if ($rawcode == 1)
		$myText = rawurldecode($myText);
	else
		$myText = urldecode($myText);
		
	return $myText;

}

function convertSpChars($myText, $rev = 0){
		
	$specialChars1=array('á'=>'&aacute;', 'é'=>'&eacute;', 'í'=>'&iacute;', 'ó'=>'&oacute;', 'ú'=>'&uacute;', 
						'Á'=>'&Aacute;', 'É'=>'&Eacute;', 'Í'=>'&Iacute;', 'Ó'=>'&Oacute;', 'Ú'=>'&Uacute;',
						' '=>'&nbsp;', 'º'=>'&ordm;', '¡'=>'&iexcl;', '¿'=>'&iquest;', '·'=>'&middot;', '"'=>'&quot;',
						'ñ'=>'&ntilde;', 'Ñ'=>'&Ntilde;', '>'=>'&gt;', '<'=>'&lt;', '›'=>'&rsaquo;', '‹'=>'&lsaquo;', 
						'—'=>'&mdash;', '¬'=>'&not;', '“'=>'&ldquo;', '”'=>'&rdquo;');
	// Convierte algunos caracteres especiales (no las etiquetas html)
		foreach ($specialChars1 as $char => $replace){
			if($rev == 0)
				$myText=str_replace($char, $replace, $myText);
			else
				$myText=str_replace($replace, $char, $myText);
			}
	return $myText;
}

// Muestra texto sacado de una BD y lo formatea
function printText($myText, $nl2br=1, $conv=1){
	
	if($nl2br == 1 || $nl2br == 'on'){
		$myText = nl2br($myText);
		$myText = '<p>'.$myText.'</p>';
	}
	
	// Modifica los caracteres á é y etc
	if($conv == 1){
		$specialChars=array('á'=>'&aacute;', 'é'=>'&eacute;', 'í'=>'&iacute;', 'ó'=>'&oacute;', 'ú'=>'&uacute;', '¡'=>'&iexcl;', '¿'=>'&iquest;', '·'=>'&middot;', 'ñ'=>'&ntilde;');
		foreach ($specialChars as $char => $replace)
			$myText=str_replace($char, $replace, $myText);
	}
	$myText=stripslashes($myText);
	
	return $myText;
}

// Imprime título (desde el breadcrumb)
function printTitle($text){
	$title = strip_tags($text);
	$title = str_replace ("&gt;", "&middot;", $title);
	$title = str_replace("Estás en Boulesis", "Boulesis.com &raquo; Filosof&iacute;a ", $title);
	return $title;
}

// Saca una lista de enlaces en base a un archivo de texto
// Formato: nombre,enlace
function printListLinks($myFile = '', $myMode = 'html'){

	if($myFile == '')
		return;
	
	$fp = fopen($myFile, "rb");
	while(!feof($fp)){
		$buffer = fgets($fp, 1024);
		ereg("(.+),(.+)",$buffer,$data);
		$list['name'][] = $data[1];
		$list['url'][] = $data[2];
	}
	fclose($fp);
	
	$html = '';
	if($myMode == 'html'){
		for($i=0;$i<count($list['name']);$i++){
			$html .= '<li>'.printLink($list['url'][$i],$list['name'][$i],'_blank').'</li>'."\n";
		}
	return $html;
	}
	
	elseif($myMode == 'array')
		return $list;
	
	
}


// Contabiliza los accesos a cada elemento
function logHits($myID, $myCase = 'articles'){

	global $siteDB;
	
	if($myCase == 'articles'){
		$table = 'cms_articles';
		$elem = 'artID';
	}
	elseif($myCase == 'news'){
		$table = 'cms_news';
		$elem = 'entryID';
	}
	elseif($myCase == 'documents'){
		$table = 'cms_documents';
		$elem = 'docID';
	}		
	
	$query = "SELECT hits 
				FROM $table 
				WHERE $elem=$myID ";
	$hitsOld = $siteDB->query_firstrow($query);
	$siteDB->free_result();
	
	$hitsNew = $hitsOld[0] + 1;
	
	$query="UPDATE $table  
				SET hits=$hitsNew    
				WHERE $elem=$myID";
	$result = $siteDB->query($query);
	$siteDB->free_result();

}

// Muestra estadísticas
function viewStats ($myCase = "articles", $limit='', $ini=0){

	global $siteDB;
	
	if($myCase == 'articles'){
		$table = 'cms_articles';
		$elem = 'artID';
		$letter = 'a';
	}
	elseif($myCase == 'news'){
		$table = 'cms_news';
		$elem = 'entryID';
		$letter = 'n';
	}
	elseif($myCase == 'documents'){
		$table = 'cms_documents';
		$elem = 'docID';
		$letter = 'd';
	}	
	
	// Llamada a la base de datos
	$sql = "SELECT * FROM $table WHERE ";
	
	$sql .= " status = 0 ORDER BY ";
	
	// Orden de los datos
	if(!$_GET['o'] || $_GET['o'] == 'hit')
		$sql .= " hits DESC ";
	elseif($_GET['o'] == 'tit')
		$sql .= " title ASC ";
	elseif($_GET['o'] == 'tim')
		$sql .= " date DESC ";
	elseif($_GET['o'] == 'cat')
		$sql .= " catID ASC ";
	elseif($_GET['o'] == 'mag')
		$sql .= " jourID ASC ";		


	// Sin límite
	if ($limit != '')
		$sql .= " LIMIT $ini, $limit ";

	$result = $siteDB->query($sql);		

	$html = '';
	$i=1;
	
	// Extraemos los datos para presentarlos en pantalla
	while ($row = $siteDB->fetch_array($result, 1)) {

		// Extraemos los datos que nos interesan	
		$elemID = $row[$elem];
		//$chits = $row['c_hits'];
		//$mhits = $row['m_hits'];
		$hits = $row['hits'];
		$title = stripslashes($row['title']);
		$timestamp = $row['date_mod'];
		$catID = $row['catID'];
		$authorID = $row['authorID'];
		$jourID = $row['jourID'];
		
		// Modificaciones de fecha y hora
		$month_name = ucfirst(strftime("%B", $timestamp));
		$time = strftime("%H:%M:%S", $timestamp);
		$date = strftime("%d/%m/%Y", $timestamp);
		
		// Nombre de la categoria
		$cat = getCat($catID);
		
		// Magazine
		if($myCase == 'articles' || $myCase == 'news')
			$mag = getJournal($jourID);
		else
			$mag['path'] = '/didactica/documentos';
		
		// URL de la anotacion
		$link = $mag['path'].'/?'.$letter.'='.$elemID;
		
		// Formateamos la salida
		$html .= '<tr';
		if (ceil($i/5)%2 != 0)
			$html .= ' bgcolor="#E9E9E9"';
		$html .= '>'."\n";
		$html .= '<td>'.$i.'</td> <td>'.$title.' <a href="'.$link.'" title="Publicada el '.$month_name.'">&raquo;</a></td> ';
		$html .= '<td>'.$hits.'</td> <td>'.$mag['title'].'</td> <td>'.$cat['name'].'</td> <td>'.$time.'</td> <td>'.$date.'</td>'."\n";
		$html .= '</tr>'."\n";

		$i++;
	}
	
	//$html .= '</ul>';
	echo $html;		

}

// Conexión entre artículos y cuestionarios
function callQuiz($quizID){

	include $_SERVER['DOCUMENT_ROOT'].'/com/data/quizs/'.$quizID.'.inc';
	include $_SERVER['DOCUMENT_ROOT'].'/com/din/cms_quizs.php';
	
	return;
}

// Genera el mapa del sitio
function setSiteMap($myPages, $level = 0, $pathprev = '') {
  global $pathParts, $path_Parts, $handler;
  
  // Sangría de código
  $tab = '';
  for($j=0;$j<$level;$j++)
  	$tab .= '	';	
  if (!$level)
		$bread.='<ul>'."\n";

  foreach ( $myPages as $dir => $label ) { // $label => $path
    
	if ( ! is_array($label) ) {
	  if ( $dir ){
		$myPath = $pathprev . $dir . '/';
		$bread .= $tab . '  <li><a href="/'.$myPath.'">'.$label.'</a></li>'."\n";
		}
    } 
	else {

      $myPath = $pathprev . $dir . '/';
	  	
	  if ($label&&$dir!='inicio')
		  $bread .= $tab . '  <li><a href="/'.$myPath.'">'.$label[0].'</a></li>'."\n";
 
       $bread .= $tab . '<ul>'."\n".setSiteMap($label, $level +1, $myPath). $tab . '</ul>'."\n";
    } 

    }

	if (!$level)
		$bread.=$tab . '</ul>'."\n";	
  return ( $bread );
}

/////////////////////////////////////////////////////////////
// Funciones de Publicidad
// Muestras publicidad de Google Adsense si el usuario viene de uno
// sitios predefinidos
// Basado en
// Plugin Name: MoreMoney (AKA Buhonejo)
// Plugin URI: http://www.nopuedocreer.com/quelohayaninventado/?page_id=203

function showAdsense($option = 'boule')
{

  // Sitios a incluir		
  $wpmm_sitios="Google\nYahoo\nMSN";
  // Términos de busqueda a excluir (no se mostrara el anuncio)
  $wpmm_excluir="";
		
  if( empty($_SERVER['HTTP_REFERER'])) 
  {
     return false;
  }
 
  $sourcesList = split("\n",$wpmm_sitios); 
  


  foreach ($sourcesList as $source) 
  {
	$source=trim($source);
    if (checkReferer2($source)) 
    {
  	  $swOK=true;
	  $searchKeywords = getSearchKeywords($source);
	  
	  
	  $excludeList= split("\n",$wpmm_excluir);
	  
	  foreach ($excludeList as $excludeWord) 
	  {	  
		  if ($excludeWord != "")
		  { 
			if (eregi($excludeWord,$searchKeywords))
			{
				$swOK=false;
				break;
			}
		  }	  
	  }
	  	
	  if ($swOK)
	  {
		$textoSalida= stripslashes(getTextAdsense($option));
	      
		$textoSalida=preg_replace('|#keywords#|', $searchKeywords, $textoSalida);
		$textoSalida=preg_replace('|#source#|', $source, $textoSalida);
		echo $textoSalida;
	      
		return true;
      		}
	}
  }
  return false;
}

/*
Probablemente quiera incluir aqu&iacute; codificaci&oacute;n para mostrar anuncios.<br/>
Si desea incluir las palabras que us&oacute; el usuario en el buscador, escriba #keywords# donde quiera que aparezcan.<br/>
Si desea incluir el nombre del sitio de origen, escriba #source# donde quiera que aparezca.<br/>
Puede usar CSS para modificar la apariencia del mensaje.
Variable $option: define el tipo de texto a mostrar en pantalla
*/
function getTextAdsense($option=0){
	

	switch ($option){
		case 'boule':
			$html = '<!--tipo 0-->';
			$html .= '<script type="text/javascript"><!--
google_ad_client = "pub-7110432088770954";
google_ad_width = 468;
google_ad_height = 60;
google_ad_format = "468x60_as";
google_ad_type = "text_image";
google_ad_channel ="6227860592";
google_color_border = "E5F3F8";
google_color_bg = "FFFFFF";
google_color_link = "003399";
google_color_url = "3333FF";
google_color_text = "000000";
//--></script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>';
			break;
		case 'didactica':
			$html = '<script type="text/javascript"><!--
google_ad_client = "pub-7110432088770954";
google_ad_width = 160;
google_ad_height = 600;
google_ad_format = "160x600_as";
google_ad_type = "text_image";
google_ad_channel ="6227860592";
google_color_border = "FFFFFF";
google_color_bg = "FFFFFF";
google_color_link = "0185B6";
google_color_url = "0185B6";
google_color_text = "003366";
//--></script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>';
			break;
		default:
			$html =  '<!--Sin publi-->';	
			break;
			
		}
	return $html;	
	
}

function checkReferer2($source = 'google') 
{
  $referer = urldecode($_SERVER['HTTP_REFERER']);
		 	
  if ( ! $source ) 
  {
     return false;
  }
  switch ($source) 
  {
     case 'Google':
          if (preg_match('|^http://(www)?\.?google.*|i',$referer)) 
          {
			 if (!eregi("reader",$referer) && !eregi("ig",$referer) )  //viene de Google Reader o de Google IG
			    return true;
			 else 
			    return false;
          }
          break;							 
							  
	
	 case 'Yahoo':		
          if (preg_match('|^http://[a-z]?[a-z]?(\.)?(search)?\.?yahoo.*|i',$referer)) 
          {
             return true;
          }
          break;
     						    
	/*						    
     case 'Yahoo':		
       	
          //if (preg_match('|^http://search\.yahoo.*|i',$referer)) 
          if (preg_match('|^http://(search)?\.?yahoo.*|i',$referer)) 
          {
             return true;
          }
          break;
      case 'Yahoo.es':
          //if (preg_match('|^http://search\.yahoo.*|i',$referer)) 
          if (preg_match('|^http://(es.search)?\.?yahoo.*|i',$referer)) 
          {
             return true;
          }
          break;
     */
          
	 case 'MSN':
          if (preg_match('|^http://search\.msn.*|i',$referer)) 
          {
             return true;
          }
          break;
          
	default:
         /*$source = strtolower (trim($source));
	     if (preg_match('|^http://(www)?\.?'.$source.'.*|i',$referer)) 
          {
			 return true;
          }*/
          return false;
          break;

  }

  return false;
}


function getSearchKeywords($source = 'google') 
{
    $referer = urldecode($_SERVER['HTTP_REFERER']);
    switch ($source) 
    {
		case 'Google':
				
				$searchKeywords = preg_replace('/^.*q=([^&]+)&?.*$/i','$1', $referer);
				$searchKeywords = preg_replace('/\'|"/', '', $searchKeywords);
				break;

		case 'Yahoo':
		case 'Yahoo.es':
				$searchKeywords = preg_replace('/^.*p=([^&]+)&?.*$/i','$1', $referer);
				$searchKeywords = preg_replace('/\'|"/', '', $searchKeywords);
				break;

		
		case 'MSN':
				$searchKeywords = preg_replace('/^.*q=([^&]+)&?.*$/i','$1', $referer);
				$searchKeywords = preg_replace('/\'|"/', '', $searchKeywords);
				break;
	            
    }
    
    return $searchKeywords;
}
?>