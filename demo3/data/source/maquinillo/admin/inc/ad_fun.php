<?php
// Funciones de administracion

// Devuelve los datos de los grupos segun criterio
function getGroups($myMode='all'){
	
	global $siteDB, $magID;

	if($myMode == 'name'){
		$keywords = setSearch($_POST['name'], 'name');
		$queryX = " AND name LIKE '%".$keywords."%' ";
	}
	
	if($myMode == 'all'){
		$queryX = "";
	}
	
	$query = "SELECT * 
				FROM groups "
				.$queryX.
				"ORDER BY name ASC";
			
	$result = $siteDB->query($query);
	
	while ($row = $siteDB->fetch_array($result, 1)){
		$data[$row['groupID']] = $row;
	}
	
	$siteDB->free_result();
	return $data;

}

// Devuelve los datos de los números segun el criterio
function getNums($myMode='all'){
	
	global $siteDB, $magID;

	if($myMode == 'title'){
		$keywords = setSearch($_POST['title'], 'title');
		$queryX = " AND title LIKE '%".$keywords."%' ";
	}
	
	if($myMode == 'all'){
		$queryX = "";
	}
	
	$query = "SELECT * 
				FROM cms_nums
				WHERE magID=$magID "
				.$queryX.
				"ORDER BY num DESC";
			
	$result = $siteDB->query($query);
	
	while ($row = $siteDB->fetch_array($result, 1)){
		$data[$row['numID']] = $row;
	}
	
	$siteDB->free_result();
	return $data;

}

function getNum($myID){
	
	global $siteDB, $magID;

	$query = "SELECT * 
				FROM cms_nums
				WHERE numID=$myID ";
			
	$result = $siteDB->query($query);
	
	while ($row = $siteDB->fetch_array($result, 1)){
		$data = $row;
	}
	
	$siteDB->free_result();
	return $data;

}



// Categorias
/*function getCats($myMode = 'news', $myGroupID = 0){

	global $siteDB, $catTree;

	$query="SELECT * 
			FROM categories 
			ORDER BY name ASC";
	$result = $siteDB->query($query);
	
	while ($row = $siteDB->fetch_array($result, 1)){
		$data[$row['catID']] = $row;
		$catTree[$row['cat_parent']][] = $row['catID'];
	}
	$siteDB->free_result();
	
	// Registros de cada categoria según el modo
	if($myMode == 'news')
		$table = 'cms_news';
	elseif($myMode == 'articles')
		$table = 'cms_articles';
	
	$query="SELECT catID, COUNT(*) as numRegs  
			FROM $table 
			GROUP BY catID";
	$result = $siteDB->query($query);
	
	while ($row = $siteDB->fetch_array($result, 1)){
		$data[$row['catID']]['numRegs'] = $row['numRegs'];
	}
	
	$siteDB->free_result();
	
	return $data;
	
}*/

function getCats($myMode = 'news', $myGroupID = 0, $myID = ''){

	global $siteDB, $catTree, $catNameTree;

	$query="SELECT * 
			FROM categories 
			WHERE groupsID = $myGroupID
			ORDER BY name ASC";
	$result = $siteDB->query($query);
	
	while ($row = $siteDB->fetch_array($result, 1)){
		$data[$row['catID']] = $row;
		$catTree[$row['cat_parent']][] = $row['catID'];
	}

	$siteDB->free_result();
	
	// Registros de cada categoria según el modo
	if($myMode == 'news'){
		$table = 'cms_news';
		if($myID != '')
			$queryX = " WHERE jourID = $myID ";
		}
	elseif($myMode == 'articles'){
		$table = 'cms_articles';
		if($myID != '')
			$queryX = " WHERE jourID = $myID ";		
		}
	elseif($myMode == 'albums'){
		$table = 'cms_albums';
		if($myID != '')
			$queryX = " WHERE albumID = $myID ";		
		}
	elseif($myMode == 'links'){
		$table = 'cms_links';
		if($myID != '')
			$queryX = " WHERE linkID = $myID ";		
		}
	elseif($myMode == 'docs'){
		$table = 'cms_documents';
		if($myID != '')
			$queryX = " WHERE docID = $myID ";		
		}		
	elseif($myMode == 'staticpages'){
		$table = 'cms_staticpages';
		if($myID != '')
			$queryX = " WHERE staticID = $myID ";		
		}				
		
	$query="SELECT catID, COUNT(*) as numRegs  
			FROM $table "
			.$queryX.
			"GROUP BY catID";
	$result = $siteDB->query($query);
	
	while ($row = $siteDB->fetch_array($result, 1)){
		$data[$row['catID']]['numRegs'] = $row['numRegs'];
	}
	
	$siteDB->free_result();
	
	return $data;
	
}

