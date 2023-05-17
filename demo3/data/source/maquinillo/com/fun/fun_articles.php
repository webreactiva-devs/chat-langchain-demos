<?php
// Funciones de articulos

// Devuelve los datos de los articulos segun criterio
function getArts($myMode='all', $myJourID = '', $myCatID = '', $myDate = '', $myLimit = '', $myInit = 0){
	
	global $siteDB, $numItems;

	if($myMode == 'search'){
		$keywords = setSearch($_POST['title'], 'title');
		$queryX = " AND title LIKE '%".$keywords."%' ";
		$keywords = setSearch($_POST['q'], 'body');
		$queryX .= " OR body LIKE '%".$keywords."%' ";
		if($myJourID !=''){
			$queryX .= " AND jourID=$myJourID ";
		}		
	}
	
	if($myMode == 'all'){
		$queryX = "";
	}
	
	if($myMode == 'jourID'){
		if($_POST['jourID'])
			$jourID = $_POST['jourID'];
		else
			$jourID = $myJourID;
		$queryX = " AND jourID=$jourID ";
	}
	
	if($myMode == 'categories'){
		if(!$myCatID && $_REQUEST['catID'])
			$myCatID = $_REQUEST['catID'];
		$queryX = " AND catID=$myCatID ";
		$queryX .= " AND jourID=$myJourID ";
	}
	
	if($myMode == 'date'){
		if(!$myDate && $_REQUEST['date'])
			$myDate = $_REQUEST['date'];
		$dates = getIntervalDates($myDate);
		$queryX = " AND date_mod<$dates[1] AND date_mod>$dates[0] ";
		$queryX .= " AND jourID=$myJourID ";
	}
	
	if($myLimit != ''){
		$queryY = "LIMIT $myInit, $myLimit";
	}
	
	$query = "SELECT * 
				FROM cms_articles
				WHERE 1>0 "
				.$queryX.
				"AND status=0 
				ORDER BY title ASC "
				.$queryY;
			
	$result = $siteDB->query($query);
	
	while ($row = $siteDB->fetch_array($result, 1)){
		$data[$row['artID']] = $row;
	}
	
	$numItems = $siteDB->get_numrows();
	$siteDB->free_result();
	return $data;

}

function getLastArts($myJourID = '', $myCatID = '', $myLimit = '', $myUserID = ''){

	global $siteDB;
	
	if($myJourID != ''){
		$queryX .= " AND jourID=$myJourID ";
	}	
	
	if ($myCatID != ''){
		$queryX .= " AND catID=$myCatID ";
	}
	
	if($myLimit != ''){
		$queryY = "LIMIT 0, $myLimit";
	}
	
	if($myUserID != ''){
		$queryX .= " AND userID=$myUserID ";
	}	

	$query = "SELECT * 
				FROM cms_articles
				WHERE 1>0 "
				.$queryX.
				"AND status=0 
				ORDER BY date_mod DESC "
				.$queryY;

	$result = $siteDB->query($query);
	
	while ($row = $siteDB->fetch_array($result, 1)){
		$data[$row['artID']] = $row;
	}
	
	//$numItems = $siteDB->get_numrows();
	$siteDB->free_result();
	return $data;
				
}

function getArt($myID){
	
	global $siteDB, $magID;

	$query = "SELECT * 
				FROM cms_articles, cms_art_chapters
				WHERE cms_articles.artID=$myID AND cms_art_chapters.artID=$myID";
			
	$result = $siteDB->query($query);
	
	$data = Array();
	while ($row = $siteDB->fetch_array($result, 1)){
		$data = $row;
		$j = $row['chapterID']-1;
		$dataaux['title_chapter'][$j] = $row['title_chapter'];
		$dataaux['body'][$j] = $row['body'];
	}
	
	$data['title_chapter']=Array();
	$data['body']=Array();
	
	for($i=0; $i<$data['num_chapters']; $i++){
		$data['title_chapter'][$i] = $dataaux['title_chapter'][$i];
		$data['body'][$i] = $dataaux['body'][$i];
	}
	
	$siteDB->free_result();
	return $data;
	
}

function printArtsList($myArts, $myMode = 'short'){

		global $mag, $cats, $rewriteURL;

		if(!$cats)
			$cats = getCats('articles', '', '');
		
		$i = 0;
		foreach ($myArts as $artID => $art){
			
			if($myMode == 'short')
				$artDate = convertDateU2LFormat($art['date_mod'], "%d/%m/%Y");
			elseif($myMode == 'large'){
				$artDate = convertDateU2LFormat($art['date_mod'], "%d/%m/%Y");
				$artUserName = getUserName($art['userID']);
			}
			$artTitle = $art['title'];
			$artMag = getJournal($art['jourID']);
			$artLink = $artMag['path'].'/'.printGetUrl('a', $art['artID'], $rewriteURL);
			$artLinkTitle = printLink($artLink, $artTitle);
			$artExcerpt = $art['excerpt'];
			if($myMode == 'short')
				$artCat = $cats[$art['catID']]['name'];
			$catAux = getCatParent($art['catID'], $cats);
			$artCatRoot = printCatRoot($catAux, 'link', $mag['path'].'/');
				
			$art_item = & new Template(ROOT_TMPL.'/');
			$art_item->set('artDate', $artDate);
			$art_item->set('artTitle', $artTitle);
			$art_item->set('artLink', $artLink);
			$art_item->set('artLinkTitle', $artLinkTitle);
			$art_item->set('artExcerpt', $artExcerpt);
			$art_item->set('artCat', $artCat);
			$art_item->set('artCatRoot', $artCat);
			$art_item->set('artUserID', $art['userID']);
			$art_item->set('artUserName', $artUserName);						
			$art_item->set('artMagID', $art['jourID']);
			if($myMode == 'short')
				$artsList .= $art_item->fetch('art_item_short.tpl'); 
			elseif($myMode == 'large')
				$artsList .= $art_item->fetch('art_item_large.tpl'); 
			unset($art_item);
			
			if($i==0){
				$artLastDate = $artDate;
				$artLastTitle = $artTitle;
				$artLastLink = $artLink;
				$artLastExcerpt = $artExcerpt;
				
				//if($art['imageID']){
				//	$itemImageURL = $art['imageURL'];
				//	$itemImageData = ' alt="'.$art['title'].'" width="'.$art['imageW'].'" height="'.$art['imageH'].'" ';
				//	$itemImage = 1;
				//}
			}

			$i++;
		}
		
		return $artsList;

}

if(!function_exists(getJournal)){

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

}


?>