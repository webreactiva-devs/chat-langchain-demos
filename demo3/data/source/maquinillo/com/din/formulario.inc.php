<?php
$to="miguel@boulesis.com";
$to2="boulesis@boulesis.com";

function printForm(){
	global $name, $email, $subject, $body;
	?>
<h2>Formulario de contacto</h2>
<div class="form">
<form action="<?php echo $PHP_SELF; ?>" method="post">
  <span class="textsmall">* Campos que se deben rellenar obligatoriamente</span><br />
  <label for="name" class="text">Nombre *</label>
  <br />
  <input name="name" type="text" size="45" class="formfield" <?php if ($name) echo "value=\"$name\""; ?>/>
  <br />
  <label for="email" class="text">Correo electrónico *</label>
  <br />
  <input name="email" type="text" size="45" class="formfield" <?php if ($email) echo "value=\"$email\""; ?>/>
  <br />
  <label for="subject" class="text">Asunto del mensaje</label>
  <br />
  <input name="subject" type="text" size="45" class="formfield" <?php if ($subject) echo "value=\"$subject\""; ?>/>
  <br />
  <label for="body" class="text">Consulta *</label>
  <br />
  <textarea name="body" cols="45" rows="10" wrap="virtual" class="formtextarea"><?php if ($body) echo $body; ?></textarea>
  <br />
  <label for="submit" class="noshow">Enviar</label>
  <input name="submit" type="submit" value="Enviar" class="formbutton">
</form>
</div>	
	<?php
}

if($HTTP_GET_VARS["sub"]){
	$subject = stripslashes($HTTP_GET_VARS["sub"]);
}

if(!$_POST){
	printForm();
}


if($_POST){
	if(!$name||!$body||!$email){
		echo "<h2>Debe rellenar los campos obligatorios marcados con un *</h2>";
		printForm();
		}
	else{
		$date = strftime("%d-%m-%Y a las %H:%M", time());
		$headers = "Reply-To:$email\nFrom:$name <$email>\nBcc: $to2";
		$name = stripslashes($name);
		$email = stripslashes($email);
		$subject = stripslashes($subject);
		$body = stripslashes($body);
		if(mail($to,$subject,"$body",$headers)){
			echo "<h2>Datos enviados</h2>\n";
		    echo "<p>Gracias por su participación. Le contestaremos tan pronto como nos sea posible</p>\n";
			}
		else{
			echo "<h2>No se han podido enviar los datos</h2>\n";
			echo "<p>Se ha producido un error. <br />Inténtelo más tarde o escriba directamente a este <a href=\"mailto:".$to."\">correo electrónico</a></p>\n";
			}
		}
}
?>
