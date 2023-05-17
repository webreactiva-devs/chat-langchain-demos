<?php
// Usuarios

function getUser($myID){
	
	global $siteDB;

	$query = "SELECT * 
				FROM cms_users 
				WHERE status=0 
				AND userID=$myID ";
			
	$data = $siteDB->query_firstrow($query);
	$siteDB->free_result();
	
	return $data;

}

function getUserName($myID){
	
	global $siteDB;
	
	$query = "SELECT name  
				FROM cms_users 
				WHERE status=0 
				AND userID=$myID ";
			
	//$data = $siteDB->query_firstrow($query);
	$result = $siteDB->query($query);
	if($result){
		$data = $siteDB->fetch_array($result, 1);
		$siteDB->free_result();
		return $data['name'];
	}
	return;

}

function printUser($myUser){

	$user_item = & new Template(ROOT_TMPL.'/');
	
	$user_item->set('userID', $myUser['userID']);
	if($myUser['show_email'] == 1){
		$user_item->set('userEmail', printEncEmail($myUser['email']));
	}
	if($myUser['artsList']){
		$user_item->set('artsList', $myUser['artsList']);
	}
	if($myUser['docList']){
		$user_item->set('docList', $myUser['docList']);
	}
	$user_item->set('userNick', $myUser['username']);
	$user_item->set('userName', $myUser['name']);
	$user_item->set('userDesc', $myUser['description']);
	$user_item->set('userWeb', $myUser['website']);
	$userItem = $user_item->fetch('user_single.tpl');
	
	return $userItem;
}


?>