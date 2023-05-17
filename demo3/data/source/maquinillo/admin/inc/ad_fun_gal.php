<?php
// Funciones de galeria de fotos

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

// Mostrar formulario de album
function printFormAlbum($myData = ''){

	global $catTree;

	// El grupo de los albums siempre el mismo
	$myData['groupID'] = 99;
	
	if(!isset($myData['date']))
		$myData['date']=convertDateU2L(date("U"));
	else
		$myData['date']=convertDateU2L($myData['date']);		
	
	// Usuarios
	if(!$myData['userID'])
		$myData['userID'] == $_SESSION['userID'];
	
	$data = getCats('albums', $myData['groupID']);
	$cats = printCatTree($data, 0, 1, 'array');
	
	echo '<div class="form">'."\n";
	$form = new Form('formalbum');
	$form->printFieldset('Datos del álbum');
	$form->addField('text', 'title', 'Título', $myData['title']);
	$form->addTextarea('description', 'Descripción', $myData['description'], '', 65, 3);
	$form->addField('text', 'date', 'Fecha', $myData['date']);
	
	$select .= '<label for="catID">Categorías</label><br />';
	$select .= printJump($cats, $myData['catID'], '%d', '', 'catID').'<br />';
	echo $select;
	
	$select = '<label for="userID">Autor</label><br />';
	$select .= printJumpUsers('', $myData['userID']).'<br />';
	echo $select;	
	
	$form->addField('text', 'imageID', 'Imagen de portada', $myData['imageID'], '10');
	if($_GET['action'] == 'addalbum')
		$buttext = 'Añadir';
	elseif($_GET['action'] == 'editalbum')
		$buttext = 'Editar';
	$form->addField('submit', 'btn_album', $buttext, $buttext);
	$form->endForm();
	echo '</div>'."\n";
	
	return;
}

