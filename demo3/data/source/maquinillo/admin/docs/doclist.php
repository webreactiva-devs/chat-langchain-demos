<?php
include ('../basic.php');
include (ROOT_AD_INC.'/head.inc.php');
include (ROOT_AD_INC.'/top.inc.php');

// Comienzo del contenedor
echo printContHead('Documentos');

// Nuevo diario
echo '<p><a href="'.DIR_ADMIN.'/docs/docpro.php?action=adddoc">Agregar uno nuevo</a></p>';	

// Se muestra los documentos ordenados
$docs = getDocs('', 1);
echo printList($docs, 'docs');

echo printContFoot();

include (ROOT_AD_INC.'/foot.inc.php');
?>