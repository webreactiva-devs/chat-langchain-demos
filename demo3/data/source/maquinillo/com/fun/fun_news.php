<?php
// Funciones de diarios y noticias

function getNews($myMode='all', $myJourID = '', $myCatID = '', $myDate = '', $myLimit = ''){
	
	global $siteDB, $numNews;
	
	if($myMode == 'all'){
		$queryX = "";
	}
	
	if($myMode == 'search'){
		$keywords = setSearch($_POST['q'], 'title');
		$queryX = " AND title LIKE '%".$keywords."%' ";
		$keywords = setSearch($_POST['q'], 'body');
		$queryX .= " OR body LIKE '%".$keywords."%' ";
		if($myJourID !=''){
			$queryX .= " AND jourID=$myJourID ";
		}			
	}

	
	if($myMode == 'jourID'){
		if($_POST['jourID'])
			$jourID = $_POST['jourID'];
		else
			$jourID = $myJourID;
		$queryX = " AND jourID=$jourID ";
		$queryX .= " AND jourID=$myJourID ";
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
	
	if($myLimit != ''){
		$queryY = "LIMIT 0, $myLimit";
	}
	
	$query = "SELECT * 
				FROM cms_news 
				WHERE 1>0 "
				.$queryX.
				"AND status=0 
				 ORDER BY title ASC "
				 .$queryY;
	//echo $query;		
	$result = $siteDB->query($query);
	
	while ($row = $siteDB->fetch_array($result, 1)){
		$data[$row['entryID']] = $row;
	}
	
	$numNews = $siteDB->get_numrows();
	$siteDB->free_result();
	return $data;

}

function getLastNews($myJourID = '', $myCatID = '', $myLimit = ''){

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

	$query = "SELECT * 
				FROM cms_news
				WHERE 1>0 "
				.$queryX.
				"AND status=0 
				ORDER BY date_mod DESC "
				.$queryY;

	$result = $siteDB->query($query);
	
	while ($row = $siteDB->fetch_array($result, 1)){
		$data[$row['entryID']] = $row;
	}
	
	//$numItems = $siteDB->get_numrows();
	$siteDB->free_result();
	return $data;
				
}

// Devuelve los datos de una entrada
function getEntry($myID){
	
	global $siteDB;

	$query = "SELECT * 
				FROM cms_news 
				WHERE entryID=$myID";
			
	$result = $siteDB->query($query);
	
	$data = $siteDB->query_firstrow($query);
	
	// Error
	if(!$data)
		echo 'No existe esa entrada';
	
	$siteDB->free_result();
	return $data;
	
}

function printNewsList($myNews, $myMode = 'short'){

		global $jour, $cats, $rewriteURL;
		
		if(!$myNews)
			return '<h2>No hay ninguna entrada</h2>';

		if(!$cats)
			$cats = getCats('entryicles');
		
		$i = 0;
		foreach ($myNews as $entryID => $entry){
			
			if($myMode != 'large')
				$entryDate = convertDateU2LFormat($entry['date_mod'], "%d/%m/%Y");
			elseif($myMode == 'large')
				$entryDate = convertDateU2LFormat($entry['date_mod'], "%d de %B de %Y");
			$entryTitle = $entry['title'];
			$entryLink = $jour['path'].'/'.printGetUrl('n', $entry['entryID'], $rewriteURL);
			$entryLinkTitle = printLink($entryLink, $entryTitle);
			$entryExcerpt = $entry['excerpt'];
			if($myMode == 'short')
				$entryCat = $cats[$entry['catID']]['name'];
			$catAux = getCatParent($entry['catID'], $cats);
			$entryCatRoot = printCatRoot($catAux, 'link', $mag['path'].'/');
			
			if($myMode == 'alphabeta'){
				$firstLetter = ucfirst(substr($entry['title'], 0, 1));
				$firstLetterPrev = ucfirst(substr($myNews[$prevId]['title'], 0, 1));
				if($firstLetter != $firstLetterPrev){
					$entryEnc = '';
					if($i != 0)
						$entryEnc .= '</ul>'."\n";
					$entryEnc .= '<h2>'.$firstLetter.'</h2>'."\n";	
					$entryEnc .= '<ul class="list">'."\n";
				}
				else{
					$entryEnc = '';
				}
				$prevId = $entryID;
			}
				
				
			$entry_item = & new Template(ROOT_TMPL.'/');
			$entry_item->set('entryDate', $entryDate);
			$entry_item->set('entryTitle', $entryTitle);
			$entry_item->set('entryLink', $entryLink);
			$entry_item->set('entryLinkTitle', $entryLinkTitle);
			$entry_item->set('entryExcerpt', $entryExcerpt);
			$entry_item->set('entryEnc', $entryEnc);
			$entry_item->set('entryCat', $entryCat);
			$entry_item->set('entryCatRoot', $entryCat);
			$entry_item->set('entryJourID', $entry['jourID']);

			$newsList .= $entry_item->fetch('entry_item_'.$myMode.'.tpl'); 
				
			unset($entry_item);
			
			// Tenemos que introducir este if en la generacion de la plantilla
			if($i==0){
				$entryLastDate = $entryDate;
				$entryLastTitle = $entryTitle;
				$entryLastLink = $entryLink;
				$entryLastExcerpt = $entryExcerpt;
				
				//if($entry['imageID']){
				//	$itemImageURL = $entry['imageURL'];
				//	$itemImageData = ' alt="'.$entry['title'].'" width="'.$entry['imageW'].'" height="'.$entry['imageH'].'" ';
				//	$itemImage = 1;
				//}
			}

			$i++;
		}
		
		return $newsList;

}
?>