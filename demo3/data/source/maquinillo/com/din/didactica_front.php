<?php
// Portada de la didáctica

// Conexión a la BD
require (ROOT_INC.'/fun/db_mysql.php');
require(ROOT_INC.'/dbconfig.php');
$siteDB = new Db($dbServer, $dbUser, $dbPass, $dbDataBase);

// Funciones necesarias
require(ROOT_INC.'/fun/fun_jour.php');
require(ROOT_INC.'/fun/fun_articles.php');
require(ROOT_INC.'/fun/fun_news.php');
require(ROOT_INC.'/fun/fun_links.php');
require(ROOT_INC.'/fun/fun_docs.php');
require(ROOT_INC.'/fun/fun_statics.php');
require(ROOT_INC.'/fun/fun_staticpages.php');
require(ROOT_INC.'/fun/fun_categories.php');

function getElement($myData, $myType = ''){

	if($myType == '' || $myType == 'arts')
		$elem['elemID'] = $myData['artID'];
	elseif($myType == 'news')
		$elem['elemID'] = $myData['entryID'];
	elseif($myType == 'docs')
		$elem['elemID'] = $myData['docID'];		
	elseif($myType == 'staticpages'){
		$elem['elemID'] = $myData['staticpageID'];				
		$elem['url'] = $myData['url'];
	}
	$elem['title'] = $myData['title'];
	if($myData['date_mod'])
		$date = $myData['date_mod'];
	else
		$date = $myData['date'];
	$elem['date'] = convertDateU2LFormat($date, "%d/%m/%y");
	$elem['catID'] = $myData['catID'];
	
	return $elem;
}

// Iniciamos el array de contenido
$pathHandler = '/didactica';
$content = array(
	'apuntes' => array(
		'jourID' => 7,
		'name' => 'Apuntes',
		'level' => 9,
		'dinamic' => true
	),
	'examenes' => array(
		'jourID' => 1,
		'name' => 'Exámenes',
		'level' => 9,
		'dinamic' => true
	),
	'textos' => array(
		'jourID' => 10,
		'name' => 'Comentarios de texto',
		'level' => 9,
		'dinamic' => true
	),
	'intercambio' => array(
		'name' => 'Intercambio',
		'description' => '<strong>Ayúdanos</strong> aportando materiales para que esta web sea todavía más util',
		'level' => 6,
		'dinamic' => false
	),	
	'tics' => array(
		'name' => 'Tic\'s',
		'description' => 'Webquests, cazatesoros y juego interactivos: Tecnologías de la información en el aula',
		'level' => 6,
		'dinamic' => false
	),	
	/*'foros' => array(
		'name' => 'Foros',
		'description' => 'Debates, dudas y reflexiones',
		'type' => 'include',
		'file' => ROOT_GLOBAL.'/foros/last_posts.php',
		'level' => 6,
		'dinamic' => false
	),*/


	'selectividad' => array(
		'name' => 'Selectividad',
		'description' => 'Pistas y recursos para realizar un buen examen',
		'level' => 6,
 		'dinamic' => false
	),			
	'especiales' => array(
		'name' => 'Especiales',
		'description' => 'Temas filosóficos tratados en profundidad',
		'level' => 6,
 		'dinamic' => false
	),	
	/*'publi' => array(
		'name' => 'Humanidades',
		'type' => 'include',
		'file' => ROOT_GLOBAL.'/com/js/publi-banner-1.php',
		'level' => 9,
		'dinamic' => false
	),*/		
	'interactivos' => array(
		'jourID' => 1,
		'type' => 'staticpages',
		'name' => 'interactivos',
		'level' => 9,
		'dinamic' => true
	),
	/*'tutoria' => array(
		'name' => 'Tutoría',
		'description' => 'Blog de la tutoría de boulesis.com',
		'type' => 'include',
		'file' => ROOT_GLOBAL.'/didactica/tutoria/wp-last-posts.php',
		'level' => 9,
		'dinamic' => false
	),*/
	'documentos' => array(
		'name' => 'Documentos',
		'description' => 'Almacén de archivos monográficos',
		'type' => 'docs',
		'level' => 9,
		'dinamic' => true
	),
	'cuestionarios' => array(
		'jourID' => 12,
		'name' => 'cuestionarios',
		'level' => 9,
		'dinamic' => true
	),
	'logse' => array(
		'jourID' => 9,
		'name' => 'LOGSE',
		'level' => 9,
		'dinamic' => true
	),
	'glosario' => array(
		'jourID' => 11,
		'name' => 'Glosario',
		'type' => 'news',
		'level' => 9,
		/*'description' => 'Diccionario práctico de términos filosóficos',*/
		'dinamic' => true
	),
	'enlaces' => array(
		'name' => 'Enlaces',
		'description' => 'Colección de enlaces educativos',
		'level' => 6,
		'dinamic' => false
	)

);

