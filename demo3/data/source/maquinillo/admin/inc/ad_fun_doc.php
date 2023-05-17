<?php
// Funciones de documentos

// Devuelve los datos de los documentos
function getDocs($myMode='all', $myCatID = '', $myDate = '', $myLimit = ''){
	
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
				FROM cms_documents  
				WHERE 1>0 "
				.$queryX.
				" ORDER BY title ";
	// echo $query;		
	$result = $siteDB->query($query);
	
	while ($row = $siteDB->fetch_array($result, 1)){
		$data[$row['docID']] = $row;
	}
	
	$numItems = $siteDB->get_numrows();
	$siteDB->free_result();
	return $data;

}

// Devuelve datos sobre un documento
function getDoc($myID){
	
	global $siteDB;

	$query = "SELECT * 
				FROM cms_documents  
				WHERE docID=$myID ";
			
	$data = $siteDB->query_firstrow($query);
	
	$siteDB->free_result();
	return $data;

}

// Comrpueba la existencia del documento
function checkDoc($j){

	// Comprobación de variables globales
	if (!$_POST)
		return false;

	$fileName = $_FILES['document']['name'][$j];
	$pathTemp = ROOT_PATH.DOC_BASE.'/temp';
	$docPath = ROOT_PATH.DOC_BASE;
	if($_POST['dir'][$j] != ''){
		$newDir = addslashes($_POST['dir'][$j]);
		$docPath .= '/'.$newDir;
		// Si no existe el directorio lo crea
		$create = createDir('/'.$newDir, 0666, DOC_BASE);
		}	
	
	if(file_exists($docPath.'/'.$fileName)){
		printError('El documento ya existe');
		return false;
		}	
		
	return true;
	
}

// Sube el documento
function uploadDoc($j){

	// Comprobación de variables globales
	if (!$_POST)
		return false;
		
	$fileName = $_FILES['document']['name'][$j];
	$pathTemp = ROOT_PATH.DOC_BASE.'/temp';
	$docPath = ROOT_PATH.DOC_BASE;
	if($_POST['dir'][$j] != ''){
		$newDir = addslashes($_POST['dir'][$j]);
		$docPath .= '/'.$newDir;
	}
	$oldumask = umask(0);
	copy($_FILES['document']['tmp_name'][$j], $docPath.'/'.$fileName);
	umask($oldumask);
	//unlink($pathTemp.'/'.$fileName);
	
	$destDir = str_replace(ROOT_PATH, '', $docPath);
	// Devuelve la ruta del archivo subido
	return 'http://'.HOST.$destDir.'/'.$fileName;
}

// Muestra el formulario del documento
function printFormDoc ($myData = ''){

	global $catTree;
	
	$myData['groupID'] = 101;
	
	// Número de archivos
	if($_POST['numfiles'])
		$numfiles = $_POST['numfiles'];
	elseif($myData['num_files'])
		$numfiles = $myData['num_files'];
	else
		$numfiles = 1;

	// Fecha
	for($i=0;$i<$numfiles;$i++){	
		if(!isset($myData['date'][$i]))
			$myData['date'][$i]=convertDateU2L(date("U"));
		elseif(isset($myData['date']) && !is_array($myData['date']))
			$myData['date']=convertDateU2L($myData['date']);
	}
			
		
	// Etiqueta del botón
	if($_GET['action'] == 'adddoc')
		$buttext = 'Añadir';
	elseif($_GET['action'] == 'editdoc')
		$buttext = 'Editar';
		
	// Categorias
	$data = getCats('docs', $myData['groupID']);
	$cats = printCatTree($data, 0, 1, 'array');		
	
	echo '<div class="form">'."\n";
	$form = new Form('docs','','','multipart/form-data');
	
	if($_GET['action'] == 'adddoc'){
		echo '<div style="text-align:right;">'."\n";
		echo 'Nº de documentos: ';
		echo printJump('', $numfiles, '', 'auto', 'numfiles', 'docs');
		echo '</div>'."\n";
		//$form->printFieldset('Tamaños');
		//$form->addField('text', 'imageMX', 'Ancho imagen máximo', $imageMX, 10);
	
		for($i=0;$i<$numfiles;$i++){
			$form->printFieldset('Documento '.intval($i+1));
			$form->addField('text', 'title[]', 'Título', $myData['title'][$i], 50);
			$form->addTextarea('description[]', 'Descripción', $myData['description'][$i], '', 65, 3);
			echo '<span>Puede subir el archivo o incluirlo desde fuera a través de la URL</span><br />';
			$form->addField('file', 'document[]', 'Archivo', $myData['file'][$i], 50);
			$form->addField('text', 'dir[]', 'Carpeta (si sube archivo) (sin \'/\')', $myData['dir'][$i], 50);	
			$form->addField('text', 'url[]', 'URL archivo', $myData['url'][$i], 50);			
			$form->addField('text', 'related_link[]', 'Enlace relacionado', $myData['related_link'][$i], 50);				
			$form->addField('text', 'date[]', 'Fecha', $myData['date'][$i], 20);
			
			$select = '<label for="catID[]">Categorías</label><br />';
			$select .= printJump($cats, $myData['catID'][$i], '%d', '', 'catID[]').'<br />';
			echo $select;	

			if($myData == '')
				$mySelect[$i][0]=1;
			else{
				$aux = $myData['status'][$i];
				$mySelect[$i][$aux]=1;
				}
			$myData['status_s'][0]='Visible';
			$myData['status_s'][1]='Invisible';	
			$form->addSelect('status[]', 'Estado', $myData['status_s'], $mySelect[$i]);
			$form->addField('text', 'imageID[]', 'Imagen', $myData['imageID'][$i], 20);
			
			// Usuarios
			if(!$myData['userID'][$i])
				$myData['userID'][$i] == $_SESSION['userID'];
			
			$select = '<label for="userID[]">Autor</label><br />';
			$select .= printJumpUsers('', $myData['userID'][$i], 'userID[]').'<br />';
			echo $select;
		}
	}
	
	elseif($_GET['action'] == 'editdoc'){
		$form->addField('text', 'title', 'Título', $myData['title'], 50);
		$form->addTextarea('description', 'Descripción', $myData['description'], '', 65, 3);
		$form->addField('text', 'url', 'URL archivo', $myData['url'], 50);	
		$form->addField('text', 'related_link', 'Enlace relacionado', $myData['related_link'], 50);		
		$form->addField('text', 'date', 'Fecha', $myData['date'], 20);
		
		$select .= '<label for="catID[]">Categorías</label><br />';
		$select .= printJump($cats, $myData['catID'], '%d', '', 'catID').'<br />';
		echo $select;	

		if($myData == '')
			$mySelect[$i][0]=1;
		else{
			$aux = $myData['status'][$i];
			$mySelect[$i][$aux]=1;
			}
		$myData['status_s'][0]='Visible';
		$myData['status_s'][1]='Invisible';	
		$form->addSelect('status', 'Estado', $myData['status_s'], $mySelect[$i]);
		$form->addField('text', 'imageID', 'Imagen', $myData['imageID'], 20);
					
		$select = '<label for="userID[]">Autor</label><br />';
		$select .= printJumpUsers('', $myData['userID']).'<br />';
		echo $select;		
	}
	

	$form->addField('submit', 'btn_doc', $buttext, $buttext);
	$form->endForm();
	
	echo '</div>'."\n";

	return;
}


?>