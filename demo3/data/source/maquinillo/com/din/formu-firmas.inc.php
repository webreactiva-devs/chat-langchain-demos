<?php

// Formulario de insercion de firmas pro-filosofia
// Conexi�n a la BD
require (ROOT_INC.'/fun/db_mysql.php');
require (ROOT_INC.'/fun/fun_forms.php');
$siteDB = new Db('localhost', 'boule_daniel', 'cola0bytes1tema', 'boule_foro');
require(ROOT_INC.'/dbconfig.php');




function pinta_formu_frimas($campos){
	


	// Elimina las slash no deseadas
	if($campos['nombre'])
		$campos['nombre']=stripslashes($campos['nombre']);
	if($campos['deprada'])
		$campos['deprada']=stripslashes($campos['deprada']);
	if($campos['ciudad'])
		$campos['ciudad']=stripslashes($campos['ciudad']);		

	// Variables necesarias para ser mostradas en el formulario	
	if($campos['pais'])
		$campos['bpais']=$campos['pais'];
		



?>		
		
	
<form action="" method="post">

<table width="98%" border="0" cellpadding="5" cellspacing="0" class="inscription">
	<colgroup span="1" width="40%" />
	<tr>
		<td colspan="2" style="background: #e8e8e8"><strong>Campos obligatorios</strong></td>
	</tr>
	<tr style="background: #e8e8e8">
		<td class="text">Nombre: </td>
		<td><input type="text" name="nombre" size="50" value="<? echo $campos['nombre'] ?>" /></td>
	</tr>
	<tr style="background: #e8e8e8">
		<td class="text">Apellidos: </td>
		<td><input type="text" name="apellidos" size="50" value="<? echo $campos['apellidos'] ?>" /></td>
	</tr>	
	<tr style="background: #e8e8e8">
		<td class="text">Escribe aqu� el nombre de la capital de Espa�a (Madrid): </td>
		<td><input type="text" name="ccir43" size="50" value="" /></td>
	</tr>		
	<tr>
		<td colspan="2" ><strong>Campos opcionales</strong></td>
	</tr>	
	<tr>
		<td colspan="2" class="small">Te recomendamos rellenar los datos relativos al correo electr�nico (para ponernos en contacto contigo si procede) y el DNI (por si en alg�n momento los datos aqu� recogidos pueden tener reconocimiento oficial)</td>
	</tr>	
	<tr>		
		<td class="text">Correo electr�nico:</td>
		<td><input type="text" name="email" size="50" value="<? echo $campos['email'] ?>" /></td>
	</tr>	
	<tr>
		<td class="text">DNI, NIF o n�mero de identificaci�n personal: </td>
		<td class="text"><input type="text" name="dni" size="50" value="<? echo $campos['dni'] ?>" /></td>
	</tr>
	<tr>
		<td class="text">Localidad: </td>
		<td><input type="text" name="ciudad" size="50" value="<? echo $campos['ciudad'] ?>" /></td>
	</tr>
	<tr>
		<td class="text">Pa�s: </td>
		<td><? include("select-paises.inc") ?></td>
	</tr>
	<tr>		
		<td class="text">Comentario: <span class="small">(m&aacute;ximo 250 caracteres)</span> </td>
		<td><textarea name="deprada" cols="30" rows="5"><? echo $campos['deprada'] ?></textarea></td>
	</tr>	  
	<tr>
		<td>&nbsp;</td>
		<td>
		<input type="submit" name="btninscripcion" value="Enviar" class="button" />

		</td>
	</tr>
</table>

</form>
	
<?php

	
}

function cuantas_firmas(){
	global $siteDB;
	$result = $siteDB->query("SELECT name FROM firmas_filo");
	$cantidad = $siteDB->get_numrows($result);
	$siteDB->free_result();

	return $cantidad;

}

function dame_ultimas_firmas(){
	global $siteDB;
	$result = $siteDB->query("SELECT * FROM firmas_filo ORDER BY time DESC LIMIT 0,10");
	while ($row = $siteDB->fetch_array($result, 1)){
		$data[$row['signID']] = $row;
	}
	$siteDB->free_result();

	return $data;
}

