<?php
include ('../basic.php');
include (ROOT_AD_INC.'/head.inc.php');
include (ROOT_AD_INC.'/top.inc.php');

// Comienzo del contenedor
echo printContHead('Páginas de estático');

// Nuevo diario
echo '<p><a href="'.DIR_ADMIN.'/statics/staticpro.php?action=addstatic">Agregar uno nuevo</a></p>';	

// Se muestra los diarios ordenados
$statics = getStatics();
echo printListStatics($statics);

echo printContFoot();

include (ROOT_AD_INC.'/foot.inc.php');
?>