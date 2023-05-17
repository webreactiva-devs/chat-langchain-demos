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
if(!$staticID){
	$static = setPathStatic();
	$staticID = $static['staticID'];
}
else{
	$static = getStatic($staticID);
}


$title = printTitle($breadcrumb);

// Título general
$title_jour = & new Template(ROOT_TMPL.'/');
$title_jour->set('magTitle', $static['title']);
$title_jour->set('magSimpleTitle', end(explode('/',$static['path'])));
$title_jour->set('magLink', $static['path']);
$contentStatic = $title_jour->fetch('title_mag.tpl'); 

$cats = getCats('staticpages', $static['staticID'], $static['groupID'] );
printCatTree($cats, 0, 1, 'array');


if(!$_GET['cat'] && !$_GET['e']){
	
	$frontCats = printCatTree($cats, 0, 1, 'list', $static['path'].$handlerCat.printGetUrl('cat', '%s', $rewriteURL));

	if(!$_GET['p']){
		if ($static['template'] == 0){ // Plantilla normal
			$staticpages = getLastStaticpages($staticID, '', 5);
			$staticpagesList = printStaticpagesList($staticpages);
			}
		elseif ($static['template'] == 1){ // Plantilla con más datos
			$staticpages = getLastStaticpages($staticID, '', 5);
			$staticpagesList = printStaticpagesList($staticpages, 'large');
			}
		elseif ($static['template'] == 2){ // Plantilla de FAQ
			$staticpages = getStaticpages('staticID', $staticID);
			$staticpagesList = printStaticpagesList($staticpages, 'faq');
			}
		elseif ($static['template'] == 3){ // Plantilla de glosario
			$staticpages = getStaticpages('staticID', $staticID);
			$staticpagesList = printStaticpagesList($staticpages, 'alphabeta');
			} 
	}
	elseif($_GET['p'] == 'todos'){
		$staticpages = getStaticpages('staticID', $staticID, '', '', 10);
		$staticpagesList = printStaticpagesList($staticpages);
	}
	
	
	//$frontCats = printCatTree($cats, 0, 1, 'list', $static['path'].$handlerArch.printGetUrl('arch', 'c_%s', $rewriteURL));
	$entryViewAll = printLink($static['path'].$handlerArch, 'Ver todos');
	
	$front_jour = & new Template(ROOT_TMPL.'/');
	$front_jour->set('magDesc', $static['description']);
	$front_jour->set('magText', $static['text']);
	$front_jour->set('frontCats', $frontCats);
	$front_jour->set('artsList', $staticpagesList);
	$front_jour->set('entryViewAll', $entryViewAll);
	$frontStatic = $front_jour->fetch('front_jour_n'.$static['template'].'.tpl'); 
	$contentStatic .= $frontStatic;

}

elseif($_GET['cat'] && !$_GET['e']){

	$catsName = addslashes($_GET['cat']);
	$cat = getCat($catsName, 'name', $static['groupID']);
	
	//if($cat['cat_parent'] != 0){
	$catAux = getCatParent($cat['catID'], $cats);
	$catRoot = printCatRoot($catAux, 'link');
	//}
	
	$catName = $cat['name'];
	$catDesc = $cat['description'];
	$catText = $cat['text'];
	
	if($catTree[$cat['catID']])
		$subCats = printCatTree($cats, $cat['catID'], 1, 'listshort', $static['path'].$handlerCat.printGetUrl('cat', '%s', $rewriteURL));

	
	if(!$_GET['p']){
		if ($static['template'] == 0){ // Plantilla normal
			$staticpages = getLastStaticpages($staticID, $cat['catID'], 5);
			$staticpagesList = printStaticpagesList($staticpages);
			}
		elseif ($static['template'] == 1){ // Plantilla con más datos
			$staticpages = getLastStaticpages($staticID, $cat['catID'], 5);
			$staticpagesList = printStaticpagesList($staticpages, 'large');
			}
		elseif ($static['template'] == 2){ // Plantilla de FAQ
			$staticpages = getStaticpages('staticID', $staticID);
			$staticpagesList = printStaticpagesList($staticpages, 'faq');
			}
		elseif ($static['template'] == 3){ // Plantilla de glosario
			$staticpages = getStaticpages('staticID', $staticID);
			$staticpagesList = printStaticpagesList($staticpages, 'alphabeta');
			} 
	}
	elseif($_GET['p'] == 'todos'){
		$staticpages = getStaticpages('staticID', $staticID, '', '', 10);
		$staticpagesList = printStaticpagesList($staticpages);
	}	
	
	if(!$staticpages){
		$staticpagesList = '<br /><br />No hay elementos en esta categoría';
	}
	else
		$entryViewAll = printLink($static['path'].$handlerCat.printGetUrl('cat', $catsName, $rewriteURL).'&p=todos', 'Ver todos');
	

	// Completamos el breadcrumb
	$breadcrumb .= ' &gt; '.$catRoot;
	
	
	$front_cat = & new Template(ROOT_TMPL.'/');
	$front_cat->set('catName', $catName);
	$front_cat->set('catDesc', $catDesc);
	$front_cat->set('catText', $catText);
	$front_cat->set('subCats', $subCats);
	$front_cat->set('artsList', $staticpagesList);
	$front_cat->set('artViewAll', $entryViewAll);
	$frontCat = $front_cat->fetch('front_category.tpl'); 
	$contentStatic .= $frontCat;

}


// Mostramos una noticia
elseif($_GET['e']){

		$breadcrumb .= ' &gt; '.$catRoot.' &gt; '.$artLink;
	$title .= ' &middot; '.$art['title'].' '.$artChapterTitle;


}

$content_jour = & new Template(ROOT_TMPL.'/');
$content_jour->set('breadcrumb', $breadcrumb);
$content_jour->set('content', $contentStatic);
$contentMain = $content_jour->fetch('content.tpl'); 

include(ROOT_TMPL.'/didactica_main.tpl');
?>