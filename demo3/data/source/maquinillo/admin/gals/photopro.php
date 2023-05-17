<?php
include ('../basic.php');
include (ROOT_AD_INC.'/head.inc.php');
include (ROOT_AD_INC.'/top.inc.php');
include (ROOT_PATH.'/com/fun/thumbnail.php');

// Comienzo del contenedor
echo printContHead('Fotografía del álbum');

// Datos globales del magazine
$album = getAlbum ($_GET['albumid']);

// Si no se ha pasado un identificador
if (!$_GET['photoid']){
	
if (!$_GET['action'] == 'addphoto'){
	echo printError('No se puede ejecutar esa acción');
}
	
// Si es action=add
elseif($_GET['action'] == 'addphoto'){

	// Mostrar formulario
	if(!$_POST['btn_photo']){
		printFormPhoto($_POST);
	}
	
	// Añadir a la base de datos
	elseif($_POST['btn_photo']){
		
		// Datos de las imagenes
		for($i=0;$i<$_POST['numfiles'];$i++){ 	
			$j = $i+1;
			
			// Modificaciones a realizar en la imagen
			uploadImage($i, $imageMX, $imageMY, $thumbMX, $thumbMY);

			$title = $_POST['title'][$i];
			$desc = printText($_POST['description'][$i], 1);
			$date = convertDateL2U($_POST['date'][$i]);
			
			if (empty($_POST['path_image'][$i]))
				$path = IMAGE_BASE . '/' . $_POST['albumid'] . '/' . $_FILES['image']['name'][$i];
			if (empty($_POST['path_thumb'][$i]))
				$path2 = THUMB_BASE . '/' . $_POST['albumid'] . '/' . $_FILES['image']['name'][$i];
			
			$status = $_POST[status][$i];
			$userID = $_POST['userID'][$i];
			
			$query="INSERT INTO cms_images 
					(albumID, title, description, date, path_image, path_thumb, userID, status) 
					VALUES ($_GET[albumid], '$title', '$desc', $date, '$path', '$path2', $userID, $status)";
			$result[$j] = $siteDB->query($query);
			$id = $siteDB->get_insert_id();
			$siteDB->free_result();
			
			if($_POST['coverimage'][$i]=='on')
				setCoverImage($id, $_GET[albumid]);
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
			saveLastInsert($id, 'photos', $date);
			echo printMsg('Fotografía insertada con éxito');
			}
		else{
			echo printMsg('Se ha producido un error');
			printFormPhoto($_POST);
		}
	}
}

} // Fin !$_GET[id]

// Si se ha pasado un identificador
elseif($_GET['photoid']){

// Ver
if($_GET['action'] == 'viewphoto'){

}

// Edición
elseif($_GET['action'] == 'editphoto'){

	// Mostrar formulario
	if(!$_POST['btn_photo']){
		$photo = getPhoto($_GET['photoid']);
		$photo['date']=convertDateU2L($photo['date']);
		printFormPhoto($photo);
	}
	
	// Ejecutar la edición
	if($_POST['btn_photo']){

		$title = $_POST['title'];
		$desc = $_POST['description'];
		$date = convertDateL2U($_POST['date']);
		$path = $_POST['path_image'];
		$path2 = $_POST['thumb_image'];
		$status = $_POST['status'];
		$query="UPDATE cms_images 
				SET title='$title', description='$desc', date=$date, path_image='$path', path_thumb='$path2', userID=$_POST[userID], status=$status    
				WHERE imageID=$_GET[photoid] ";
		$result = $siteDB->query($query);
		$siteDB->free_result();
		
		if($result){
			updateLastInsert($_GET[photoid], 'photos', $date);
			echo printMsg('Foto editada con éxito');
		}
		else{
			echo printError('Se ha producido un error en la edición');
			printFormAlbum($_POST);
		}
	}

}

// Borrar
elseif($_GET['action'] == 'deletephoto'){

	// Mostrar confirmacion
	if(!$_POST['btn_delphoto']){
		echo printMsg('¿Seguro que quiere borrar la fotografía de la base de datos?');
		printFormDel('photos');
	}
	
	// Ejecutar borrado
	elseif($_POST['btn_delphoto']){
		$query="DELETE 
				FROM cms_images 
				WHERE imageID='$_GET[photoid]'";
		$result = $siteDB->query($query);
		
		if($result){
			delLastInsert($_GET[photoid], 'photos');
			echo printMsg('Fotografía eliminado con éxito');
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