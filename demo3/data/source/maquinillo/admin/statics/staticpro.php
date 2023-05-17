<?php
include ('../basic.php');
include (ROOT_AD_INC.'/head.inc.php');
include (ROOT_AD_INC.'/top.inc.php');

// Comienzo del contenedor
echo printContHead('Sección de estático');

// Si no se ha pasado un identificador
if (!$_GET['staticid']){
	
if (!$_GET['action'] == 'addstatic'){
	echo printError('No se puede ejecutar esa acción');
}
	
// Si es action=add
elseif($_GET['action'] == 'addstatic'){
	
	// Mostrar formulario
	if(!$_POST['btn_static']){
		printFormStatic();
	}
	
	// Añadir a la base de datos
	elseif($_POST['btn_static']){
		
		$query="INSERT INTO cms_statics 
				 (title, description, path, static_type, imageID, groupID, text) 
				VALUES ('$_POST[title]', '$_POST[description]', '$_POST[path]', '$_POST[static_type]', '$_POST[imageID]', '$_POST[groupID]', '$_POST[text]')";
		$result = $siteDB->query($query);
		if($result){
			echo printMsg('Estático insertado con éxito');
			$siteDB->free_result();
		}
		else{
			printFormStatic($_POST);
		}
	}
}

} // Fin !$_GET[id]

// Si se ha pasado un identificador
elseif($_GET['staticid']){

// Ver
if($_GET['action'] == 'viewstatic'){

}

// Edición
elseif($_GET['action'] == 'editstatic'){

	// Mostrar formulario
	if(!$_POST['btn_static']){
		$static = getStatic($_GET['staticid']);
		printFormStatic($static);
	}
	
	// Ejecutar la edición
	if($_POST['btn_static']){
	
		$query="UPDATE cms_statics 
				SET title='$_POST[title]', description='$_POST[description]', path='$_POST[path]', static_type='$_POST[staticnal_type]', imageID='$_POST[imageID]', groupID='$_POST[groupID]', text='$_POST[text]'  
				WHERE staticID=$_GET[staticid]";
		$result = $siteDB->query($query);
		if($result){
			echo printMsg('Sección de estáticas editada con éxito');
			$siteDB->free_result();		
		}
		else{
			echo printError('Se ha producido un error en la edición');
			printFormStatic($_POST);
		}
	}

}

// Borrar
elseif($_GET['action'] == 'deletestatic'){

	// Mostrar confirmacion
	if(!$_POST['btn_delstatic']){
		echo printMsg('¿Seguro que quiere borrar la sección de estáticas (y todas las entradas del mismo)?');
		printFormDel('statics');
	}
	
	// Ejecutar borrado
	elseif($_POST['btn_delstatic']){
		$query="DELETE 
				FROM cms_statics 
				WHERE staticID='$_GET[staticid]'";
		$result = $siteDB->query($query);
		
		$static = getStatic($_GET[staticid]);
		if ($static[static_type] == 0)
			$table = 'cms_staticpages';
		elseif ($static[static_type] == 1)
			$table = 'cms_staticpages';
				
		$query2="DELETE 
				FROM $table 
				WHERE staticID='$_GET[staticid]'";
		$result2 = $siteDB->query($query2);
	
		if($result && $result2){
			echo printMsg('Sección de estáticas eliminada con éxito');
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