<?php
// Para ver noticias

// Conexión a la BD
require (ROOT_INC.'/fun/db_mysql.php');
require(ROOT_INC.'/dbconfig.php');
$siteDB = new Db($dbServer, $dbUser, $dbPass, $dbDataBase);

// Funciones necesarias
require(ROOT_INC.'/fun/fun_statics.php');
require(ROOT_INC.'/fun/fun_staticpages.php');
require(ROOT_INC.'/fun/fun_categories.php');

$handlerArch = '/';

// Definimos el diario
if(!$staticpageID){
	$staticpage = setPathStaticpage();
	$staticpageID = $staticpage['staticID'];
}
else{
	$staticpage = getStaticpage($staticpageID);
}
$static = getStatic($staticpage['staticID']);

$title = printTitle($breadcrumb);

// Título general
$title_jour = & new Template(ROOT_TMPL.'/');
$title_jour->set('magTitle', $static['title']);
$title_jour->set('magSimpleTitle', end(explode('/',$static['path'])));
$title_jour->set('magLink', $static['path']);
$contentStatic = $title_jour->fetch('title_mag.tpl'); 

$cats = getCats('staticpages', $static['staticID'], $static['groupID'] );
printCatTree($cats, 0, 1, 'array');

	$cat = getCat($staticpage['catID'], 'id');
	
	//if($cat['cat_parent'] != 0){
	$catAux = getCatParent($cat['catID'], $cats);
	$catRoot = printCatRoot($catAux, 'link', '../');

	$staticpageLink = printLink($staticpage['url'],$staticpage['title']);

		$breadcrumb .= ' &gt; '.$catRoot.' &gt; '.$staticpageLink;
	$title .= ' &middot; '.$staticpage['title'];
	
	$staticpageTitle = '<h2>'.$staticpage['title'].'</h2>'."\n";
	$staticpageDesc = '<p class="subtitle">'.$staticpage['description'].'</p>';
	
	
?>