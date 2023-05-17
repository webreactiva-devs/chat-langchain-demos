<?php

// Formulario de insercion de firmas pro-filosofia
// Conexión a la BD
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
		<td class="text">País: </td>
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

/* Ejecuta las funciones de validación una a una y devuelve un error cuando falla algo */
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
		
	if(!valida_texto($email)) set_error("Debes especificar un correo electrónico correcto (Ej: <em>minombre@hotmail.com</em>)");

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
"es" => "España",
"af" => "Afganistán",
"al" => "Albania",
"de" => "Alemania",
"sa" => "Arabia Saudí",
"ad" => "Andorra",
"ao" => "Angola",
"ai" => "Anguila",
"aq" => "Antártida",
"ag" => "Antigua y Barbuda",
"dz" => "Argelia",
"ar" => "Argentina",
"am" => "Armenia",
"au" => "Australia",
"at" => "Austria",
"bs" => "Bahamas",
"be" => "Bélgica",
"bo" => "Bolivia",
"br" => "Brasil",
"bg" => "Bulgaria",
"ca" => "Canadá",
"cz" => "Checa, República",
"cl" => "Chile",
"cn" => "China",
"co" => "Colombia",
"kp" => "Corea del Norte",
"kr" => "Corea del Sur",
"cr" => "Costa Rica",
"hr" => "Croacia",
"cu" => "Cuba",
"dk" => "Dinamarca",
"do" => "Dominicana, República",
"ec" => "Ecuador",
"eg" => "Egipto",
"sv" => "El Salvador",
"ae" => "Emiratos Árabes Unidos",
"us" => "Estados Unidos de América",
"ph" => "Filipinas",
"fi" => "Finlandia",
"fr" => "Francia",
"gi" => "Gibraltar",
"gr" => "Grecia",
"gt" => "Guatemala",
"gq" => "Guinea Equatorial",
"ht" => "Haití",
"hn" => "Honduras",
"hk" => "Hong Kong",
"hu" => "Hungría",
"in" => "India",
"id" => "Indonesia",
"iq" => "Irak",
"ir" => "Irán",
"ie" => "Irlanda",
"il" => "Israel",
"it" => "Italia",
"jp" => "Japón",
"jo" => "Jordania",
"lb" => "Líbano",
"lu" => "Luxemburgo",
"my" => "Malasia",
"mx" => "México",
"ma" => "Marruecos",
"nz" => "Nueva Zelanda",
"no" => "Noruega",
"nl" => "Países Bajos",
"pk" => "Pakistán",
"pa" => "Panamá",
"py" => "Paraguay",
"pe" => "Perú",
"pl" => "Polonia",
"pt" => "Portugal",
"pr" => "Puerto Rico",
"uk" => "Reino Unido",
"ro" => "Rumanía",
"ru" => "Rusia",
"as" => "Samoa Americana",
"sg" => "Singapur",
"za" => "Sudáfrica",
"se" => "Suecia",
"ch" => "Suiza",
"tw" => "Taiwán",
"th" => "Tailandia",
"tr" => "Turquía",
"uy" => "Uruguay",
"um" => "U.S. Minor Outlying Islands",
"ua" => "Ucrania",
"ve" => "Venezuela",
"yu" => "Yugoslavia (ex)",
"aw" => "Aruba",
"az" => "Azerbaiján",
"bh" => "Bahrain",
"bd" => "Bangladesh",
"bb" => "Barbados",
"by" => "Bielorrusia",
"bz" => "Belice",
"bj" => "Benín",
"bm" => "Bermuda",
"bt" => "Bhután",
"bw" => "Botswana",
"vg" => "Islas Vírgenes (RU)",
"bn" => "Brunei",
"bf" => "Burkina Faso",
"bi" => "Burundi",
"kh" => "Camboya",
"cm" => "Camerún",
"cv" => "Cabo Verde",
"ky" => "Islas Caimán",
"cf" => "República Centroafricana",
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
"et" => "Etiopía",
"fj" => "Fiji",
"gf" => "Guayana francesa",
"pf" => "Polinesia francesa",
"ga" => "Gabón",
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
"kg" => "Kirguistán",
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
"kz" => "Kazajstán",
"mu" => "Mauricio",
"fm" => "Micronesia",
"md" => "Moldova",
"mc" => "Mónaco",
"mn" => "Mongolia",
"ms" => "Montserrat",
"mz" => "Mozambique",
"mm" => "Myanmar",
"na" => "Namibia",
"nr" => "Naurú",
"np" => "Nepal",
"an" => "Antillas holandesas",
"ni" => "Nicaragua",
"ne" => "Níger",
"ng" => "Nigeria",
"om" => "Omán",
"mp" => "Marianas del norte",
"pw" => "Palau",
"pg" => "Papúa-Nueva Guinea",
"pn" => "Pitcairn",
"qa" => "Qatar",
"re" => "Reunión",
"rw" => "Ruanda",
"kn" => "Saint Kitts &amp; Nevis",
"ws" => "Samoa",
"sm" => "San Marino",
"lc" => "Santa Lucía",
"vc" => "San Vicente y Granadinas",
"st" => "Santo Tomé y Príncipe",
"sn" => "Senegal",
"sc" => "Seychelles",
"sl" => "Sierra Leona",
"sy" => "Siria",
"so" => "Somalia",
"lk" => "Sri Lanka",
"sh" => "St. Helena",
"pm" => "San Pedro y Miquelón (FR.)",
"sd" => "Sudán",
"sr" => "Suriname",
"sz" => "Swazilandia",
"tz" => "Tanzania",
"tj" => "Tayikistán",
"tg" => "Togo",
"tk" => "Tokelau",
"to" => "Tonga",
"tt" => "Trinidad y Tobago",
"tn" => "Tunisia",
"tc" => "Turcas y Caicos",
"tm" => "Turkmenistán",
"tv" => "Tuvalu",
"ug" => "Uganda",
"uz" => "Uzbekistán",
"vu" => "Vanuatu",
"va" => "Vaticano (Ciudad del)",
"vn" => "Vietnam",
"vi" => "Vírginenes Is.",
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
"io" => "Territorio Británico en el Indico",
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