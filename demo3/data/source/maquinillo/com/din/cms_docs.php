<?php
// Muestra documentos y categorías

// Conexión a la BD
require (ROOT_INC.'/fun/db_mysql.php');
require(ROOT_INC.'/dbconfig.php');
$siteDB = new Db($dbServer, $dbUser, $dbPass, $dbDataBase);

// Funciones necesarias
require(ROOT_INC.'/fun/fun_categories.php');
require(ROOT_INC.'/fun/fun_docs.php');

$handlerCat = '/';
$groupID = 101;
$mag['path'] = '/didactica/documentos';

$title_mag = & new Template(ROOT_TMPL.'/');
$title_mag->set('magTitle', 'Documentos');
$title_mag->set('magSimpleTitle', 'documentos');
$title_mag->set('magLink', $mag['path']);
$contentDocs = $title_mag->fetch('title_mag.tpl'); 

$cats = getCats('documents', '', $groupID);
printCatTree($cats, 0, 1, 'array');

// Muestra categorías y últimos añadidos
if(!$_GET['cat'] && !$_GET['d']){

	$docs = getLastDocs('', 5);
	
	$frontCats = printCatTree($cats, 0, 1, 'list', $mag['path'].$handlerCat.printGetUrl('cat', '%s', $rewriteURL));
	
	if($docs){
		$docsList = printDocs($docs, 'short');
	}
	else{
		$docsList = 'No hay entradas ';
	}
	
	//$docViewAll = printLink($mag['path'].'/'.'?p=todos', 'Ver todos');
	
	$front_doc = & new Template(ROOT_TMPL.'/');
	$front_doc->set('magDesc', 'Materiales diversos en pdf y otros');
	$front_doc->set('magText', 'Documentos extensos agrupados por categorías. No olvides que puedes enviarnos los tuyos a través de nuestro <a href="/didactica/intercambio/">intercambio</a>.<br /><br />» Participa en <strong><a href="/foros/">nuestros foros</a></strong> académicos para preguntar, hacer peticiones...');
	//$front_doc->set('docViewAll', $docViewAll);
	$front_doc->set('frontCats', $frontCats);
	$front_doc->set('docsList', $docsList);
	$frontDocs = $front_doc->fetch('front_docs.tpl'); 
	$contentDocs .= $frontDocs;

}


// Muestra la categoría elegida
elseif($_GET['cat'] && !$_GET['d']){
	
	// Categoría
	$catsName = addslashes($_GET['cat']);
	$cat = getCat($catsName, 'name', $groupID);
	$catRoot = printCatRoot(getCatParent($cat['catID'], $cats), 'doc');
	
	$catName = $cat['name'];
	$catDesc = $cat['description'];
	$catText = $cat['text'];
	
	if($catTree[$cat['catID']])
		$subCats = printCatTree($cats, $cat['catID'], 1, 'listshort', $mag['path'].$handlerCat.printGetUrl('cat', '%s', $rewriteURL));
	
	// Documentos para esa categoria
	if(!$_GET['p'])
		$docs = getLastDocs($cat['catID'], 5);
	elseif($_GET['p'] == 'todos')
		$docs = getDocs('categories', $cat['catID']);
	
	
	if($docs){
		$docsList = printDocs($docs);
	}
	else{
		$docsList = 'No hay entradas ';
	}
	
	// Completamos el breadcrumb
	$breadcrumb .= ' &gt; '.$catRoot;
	
	$docViewAll = printLink($mag['path'].$handlerCat.printGetUrl('cat', $catsName, $rewriteURL).'&p=todos', 'Ver todos');
	
	$front_doc_cat = & new Template(ROOT_TMPL.'/');
	$front_doc_cat->set('catName', $catName);
	$front_doc_cat->set('catDesc', $catDesc);
	$front_doc_cat->set('catText', $catText);
	$front_doc_cat->set('subCats', $subCats);
	$front_doc_cat->set('artViewAll', $docViewAll);
	$front_doc_cat->set('artsList', $docsList);
	$frontDocCat = $front_doc_cat->fetch('front_category.tpl'); 
	$contentDocs .= $frontDocCat;
	
}

// Muestra todos los datos de un solo documento
elseif($_GET['d']){

	// Informacion del documento
	$doc = getDoc($_GET['d']);
	
	// Categoría
	$cat = getCat($doc['catID'], 'id');
	$catAux = getCatParent($cat['catID'], $cats);
	$catRoot = printCatRoot($catAux, 'link');
	
	// Variables auxiliares
	$doc['link'] = $mag['path'].'/'.printGetUrl('d', $doc['docID'], $rewriteURL);
	$docLinkTitle = printLink($doc['link'], $doc['title']);
	$doc['username'] = getUserName($doc['userID']);
	
	
	// Variables de salida
	$contentDocs .= printDoc($doc);
	
	// Completamos el titulo, breadcrumb
	$breadcrumb .= ' &gt; '.$catRoot.' &gt; '.$docLinkTitle;
	

}

$title = printTitle($breadcrumb);

$content_doc = & new Template(ROOT_TMPL.'/');
$content_doc->set('breadcrumb', $breadcrumb);
$content_doc->set('content', $contentDocs);
$contentMain = $content_doc->fetch('content.tpl'); 

include(ROOT_TMPL.'/didactica_main.tpl');

?>