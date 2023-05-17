<?php
// Funciones de noticias (news))

// Devuelve los datos de diarios (journals)
function getJournals($myMode='all', $myJourType = '0'){
	
	global $siteDB, $numRegs;

	if($myMode == 'title'){
		$keywords = setSearch($_POST['title'], 'title');
		$queryX = " AND title LIKE '%".$keywords."%' ";
	}
	
	if($myMode == 'all'){
		$queryX = "";
	}
	
	if($myMode == 'id'){
		$queryX = " AND jourID = $_GET[jourid] ";
	}
	
	$query = "SELECT * 
				FROM cms_journals 
				WHERE journal_type=$myJourType "
				.$queryX.
				" ORDER BY title ASC";
	//echo $query;		
	$result = $siteDB->query($query);
	
	while ($row = $siteDB->fetch_array($result, 1)){
		$data[$row['jourID']] = $row;
	}
	//print_r($data);
	//$data['numRegs'] = $siteDB->get_numrows();
	$numRegs = $siteDB->get_numrows();
	$siteDB->free_result();
	return $data;

}

// Devuelve datos sobre un diario
function getJournal($myID){
	
	global $siteDB;

	$query = "SELECT * 
				FROM cms_journals
				WHERE jourID=$myID ";
			
	$data = $siteDB->query_firstrow($query);
	
	$siteDB->free_result();
	return $data;

}

