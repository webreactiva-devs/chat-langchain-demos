<?php
// Funciones de articulos (mags)
// Devuelve los datos de los articulos segun criterio
function getArts($myMode='all', $myJourID = ''){
	
	global $siteDB, $numItems;

	if($myMode == 'title'){
		$keywords = setSearch($_POST['title'], 'title');
		$queryX = " AND title LIKE '%".$keywords."%' ";
		$keywords = setSearch($_POST['q'], 'body');
		$queryX .= " OR body LIKE '%".$keywords."%' ";		
	}
	
	if($myMode == 'all'){
		$queryX = "";
	}
	
	if($myMode == 'jourID'){
		if($_POST['jourID'])
			$jourID = $_POST['jourID'];
		else
			$jourID = $myJourID;
		$queryX = " AND jourID=$jourID ";
	}
	
	$query = "SELECT * 
				FROM cms_articles
				WHERE 1>0 "
				.$queryX.
				"ORDER BY artID ASC";
			
	$result = $siteDB->query($query);
	
	while ($row = $siteDB->fetch_array($result, 1)){
		$data[$row['artID']] = $row;
	}
	
	$numItems = $siteDB->get_numrows();
	$siteDB->free_result();
	return $data;

}


function getMagName($myID){
		
	$query="SELECT name
			FROM mag
			WHERE magID='$myID'";
	$name = $siteDB->query_firstrow($query);
	return $name;
}


 function printFormArt ($myData = '', $myGroupID = 0){
	
	// Convertir saltos de línea
	/*if(!isset($myData['nl2br']))
		$myData['nl2br']=0;
	else
		$myData['nl2br']=1;*/
		
	// Fecha
	if(!isset($myData['date']))
		$myData['date']=convertDateU2L(date("U"));
	if(!isset($myData['date_mod']))
		$myData['date_mod']=$myData['date'];
	
	// Número de capítulos
	if($_POST['numchapters'])
		$numchapters = $_POST['numchapters'];
	elseif($myData['num_chapters'])
		$numchapters = $myData['num_chapters'];
	else
		$numchapters = 1;
	
	// Etiqueta del botón
	if($_GET['action'] == 'addart')
		$buttext = 'Añadir';
	elseif($_GET['action'] == 'editart')
		$buttext = 'Editar';
	
	// Categorias
	$data = getCats('articles', $myGroupID);
	$cats = printCatTree($data, 0, 1, 'array');
	
	// Usuarios
	if(!$myData['userID'])
		$myData['userID'] == $_SESSION['userID'];
	
	// Números de la publicación seleccionada
	/*$data1 = getJours('',1);
	foreach($data1 as $numID => $values){
		$nums[$numID] = $values['num'].'. '.$values['title'];
		if($myData['numID'] == $numID)
			$nums_s[$numID]=1;
	}*/
	
	// Artículos
	$data2 = getArts();
	$articles[0] = 'Ninguno';
	foreach($data2 as $artID => $values){
		//$myJour = getJournal($values['jourID']);
		$articles[$artID] = $values['title'];
		if($myData['article_parent'] == $artID)
			$articles_s[$artID]=1;
	}
	
	// Formulario
	echo '<div class="form">'."\n";
	$form = new Form('articles');
	echo '<div style="text-align:right;">'."\n";
	echo 'Nº capítulos: ';
	echo printJump('', $numchapters, '', 'auto', 'numchapters', 'articles');
	echo '</div>'."\n";

	$form->printFieldset('Datos principales');
	//$form->addSelect('numID', 'Número de publicación', $nums, $nums_s);
	$form->addField('text', 'title', 'Título del artículo', $myData['title'], 50);
	$form->addTextarea('excerpt', 'Entradilla', $myData['excerpt'], '', 65, 4);
	
	// Un solo capítulo
	if($numchapters == 1){
		printTextToolbar();
		$form->addTextarea('body[]', 'Cuerpo', $myData['body'][0], '', 65, 12);
	}
	// Varios capítulos
	elseif($numchapters > 1 ){
		for($i=0;$i<$numchapters;$i++){
			$form->printFieldset('Capítulo '.intval($i+1));
			$form->addField('text', 'title_chapter[]', 'Título del capítulo '.intval($i+1), $myData['title_chapter'][$i], 50);
			printTextToolbar();
			$form->addTextarea('body[]', 'Cuerpo '.intval($i+1), $myData['body'][$i], '', 65, 12);
		}
	}
	
	$form->printFieldset('Datos generales');
	echo '<input type="checkbox" name="nl2br" id="nl2br" ';
	if($myData['nl2br']=='on')
		echo 'checked="checked"';
	echo ' class="formfield" />
		<label for="nl2br" class="text" >Convertir saltos de línea</label>
		<br />';
	//$form->addField('checkbox', 'nl2br', 'Convertir saltos de línea', $myData['nl2br']);
	$form->addField('text', 'date', 'Fecha', $myData['date_mod'], 20);
	
	$select .= '<label for="catID">Categorías</label><br />';
	$select .= printJump($cats, $myData['catID'], '%d', '', 'catID').'<br />';
	echo $select;
	
	$form->addField('text', 'article_level', 'Nivel de importancia', $myData['article_level'], 20);
	$form->addSelect('article_parent', 'Artículo padre', $articles, $articles_s);
	
	if($myData == '')
		$mySelect=1;
	else
		$mySelect[$myData['status']]=1;
	$myData['status_s'][0]='Visible';
	$myData['status_s'][1]='Invisible';	
	$form->addSelect('status', 'Estado', $myData['status_s'], $mySelect);
	
	$form->addField('text', 'imageID', 'Imagen', $myData['imageID'], 20);
	$select = '<label for="userID">Autor</label><br />';
	$select .= printJumpUsers('', $myData['userID']).'<br />';
	echo $select;
	$form->addField('submit', 'btn_art', $buttext, $buttext);
	$form->endForm();
	
	echo '</div>'."\n";
	
	return;
}



function getArt($myID){
	
	global $siteDB, $magID;

	$query = "SELECT * 
				FROM cms_articles, cms_art_chapters
				WHERE cms_articles.artID=$myID AND cms_art_chapters.artID=$myID";
			
	$result = $siteDB->query($query);
	
	$data = Array();
	while ($row = $siteDB->fetch_array($result, 1)){
		$data = $row;
		$j = $row['chapterID']-1;
		$dataaux['title_chapter'][$j] = $row['title_chapter'];
		$dataaux['body'][$j] = $row['body'];
	}
	
	$data['title_chapter']=Array();
	$data['body']=Array();
	
	for($i=0; $i<$data['num_chapters']; $i++){
		$data['title_chapter'][$i] = $dataaux['title_chapter'][$i];
		$data['body'][$i] = $dataaux['body'][$i];
	}
	
	$siteDB->free_result();
	return $data;
	
}

// Recoge menos informacion que la anterior
function getArtShort($myID){
	
	global $siteDB;

	$query = "SELECT a.*,c.body  
				FROM cms_articles AS a, cms_art_chapters AS c
				WHERE a.artID=$myID AND c.artID=$myID AND c.chapterID=1";
			
	$data = $siteDB->query_firstrow($query);
	
	$siteDB->free_result();
	return $data;

}

?>