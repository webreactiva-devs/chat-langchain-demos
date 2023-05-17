<?php
// Funciones de paginas estaticas
function setPathStaticpage($myHandler = '/historial'){

	global $siteDB;
	
	$pathStatic = dirname($_SERVER['SCRIPT_NAME']); 
	$urlStatic = 'http://'.HOST_GLOBAL.$pathStatic; 


	if(substr_count($pathStatic, '/')>1)
		$pathStatic =  str_replace($myHandler, '', $urlStatic);
	$query="SELECT * FROM cms_staticpages WHERE url='$urlStatic'";

	$data = $siteDB->query_firstrow($query);

	$siteDB->free_result();
	return $data;
}





function getStaticpages($myMode='all', $myStaticID = '', $myCatID = '', $myDate = '', $myLimit = ''){
	
	global $siteDB, $numNews;
	
	if($myMode == 'all'){
		$queryX = "";
	}
	
	if($myMode == 'search'){
		$keywords = setSearch($_POST['q'], 'title');
		$queryX = " AND title LIKE '%".$keywords."%' ";
		if($myStaticID !=''){
			$queryX .= " AND staticID=$myStaticID ";
		}			
	}

	
	if($myMode == 'staticID'){
		if($_POST['staticID'])
			$staticID = $_POST['staticID'];
		else
			$staticID = $myStaticID;
		$queryX = " AND staticID=$staticID ";
		$queryX .= " AND staticID=$myStaticID ";
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
				FROM cms_staticpages 
				WHERE 1>0 "
				.$queryX.
				"AND status=0 
				 ORDER BY title ASC "
				 .$queryY;
	//echo $query;		
	$result = $siteDB->query($query);
	
	while ($row = $siteDB->fetch_array($result, 1)){
		$data[$row['staticpageID']] = $row;
	}
	
	$numNews = $siteDB->get_numrows();
	$siteDB->free_result();
	return $data;

}

function getLastStaticpages($myStaticID = '', $myCatID = '', $myLimit = ''){

	global $siteDB;
	
	if($myStaticID != ''){
		$queryX .= " AND staticID=$myStaticID ";
	}	
	
	if ($myCatID != ''){
		$queryX .= " AND catID=$myCatID ";
	}
	
	if($myLimit != ''){
		$queryY = "LIMIT 0, $myLimit";
	}

	$query = "SELECT * 
				FROM cms_staticpages
				WHERE 1>0 "
				.$queryX.
				"AND status=0 
				ORDER BY date_mod DESC "
				.$queryY;

	$result = $siteDB->query($query);
	
	while ($row = $siteDB->fetch_array($result, 1)){
		$data[$row['staticpageID']] = $row;
	}
	
	//$numItems = $siteDB->get_numrows();
	$siteDB->free_result();
	return $data;
				
}



function printStaticpagesList($myStaticpages, $myMode = 'short'){

		global $static, $cats, $rewriteURL;
		
		if(!$myStaticpages)
			return '<h2>No hay ninguna entrada</h2>';

		if(!$cats)
			$cats = getCats('staticpages');
		
		$i = 0;
		foreach ($myStaticpages as $entryID => $entry){

			if($myMode != 'large')
				$entryDate = convertDateU2LFormat($entry['date_mod'], "%d/%m/%Y");
			elseif($myMode == 'large'){
				$entryDate = convertDateU2LFormat($entry['date_mod'], "%d de %B de %Y");
				$entryUserName = getUserName($entry['userID']);
				}

			$entryTitle = $entry['title'];
			$entryLink = $entry['url'];
			$entryLinkTitle = printLink($entryLink, $entryTitle);
			$entryExcerpt = $entry['description'];
			if($myMode == 'short')
				$entryCat = $cats[$entry['catID']]['name'];
			$catAux = getCatParent($entry['catID'], $cats);
			$entryCatRoot = printCatRoot($catAux, 'link', $static['path'].'/');
			
			if($myMode == 'alphabeta'){
				$firstLetter = ucfirst(substr($entry['title'], 0, 1));
				$firstLetterPrev = ucfirst(substr($myStaticpages[$prevId]['title'], 0, 1));
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
			$entry_item->set('artDate', $entryDate);
			$entry_item->set('artTitle', $entryTitle);
			$entry_item->set('artLink', $entryLink);
			$entry_item->set('artLinkTitle', $entryLinkTitle);
			$entry_item->set('artExcerpt', $entryExcerpt);
			$entry_item->set('artEnc', $entryEnc);
			$entry_item->set('artCat', $entryCat);
			$entry_item->set('artUserID', $entry['userID']);
			$entry_item->set('artUserName', $entryUserName);
			$entry_item->set('artCatRoot', $entryCat);
			$entry_item->set('artJourID', $entry['staticID']);

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