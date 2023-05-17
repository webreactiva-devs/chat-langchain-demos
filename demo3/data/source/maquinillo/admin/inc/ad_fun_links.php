<?php
// Funciones para enlaces

// Devuelve los datos de los enlaces
function getLinks($myMode='all', $myCatID = '', $myDate = '', $myLimit = ''){
	
	global $siteDB, $numItems;
	
	if($myMode == 'all'){
		$queryX = "";
	}
	
	if($myMode == 'search'){
		$keywords = setSearch($_POST['q'], 'title');
		$queryX = " AND title LIKE '%".$keywords."%' ";
		$keywords = setSearch($_POST['q'], 'body');
		$queryX .= " OR body LIKE '%".$keywords."%' ";
	}

	if($myMode == 'categories'){
		if(!$myCatID && $_REQUEST['catID'])
			$myCatID = $_REQUEST['catID'];
		$queryX = " AND catID=$myCatID ";
	}
	
	if($myMode == 'date'){
		if(!$myDate && $_REQUEST['date'])
			$myDate = $_REQUEST['date'];
		$dates = getIntervalDates($myDate);
		$queryX = " AND date_mod<$dates[1] AND date_mod>$dates[0] ";
	}
	
	$query = "SELECT * 
				FROM cms_links 
				WHERE 1>0 "
				.$queryX.
				" ORDER BY title ";
	// echo $query;		
	$result = $siteDB->query($query);
	
	while ($row = $siteDB->fetch_array($result, 1)){
		$data[$row['linkID']] = $row;
	}
	
	$numItems = $siteDB->get_numrows();
	$siteDB->free_result();
	return $data;

}

// Últimos enlaces
function getLastLinks($myLimit = 5){

	global $siteDB;

	$query = "SELECT * 
				FROM cms_links
				ORDER BY date DESC  
				LIMIT 0, $myLimit";
			
	$result = $siteDB->query($query);
	
	while ($row = $siteDB->fetch_array($result, 1)){
		$data[$row['linkID']] = $row;
	}
	
	$siteDB->free_result();
	
	return $data;

}

// Devuelve datos sobre un enlace
function getLink($myID){
	
	global $siteDB;

	$query = "SELECT * 
				FROM cms_links
				WHERE linkID=$myID ";
			
	$data = $siteDB->query_firstrow($query);
	
	$siteDB->free_result();
	return $data;

}

// Muestra el formulario de enlace
function printFormLink ($myData = '', $myGroupID = 0){

	global $catTree;

	// El grupo de los enlaces siempre el mismo
	$myData['groupID'] = 100;

	// Fecha
	if(!isset($myData['date']))
		$myData['date']=convertDateU2L(date("U"));
	else
		$myData['date']=convertDateU2L($myData['date']);
		
	// Etiqueta del botón
	if($_GET['action'] == 'addentry')
		$buttext = 'Añadir';
	elseif($_GET['action'] == 'editentry')
		$buttext = 'Editar';
	
	// Categorias
	$data = getCats('links', $myData['groupID']);
	$cats = printCatTree($data, 0, 1, 'array');
	
	// Usuarios
	if(!$myData['userID'])
		$myData['userID'] == $_SESSION['userID'];
	
	echo '<div class="form">'."\n";
	$form = new Form('news');
	$form->printFieldset('Datos del enlace');
	$form->addField('text', 'title', 'Título', $myData['title'], 50);
	$form->addField('text', 'url', 'URL del enlace', $myData['url'], 50);
	$form->addTextarea('description', 'Descripción', $myData['description'], '', 65, 3);
	$form->addField('text', 'date', 'Fecha', $myData['date']);
	
	$select .= '<label for="catID">Categorías</label><br />';
	$select .= printJump($cats, $myData['catID'], '%d', '', 'catID').'<br />';
	echo $select;
	
	if($myData == '')
		$mySelect=1;
	else
		$mySelect[$myData['status']]=1;
	$myData['status_s'][0]='Visible';
	$myData['status_s'][1]='Invisible';	
	$form->addSelect('status', 'Estado', $myData['status_s'], $mySelect);
	
	$form->addField('text', 'imageID', 'Imagen', $myData['imageID'], '10');
	
	$select = '<label for="userID">Autor</label><br />';
	$select .= printJumpUsers('', $myData['userID']).'<br />';
	echo $select;
	
	$form->addField('submit', 'btn_link', $buttext, $buttext);
	$form->endForm();
	echo '</div>'."\n";

	return;
}
?>