function dame_firmas($id){
	global $siteDB;
	if(!$id)
		$id = "A";
	$letter = substr($id, 0, 1);

	$query = "SELECT * FROM firmas_filo WHERE surname LIKE '".$letter."%' ORDER BY surname ASC";	
	$result = $siteDB->query($query);
	while ($row = $siteDB->fetch_array($result, 1)){
		$data[$row['signID']] = $row;
	}
	$siteDB->free_result();
	
	return $data;

}

function pinta_firmas($signs){

	global $arrayfirmas;
	$i = 1;
	if(!is_array($signs))
		$html = '<p>Sin resultados</p>';
	else{	
	foreach($signs as $id => $sign){
			
		$sign['name'] = ucfirst($sign['name']);
		$sign['surname'] = ucfirst($sign['surname']);
		$sign['city'] = ucfirst($sign['city']);
		
		if($sign['country'] != ''){
			$pais = ' '.$arrayfirmas[$sign['country']].'';
			if($sign['city'] != '')
				$pais = ', '.$pais;
		}
		$html .= '<p>'.$i.'. <b>'.$sign['name'].' '.$sign['surname'].'</b> desde <em>'.$sign['city'].$pais.'</em><br/>'."\n";
		if($sign['comment'] != ''){
			$html .= '<span class="small">Comentario: <span style="color: #6e6e6e;">'.$sign['comment'].'</span></span> '."\n";
		}	
		$html .= '</p>'."\n";
		$i++;
	}
	}
	return $html;
}

function pinta_iniciales(){
	
	echo '		   <a href="/firmas/coleccion/?l=A">A</a> | 
           <a href="/firmas/coleccion/?l=B">B</a> | 
           <a href="/firmas/coleccion/?l=C">C</a> | 
           <a href="/firmas/coleccion/?l=D">D</a> | 
           <a href="/firmas/coleccion/?l=E">E</a> | 
	   	   <a href="/firmas/coleccion/?l=F">F</a> | 
           <a href="/firmas/coleccion/?l=G">G</a> | 
           <a href="/firmas/coleccion/?l=H">H</a> | 
           <a href="/firmas/coleccion/?l=I">I</a> | 
           <a href="/firmas/coleccion/?l=J">J</a> | 
           <a href="/firmas/coleccion/?l=K">K</a> | 
           <a href="/firmas/coleccion/?l=L">L</a> | 
           <a href="/firmas/coleccion/?l=M">M</a> | 
           <a href="/firmas/coleccion/?l=N">N</a> | 
		   <a href="/firmas/coleccion/?l=�">�</a> | 
           <a href="/firmas/coleccion/?l=O">O</a> | 
           <a href="/firmas/coleccion/?l=P">P</a> | 
           <a href="/firmas/coleccion/?l=Q">Q</a> | 
	       <a href="/firmas/coleccion/?l=R">R</a> | 
	       <a href="/firmas/coleccion/?l=S">S</a> | 
           <a href="/firmas/coleccion/?l=T">T</a> | 
           <a href="/firmas/coleccion/?l=U">U</a> | 
           <a href="/firmas/coleccion/?l=V">V</a> | 
           <a href="/firmas/coleccion/?l=W">W</a> | 
           <a href="/firmas/coleccion/?l=X">X</a> | 
           <a href="/firmas/coleccion/?l=Y">Y</a> | 
           <a href="/firmas/coleccion/?l=Z">Z</a>';
	
}

