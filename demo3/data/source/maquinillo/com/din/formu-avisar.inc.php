<?php

// Formulario de insercion de firmas pro-filosofia
// Conexión a la BD
require (ROOT_INC.'/fun/db_mysql.php');
require (ROOT_INC.'/fun/fun_forms.php');
$siteDB = new Db('localhost', 'boule_daniel', 'cola0bytes1tema', 'boule_foro');
require(ROOT_INC.'/dbconfig.php');

if(!$_POST['btnavisar']){
	header('Location: /filosofica/etica-ciudadano-siglo-xxi/');
}

elseif($_POST['btnavisar']){


		
	foreach($_POST as $key => $value)
		$_POST[$key]=strip_tags($value);

	$query="INSERT INTO avisar_ciudadania(email,time) VALUES ('".$_POST['email']."', UNIX_TIMESTAMP(NOW()))";
	$result = $siteDB->query($query);
	$siteDB->free_result();
	if(mail('boulesis@gmail.com','[avisar-ciudadania]',"Nuevo interesado\n\n".$_POST['email']."\n")){
		
		//mail('firmas@boulesis.com','[firmas]',"Se agregó nueva firma\n\n".$_POST['nombre']." ".$_POST['apellidos']." de ".$_POST['ciudad']." con ".$_POST['email']."\n\nCom: ".$_POST['deprada']."","From:".$_POST['nombre']." <".$_POST['email'].">");
		include($_SERVER['DOCUMENT_ROOT'].'/contacto/avisar-correcto.htm');
	}
	else{
		include($_SERVER['DOCUMENT_ROOT'].'/contacto/avisar-error.htm');
	}


}

?>