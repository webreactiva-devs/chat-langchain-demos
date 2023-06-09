<?php

// Esquema del array con preguntas, respuestas y correctas de uin cuestionario
/*,
$quizAsks = array(
	n� pregunta => array(
		'ask' => 'Pregunta',
		1 => 'Respuesta 1',
		2 => 'Respuesta 2',
		3 => 'Respuesta 3',
		4 => 'Respuesta 4',
		'ok' => n� respuesta correcta
	)
);

Al pasar los datos a trav�s del formulario, se genera un array
$_POST['quizAnswers'] = array( n� question => n� respuesta)
*/

// Introducci�n a la �tica, �tica (4� de la ESO)
// Preguntas sobre los conceptos fundamentales de la �tica.

$quizAsks = Array
(
	1 => array(
		'ask' => '�Qu� diferencia hay entre la �tica y la moral?',
		'ok' => '3',
		1 => 'La moral es una reflexi�n filos�fica sobre la �tica',
		2 => 'La �tica y la moral son lo mismo',
		3 => 'La �tica es una reflexi�n filos�fica sobre la moral',
		4 => 'La �tica se ocupa de normas y la moral de valores.'
	),
	2 => array(
		'ask' => '�Qu� es una �tica formal?',
		'ok' => '1',
		1 => 'Aquella que se ocupa no tanto de qu� debe hacer el ser humano (contenido) sino de c�mo debe hacerlo',
		2 => 'Aquella que reflexiona sobre las Formas morales',
		3 => 'Aquella que defiende la existencia de Formas o Ideas morales, como la teor�a plat�nica',
		4 => 'La que dice qu� debemos hacer para ser feliz.'
	),
	3 => array(
		'ask' => '�Qu� es una �tica material?',
		'ok' => '2',
		1 => 'La que tiene una visi�n materialista del mundo',
		2 => 'La que ofrece un modelo de vida buena, un modelo de felicidad',
		3 => 'Aquella �tica que pretende una visi�n cient�fica del mundo',
		4 => 'Es una �tica materialista, en la que las cosas valen m�s que las personas.'
	),
	4 => array(
		'ask' => '�Qu� significa autonom�a moral?',
		'ok' => '2',
		1 => 'Que un pueblo pueda decidir qui�n gobierna',
		2 => 'Que el sujeto sea capaz de darse las normas a s� mismo',
		3 => 'Que una naci�n se independice de otra',
		4 => 'Ninguna de las anteriores es v�lida.'
	),
	5 => array(
		'ask' => '�Qu� significa heteronom�a moral?',
		'ok' => '4',
		1 => 'Que el individuo toma decisiones por s� mismo',
		2 => 'Que el sujeto moral decide seg�n unas leyes',
		3 => 'Que todos los ciudadanos est�n sujetos a las mismas normas',
		4 => 'Que el sujeto moral encuentra en alguna autoridad externa la fuente de legitimidad de las normas.'
	),
	6 => array(
		'ask' => '�Cu�les son, seg�n Kohlberg, las etapas de desarrollo moral?',
		'ok' => '3',
		1 => 'Heteronom�a-autonom�a',
		2 => 'Infancia-Adolescencia-Madurez',
		3 => 'Preconvencional-Convencional-Postconvencional'
	),
	7 => array(
		'ask' => '�Cu�l es el significado etimol�gicos de la palabra �moral�?',
		'ok' => '1',
		1 => 'Viene de mos-moris, y significa costumbres',
		2 => 'Viene de mos-moris, y significa bueno',
		3 => 'Viene de mos-moris, y significa justo',
		4 => 'Viene de mos-moris, pero no significa ninguna de las anteriores.'
	),
	8 => array(
		'ask' => '�Qu� es una �tica teleol�gica?',
		'ok' => '3',
		1 => 'Una �tica basada en las nuevas tecnolog�as',
		2 => 'Una �tica basada en la l�gica',
		3 => 'Una �tica material, centrada en los fines del ser humano',
		4 => 'Es sin�nimo de teol�gica, y es una �tica inspirada en los mandatos de Dios.'
	),
	9 => array(
		'ask' => '�Cu�l de las siguentes relaciones entre �lo legal� y �lo moral� son correctas?',
		'ok' => '2',
		1 => 'Todo lo legal es moral',
		2 => 'A veces puede ser moral estar en contra de �lo legal�',
		3 => 'Todo lo moral es legal',
		4 => 'Lo legal y lo moral no guardan ninguna relaci�n entre s�.'
	),
	10 => array(
		'ask' => 'Un lobo mata a una oveja del reba�o de un pastor. �C�mo calificar�as este hecho?',
		'ok' => '3',
		1 => 'Inmoral',
		2 => 'Ilegal',
		3 => 'Amoral',
		4 => 'Ninguna de las anteriores.'
	)
);


?>