$arrayfirmas = array(
"es" => "Espa�a",
"af" => "Afganist�n",
"al" => "Albania",
"de" => "Alemania",
"sa" => "Arabia Saud�",
"ad" => "Andorra",
"ao" => "Angola",
"ai" => "Anguila",
"aq" => "Ant�rtida",
"ag" => "Antigua y Barbuda",
"dz" => "Argelia",
"ar" => "Argentina",
"am" => "Armenia",
"au" => "Australia",
"at" => "Austria",
"bs" => "Bahamas",
"be" => "B�lgica",
"bo" => "Bolivia",
"br" => "Brasil",
"bg" => "Bulgaria",
"ca" => "Canad�",
"cz" => "Checa, Rep�blica",
"cl" => "Chile",
"cn" => "China",
"co" => "Colombia",
"kp" => "Corea del Norte",
"kr" => "Corea del Sur",
"cr" => "Costa Rica",
"hr" => "Croacia",
"cu" => "Cuba",
"dk" => "Dinamarca",
"do" => "Dominicana, Rep�blica",
"ec" => "Ecuador",
"eg" => "Egipto",
"sv" => "El Salvador",
"ae" => "Emiratos �rabes Unidos",
"us" => "Estados Unidos de Am�rica",
"ph" => "Filipinas",
"fi" => "Finlandia",
"fr" => "Francia",
"gi" => "Gibraltar",
"gr" => "Grecia",
"gt" => "Guatemala",
"gq" => "Guinea Equatorial",
"ht" => "Hait�",
"hn" => "Honduras",
"hk" => "Hong Kong",
"hu" => "Hungr�a",
"in" => "India",
"id" => "Indonesia",
"iq" => "Irak",
"ir" => "Ir�n",
"ie" => "Irlanda",
"il" => "Israel",
"it" => "Italia",
"jp" => "Jap�n",
"jo" => "Jordania",
"lb" => "L�bano",
"lu" => "Luxemburgo",
"my" => "Malasia",
"mx" => "M�xico",
"ma" => "Marruecos",
"nz" => "Nueva Zelanda",
"no" => "Noruega",
"nl" => "Pa�ses Bajos",
"pk" => "Pakist�n",
"pa" => "Panam�",
"py" => "Paraguay",
"pe" => "Per�",
"pl" => "Polonia",
"pt" => "Portugal",
"pr" => "Puerto Rico",
"uk" => "Reino Unido",
"ro" => "Ruman�a",
"ru" => "Rusia",
"as" => "Samoa Americana",
"sg" => "Singapur",
"za" => "Sud�frica",
"se" => "Suecia",
"ch" => "Suiza",
"tw" => "Taiw�n",
"th" => "Tailandia",
"tr" => "Turqu�a",
"uy" => "Uruguay",
"um" => "U.S. Minor Outlying Islands",
"ua" => "Ucrania",
"ve" => "Venezuela",
"yu" => "Yugoslavia (ex)",
"aw" => "Aruba",
"az" => "Azerbaij�n",
"bh" => "Bahrain",
"bd" => "Bangladesh",
"bb" => "Barbados",
"by" => "Bielorrusia",
"bz" => "Belice",
"bj" => "Ben�n",
"bm" => "Bermuda",
"bt" => "Bhut�n",
"bw" => "Botswana",
"vg" => "Islas V�rgenes (RU)",
"bn" => "Brunei",
"bf" => "Burkina Faso",
"bi" => "Burundi",
"kh" => "Camboya",
"cm" => "Camer�n",
"cv" => "Cabo Verde",
"ky" => "Islas Caim�n",
"cf" => "Rep�blica Centroafricana",
"td" => "Chad",
"km" => "Comoros",
"ck" => "Islas Cook",
"cg" => "Congo",
"ci" => "Costa de marfil",
"cy" => "Chipre",
"dj" => "Djibuti",
"dm" => "Dominica",
"tp" => "Timor oriental",
"er" => "Eritrea",
"sk" => "Eslovaquia",
"si" => "Eslovenia",
"ee" => "Estonia",
"et" => "Etiop�a",
"fj" => "Fiji",
"gf" => "Guayana francesa",
"pf" => "Polinesia francesa",
"ga" => "Gab�n",
"gm" => "Gambia",
"ge" => "Georgia",
"gh" => "Ghana",
"gd" => "Grenada",
"gp" => "Guadalupe",
"gu" => "Guam",
"gn" => "Guinea",
"gw" => "Guinea-Bissau",
"gy" => "Guyana",
"is" => "Islandia",
"jm" => "Jamaica",
"ke" => "Kenia",
"ki" => "Kiribati",
"kg" => "Kirguist�n",
"kw" => "Kuwait",
"la" => "Laos",
"lv" => "Letonia",
"ls" => "Lesotho",
"lr" => "Liberia",
"ly" => "Libia",
"li" => "Liechtenstein",
"lt" => "Lituania",
"mo" => "Macao",
"mk" => "Macedonia",
"mg" => "Madagascar",
"mw" => "Malawi",
"mv" => "Maldivas",
"ml" => "Mali",
"mt" => "Malta",
"mh" => "Marshall (Islas)",
"mq" => "Martinica",
"mr" => "Mauritania",
"kz" => "Kazajst�n",
"mu" => "Mauricio",
"fm" => "Micronesia",
"md" => "Moldova",
"mc" => "M�naco",
"mn" => "Mongolia",
"ms" => "Montserrat",
"mz" => "Mozambique",
"mm" => "Myanmar",
"na" => "Namibia",
"nr" => "Naur�",
"np" => "Nepal",
"an" => "Antillas holandesas",
"ni" => "Nicaragua",
"ne" => "N�ger",
"ng" => "Nigeria",
"om" => "Om�n",
"mp" => "Marianas del norte",
"pw" => "Palau",
"pg" => "Pap�a-Nueva Guinea",
"pn" => "Pitcairn",
"qa" => "Qatar",
"re" => "Reuni�n",
"rw" => "Ruanda",
"kn" => "Saint Kitts &amp; Nevis",
"ws" => "Samoa",
"sm" => "San Marino",
"lc" => "Santa Luc�a",
"vc" => "San Vicente y Granadinas",
"st" => "Santo Tom� y Pr�ncipe",
"sn" => "Senegal",
"sc" => "Seychelles",
"sl" => "Sierra Leona",
"sy" => "Siria",
"so" => "Somalia",
"lk" => "Sri Lanka",
"sh" => "St. Helena",
"pm" => "San Pedro y Miquel�n (FR.)",
"sd" => "Sud�n",
"sr" => "Suriname",
"sz" => "Swazilandia",
"tz" => "Tanzania",
"tj" => "Tayikist�n",
"tg" => "Togo",
"tk" => "Tokelau",
"to" => "Tonga",
"tt" => "Trinidad y Tobago",
"tn" => "Tunisia",
"tc" => "Turcas y Caicos",
"tm" => "Turkmenist�n",
"tv" => "Tuvalu",
"ug" => "Uganda",
"uz" => "Uzbekist�n",
"vu" => "Vanuatu",
"va" => "Vaticano (Ciudad del)",
"vn" => "Vietnam",
"vi" => "V�rginenes Is.",
"eh" => "Sahara Occidental",
"ye" => "Yemen",
"zr" => "Zaire",
"zm" => "Zambia",
"zw" => "Zimbabwe",
"bv" => "Bouvet Is.",
"fo" => "Feroe",
"gl" => "Groenlandia",
"ba" => "Bosnia Herzegovina",
"sp" => "Solomon (Islas)",
"yt" => "Mayotte (FR.)",
"nc" => "Nueva Caledonia",
"nu" => "Niue",
"nf" => "Norfolk Is.",
"io" => "Territorio Brit�nico en el Indico",
"cx" => "Christmas (Isla)",
"cc" => "Cocos (Islas)",
"fk" => "Malvinas (Falkland) (Islas)",
"tf" => "Territorios franceses del sur",
"hm" => "Heard y McDonald (Islas)",
"gs" => "S. Georgia y S. Sandwich (Islas)",
"sj" => "Svalbard y Jan Mayen (Islas)",
"wf" => "Wallis y Futuna (Islas)");

/*
CREATE TABLE `firmas_filo` (
  `signID` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `surname` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `dni` varchar(255) NOT NULL default '',
  `city` varchar(255) NOT NULL default '',
  `country` varchar(255) NOT NULL default '',
  `comment` text NOT NULL,
  PRIMARY KEY  (`signID`)
) TYPE=MyISAM COMMENT='Firmas para salvar la filosofia' AUTO_INCREMENT=1 ;

*/

?>