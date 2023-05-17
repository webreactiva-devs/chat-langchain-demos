<?php
// Datos de navegación

$sections = array(
	'filosofica' => 'filosófica',
	'didactica' => 'didáctica',
	'boule' => 'boulé',
	'boule/pau' => 'selectividad',
	//'foros' => 'foros',
	//'wiki' => 'wiki',
	'tienda' => 'tienda*',
	'ayuda' => 'ayuda'
);

$sectionsTitle = array(
	'filosofica' => 'Sección profesional del autor de boulesis.com dedicada a la filosofía',
	'didactica' => 'Recursos para la asignatura de filosofía y afines',
	'foros' => 'Foros de debate, charla y discusión',
	'boule' => 'Weblog (bitácora) de boulesis.com Lo más fresco de la página',
	'wiki' => 'Wiki de filosofía. Puedes crear y editar tus propias páginas para completar la base de datos de conocimiento',
	'tienda' => 'Libros de filosofía a un precio asequible',
	'ayuda' => 'Quién está detras de boulesis.com. Porque lo hacemos. Que significa boulesis',
);

$siteNav = array(
	'boule' => array(
		0 => 'Boul&eacute;',
		'buscar' => 'Búsqueda',
		'dialbit' => array(
			0 => 'DialBit: Di&aacute;logo + Bit&aacute;coras',
			'como.php' => '¿Cómo participo?',
			'apuntate.php' => 'Formulario de suscripción',
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
				'formacion.php' => 'Formación',
				'publicaciones.php' => 'Publicaciones',
				'otros.php' => 'Otros méritos',
				'experiencia.php'=> 'Experiencia'
			)
		),
		'etica-ciudadano-siglo-xxi' =>  'Educación para el ciudadano del siglo XXI',		
		'tesis' => array(
			0 => 'Tesis',
			'index.php' => 'Tesis',
			'' => 'Tesis',
			'tribunal.php' => 'Tribunal',
			'resumen.php' => 'Resumen',
			'investigacion.php' => 'Líneas investigación',
			'masinformacion.php' => 'Más info'
		),
		'tesina' => array(
			0 => 'Tesina',
			'investigacion.php' => 'Líneas investigación',
			'masinformacion.php' => 'Más info'
		),
		'articulos' => array (
			0 => 'Artículos',
			'calderon' => 'Calderón',
			'dialectica' => 'Dialéctica',
			'acordando' => 'Acordando',
			'unamuno' => 'Unamuno',
			'kantiana' => 'Kantiana',
			'metodologia' => 'Enseñanza',
			'hermeneutica' => 'Hermenéutica',
			'rio-metafora' => 'Metafísica del río',
			'masinformacion.php' => 'Más info'
		),
		'comunicaciones' => array (
			0 => 'Comunicaciones',
			'kind-equality-gauthier' => 'What Kind of Equality?',
			'moral-economica-gauthier' => 'Moral económica de Gauthier',
			'tesis-adorno-arte-actual' => 'Adorno y el arte actual',
			'reflexiones-internet-filosofia' => 'Internet en la educación de la filosofía',
			'4-metaforas-instituto-internet' => 'Internet y el Instituto: 4 met&aacute;foras',
			'poder-caras-ciencia' => 'El poder y las caras de la ciencia',
			'lyotard-burros-carros' => 'Lyotard, los burros y los carros',
			'economics-language' => 'Economics and language: three classical contributions from philosophy',
			'perfil-profesor-tic' => 'El perfil del profesor TIC',
			'masinformacion.php' => 'Más info'
		),
		'ponencias' => array (
			0 => 'Ponencias',
			'tic-aula' => 'Las TICs en el aula: bitácoras, webquest y cazatesosoros',
			'nuevas-tecnologias' => '¿Qué nos ofrecen las nuevas tecnologías?',
			'herramientas-gratuitas' => 'Trabajar en com&uacute;n con herramientas gratuitas',
			'herramientas-4-eso' => 'Herramientas para integrar las TIC´s en 4º de E.S.O.',
			'cap' => 'Recursos de aula para la enseñanza de la filosofía',
			'cap2007metod' => 'Metodología en ESO y Bachillerato',
			'cap2007eval' => 'Evaluación e innovación en el aula',
			'colaborativo' => 'Valoración de las herramientas colaborativas',
			'masinformacion.php' => 'Más info'
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
		'tics' => 'Tecnologías de la Información',
		'webquests' => array(
			0 => 'Webquests',
			'bioetica' => 'Bioética',
			'globalizacion' => 'Globalización',
			'etica-ambiental' => 'Ética ambiental',
			'etica-religion' => 'Religiones del mundo'
		),
		'usuarios' => 'Usuarios',
		'cazatesoros' => array(
			0 => 'Cazatesoros',
			'derechos-humanos' => 'Derechos humanos',
			'que-es-filosofia' => '¿Qué es filosofía?',
			'historia-filosofia-sistema' => 'Historía de la Filosofía como sistema',
			'el-relativismo' => 'El relativismo',
			'aprendizaje' => 'El aprendizaje'
		),
		'cuestionarios' => 'Cuestionarios',
		'comunidad' => 'Comunidad online: lista y foros',
		'intercambio' => array(
			0 => 'Intercambio de materiales',
			'como' => 'Cómo colaborar',
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
		'tutoria' => 'Tutoría'
		
	),
	
	'firmas' => array(
		0 => 'Salvemos la filosofía',
		'ultimas' => 'Ultimas firmas recibidas',
		'promociona' => 'Promociona la campaña',
		'coleccion' => 'Firmas recibidas'
	),	
	
	'preparadores' => array(
		0 => 'Preparadores de oposiciones',
		'curso-2006-2007' => 'Curso 2006-07',
		'distancia' => 'Preparación a distancia',
	),	
	
	'tienda' => array(
		0 => 'Tienda',
		'gracias.php' => 'Gracias',
		'chapas.php' => 'Chapas filosóficas',
	),	
	
	'ayuda' => array(
		0 => 'Ayuda',
		'que_es_boulesis.php' => '¿Qué es boulesis.com?',
		'quienes_somos.php' => '¿Quiénes somos?',
		'recomendar' => 'Recomiéndanos',
		'rss' => 'RSS (sindicación)',
		'faq' => 'FAQ',
		'mapa' => 'Mapa del sitio web',
		'legal.php' => 'Términos de uso'
	)
);


?>
