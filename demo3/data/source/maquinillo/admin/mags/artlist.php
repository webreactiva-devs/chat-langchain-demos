<?php
include ('../basic.php');

if(!$_GET['jourid']){
	header("Location: maglist.php");
	exit();
	}
	
include (ROOT_AD_INC.'/head.inc.php');
include (ROOT_AD_INC.'/top.inc.php');

// Comienzo del contenedor
echo printContHead('Artículos de la publicación');

// No se ha enviado el formulario
if(!$_POST['btn_list']){

	echo '<div class="form">'."\n";
	// Agregar uno nuevo
	echo '<p><a href="'.DIR_ADMIN.'/mags/artpro.php?action=addart&jourid='.$_GET['jourid'].'">Agregar uno nuevo</a></p>';	
	
	$arts = getArts('jourID', $_GET['jourid']);
	if($arts)
		echo printList($arts, 'articles');
	else
		echo printMsg('No se ha encontrado ninguno');
	
	// Formulario de listado
	$form1 = new Form('byname');
	$form1->addField('text', 'title', '1. Por título' );
	$form1->addField('hidden', 'mode', '', 'title' );
	$form1->addField('submit', 'btn_list', 'Ver', 'Ver');
	$form1->endForm();	
	
	$form2 = new Form('byjourID');
	
	$data = getJournals('',1);
	foreach($data as $jourID => $values){
		$jours[$jourID] = $values['title'];
	}
	
	$form2->addSelect('jourID', '2. Por magazine', $jours , 0);
	$form2->addField('hidden', 'mode', '', 'jourID' );
	$form2->addField('submit', 'btn_list', 'Ver', 'Ver');
	$form2->endForm();	
	
	$form3 = new Form('byall');
	$form3->addField('hidden', 'mode', '', 'all' );
	echo '<label>3. Ver todos</label>';
	$form3->addField('submit', 'btn_list', 'Ver', 'Ver');
	$form3->endForm();	
	
	echo '</div>'."\n";
}

// Si se ha enviado el formulario
elseif($_POST['btn_list']||$_GET['mode']){

	$arts = getArts($_REQUEST['mode']);
	if($arts)
		echo printList($arts, 'articles');
	else
		echo printMsg('No se ha encontrado ninguno');
	
}

echo printContFoot();

include (ROOT_AD_INC.'/foot.inc.php');
?>