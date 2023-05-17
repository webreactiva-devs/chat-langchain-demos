<?php
// Funciones de diario
function setPathStatic($myHandler = '/historial'){

	global $siteDB;
	
	$pathStatic = dirname($_SERVER['SCRIPT_NAME']); 
	if(substr_count($pathStatic, '/')>1)
		$pathStatic =  str_replace($myHandler, '', $pathStatic);
	$query="SELECT * FROM cms_statics WHERE path='$pathStatic'";

	$data = $siteDB->query_firstrow($query);
	
	$siteDB->free_result();
	return $data;
}

// Devuelve datos sobre un diario
function getStatic($myID){
	
	global $siteDB;

	$query = "SELECT * 
				FROM cms_statics
				WHERE staticID=$myID ";
			
	$data = $siteDB->query_firstrow($query);
	
	$siteDB->free_result();
	return $data;

}

?>