// Categoria
function getCat($myID, $myMode = 'id'){

	global $siteDB;
	
	if ($myMode == 'id')
		$queryX = "WHERE catID=$myID";
	elseif ($myMode == 'name')
		$queryX = "WHERE name LIKE '%$myID%'";
		
	$query="SELECT * 
			FROM categories "
			.$queryX. 
			" ORDER BY name DESC";
	$result = $siteDB->query($query);
	
	$data = $siteDB->query_firstrow($query);
	
	$siteDB->free_result();
	return $data;
	
}



function printContHead($myMsg){
	$html .= '<table id="body" cellpadding="0" cellspacing="0">';
	$html .= '	<tr>';
	$html .= '		<td>';
	$html .= '<h1>'.$myMsg.'</h1>'."\n";
	return $html;
}

function printContFoot(){
	$html .= '		</td>';
	$html .= '	</tr>';
	$html .= '</table>';
	return $html;
}

function printError($myMsg){
	$html .= '<p class="error">'.$myMsg.'</p>';
	return $html;
}

function printMsg($myMsg){
	$html .= '<p class="note">'.$myMsg.'</p>';
	return $html;
}

function printTextToolbar(){
	include (ROOT_AD_INC.'/text_toolbar.inc');
}

function printListHead($myCase='articles'){

	$tableHead=array('&nbsp;', '&nbsp;', '&nbsp;');
	
	if($myCase == 'nums'){
		array_push($tableHead, '&nbsp;', '&nbsp;', 'Número');
		$cols = '<colgroup span="3" width="30" />'."\n";
	}
	
	elseif($myCase == 'articles'){
		array_push($tableHead, 'Artículos');
		$cols = '<colgroup span="3" width="30" />'."\n";
	}
	elseif($myCase == 'journals'){
		array_push($tableHead, 'Diarios');
		$cols = '<colgroup span="3" width="30" />'."\n";
	}
	elseif($myCase == 'news'){
		array_push($tableHead, 'Noticias');
		$cols = '<colgroup span="3" width="30" />'."\n";
	}
	elseif($myCase == 'albums'){
		array_push($tableHead, 'Álbums');
		$cols = '<colgroup span="3" width="30" />'."\n";
	}
	elseif($myCase == 'links'){
		array_push($tableHead, 'Enlaces');
		$cols = '<colgroup span="3" width="30" />'."\n";
	}
	elseif($myCase == 'docs'){
		array_push($tableHead, 'Documentos');
		$cols = '<colgroup span="3" width="30" />'."\n";
	}	

	$html = '<table class="list" cellpadding="0" cellspacing="0" align="center">'."\n";
	$html .= $cols;
	$html .= '	<tr>'."\n";
	foreach($tableHead as $value){
		$html .= '		<th>'.$value.'</th>';
	}	
	$html .= '	</tr>'."\n";

	return $html;
}

