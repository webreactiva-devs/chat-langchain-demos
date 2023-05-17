<?php
include ('../basic.php');
include (ROOT_AD_INC.'/head.inc.php');
include (ROOT_AD_INC.'/top.inc.php');

// Comienzo del contenedor
echo printContHead('Magazines de articulos');

// Nuevo diario
echo '<p><a href="'.DIR_ADMIN.'/mags/magpro.php?action=addjour">Agregar uno nuevo</a></p>';	

// Se muestra los diarios ordenados
$jours = getJournals('', 1);
echo printListJournals($jours, 'magazines');

echo printContFoot();

include (ROOT_AD_INC.'/foot.inc.php');
?>