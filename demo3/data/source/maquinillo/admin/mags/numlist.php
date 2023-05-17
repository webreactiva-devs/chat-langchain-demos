<?php
include ('../basic.php');
include (ROOT_AD_INC.'/head.inc.php');
include (ROOT_AD_INC.'/top.inc.php');

// Provisional. Variable definida por formulario
$magID=1;

// Comienzo del contenedor
echo printContHead('Números de la publicación');

// No se ha enviado el formulario
if(!$_POST['btn_list']){

	echo '<div class="form">'."\n";
	// Agregar uno nuevo
	echo '<p><a href="'.DIR_ADMIN.'/mag/numpro.php?action=addnum">Agregar uno nuevo</a></p>';	
	
	// Formulario de listado
	$form1 = new Form('byname');
	$form1->addField('text', 'title', '1. Por nombre' );
	$form1->addField('hidden', 'mode', '', 'title' );
	$form1->addField('submit', 'btn_list', 'Ver', 'Ver');
	$form1->endForm();	
	$form2 = new Form('byall');
	$form2->addField('hidden', 'mode', '', 'all' );
	echo '<label>2. Ver todos</label>';
	$form2->addField('submit', 'btn_list', 'Ver', 'Ver');
	$form2->endForm();	
	
	echo '</div>'."\n";
}

// Si se ha enviado el formulario
elseif($_POST['btn_list']){

	$nums = getNums($_POST['mode']);
	echo printList($nums, 'nums');
	
}

echo printContFoot();

include (ROOT_AD_INC.'/foot.inc.php');
?>