<?php
// Funciones para autores

function getUser($myID){

	
	global $siteDB;

	$query = "SELECT * 
				FROM cms_users
				WHERE userID=$myID ";
			
	$data = $siteDB->query_firstrow($query);
	
	$siteDB->free_result();
	return $data;

}

function getUserName($myID){

	
	global $siteDB;

	$query = "SELECT name  
				FROM cms_users 
				WHERE userID=$myID ";
			
	$result = $siteDB->query($query);
	$data = $siteDB->fetch_array($result, 1);
	
	$siteDB->free_result();
	return $data['name'];

}

// Devuelve los datos de los usuarios
function getUsers($myMode='all', $myLevel = 1, $myDate = '', $myLimit = ''){
	
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
	
	if($myMode == 'level'){
		$queryX = " AND level>$myLevel ";
	}	

	if($myMode == 'date'){
		if(!$myDate && $_REQUEST['date'])
			$myDate = $_REQUEST['date'];
		$dates = getIntervalDates($myDate);
		$queryX = " AND date_mod<$dates[1] AND date_mod>$dates[0] ";
	}
	
	$query = "SELECT userID, username, name, website, email 
				FROM cms_users 
				WHERE 1>0 "
				.$queryX.
				" ORDER BY username ";
	// echo $query;		
	$result = $siteDB->query($query);
	
	while ($row = $siteDB->fetch_array($result, 1)){
		$data[$row['userID']] = $row;
	}
	
	$numItems = $siteDB->get_numrows();
	$siteDB->free_result();
	return $data;

}

function printJumpUsers($myData = '', $myUserID = '', $myName = 'userID'){

	if($myData == '')
		$myData = getUsers();
	
	if($myUserID == '')
		$myUserID = $_SESSION['userID'];
	
	foreach ($myData as $myID => $data)
		$users[$myID] = $data['name'];
	
	$select = printJump($users, $myUserID, '%d', 'noauto', $myName);

	return $select;
}
?>