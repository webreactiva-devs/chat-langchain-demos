<?php
// Para ver noticias

// Conexión a la BD
require (ROOT_INC.'/fun/db_mysql.php');
require(ROOT_INC.'/dbconfig.php');
$siteDB = new Db($dbServer, $dbUser, $dbPass, $dbDataBase);

// Funciones necesarias
require(ROOT_INC.'/fun/fun_jour.php');
require(ROOT_INC.'/fun/fun_news.php');
require(ROOT_INC.'/fun/fun_categories.php');

$handlerArch = '/';

// Definimos el diario
if(!$jourID){
	$jour = setPathJournal();
	$jourID = $jour['jourID'];
}
else{
	$jour = getJournal($jourID);
}

$title = printTitle($breadcrumb);

// Título general
$title_jour = & new Template(ROOT_TMPL.'/');
$title_jour->set('magTitle', $jour['title']);
$title_jour->set('magSimpleTitle', end(explode('/',$jour['path'])));
$title_jour->set('magLink', $jour['path']);
$contentJour = $title_jour->fetch('title_jour.tpl'); 

$cats = getCats('news', $jour['jourID'], $jour['groupID']);
printCatTree($cats, 0, 1, 'array');

// Mostramos listado de noticias (secuenciado)
if(!$_GET['n']){

	if(!$_GET['p']){
		if ($jour['template'] == 0){ // Plantilla normal
			$news = getLastNews($jourID, '', 5);
			$newsList = printNewsList($news);
			}
		elseif ($jour['template'] == 1){ // Plantilla con más datos
			$news = getLastNews($jourID, '', 5);
			$newsList = printNewsList($news, 'large');
			}
		elseif ($jour['template'] == 2){ // Plantilla de FAQ
			$news = getNews('jourID', $jourID);
			$newsList = printNewsList($news, 'faq');
			}
		elseif ($jour['template'] == 3){ // Plantilla de glosario
			$news = getNews('jourID', $jourID);
			$newsList = printNewsList($news, 'alphabeta');
			}
	}
	elseif($_GET['p'] == 'todos'){
		$news = getNews('jourID', $jourID, '', '', 10);
		$newsList = printNewsList($news);
	}
	
	//$frontCats = printCatTree($cats, 0, 1, 'list', $jour['path'].$handlerArch.printGetUrl('arch', 'c_%s', $rewriteURL));
	$entryViewAll = printLink($jour['path'].$handlerArch, 'Ver archivos');
	
	$front_jour = & new Template(ROOT_TMPL.'/');
	$front_jour->set('jourDesc', $jour['description']);
	$front_jour->set('jourText', $jour['text']);
	//$front_jour->set('frontCats', $frontCats);
	$front_jour->set('newsList', $newsList);
	$front_jour->set('entryViewAll', $entryViewAll);
	$frontJour = $front_jour->fetch('front_jour_n'.$jour['template'].'.tpl'); 
	$contentJour .= $frontJour;

}


// Mostramos una noticia
elseif($_GET['n']){

	$entry = getEntry($_GET['n']);
	if(!$entry){
		exit();
	}
	
	logHits($_GET['n'], 'news');
	
	// Categoría
	$cat = getCat($entry['catID'], 'id');
	$catAux = getCatParent($cat['catID'], $cats);
	$catRoot = printCatRoot($catAux, 'link');
	
	// Opciones de noticia
	$optionsBox = printOptionsBox($entry['title']);
	
	// Variables de la entrada
	$entryTitle = $entry['title'];
	$entryExcerpt = printText($entry['excerpt'], $entry['nl2br']);
	$entryBody = printText($entry['body'], $entry['nl2br']);
	$entryCat = printLink($jour['path']. $handlerArch.printGetUrl('arch','c_'.setSimpText($cat['name']),$rewriteURL),$cat['name']);
	$entryLink = $jour['path'].'/'.printGetUrl('n', $entry['entryID'], $rewriteURL);
	$entryLinkTitle = printLink($entryLink, $entry['title']);
	$entryDate = convertDateU2LFormat($entry['date_mod'], "%d/%m/%Y");

	$entry_single = & new Template(ROOT_TMPL.'/');
	$entry_single->set('entryTitle', $entryTitle);
	$entry_single->set('entryExcerpt', $entryExcerpt);
	$entry_single->set('entryBody', $entryBody);
	$entry_single->set('entryLink', $entryLink);
	$entry_single->set('entryLinkTitle', $entryLinkTitle);
	$entry_single->set('optionsBox', $optionsBox);
	$contentJour .= $entry_single->fetch('entry_single.tpl'); 
	
	// Completamos el breadcrumb
	$breadcrumb .= ' &gt; '.$catRoot.' &gt; '.$entryLinkTitle;
	
	$title .= ' &middot; '.$entry['title'];

}

$content_jour = & new Template(ROOT_TMPL.'/');
$content_jour->set('breadcrumb', $breadcrumb);
$content_jour->set('content', $contentJour);
$contentMain = $content_jour->fetch('content.tpl'); 

include(ROOT_TMPL.'/didactica_main.tpl');
?>