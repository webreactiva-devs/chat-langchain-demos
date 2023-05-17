<?php
// Para ver las publicaciones

// Conexi�n a la BD
require (ROOT_INC.'/fun/db_mysql.php');
require(ROOT_INC.'/dbconfig.php');
$siteDB = new Db($dbServer, $dbUser, $dbPass, $dbDataBase);

// Funciones necesarias
require(ROOT_INC.'/fun/fun_jour.php');
require(ROOT_INC.'/fun/fun_articles.php');
require(ROOT_INC.'/fun/fun_categories.php');

$handlerCat = '/';

// Definimos el diario
if(!$jourID){
	$mag = setPathJournal();
	$jourID = $mag['jourID'];
}
else{
	$mag = getJournal($jourID);
}

$title = printTitle($breadcrumb);

$title_mag = & new Template(ROOT_TMPL.'/');
$title_mag->set('magTitle', $mag['title']);
$title_mag->set('magSimpleTitle', end(explode('/',$mag['path'])));
$title_mag->set('magLink', $mag['path']);
$contentMag = $title_mag->fetch('title_mag.tpl'); 

$cats = getCats('articles', $mag['jourID'], $mag['groupID']);
printCatTree($cats, 0, 1, 'array');

// �ndice de magazine
if(!$_GET['cat'] && !$_GET['a']){
	
	if(!$_GET['p'])
		$arts = getLastArts($jourID, '', 5);
	elseif($_GET['p'] == 'todos')
		$arts = getArts('jourID', $jourID);
	
	$frontCats = printCatTree($cats, 0, 1, 'list', $mag['path'].$handlerCat.printGetUrl('cat', '%s', $rewriteURL));
	
	/// Fix problem error 406
	$frontCats = str_replace('%BA','CURSO',$frontCats);
	
	if($arts){
		if ($mag['template'] == 0)
			$artsList = printArtsList($arts);
		elseif ($mag['template'] == 1)
			$artsList = printArtsList($arts, 'large');
	}
	else{
		$artsList = 'No hay entradas ';
	}
		
	$artViewAll = printLink($mag['path'].'/'.'?p=todos', 'Ver todos');
	 
	$front_mag = & new Template(ROOT_TMPL.'/');
	$front_mag->set('magDesc', $mag['description']);
	$front_mag->set('magText', $mag['text']);
	$front_mag->set('frontCats', $frontCats);
	$front_mag->set('artsList', $artsList);
	$front_mag->set('artViewAll', $artViewAll);
	$frontMag = $front_mag->fetch('front_mag_a'.$mag['template'].'.tpl'); 
	$contentMag .= $frontMag;
	
}

// �ndice de categoria
// En cms_news la categoria se ve en el apartado del historial
elseif($_GET['cat'] && !$_GET['a']){

	/// Fix problem error 406
	$_GET['cat'] = str_replace('CURSO','�',$_GET['cat']);

	$catsName = addslashes($_GET['cat']);
	$cat = getCat($catsName, 'name');
	
	//if($cat['cat_parent'] != 0){
	$catAux = getCatParent($cat['catID'], $cats);
	$catRoot = printCatRoot($catAux, 'link');
	//}
	
	$catName = $cat['name'];
	$catDesc = $cat['description'];
	$catText = $cat['text'];
	
	if($catTree[$cat['catID']])
		$subCats = printCatTree($cats, $cat['catID'], 1, 'listshort', $mag['path'].$handlerCat.printGetUrl('cat', '%s', $rewriteURL));
	
	if(!$_GET['p'])
		$arts = getLastArts($jourID, $cat['catID'], 5);
	elseif($_GET['p'] == 'todos')
		$arts = getArts('categories', $jourID, $cat['catID']);
	
	if($arts){
		$artsList = printArtsList($arts, 'large');
	}
	else{
		$artsList = 'No hay art�culos para esta categor�a';
	}

	// Completamos el breadcrumb
	$breadcrumb .= ' &gt; '.$catRoot;
	
	$artViewAll = printLink($mag['path'].$handlerCat.printGetUrl('cat', $catsName, $rewriteURL).'&p=todos', 'Ver todos');

	/// Fix problem error 406
	$artViewAll = str_replace('�','CURSO',$artViewAll);
	
	$front_cat = & new Template(ROOT_TMPL.'/');
	$front_cat->set('catName', $catName);
	$front_cat->set('catDesc', $catDesc);
	$front_cat->set('catText', $catText);
	$front_cat->set('subCats', $subCats);
	$front_cat->set('artsList', $artsList);
	$front_cat->set('artViewAll', $artViewAll);
	$frontCat = $front_cat->fetch('front_category.tpl'); 
	$contentMag .= $frontCat;

}

