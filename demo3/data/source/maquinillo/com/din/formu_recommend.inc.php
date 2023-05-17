<?php
// Formulario de recomendación
require(ROOT_INC.'/fun/fun_forms.php');

$refURL = REF_URL;
getDateNow();
$webmasterEmail = "webmaster@boulesis.com";


// Si no hemos enviado el formulario
if(!$_POST['submit']){
	
	checkReferer(HOST_GLOBAL, $refURL);
	
	if($_GET['url']){
		$printUrl = $_GET['url'];
		printFormRecommend($printUrl);
		}
	else
		printFormRecommend();
	
}

// Si hemos enviado el formulario
elseif($_POST['submit']){

	if(!$_POST['name']||!$_POST['body']||!$_POST['email']||!$_POST['nameto']||!$_POST['emailto']){
		showError("Debe rellenar todos los campos obligatoriamente");
		printFormRecommend($printUrl);
		}
	else{
		$date = convertDateU2LFormat(time(), "%d/%m/%Y a las %H:%M");
		$email = stripslashes($_POST[email]);
		$name = stripslashes($_POST['name']);
		$to = $_POST['emailto'];
		$bodyPersonal = stripslashes($_POST['body']);

		//$emailBody = printBodyRecommend($totalUrl, $name, $nameto, $bodyPersonal); 
		$emailBody = $bodyPersonal;  
		
		$headers = "Reply-To:$email\nFrom:$name <$email>";
		$subject = 'Te recomiendo que visites '.$siteName;
			
		$emailBodyMaster = $emailBody."\n\n".$to;
		// Para el webmaster
		
		if(mail($to,$subject,"$emailBody",$headers)){
			echo "<h1>Datos enviados</h1>\n";
		    echo "<p class=\"text\">Gracias por su confianza. Su recomendación ha sido enviada</p>\n";
			echo "<p class=\"text\">Puede volver <a href=\"$_SERVER[HTTPREFERER]\">atrás</a></p>\n";
			mail($webmasterEmail,$subject,"$emailBodyMaster",$headers);
			}
		else{
			echo "<h1>No se han podido enviar los datos</h1>\n";
			echo "<p class=\"text\">Se ha producido un error. <br />Inténtelo más tarde o póngase en contacto con el <a href=\"mailto:".$webmaster."\">webmaster</a></p>\n";
			}
		}
}
?>