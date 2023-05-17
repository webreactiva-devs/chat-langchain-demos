<?php
// Funciones de noticias (news))

// Devuelve los datos de diarios (Statics)
function getStatics($myMode='all', $myStaticType = '0'){
	
	global $siteDB, $numRegs;

	if($myMode == 'title'){
		$keywords = setSearch($_POST['title'], 'title');
		$queryX = " AND title LIKE '%".$keywords."%' ";
	}
	
	if($myMode == 'all'){
		$queryX = "";
	}
	
	if($myMode == 'id'){
		$queryX = " AND staticID = $_GET[staticid] ";
	}
	
	$query = "SELECT * 
				FROM cms_statics 
				WHERE static_type=$myStaticType "
				.$queryX.
				" ORDER BY title ASC";
	//echo $query;		
	$result = $siteDB->query($query);
	
	while ($row = $siteDB->fetch_array($result, 1)){
		$data[$row['staticID']] = $row;
	}
	//print_r($data);
	//$data['numRegs'] = $siteDB->get_numrows();
	$numRegs = $siteDB->get_numrows();
	$siteDB->free_result();
	return $data;

}

// Devuelve datos sobre un diario
function getStatic($myID){
	
	global $siteDB;

	$query = "SELECT * 
				FROM cms_statics
				WHERE staticID=$myID ";
			
	$data = $siteDB->query_firstrow($query);
	
	$siteDB->free_result();
	return $data;

}