// Art�culo
elseif($_GET['a']){
	
	// Informaci�n sobre el art�culo
	$art = getArt($_GET['a']);
	
	if(!$_GET['p'] || $_GET['p']==1)
		logHits($_GET['a'], 'articles');
	
	// Usuario
	$art['username'] = getUserName($art['userID']);
	
	// Categor�a
	$cat = getCat($art['catID'], 'id');
	$catAux = getCatParent($cat['catID'], $cats);
	$catRoot = printCatRoot($catAux, 'link');
	
	// Muestra la primera p�gina del art�culo
	if(!$_GET['p'])
		$chapterID = 1;
	// Muestra la p�gina seleccionada del art�culo
	elseif($_GET['p'])
		$chapterID = $_GET['p'];
		
	// Opciones de art�culo
	$optionsBox = printOptionsBox($art['title'], 1, 1, array($art['userID'], $art['username']));
	
	// Art�culo con varias p�ginas
	if($art['article_chapters'] == 1){
		
		$j = $chapterID-1;
		$artChapterTitle = $art['title_chapter'][$j];
		$artBody = printText($art['body'][$j], $art['nl2br']);
		$artLink = printLink($mag['path'].'/'.printGetUrl('a', $art['artID'], $rewriteURL), $art['title']);

		// Mostrar p�gina siguiente
		if($chapterID > 1){
			$k = $chapterID - 1;
			$arrVars = array('a', 'p');
			$arrVals = array($_GET['a'], $k);
			$artPrevPage = printLink($mag['path'].'/'.printGetUrl($arrVars, $arrVals, $rewriteURL), '&laquo; '.$txt['paginaanterior']);
		}
		if($chapterID < $art['num_chapters']){
			$k = $chapterID + 1;
			$arrVars = array('a', 'p');
			$arrVals = array($_GET['a'], $k);
			$artNextPage = printLink($mag['path'].'/'.printGetUrl($arrVars, $arrVals, $rewriteURL), $txt['paginasiguiente'].' &raquo;');
			//$navPages = '<a href="'.$mag['path'].'/'.printGetUrl($arrVars, $arrVals, $rewriteURL).'">'.$txt['paginasiguiente'].' &raquo;</a>';
		}
		
		// Mostrar men� de salto para navegaci�n
		$selectPages = printSelectJump2($art['title_chapter']);
		
		// Plantillas
		$pages_box = & new Template(ROOT_TMPL.'/');
		$pages_box->set('artPrevPage', $artPrevPage);
		$pages_box->set('artNextPage', $artNextPage);
		$pages_box->set('selectPages', $selectPages);
		$pagesBox = $pages_box->fetch('pages_box.tpl');
				
		$art_chapter = & new Template(ROOT_TMPL.'/');
		$art_chapter->set('artTitle', $art['title']);
		$art_chapter->set('artChapterTitle', $artChapterTitle);
		$art_chapter->set('artBody', $artBody);
		$art_chapter->set('artLink', $artLink);
		$art_chapter->set('optionsBox', $optionsBox);
		$art_chapter->set('pagesBox', $pagesBox);
		$contentMag .= $art_chapter->fetch('article_chapter.tpl'); 

		
	}
	
	// Art�culo con una sola p�gina
	elseif($art['article_chapters'] == 0){
		$artTitle = $art['title'];
		$artExcerpt = printText($art['excerpt'], $art['nl2br']);
		
		if(ereg("<exe (.+) />", $art['body'][0], $aux) == true){
			ob_start();
			eval($aux[1].';');
			$artBody = ob_get_contents(); 
  			ob_end_clean();
		}
		else
			$artBody = printText($art['body'][0], $art['nl2br']);
		$artLink = printLink($mag['path'].'/'.printGetUrl('a', $art['artID'], $rewriteURL), $art['title']);

		$art_single = & new Template(ROOT_TMPL.'/');
		$art_single->set('artTitle', $artTitle);
		$art_single->set('artExcerpt', $artExcerpt);
		$art_single->set('artBody', $artBody);
		$art_single->set('artLink', $artLink);
		$art_single->set('optionsBox', $optionsBox);
		$contentMag .= $art_single->fetch('article_single.tpl'); 
	}
	
	// Completamos el breadcrumb
	$breadcrumb .= ' &gt; '.$catRoot.' &gt; '.$artLink;
	//$title .= ' &middot; '.$art['title'].' '.$artChapterTitle;
	$title = 'Did�ctica � '.$art['title'].' '.$artChapterTitle.' � '.$title;

}



$content_mag = & new Template(ROOT_TMPL.'/');
$content_mag->set('breadcrumb', $breadcrumb);
$content_mag->set('content', $contentMag);
$contentMain = $content_mag->fetch('content.tpl'); 

include(ROOT_TMPL.'/didactica_main.tpl');
?>