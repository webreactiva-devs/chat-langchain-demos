<?php
// Datos de navegaci�n

$sections = array(
	'filosofica' => 'filos�fica',
	'didactica' => 'did�ctica',
	'boule' => 'boul�',
	'boule/pau' => 'selectividad',
	//'foros' => 'foros',
	//'wiki' => 'wiki',
	'tienda' => 'tienda*',
	'ayuda' => 'ayuda'
);

$sectionsTitle = array(
	'filosofica' => 'Secci�n profesional del autor de boulesis.com dedicada a la filosof�a',
	'didactica' => 'Recursos para la asignatura de filosof�a y afines',
	'foros' => 'Foros de debate, charla y discusi�n',
	'boule' => 'Weblog (bit�cora) de boulesis.com Lo m�s fresco de la p�gina',
	'wiki' => 'Wiki de filosof�a. Puedes crear y editar tus propias p�ginas para completar la base de datos de conocimiento',
	'tienda' => 'Libros de filosof�a a un precio asequible',
	'ayuda' => 'Qui�n est� detras de boulesis.com. Porque lo hacemos. Que significa boulesis',
);

$siteNav = array(
	'boule' => array(
		0 => 'Boul&eacute;',
		'buscar' => 'B�squeda',
		'dialbit' => array(
			0 => 'DialBit: Di&aacute;logo + Bit&aacute;coras',
			'como.php' => '�C�mo participo?',
			'apuntate.php' => 'Formulario de suscripci�n',
			'novedades.php' => 'Novedades',
			'participantes.php' => 'Participantes',
			'logos.php' => 'Logos para enlazar'
		)
	),
	
	'filosofica' => array(
		0 => 'Filos&oacute;fica',
		'miguel' => array (
			0 => 'Personal',
			'cv' => array (
				0 => 'Curriculum',
				'formacion.php' => 'Formaci�n',
				'publicaciones.php' => 'Publicaciones',
				'otros.php' => 'Otros m�ritos',
				'experiencia.php'=> 'Experiencia'
			)
		),
		'etica-ciudadano-siglo-xxi' =>  'Educaci�n para el ciudadano del siglo XXI',		
		'tesis' => array(
			0 => 'Tesis',
			'index.php' => 'Tesis',
			'' => 'Tesis',
			'tribunal.php' => 'Tribunal',
			'resumen.php' => 'Resumen',
			'investigacion.php' => 'L�neas investigaci�n',
			'masinformacion.php' => 'M�s info'
		),
		'tesina' => array(
			0 => 'Tesina',
			'investigacion.php' => 'L�neas investigaci�n',
			'masinformacion.php' => 'M�s info'
		),
		'articulos' => array (
			0 => 'Art�culos',
			'calderon' => 'Calder�n',
			'dialectica' => 'Dial�ctica',
			'acordando' => 'Acordando',
			'unamuno' => 'Unamuno',
			'kantiana' => 'Kantiana',
			'metodologia' => 'Ense�anza',
			'hermeneutica' => 'Hermen�utica',
			'rio-metafora' => 'Metaf�sica del r�o',
			'masinformacion.php' => 'M�s info'
		),
		'comunicaciones' => array (
			0 => 'Comunicaciones',
			'kind-equality-gauthier' => 'What Kind of Equality?',
			'moral-economica-gauthier' => 'Moral econ�mica de Gauthier',
			'tesis-adorno-arte-actual' => 'Adorno y el arte actual',
			'reflexiones-internet-filosofia' => 'Internet en la educaci�n de la filosof�a',
			'4-metaforas-instituto-internet' => 'Internet y el Instituto: 4 met&aacute;foras',
			'poder-caras-ciencia' => 'El poder y las caras de la ciencia',
			'lyotard-burros-carros' => 'Lyotard, los burros y los carros',
			'economics-language' => 'Economics and language: three classical contributions from philosophy',
			'perfil-profesor-tic' => 'El perfil del profesor TIC',
			'masinformacion.php' => 'M�s info'
		),
		'ponencias' => array (
			0 => 'Ponencias',
			'tic-aula' => 'Las TICs en el aula: bit�coras, webquest y cazatesosoros',
			'nuevas-tecnologias' => '�Qu� nos ofrecen las nuevas tecnolog�as?',
			'herramientas-gratuitas' => 'Trabajar en com&uacute;n con herramientas gratuitas',
			'herramientas-4-eso' => 'Herramientas para integrar las TIC�s en 4� de E.S.O.',
			'cap' => 'Recursos de aula para la ense�anza de la filosof�a',
			'cap2007metod' => 'Metodolog�a en ESO y Bachillerato',
			'cap2007eval' => 'Evaluaci�n e innovaci�n en el aula',
			'colaborativo' => 'Valoraci�n de las herramientas colaborativas',
			'masinformacion.php' => 'M�s info'
		)						
	),
	
	'didactica' => array(
		0 => 'Did&aacute;ctica',
		'glosario' => 'Glosario',
		'enlaces' => 'Enlaces',
		'examenes' => 'Ex&aacute;menes',
		'apuntes' => 'Apuntes',
		'resenas' => 'Rese&ntilde;as',
		'textos' => 'Comentario de texto',
		'documentos' => 'Documentos',
		'logse' => 'LOGSE',
		'tics' => 'Tecnolog�as de la Informaci�n',
		'webquests' => array(
			0 => 'Webquests',
			'bioetica' => 'Bio�tica',
			'globalizacion' => 'Globalizaci�n',
			'etica-ambiental' => '�tica ambiental',
			'etica-religion' => 'Religiones del mundo'
		),
		'usuarios' => 'Usuarios',
		'cazatesoros' => array(
			0 => 'Cazatesoros',
			'derechos-humanos' => 'Derechos humanos',
			'que-es-filosofia' => '�Qu� es filosof�a?',
			'historia-filosofia-sistema' => 'Histor�a de la Filosof�a como sistema',
			'el-relativismo' => 'El relativismo',
			'aprendizaje' => 'El aprendizaje'
		),
		'cuestionarios' => 'Cuestionarios',
		'comunidad' => 'Comunidad online: lista y foros',
		'intercambio' => array(
			0 => 'Intercambio de materiales',
			'como' => 'C�mo colaborar',
			'entrar' => 'Datos de usuario'
		),
		'selectividad' => array(
			0 => 'Selectividad',
			'recursos-examenes' => 'Nuestros materiales',
			'hablamos' => 'Foro',
			'enlaces' => 'Enlaces en la red',
			'universidades' => 'Universidades'
		),
		'interactivos' => 'Juegos interactivos',
		'tutoria' => 'Tutor�a'
		
	),
	
	'firmas' => array(
		0 => 'Salvemos la filosof�a',
		'ultimas' => 'Ultimas firmas recibidas',
		'promociona' => 'Promociona la campa�a',
		'coleccion' => 'Firmas recibidas'
	),	
	
	'preparadores' => array(
		0 => 'Preparadores de oposiciones',
		'curso-2006-2007' => 'Curso 2006-07',
		'distancia' => 'Preparaci�n a distancia',
	),	
	
	'tienda' => array(
		0 => 'Tienda',
		'gracias.php' => 'Gracias',
		'chapas.php' => 'Chapas filos�ficas',
	),	
	
	'ayuda' => array(
		0 => 'Ayuda',
		'que_es_boulesis.php' => '�Qu� es boulesis.com?',
		'quienes_somos.php' => '�Qui�nes somos?',
		'recomendar' => 'Recomi�ndanos',
		'rss' => 'RSS (sindicaci�n)',
		'faq' => 'FAQ',
		'mapa' => 'Mapa del sitio web',
		'legal.php' => 'T�rminos de uso'
	)
);


?>
