<?php

// Formulario de insercion de firmas pro-filosofia
// Conexi�n a la BD
require (ROOT_INC.'/fun/db_mysql.php');
require (ROOT_INC.'/fun/fun_forms.php');
$siteDB = new Db('localhost', 'boule_daniel', 'cola0bytes1tema', 'boule_foro');
require(ROOT_INC.'/dbconfig.php');




function pinta_formu_concurso($campos){
	


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
	<tr style="background: #e8e8e8">
		<td class="text">Nombre o nick : </td>
		<td><input type="text" name="nombre" size="50" value="<? echo $campos['nombre'] ?>" /></td>
	</tr>
	<tr style="background: #e8e8e8">
      <td class="text">Correo electr&oacute;nico:</td>
	  <td><input type="text" name="email" size="50" value="<? echo $campos['email'] ?>" /></td>
    </tr>
	<tr style="background: #e8e8e8">
      <td class="text">Comprobaci&oacute;n, &iquest;cu&aacute;l es el resultado de 3+5? : </td>
	  <td><input type="text" name="carecir43" size="50" value="" /></td>
    </tr>
	<tr style="background: #e8e8e8">
      <td class="text">Foto 1: Direcci&oacute;n (URL)</td>
	  <td><input type="text" name="photos[0]" size="50" value="<? echo $campos['photos'][0] ?>" /></td>
    </tr>
	<tr style="background: #e8e8e8">
      <td class="text">Comentario de la foto 1 :</td>
	  <td><textarea name="comment_photos[0]" cols="35" rows="3"><? echo $campos['comment_photos'][0] ?></textarea></td>
    </tr>
	<tr style="background: #e8e8e8">
      <td class="text">Foto 2: Direcci&oacute;n (URL)</td>
	  <td><input type="text" name="photos[1]" size="50" value="<? echo $campos['photos'][1] ?>" /></td>
    </tr>
	<tr style="background: #e8e8e8">
      <td class="text">Comentario de la foto 2 :</td>
	  <td><textarea name="comment_photos[1]" cols="35" rows="3"><? echo $campos['comment_photos'][1] ?></textarea></td>
    </tr>
	<tr style="background: #e8e8e8">
      <td class="text">Foto 3: Direcci&oacute;n (URL)</td>
	  <td><input type="text" name="photos[2]" size="50" value="<? echo $campos['photos'][2] ?>" /></td>
    </tr>
	<tr style="background: #e8e8e8">
      <td class="text">Comentario de la foto 3 :</td>
	  <td><textarea name="comment_photos[2]" cols="35" rows="3"><? echo $campos['comment_photos'][2] ?></textarea></td>
    </tr>	
	<tr>
		<td colspan="2" class="small">La informaci&oacute;n sobre el pa&iacute;s donde vives no es esencial, pero nos ayudar&aacute; a saber desde d&oacute;nde nos le&eacute;is. A&ntilde;ade un comentario como sugerencia, petici&oacute;n... </td>
	</tr>
	<tr>
		<td class="text">Pa�s: </td>
		<td><? include("select-paises.inc") ?></td>
	</tr>
	<tr>		
		<td class="text">Comentarios en general: </span> </td>
		<td><textarea name="deprada" cols="35" rows="5"><? echo $campos['deprada'] ?></textarea></td>
	</tr>	  
	<tr>
		<td>&nbsp;</td>
		<td>
		<input type="submit" name="btnconcurso" value="Enviar" class="button" />		</td>
	</tr>
</table>

</form>
	
<?php

	
}

/* Ejecuta las funciones de validaci�n una a una y devuelve un error cuando falla algo */
function valida_form_concurso($nombre="",$films = array(), $email="") {
	
	global $errorurl;
	
	if(!valida_texto($nombre)) set_error("Debes especificar un nombre o nick");
	
	$count = 0;
	if(is_array($films)){
		for($i=0;$i<3;$i++){
		if($films[$i] == '' || empty($films[$i]) || strlen($films[$i]) < 3)	
			$count++;
		}
	}
	
	if($count>2)
		set_error("Debes referenciar al menos 1 foto");
		
	if(!valida_texto($email)) set_error("Debes especificar un correo electr�nico correcto (Ej: <em>minombre@hotmail.com</em>)");

return;

}

function cuantas_concurso_participaciones(){
	global $siteDB;
	$result = $siteDB->query("SELECT name FROM concurso_fotos");
	$cantidad = $siteDB->get_numrows($result);
	$siteDB->free_result();

	return $cantidad;

}

function dame_y_pinta_participaciones(){
	global $siteDB;
	$data = array();

	$query = "SELECT * FROM concurso_fotos ORDER BY time DESC";	
	$result = $siteDB->query($query);
	while ($row = $siteDB->fetch_array($result, 1)){
		$photos_global =  explode('$$$$',$row['photos']);
		$photos = explode('|||',$photos_global[0]);
		$photos_comment = explode('|||',$photos_global[1]);
		$content = '';
		foreach($photos as $i => $url){
			$url = strtolower($url);
			$link = '<a href="http://www.google.es/url?url='.urlencode($url).'">'.$url.'</a>';
			$description = '<br />'.$photos_comment[$i];
			$content .= $link.$description.'<br />';
		}
		$data[$row['signID']] = $content;
	}
	$siteDB->free_result();
	
	//arsort($total_films);
	echo '<ul>';
	foreach($data as $key => $value)
		echo "<li>$key: $value</li>";
	echo '</ul>';	
	return;

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
CREATE TABLE `concurso_cine` (
  `signID` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `films` text NOT NULL,
  `country` varchar(255) NOT NULL default '',
  `comment` text NOT NULL,
  PRIMARY KEY  (`signID`)
) TYPE=MyISAM COMMENT='Primer concurso de boulesis'  ;

*/

?>