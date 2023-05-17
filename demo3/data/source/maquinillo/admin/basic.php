<?php
// Archivo básico que se utiliza en todas las páginas

require('config.php');

// Iniciamos la conexion a la base de datos
include(ROOT_PATH.'/com/fun/db_mysql.php');
$siteDB = new Db($dbServer, $dbUser, $dbPass, $dbDataBase);


// Chequea la validez del usuario que esta utilizando el sistema
session_start(); 
if (!session_is_registered("userID") && !session_is_registered("password")) {
	header("Location: ".DIR_ADMIN);
}
else {
	$userInfo = $siteDB->query_firstrow("SELECT password FROM cms_users WHERE userID = '$_SESSION[userID]'");
	if ($userInfo['password'] != $_SESSION[password]) {
		session_destroy();
		header("Location: ".DIR_ADMIN);
	}
}

// Clase para formularios
include(ROOT_PATH.'/com/fun/forms.php');

include_once(ROOT_PATH.'/com/fun/templates.php');

// Funciones de administracion
include(ROOT_AD_INC.'/ad_fun.php');
include(ROOT_AD_INC.'/ad_fun_users.php');
include(ROOT_AD_INC.'/ad_fun_mags.php');
include(ROOT_AD_INC.'/ad_fun_news.php');
include(ROOT_AD_INC.'/ad_fun_gal.php');
include(ROOT_AD_INC.'/ad_fun_links.php');
include(ROOT_AD_INC.'/ad_fun_doc.php');
include(ROOT_AD_INC.'/ad_fun_statics.php');

// Menú navegacion horizontal
foreach ($siteNav as $key => $value){
	
	if(!is_array($value)){
		$htmlMenu.='<li><a href="'.DIR_ADMIN.$value.'">'.ucfirst($key).'</a></li>'."\n";
	}
	else{
		$htmlMenu.='<li><a href="'.DIR_ADMIN.$value[0].'">'.ucfirst($key).'</a></li>'."\n";
		if(DIR_ADMIN.$value[0]==$myLocation){
			foreach ($value as $key2 => $value2){
				if ($key2!='0')
					$htmlMenu2.='<li><a href="'.DIR_ADMIN.$value2.'">'.ucfirst($key2).'</a></li>'."\n";
			}
		}
	
	}
}



?>