// Recogemos los datos que nos faltan
foreach ($content as $sec => $values){
	if($values['dinamic'] == true){
		
		if(!$values['type'] || $values['type']=='arts'){
			$data = getJournal($values['jourID']);
			$content[$sec]['description'] = $data['description'];
			$lastArt = getLastArts($values['jourID'], '', 3);
			foreach ($lastArt as $artID => $value)
				$elements[$sec][] = getElement($lastArt[$artID], $values['type']);
		}
		elseif($values['type']=='news'){
			$data = getJournal($values['jourID']);
			$content[$sec]['description'] = $data['description'];
			$lastEntry = getLastNews($values['jourID'], '', 2);
			foreach ($lastEntry as $entryID => $value)
				$elements[$sec][] = getElement($lastEntry[$entryID], $values['type']);
		}
		elseif($values['type']=='docs'){
			//$content[$sec]['description'] = $data['description'];
			$lastDoc = getLastDocs('', 2);
			foreach ($lastDoc as $docID => $value)
				$elements[$sec][] = getElement($lastDoc[$docID], $values['type']);
		}		
		elseif($values['type']=='staticpages'){
			$data = getStatic($values['jourID']);
			$content[$sec]['description'] = $data['description'];
			$lastStaticpage = getLastStaticpages($values['jourID'], '', 3);
			foreach ($lastStaticpage as $staticpageID => $value)
				$elements[$sec][] = getElement($lastStaticpage[$staticpageID], $values['type']);
		}				
		elseif($values['type']=='wp'){ /* Listado de posts en wordpress */
			//require_once(ROOT_GLOBAL.'/planeta/wordpress/wp-blog-header.php');
			//require_once(ROOT_GLOBAL.$values['wpDir'].'/wp-blog-header.php');
			$wpPosts = get_posts('numberposts=3');
			$i=0;
			foreach ($wpPosts as $post){
				$elements[$sec][$i]['url'] = get_permalink();
				$elements[$sec][$i]['title'] = the_title('','',FALSE);
				$elements[$sec][$i]['date'] = get_the_time('d\/m\/y');
				$i++;
			}
		}			
	}
}
//print_r($content);


//reset($content);

// Construimos la salida en pantalla
$i=0;
foreach ($content as $sec => $values){


	$itemBack = 'style="background-image: url(/media/fronts/back_'.$sec.'.jpg);"';
	$itemLink = $pathHandler.'/'.$sec.'/';
	
	$front_item = & new Template(ROOT_TMPL.'/');
	$front_item->set('itemBack', $itemBack);
	$front_item->set('itemLink', $itemLink);
	$front_item->set('itemName', $sec);
	$front_item->set('itemDesc', $values['description']);
	
	if($values['dinamic'] == true){
		if($values['type'] == 'news')
			$letter = 'n';
		if($values['type'] == 'docs')
			$letter = 'd';			
		else
			$letter = 'a';
		$itemLastArt = '';
		foreach ($elements[$sec] as $elems){	
			if($values['type'] == 'staticpages' || $values['type'] == 'wp')
				$artLink = $elems['url'];
			else
				$artLink = $itemLink.printGetUrl($letter, $elems['elemID'], $rewriteURL);
			$art_item = & new Template(ROOT_TMPL.'/');
			$art_item->set('artDate', $elems['date']);
			$art_item->set('artTitle', $elems['title']);
			$art_item->set('artLink', $artLink);
			$itemLastArt .= $art_item->fetch('art_item_mini.tpl'); 
			$front_item->set('itemLastArt', $itemLastArt);
			
		}
	}
	
	elseif($values['type'] == 'include'){
		@include ($values['file']);
		$front_item->set('itemLastArt', $htmlInc);
	}
	
	if($values['level'] == 9){
		$frontItem = $front_item->fetch('front_didactica_item.tpl');
		$frontCol .= $frontItem;
	}
	/// PUBLICIDAD
	// if($sec == 'textos') {
	// 	$frontCol .= file_get_contents(ROOT_GLOBAL.'/com/js/publi-banner-1.php');
	// }
	
	if($values['level'] == 6){
		$frontItem = $front_item->fetch('front_didactica_item_side.tpl');
		$frontSide .= $frontItem;
	}
}

$didactica_front = & new Template(ROOT_TMPL.'/');
$didactica_front->set('frontCol', $frontCol);
$contentFront = $didactica_front->fetch('front_didactica.tpl'); 


?>