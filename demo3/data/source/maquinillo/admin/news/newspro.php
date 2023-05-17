<?php
include ('../basic.php');
include (ROOT_AD_INC.'/head.inc.php');
include (ROOT_AD_INC.'/top.inc.php');

// Nombre del diario
$jour = getJournal($_GET['jourid']);

// Comienzo del contenedor
echo printContHead('Noticias del diario<span>'.$jour['title'].'</span>');

// Si no se ha pasado un identificador
if (!$_GET['entryid']){
	
if (!$_GET['action'] == 'addentry'){
	echo printError('No se puede ejecutar esa acción');
}
	
// Si es action=add
elseif($_GET['action'] == 'addentry'){

	// Mostrar formulario
	if(!$_POST['btn_entry']){
		printFormEntry($_POST);
	}
	
	// Añadir a la base de datos
	elseif($_POST['btn_entry']){
		
		// Transformaciones previas
		$date = convertDateL2U($_POST['date']);
		$excerpt = chop($_POST[excerpt]);
		$body = chop($_POST[body]);
		// Datos del artículo
		$query="INSERT INTO cms_news 
				 (jourID, catID, title, excerpt, body, date, date_mod, userID, status, nl2br, imageID) 
				VALUES ('$_GET[jourid]', '$_POST[catID]', '$_POST[title]', '$excerpt', '$body', $date, $date, $_POST[userID], $_POST[status], '$_POST[nl2br]', '$_POST[imageID]')";
		$result = $siteDB->query($query);
		$lastID = $siteDB->get_insert_id();
		$siteDB->free_result();
		
		if($result){
			saveLastInsert($lastID, 'news', $date, $_GET[jourid], $_POST[status]);
			echo printMsg('Entrada insertada con éxito');
			}
		else{
			echo printMsg('Se ha producido un error');
			printFormEntry($_POST);
		}
	}
}

} // Fin !$_GET[id]

// Si se ha pasado un identificador
elseif($_GET['entryid']){

// Ver
if($_GET['action'] == 'viewentry'){

}

// Edición
elseif($_GET['action'] == 'editentry'){

	// Mostrar formulario
	if(!$_POST['btn_entry']){
		$entry = getEntry($_GET['entryid']);
		$entry['date_mod']=convertDateU2L($entry['date_mod']);
		printFormEntry($entry);
	}
	
	// Ejecutar la edición
	if($_POST['btn_entry']){

		// Transformaciones previas
		$date = convertDateL2U($_POST['date']);
		$excerpt = chop($_POST[excerpt]);
		$body = chop($_POST[body]);
	
		$query="UPDATE cms_news  
				SET catID=$_POST[catID], title='$_POST[title]', excerpt='$excerpt', body='$body',date_mod=$date, status=$_POST[status], nl2br='$_POST[nl2br]', imageID=$_POST[imageID], userID=$_POST[userID]    
				WHERE entryID=$_GET[entryid]";
		$result = $siteDB->query($query);
		$siteDB->free_result();
		
		if($result){
			updateLastInsert($_GET[entryid], 'news', $date, $_GET[jourid], $_POST[status]);
			echo printMsg('Entrada editada con éxito');
			}
		else{
			echo printMsg('Se ha producido un error');
			printFormEntry($_POST);
		}
	}

}

// Borrar
elseif($_GET['action'] == 'deleteentry'){

	// Mostrar confirmacion
	if(!$_POST['btn_delentry']){
		echo printMsg('¿Seguro que quiere borrar el artículo completo?');
		printFormDel('news');
	}
	
	// Ejecutar borrado
	elseif($_POST['btn_delentry']){
		$query="DELETE 
				FROM cms_news 
				WHERE entryID='$_GET[entryid]'";
		$result = $siteDB->query($query);
		
		if($result){
			delLastInsert($_GET[entryid], 'news');
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