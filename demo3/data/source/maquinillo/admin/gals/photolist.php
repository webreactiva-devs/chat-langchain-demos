<?php
include ('../basic.php');

if(!$_GET['albumid']){
	header("Location: photolist.php");
	exit();
	}
	
include (ROOT_AD_INC.'/head.inc.php');
include (ROOT_AD_INC.'/top.inc.php');

// Comienzo del contenedor
echo printContHead('Fotografías del álbum');

// No se ha enviado el formulario
if(!$_POST['btn_list']){

	echo '<div class="form">'."\n";
	// Agregar uno nuevo
	echo '<p><a href="'.DIR_ADMIN.'/gals/photopro.php?action=addphoto&albumid='.$_GET['albumid'].'">Agregar una nueva</a></p>';	
	
	$photos = getPhotos('albumID', $_GET['albumid']);
	if($photos)
		echo printListPhotos($photos);
	else
		echo printMsg('No se ha encontrado ninguno');
	
	// Formulario de listado
	$form1 = new Form('byname');
	$form1->addField('text', 'title', '1. Por título' );
	$form1->addField('hidden', 'mode', '', 'title' );
	$form1->addField('submit', 'btn_list', 'Ver', 'Ver');
	$form1->endForm();	
	
	$form2 = new Form('byalbumID');
	
	$data = getAlbums();
	foreach($data as $albumID => $values){
		$albums[$albumID] = $values['title'];
	}
	
	$form2->addSelect('jourID', '2. Por album', $albums , 0);
	$form2->addField('hidden', 'mode', '', 'albumID' );
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

	$photos = getPhotos($_REQUEST['mode']);
	if($arts)
		echo printList($photos, 'albums');
	else
		echo printMsg('No se ha encontrado ninguno');
	
}

echo printContFoot();

include (ROOT_AD_INC.'/foot.inc.php');
?>