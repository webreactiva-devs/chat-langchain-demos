<?php
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
// Configuraciones básicas

include_once ('fun/functions.php');
include_once ('fun/fun_users.php');
include_once ('fun/templates.php');

// Variables globales
$siteName = 'Boulesis.com';
// Reescritura de variables a través de GET (simple o rw)
define(RW_URL,'rw'); 
$rewriteURL = 'simple';
$selectCSS = 'blue';
$lang = 'es_ES';
setlocale(LC_ALL, "$lang");

// Rutas
define(ROOT_GLOBAL, $_SERVER['DOCUMENT_ROOT']);
define(ROOT_INC, ROOT_GLOBAL.'/com');
define(ROOT_NAV, ROOT_GLOBAL.'/com/nav');
define(ROOT_ADMIN, ROOT_GLOBAL.'/admin');
define(ROOT_TMPL, ROOT_GLOBAL.'/com/tmpl');
define(DIR_GLOBAL, '/');
define(DIR_MEDIA, '/media');
define(HOST_GLOBAL, $_SERVER['HTTP_HOST']);
define(REF_URL, $_SERVER['HTTP_REFERER']);

// Archivo de idioma
include_once(ROOT_INC.'/lang_'.$lang.'.inc');

// Archivo de menú de navegacion
include_once(ROOT_NAV.'/sitenav.php');

// Localizador
$requestURL = $_SERVER['REQUEST_URI'];

// Partes del path 1
$path_Parts = pathinfo($requestURL);
// Eliminamos extensión php del nombre de archivo
$fileName=str_replace('.'.$path_Parts["extension"], "", $path_Parts["basename"]);
if($path_Parts["extension"] == '' || $fileName == '' || $fileName == 'index')
	$fileName = 'indexa';


//Eliminamos el ultimo '/'
if (strrpos($requestURL, '/') == strlen($requestURL)-1){
	$requestURL = substr_replace($requestURL, '', strrpos($requestURL, '/'),1);
	}

// Partes del path 2	
$pathParts = explode('/', $requestURL);

//Eliminaos el [0] por ser vacio	
array_shift($pathParts);



// Establecemos la sección en la que nos encontramos
// Construimos el menú principal de navegación
$menuhor = '<ul>'."\n";
foreach ($sections as $dir => $label){
	if($dir == $pathParts[0]){
		$selectSection = $dir;
		$menuhor .= '<li id="current"><a href="/'.$dir.'/" title="'.$sectionsTitle[$dir].'">'.$label.'</a></li>'."\n";
	}
	else{
		$menuhor .= '<li><a href="/'.$dir.'/"  title="'.$sectionsTitle[$dir].'">'.$label.'</a></li>'."\n";
	}
}
$menuhor .= '</ul>'."\n";

// Establecemos la subseccion en la que estamos
// para incluir o no un submenu
if($pathParts[1]){
	if ($siteNav[$selectSection][$pathParts[1]])
		$selectSubSection = $pathParts[1];
}

// Archivo de submenu
$submenuFile = ROOT_NAV.'/submenu_'.$selectSection.'_'.$selectSubSection.'.inc';;
// Archivo de menu
$menuFile = ROOT_NAV.'/'.$selectSection.'.inc';


// Localización
$sitePosition = setSitePosition ($siteNav);
$title = strip_tags($sitePosition);
$title = str_replace ("&gt;", ":", $title);
if($selectSection == 'filosofica')
	$title = str_replace("Boulesis", "Boulesis.com &middot; Miguel Santa Olalla ", $title);
else
	$title = str_replace("Boulesis", "Boulesis.com ", $title);



//$breadcrumb = "Estás en ".$sitePosition;
$breadcrumb = $sitePosition;
?>