function printList($myData = '', $myCase = 'articles'){
	
	$html = printListHead($myCase);
	
	// Listado
	foreach ($myData as $id => $data){
	
		if($myCase == 'nums'){
			$data['title'] = $data['num'].'. '.$data['title'];
			$sufaction = 'num';
			}
		elseif($myCase == 'articles'){
			//$dataaux = getNum($data['numID']);
			$data['title'] = $data['title'];//.' <em>('.$dataaux['num'].')</em>';
			$sufaction = 'art';
			}
		elseif($myCase == 'journals'){
			$data['title'] = $data['title'];
			$sufaction = 'jour';
			}
		elseif($myCase == 'news'){
			$data['title'] = $data['title'];
			$sufaction = 'entry';
			}
		elseif($myCase == 'albums'){
			$sufaction = 'album';
			}
		elseif($myCase == 'photos'){
			$sufaction = 'photo';
			}
		elseif($myCase == 'links'){
			$sufaction = 'link';
			}
		elseif($myCase == 'docs'){
			$sufaction = 'doc';
			}		
		elseif($myCase == 'staticpages'){
			$sufaction = 'staticpage';
			}						
		
		$html .= '	<tr>'."\n";
		$html .= '		<td>'.printLinkAction('view'.$sufaction,$myCase,$id).'</td>'."\n";
		$html .= '		<td>'.printLinkAction('edit'.$sufaction,$myCase,$id).'</td>'."\n";
		$html .= '		<td>'.printLinkAction('delete'.$sufaction,$myCase,$id).'</td>'."\n";
		$html .= '		<td>'.$data['title'];
		if($myCase == 'links')
			$html .= ' <a href="'.$data['url'].'" target="_blank">&gt; Ir</a>';
		$html .= '</td>'."\n";
		$html .= '	</tr>'."\n";
	}
	$html .= '</table>'."\n";
	
	return $html;
}

function printLinkAction ($myAction = 'view', $myCase = 'articles', $myID, $myText = ''){
	
	switch($myCase){
		case 'nums':
			$txtlink .= DIR_ADMIN."/mags/numpro.php?action=%s&numid=%d";
			break;
		case 'nums_articles_add':
			$txtlink .= DIR_ADMIN."/mags/artpro.php?action=%s&magid=%d";
			break;
		case 'nums_articles_list':
			$txtlink .= DIR_ADMIN."/mags/artlist.php?mode=%s";
			break;
		case 'magazines':
			$txtlink .= DIR_ADMIN."/mags/magpro.php?action=%s&jourid=%d";
			break;
		case 'articles':
			$txtlink .= DIR_ADMIN."/mags/artpro.php?action=%s&artid=%d&jourid=$_GET[jourid]";
			break;	
		case 'journals':
			$txtlink .= DIR_ADMIN."/news/jourpro.php?action=%s&jourid=%d";
			break;	
		case 'news':
			$txtlink .= DIR_ADMIN."/news/newspro.php?action=%s&entryid=%d&jourid=$_GET[jourid]";
			break;	
		case 'albums':
			$txtlink .= DIR_ADMIN."/gals/albumpro.php?action=%s&albumid=%d";
			break;	
		case 'photos':
			$txtlink .= DIR_ADMIN."/gals/photopro.php?action=%s&photoid=%d&albumid=$_GET[albumid]";
			break;	
		case 'links':
			$txtlink .= DIR_ADMIN."/links/linkpro.php?action=%s&linkid=%d";
			break;	
		case 'docs':
			$txtlink .= DIR_ADMIN."/docs/docpro.php?action=%s&docid=%d";
			break;			
		case 'statics':
			$txtlink .= DIR_ADMIN."/statics/staticpro.php?action=%s&staticid=%d";
			break;	
		case 'staticpages':
			$txtlink .= DIR_ADMIN."/statics/staticpagepro.php?action=%s&staticpageid=%d&staticid=$_GET[staticid]";
			break;					
			
	}
		
	$html .= '<a href="'.sprintf($txtlink, $myAction, $myID).'" ';
	if($myText == '')
		$myText = ucfirst(substr($myAction,0,1));
	$html .= 'title="'.$myAction.'">'.$myText.'</a>';
	
	return $html;	
}

function printLink($myLink, $myText='', $myTarget=''){

	if($myText=='')
		$myText=$myLink;

	$html='<a href="'.$myLink.'"';	if ($myTarget!='') $html.=' target="'.$myTarget.'"'; $html.='>'.$myText.'</a>';
	
	return $html;

}

