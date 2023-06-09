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

$quizAsks = array(
	1 => array(
		'ask' => '�En qu� a�o se fund� la Escuela de Frankfurt?',
		1 => '1925',
		2 => '1926',
		3 => '1924',
		4 => '1923',
		'ok' => 4
	),
	2 => array(
		'ask' => '�Cu�l de los siguientes hechos hist�ricos provocaron un giro en el pensamiento de Adorno y Horkheimer?',
		1 => 'El ascenso al poder de Hitler.',
		2 => 'El exilio y la persecuci�n nazi.',
		3 => 'La intervenci�n norteamericana en la II guerra mundial.',
		4 => 'El fin de la segunda guerra mundial.',
		'ok' => 2
	),
	3 => array(
		'ask' => '�Cu�l de los siguientes autores no intervino en la fundaci�n del Instituto para la Investigaci�n Social?',
		1 => 'Max Horkheimer.',
		2 => 'Friedrich Pollock.',
		3 => 'F�lix Weil.',
		4 => 'Kurt Albert Gerlach.',
		'ok' => 1
	),
	4 => array(
		'ask' => '�En qu� a�o fue nombrado Horkheimer director del Instituto?',
		1 => '1930',
		2 => '1932',
		3 => '1931',
		4 => '1934',
		'ok' => 3
	),
	5 => array(
		'ask' => '�En qu� obra de Horkheimer aparecen escritos b�sicos que estar�an pensados para dirigir la investigaci�n del Instituto?',
		1 => 'Teor�a cr�tica',
		2 => 'Dial�ctica de la Ilustraci�n',
		3 => 'Cr�tica de la raz�n instrumental',
		4 => 'Sociol�gica',
		'ok' => 1
	),
	6 => array(
		'ask' => '�Qu� psic�logo fue encargado de sintetizar la psicolog�a con el proyecto de los frankfurtianos?',
		1 => 'Sigmund Freud',
		2 => 'Erich Fromm',
		3 => 'Ernst Jung',
		4 => 'Alfred Adler',
		'ok' => 2
	),
	7 => array(
		'ask' => '�Cu�l de las siguientes es una caracter�stica definitoria de la Teor�a Cr�tica de la Escuela? ',
		1 => 'Interdisciplinariedad.',
		2 => 'Cr�tica.',
		3 => 'Reflexividad que supere la distinci�n teor�a-praxis.',
		4 => 'Las tres anteriores son correctas.',
		'ok' => 4
	),	
	8 => array(
		'ask' => '�Cu�les eran las tres disciplinas m�s importantes de la Teor�a Critica?',
		1 => 'F�sica, qu�mica, matem�ticas.',
		2 => 'Sociolog�a, psicolog�a y econom�a.',
		3 => 'Matem�ticas, f�sica y psicolog�a.',
		4 => 'Sociolog�a, psicolog�a y teolog�a.',
		'ok' => 2
	),
	9 => array(
		'ask' => '�Con qu� teor�a sociol�gica choc� la sociolog�a de los frankfurtianos?',
		1 => 'Con el racionalismo cr�tico.',
		2 => 'Con la sociolog�a de Norbert El�as.',
		3 => 'Con la teor�a de Herbert Marcuse.',
		4 => 'Con el sociologismo positivista.',
		'ok' => 1
	),
	10 => array(
		'ask' => '�Qu� obra de los frankfurtianos se convirti� en una obra clave que inspir� algunos de los movimientos sociales de los los 60?',
		1 => 'Dial�ctica de la Ilustraci�n de Adorno y Horkheimer.',
		2 => 'El miedo a la libertad de Fromm.',
		3 => 'El hombre unidimensional de Marcuse.',
		4 => 'Cr�tica a la raz�n instrumental de Horkheimer.',
		'ok' => 3
	),
	11 => array(
		'ask' => '�Cu�l de las siguientes teor�as fue la principal influencia de los frankfurtianos?',
		1 => 'El marxismo.',
		2 => 'Hegel.',
		3 => 'Kant.',
		4 => 'Schopenhauer.',
		'ok' => 1
	),	
	12 => array(
		'ask' => '�Cu�l es el contenido esencial de Dial�ctica de la Ilustraci�n? ',
		1 => 'Una reflexi�n hist�rica sobre las causas y consecuencias de la Ilustraci�n.',
		2 => 'Una panor�mica de los fil�sofos ilustrados m�s influyentes.',
		3 => 'Aplicar el pensamiento dial�ctico hegeliano a la historia de la Filosof�a, de modo que se compruebe c�mo cada uno de los sistemas y autores tiene una relaci�n con sus coet�neos y precedentes.',
		4 => 'An�lisis de la ilustraci�n que pretende desenmascarar ciertas ideas ocultas dentro de la misma.',
		'ok' => 4
	),	
	13 => array(
		'ask' => '�Por qu� Horkheimer y Adorno centran su pensamiento en la religi�n y el arte a la vuelta de su exilio?',
		1 => 'Porque siempre fue una tem�tica fundamental de su pensamiento.',
		2 => 'Porque esta reflexi�n fue prohibida en la Alemania nazi.',
		3 => 'Porque ambas esferas se escapan a la racionalidad y tienen un potencial cr�tico.',
		4 => 'Porque eran temas actuales en los a�os 50.',
		'ok' => 3
	),	
	14 => array(
		'ask' => '�Qu� autor vuelve a ocupar las lecturas y la reflexi�n de Horkheimer a partir de los 50?',
		1 => 'Kant.',
		2 => 'Schopenhauer.',
		3 => 'Marx.',
		4 => 'Hegel.',
		'ok' => 2
	),	
	15 => array(
		'ask' => '�Qu� autor se encarg� de desarrollar la teolog�a de la Escuela de Frankfurt?',
		1 => 'Max Horkheimer.',
		2 => 'Paul Tillich.',
		3 => 'Adorno.',
		4 => 'Marcuse.',
		'ok' => 2
	),	
	16 => array(
		'ask' => '�Cu�l es uno de los principales peligros de la raz�n instrumental?',
		1 => 'Que no es capaz de determinar la racionalidad de los fines a los que sirve.',
		2 => 'Que cosifica la naturaleza y al resto de seres humanos.',
		3 => 'Que se limita a calcular los medios necesarios para fines dados.',
		4 => 'Las 3 anteriores son correctas.',
		'ok' => 4
	),	
	17 => array(
		'ask' => '�Cu�l de los siguientes autores es considerado como uno de los mejores intelectuales que ha surgido de la Escuela de Frankfurt? ',
		1 => 'J�rgen Habermas.',
		2 => 'Axel Honneth.',
		3 => 'Helmut Dubiel.',
		4 => 'Gerhard Brandt.',
		'ok' => 1
	),	
	18 => array(
		'ask' => '�Cu�l es, seg�n Horkheimer, el principal peligro de la raz�n objetiva?',
		1 => 'Que el conocimiento se convierta en "metaf�sica", incapaz de captar en conceptos una realidad cambiante.',
		2 => 'Que degenere en ideolog�a, justificando diferentes formas de opresi�n y barbarie.',
		3 => 'Que se privilegie la tecnificaci�n y la dominaci�n de la naturaleza.',
		4 => 'Las tres anteriores son v�lidas.',
		'ok' => 1
	),	
	19 => array(
		'ask' => '�Qu� visi�n de la relaci�n entre teor�a y pr�ctica caracteriza a la Escuela?',
		1 => 'Inspir�ndose en Marx, afirman que toda teor�a colabora con la ideolog�a, y la pr�ctica es mucho m�s importante que cualquier esfuerzo te�rico. Aplican la frase del Marx, seg�n la cual, la filosof�a se ha dedicado a especular sobre el mundo, y ha llegado la hora de transformarlo.',
		2 => 'Defienden la superioridad de la teor�a respecto a la pr�ctica, pues no puede planificarse ninguna pr�ctica concreta sin un fondo te�rico que lo justifique.',
		3 => 'Teor�a y pr�ctica est�n �ntimamente relacionados y pueden transformarse mutuamente. La pr�ctica es el punto de partida para la reflexi�n te�rica, que puede modificar a su vez a la pr�ctica.',
		4 => 'Para los frankfurtianos la teor�a y la pr�ctica no guardan ning�n tipo de relaci�n.',
		'ok' => 3
	),	
	20 => array(
		'ask' => '�Qu� valoraci�n de la Ilustraci�n aparece en Dial�ctica de la Ilustraci�n?',
		1 => 'La Ilustraci�n es un movimiento hist�rico de nefastas consecuencias para occidente, y es responsable de la barbarie, la persecuci�n y el horror, que se manifiestan de un modo "civilizado" en grandes holocaustos y matanzas.',
		2 => 'La Ilustraci�n debe enfocarse de un modo cr�tico. No podemos ser ingenuos y pensar que ya ha sido realizada, pero tampoco podemos negarla. Desde su planteamiento, la Ilustraci�n ha desplegado momentos negativos, pero tambi�n ha mostrado momentos de verdad que deben ser conservados.',
		3 => 'La Ilustraci�n ha sido el gran movimiento emancipatorio que ha logrado liberar al ciudadano occidental de todo tipo de barbarie y opresi�n. Gracias a la Ilustraci�n se ha logrado desarrollar sociedades justas e igualitarias, y la Ilustraci�n debe ser nuestro fundamental argumento para defendernos ante sus atacantes, partidarios de la instrumentalizaci�n del ser humano.',
		4 => 'Ninguna de la anteriores es v�lida.',
		'ok' => 2
	)
);


?>