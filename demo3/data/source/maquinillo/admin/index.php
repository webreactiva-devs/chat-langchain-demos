<?php
require('config.php');

function checkUser($myUser, $myPass){
	global $userInfo, $siteDB;

	$userInfo = $siteDB->query_firstrow("SELECT * FROM cms_users WHERE username = '$_POST[username]'");

	if($myPass!=$userInfo['password'] || !$myPass || $myPass=='')
		return false;
	else
		return true;
}

// Si hemos enviado el formulario de usuario/contraseña
if($_POST['btn_up']){

	include(ROOT_PATH.'/com/fun/db_mysql.php');
	$siteDB = new Db($dbServer, $dbUser, $dbPass, $dbDataBase);
	
	$password=md5($_POST['password']);
	if (checkUser($_POST['username'],$password)) {
		session_start();
		$userID=$userInfo['userID'];
		$level=$userInfo['level'];
		session_register("userID","password","level");
		header("Location: ".DIR_ADMIN."/start.php");
	}
	else {
		header("Location: ".DIR_ADMIN);
	}

}

// Formulario de usuario/contraseña
elseif(!$_POST['btn_up'] && !$_SESSION['userID']){
	
	echo '<html><head><title>Entrada</title></head><body>'."\n";
	echo '<form method="post" action="'.$_SERVER['PHP_SELF'].'" id="formuser">'."\n";
	echo 'Usuario: <input type="text" name="username" /><br />'."\n";
	echo 'Contraseña: <input type="password" name="password" /><br />'."\n";
	echo '<input type="submit" name="btn_up" value=" Entrar " />';
	echo '</form>';
	echo '</body></html>'."\n";

}
?>