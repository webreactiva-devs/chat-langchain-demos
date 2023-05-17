<?php
include ('../basic.php');
include (ROOT_AD_INC.'/head.inc.php');
include (ROOT_AD_INC.'/top.inc.php');

// Comienzo del contenedor
echo printContHead('Diarios de noticias');

// Nuevo diario
echo '<p><a href="'.DIR_ADMIN.'/news/jourpro.php?action=addjour">Agregar uno nuevo</a></p>';	

// Se muestra los diarios ordenados
$jours = getJournals();
echo printListJournals($jours);

echo printContFoot();

include (ROOT_AD_INC.'/foot.inc.php');
?>