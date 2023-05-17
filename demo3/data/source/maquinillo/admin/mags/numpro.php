<?php
include ('../basic.php');
include (ROOT_AD_INC.'/head.inc.php');
include (ROOT_AD_INC.'/top.inc.php');

// Provisional. Variable definida por formulario
$magID=1;

// Comienzo del contenedor
echo printContHead('N�meros de la publicaci�n');

// Si no se ha pasado un identificador
if (!$_GET['numid']){
	
if (!$_GET['action'] == 'addnum'){
	echo printError('No se puede ejecutar esa acci�n');
}
	
// Si es action=add
elseif($_GET['action'] == 'addnum'){
	
	// Mostrar formulario
	if(!$_POST['btn_num']){
		printFormNum();
	}
	
	// A�adir a la base de datos
	elseif($_POST['btn_num']){
		
		$query="INSERT INTO mag_nums 
				 (magID, num, title, description, issue, mag_tmpl, albumID) 
				VALUES ($magID, '$_POST[num]', '$_POST[title]', '$_POST[description]', '$_POST[issue]', '$_POST[mag_tmpl]', '$_POST[albumID]')";
		$result = $siteDB->query($query);
		if($result){
			echo printMsg('N�mero insertado con �xito');
			$siteDB->free_result();
		}
		else{
			printFormNum($_POST);
		}
	}
}

} // Fin !$_GET[id]

// Si se ha pasado un identificador
elseif($_GET['numid']){

// Ver
if($_GET['action'] == 'viewnum'){

}

// Edici�n
elseif($_GET['action'] == 'editnum'){

	// Mostrar formulario
	if(!$_POST['btn_num']){
		$num = getNum($_GET['numid']);
		printFormNum($num);
	}
	
	// Ejecutar la edici�n
	if($_POST['btn_num']){
	
		$query="UPDATE mag_nums 
				SET num=$_POST[num], title='$_POST[title]', description='$_POST[description]', issue='$_POST[issue]', mag_tmpl='$_POST[mag_tmpl]', albumID='$_POST[albumID]' 
				WHERE numID=$_GET[numid]";
		$result = $siteDB->query($query);
		if($result){
			echo printMsg('N�mero editado con �xito');
			$siteDB->free_result();		
		}
		else{
			echo printError('Se ha producido un error en la edici�n');
			printFormNum($_POST);
		}
	}

}

// Borrar
elseif($_GET['action'] == 'deletenum'){

	// Mostrar confirmacion
	if(!$_POST['btn_delnum']){
		echo printMsg('�Seguro que quiere borrar el n�mero completo?');
		printFormDel('nums');
	}
	
	// Ejecutar borrado
	elseif($_POST['btn_delnum']){
		$query="DELETE 
				FROM mag_nums 
				WHERE numID='$_GET[numid]'";
		$result = $siteDB->query($query);
		if($result){
			echo printMsg('N�mero eliminado con �xito');
			$siteDB->free_result();		
		}
		else{
			echo printError('Se ha producido un error en la eliminaci�n');
		}	
	}

}

} // Fin $_GET[id]

echo printContFoot();


include (ROOT_AD_INC.'/foot.inc.php');
?>