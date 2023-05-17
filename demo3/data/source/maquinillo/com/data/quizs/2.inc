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

// Aristóteles: Historia de la Filosofía (2º de bachillerato)
// ¿Conoces los conceptos más importantes de este autor?

$quizAsks = Array
(
	1 => array(
		'ask' => '¿A qué dos conceptos hace referencia la teoría hilemórfica de Aristóteles?',
		'ok' => '3',
		1 => 'Sustancia y accidente',
		2 => 'Potencia y acto',
		3 => 'Materia y forma',
		4 => 'Cuerpo y alma.'
	),
	2 => array(
		'ask' => '¿Qué tipos de cambio fundamentales distinguía Aristóteles?',
		'ok' => '2',
		1 => 'De forma y de color',
		2 => 'Sustancial y accidental',
		3 => 'Potencial y actual',
		4 => 'Local y sustancial'
	),
	3 => array(
		'ask' => '¿Cuáles eran las causas aristotélicas?',
		'ok' => '4',
		1 => 'Eficiente',
		2 => 'Final',
		3 => 'Material',
		4 => 'Todas las anteriores son válidas'
	),
	4 => array(
		'ask' => '¿Qué tipos de virtud distinguía Aristóteles?',
		'ok' => '3',
		1 => 'Potenciales y actuales',
		2 => 'Innatas y aprendidas',
		3 => 'Morales e intelectuales',
		4 => 'Ninguna de las anteriores es válida'
	),
	5 => array(
		'ask' => '¿Qué es el cambio para Aristóteles?',
		'ok' => '1',
		1 => 'El paso de la potencia al acto',
		2 => 'El paso del acto a la potencia',
		3 => 'La modificación de la forma',
		4 => 'La desaparición de los accidentes.'
	),
	6 => array(
		'ask' => '¿Cuáles son, según Aristóteles, los tipos de potencia?',
		'ok' => '2',
		1 => 'Actual y potencial',
		2 => 'Activa y pasiva',
		3 => 'Virtuosa y viciosa',
		4 => 'Material y formal'
	),
	7 => array(
		'ask' => 'La prudencia es una virtud...',
		'ok' => '4',
		1 => 'Ética',
		2 => 'Moral',
		3 => 'Fundamental',
		4 => 'Dianoética'
	),
	8 => array(
		'ask' => 'Cuál de los siguientes regímenes políticos es considerado por Aristóteles como una degeneración de la república?',
		'ok' => '4',
		1 => 'Tiranía',
		2 => 'Oligarquía',
		3 => 'Monarquía',
		4 => 'Democracia'
	),
	9 => array(
		'ask' => '¿Qué tipos de alma distingue Aristóteles?',
		'ok' => '3',
		1 => 'Racional e irracional',
		2 => 'Atemperada y concupiscible',
		3 => 'Vegetativa, sensitiva y racional',
		4 => 'Racional, irascible y concupiscible.'
	),
	10 => array(
		'ask' => 'Las ideas innatas son para Aristóteles…',
		'ok' => '2',
		1 => 'La forma separada de la materia por el entendimiento',
		2 => 'No existen ideas innatas',
		3 => 'Las Formas platónicas',
		4 => 'Las 3 anteriores son válidas.'
	)
);


?>