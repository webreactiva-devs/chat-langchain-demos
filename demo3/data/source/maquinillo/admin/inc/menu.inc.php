<?php
// Menú navegacion horizontal

$myLocation=$_SERVER['SCRIPT_NAME'];


$siteNav=array(
	'inicio' => '/',
	'publicaciones' => array(
		0 => '/mag',
		'listado' => '/mags/maglist.php',
		'articulos' => '/mags/artlist.php'
	)
);

foreach ($siteNav as $key => $value){
	
	if(!is_array($value)){
		$htmlMenu.='<li><a href="'.DIR_ADMIN.$value.'">'.ucfirst($key).'</a></li>'."\n";
	}
	else{
		$htmlMenu.='<li><a href="'.DIR_ADMIN.$value[0].'">'.ucfirst($key).'</a></li>'."\n";
		if($value[0]==DIR_ADMIN.$myLocation){
			foreach ($value as $key2 => $value2){
				$htmlMenu2.='<li><a href="'.DIR_ADMIN.$value2.'">'.ucfirst($key2).'</a></li>'."\n";
			}
		}
	
	}
	
	

}



?>