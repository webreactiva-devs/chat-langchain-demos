<?php
include ('../basic.php');
include (ROOT_AD_INC.'/head.inc.php');
include (ROOT_AD_INC.'/top.inc.php');

// Nombre del diario
$static = getStatic($_GET['staticid']);

// Comienzo del contenedor
echo printContHead('Páginas del estático<span>'.$jour['title'].'</span>');

// Si no se ha pasado un identificador
if (!$_GET['staticpageid']){
	
if (!$_GET['action'] == 'addstaticpage'){
	echo printError('No se puede ejecutar esa acción');
}
	
// Si es action=add
elseif($_GET['action'] == 'addstaticpage'){

	// Mostrar formulario
	if(!$_POST['btn_staticpage']){
		printFormStaticpage($_POST, $static['groupID']);
	}
	
	// Añadir a la base de datos
	elseif($_POST['btn_staticpage']){
		
		// Transformaciones previas
		$date = convertDateL2U($_POST['date']);
		$description = chop($_POST[description]);
		// Datos del artículo
		$query="INSERT INTO cms_staticpages 
				 (staticID, catID, title, description, url, date, date_mod, userID, status, imageID) 
				VALUES ('$_GET[staticid]', '$_POST[catID]', '$_POST[title]', '$description', '$_POST[url]', $date, $date, $_POST[userID], $_POST[status], '$_POST[imageID]')";
		$result = $siteDB->query($query);
		$lastID = $siteDB->get_insert_id();
		$siteDB->free_result();
		
		if($result){
			saveLastInsert($lastID, 'staticpages', $date, $_GET[staticid], $_POST[status]);
			echo printMsg('Entrada insertada con éxito');
			}
		else{
			echo printMsg('Se ha producido un error');
			printFormStaticpage($_POST);
		}
	}
}

} // Fin !$_GET[id]

// Si se ha pasado un identificador
elseif($_GET['staticpageid']){

// Ver
if($_GET['action'] == 'viewstaticpage'){

}

// Edición
elseif($_GET['action'] == 'editstaticpage'){

	// Mostrar formulario
	if(!$_POST['btn_staticpage']){
		$staticpage = getStaticpage($_GET['staticpageid']);
		$staticpage['date_mod']=convertDateU2L($staticpage['date_mod']);
		printFormStaticpage($staticpage, $static['groupID']);
	}
	
	// Ejecutar la edición
	if($_POST['btn_staticpage']){

		// Transformaciones previas
		$date = convertDateL2U($_POST['date']);
		$description = chop($_POST['description']);
	
		$query="UPDATE cms_staticpages  
				SET catID=$_POST[catID], title='$_POST[title]', description='$description', url='$_POST[url]', date_mod=$date, status=$_POST[status], imageID=$_POST[imageID], userID=$_POST[userID]    
				WHERE staticpageID=$_GET[staticpageid]";
		$result = $siteDB->query($query);
		$siteDB->free_result();
		
		if($result){
			updateLastInsert($_GET[staticpageid], 'staticpages', $date, $_GET[staticid], $_POST[status]);
			echo printMsg('Entrada editada con éxito');
			}
		else{
			echo printMsg('Se ha producido un error');
			printFormstaticpage($_POST);
		}
	}

}

// Borrar
elseif($_GET['action'] == 'deletestaticpage'){

	// Mostrar confirmacion
	if(!$_POST['btn_delstaticpage']){
		echo printMsg('¿Seguro que quiere borrar la página estática de la base de datos?');
		printFormDel('staticpages');
	}
	
	// Ejecutar borrado
	elseif($_POST['btn_delstaticpage']){
		$query="DELETE 
				FROM cms_staticpages 
				WHERE staticpageID='$_GET[staticpageid]'";
		$result = $siteDB->query($query);
		
		if($result){
			delLastInsert($_GET[staticpageid], 'staticpages');
			echo printMsg('Entrada eliminada con éxito');
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