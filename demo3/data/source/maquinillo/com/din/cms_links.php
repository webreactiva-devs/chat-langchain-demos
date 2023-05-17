<?php
// Muestra enlaces y categorías

// Conexión a la BD
require (ROOT_INC.'/fun/db_mysql.php');
require(ROOT_INC.'/dbconfig.php');
$siteDB = new Db($dbServer, $dbUser, $dbPass, $dbDataBase);

// Funciones necesarias
require(ROOT_INC.'/fun/fun_categories.php');
require(ROOT_INC.'/fun/fun_links.php');

$handlerCat = '/';
$groupID = 100;
$mag['path'] = '/didactica/enlaces';

$title_mag = & new Template(ROOT_TMPL.'/');
$title_mag->set('magTitle', 'Enlaces');
$title_mag->set('magSimpleTitle', 'enlaces');
$title_mag->set('magLink', $mag['path']);
$contentLinks = $title_mag->fetch('title_mag.tpl'); 

$cats = getCats('links', '', $groupID);
printCatTree($cats, 0, 1, 'array');

// Muestra categorías y últimos añadidos
if(!$_GET['cat'] && !$_GET['l']){

	$links = getLastLinks(5);
	
	$frontCats = printCatTree($cats, 0, 1, 'list', $mag['path'].$handlerCat.printGetUrl('cat', '%s', $rewriteURL));
	
	if($links){
		$linksList = printLinks($links);
	}
	else{
		$linksList = 'No hay entradas ';
	}
	
	$front_link = & new Template(ROOT_TMPL.'/');
	$front_link->set('magDesc', 'Colección de recursos disponibles en la red');
	$front_link->set('magText', 'Aquí podrás encontrar diversos enlaces relacionados con la filosofía y su enseñanza. Si encuentras algún enlace que crees que vale la pena (o incluso si vas a hacer una página web personal sobre este tema) <a href="/didactica/intercambio/">no dudes en avisarnos</a>.<br /><br />» Participa en <strong><a href="/foros/">nuestros foros</a></strong> académicos para preguntar, hacer peticiones...');
	$front_link->set('frontCats', $frontCats);
	$front_link->set('linksList', $linksList);
	$frontLinks = $front_link->fetch('front_links.tpl'); 
	$contentLinks .= $frontLinks;

}


// Muestra la categoría elegida
elseif($_GET['cat']){
	
	// Categoría
	$catsName = addslashes($_GET['cat']);
	$cat = getCat($catsName, 'name', $groupID);
	$catRoot = printCatRoot(getCatParent($cat['catID'], $cats), 'link');
	
	$catName = $cat['name'];
	$catDesc = $cat['description'];
	$catText = $cat['text'];
	
	if($catTree[$cat['catID']])
		$subCats = printCatTree($cats, $cat['catID'], 1, 'listshort', $mag['path'].$handlerCat.printGetUrl('cat', '%s', $rewriteURL));
	
	// Enlaces para esa categoria
	$links = getLinks('categories', $cat['catID']);
	
	if($links){
		$linksList = printLinks($links);
	}
	else{
		$linksList = 'No hay entradas ';
	}
	
	// Completamos el breadcrumb
	$breadcrumb .= ' &gt; '.$catRoot;
	
	$front_link_cat = & new Template(ROOT_TMPL.'/');
	$front_link_cat->set('catName', $catName);
	$front_link_cat->set('catDesc', $catDesc);
	$front_link_cat->set('catText', $catText);
	$front_link_cat->set('subCats', $subCats);
	$front_link_cat->set('artsList', $linksList);
	$frontLinkCat = $front_link_cat->fetch('front_category.tpl'); 
	$contentLinks .= $frontLinkCat;
	
}

$content_mag = & new Template(ROOT_TMPL.'/');
$content_mag->set('breadcrumb', $breadcrumb);
$content_mag->set('content', $contentLinks);
echo $content_mag->fetch('content.tpl'); 

?>