// Devuelve los datos de las noticias
// myMode = modo de recoger la informacion
// myJourID = podemos no señalarlo
// myCatId = categoria que queremos mostrar
// myDate = fecha en formato mmyyyy
function getNews($myMode='all', $myJourID = '', $myCatID = '', $myDate = ''){
	
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

	
	if($myMode == 'jourID'){
		if($_POST['jourID'])
			$jourID = $_POST['jourID'];
		else
			$jourID = $myJourID;
		$queryX = " AND jourID=$jourID ";
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
				FROM cms_news 
				WHERE jourID=$myJourID "
				.$queryX.
				" ORDER BY entryID DESC";
	// echo $query;		
	$result = $siteDB->query($query);
	
	while ($row = $siteDB->fetch_array($result, 1)){
		$data[$row['entryID']] = $row;
	}
	
	$numItems = $siteDB->get_numrows();
	$siteDB->free_result();
	return $data;

}

// Devuelve los datos de una entrada
function getEntry($myID){
	
	global $siteDB;

	$query = "SELECT * 
				FROM cms_news 
				WHERE entryID=$myID";
			
	$result = $siteDB->query($query);
	
	$data = $siteDB->query_firstrow($query);
	
	// Error
	if(!$data)
		echo 'No existe esa entrada';
	
	$siteDB->free_result();
	return $data;
	
}


// Mostrar formulario de Diario
function printFormJournal($myData = ''){

	$dataGroups = getGroups();
	
	echo '<div class="form">'."\n";
	$form = new Form('formjour');
	$form->printFieldset('Datos del diario');
	$form->addField('text', 'title', 'Título', $myData['title']);
	$form->addTextarea('description', 'Descripción', $myData['description'], '', 65, 3);
	$form->addTextarea('text', 'Texto adicional', $myData['text'], '', 65, 5);
	$form->addField('text', 'path', 'Path', $myData['path']);
	$form->addField('text', 'url', 'Url', $myData['url']);
	
	// tipo
	if($myData == '')
		$mySelect=1;
	else
		$mySelect[$myData['journal_type']]=1;
	
	$myData['jour_type'][0]='Noticias';
	$myData['jour_type'][1]='Artículos';
	
	$form->addSelect('journal_type', 'Tipo', $myData['jour_type'], $mySelect);
	
	// plantillas
	if($myData == '')
		$mySelect2=1;
	else
		$mySelect2[$myData['template']]=1;
	
	$myData['templ'][0]='Noticias';
	$myData['templ'][1]='Noticias larga';
	$myData['templ'][2]='FAQ';
	$myData['templ'][3]='Alfabética';
	
	$form->addSelect('template', 'Plantilla presentación', $myData['templ'], $mySelect2);
	
	// Grupos
	$dataGroups[0]['name'] = 'Ninguno';
	foreach($dataGroups as $groupID => $values){
		$groups[$groupID] = $values['name'];
		if($myData['groupID'] == $groupID)
			$groups_s[$groupID]=1;
	}
	$form->addSelect('groupID', 'Grupo de información', $groups, $groups_s);
	
	$form->addField('text', 'imageID', 'Imagen', $myData['imageID'], '10');
	if($_GET['action'] == 'addjour')
		$buttext = 'Añadir';
	elseif($_GET['action'] == 'editjour')
		$buttext = 'Editar';
	$form->addField('submit', 'btn_jour', $buttext, $buttext);
	$form->endForm();
	echo '</div>'."\n";
	
	return;
}


// Muestra el formulario de Noticias
function printFormEntry ($myData = '', $myGroupID = 0){

	global $catTree;

	// Fecha
	if(!isset($myData['date']))
		$myData['date']=convertDateU2L(date("U"));
	if(!isset($myData['date_mod']))
		$myData['date_mod']=$myData['date'];
		
	// Etiqueta del botón
	if($_GET['action'] == 'addentry')
		$buttext = 'Añadir';
	elseif($_GET['action'] == 'editentry')
		$buttext = 'Editar';
	
	// Categorias
	$data = getCats('news', $myGroupID);
	$cats = printCatTree($data, 0, 1, 'array');
	
	// Usuarios
	if(!$myData['userID'])
		$myData['userID'] == $_SESSION['userID'];

	echo '<div class="form">'."\n";
	$form = new Form('news');
	$form->printFieldset('Datos principales');
	$form->addField('text', 'title', 'Título', $myData['title'], 50);
	$form->addTextarea('excerpt', 'Entradilla', $myData['excerpt'], '', 65, 3);
	$form->addField('hidden', 'jourID', '', $_GET['jourID']);
	$form->addTextarea('body', 'Cuerpo', $myData['body'], '', 65, 10);
	$form->printFieldset('Datos generales');
	
	echo '<input type="checkbox" name="nl2br" id="nl2br" ';
	if($myData['nl2br']=='on')
		echo 'checked="checked"';
	echo ' class="formfield" />
		<label for="nl2br" class="text" >Convertir saltos de línea</label>
		<br />';
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
	$form->addField('submit', 'btn_entry', $buttext, $buttext);
	$form->endForm();
	
	echo '</div>'."\n";

	return;
}

function printListJournals ($myData = '', $myCase = 'journals'){

	global $numItems;
	foreach ($myData as $id => $data){
		if($myCase == 'journals'){
			$sufaction = 'jour';
			$news = getNews('all', $id);
		}
		elseif($myCase == 'magazines'){
			$sufaction = 'jour';
			$arts = getArts('jourID', $id);
		}
		
		

		$html .= '<div class="item">'."\n";
		$html .= '<strong>'.$data['title'].'</strong><br />';
		$html .= $data['description'].'<br />';
		$html .= printLinkAction('edit'.$sufaction,$myCase,$id, 'Editar').' | ';
		$html .= printLinkAction('delete'.$sufaction,$myCase,$id, 'Borrar').'<br />';
		$html .= $numItems.' entradas | ';
		if($myCase == 'journals'){
			$html .= '<a href="'.DIR_ADMIN.'/news/newspro.php?action=addentry&jourid='.$id.'">Añadir entrada</a> | ';
			$html .= '<a href="'.DIR_ADMIN.'/news/newslist.php?jourid='.$id.'">Ver entradas</a>';
			$html .= ' :: <a href="'.$data['path'].'" target="_blank" >Ver diario</a><br />';
		}
		elseif($myCase == 'magazines'){
			$html .= '<a href="'.DIR_ADMIN.'/mags/artpro.php?action=addart&jourid='.$id.'">Añadir artículo</a> | ';
			$html .= '<a href="'.DIR_ADMIN.'/mags/artlist.php?jourid='.$id.'">Ver artículos</a>';
			$html .= ' :: <a href="'.$data['path'].'" target="_blank" >Ver publicación</a><br />';
		}
		$html .= '</div>'."\n";
	
	}
	
	return $html; 
}
?>