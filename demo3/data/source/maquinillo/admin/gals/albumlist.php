<?php
include ('../basic.php');
include (ROOT_AD_INC.'/head.inc.php');
include (ROOT_AD_INC.'/top.inc.php');

// Comienzo del contenedor
echo printContHead('Álbumes de fotografías');

// Nuevo diario
echo '<p><a href="'.DIR_ADMIN.'/gals/albumpro.php?action=addalbum">Agregar uno nuevo</a></p>';	

// Se muestra los diarios ordenados
$albums = getAlbums();
echo printListAlbums($albums);

echo printContFoot();

include (ROOT_AD_INC.'/foot.inc.php');
?>