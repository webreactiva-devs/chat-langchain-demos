<?php
// Muestra la ficha de usuario

// Conexión a la BD
require (ROOT_INC.'/fun/db_mysql.php');
require(ROOT_INC.'/dbconfig.php');
$siteDB = new Db($dbServer, $dbUser, $dbPass, $dbDataBase);

// Funciones necesarias
require(ROOT_INC.'/fun/fun_categories.php');
require(ROOT_INC.'/fun/fun_articles.php');
require(ROOT_INC.'/fun/fun_docs.php');
//require(ROOT_INC.'/fun/fun_users.php');

$mag['path'] = '/didactica/usuarios';

$title_mag = & new Template(ROOT_TMPL.'/');
$title_mag->set('magTitle', 'Usuarios');
$title_mag->set('magSimpleTitle', 'usuarios');
$title_mag->set('magLink', $mag['path']);
$contentUser = $title_mag->fetch('title_mag.tpl'); 



if(!$_GET['u']){

	//$contentUser .= '<div class="error">No hay ningún usuario especificado</div>';
	//$contentUser .= '<div class="center">Ir a <a href="/didactica/"><em>didáctica</em></a></div>';
	header('Location: /didactica/');
	exit();
}

elseif($_GET['u']){

	// Informacion del usuario
	$user = getUser($_GET['u']);
	
	if(!$user){
		header('Location: /didactica/');
		exit();
	}
	// Recogemos las últimas aportaciones (artículos y documentos)
	$arts = getLastArts('', '', 10, $user['userID']);
	
	if($arts){
		$artsList = printArtsList($arts, 'short');
	}
	else{
		$artsList = 'No hay entradas ';
	}
	
	$docs = getLastDocs('', 10, $user['userID']);
	
	if($docs){
		$docList = printDocs($docs, 'short');
	}
	else{
		$docList = 'No hay entradas ';
	}
	
	$user['artsList'] = $artsList;
	$user['docList'] = $docList;
	$contentUser .= printUser($user);

	/*$front_user = & new Template(ROOT_TMPL.'/');
	$front_user->set('docList', $docsList);
	$front_user->set('artsList', $artsList);
	$front_user->set('userProfile', $userProfie);
	$contentUser = $front_user->fetch('front_user.tpl'); */
	
	// Completamos el breadcrumb
	$breadcrumb .= ' &gt; '.$user['name'];
	$title .= ' &middot; '.$user['name'];
	
}

$content_user = & new Template(ROOT_TMPL.'/');
$content_user->set('breadcrumb', $breadcrumb);
$content_user->set('content', $contentUser);
$contentMain = $content_user->fetch('content.tpl'); 

include(ROOT_TMPL.'/didactica_main.tpl');

?>