<?php
// Script para ver ARTÍCULOS

require($DOCUMENT_ROOT."/script/dbconfig.php");
require($DOCUMENT_ROOT."/script/functions.php");

$id=mysql_connect($dbServer,$dbUser,$dbPass) or die("Se ha producido un error: ".mysql_error());
mysql_select_db($dbDataBase) or die("Se ha producido un error: ".mysql_error());

echo '<link href="'.$DOCUMENT_ROOT.'/estilosar.css" rel="stylesheet" type="text/css" />';
echo '<script language="JavaScript" type="text/javascript" src="'.$DOCUMENT_ROOT.'/scriptsar.js"> </script>';


// Seleccionamos el blog adecuado
if (!$blogID){
	$pathBlog=dirname($SCRIPT_NAME);
	$query="SELECT * FROM blogs WHERE path='$pathBlog'";
	$result=mysql_query($query) or die("Se ha producido un error1: ".mysql_error() );
	if(mysql_num_rows($result)!=1){
		echo "<h2>Error</h2>";
	}
	else{
		$row=mysql_fetch_object($result);
		$blogID=$row->blogID;
		$blogName=$row->name;
		$blogDescription=$row->description;
		$blogUrl=$row->url;
	}
}


echo '<h2><a href="'.$blogUrl.'">'.$blogName.'</a></h2>';
echo '<p>'.$blogDescription.'</p>';

// Si no hemos específicado la noticia
if (!$_GET['a']){
	// Mostramos las noticias por entryID descendente
	$query="SELECT articleID, title, excerpt FROM articles WHERE blogID=$blogID ORDER BY articleID DESC";
	$result=mysql_query($query) or die("Se ha producido un error: ".mysql_error() );

	while($row=mysql_fetch_object($result)){
		$row->entryID=str_replace("0","","$row->entryID");
		echo '<h3><a href="'.$blogUrl.'?a='.$row->articleID.'">'.$row->title.'</a></h3>'."\n";
		echo '<p>'.$row->excerpt."\n";
		echo '<br /><a href="'.$blogUrl.'?a='.$row->articleID.'">Más...</a></p>'."\n";
	}
}

// Si hemos específicado la noticia
elseif ($_GET['a']){

	$articleID=$_GET['a'];
	
	//Mostramos la noticia completa
	$query="SELECT * FROM articles WHERE blogID=$blogID AND articleID=$articleID";
	$result=mysql_query($query) or die("Se ha producido un error2: ".mysql_error() );
	if(mysql_num_rows($result)!=1){
		echo "<h3>Error: No existe el artículo</h3>";
		exit();
	}
	$row=mysql_fetch_object($result);
	
	echo '<h2>'.$row->title.'</h2>'."\n";
	
	// Artículo multi
	if ($row->article_chapters==1){
	
		// No hemos especificado número de página/capitulo
		if(!$_GET['p']){
			$chapterID=1;
		}
		
		// La hemos especificado
		else{
			$chapterID=$_GET['p'];
		}
		
		// Mostramos la pagina/capítulo especificado
		$query="SELECT * FROM articles_chapters WHERE articleID=$articleID AND chapterID=$chapterID";
		$result=mysql_query($query) or die("Se ha producido un error2: ".mysql_error() );
			if(mysql_num_rows($result)!=1){
			echo "<h3>Error: No existe el capítulo</h3>";
			exit();
		}
		
		$row2=mysql_fetch_object($result);
		
		echo '<h3>'.$row2->title.'</h3>'."\n";
		echo '<p class="text">'.$row2->body.'</p>'."\n";
		
		// Menú lineal de navegación por las páginas
		echo '<div id="pagesbox">';
		for ($i=1; $i<=$row->num_chapters; $i++){
			// Si la página es en la que nos encontramos
			if ($i==$chapterID){
				echo " $i |";
			}
			else{
				echo ' <a href="'.$blogUrl.'?a='.$articleID.'&p='.$i.'">'.$i.'</a> |';
			}
		}
		echo '</div>';
		
		// Menú de salto para navegar por las paginas
		$query="SELECT chapterID, title FROM articles_chapters WHERE articleID=$articleID";
		$result=mysql_query($query) or die("Se ha producido un error: ".mysql_error() );

		while($row3=mysql_fetch_array($result)){
			$options['title'][]=$row3['title'];
			$options['chapterID'][]=$row3['chapterID'];
		}
		printSelectJump($options, $blogUrl);
		// Fin menu de salto	
	}
	
	// Artículos simple
	elseif ($row->article_chapters==0){
		
		$query="SELECT * FROM articles_chapters WHERE articleID=$articleID AND chapterID=1";
		$result=mysql_query($query) or die("Se ha producido un error2: ".mysql_error() );
			if(mysql_num_rows($result)!=1){
			echo "<h3>Error: No existe el capítulo</h3>";
			exit();
		}
		
		$row2=mysql_fetch_object($result);
		
		echo '<h3>'.$row2->title.'</h3>'."\n";
		echo '<p class="text">'.$row2->body.'</p>'."\n";
	}

}
mysql_close();
?>