// Devuelve los datos de las noticias
// myMode = modo de recoger la informacion
// mystaticID = podemos no señalarlo
// myCatId = categoria que queremos mostrar
// myDate = fecha en formato mmyyyy
function getStaticpages($myMode='all', $mystaticID = '', $myCatID = '', $myDate = ''){
	
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

	
	if($myMode == 'staticID'){
		if($_POST['staticID'])
			$staticID = $_POST['staticID'];
		else
			$staticID = $mystaticID;
		$queryX = " AND staticID=$staticID ";
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
				FROM cms_staticpages 
				WHERE staticID=$mystaticID "
				.$queryX.
				" ORDER BY staticpageID DESC";
	// echo $query;		
	$result = $siteDB->query($query);
	
	while ($row = $siteDB->fetch_array($result, 1)){
		$data[$row['staticpageID']] = $row;
	}
	
	$numItems = $siteDB->get_numrows();
	$siteDB->free_result();
	return $data;

}

// Devuelve los datos de una entrada
function getStaticpage($myID){
	
	global $siteDB;

	$query = "SELECT * 
				FROM cms_staticpages 
				WHERE staticpageID=$myID";
			
	$result = $siteDB->query($query);
	
	$data = $siteDB->query_firstrow($query);
	
	// Error
	if(!$data)
		echo 'No existe esa entrada';
	
	$siteDB->free_result();
	return $data;
	
}


// Mostrar formulario de Diario
function printFormStatic($myData = ''){

	$dataGroups = getGroups();
	
	echo '<div class="form">'."\n";
	$form = new Form('formStatic');
	$form->printFieldset('Datos de la sección estática');
	$form->addField('text', 'title', 'Título', $myData['title']);
	$form->addTextarea('description', 'Descripción', $myData['description'], '', 65, 3);
	$form->addTextarea('text', 'Texto adicional', $myData['text'], '', 65, 5);
	$form->addField('text', 'path', 'Path', $myData['path']);
	//$form->addField('text', 'url', 'Url', $myData['url']);
	
	// tipo
	if($myData == '')
		$mySelect=1;
	else
		$mySelect[$myData['static_type']]=1;
	
	$myData['statictype'][0]='Uno';
	$myData['statictype'][1]='Dos';
	
	$form->addSelect('static_type', 'Tipo', $myData['statictype'], $mySelect);
	
	
	// plantillas
	/*if($myData == '')
		$mySelect2=1;
	else
		$mySelect2[$myData['template']]=1;
	
	$myData['templ'][0]='Noticias';
	$myData['templ'][1]='Noticias larga';
	$myData['templ'][2]='FAQ';
	$myData['templ'][3]='Alfabética';
	
	$form->addSelect('template', 'Plantilla presentación', $myData['templ'], $mySelect2);*/
	
	// Grupos
	$dataGroups[0]['name'] = 'Ninguno';
	foreach($dataGroups as $groupID => $values){
		$groups[$groupID] = $values['name'];
		if($myData['groupID'] == $groupID)
			$groups_s[$groupID]=1;
	}
	$form->addSelect('groupID', 'Grupo de información', $groups, $groups_s);
	
	$form->addField('text', 'imageID', 'Imagen', $myData['imageID'], '10');
	if($_GET['action'] == 'addStatic')
		$buttext = 'Añadir';
	elseif($_GET['action'] == 'editStatic')
		$buttext = 'Editar';
	$form->addField('submit', 'btn_static', $buttext, $buttext);
	$form->endForm();
	echo '</div>'."\n";
	
	return;
}


// Muestra el formulario de Noticias
function printFormStaticpage ($myData = '', $myGroupID = 0){

	global $catTree;

	// Fecha
	if(!isset($myData['date']))
		$myData['date']=convertDateU2L(date("U"));
	if(!isset($myData['date_mod']))
		$myData['date_mod']=$myData['date'];
		
	// Etiqueta del botón
	if($_GET['action'] == 'addstaticpage')
		$buttext = 'Añadir';
	elseif($_GET['action'] == 'editstaticpage')
		$buttext = 'Editar';
	
	// Categorias
	$data = getCats('staticpages', $myGroupID);
	$cats = printCatTree($data, 0, 1, 'array');

	
	// Usuarios
	if(!$myData['userID'])
		$myData['userID'] == $_SESSION['userID'];

	echo '<div class="form">'."\n";
	$form = new Form('staticpages');
	$form->printFieldset('Datos principales');
	$form->addField('text', 'title', 'Título', $myData['title'], 50);
	$form->addTextarea('description', 'Descripción', $myData['description'], '', 65, 3);
	$form->addField('text', 'url', 'Dirección', $myData['url'], 50);
	$form->addField('hidden', 'staticID', '', $_GET['staticid']);
	$form->printFieldset('Datos generales');
	
	$form->addField('text', 'date', 'Fecha', $myData['date_mod'], 20);

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
	$form->addField('submit', 'btn_staticpage', $buttext, $buttext);
	$form->endForm();
	
	echo '</div>'."\n";

	return;
}

function printListStatics ($myData = '', $myCase = 'statics'){

	global $numItems;
	foreach ($myData as $id => $data){
		if($myCase == 'statics'){
			$sufaction = 'static';
			$news = getStaticpages('all', $id);
		}
		elseif($myCase == 'magazines'){
			$sufaction = 'static';
			$arts = getArts('staticID', $id);
		}
		
		

		$html .= '<div class="item">'."\n";
		$html .= '<strong>'.$data['title'].'</strong><br />';
		$html .= $data['description'].'<br />';
		$html .= printLinkAction('edit'.$sufaction,$myCase,$id, 'Editar').' | ';
		$html .= printLinkAction('delete'.$sufaction,$myCase,$id, 'Borrar').'<br />';
		$html .= $numItems.' entradas | ';
		if($myCase == 'statics'){
			$html .= '<a href="'.DIR_ADMIN.'/statics/staticpagepro.php?action=addstaticpage&staticid='.$id.'">Añadir entrada</a> | ';
			$html .= '<a href="'.DIR_ADMIN.'/statics/staticpagelist.php?staticid='.$id.'">Ver entradas</a>';
			$html .= ' :: <a href="'.$data['path'].'" target="_blank" >Ver diario</a><br />';
		}
		elseif($myCase == 'magazines'){
			$html .= '<a href="'.DIR_ADMIN.'/mags/artpro.php?action=addart&Staticid='.$id.'">Añadir artículo</a> | ';
			$html .= '<a href="'.DIR_ADMIN.'/mags/artlist.php?Staticid='.$id.'">Ver artículos</a>';
			$html .= ' :: <a href="'.$data['path'].'" target="_blank" >Ver publicación</a><br />';
		}
		$html .= '</div>'."\n";
	
	}
	
	return $html; 
}
?>