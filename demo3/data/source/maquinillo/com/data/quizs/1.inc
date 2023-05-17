<?php

// Esquema del array con preguntas, respuestas y correctas de uin cuestionario
/*,
$quizAsks = array(
	nº pregunta => array(
		'ask' => 'Pregunta',
		1 => 'Respuesta 1',
		2 => 'Respuesta 2',
		3 => 'Respuesta 3',
		4 => 'Respuesta 4',
		'ok' => nº respuesta correcta
	)
);

Al pasar los datos a través del formulario, se genera un array
$_POST['quizAnswers'] = array( nº question => nº respuesta)
*/

$quizAsks = Array
(
	1 => array(
		'ask' => '¿Cuál era el verdadero nombre de Platón?',
		'ok' => '3',
		1 => 'Dión',
		2 => 'Aristófanes',
		3 => 'Aristocles',
		4 => 'Sócrates'
	),
	2 => array(
		'ask' => 'El tema central del Protágoras es...',
		'ok' => '4',
		1 => 'Buscar una definición de la justicia',
		2 => 'La Idea de Bien',
		3 => 'La Idea de Belleza',
		4 => 'Debatir si la virtud es enseñable'
	),
	3 => array(
		'ask' => 'En el símil de la línea Platón distingue las siguientes clases de conocimiento:',
		'ok' => '2',
		1 => 'Intuición y razón',
		2 => 'Imaginación, creencia, conocimiento discursivo e inteligencia',
		3 => 'Creencia y conocimiento discursivo',
		4 => 'Opinión, imaginación y ciencia'
	),
	4 => array(
		'ask' => '¿De qué clases de "almas" habla Platón?',
		'ok' => '1',
		1 => 'Concupiscible, irascible, y racional',
		2 => 'Inteligible, sensible y racional',
		3 => 'Inmortal y mortal',
		4 => 'Sensible, racional e inmortal'
	),
	5 => array(
		'ask' => '¿Quién debe gobernar según Platón?',
		'ok' => '2',
		1 => 'El rey',
		2 => 'El Sabio',
		3 => 'El elegido democráticamente por el pueblo',
		4 => 'El más fuerte (poder militar)'
	),
	6 => array(
		'ask' => '¿Qué escuela fundó Platón?',
		'ok' => '1',
		1 => 'La academia',
		2 => 'El liceo',
		3 => 'El ágora',
		4 => 'La stoa'
	),
	7 => array(
		'ask' => '¿Qué inscripción había al frente de la escuela platónica?',
		'ok' => '4',
		1 => '"Conócete a ti mismo"',
		2 => '"Sólo sé que no sé nada"',
		3 => '"De nada demasiado"',
		4 => '"Nadie entre aquí sin saber geometría"'
	),
	8 => array(
		'ask' => '¿Cuáles de los siguientes diálogos son dos de los llamados "diálogos críticos"?',
		'ok' => '3',
		1 => '"República" y "Fedón"',
		2 => '"Apología de Sócrates" y "Protágoras"',
		3 => '"Parménides" y "Sofista"',
		4 => '"Gorgias" y "Menón"'
	),
	9 => array(
		'ask' => '¿En qué diálogo de Platón aparece el mito de la caverna?',
		'ok' => '4',
		1 => 'Protágoras',
		2 => 'Menón',
		3 => 'Sofista',
		4 => 'Republica'
	),
	10 => array(
		'ask' => '¿Cuál de los siguientes mitos no aparece en los diálogos platónicos?',
		'ok' => '2',
		1 => 'El carro alado',
		2 => 'La manzana de la discordia',
		3 => 'La Atlántida',
		4 => 'El mito de Prometeo'
	)
);


?>