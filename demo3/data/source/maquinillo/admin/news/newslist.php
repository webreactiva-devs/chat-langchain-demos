<?php
include ('../basic.php');

if(!$_GET['jourid']){
	header("Location: jourlist.php");
	exit();
	}

include (ROOT_AD_INC.'/head.inc.php');
include (ROOT_AD_INC.'/top.inc.php');

// Nombre del diario
$jour = getJournal($_GET['jourid']);

// Comienzo del contenedor
echo printContHead('Noticias del diario<span>'.$jour['title'].'</span>');

// No se ha enviado el formulario
if(!$_POST['btn_list']){
	
	// Agregar uno nuevo
	echo '<p><a href="'.DIR_ADMIN.'/news/newspro.php?action=addentry&jourid='.$_GET[jourid].'">Agregar uno nuevo</a></p>';	
	
	$news = getNews('all', $_GET['jourid']);
	if($news)
		echo printList($news, 'news');
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

	$news = getNews($_REQUEST['mode'], $_GET['jourid']);
	if($news)
		echo printList($news, 'news');
	else
		echo printMsg('No se ha encontrado ninguno');
	
}

echo printContFoot();

include (ROOT_AD_INC.'/foot.inc.php');
?>