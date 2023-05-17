<?php

// Cuestionarios

// Funciones del cuestionario

// Muestra el cuestionario segun el segundo parámetro
// 'normal' : limpio, listo para responder
// 'correct' : con las preguntas fallidas señaladas, listo para responder
// 'end' : con las respuestas correctas señaladas
function printQuiz($myData, $myType = 'normal'){
	
	foreach($myData as $question => $answer){
	
		$item_quiz = & new Template(ROOT_TMPL.'/');
		$item_quiz->set('itemQQuestion', $question);
		$item_quiz->set('itemQAnswers', $answer);
		
		if($myType == 'correct' && $_POST['quizAnswers']){
			// Comprobamos si es correcto
			if($_POST['quizAnswers'][$question] != $answer['ok'])
				$item_quiz->set('itemQCheck', ' error');
			// Respuesta marcada
			$item_quiz->set('itemQAnswerActive', $_POST['quizAnswers'][$question]);
		}
		
		elseif($myType == 'end'){
			// Respuesta correcta
			$item_quiz->set('itemQAnswerActive', $answer['ok']);
		}
		
		$item_quiz->set('itemQType', $myType);
		
		$itemsQuiz .= $item_quiz->fetch('quiz_item.tpl');
	
	}
	
	return $itemsQuiz;
}

// Calcula el nº de errores
function checkQuiz($myData, $myAnswers){
	$errors = 0;
	foreach($myAnswers as $question => $answer){
		if($myData[$question]['ok'] != $answer)
			$errors++;
	}
	if(sizeof($myData) != sizeof($myAnswers));
		$errors = $errors + sizeof($myData) - sizeof($myAnswers);
	return $errors;
}

// Funcion serialize personal
function mySerialize($array){

	foreach ($array as $key => $value)
		$string .= $key.'=>'.$value.'||';
	
	return $string;
}

// Funcion serialize personal
function myUnserialize($string){

	$aux1 = explode('||', $string);
	array_pop($aux1);
	foreach ($aux1 as $value){
		$aux2 = explode('=>', $value);
		$array[$aux2[0]]=$aux2[1];
	}
	return $array;
}

// Procedimientos para mostrar y resolver el cuestionario
$asksNum = sizeof($quizAsks);

// Primera vez que se muestra el cuestionario
if(!$_POST){

	$contentQuiz = printQuiz($quizAsks);
	$contentQuiz .= '<br /><input type="submit" class="formbutton" name="btn_check" value="Comprobar respuestas" />';

}

// Ya se han enviado respuestas
elseif($_POST['quizAnswers']){
	
	// Nº de errores y opciones (corregir o ver resuelto)
	if($_POST['btn_check']){
	
		$errors = checkQuiz($quizAsks, $_POST['quizAnswers']);
		$errorsRel = sprintf("%1.1f", 100*$errors/$asksNum);
		$quiz_check = & new Template(ROOT_TMPL.'/');
		
		// Resultado perfecto
		if($errors == 0){
			$checkMsg = '<strong>¡Cuestionario perfecto!</strong>.';
			$quiz_check->set('quizPerfect', 1);
			}
		// Al menos un error
		else{
			$checkMsg = 'Ha fallado o no ha respondido '.$errors.' preguntas. Un '.$errorsRel.'% de errores';
		}
		$quiz_check->set('quizCheckMsg', $checkMsg);
		$quiz_check->set('quizCheckAns', mySerialize($_POST['quizAnswers'])); 
		
		$contentQuiz = $quiz_check->fetch('quiz_check.tpl');
	}
	
	// Cuestionario con errores marcados
	elseif($_POST['btn_correct']){
		
		$aux = myUnserialize($_POST['quizAnswers']);
		$_POST['quizAnswers'] = $aux;
		
		$contentQuiz = '<p style="text-weight: bold; font-size: 110%">Las preguntas marcadas con una respuesta equivocada son las de fondo amarillo y borde rojo</p>';
		$contentQuiz .= printQuiz($quizAsks, 'correct');
		$contentQuiz .= '<br /><input type="submit" class="formbutton" name="btn_check" value="Corregir errores" />';
	
	}

	// Solución final del cuestionario
	elseif($_POST['btn_end']){

		$contentQuiz = printQuiz($quizAsks, 'end');

	}
}

// Si se llama desde fuera del formulario a la solución
	// Solución final del cuestionario
elseif($_GET['versolucion']=='ok'){

	$contentQuiz = printQuiz($quizAsks, 'end');

}



$quiz_form = & new Template(ROOT_TMPL.'/');
$quiz_form->set('contentQuiz', $contentQuiz);
$formQuiz = $quiz_form->fetch('quiz_form.tpl');
echo $formQuiz;

?>