function printFormNum($myData = ''){
	
	echo '<div class="form">'."\n";
	$form = new Form('formnum');
	$form->printFieldset('Datos del número');
	$form->addField('text', 'num', 'Número', $myData['num'], '20');
	$form->addField('text', 'title', 'Título', $myData['title']);
	$form->addTextarea('description', 'Descripción', $myData['description'], '', 65, 3);
	$form->addField('text', 'issue', 'Período', $myData['issue']);
	
	if($myData == '')
		$mySelect=1;
	else
		$mySelect[$myData['cms_tmpl']]=1;
	
	$myData['mag_tmpl_s'][0]='Elige una plantilla...';
	$myData['mag_tmpl_s'][1]='Plantilla 1';
	$myData['mag_tmpl_s'][2]='Plantilla 2';
	$myData['mag_tmpl_s'][3]='Plantilla 3';

	
	$form->addSelect('mag_tmpl', 'Plantilla', $myData['mag_tmpl_s'], $mySelect);
	$form->addField('albumID', 'albumID', 'Álbum fotográfico:', $myData['albumID'], '10');
	if($_GET['action'] == 'addnum')
		$buttext = 'Añadir';
	elseif($_GET['action'] == 'editnum')
		$buttext = 'Editar';
	$form->addField('submit', 'btn_num', $buttext, $buttext);
	$form->endForm();
	echo '</div>'."\n";
	
	return;
}


// Muestra formulario de confirmación de eliminación
function printFormDel($myCase = 'articles'){

	if($myCase == 'nums'){
		$butname = 'btn_delnum';
		$formaction = DIR_ADMIN.'/mag/numlist.php';
	}
	elseif($myCase == 'articles'){
		$butname = 'btn_delart';
		$formaction = DIR_ADMIN.'/mag/artlist.php';	
	}
	elseif($myCase == 'journals'){
		$butname = 'btn_deljour';
		$formaction = DIR_ADMIN.'/news/jourlist.php';	
	}
	elseif($myCase == 'news'){
		$butname = 'btn_delentry';
		$formaction = DIR_ADMIN.'/news/newslist.php';	
	}
	elseif($myCase == 'albums'){
		$butname = 'btn_delalbum';
		$formaction = DIR_ADMIN.'/gals/albumlist.php';	
	}
	elseif($myCase == 'photos'){
		$butname = 'btn_delphoto';
		$formaction = DIR_ADMIN.'/gals/photolist.php';	
	}
	elseif($myCase == 'links'){
		$butname = 'btn_dellink';
		$formaction = DIR_ADMIN.'/links/linklist.php';	
	}
	elseif($myCase == 'docs'){
		$butname = 'btn_deldoc';
		$formaction = DIR_ADMIN.'/docs/doclist.php';	
	}	
	elseif($myCase == 'statics'){
		$butname = 'btn_delstatic';
		$formaction = DIR_ADMIN.'/news/staticlist.php';	
	}
	elseif($myCase == 'staticpages'){
		$butname = 'btn_delstaticpage';
		$formaction = DIR_ADMIN.'/statics/staticpagelist.php';	
	}	
	
	echo '<table class="list" align="center"><tr>';
	echo '<td>';
	$form1 = new Form('ok');
	//$form1->addField('hidden', 'numid', $_GET['numid']);
	$form1->addField('submit', $butname, 'Si', 'Si');
	$form1->endForm();
	echo '</td><td>';
	$form2 = new Form('ok', '', $formaction);
	$form2->addField('submit', 'btn_no', 'No', 'No');
	$form2->endForm();	
	
	return;
}


