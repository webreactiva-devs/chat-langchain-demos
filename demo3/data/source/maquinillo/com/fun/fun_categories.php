<?php
// Categorias
// Categoria
function getCat($myCat, $myMode = 'id', $myGroupID = ''){

	global $siteDB, $catTree, $catNameTree;
	
	$catDiv = substr_count($myCat, '/');
	
	if($myMode != 'id'){
	if($catDiv == 0){
		$myMode = 'name';
	}
	else{
		if(!$catTree)
			$cats = getCats('articles');
		if(substr($myCat,strlen($myCat)-1,1) == '/')
			$myCat = substr($myCat,0,strlen($myCat)-1);
		
		$catNames = explode('/', $myCat);
		for($i=0;$i<count($catNames);$i++){
			$aux .= setSimpText($catNames[$i]).'/';
		}
		$aux = substr($aux,0,strlen($aux)-1);
		$myCat = $catNameTree[$aux];
		$myMode = 'id';
	}
	}
	
	if ($myMode == 'id')
		$queryX = "WHERE catID=$myCat";
	elseif ($myMode == 'name'){
		$queryX = "WHERE name LIKE '%$myCat%'";
	}
	
	if($myGroupID != ''){
		$queryX .= " AND groupsID=$myGroupID ";
	}
		
		
	$query="SELECT * 
			FROM categories "
			.$queryX. 
			" ORDER BY name DESC";
	$result = $siteDB->query($query);
	
	while ($row = $siteDB->fetch_array($result, 1)){
		$data = $row;
	}
	
	//$data = $siteDB->query_firstrow($query);
	
	$siteDB->free_result();
	return $data;
	
}



// Categorias
function getCats($myMode = 'news', $myID = '', $myGroupID = ''){

	global $siteDB, $catTree, $catNameTree;
	
	if($myGroupID != '')
		$queryZ = "WHERE groupsID = $myGroupID ";

	$query="SELECT * 
			FROM categories "
			.$queryZ.
			"ORDER BY name ASC";
	$result = $siteDB->query($query);
	
	while ($row = $siteDB->fetch_array($result, 1)){
		$data[$row['catID']] = $row;
		$catTree[$row['cat_parent']][] = $row['catID'];
	}
	$siteDB->free_result();
	
	// Registros de cada categoria según el modo
	if($myMode == 'news'){
		$table = 'cms_news';
		if($myID != '')
			$queryX = " WHERE jourID = $myID ";
		}
	elseif($myMode == 'articles'){
		$table = 'cms_articles';
		if($myID != '')
			$queryX = " WHERE jourID = $myID ";		
		}
	elseif($myMode == 'albums'){
		$table = 'cms_albums';
		if($myID != '')
			$queryX = " WHERE albumID = $myID ";		
		}
	elseif($myMode == 'links'){
		$table = 'cms_links';
		if($myID != '')
			$queryX = " WHERE linkID = $myID ";		
		}	
	elseif($myMode == 'documents'){
		$table = 'cms_documents';
		if($myID != '')
			$queryX = " WHERE docID = $myID ";		
		}	
	elseif($myMode == 'staticpages'){
		$table = 'cms_staticpages';
		if($myID != '')
			$queryX = " WHERE staticID = $myID ";		
		}				
		
	//if($myJourID != '')
	//	$queryX = "WHERE jourID = $myJourID ";
		
	
	$query="SELECT catID, COUNT(*) as numRegs  
			FROM $table "
			.$queryX.
			"GROUP BY catID";
	$result = $siteDB->query($query);
	
	while ($row = $siteDB->fetch_array($result, 1)){
		if($data[$row['catID']]['catID'] == $row['catID'])
			$data[$row['catID']]['numRegs'] = $row['numRegs'];
	}
	
	$siteDB->free_result();
	
	return $data;
	
}


// Extrae un árbol con los padres de la categoría
function getCatParent ($myCatID, $myCats = '', $i = '999'){
	
	global $catTree, $catNameTree, $myCatRoot;
	
	$myCatRoot[$i] = $myCats[$myCatID];
	
	//echo $i.': '.print_r($myCatRoot[$i]).'<br>';
	if($myCats[$myCatID]['cat_parent'])
		$myCat = getCat($myCats[$myCatID]['cat_parent'] ,'id');
	
	// Categoría sin padre
	if($myCat['cat_parent'] == 0){
		$j=$i-1;
		$myCatRoot[$j] = $myCat;
		//echo $j.': '.print_r($myCatRoot[$j]).'<br>';
		//echo 'salida<br>';
		//print_r($myCatRoot);
		return $myCatRoot;
	}
	// Categoría con padre
	else{
		getCatParent($myCat['catID'], $myCats, $i-1);
		return $myCatRoot;
	}
	
}

function printCatRoot($myCatArray, $myMode = 'name', $handler = ''){

	global $catTree, $catNameTree, $rewriteURL;
	
	//print_r($myCatArray);
	//echo $myMode;

	ksort($myCatArray);
	
	foreach($myCatArray as $key => $cat){
		if($cat){
			$myCatURL .= setSimpText($cat['name']).'/';
			if($myMode == 'link'){
				$myCatLink = $handler . printGetUrl('cat', $myCatURL, $rewriteURL);
				$myCatRoot .= printLink($myCatLink, $cat['name']).' &gt; ';
			}
			elseif($myMode == 'doc'){
				$myCatDoc = $handler . printGetUrl('cat', $myCatURL, $rewriteURL);
				$myCatRoot .= printLink($myCatDoc, $cat['name']).' &gt; ';
			}			
			elseif($myMode == 'url')
				$myCatRoot = $myCatURL;
			else
				$myCatRoot .= $cat[$myMode].'/';
		}
	}
	
	if($myMode == 'link')
		$myCatRoot = substr($myCatRoot, 0, strlen($myCatRoot)-6);
	else
		$myCatRoot = substr($myCatRoot, 0, strlen($myCatRoot)-1);
	unset($myCatArray);
	return $myCatRoot;
}



