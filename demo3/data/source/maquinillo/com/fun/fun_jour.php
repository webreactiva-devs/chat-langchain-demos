<?php
// Funciones de diario
function setPathJournal($myHandler = '/historial'){

	global $siteDB;
	
	$pathJournal = dirname($_SERVER['SCRIPT_NAME']);
	if(substr_count($pathJournal, '/')>1)
		$pathJournal =  str_replace($myHandler, '', $pathJournal);
	$query="SELECT * FROM cms_journals WHERE path='$pathJournal'";

	$data = $siteDB->query_firstrow($query);
	
	$siteDB->free_result();
	return $data;
}

// Devuelve datos sobre un diario
function getJournal($myID){
	
	global $siteDB;

	$query = "SELECT * 
				FROM cms_journals
				WHERE jourID=$myID ";
			
	$data = $siteDB->query_firstrow($query);
	
	$siteDB->free_result();
	return $data;

}

?>