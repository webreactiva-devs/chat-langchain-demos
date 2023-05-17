<?php
include ('../basic.php');
include (ROOT_AD_INC.'/head.inc.php');
include (ROOT_AD_INC.'/top.inc.php');

// Comienzo del contenedor
echo printContHead('Artículos de la publicación');

// Datos globales del magazine
$mag = getJournal ($_GET['jourid']);

// Si no se ha pasado un identificador
if (!$_GET['artid']){
	
if (!$_GET['action'] == 'addart'){
	echo printError('No se puede ejecutar esa acción');
}
	
// Si es action=add
elseif($_GET['action'] == 'addart'){

	// Mostrar formulario
	if(!$_POST['btn_art']){
		printFormArt($_POST, $mag['groupID']);
	}
	
	// Añadir a la base de datos
	elseif($_POST['btn_art']){
		
		// Transformaciones previas
		$date = convertDateL2U($_POST['date']);
		$excerpt = chop($_POST[excerpt]);
		
		if($_POST['numchapters']>1)
			$article_chapters=1;
		else
			$article_chapters=0;
		
		// Datos del artículo
		$query="INSERT INTO cms_articles 
				 (jourID, catID, title, excerpt, date, date_mod, userID, article_chapters, num_chapters, imageID, article_level, article_parent, status, nl2br) 
				VALUES ('$_GET[jourid]', '$_POST[catID]', '$_POST[title]', '$excerpt', $date, $date, $_POST[userID], $article_chapters, $_POST[numchapters], '$_POST[imageID]', '$_POST[article_level]', '$_POST[article_parent]', $_POST[status], '$_POST[nl2br]')";
		$result[0] = $siteDB->query($query);
		$lastID = $siteDB->get_insert_id();
		$siteDB->free_result();
		
		// Datos de los capítulos
		for($i=0;$i<$_POST['numchapters'];$i++){
			$j = $i+1;
			$title_chapter = $_POST[title_chapter][$i];
			$body = chop($_POST[body][$i]);
			$query="INSERT INTO cms_art_chapters 
					(artID, chapterID, title_chapter, body) 
					VALUES ($lastID, $j, '$title_chapter', '$body')";
			$result[$j] = $siteDB->query($query);
			$siteDB->free_result();
		}
		foreach($result as $value){
			if(!$value){
				$setErrorDB = 1;
				break;
			}
			else
				$setErrorDB = 0;
		}
		
		if($setErrorDB == 0){
			saveLastInsert($lastID, 'articles', $date, $_GET[jourid], $_POST[status]);
			echo printMsg('Artículo insertado con éxito');
			}
		else{
			echo printMsg('Se ha producido un error');
			printFormArt($_POST,$mag['groupID']);
		}
	}
}

} // Fin !$_GET[id]

// Si se ha pasado un identificador
elseif($_GET['artid']){

// Ver
if($_GET['action'] == 'viewart'){

}

// Edición
elseif($_GET['action'] == 'editart'){

	// Mostrar formulario
	if(!$_POST['btn_art']){
		$art = getArt($_GET['artid']);
		$art['date_mod']=convertDateU2L($art['date_mod']);
		printFormArt($art, $mag['groupID']);
	}
	
	// Ejecutar la edición
	if($_POST['btn_art']){
		
		// Transformaciones previas
		$date = convertDateL2U($_POST['date']);
		$excerpt = chop($_POST[excerpt]);
		
		if($_POST['numchapters']>1)
			$article_chapters=1;
		else
			$article_chapters=0;
	
		$query="UPDATE cms_articles  
				SET catID=$_POST[catID], title='$_POST[title]', excerpt='$excerpt', date_mod=$date, article_chapters=$article_chapters, num_chapters=$numchapters, article_level=$_POST[article_level], article_parent=$_POST[article_parent], status=$_POST[status], nl2br='$_POST[nl2br]', userID=$_POST[userID]    
				WHERE artID=$_GET[artid]";
		$result[0] = $siteDB->query($query);
		
		$siteDB->free_result();
		
		// Datos de los capítulos
		for($i=0;$i<$_POST['numchapters'];$i++){
			$j = $i+1;
			$title_chapter = $_POST[title_chapter][$i];
			$body = chop($_POST[body][$i]);
			$query="UPDATE cms_art_chapters 
					SET title_chapter='$title_chapter', body='$body'  
					WHERE artID=$_GET[artid] AND chapterID=$j";
			$result[$j] = $siteDB->query($query);
			$siteDB->free_result();
		}
		
		foreach($result as $value){
			if(!$value){
				$setErrorDB = 1;
				break;
			}
			else
				$setErrorDB = 0;
		}
		
		if($setErrorDB == 0){
			updateLastInsert($_GET[artid], 'articles', $date, $_GET[jourid], $_POST[status]);
			echo printMsg('Artículo editado con éxito');
			}
		else{
			echo printMsg('Se ha producido un error');
			printFormArt($_POST, $mag['groupID']);
		}
	}

}

// Borrar
elseif($_GET['action'] == 'deleteart'){

	// Mostrar confirmacion
	if(!$_POST['btn_delart']){
		echo printMsg('¿Seguro que quiere borrar el artículo completo?');
		printFormDel('articles');
	}
	
	// Ejecutar borrado
	elseif($_POST['btn_delart']){
		$query="DELETE 
				FROM cms_articles 
				WHERE artID='$_GET[artid]'";
		$result1 = $siteDB->query($query);
		
		$query="DELETE
				FROM cms_art_chapters
				WHERE artID='$_GET[artid]'";
		$result2 = $siteDB->query($query);
		if($result1&&$result2){
			delLastInsert($_GET[artid], 'articles');
			echo printMsg('Artículo eliminado con éxito');
			$siteDB->free_result();		
		}
		else{
			echo printError('Se ha producido un error en la eliminación');
		}	
	}

}

} // Fin $_GET[id]

echo printContFoot();


include (ROOT_AD_INC.'/foot.inc.php');
?>