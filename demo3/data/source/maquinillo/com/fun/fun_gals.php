<?php
// Funciones de fotografias

// Devuelve los datos de albumes
function getAlbums($myMode='all', $myCatID = ''){
	
	global $siteDB, $numRegs;

	if($myMode == 'title'){
		$keywords = setSearch($_POST['title'], 'title');
		$queryX = " AND title LIKE '%".$keywords."%' ";
		$keywords = setSearch($_POST['q'], 'description');
		$queryX .= " OR description LIKE '%".$keywords."%' ";
	}
	
	if($myMode == 'all'){
		$queryX = "";
	}
	
	if($myMode == 'id'){
		$queryX = " AND albumID = $_GET[albumid] ";
	}
	
	if($myMode == 'categories'){
		if(!$myCatID && $_REQUEST['catID'])
			$myCatID = $_REQUEST['catID'];
		$queryX = " AND catID=$myCatID ";
	}
	
	$query = "SELECT * 
				FROM cms_albums 
				WHERE 1>0 "
				.$queryX.
				" ORDER BY title ASC";
	//echo $query;		
	$result = $siteDB->query($query);
	
	while ($row = $siteDB->fetch_array($result, 1)){
		$data[$row['albumID']] = $row;
	}
	//print_r($data);
	//$data['numRegs'] = $siteDB->get_numrows();
	$numRegs = $siteDB->get_numrows();
	$siteDB->free_result();
	return $data;

}

// Devuelve datos sobre un album
function getAlbum($myID){
	
	global $siteDB;

	$query = "SELECT * 
				FROM cms_albums
				WHERE albumID=$myID ";
			
	$data = $siteDB->query_firstrow($query);
	
	$siteDB->free_result();
	return $data;

}

// Devuelve los datos de las fotos
// myMode = modo de recoger la informacion
// myAlbumID = podemos no señalarlo
// myDate = fecha en formato mmyyyy
function getPhotos($myMode='all', $myAlbumID = '', $myDate = ''){
	
	global $siteDB, $numItems;
	
	if($myMode == 'all'){
		$queryX = "";
	}
	
	if($myMode == 'search'){
		$keywords = setSearch($_POST['q'], 'title');
		$queryX = " AND title LIKE '%".$keywords."%' ";
		$keywords = setSearch($_POST['q'], 'description');
		$queryX .= " OR description LIKE '%".$keywords."%' ";
	}

	
	if($myMode == 'albumID'){
		if($_POST['albumID'])
			$albumID = $_POST['albumID'];
		else
			$albumID = $myAlbumID;
		$queryX = " AND albumID=$albumID ";
	}

	if($myMode == 'date'){
		if(!$myDate && $_REQUEST['date'])
			$myDate = $_REQUEST['date'];
		$dates = getIntervalDates($myDate);
		$queryX = " AND date<$dates[1] AND date>$dates[0] ";
	}
	
	$query = "SELECT * 
				FROM cms_images 
				WHERE albumID=$myAlbumID "
				.$queryX.
				" ORDER BY albumID DESC";
	// echo $query;		
	$result = $siteDB->query($query);
	
	while ($row = $siteDB->fetch_array($result, 1)){
		$data[$row['imageID']] = $row;
	}
	
	$numItems = $siteDB->get_numrows();
	$siteDB->free_result();
	return $data;

}

// Devuelve datos sobre una iamgen
function getPhoto($myID){
	
	global $siteDB;

	$query = "SELECT * 
				FROM cms_images 
				WHERE imageID=$myID ";
			
	$data = $siteDB->query_firstrow($query);
	
	$siteDB->free_result();
	return $data;

}

// Imagen de portada
function getCoverImage($myImageID, $myAlbumID){

	global $siteDB;
	
	// No hay imagen establecida
	if($myImageID == 0){
		$query = "SELECT * 
					FROM cms_images 
					WHERE albumID=$myAlbumID";
	}	
	else{
		$query = "SELECT * 
					FROM cms_images 
					WHERE imageID=$myImageID";
	}
	$data = $siteDB->query_firstrow($query);
	$siteDB->free_result();
	return $data;
}

?>