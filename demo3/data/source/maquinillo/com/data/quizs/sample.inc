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

$quizAsks = array(
	1 => array(
		'ask' => '¿En qué año se fundó la Escuela de Frankfurt?',
		1 => '1925',
		2 => '1926',
		3 => '1924',
		4 => '1923',
		'ok' => 4
	),
	2 => array(
		'ask' => '¿Cuál de los siguientes hechos históricos provocaron un giro en el pensamiento de Adorno y Horkheimer?',
		1 => 'El ascenso al poder de Hitler.',
		2 => 'El exilio y la persecución nazi.',
		3 => 'La intervención norteamericana en la II guerra mundial.',
		4 => 'El fin de la segunda guerra mundial.',
		'ok' => 2
	),
	3 => array(
		'ask' => '¿Cuál de los siguientes autores no intervino en la fundación del Instituto para la Investigación Social?',
		1 => 'Max Horkheimer.',
		2 => 'Friedrich Pollock.',
		3 => 'Félix Weil.',
		4 => 'Kurt Albert Gerlach.',
		'ok' => 1
	),
	4 => array(
		'ask' => '¿En qué año fue nombrado Horkheimer director del Instituto?',
		1 => '1930',
		2 => '1932',
		3 => '1931',
		4 => '1934',
		'ok' => 3
	),
	5 => array(
		'ask' => '¿En qué obra de Horkheimer aparecen escritos básicos que estarían pensados para dirigir la investigación del Instituto?',
		1 => 'Teoría crítica',
		2 => 'Dialéctica de la Ilustración',
		3 => 'Crítica de la razón instrumental',
		4 => 'Sociológica',
		'ok' => 1
	),
	6 => array(
		'ask' => '¿Qué psicólogo fue encargado de sintetizar la psicología con el proyecto de los frankfurtianos?',
		1 => 'Sigmund Freud',
		2 => 'Erich Fromm',
		3 => 'Ernst Jung',
		4 => 'Alfred Adler',
		'ok' => 2
	),
	7 => array(
		'ask' => '¿Cuál de las siguientes es una característica definitoria de la Teoría Crítica de la Escuela? ',
		1 => 'Interdisciplinariedad.',
		2 => 'Crítica.',
		3 => 'Reflexividad que supere la distinción teoría-praxis.',
		4 => 'Las tres anteriores son correctas.',
		'ok' => 4
	),	
	8 => array(
		'ask' => '¿Cuáles eran las tres disciplinas más importantes de la Teoría Critica?',
		1 => 'Física, química, matemáticas.',
		2 => 'Sociología, psicología y economía.',
		3 => 'Matemáticas, física y psicología.',
		4 => 'Sociología, psicología y teología.',
		'ok' => 2
	),
	9 => array(
		'ask' => '¿Con qué teoría sociológica chocó la sociología de los frankfurtianos?',
		1 => 'Con el racionalismo crítico.',
		2 => 'Con la sociología de Norbert Elías.',
		3 => 'Con la teoría de Herbert Marcuse.',
		4 => 'Con el sociologismo positivista.',
		'ok' => 1
	),
	10 => array(
		'ask' => '¿Qué obra de los frankfurtianos se convirtió en una obra clave que inspiró algunos de los movimientos sociales de los los 60?',
		1 => 'Dialéctica de la Ilustración de Adorno y Horkheimer.',
		2 => 'El miedo a la libertad de Fromm.',
		3 => 'El hombre unidimensional de Marcuse.',
		4 => 'Crítica a la razón instrumental de Horkheimer.',
		'ok' => 3
	),
	11 => array(
		'ask' => '¿Cuál de las siguientes teorías fue la principal influencia de los frankfurtianos?',
		1 => 'El marxismo.',
		2 => 'Hegel.',
		3 => 'Kant.',
		4 => 'Schopenhauer.',
		'ok' => 1
	),	
	12 => array(
		'ask' => '¿Cuál es el contenido esencial de Dialéctica de la Ilustración? ',
		1 => 'Una reflexión histórica sobre las causas y consecuencias de la Ilustración.',
		2 => 'Una panorámica de los filósofos ilustrados más influyentes.',
		3 => 'Aplicar el pensamiento dialéctico hegeliano a la historia de la Filosofía, de modo que se compruebe cómo cada uno de los sistemas y autores tiene una relación con sus coetáneos y precedentes.',
		4 => 'Análisis de la ilustración que pretende desenmascarar ciertas ideas ocultas dentro de la misma.',
		'ok' => 4
	),	
	13 => array(
		'ask' => '¿Por qué Horkheimer y Adorno centran su pensamiento en la religión y el arte a la vuelta de su exilio?',
		1 => 'Porque siempre fue una temática fundamental de su pensamiento.',
		2 => 'Porque esta reflexión fue prohibida en la Alemania nazi.',
		3 => 'Porque ambas esferas se escapan a la racionalidad y tienen un potencial crítico.',
		4 => 'Porque eran temas actuales en los años 50.',
		'ok' => 3
	),	
	14 => array(
		'ask' => '¿Qué autor vuelve a ocupar las lecturas y la reflexión de Horkheimer a partir de los 50?',
		1 => 'Kant.',
		2 => 'Schopenhauer.',
		3 => 'Marx.',
		4 => 'Hegel.',
		'ok' => 2
	),	
	15 => array(
		'ask' => '¿Qué autor se encargó de desarrollar la teología de la Escuela de Frankfurt?',
		1 => 'Max Horkheimer.',
		2 => 'Paul Tillich.',
		3 => 'Adorno.',
		4 => 'Marcuse.',
		'ok' => 2
	),	
	16 => array(
		'ask' => '¿Cuál es uno de los principales peligros de la razón instrumental?',
		1 => 'Que no es capaz de determinar la racionalidad de los fines a los que sirve.',
		2 => 'Que cosifica la naturaleza y al resto de seres humanos.',
		3 => 'Que se limita a calcular los medios necesarios para fines dados.',
		4 => 'Las 3 anteriores son correctas.',
		'ok' => 4
	),	
	17 => array(
		'ask' => '¿Cuál de los siguientes autores es considerado como uno de los mejores intelectuales que ha surgido de la Escuela de Frankfurt? ',
		1 => 'Jürgen Habermas.',
		2 => 'Axel Honneth.',
		3 => 'Helmut Dubiel.',
		4 => 'Gerhard Brandt.',
		'ok' => 1
	),	
	18 => array(
		'ask' => '¿Cuál es, según Horkheimer, el principal peligro de la razón objetiva?',
		1 => 'Que el conocimiento se convierta en "metafísica", incapaz de captar en conceptos una realidad cambiante.',
		2 => 'Que degenere en ideología, justificando diferentes formas de opresión y barbarie.',
		3 => 'Que se privilegie la tecnificación y la dominación de la naturaleza.',
		4 => 'Las tres anteriores son válidas.',
		'ok' => 1
	),	
	19 => array(
		'ask' => '¿Qué visión de la relación entre teoría y práctica caracteriza a la Escuela?',
		1 => 'Inspirándose en Marx, afirman que toda teoría colabora con la ideología, y la práctica es mucho más importante que cualquier esfuerzo teórico. Aplican la frase del Marx, según la cual, la filosofía se ha dedicado a especular sobre el mundo, y ha llegado la hora de transformarlo.',
		2 => 'Defienden la superioridad de la teoría respecto a la práctica, pues no puede planificarse ninguna práctica concreta sin un fondo teórico que lo justifique.',
		3 => 'Teoría y práctica están íntimamente relacionados y pueden transformarse mutuamente. La práctica es el punto de partida para la reflexión teórica, que puede modificar a su vez a la práctica.',
		4 => 'Para los frankfurtianos la teoría y la práctica no guardan ningún tipo de relación.',
		'ok' => 3
	),	
	20 => array(
		'ask' => '¿Qué valoración de la Ilustración aparece en Dialéctica de la Ilustración?',
		1 => 'La Ilustración es un movimiento histórico de nefastas consecuencias para occidente, y es responsable de la barbarie, la persecución y el horror, que se manifiestan de un modo "civilizado" en grandes holocaustos y matanzas.',
		2 => 'La Ilustración debe enfocarse de un modo crítico. No podemos ser ingenuos y pensar que ya ha sido realizada, pero tampoco podemos negarla. Desde su planteamiento, la Ilustración ha desplegado momentos negativos, pero también ha mostrado momentos de verdad que deben ser conservados.',
		3 => 'La Ilustración ha sido el gran movimiento emancipatorio que ha logrado liberar al ciudadano occidental de todo tipo de barbarie y opresión. Gracias a la Ilustración se ha logrado desarrollar sociedades justas e igualitarias, y la Ilustración debe ser nuestro fundamental argumento para defendernos ante sus atacantes, partidarios de la instrumentalización del ser humano.',
		4 => 'Ninguna de la anteriores es válida.',
		'ok' => 2
	)
);


?>