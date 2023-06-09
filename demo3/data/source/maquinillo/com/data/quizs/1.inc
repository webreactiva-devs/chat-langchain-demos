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

$quizAsks = Array
(
	1 => array(
		'ask' => '�Cu�l era el verdadero nombre de Plat�n?',
		'ok' => '3',
		1 => 'Di�n',
		2 => 'Arist�fanes',
		3 => 'Aristocles',
		4 => 'S�crates'
	),
	2 => array(
		'ask' => 'El tema central del Prot�goras es...',
		'ok' => '4',
		1 => 'Buscar una definici�n de la justicia',
		2 => 'La Idea de Bien',
		3 => 'La Idea de Belleza',
		4 => 'Debatir si la virtud es ense�able'
	),
	3 => array(
		'ask' => 'En el s�mil de la l�nea Plat�n distingue las siguientes clases de conocimiento:',
		'ok' => '2',
		1 => 'Intuici�n y raz�n',
		2 => 'Imaginaci�n, creencia, conocimiento discursivo e inteligencia',
		3 => 'Creencia y conocimiento discursivo',
		4 => 'Opini�n, imaginaci�n y ciencia'
	),
	4 => array(
		'ask' => '�De qu� clases de "almas" habla Plat�n?',
		'ok' => '1',
		1 => 'Concupiscible, irascible, y racional',
		2 => 'Inteligible, sensible y racional',
		3 => 'Inmortal y mortal',
		4 => 'Sensible, racional e inmortal'
	),
	5 => array(
		'ask' => '�Qui�n debe gobernar seg�n Plat�n?',
		'ok' => '2',
		1 => 'El rey',
		2 => 'El Sabio',
		3 => 'El elegido democr�ticamente por el pueblo',
		4 => 'El m�s fuerte (poder militar)'
	),
	6 => array(
		'ask' => '�Qu� escuela fund� Plat�n?',
		'ok' => '1',
		1 => 'La academia',
		2 => 'El liceo',
		3 => 'El �gora',
		4 => 'La stoa'
	),
	7 => array(
		'ask' => '�Qu� inscripci�n hab�a al frente de la escuela plat�nica?',
		'ok' => '4',
		1 => '"Con�cete a ti mismo"',
		2 => '"S�lo s� que no s� nada"',
		3 => '"De nada demasiado"',
		4 => '"Nadie entre aqu� sin saber geometr�a"'
	),
	8 => array(
		'ask' => '�Cu�les de los siguientes di�logos son dos de los llamados "di�logos cr�ticos"?',
		'ok' => '3',
		1 => '"Rep�blica" y "Fed�n"',
		2 => '"Apolog�a de S�crates" y "Prot�goras"',
		3 => '"Parm�nides" y "Sofista"',
		4 => '"Gorgias" y "Men�n"'
	),
	9 => array(
		'ask' => '�En qu� di�logo de Plat�n aparece el mito de la caverna?',
		'ok' => '4',
		1 => 'Prot�goras',
		2 => 'Men�n',
		3 => 'Sofista',
		4 => 'Republica'
	),
	10 => array(
		'ask' => '�Cu�l de los siguientes mitos no aparece en los di�logos plat�nicos?',
		'ok' => '2',
		1 => 'El carro alado',
		2 => 'La manzana de la discordia',
		3 => 'La Atl�ntida',
		4 => 'El mito de Prometeo'
	)
);


?>