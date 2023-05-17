<?php
include ('../basic.php');
include (ROOT_AD_INC.'/head.inc.php');
include (ROOT_AD_INC.'/top.inc.php');

// Comienzo del contenedor
echo printContHead('Documento');

// Si no se ha pasado un identificador
if (!$_GET['docid']){
	
if (!$_GET['action'] == 'adddoc'){
	echo printError('No se puede ejecutar esa acción');
}
	
// Si es action=add
elseif($_GET['action'] == 'adddoc'){
	
	// Mostrar formulario
	if(!$_POST['btn_doc']){
		printFormDoc();
	}
	
	// Añadir a la base de datos
	elseif($_POST['btn_doc']){
	
		// Datos de los documentos
		for($i=0;$i<$_POST['numfiles'];$i++){ 	
			$j = $i+1;
			
			// Si pasamos la URL del documento no subimos nada
			if($_POST['url'][$i]!=''){
				$docDir = AddSlashes($_POST['url'][$i]);
			}
			
			// Si no pasamos URL subimos el documento
			else{
				// Comprobamos el directorio y la existencia del archivo
				if(checkDoc($i) == true){
					$docDir = uploadDoc($i);
				}
			}
			
			$title = $_POST['title'][$i];
			$desc = printText($_POST['description'][$i], 1);
			$date = convertDateL2U($_POST['date'][$i]);
			$catID = $_POST['catID'][$i];
			$imageID = $_POST['imageID'][$i];
			$status = $_POST['status'][$i];
			$related_link = $_POST['related_link'][$i];
			$userID = $_POST['userID'][$i];
			
			$query="INSERT INTO cms_documents 
					(title, description, url, catID, userID, status, date, related_link, imageID) 
					VALUES ('$title', '$desc', '$docDir', $catID, $userID, $status, $date, '$related_link', '$imageID')";
			$result[$j] = $siteDB->query($query);
			$id = $siteDB->get_insert_id();
			if($result[$j])
				saveLastInsert($id, 'documents', $date, '', $status);
			$siteDB->free_result();
		
		}
		foreach($result as $value){
			if(!$value){
				$setErrorDB = 1;
				break;
			}
			else
				$setErrorDB = 0;
		}
		
		if($setErrorDB == 0){
			echo printMsg('Documento insertado con éxito');
			}
		else{
			echo printMsg('Se ha producido un error');
			printFormDoc($_POST);
		}	
	

	}
}

} // Fin !$_GET[id]

// Si se ha pasado un identificador
elseif($_GET['docid']){

// Ver
if($_GET['action'] == 'viewdoc'){

}

// Edición
elseif($_GET['action'] == 'editdoc'){
	
	// Mostrar formulario
	if(!$_POST['btn_doc']){
		$doc = getDoc($_GET['docid']);
		printFormDoc($doc);
	}
	
	// Ejecutar la edición
	if($_POST['btn_doc']){
		
		$date = convertDateL2U($_POST['date']);
		$status = $_POST['status'];
	
		$query="UPDATE cms_documents  
				SET title='$_POST[title]', description='$_POST[description]', url='$_POST[url]', catID='$_POST[catID]', status=$_POST[status], date=$date, related_link='$_POST[related_link]', imageID='$_POST[imageID]', userID=$_POST[userID]   
				WHERE docid=$_GET[docid]";
		$result = $siteDB->query($query);
		if($result){
			updateLastInsert($_GET[docid], 'documents', $date, '', $status);
			echo printMsg('Documento editado con éxito');
			$siteDB->free_result();		
		}
		else{
			echo printError('Se ha producido un error en la edición');
			printFormDoc($_POST);
		}
	}

}

// Borrar
elseif($_GET['action'] == 'deletedoc'){

	// Mostrar confirmacion
	if(!$_POST['btn_deldoc']){
		echo printMsg('¿Seguro que quiere borrar el documento?');
		printFormDel('docs');
	}
	
	// Ejecutar borrado
	elseif($_POST['btn_deldoc']){
		$query="DELETE 
				FROM cms_documents 
				WHERE docid='$_GET[docid]'";
		$result = $siteDB->query($query);
			
		if($result){
			delLastInsert($_GET[docid], 'documents');
			echo printMsg('Documento eliminado con éxito. No se ha eliminado del servidor.');
			$siteDB->free_result();		
		}
		else{
			echo printError('Se ha producido un error en la eliminación');
		}	
	}

}

} // Fin $_GET[id]

echo printContFoot();


include (ROOT_AD_INC.'/foot.inc.php');
?>