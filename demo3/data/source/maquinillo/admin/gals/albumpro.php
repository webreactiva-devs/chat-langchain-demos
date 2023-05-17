<?php
include ('../basic.php');
include (ROOT_AD_INC.'/head.inc.php');
include (ROOT_AD_INC.'/top.inc.php');

// Los albums no estan dentro de un grupo
// Pertenecen a una categoria

// Comienzo del contenedor
echo printContHead('Álbum de fotografías');

// Si no se ha pasado un identificador
if (!$_GET['albumid']){
	
if (!$_GET['action'] == 'addalbum'){
	echo printError('No se puede ejecutar esa acción');
}
	
// Si es action=add
elseif($_GET['action'] == 'addalbum'){
	
	// Mostrar formulario
	if(!$_POST['btn_album']){
		printFormAlbum();
	}
	
	// Añadir a la base de datos
	elseif($_POST['btn_album']){
	
		// Transformaciones previas
		$date = convertDateL2U($_POST['date']);
		
		// Insertamos el registro en la BD
		$query="INSERT INTO cms_albums 
				 (title, description, catID, date, userID, imageID) 
				VALUES ('$_POST[title]', '$_POST[description]', '$_POST[catID]', $date, $_POST[userID], '$_POST[imageID]')";
		$result = $siteDB->query($query);
		
		// Creamos el directorio del album
		$albumID = $siteDB->get_insert_id();
		$create[] = createDir('/'.$albumID, 0777, IMAGE_BASE);
		$create[] = createDir('/'.$albumID, 0777, THUMB_BASE);
		
		if($result && $create[0] && $create[1]){
			echo printMsg('Álbum insertado con éxito');
			$siteDB->free_result();
		}
		else{
			echo printMsg('Se ha producido un error');
			printFormAlbum($_POST);
		}
	}
}

} // Fin !$_GET[id]

// Si se ha pasado un identificador
elseif($_GET['albumid']){

// Ver
if($_GET['action'] == 'viewalbum'){

}

// Edición
elseif($_GET['action'] == 'editalbum'){

	// Mostrar formulario
	if(!$_POST['btn_album']){
		$album = getAlbum($_GET['albumid']);
		printFormAlbum($album);
	}
	
	// Ejecutar la edición
	if($_POST['btn_album']){
	
		// Transformaciones previas
		$date = convertDateL2U($_POST['date']);
	
		$query="UPDATE cms_albums 
				SET title='$_POST[title]', description='$_POST[description]', catID='$_POST[catID]', imageID='$_POST[imageID]', date=$date, userID=$_POST[userID]  
				WHERE albumID=$_GET[albumid]";
		$result = $siteDB->query($query);
		if($result){
			echo printMsg('Álbum editado con éxito');
			$siteDB->free_result();		
		}
		else{
			echo printError('Se ha producido un error en la edición');
			printFormAlbum($_POST);
		}
	}

}

// Borrar
elseif($_GET['action'] == 'deletealbum'){

	// Mostrar confirmacion
	if(!$_POST['btn_delalbum']){
		echo printMsg('¿Seguro que quiere borrar el álbum completo (y todas las fotografías de la base de datos del mismo)?');
		printFormDel('albums');
	}
	
	// Ejecutar borrado
	elseif($_POST['btn_delalbum']){
		$query="DELETE 
				FROM cms_albums 
				WHERE albumID='$_GET[albumid]'";
		$result = $siteDB->query($query);
		
		$album = getAlbum($_GET['albumid']);
		$table = 'cms_images';
				
		$query2="DELETE 
				FROM $table 
				WHERE albumID='$_GET[albumid]'";
		$result2 = $siteDB->query($query2);
	
		if($result && $result2){
			echo printMsg('Álbum (y fotografías) eliminado/s con éxito (solo de la base de datos)');
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