// Muestra arbol de categorias
// $myCats: array con las categorias
// $myID: ID de la categoría de $catTree por la que comenzamos a trabajar
// $myLevel: nivel de profundidad en las llamadas recursivas
// $myType: 'list' -> lista  'array' -> array para utilizar en otra función 
// $myParam: url a la que se añadirán los parametros de categoría
function printCatTree($myCats, $myID = 0, $myLevel = 1, $myType = 'list', $myParam = '', $myCatURL = ''){

	global $catTree, $catNameTree, $myData, $archiveName, $mag;
	// Si no tiene categorias hijas
	if(!$catTree[$myID]){
		return '';
	}
	// Con categorias hijas
	$myCatURL2 = $myCatURL;
	// Modo listado
	if($myType == 'list' || $myType == 'listshort'){
		$html .= '<ul>'."\n";
		foreach ($catTree[$myID] as $key => $catID){
			
			if(!$myCats[$catID]['numRegs'])
				$myCats[$catID]['numRegs'] = 0;
			// Para subcategorias
			// Si no tiene padre
			if($myCats[$catID]['cat_parent'] == 0)
				$myCatURL = setSimpText($myCats[$catID]['name']);
			// Si tiene padre	
			elseif($myCats[$catID]['cat_parent'] != 0){
				// No tenemos que buscar el padre
				if($myLevel > 1)
					$myCatURL = $myCatURL2.'/'.setSimpText($myCats[$catID]['name']);
				// Lo buscamos y luego añadimos la posición actual
				else{
					$myCatRoot = getCatParent($catID, $myCats);
					$myCatURL = printCatRoot($myCatRoot, 'url');
					$myCatURL2 = $myCatURL;
				}
			}
			
			// Elemento lista
			$html .= '<li>'.printLink(sprintf($myParam, $myCatURL), $myCats[$catID]['name']);
			if($myCats[$catID]['numRegs']!=0 || $myCats[$catID]['cat_parent']!=0)
				$html .= '('.$myCats[$catID]['numRegs'].')';
			if($myCats[$catID]['description'] && $myType == 'list')
				$html .= '<br />'.$myCats[$catID]['description'];
			$html .= '</li>'."\n";
			
			
			// Llamada recursiva para mostrar categorías hijas
			$html .= printCatTree($myCats, $catID, $myLevel +1, $myType, $myParam, $myCatURL);
		}		
		
		$html .= '</ul>'."\n";
		return $html;
	/*
	// Modo listado con plantilla
	if($myType == 'list'){
		$front_cats = & new Template(ROOT_TMPL.'/');
		
		foreach ($catTree[$myID] as $key => $catID){
			
			if(!$myCats[$catID]['numRegs'])
				$myCats[$catID]['numRegs'] = 0;
			// Para subcategorias
			if($myLevel == 1)
				$myCatURL = setSimpText($myCats[$catID]['name']);
			elseif($myLevel > 1)
				$myCatURL = $myCatURL2.'/'.setSimpText($myCats[$catID]['name']);
			
			// Elemento lista
			$cats[$catID]['namelink'] = printLink(sprintf($myParam, $myCatURL), $myCats[$catID]['name']);
			if($myCats[$catID]['numRegs']!=0 || $myLevel>1)
				$cats[$catID]['namelink'] = $myCats[$catID]['numRegs'];
			if($myCats[$catID]['description'])
				$cats[$catID]['description'] = $myCats[$catID]['description'];
			if($catTree[$catID])
				$cats[$catID]['children'] = 1;
			
			// Llamada recursiva para mostrar categorías hijas
			printCatTree($myCats, $catID, $myLevel +1, $myType, $myParam, $myCatURL);
		}		
		
		$front_cats->set('cats', $cats);
		return $front_cats->fetch('front_categories.tpl');
    	*/
	}
	// Modo menu desplegable -array para utilizar en printJump() o printFormJump()
	if($myType == 'array'){
		foreach ($catTree[$myID] as $key => $catID){
			if($myParam != '')
				$myCase = setSimpleText($myCats[$catID]['name']);
			else
				$myCase = $catID;
			$myText = $myCats[$catID]['name']; 
			if($myLevel > 1)
				$myText = str_repeat('&nbsp;&nbsp;',$myLevel).$myText;
			$myData[$myCase] = $myText;
			
			// Para arbol de nombres de categorias
			// Para subcategorias
			// Si no tiene padre
			if($myCats[$catID]['cat_parent'] == 0)
				$myCatURL = setSimpText($myCats[$catID]['name']);
			// Si tiene padre	
			elseif($myCats[$catID]['cat_parent'] != 0){
				// No tenemos que buscar el padre
				if($myLevel > 1)
					$myCatURL = $myCatURL2.'/'.setSimpText($myCats[$catID]['name']);
				// Lo buscamos y luego añadimos la posición actual
				else{
					$myCatRoot = getCatParent($catID, $myCats);
					$myCatURL = printCatRoot($myCatRoot, 'url');
				}
			}
			/*
			if($myLevel == 1)
				$myCatURL = setSimpText($myCats[$catID]['name']);
			elseif($myLevel > 1)
				$myCatURL = $myCatURL2.'/'.setSimpText($myCats[$catID]['name']);
			*/
			$catNameTree[$myCatURL] = $catID;
			
			printCatTree($myCats, $catID, $myLevel +1, 'array', $myParam, $myCatURL);

		}
		return $myData;
	}
	
}


?>