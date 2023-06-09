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

// Arist�teles: Historia de la Filosof�a (2� de bachillerato)
// �Conoces los conceptos m�s importantes de este autor?

$quizAsks = Array
(
	1 => array(
		'ask' => '�A qu� dos conceptos hace referencia la teor�a hilem�rfica de Arist�teles?',
		'ok' => '3',
		1 => 'Sustancia y accidente',
		2 => 'Potencia y acto',
		3 => 'Materia y forma',
		4 => 'Cuerpo y alma.'
	),
	2 => array(
		'ask' => '�Qu� tipos de cambio fundamentales distingu�a Arist�teles?',
		'ok' => '2',
		1 => 'De forma y de color',
		2 => 'Sustancial y accidental',
		3 => 'Potencial y actual',
		4 => 'Local y sustancial'
	),
	3 => array(
		'ask' => '�Cu�les eran las causas aristot�licas?',
		'ok' => '4',
		1 => 'Eficiente',
		2 => 'Final',
		3 => 'Material',
		4 => 'Todas las anteriores son v�lidas'
	),
	4 => array(
		'ask' => '�Qu� tipos de virtud distingu�a Arist�teles?',
		'ok' => '3',
		1 => 'Potenciales y actuales',
		2 => 'Innatas y aprendidas',
		3 => 'Morales e intelectuales',
		4 => 'Ninguna de las anteriores es v�lida'
	),
	5 => array(
		'ask' => '�Qu� es el cambio para Arist�teles?',
		'ok' => '1',
		1 => 'El paso de la potencia al acto',
		2 => 'El paso del acto a la potencia',
		3 => 'La modificaci�n de la forma',
		4 => 'La desaparici�n de los accidentes.'
	),
	6 => array(
		'ask' => '�Cu�les son, seg�n Arist�teles, los tipos de potencia?',
		'ok' => '2',
		1 => 'Actual y potencial',
		2 => 'Activa y pasiva',
		3 => 'Virtuosa y viciosa',
		4 => 'Material y formal'
	),
	7 => array(
		'ask' => 'La prudencia es una virtud...',
		'ok' => '4',
		1 => '�tica',
		2 => 'Moral',
		3 => 'Fundamental',
		4 => 'Diano�tica'
	),
	8 => array(
		'ask' => 'Cu�l de los siguientes reg�menes pol�ticos es considerado por Arist�teles como una degeneraci�n de la rep�blica?',
		'ok' => '4',
		1 => 'Tiran�a',
		2 => 'Oligarqu�a',
		3 => 'Monarqu�a',
		4 => 'Democracia'
	),
	9 => array(
		'ask' => '�Qu� tipos de alma distingue Arist�teles?',
		'ok' => '3',
		1 => 'Racional e irracional',
		2 => 'Atemperada y concupiscible',
		3 => 'Vegetativa, sensitiva y racional',
		4 => 'Racional, irascible y concupiscible.'
	),
	10 => array(
		'ask' => 'Las ideas innatas son para Arist�teles�',
		'ok' => '2',
		1 => 'La forma separada de la materia por el entendimiento',
		2 => 'No existen ideas innatas',
		3 => 'Las Formas plat�nicas',
		4 => 'Las 3 anteriores son v�lidas.'
	)
);


?>