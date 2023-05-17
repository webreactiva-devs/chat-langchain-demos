<?php
include ('../basic.php');

if(!$_GET['staticid']){
	header("Location: staticlist.php");
	exit();
	}

include (ROOT_AD_INC.'/head.inc.php');
include (ROOT_AD_INC.'/top.inc.php');

// Nombre del diario
$static = getStatic($_GET['staticid']);

// Comienzo del contenedor
echo printContHead('Estáticas<span>'.$jour['title'].'</span>');

// No se ha enviado el formulario
if(!$_POST['btn_list']){
	
	// Agregar uno nuevo
	echo '<p><a href="'.DIR_ADMIN.'/statics/staticpagepro.php?action=addstaticpage&staticid='.$_GET[staticid].'">Agregar uno nuevo</a></p>';	
	
	$staticpages = getStaticpages('all', $_GET['staticid']);
	if($staticpages)
		echo printList($staticpages, 'staticpages');
	else
		echo printMsg('No se ha encontrado ninguno');
	
	// Formulario de listado
	echo '<div class="form">'."\n";	
	$form1 = new Form('byname');
	$form1->addField('text', 'q', 'Búsqueda' );
	$form1->addField('hidden', 'mode', '', 'search' );
	$form1->addField('submit', 'btn_list', 'Ver', 'Ver');
	$form1->endForm();	
	echo '</div>'."\n";
}

// Si se ha enviado el formulario
elseif($_POST['btn_list']||$_GET['mode']){

	echo '<p class="note">Resultado de la búsqueda</p>';

	$news = getNews($_REQUEST['mode'], $_GET['staticid']);
	if($staticpages)
		echo printList($staticpages, 'staticpages');
	else
		echo printMsg('No se ha encontrado ninguno');
	
}

echo printContFoot();

include (ROOT_AD_INC.'/foot.inc.php');
?>