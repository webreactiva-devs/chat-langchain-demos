<?php
include ('../basic.php');
include (ROOT_AD_INC.'/head.inc.php');
include (ROOT_AD_INC.'/top.inc.php');

// Comienzo del contenedor
echo printContHead('Enlace');

// Si no se ha pasado un identificador
if (!$_GET['linkid']){
	
if (!$_GET['action'] == 'addlink'){
	echo printError('No se puede ejecutar esa acción');
}
	
// Si es action=add
elseif($_GET['action'] == 'addlink'){
	
	// Mostrar formulario
	if(!$_POST['btn_link']){
		printFormLink();
	}
	
	// Añadir a la base de datos
	elseif($_POST['btn_link']){
	
		$date = convertDateL2U($_POST['date']);
		
		$query="INSERT INTO cms_links 
				 (title, description, url, catID, userID, status, date, imageID) 
				VALUES ('$_POST[title]', '$_POST[description]', '$_POST[url]', '$_POST[catID]', $_POST[userID], $_POST[status], $date, '$_POST[imageID]')";
		$result = $siteDB->query($query);
		if($result){
			echo printMsg('Enlace insertado con éxito');
			//saveLastInsert($siteDB->get_insert_id(), 'links');
			$siteDB->free_result();
			
		}
		else{
			printFormLink($_POST);
		}
	}
}

} // Fin !$_GET[id]

// Si se ha pasado un identificador
elseif($_GET['linkid']){

// Ver
if($_GET['action'] == 'viewlink'){

}

// Edición
elseif($_GET['action'] == 'editlink'){
	
	// Mostrar formulario
	if(!$_POST['btn_link']){
		$link = getLink($_GET['linkid']);
		printFormLink($link);
	}
	
	// Ejecutar la edición
	if($_POST['btn_link']){
	
		$date = convertDateL2U($_POST['date']);
	
		$query="UPDATE cms_links 
				SET title='$_POST[title]', description='$_POST[description]', url='$_POST[url]', catID='$_POST[catID]', status=$_POST[status], date=$date, imageID='$_POST[imageID]', userID=$_POST[userID] 
				WHERE linkID=$_GET[linkid]";
		$result = $siteDB->query($query);
		if($result){
			echo printMsg('Enlace editado con éxito');
			$siteDB->free_result();		
		}
		else{
			echo printError('Se ha producido un error en la edición');
			printFormLink($_POST);
		}
	}

}

// Borrar
elseif($_GET['action'] == 'deletelink'){

	// Mostrar confirmacion
	if(!$_POST['btn_dellink']){
		echo printMsg('¿Seguro que quiere borrar el enlace?');
		printFormDel('links');
	}
	
	// Ejecutar borrado
	elseif($_POST['btn_dellink']){
		$query="DELETE 
				FROM cms_links 
				WHERE linkID='$_GET[linkid]'";
		$result = $siteDB->query($query);
			
		if($result){
			//delLastInsert($_GET[linkid], 'links');
			echo printMsg('Enlace eliminado con éxito');
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