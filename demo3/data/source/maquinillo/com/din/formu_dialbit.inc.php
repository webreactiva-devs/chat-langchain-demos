<?php
$to="dialbit_alta@boulesis.com";
$to2="dialbit@boulesis.com";

function printForm(){
	global $name, $email, $url, $body;
	?>
<h2>Apúntate a DialBit</h2>
<p>No hace falta que tengas una página web para participar. Tan sólo queremos saber quién participa
en esta iniciativa de <em>boulé</em>. Cuando recibamos tus datos te contestaremos y te añadiremos
a la lista de <a href="/boule/dialbit/participantes.php">participantes</a> en el diálogo. Gracias anticipadas por tu interés.</p>
<div class="form">
<form action="<?php echo $PHP_SELF; ?>" method="post">
  <label for="name" class="text">Nombre o nick</label>
  <br />
  <input name="name" type="text" size="45" class="formfield" <?php if ($_POST[name]) echo "value=\"$_POST[name]\""; ?>/>
  <br />
  <label for="email" class="text">Correo electrónico <span class="textsmall">(Campo obligatorio)</span>
  </label>
  <br />
  <input name="email" type="text" size="45" class="formfield" <?php if ($_POST[email]) echo "value=\"$_POST[email]\""; ?>/>
  <br />
  <label for="webname" class="text">Nombre de la página</label>
  <br />
  <input name="webname" type="text" size="45" class="formfield" <?php if ($_POST[url]) echo "value=\"$_POST[webname]\""; ?>/>
  <br />  
  <label for="url" class="text">Página web</label>
  <br />
  <input name="url" type="text" size="45" class="formfield" <?php if ($_POST[url]) echo "value=\"$_POST[url]\""; else echo "value=\"http://\""?>/>
  <br />
  <label for="coms" class="text">Comentarios</label>
  <br />
  <textarea name="coms" cols="40" rows="5" wrap="virtual" class="formtextarea"><?php if ($_POST[coms]) echo $_POST[coms]; ?></textarea>
  <br />
  <label for="submit" class="noshow">Enviar</label>
  <input name="submit" type="submit" value="Enviar" class="formbutton">
</form>
</div>	
	<?php
}

if($_GET["sub"]){
	$subject = stripslashes($_GET["sub"]);
}

if(!$_POST){
	printForm();
}


if($_POST){
	if(!$_POST[email]){
		echo "<h2>Debe rellenar los campos obligatorios marcados con un *</h2>";
		printForm();
		}
	else{
		$date = strftime("%d-%m-%Y a las %H:%M", time());
		if(!$_POST[name])
			$name = "Anonimo";
		else
			$name = stripslashes($_POST[name]);
		$headers = "Reply-To:$email\nFrom:$name <$email>";
		$email = stripslashes($_POST[email]);
		$subject = "[DialBit] Nuevo participante";
		$body = "
Nombre: $name 
Email: $email 
Web: $_POST[webname] 
Url: $_POST[url] 
Comentarios: $_POST[coms]";
		if(mail($to,$subject,"$body",$headers)){
			echo "<h2>Datos enviados</h2>\n";
		    echo "<p>Muchas gracias por tu participación. Te contestaremos tan pronto como nos sea posible</p>\n";
			
			// Envia mensaje de autorespuesta
			$subject = '[DialBit] Bienvenido a nuestro diálogo';
			
			$fp = fopen(ROOT_INC.'/data/email_auto_dialbit_alta.inc', "rb");
			$body = '';
			while(!feof($fp)){
				$body .= fgets($fp, 1024);
			}
			fclose($fp);
			
			$headers = "Reply-To:$to\nFrom:DialBit <$to>";
			$to = $email;
			mail($to,$subject,"$body",$headers);
			
			include (ROOT_GLOBAL."/boule/dialbit/logos.htm");
			}
		else{
			echo "<h2>No se han podido enviar los datos</h2>\n";
			echo "<p>Se ha producido un error. <br />Inténtelo más tarde o escriba directamente a este <a href=\"mailto:".$to2."\">correo electrónico</a></p>\n";
			}
		}
}
?>
