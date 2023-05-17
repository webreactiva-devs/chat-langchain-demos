<?php
// Funciones para documentos

// Devuelve los datos de los enlaces
function getDocs($myMode='all', $myCatID = '', $myDate = '', $myLimit = ''){
	
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
				FROM cms_documents  
				WHERE 1>0 "
				.$queryX.
				" ORDER BY title ";
	// echo $query;		
	$result = $siteDB->query($query);
	
	while ($row = $siteDB->fetch_array($result, 1)){
		$data[$row['docID']] = $row;
		$data[$row['docID']]['username'] = getUserName($row['userID']);
	}
	
	$numItems = $siteDB->get_numrows();
	$siteDB->free_result();
	return $data;

}

// Últimos enlaces
function getLastDocs($myCatID = '', $myLimit = 5, $myUserID = ''){

	global $siteDB;
	
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
				FROM cms_documents
				WHERE 1>0 "
				.$queryX.
				"AND status=0 
				ORDER BY date DESC "
				.$queryY;
						
	$result = $siteDB->query($query);
	
	while ($row = $siteDB->fetch_array($result, 1)){
		$data[$row['docID']] = $row;
		$data[$row['docID']]['username'] = getUserName($row['userID']);
	}
	
	$siteDB->free_result();
	
	return $data;

}

// Devuelve datos sobre un enlace
function getDoc($myID){
	
	global $siteDB;

	$query = "SELECT * 
				FROM cms_documents 
				WHERE docID=$myID ";
			
	$data = $siteDB->query_firstrow($query);
	$data['username'] = getUserName($data['userID']);
	
	$siteDB->free_result();
	return $data;

}

function printDocs($myData, $myMode = 'large'){
	
	global $mag, $cats, $rewriteURL, $txt, $groupID;
	
	if(!$cats)
		$cats = getCats('documents', '', $groupID);
	
	foreach ($myData as $docID => $doc){
	
		$doc['name'] = implode('.', getName($doc['url']));	
		$doc['ext'] = end(getName($doc['url']));
		
		if($myMode == 'large')
			$doc['size'] = getDocSize($doc['url']);
		$doc['link'] = '/didactica/documentos/'.printGetUrl('d', $doc['docID'], $rewriteURL);

		if($myMode == 'short'){
			$docCats = getCat($doc['catID']);
		}
	
		$doc_item = & new Template(ROOT_TMPL.'/');
		$doc_item->set('docTitle', $doc['title']);
		$doc_item->set('docLink', $doc['link']);
		$doc_item->set('docDate', convertDateU2LFormat($doc['date'], "%d/%m/%Y"));
		$doc_item->set('docSize', $doc['size']);
		$doc_item->set('docName', $doc['name']);
		$doc_item->set('docCat', $docCats['name']);
		$doc_item->set('docExt', $doc['ext']);
		$doc_item->set('docExtDesc', $txt['arch'.$myDoc[ext]]);
		$doc_item->set('docDesc', $doc['description']);
		$doc_item->set('docUserID', $doc['userID']);
		$doc_item->set('docUserName', $doc['username']);
		if($myMode == 'short')
			$docList .= $doc_item->fetch('doc_item_short.tpl');
		elseif($myMode == 'large')
			$docList .= $doc_item->fetch('doc_item.tpl'); 
		
	}
	
	return $docList;
}

function printDoc($myDoc){

		global $txt;
	
		$myDoc['name'] = implode('.', getName($myDoc['url']));	
		$myDoc['ext'] = end(getName($myDoc['url']));
		$myDoc['size'] = getDocSize($myDoc['url']);

		$optionsBox = printOptionsBox($myDoc['title'], 0, 0, array($myDoc['userID'],$myDoc['username']));
		
		$doc_item = & new Template(ROOT_TMPL.'/');
		$doc_item->set('docTitle', $myDoc['title']);
		$doc_item->set('docID', $myDoc['docID']);
		$doc_item->set('optionsBox', $optionsBox);
		$doc_item->set('docName', $myDoc['name']);
		$doc_item->set('docURL', $myDoc['url']);
		$doc_item->set('docLink', $myDoc['link']);
		$doc_item->set('docRelLink', $myDoc['related_link']);
		$doc_item->set('docDate', convertDateU2LFormat($myDoc['date'], "%d/%m/%Y"));
		$doc_item->set('docSize', $myDoc['size']);
		$doc_item->set('docExt', $myDoc['ext']);
		$doc_item->set('docExtDesc', $txt['arch'.$myDoc[ext]]);
		$doc_item->set('docDesc', $myDoc['description']);
		$doc_item->set('docUserID', $myDoc['userID']);
		$doc_item->set('docUserName', $myDoc['username']);
		$docItem = $doc_item->fetch('doc_single.tpl');

	
	return $docItem;

}

function getName ($myPath){
	
	$myFile = basename($myPath);
	$myName = explode('.', $myFile);
	return $myName;
	
}

function getDocSize($myPath, $myFormat = 'normal'){
	
	$myPath = str_replace ('http://www.boulesis.com', '', $myPath);
	$myPath = str_replace ('http://boulesis.com', '', $myPath);
	$myPath = str_replace ('http://boulesis', '', $myPath);
	
	/*$fp = @fopen($myPath, 'rb');
	if($fp != false){
		$s = fread($fp, 10000000);
		fclose($fp);
		$size = strlen($s);
	}*/
	$size = @filesize(ROOT_GLOBAL.$myPath);

	if($myFormat == 'normal')
		$mySize = bytesToHumanReadableUsage($size);
	elseif($myFormat == 'numeric')
		$mySize = $size;
	return $mySize;
	
}

/**
* Converts bytes to a human readable string
* @param int $bytes Number of bytes
* @param int $precision Number of decimal places to include in return string
* @param array $names Custom usage strings
* @return string formatted string rounded to $precision
*/
function bytesToHumanReadableUsage($bytes, $precision = 2, $names = '')
{
   if (!is_numeric($bytes) || $bytes < 0) {
       return false;
   }
       
   for ($level = 0; $bytes >= 1024; $level++) {    
       $bytes /= 1024;      
   }
   
   switch ($level)
   {
       case 0:
           $suffix = (isset($names[0])) ? $names[0] : 'Bytes';
           break;
       case 1:
           $suffix = (isset($names[1])) ? $names[1] : 'KB';
           break;
       case 2:
           $suffix = (isset($names[2])) ? $names[2] : 'MB';
           break;
       case 3:
           $suffix = (isset($names[3])) ? $names[3] : 'GB';
           break;      
       case 4:
           $suffix = (isset($names[4])) ? $names[4] : 'TB';
           break;                            
       default:
           $suffix = (isset($names[$level])) ? $names[$level] : '';
           break;
   }
   
   if (empty($suffix)) {
       trigger_error('Unable to find suffix for case ' . $level);
       return false;
   }
   
   return round($bytes, $precision) . ' ' . $suffix;
}


?>