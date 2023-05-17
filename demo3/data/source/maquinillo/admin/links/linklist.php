<?php
include ('../basic.php');
include (ROOT_AD_INC.'/head.inc.php');
include (ROOT_AD_INC.'/top.inc.php');

// Comienzo del contenedor
echo printContHead('Directorio de enlaces');

// Nuevo diario
echo '<p><a href="'.DIR_ADMIN.'/links/linkpro.php?action=addlink">Agregar uno nuevo</a></p>';	

// Se muestra los diarios ordenados
$links = getLinks('', 1);
echo printList($links, 'links');

echo printContFoot();

include (ROOT_AD_INC.'/foot.inc.php');
?>