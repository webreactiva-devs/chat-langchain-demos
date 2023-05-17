<?php
// Funciones para formularios

function printFormRecommend($myPrintUrl = ''){

	// Generamos la URL de la página recomendada
	$totalUrl = HOST_GLOBAL . $myPrintUrl;
	
	if ($_POST[subject]){
		$subject=$_POST[subject];
	}
	else{
		$subject=$totalUrl;
	}
	
	if ($_POST['body']){
		$body = $_POST['body'];
	}
	
	elseif($_GET['tema'] == 'firmasfilo'){
		$body = '¡Hola!
Hay una campaña para salvar la asignatura de filosofía en la educación secundaria. Te recomiendo que visites está página y que colabores con esta campaña:
http://www.boulesis.com/firmas/

¡Gracias!';
	}
	
	// Si no hemos mandado la recomendación, la creamos
	else{
		$body = printBodyRecommend($totalUrl); 
	}
	

	?>
<div class="form">
<h2>Recomendar una página a un amigo/a</h2>
<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
	<span class="textsmall">Recuerde que hay que rellenar todos los campos</span>
  <br />
  <label for="name" class="text">Su nombre</label>
  <br />
  <input name="name" type="text" size="45" class="formfield" <?php if ($_POST[name]) echo "value=\"$_POST[name]\""; ?>/>
  <br />
  <label for="email" class="text">Su correo electrónico</label>
  <br />
  <input name="email" type="text" size="45" class="formfield" <?php if ($_POST[email]) echo "value=\"$_POST[email]\""; ?>/>
  <br />
  <label for="nameto" class="text">Nombre de su amigo/a</label>
  <br />
  <input name="nameto" type="text" size="45" class="formfield" <?php if ($_POST[nameto]) echo "value=\"$_POST[nameto]\""; ?>/>
  <br />
  <label for="emailto" class="text">Correo electrónico de su amigo/a</label>
  <br />
  <input name="emailto" type="text" size="45" class="formfield" <?php if ($_POST[emailto]) echo "value=\"$_POST[emailto]\""; ?>/>
  <br />
  <input name="subject" type="hidden" size="45" class="formfield" <?php if ($subject) echo "value=\"$subject\""; ?>/>
  <label for="body" class="text">Texto de recomendación (puede cambiarlo)</label><br />
  <span class="textsmall"><em>Al enviar la recomendación añadiremos su nombre y el de su amigo/a</em></span>
  <br />
  <textarea name="body" cols="35" rows="10" wrap="virtual" class="formtextarea"><?php if ($body) echo $body; ?></textarea>
  <br />
  <label for="submit" class="noshow">Enviar</label>
  <input name="submit" type="submit" value="Enviar" class="formbutton">
</form>
</div>
<?php
	return;
}

function printBodyRecommend($totalUrl = '', $name = '', $nameto = '', $bodyPersonal = ''){

		$email_body = & new Template(ROOT_TMPL.'/');
		$email_body->set('totalUrl', $totalUrl);
		if($nameto != '')
			$email_body->set('nameto', $nameto);
		if($bodyPersonal != '')
			$email_body->set('bodyPersonal', $bodyPersonal);
		if($name != '')
			$email_body->set('name', $name);
		return $email_body->fetch('email_recommend.tpl'); 

}

/* FUNCIONES DE VALIDACIÓN DE FORMULARIOS */

/* Imprime una cadena de error y pone en false la variable que controla toda la validación del formulario */
function set_error($error) {
	global $form_valido;
	$form_valido = false;
	echo "<p class=\"error\">&raquo; $error</p>\n";
}

/* Valida una cadena de texto, comprueba si está vacía y la limpia */
function valida_texto($texto="", $tam = '') {
	if (!$texto) return false;
	if ($tam!='' && strlen($texto) > $tam)
		return false;
	$texto = trim($texto);
	$texto = ucfirst($texto);
	$texto = nl2br($texto);
	
	return $texto;
}

/* Valida una URL */
function valida_url($url) {	

	global $errorurl;
	// Inicializo la variable de validación
	$valida=true;
	$long=strlen($url);

	// Dos puntos en la URL como en www.dominio.com
	$puntos=0;
	for($i=0;$i<=$long;$i++){
		if(substr($url, $i, 1)=='.'){
			$puntos+=1;
		}	
	}	
	if($puntos<2){
		// Pone las www
		if(ereg("(http://)(.*)",$_POST['url'],$mejorada))
			$_POST['url']=$mejorada[1]."www.".$mejorada[2];
		else 
			$_POST['url']="www.".$_POST['url'];
	}
	
	// Cadena http:// al comienzo
	if(substr($url, 0, 7)!='http://'){
		$_POST['url']="http://".$_POST['url'];
	}
	// Último caracter no debe ser una slash /
	if(substr($url, -1)=='/')
		$_POST['url']=substr_replace($_POST['url'],"", strlen($_POST['url'])-1,1);
	
	// Caracteres generales correctos
	if(preg_match('/^(https?|ftp|news)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $url)==false){
		$valida=false;
		$errorurl.='URL no válida<br />';
	}
		
	return $valida;	
}


/* Valida un combobox */
function valida_combo($valor) {
	if ($valor==0) return false; 
	return true;
}

function valida_email($email){

	if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email))
        return false;      
	else 
    	return true; 
         
}

function valida_archivo($archivo, $exts, $sizemax){

	if($archivo['size'] > $sizemax){
		set_error('Archivo demasiado grande. Límite 150 KB');
		return false;
	}
	
	$aux = explode('.', $archivo['name']);
	$aux2 = count($aux) - 1;
	$archivoext = $aux[$aux2];

	$conc = array_search($archivoext, $exts);
	foreach ($exts as $ext)
		$mssg .= $ext.' ';

	if($conc == false){
		set_error('El tipo de archivo no es correcto. Admitimos solo '.$mssg);
		return false;
	}
}

/* Ejecuta las funciones de validación una a una y devuelve un error cuando falla algo */
function valida_form_firmas($nombre="",$apellidos ="", $email="") {
	
	global $errorurl;
	
	if(!valida_texto($nombre)) set_error("Debes especificar un nombre");
	if(!valida_texto($apellidos)) set_error("Debes especificar tus apellidos");
	//if(!valida_email($email)) set_error("Debes especificar un correo electrónico correcto (Ej: <em>minombre@hotmail.com</em>)");

return;

}


function valida_form($nombre="",$url="",$autor="",$email="",$descripcion="",$provincia="", $ciudad='',$categoria="") {
	
	global $errorurl;
	
	if(!valida_texto($nombre)) set_error("Debes especificar un nombre para tu blog");
	if(!valida_url($url)) set_error($errorurl);
	if(!valida_texto($autor)) set_error("Debes especificar un autor");
	if(!valida_email($email)) set_error("Debes especificar un correo electrónico correcto (Ej: <em>minombre@hotmail.com</em>)");
	if(!valida_texto($descripcion, 250)) set_error("Debes escribir una descripción del blog. Recuerda que no deben ser más de 240 caracteres.");
	if(!valida_combo($provincia)) set_error("No has especificado una provincia. Si es una provincia de España y no es de Castilla y León escoge la opción 'Otra'");
	if(!valida_texto($ciudad)) set_error("Debes escribir la localidad (ciudad o pueblo) donde vives");	
	//if(!valida_combo($mes)) set_error("Error en la fecha de inicio, debes especificar un mes");
	//if(!valida_combo($anio)) set_error("Error en la fecha de inicio, debes especificar un año");
	if(!valida_combo($categoria)) set_error("No has seleccionado una categoría para el blog");

}



?>