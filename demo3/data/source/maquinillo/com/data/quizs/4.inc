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

// Introducción a la Ética, Ética (4º de la ESO)
// Preguntas sobre los conceptos fundamentales de la ética.

$quizAsks = Array
(
	1 => array(
		'ask' => '¿Qué diferencia hay entre la ética y la moral?',
		'ok' => '3',
		1 => 'La moral es una reflexión filosófica sobre la ética',
		2 => 'La ética y la moral son lo mismo',
		3 => 'La ética es una reflexión filosófica sobre la moral',
		4 => 'La ética se ocupa de normas y la moral de valores.'
	),
	2 => array(
		'ask' => '¿Qué es una ética formal?',
		'ok' => '1',
		1 => 'Aquella que se ocupa no tanto de qué debe hacer el ser humano (contenido) sino de cómo debe hacerlo',
		2 => 'Aquella que reflexiona sobre las Formas morales',
		3 => 'Aquella que defiende la existencia de Formas o Ideas morales, como la teoría platónica',
		4 => 'La que dice qué debemos hacer para ser feliz.'
	),
	3 => array(
		'ask' => '¿Qué es una ética material?',
		'ok' => '2',
		1 => 'La que tiene una visión materialista del mundo',
		2 => 'La que ofrece un modelo de vida buena, un modelo de felicidad',
		3 => 'Aquella ética que pretende una visión científica del mundo',
		4 => 'Es una ética materialista, en la que las cosas valen más que las personas.'
	),
	4 => array(
		'ask' => '¿Qué significa autonomía moral?',
		'ok' => '2',
		1 => 'Que un pueblo pueda decidir quién gobierna',
		2 => 'Que el sujeto sea capaz de darse las normas a sí mismo',
		3 => 'Que una nación se independice de otra',
		4 => 'Ninguna de las anteriores es válida.'
	),
	5 => array(
		'ask' => '¿Qué significa heteronomía moral?',
		'ok' => '4',
		1 => 'Que el individuo toma decisiones por sí mismo',
		2 => 'Que el sujeto moral decide según unas leyes',
		3 => 'Que todos los ciudadanos están sujetos a las mismas normas',
		4 => 'Que el sujeto moral encuentra en alguna autoridad externa la fuente de legitimidad de las normas.'
	),
	6 => array(
		'ask' => '¿Cuáles son, según Kohlberg, las etapas de desarrollo moral?',
		'ok' => '3',
		1 => 'Heteronomía-autonomía',
		2 => 'Infancia-Adolescencia-Madurez',
		3 => 'Preconvencional-Convencional-Postconvencional'
	),
	7 => array(
		'ask' => '¿Cuál es el significado etimológicos de la palabra “moral”?',
		'ok' => '1',
		1 => 'Viene de mos-moris, y significa costumbres',
		2 => 'Viene de mos-moris, y significa bueno',
		3 => 'Viene de mos-moris, y significa justo',
		4 => 'Viene de mos-moris, pero no significa ninguna de las anteriores.'
	),
	8 => array(
		'ask' => '¿Qué es una ética teleológica?',
		'ok' => '3',
		1 => 'Una ética basada en las nuevas tecnologías',
		2 => 'Una ética basada en la lógica',
		3 => 'Una ética material, centrada en los fines del ser humano',
		4 => 'Es sinónimo de teológica, y es una ética inspirada en los mandatos de Dios.'
	),
	9 => array(
		'ask' => '¿Cuál de las siguentes relaciones entre “lo legal” y “lo moral” son correctas?',
		'ok' => '2',
		1 => 'Todo lo legal es moral',
		2 => 'A veces puede ser moral estar en contra de “lo legal”',
		3 => 'Todo lo moral es legal',
		4 => 'Lo legal y lo moral no guardan ninguna relación entre sí.'
	),
	10 => array(
		'ask' => 'Un lobo mata a una oveja del rebaño de un pastor. ¿Cómo calificarías este hecho?',
		'ok' => '3',
		1 => 'Inmoral',
		2 => 'Ilegal',
		3 => 'Amoral',
		4 => 'Ninguna de las anteriores.'
	)
);


?>