// Muestra arbol de categorias
// $myCats: array con las categorias
// $myID: ID de la categoría de $catTree por la que comenzamos a trabajar
// $myLevel: nivel de profundidad en las llamadas recursivas
// $myType: 'list' -> lista  'array' -> array para utilizar en otra función 
// $myParam: url a la que se añadirán los parametros de categoría
function printCatTree($myCats, $myID = 0, $myLevel = 1, $myType = 'list', $myParam = ''){
	
	global $catTree, $myArray, $archiveName;
	// Si no tiene categorias hijas
	if(!$catTree[$myID]){
		return '';
	}
	// Con categorias hijas
	// Modo listado
	if($myType == 'list'){
		$html .= '<ul>'."\n";
		foreach ($catTree[$myID] as $key => $catID){
			
			if(!$myCats[$catID]['numRegs'])
				$myCats[$catID]['numRegs'] = 0;
			// Elemento lista
			$html .= '<li>'.printLink(sprintf($myParam, setSimpleText($myCats[$catID]['name'])), $myCats[$catID]['name']).' ('.$myCats[$catID]['numRegs'].')</li>'."\n";
			
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
			$myArray[$myCase] = $myText;
			
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
		return $myArray;
	}
	
}


// Muestra un select con posibilidad de ser combo
// $myData: los datos del select
//	$key -> parametro para el value del option
//	$value 	-> texto de la etiqueta option
// $mySelect: opción que debe aparecer seleccionada
// $myParam: url a la que se añaden los parametros contenidos en $myData
// $myType: 'auto' -> select como combo '' -> select simple
// $myName: nombre e id del select
function printJump($myData = '', $mySelect = '', $myParam = '', $myType = 'auto', $myName = 'numchapters', $myForm = ''){
	
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

function setSearch($myWord, $myField){

	$myWord = strip_tags($myWord); 
	$myWord = strtr($myWord,".,;:","    ");
	
	$search0 = explode(" ",$myWord);
	$string = "%' AND ".$myField." LIKE '%";
	$search = implode($string,$search0);
	
	return $search;
}

function convertDateU2L($myDate){
	$myDate=strftime("%d-%m-%Y %H:%M:%S", $myDate);
	return $myDate;
}

function convertDateU2L_2($myDate){
	$myDate=strftime("%d/%m/%Y", $myDate);
	return $myDate;
}

function convertDateU2LFormat($myDate = "", $myFormat = "%d/%m/%Y"){
	$myDate = strftime($myFormat, $myDate);
	return $myDate;
}

// Convierte la fecha en formato latino dia-mes-año hora-min-sec a formato Unix
function convertDateL2U($myDate){
	$aux=explode(" ", $myDate);
	$date=explode("-", $aux[0]);
	$time=explode(":", $aux[1]);
	$myDate=mktime($time[0], $time[1], $time[2], $date[1], $date[0], $date[2]);
	return $myDate;
}

// Devuelve tiempo desde 00-xx-xxxx hasta 31-xx-xxxx
function getIntervalDates ($myDate = ''){
	
	// Formato ddmmyyyy
	if(strlen($myDate) == 8){
		
	}
	
	// Formato mmyyyy
	elseif(strlen($myDate) == 6){
		$month = substr($myDate, 0, 2);
		$year = substr($myDate, 2, 4);
		$myInterval[0]=mktime(0, 0, 0, $month, 0, $year);
		for($i=31; $i>27; $i--){
			if(checkdate($month, $i, $year)){
				$lastDay = $i;
				break;
			}	
		}
		$myInterval[1]=mktime(24, 60, 59, $month, $lastDay, $year);
	}
	
	return $myInterval;
}

function convertText($myText, $nl2br = 0){
	// Convertimos los saltos de linea en <br />
	if ($nl2br == 1 || $nl2br == 'on')
		$myText = nl2br($myText);
		
	// Convierte algunos caracteres especiales (no las etiquetas html)
	$specialChars=array('á'=>'&aacute;', 'é'=>'&eacute;', 'í'=>'&iacute;', 'ó'=>'&oacute;', 'ú'=>'&uacute;', '¡'=>'&iexcl;', '¿'=>'&iquest;', '·'=>'&middot;', 'ñ'=>'&ntilde;');
	foreach ($specialChars as $char => $replace)
		$myText=str_replace($char, $replace, $myText);
		
	//$myText=addslashes($myText);
	return $myText;
}

function printTextField($myText, $br2nl=1){
	// Cambiamos las etiquetas <br /> por saltos de línea
	if ($br2nl==1){
		$tagBr=array("<br>", "<br/>", "<br />", "<BR>");
			for ($i=0;$i<count($tagBr);$i++)
				$myText=str_replace($tagBr[$i], "", $myText);
		}
	
	//$myText=stripslashes($myText);
	
	return $myText;
}

// Muestra texto sacado de una BD y lo formatea
function printText($myText, $nl2br=1){
	
	if($nl2br == 1){
		$myText = nl2br($myText);
	}
	$myText=stripslashes($myText);
	// Convierte algunos caracteres especiales (no las etiquetas html)
	$specialChars=array('á'=>'&aacute;', 'é'=>'&eacute;', 'í'=>'&iacute;', 'ó'=>'&oacute;', 'ú'=>'&uacute;', '¡'=>'&iexcl;', '¿'=>'&iquest;', '·'=>'&middot;', 'ñ'=>'&ntilde;');
	foreach ($specialChars as $char => $replace)
		$myText=str_replace($char, $replace, $myText);
	
	return $myText;
}

function convertFields($_POST){
	$_POST['title']=convertText($_POST['title'], $_POST['nl2br']);
	$_POST['excerpt']=convertText($_POST['excerpt'], $_POST['nl2br']);
	foreach ($_POST['body'] as $text){
		$text=convertText($text, $_POST['nl2br']);
	}
	if($_POST['title_chapter']){
		foreach ($_POST['title_chapter'] as $text){
			$text=convertText($text, $_POST['nl2br']);
		}
	}
	
	return;
}

function createDir ($myFolder, $myPerm=0770, $myPath=''){

	$myFull = ROOT_PATH . $myPath . $myFolder;
	if(!file_exists($myPath)){
		$oldUmask = umask(0);
		$ok = mkdir($myFull, $myPerm);
		umask($oldUmask);
		return $ok;
	}
	else
		return false;
	
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

// Inserta en la BD los últimos elementos añadidos
// $myID	: identificador del elemento
// $myType	: articles news links albums...
// $mySectionID : identificador de la sección a la que pertenece (journal, magazine...) 
function saveLastInsert($myID, $myType, $date = '', $mySectionID = '', $myStatus = 0){

	global $siteDB;
	
	if($myType == 'links' || $myType == 'photos' || $myStatus == 1)
		return;
	else{
	if($date == '')
		$date = date('U');
	if($mySectionID == '')
		$mySectionID = 0;
	$query="INSERT INTO cms_lasts 
				 (itemID, type, date, sectionID) 
				VALUES ($myID, '$myType', $date, $mySectionID)";
	$result = $siteDB->query($query);
	$siteDB->free_result();
	
	// Actualizamos nuestra salida grabada
	$lasts = getLastInsert();
	printLastInsert($lasts, 'savehtml');
	printLastInsert($lasts, 'rss');
	}
	return;	
}

// Actualiza un elemento modificado
function updateLastInsert($myID, $myType, $date, $mySectionID = '', $myStatus = 0){

	global $siteDB;

	if($myStatus == 1){
		delLastInsert($myID, $myType);
		return;
	}
	else{
	
		if($date == '')
			$date = date('U');
		if($mySectionID == '')
			$mySectionID = 0;	
	
		// Comprobamos que la entrada ya existe en la tabla
		$query="SELECT *  
				FROM cms_lasts 
				WHERE itemID = $myID AND type = '$myType'";
		$resultBefore = $siteDB->query($query);
		$item = $siteDB->fetch_array($resultBefore, 1);
		
		// La entrada no existía previamente
		if(!$item){
			$query="INSERT INTO cms_lasts 
				 (itemID, type, date, sectionID) 
				VALUES ($myID, '$myType', $date, $mySectionID)";
			$result = $siteDB->query($query);
			$siteDB->free_result();
		}		
		
		// La entrada si existía antes
		else{
			$query="UPDATE cms_lasts 
					SET type = '$myType', date = $date, sectionID = $mySectionID
					WHERE itemID = $myID";
			$result = $siteDB->query($query);
			$siteDB->free_result();
		}
		// Actualizamos nuestra salida grabada
		$lasts = getLastInsert();
		printLastInsert($lasts, 'savehtml');
		printLastInsert($lasts, 'rss');
		return;
	}

}

// Borra de la BD de últimos uno el elemento eliminado
function delLastInsert($myID, $myType){
	global $siteDB;
	$query="DELETE 
				FROM cms_lasts 
				WHERE itemID='$myID' AND type='$myType'";
	$result = $siteDB->query($query);
	$siteDB->free_result();
	// Actualizamos nuestra salida grabada
	$lasts = getLastInsert();
	printLastInsert($lasts, 'savehtml');	
	printLastInsert($lasts, 'rss');
	return;	
}

// Muestra los últimos elementos añadidos en la BD
function getLastInsert($myMode = 'all', $myLimit = '10'){

	global $siteDB;
	
	if($myMode != 'all')
		$queryX = " WHERE type=$myMode ";
	else
		$queryX = "";

	$query = "SELECT * 
				FROM cms_lasts "
				.$queryX.
				" ORDER BY date DESC LIMIT 0, $myLimit";
				
		$result = $siteDB->query($query);
	
	while ($row = $siteDB->fetch_array($result, 1)){
		$data[$row['itemID']] = $row;
	}
	
	foreach ($data as $id => $item){
	
		switch($item['type']){
			case 'articles': 
				$data[$id]['data'] = getArtShort($item['itemID']);
				$data[$id]['jour'] = getJournal($data[$id]['data']['jourID']);
				break;
			case 'news':
				$data[$id]['data'] = getEntry($item['itemID']);
				$data[$id]['jour'] = getJournal($data[$id]['data']['jourID']);
				break;
			case 'photos':
				$data[$id]['data'] = getPhoto($item['itemID']);
				$data[$id]['album'] = getAlbum($data[$id]['data']['albumID']);
				break;
			case 'albums':
				$data[$id]['data'] = getAlbum($item['itemID']);
				break;				
			case 'links':
				$data[$id]['data'] = getLink($item['itemID']);
				break;	
			case 'documents':
				$data[$id]['data'] = getDoc($item['itemID']);
				break;		
			case 'staticpages':
				$data[$id]['data'] = getStaticpage($item['itemID']);
				$data[$id]['static'] = getStatic($data[$id]['data']['staticID']);
				break;							
		}						
	
	}
	
	$siteDB->free_result();
	
	return $data;
	
}
// Muestra los últimos elemenots añadidos a la BD
// $myData : Datos tablulados de lo último añadido
// $myMode : 'live' : muestra el contenido directamente
//			 'savehtml' : lo graba en un archivo formato html
//			 'saverss' : lo graba en un archivo formato RSS 2.0
function printLastInsert($myData, $myMode = 'live'){
	
	$i = 0;
	
	foreach($myData as $id => $item){
		
		// Parche para que la versión live o html solo tenga 5 items
		if(($myMode == 'live' || $myMode == 'savehtml') && $i == 5){
			break;
		}
		
		$itemDateU = $item['data']['date'];
		$itemDate = convertDateU2LFormat($item['data']['date']);
		$itemTitle = $item['data']['title'];
		$itemUserName = getUserName($item['data']['userID']);
		
		switch($item['type']){
			case 'articles': 
				$itemMagLink = "http://www.boulesis.com".$item['jour']['path'];
				$itemLink = $itemMagLink.'/'.printGetUrl('a', $item['itemID'], 'simple');
				$itemType = 'Artículo';
				$itemMag = $item['jour']['title'];
				$itemDesc = $item['data']['body'];
				if($item['data']['excerpt'] != NULL)
					$itemDesc = $item['data']['excerpt']." ".$itemDesc;
				break;
			case 'news':
				$itemMagLink = "http://www.boulesis.com".$item['jour']['path'];
				$itemLink = $itemMagLink.'/'.printGetUrl('n', $item['itemID'], 'simple');
				$itemType = 'Noticia';
				$itemMag = $item['jour']['title'];
				$itemDesc = $item['data']['body'];
				if($item['data']['excerpt'] != NULL)
					$itemDesc = $item['data']['excerpt']." ".$itemDesc;
				break;
			case 'photos':
				$itemMagLink = 'http://www.boulesis.com/didactica/galeria/';
				$itemLink = $itemMagLink.printGetUrl('im', $item['itemID'], 'simple');
				$itemType = 'Foto';
				$itemMag = $item['jour']['title'];
				$itemDesc = $item['data']['description'];
				break;
			case 'albums':
				$itemMagLink = 'http://www.boulesis.com/didactica/galeria/';
				$itemLink = $itemMagLink.printGetUrl('al', $item['itemID'], 'simple');
				$itemType = 'Album';
				$itemMag = $item['jour']['title'];
				$itemDesc = $item['data']['description'];
				break;				
			case 'links':
				$itemLink = $item['data']['url'];
				$itemType = 'Enlace';
				$itemDesc = $item['data']['description'];
				break;	
			case 'documents':
				$itemMagLink = 'http://www.boulesis.com/didactica/documentos/';
				$itemLink = $itemMagLink.printGetUrl('d', $item['itemID'], 'simple');
				$itemType = 'Documento';
				$itemMag = 'Documentos';
				$itemDesc = $item['data']['description'];
				break;					
			case 'staticpages':
				$itemMagLink = "http://www.boulesis.com".$item['static']['path'];
				$itemLink = $item['data']['url'];
				$itemType = 'Página';
				$itemMag = $item['static']['title'];
				$itemDesc = $item['data']['description'];
				if($item['data']['excerpt'] != NULL)
					$itemDesc = $item['data']['excerpt']." ".$itemDesc;
				break;				
		}
		
		$items[$i]['date'] = $itemDate;
		$items[$i]['dateU'] = $itemDateU;
		$items[$i]['link'] = $itemLink;
		$items[$i]['type'] = $item['type'];
		$items[$i]['title'] = $itemTitle;
		$items[$i]['desc'] = $itemDesc;
		$items[$i]['mag'] = $itemMag;
		$items[$i]['maglink'] = $itemMagLink;
		$items[$i]['username'] = $itemUserName;
		
		$i++;
	
	}
	
	if($myMode == 'live' || $myMode == 'savehtml'){
		$last_item = & new Template(ROOT_PATH.'/com/tmpl/');
		$last_item->set('items', $items);
		$lastList = $last_item->fetch('last_list.tpl');
		unset($last_item);
		if($myMode == 'live')
			return $lastList;
		else{
			$file = ROOT_PATH.'/com/data/lasts.htm';
			$fp = fopen($file, 'w');
			fwrite($fp, $lastList);
			fclose($fp);
			return;
		}
			
	}
	elseif($myMode == 'rss'){

		
		printLastRss($items, '', 'didactica');

	}
	return false;
}

// Genera RSS con los últimos añadidos por sección y global
function printLastRss($myData, $myVersion = 'RSS1.0', $mySection = ''){

	// Para crear los feeds
	require(ROOT_PATH.'/com/scripts/feed/feedcreator.class.php');
	
	// Global
	$rss = new UniversalFeedCreator(); 
	$rss->useCached(); // use cached version if age<1 hour
	$rss->title = "Boulesis.com · Didáctica"; 
	$rss->description = "Recursos para la enseñanza de la filosofía"; 
	$rss->link = "http://www.boulesis.com/didactica/"; 
	$rss->syndicationURL = "http://www.boulesis.com/didactica/index.xml"; 
	
	$image = new FeedImage(); 
	$image->title = "didactica de boulesis.com"; 
	$image->url = "http://www.boulesis.com/media/didiactica_boton.gif"; 
	$image->link = "http://www.boulesis.com/didactica/"; 
	$image->description = "Recursos para la enseñanza de la filosofía"; 
	$rss->image = $image; 
	
	foreach ($myData as $key => $data){
	
		$item = new FeedItem(); 
    	$item->title = $data['title']; 
    	$item->link = $data['link']; 
    	$item->date = convertDateU2LFormat($data['dateU'], "%Y-%m-%dT%H:%M:%S+0100"); 
    	$item->source = "http://www.boulesis.com/didactica/"; 
    	$item->author = $data['username']; 
		$item->contentEnc = setRssText($data['desc'], 0, 60, 0);
		$item->description = $rss->iTrunc(strip_tags($data['desc']), 250);
     
    	$rss->addItem($item); 
	
	}
	
	$rss->saveFeed("RSS1.0", ROOT_PATH."/didactica/index.xml", false);
	
}

// Extrae el texto sin etiquetas, con palabras limitadas y codificado XHTML
function setRssText($myText, $striptags = 1, $words = 0, $encode = 1){

	if($striptags == 1){
		$myText = str_replace("\n", '', $myText);
		$myText = strip_tags($myText);
	}
	if($words != 0){
		$myWords = explode(" ", $myText);
		for($i=0; $i<$words; $i++)
			$newText .= $myWords[$i].' ';
		 $myText = $newText.'... ';
	}
	if($encode == 1){
		$myText = htmlspecialchars($myText);
	}
	
	return $myText;

}
?>