<?php
include ('../basic.php');
include (ROOT_AD_INC.'/head.inc.php');
include (ROOT_AD_INC.'/top.inc.php');

// Comienzo del contenedor
echo printContHead('Diario');

// Si no se ha pasado un identificador
if (!$_GET['jourid']){
	
if (!$_GET['action'] == 'addjour'){
	echo printError('No se puede ejecutar esa acción');
}
	
// Si es action=add
elseif($_GET['action'] == 'addjour'){
	
	// Mostrar formulario
	if(!$_POST['btn_jour']){
		printFormJournal();
	}
	
	// Añadir a la base de datos
	elseif($_POST['btn_jour']){
		
		$query="INSERT INTO cms_journals 
				 (title, description, path, url, journal_type, imageID, groupID, text, template) 
				VALUES ('$_POST[title]', '$_POST[description]', '$_POST[path]', '$_POST[url]', '$_POST[journal_type]', '$_POST[imageID]', '$_POST[groupID]', '$_POST[text]', '$_POST[template]')";
		$result = $siteDB->query($query);
		if($result){
			echo printMsg('Diario insertado con éxito');
			$siteDB->free_result();
		}
		else{
			printFormjour($_POST);
		}
	}
}

} // Fin !$_GET[id]

// Si se ha pasado un identificador
elseif($_GET['jourid']){

// Ver
if($_GET['action'] == 'viewjour'){

}

// Edición
elseif($_GET['action'] == 'editjour'){

	// Mostrar formulario
	if(!$_POST['btn_jour']){
		$jour = getJournal($_GET['jourid']);
		printFormJournal($jour);
	}
	
	// Ejecutar la edición
	if($_POST['btn_jour']){
	
		$query="UPDATE cms_journals 
				SET title='$_POST[title]', description='$_POST[description]', path='$_POST[path]', url='$_POST[url]', journal_type='$_POST[journal_type]', imageID='$_POST[imageID]', groupID='$_POST[groupID]', text='$_POST[text]', template='$_POST[template]' 
				WHERE jourID=$_GET[jourid]";
		$result = $siteDB->query($query);
		if($result){
			echo printMsg('Diario editado con éxito');
			$siteDB->free_result();		
		}
		else{
			echo printError('Se ha producido un error en la edición');
			printFormjour($_POST);
		}
	}

}

// Borrar
elseif($_GET['action'] == 'deletejour'){

	// Mostrar confirmacion
	if(!$_POST['btn_deljour']){
		echo printMsg('¿Seguro que quiere borrar el diario completo (y todas las entradas del mismo)?');
		printFormDel('journals');
	}
	
	// Ejecutar borrado
	elseif($_POST['btn_deljour']){
		$query="DELETE 
				FROM cms_journals 
				WHERE jourID='$_GET[jourid]'";
		$result = $siteDB->query($query);
		
		$jour = getJournal($_GET[jourid]);
		if ($jour[journal_type] == 0)
			$table = 'cms_news';
		elseif ($jour[journal_type] == 1)
			$table = 'cms_articles';
				
		$query2="DELETE 
				FROM $table 
				WHERE jourID='$_GET[jourid]'";
		$result2 = $siteDB->query($query2);
	
		if($result && $result2){
			echo printMsg('Diario eliminado con éxito');
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