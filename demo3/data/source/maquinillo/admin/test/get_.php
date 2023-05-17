<?php
require($_SERVER['DOCUMENT_ROOT'].'/comun/conf.php');
	/*$sql = 'SELECT date, entryID ';
	$sql .= 'FROM cms_news ';
	$result = $siteDB->query($sql);

	while ($row = $siteDB->fetch_array($result, 1)){
		$memo[$row['entryID']] = $row['date'];
		$sql2[$row['entryID']] = "UPDATE cms_news SET date_mod=$row[date] WHERE entryID=$row[entryID]";
	}

	$siteDB->free_result();

	foreach($sql2 as $sql1){
		$result = $siteDB->query($sql1);
		$siteDB->free_result();
		if($result)
			echo $sql1;
		}
*/

$myCats = array(
	1 => array(
		'name' => 'General',
		'cat_parent' => 0
	),
	2 => array(
		'name' => 'Cat1',
		'cat_parent' => 0
	),
	3 => array(
		'name' => 'Subcat1',
		'cat_parent' => 2
	),
	4 => array(
		'name' => 'Subcat2',
		'cat_parent' => 2
	),
	5 => array(
		'name' => 'Subsubcat1',
		'cat_parent' => 3
	),
	6 => array(
		'name' => 'Cat2',
		'cat_parent' => 0
	)
);

$catTree=array(
	0 => array(
		0 => 1,
		1 => 2,
		2 => 6
	),
	2 => array(
		0 => 3,
		1 => 4
	),
	
	3 => array(
		0 => 5
	)
);
$archiveName = 'cat1';

echo printCatTree($myCats, 0, 1, 'list', '/historial/?c_%s');
$arr = printCatTree($myCats, 0, 1, 'array');
foreach ($arr as $k => $v)
	echo $k.'-- '.$v.'<br>';
	
echo printJump($arr, $archiveName, '/historial/?c_%s', '', 'categories');	

// Muestra arbol de categorias
// $myCats: array con las categorias
// $myID: ID de la categoría de $catTree por la que comenzamos a trabajar
// $myLevel: nivel de profundidad en las llamadas recursivas
// $myType: 'list' -> lista  'array' -> array para utilizar en otra función 
// $myParam: url a la que se añadirán los parametros de categoría
function printCatTree($myCats, $myID = 0, $myLevel = 1, $myType = 'list', $myParam = ''){

	global $catTree, $myData, $archiveName;
	// Si no tiene categorias hijas
	if(!$catTree[$myID]){
		return '';
	}
	// Con categorias hijas
	// Modo listado
	if($myType == 'list'){
		$html .= '<ul>'."\n";
		foreach ($catTree[$myID] as $key => $catID){
			
			// Elemento lista
			$html .= '<li>'.printLink(sprintf($myParam, setSimpleText($myCats[$catID]['name'])), $myCats[$catID]['name']).'</li>'."\n";
			
			// Llamada recursiva para mostrar categorías hijas
			$html .= printCatTree($myCats, $catID, $myLevel +1, $myType, $myParam);
		}		
		
		$html .= '</ul>'."\n";
		return $html;
	}
	// Modo menu desplegable -array para utilizar en printJump() o printFormJump()
	if($myType == 'array'){
		foreach ($catTree[$myID] as $key => $catID){
			if($myParam != '')
				$myCase = setSimpleText($myCats[$catID]['name']);
			else
				$myCase = $catID;
			$myText = $myCats[$catID]['name'];
			if($myLevel > 1)
				$myText = str_repeat('&nbsp;&nbsp;',$myLevel).$myText;	
			$myData[$myCase] = $myText;
			
			printCatTree($myCats, $catID, $myLevel +1, 'array', $myParam);
			
			/*
			// Directamente saca las opciones
			$html .= '<option value="'.$myParam.setSimpleText($myCats[$catID]['name']).'" ';
			// Si esta seleccionada
			if($archiveName == setSimpleText($myCats[$catID]['name']))
				$html .= 'selected="selected" ';
			$html .= '>';
			// Categorias hijas
			if($myLevel > 1)
				$html .= str_repeat('&nbsp;&nbsp;',$myLevel);
			$html .= $myCats[$catID]['name'].'</option>'."\n";
			//echo $html;
			$html .= printCatTree($myCats, $catID, $myLevel +1, 'select', $myParam);
			*/
		}
		return $myData;
	}
	
}

// Codifica el texto para mostrarlo en Url
function setSimpleText($texto){
	
	//$texto=str_replace("_","++",$texto);
	$texto=str_replace(" ","+",$texto);
	$texto=str_replace("/", "|", $texto);
	$texto=strtolower($texto);
	$caracteres=array('á'=>'a', 'é'=>'e', 'í'=>'i', 'ó'=>'o', 'ú'=>'u', '¡'=>'', '¿'=>'', 'ñ'=>'n');
	foreach ($caracteres as $car => $ncar)
		$texto=str_replace($car, $ncar, $texto);
	return $texto;
}

// Muestra un enlace
function printLink($myLink, $myText='', $myTarget=''){

	if($myText=='')
		$myText=$myLink;

	$html='<a href="'.$myLink.'"';
	if ($myTarget!='')
		$html.=' target="'.$myTarget.'"';
	$html.='>'.$myText.'</a>';
	
	return $html;

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


/*
echo gettype($_GET['var']);

if(is_int($_GET['var']))
	echo 'Numerico';
elseif(is_string($_GET['var']))
	echo 'Texto';

function setArchiveDates($myDate, $myKey){
	
	global $archiveDates;
	
	
	if(!$archiveDates){
		$equal = 0;
	}
	else{
		foreach($archiveDates as $date){
			if ($date == $myDate){
				$equal = 1;
				break;
				}
			else
				$equal = 0;
		}
	}
	
	if($equal == 0)
		$archiveDates[$myKey] = $myDate;

}

function convertDateU2LFormat($myDate = "", $myFormat = "%d/%m/%Y"){
	setlocale(LC_ALL, "es_ES");
	$myDate = strftime($myFormat, $myDate);
	return $myDate;
}

$aux=array('03/2003', '04/2004', '05/2004', '03/2004', '08/2002', '04/2004');
//sort($aux);

$archiveDates = array();
@array_walk($aux, setArchiveDates);
//sort($archiveDates);
for($i=0; $i<count($archiveDates); $i++){
	$archiveDates[$i] = convertDateU2LFormat(mktime(0, 0, 0, substr($archiveDates[$i],0,2), 0, substr($archiveDates[$i],3,4)), "%B de %Y");
}

	print_r($archiveDates);
*/
?>