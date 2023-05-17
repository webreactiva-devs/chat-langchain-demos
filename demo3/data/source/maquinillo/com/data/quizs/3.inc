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

// Metafísica, Filosofía 1 (1º de bachillerato)
// Pon a prueba tus conocimientos sobre las ideas más sencillas de la metafísica.

$quizAsks = Array
(
	1 => array(
		'ask' => '¿A qué dos filósofos se les considera los dos primeros representantes de un pensamiento metafísico?',
		'ok' => '4',
		1 => 'Tales de Mileto y Anaximandro',
		2 => 'Platón y Aristóteles',
		3 => 'Demócrito y Leucipo',
		4 => 'Herácilto y Parménides.'
	),
	2 => array(
		'ask' => '¿Cuál es uno de los problemas que dieron lugar al nacimiento de la metafísica?',
		'ok' => '2',
		1 => 'El problema de unificar lenguaje y realidad',
		2 => 'El problema del cambio',
		3 => 'El problema de las sustancias',
		4 => 'El problema del arjé.'
	),
	3 => array(
		'ask' => '¿Cuál es una de las oposiciones fundamentales de la metafísica?',
		'ok' => '1',
		1 => 'Apariencia-esencia',
		2 => 'Idea-cosa',
		3 => 'Sustancia-accidente',
		4 => 'Necesidad-Contingencia'
	),
	4 => array(
		'ask' => '¿Cómo entiende la realidad Platón?',
		'ok' => '3',
		1 => 'Como una copia debilitada del mundo de las Ideas',
		2 => 'Como un mundo de cosas que participa de la verdadera realidad, que está en el mundo de las Ideas',
		3 => 'Las dos anteriores son correctas',
		4 => 'Como un conjunto de sustancias y sus correspondientes accidentes.'
	),
	5 => array(
		'ask' => '¿Qué es una cosa para Aristóteles?',
		'ok' => '4',
		1 => 'Una copia de una Forma',
		2 => 'La combinación inseparable de materia y forma',
		3 => 'Una sustancia a la que le sobrevienen diferentes accidentes',
		4 => 'Las dos anteriores son válidas.'
	),
	6 => array(
		'ask' => '¿Cuál va a ser el fundamento último de la realidad para muchos filósofos medievales?',
		'ok' => '2',
		1 => 'El mundo de las Ideas, pues en la edad media predomina la filosofía platónica',
		2 => 'Dios',
		3 => 'Las cosas mismas, entendidas como conjunción de material y forma pues en la edad media predomina el pensamiento aristotélico',
		4 => 'Ninguna de las anteriores es válida.'
	),
	7 => array(
		'ask' => '¿Cuál es el fundamento último de la realidad para Descartes?',
		'ok' => '1',
		1 => 'La certeza del cogito',
		2 => 'Dios, que sirve como puente para enlazar al yo con el mundo',
		3 => 'Dios, que es la garantía del conocimiento',
		4 => 'Las dos anteriores son válidas'
	),
	8 => array(
		'ask' => '¿Cómo entiende Hume la realidad?',
		'ok' => '3',
		1 => 'Como un conjunto de sustancias y esencias que podemos conocer por la razón',
		2 => 'Como sustancias de las que sólo conocemos sus cualidades secundarias',
		3 => 'Como un conjunto de fenómenos',
		4 => 'Ninguna de las anteriores es válida.'
	),
	9 => array(
		'ask' => '¿Qué dirá Kant de la metafísica?',
		'ok' => '4',
		1 => 'Que no es posible como ciencia',
		2 => 'Que no está formada por juicios sintéticos a priori, que son los propios de la ciencia',
		3 => 'Que sus preguntas existen como una tendencia inevitable del ser humano',
		4 => 'Las 3 respuestas anteriores son válidas.'
	),
	10 => array(
		'ask' => '¿Cuál de los siguientes  pares no representa a corrientes de la metafísica?',
		'ok' => '2',
		1 => 'Idealismo-Realismo',
		2 => 'Convencionalismo-Universalismo',
		3 => 'Nominalismo-Materialismo',
		4 => 'Existencialismo-Positivismo'
	)
);


?>