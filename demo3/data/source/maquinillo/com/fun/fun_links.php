<?php
// Funciones para enlaces

// Devuelve los datos de los enlaces
function getLinks($myMode='all', $myCatID = '', $myDate = '', $myLimit = ''){
	
	global $siteDB, $numItems;
	
	if($myMode == 'all'){
		$queryX = "";
	}
	
	if($myMode == 'search'){
		$keywords = setSearch($_POST['q'], 'title');
		$queryX = " AND title LIKE '%".$keywords."%' ";
		$keywords = setSearch($_POST['q'], 'body');
		$queryX .= " OR body LIKE '%".$keywords."%' ";
	}

	if($myMode == 'categories'){
		if(!$myCatID && $_REQUEST['catID'])
			$myCatID = $_REQUEST['catID'];
		$queryX = " AND catID=$myCatID ";
	}
	
	if($myMode == 'date'){
		if(!$myDate && $_REQUEST['date'])
			$myDate = $_REQUEST['date'];
		$dates = getIntervalDates($myDate);
		$queryX = " AND date_mod<$dates[1] AND date_mod>$dates[0] ";
	}
	
	$query = "SELECT * 
				FROM cms_links 
				WHERE 1>0 "
				.$queryX.
				" ORDER BY title ";
	// echo $query;		
	$result = $siteDB->query($query);
	
	while ($row = $siteDB->fetch_array($result, 1)){
		$data[$row['linkID']] = $row;
	}
	
	$numItems = $siteDB->get_numrows();
	$siteDB->free_result();
	return $data;

}

// Últimos enlaces
function getLastLinks($myLimit = 5){

	global $siteDB;

	$query = "SELECT * 
				FROM cms_links
				ORDER BY date DESC  
				LIMIT 0, $myLimit";
			
	$result = $siteDB->query($query);
	
	while ($row = $siteDB->fetch_array($result, 1)){
		$data[$row['linkID']] = $row;
	}
	
	$siteDB->free_result();
	
	return $data;

}

// Devuelve datos sobre un enlace
function getLink($myID){
	
	global $siteDB;

	$query = "SELECT * 
				FROM cms_links
				WHERE linkID=$myID ";
			
	$data = $siteDB->query_firstrow($query);
	
	$siteDB->free_result();
	return $data;

}

function printLinks($myData){

	foreach ($myData as $linkID => $link){
	
		$link_item = & new Template(ROOT_TMPL.'/');
		$link_item->set('linkTitle', $link['title']);
		$link_item->set('linkURL', $link['url']);
		$link_item->set('linkDesc', $link['description']);
		$linkList .= $link_item->fetch('link_item.tpl');
	}
	
	return $linkList;
}


?>