function printListAlbums ($myData = '', $myCase = 'albums'){

	global $numItems;
	foreach ($myData as $id => $data){
		
		$sufaction = 'album';
		$photos = getPhotos('albumid', $id);
		$cover = getCoverImage($data['imageID'],$id);

		$html .= '<div class="item">'."\n";
		$html .= '<a href="'.DIR_ADMIN.'/gals/photolist.php?albumid='.$id.'"><img src="'.$cover['path_thumb'].'" alt="'.$cover['title'].'" border="1" align="left"></a>'."\n";
		$html .= '<strong>'.$data['title'].'</strong><br />';
		$html .= $data['description'].'<br />';
		$html .= printLinkAction('edit'.$sufaction,$myCase,$id, 'Editar').' | ';
		$html .= printLinkAction('delete'.$sufaction,$myCase,$id, 'Borrar').'<br />';
		$html .= $numItems.' entradas | ';
		$html .= '<a href="'.DIR_ADMIN.'/gals/photopro.php?action=addphoto&albumid='.$id.'">Añadir foto</a> | ';
		$html .= '<a href="'.DIR_ADMIN.'/gals/photolist.php?albumid='.$id.'">Ver fotos</a>';
		$html .= ' :: <a href="/galeria" target="_blank" >Ver álbum</a><br />';
		
		$html .= '</div>'."\n";
	
	}
	
	return $html; 
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

// Muestra el formulario de imagen
function printFormPhoto ($myData = ''){

	global $catTree;
	
	// Número de archivos
	if($_POST['numfiles'])
		$numfiles = $_POST['numfiles'];
	elseif($myData['num_files'])
		$numfiles = $myData['num_files'];
	else
		$numfiles = 1;

	// Fecha
	for($i=0;$i<$numfiles;$i++){	
		if(!isset($myData['date'][$i]))
			$myData['date'][$i]=convertDateU2L(date("U"));
		elseif(isset($myData['date']) && !is_array($myData['date']))
			$myData['date']=convertDateU2L($myData['date']);
	}
	
	// Tamaños de imagen y calidad
	if($_POST){
		$imageMX = $_POST['imageMX'];
		$imageMY = $_POST['imageMY'];
		$thumbMX = $_POST['thumbMX'];
		$thumbMY = $_POST['thumbMY'];
		$quality = $_POST['quality'];
	}
	else{
		$imageMX = RESIZE_WIDTH;
		$imageMY = RESIZE_HEIGHT;
		$thumbMX = MAX_WIDTH;
		$thumbMY = MAX_HEIGHT;
		$quality = 75;
	}					
		
	// Etiqueta del botón
	if($_GET['action'] == 'addphoto')
		$buttext = 'Añadir';
	elseif($_GET['action'] == 'editphoto')
		$buttext = 'Editar';

	echo '<div class="form">'."\n";
	$form = new Form('photos','','','multipart/form-data');
	
	if($_GET['action'] == 'addphoto'){
		echo '<div style="text-align:right;">'."\n";
		echo 'Nº de imágenes: ';
		echo printJump('', $numfiles, '', 'auto', 'numfiles', 'photos');
		echo '</div>'."\n";
		$form->printFieldset('Tamaños');
		echo '<span>Campos vacíos para no aplicar cambios de tamaño y no crear thumbnail</span><br />';
		$form->addField('text', 'imageMX', 'Ancho imagen máximo', $imageMX, 10);
		$form->addField('text', 'imageMY', 'Alto imagen máximo', $imageMY, 10);
		$form->addField('text', 'thumbMX', 'Ancho thumbnail máximo', $thumbMX, 10);
		$form->addField('text', 'thumbMY', 'Alto thumbnail máximo', $thumbMY, 10);	
		$form->addField('text', 'quality', 'Calidad (solo JPG)', $quality, 10);	
		$form->addField('hidden', 'albumid', '', $_GET['albumid']);
	
		for($i=0;$i<$numfiles;$i++){
			$form->printFieldset('Fotografía '.intval($i+1));
			$form->addField('file', 'image[]', 'Archivo', $myData['file'][$i], 50);
			$form->addField('text', 'title[]', 'Título', $myData['title'][$i], 50);
			$form->addTextarea('description[]', 'Descripción', $myData['description'][$i], '', 65, 3);
			$form->addField('text', 'path_image[]', 'Ubicación foto', $myData['path_image'][$i], 50);		
			$form->addField('text', 'path_thumb[]', 'Ubicación thumbnail', $myData['path_thumb'][$i], 50);		
			$form->addField('text', 'date[]', 'Fecha', $myData['date'][$i], 20);

			if($myData == '')
				$mySelect[$i][0]=1;
			else{
				$aux = $myData['status'][$i];
				$mySelect[$i][$aux]=1;
				}
			$myData['status_s'][0]='Visible';
			$myData['status_s'][1]='Invisible';	
			$form->addSelect('status[]', 'Estado', $myData['status_s'], $mySelect[$i]);
			$form->addField('checkbox', 'coverimage[]', 'Portada de album', $myData['coverimage'][$i]);
			
			// Usuarios
			if(!$myData['userID'][$i])
				$myData['userID'][$i] == $_SESSION['userID'];
			
			$select = '<label for="userID[]">Autor</label><br />';
			$select .= printJumpUsers('', $myData['userID'][$i], 'userID[]').'<br />';
			echo $select;
		}
	}
	
	elseif($_GET['action'] == 'editphoto'){
		echo '<img src="'.$myData['path_image'].'" alt="'.$myData['title'].'" border="1" /><br /><br />';
		$form->addField('text', 'title', 'Título', $myData['title'], 50);
		$form->addTextarea('description', 'Descripción', $myData['description'], '', 65, 3);
		$form->addField('text', 'path_image', 'Ubicación foto', $myData['path_image'], 50);		
		$form->addField('text', 'path_thumb', 'Ubicación thumbnail', $myData['path_thumb'], 50);		
		$form->addField('text', 'date', 'Fecha', $myData['date'], 20);

		if($myData == '')
			$mySelect[$i][0]=1;
		else{
			$aux = $myData['status'][$i];
			$mySelect[$i][$aux]=1;
			}
		$myData['status_s'][0]='Visible';
		$myData['status_s'][1]='Invisible';	
		$form->addSelect('status', 'Estado', $myData['status_s'], $mySelect[$i]);

		$select = '<label for="userID">Autor</label><br />';
		$select .= printJumpUsers('', $myData['userID']).'<br />';
		echo $select;				
	}
	

	$form->addField('submit', 'btn_photo', $buttext, $buttext);
	$form->endForm();
	
	echo '</div>'."\n";

	return;
}

// Imprime la tabla con fotografias
function printListPhotos($myData){
	
	$i = -1;
	$sufaction = 'photo';
	$myCase = 'photos';
	foreach ($myData as $id => $data){
		
		if($i==-1){
			$html = '<table width="90%" align="center" cellpadding="2" cellspacing="0">'."\n";
			$i = 0;
		}
		if($i==0)
			$html .= '<tr>'."\n";
		
		$html .= '<td align="center">'."\n";
		$html .= '<a href="'.DIR_ADMIN.'/gals/photopro.php?action=editphoto&photoid='.$id.'&albumid='.$data['albumID'].'"><img src="'.$data['path_thumb'].'" alt="'.$data['title'].'" border="1"></a><br />';
		$html .= printLinkAction('view'.$sufaction,$myCase,$id).' | ';
		$html .= printLinkAction('edit'.$sufaction,$myCase,$id).' | ';
		$html .= printLinkAction('delete'.$sufaction,$myCase,$id).'</td>'."\n";
		
		if($i==3){
			$html .= '</tr>'."\n";
			$i=0;
			}
		else{
			$i++;
		}
	}
	$html .= '</table>'."\n";
	return $html; 

}

// Marca la imagen seleccionada como portada de album
function setCoverImage($myImageID, $myAlbumID){

	global $siteDB;
	
	$query = "UPDATE cms_albums 
				SET imageID=$myImageID 
				WHERE albumID=$myAlbumID";
			
	$result = $siteDB->query($query);
	
	if($result)
		printMsg('Imagen establecida como portada de album');	
	
	$siteDB->free_result();

	return;
	
}

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

// Coloca la imagen y realiza las modificaciones necesarias
function uploadImage($j, $imageMX = '', $imageMY = '', $thumbMX = '', $thumbMY = ''){

	global $imageMX, $imageMY, $thumbMX, $thumbMY;
	$fileName = $_FILES['image']['name'][$j];
	$albumID = $_GET['albumid'];
	$pathTemp = ROOT_PATH.IMAGE_BASE.'/temp';
	$imagePath = ROOT_PATH.IMAGE_BASE.'/'.$albumID;
	$thumbPath = ROOT_PATH.THUMB_BASE.'/'.$albumID;
	
	// Comprobación de variables globales
	if (!$_POST)
		return false;
	
	// Comprobamos que la imagen no existe
	if(file_exists($imagePath.'/'.$fileName)){
		printError('La imagen ya existe');
		return false;
	}	
		
	// Modificaciones que queremos hacer
	if($imageMX == '' && $imageMY == '')
		$okResize = 0;
	else
		$okResize = 1;
	if($_POST['path_image'][$j] != '' )
		$okImg = 0;
	else
		$okImg = 1;
	if($thumbMX == '' && $thumbMY == '')
		$okThumb = 0;
	else
		$okThumb = 1;
	if($_POST['quality'])
		$quality = $_POST['quality'];
	else
		$quality = 75;
		
	// Imagen temporal
	echo $okImg;
	if($okImg == 0){
		$fileName = end(explode('/',$_POST['path_image'][$j]));
		echo $fileName;
		copy($_POST['path_image'][$j], $pathTemp.'/'.$fileName);
	}
	else
		copy($_FILES['image']['tmp_name'][$j], $pathTemp.'/'.$fileName);
	// Objeto de imagen
	$img = new thumbnail($pathTemp.'/'.$fileName);	
	$img->jpeg_quality($quality);	
	
	// Imagen
	if($okResize == 1){
		$comp = compareImgSize($img->img['x'], $img->img['y'], $imageMX, $imageMY);
		if($comp > 0){
			if($comp == 1)
				$img->size_width($imageMX);
			else
				$img->size_height($imageMY);
		}
	}
	
	$img->save($imagePath.'/'.$fileName);
	printMsg('Imagen grabada con éxito');
	$img->printimg($imagePath.'/'.$fileName);
	
	// Reestablecemos calidad para thumbnail
	$img->jpeg_quality(70);	
	
	// Thumbnail
	if($okThumb == 1){
		$comp = compareImgSize($img->img['x'], $img->img['y'], $thumbMX, $thumbMY);
		if($comp > 0){
			if($comp == 1)
				$img->size_width($thumbMX);
			else
				$img->size_height($thumbMY);
		}
		$img->save($thumbPath.'/'.$fileName);
		printMsg('Thumbnail creado con éxito');
		$img->printimg($thumbPath.'/'.$fileName);
	}
	
	unlink($pathTemp.'/'.$fileName);
	
	return;
}

function compareImgSize($x, $y, $mx, $my){

	if($x>$mx && $y>$my){
		if($x>$y)
			return 1;
		else
			return 2;
		}
	else
		return 0;
}


?>