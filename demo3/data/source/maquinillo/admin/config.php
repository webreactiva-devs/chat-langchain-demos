<?php
// Configuracion general

define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']);
define('HOST', $_SERVER['HTTP_HOST']);

define('ROOT_ADMIN', $_SERVER['DOCUMENT_ROOT'].'/admin');
define('DIR_ADMIN', '/admin');

define('ROOT_AD_INC', ROOT_ADMIN.'/inc');
define('DIR_AD_INC', '/admin/inc');

define('ROOT_AD_MEDIA', ROOT_ADMIN.'/media');
define('DIR_AD_MEDIA', '/admin/media');

// Información sobre las imágenes (provisional)
define("IMAGE_BASE", '/media/gal/photos');
define("THUMB_BASE", '/media/gal/thumbs');
define("DOC_BASE", '/docs');
define("MAX_WIDTH", 100);
define("MAX_HEIGHT", 100);
define("RESIZE_WIDTH", 800);
define("RESIZE_HEIGHT", 600);

// Datos para la onexión a la base de datos
require('dbconfig.php');


$myLocation=dirname($_SERVER['SCRIPT_NAME']);

$siteNav=array(
	'inicio' => '/',
	'diarios' => array(
		0 => '/news',
		'listado' => '/news/jourlist.php',
		'noticias' => '/news/newslist.php?jourid='.$_GET[jourid]
	),
	'publicaciones' => array(
		0 => '/mags',
		'listado' => '/mags/maglist.php',
		'articulos' => '/mags/artlist.php?jourid='.$_GET[jourid]
	),
	'galerías' => array(
		0 => '/gals',
		'listado' => '/gals/albumlist.php',
		'fotos' => '/gals/photolist.php?albumid='.$_GET[albumid]
	),
	'documentos' => array(
		0 => '/docs',
		'listado' => '/docs/doclist.php'
	),
	'enlaces' => array(
		0 => '/links',
		'listado' => '/links/linklist.php'
	),
	'estáticas' => array(
		0 => '/statics',
		'listado' => '/statics/staticlist.php',
		'paginas' => '/statics/staticpagelist.php?staticid='.$_GET[staticid]
	)
);
?>