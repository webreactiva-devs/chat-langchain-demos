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

// Metaf�sica, Filosof�a 1 (1� de bachillerato)
// Pon a prueba tus conocimientos sobre las ideas m�s sencillas de la metaf�sica.

$quizAsks = Array
(
	1 => array(
		'ask' => '�A qu� dos fil�sofos se les considera los dos primeros representantes de un pensamiento metaf�sico?',
		'ok' => '4',
		1 => 'Tales de Mileto y Anaximandro',
		2 => 'Plat�n y Arist�teles',
		3 => 'Dem�crito y Leucipo',
		4 => 'Her�cilto y Parm�nides.'
	),
	2 => array(
		'ask' => '�Cu�l es uno de los problemas que dieron lugar al nacimiento de la metaf�sica?',
		'ok' => '2',
		1 => 'El problema de unificar lenguaje y realidad',
		2 => 'El problema del cambio',
		3 => 'El problema de las sustancias',
		4 => 'El problema del arj�.'
	),
	3 => array(
		'ask' => '�Cu�l es una de las oposiciones fundamentales de la metaf�sica?',
		'ok' => '1',
		1 => 'Apariencia-esencia',
		2 => 'Idea-cosa',
		3 => 'Sustancia-accidente',
		4 => 'Necesidad-Contingencia'
	),
	4 => array(
		'ask' => '�C�mo entiende la realidad Plat�n?',
		'ok' => '3',
		1 => 'Como una copia debilitada del mundo de las Ideas',
		2 => 'Como un mundo de cosas que participa de la verdadera realidad, que est� en el mundo de las Ideas',
		3 => 'Las dos anteriores son correctas',
		4 => 'Como un conjunto de sustancias y sus correspondientes accidentes.'
	),
	5 => array(
		'ask' => '�Qu� es una cosa para Arist�teles?',
		'ok' => '4',
		1 => 'Una copia de una Forma',
		2 => 'La combinaci�n inseparable de materia y forma',
		3 => 'Una sustancia a la que le sobrevienen diferentes accidentes',
		4 => 'Las dos anteriores son v�lidas.'
	),
	6 => array(
		'ask' => '�Cu�l va a ser el fundamento �ltimo de la realidad para muchos fil�sofos medievales?',
		'ok' => '2',
		1 => 'El mundo de las Ideas, pues en la edad media predomina la filosof�a plat�nica',
		2 => 'Dios',
		3 => 'Las cosas mismas, entendidas como conjunci�n de material y forma pues en la edad media predomina el pensamiento aristot�lico',
		4 => 'Ninguna de las anteriores es v�lida.'
	),
	7 => array(
		'ask' => '�Cu�l es el fundamento �ltimo de la realidad para Descartes?',
		'ok' => '1',
		1 => 'La certeza del cogito',
		2 => 'Dios, que sirve como puente para enlazar al yo con el mundo',
		3 => 'Dios, que es la garant�a del conocimiento',
		4 => 'Las dos anteriores son v�lidas'
	),
	8 => array(
		'ask' => '�C�mo entiende Hume la realidad?',
		'ok' => '3',
		1 => 'Como un conjunto de sustancias y esencias que podemos conocer por la raz�n',
		2 => 'Como sustancias de las que s�lo conocemos sus cualidades secundarias',
		3 => 'Como un conjunto de fen�menos',
		4 => 'Ninguna de las anteriores es v�lida.'
	),
	9 => array(
		'ask' => '�Qu� dir� Kant de la metaf�sica?',
		'ok' => '4',
		1 => 'Que no es posible como ciencia',
		2 => 'Que no est� formada por juicios sint�ticos a priori, que son los propios de la ciencia',
		3 => 'Que sus preguntas existen como una tendencia inevitable del ser humano',
		4 => 'Las 3 respuestas anteriores son v�lidas.'
	),
	10 => array(
		'ask' => '�Cu�l de los siguientes  pares no representa a corrientes de la metaf�sica?',
		'ok' => '2',
		1 => 'Idealismo-Realismo',
		2 => 'Convencionalismo-Universalismo',
		3 => 'Nominalismo-Materialismo',
		4 => 'Existencialismo-Positivismo'
	)
);


?>