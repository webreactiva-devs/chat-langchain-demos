<?php

// Formulario de insercion de firmas pro-filosofia
// Conexión a la BD
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
		<td class="text">Escribe aquí el nombre de la capital de España (Madrid): </td>
		<td><input type="text" name="ccir43" size="50" value="" /></td>
	</tr>		
	<tr>
		<td colspan="2" ><strong>Campos opcionales</strong></td>
	</tr>	
	<tr>
		<td colspan="2" class="small">Te recomendamos rellenar los datos relativos al correo electrónico (para ponernos en contacto contigo si procede) y el DNI (por si en algún momento los datos aquí recogidos pueden tener reconocimiento oficial)</td>
	</tr>	
	<tr>		
		<td class="text">Correo electrónico:</td>
		<td><input type="text" name="email" size="50" value="<? echo $campos['email'] ?>" /></td>
	</tr>	
	<tr>
		<td class="text">DNI, NIF o número de identificación personal: </td>
		<td class="text"><input type="text" name="dni" size="50" value="<? echo $campos['dni'] ?>" /></td>
	</tr>
	<tr>
		<td class="text">Localidad: </td>
		<td><input type="text" name="ciudad" size="50" value="<? echo $campos['ciudad'] ?>" /></td>
	</tr>
	<tr>
		<td class="text">País: </td>
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
		   <a href="/firmas/coleccion/?l=Ñ">Ñ</a> | 
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