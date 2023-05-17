<?php


class Form
{

var $classField;
var $classArea;
var $classButton;
var $classLabel;
var $myType;
var $myName;
var $myLabel;
var $myKey;
var $myTab;
var $DataPostOn;
var $fieldsetOn;


function Form($myId='formid', $myData='', $myAction='', $myEnc=''){
	if($myAction=='')
		$myAction=$_SERVER['REQUEST_URI'];
	
	if($myData=='post')
		$this->DataPostOn = 1;
	else
		$this->DataPostOn = 0;
		
	$this->classField = 'formfield';
	$this->classArea = 'formtextarea';
	$this->classButton = 'formbutton';
	$this->classLabel = 'text';
	$this->myTab = 0;
	//Mostramos el inicio de formulario
	$htmlup = '<form action="'.$myAction.'" method="post" '.'id="'.$myId.'" ';
	if($myEnc)
		$htmlup .= ' enctype="'.$myEnc.'" ';
	$htmlup .= ' >'."\n";
	echo $htmlup;
}

function printLabel($hidden='0'){
	if ($this->myName!='')
		$htmlup = '<label for="'.$this->myName.'" ';
	if ($this->myKey!='')
		$htmlup .= 'accesskey="'.$this->myKey.'" ';
	
	if ($hidden==1)
		$htmlup .= 'class="noshow" style="display:none;"';
	else
		$htmlup .= 'class="'.$this->classLabel.'" ';
		
	if ($this->myTab!=0){
		$htmlup .= 'tabindex="'.$this->myTab.'" ';
		$this->myTab++;
		}
	$htmlup .= '>'.$this->myLabel.'</label>'."\n";
	if($hidden==0)
		$htmlup .= '<br />'."\n";
		
	return $htmlup;
	}

function printTextarea($myCols='', $myRows='', $wrap='virtual'){
	$htmlup = '<textarea name="'.$this->myName.'" '.'id="'.$this->myName.'" ';
	if ($myCols || $myRows)
		$htmlup .= 'cols="'.$myCols.'" rows="'.$myRows.'" ';
	if ($wrap)
		$htmlup .= 'wrap="'.$wrap.'" ';
	$htmlup .= 'class="'.$this->classArea.'" >';	
	$htmlup .= $this->myValue."\n";
	$htmlup .= '</textarea><br />'."\n";
	return $htmlup;
}

function printSelect($multipleOn = 0, $mySelected = ''){
	$htmlup = '<select name="'.$this->myName.'" '.'id="'.$this->myName.'" ';
	if($multipleOn==1)
		$htmlup .= 'multiple ';
	if($this->mySize!='')
		$htmlup .= 'size ="'.$this->mySize.'" ';
	
	$htmlup .= 'class="'.$this->classField.'" ';
	$htmlup .= '>'."\n";
		
	//Mostramos las opciones
	foreach($this->myValue as $key => $data){
		$htmlup .= '<option value="'.$key.'" ';
		
		//Si pasamos solo un uno, marca la primera opción
		if ($mySelected==1&&$mySelectedMark!=1){
			$htmlup .= 'selected="selected" ';
			$mySelectedMark=1;
			}
		
		if ($mySelected[$key]==1)
			$htmlup .= 'selected="selected" ';
		$htmlup .= '>'.$data.'</option>'."\n";
	}
	
	$htmlup .= '</select>'.'<br />'."\n";
	return $htmlup;
	
}
	
function printImput(){
	$htmlup = '<input type="'.$this->myType.'" '.'name="'.$this->myName.'" '.'id="'.$this->myName.'" ';
	if ($this->myValue!='') //||$this->myType=='checkbox'||$this->myType=='radio')
		$htmlup .= 'value ="'.$this->myValue.'" ';
	if($this->mySize!='')
		$htmlup .= 'size ="'.$this->mySize.'" ';
	if($this->mySize==''&&$this->myType=='text')
		$htmlup .= 'size ="30" ';
		
	switch($this->myType){
		case 'hidden':
			$htmlup .= '/>'."\n";
			break;
		case 'checkbox':
		case 'radio':
			$htmlup .= 'class="'.$this->classField.'" ';
			if ($this->myValue==1 || $this->myValue=='on')
				$htmlup .= 'checked="checked" ';
			else
				$htmlup .= '';
			$htmlup .= '/>'."\n";
			break;
		case 'submit':
		case 'button':
			$htmlup .= 'class="'.$this->classButton.'" ';
			$htmlup .= '/>'."\n";
			break;
		default:
			$htmlup .= 'class="'.$this->classField.'" ';
			$htmlup .= '/><br />'."\n";
	}
	
	return $htmlup;
	}
	
function addTextarea($myName, $myLabel, $myValue='', $myKey='', $myCols='', $myRows='', $wrap=''){

	$this->myType = 'textarea';
	$this->myName = $myName;
	$this->myLabel = $myLabel;
	$this->myKey = $myKey;
	
	//Si existe algún valor, lo incluimos
	if ($_POST[$this->myName] && $this->DataPostOn==1)
		$this->myValue = $_POST[$this->myName];
	else
		$this->myValue = $myValue;
		
	$html = $this->printLabel();
	$html .= $this->printTextarea($myCols, $myRows);
	
	echo $html;
	return;
}

function addSelect ($myName, $myLabel, $myValue='', $mySelect='1', $mySize='', $myKey='', $multipleOn='0'){

	$this->myType = 'select';
	$this->myName = $myName;
	$this->myLabel = $myLabel;
	$this->myKey = $myKey;
	$this->mySize = $mySize;
	
	//Si existe algún valor, lo incluimos
	if ($_POST[$this->myName] && $this->DataPostOn==1)
		$this->myValue = $_POST[$this->myName];
	else
		$this->myValue = $myValue;
		
	$html = $this->printLabel();
	$html .= $this->printSelect($multipleOn, $mySelect);
	
	echo $html;
	return;
}
	
function addField($myType, $myName, $myLabel, $myValue='', $mySize='', $myKey=''){
	
	$this->myType = $myType;
	$this->myName = $myName;
	$this->myLabel = $myLabel;
	$this->myKey = $myKey;
	$this->mySize = $mySize;
	
	//Si existe algún valor, lo incluimos
	if ($_POST[$this->myName] && $this->DataPostOn==1)
		$this->myValue = $_POST[$this->myName];
	else
		$this->myValue = $myValue;
	
	
	switch ($this->myType){
		case 'textarea':
			$html = $this->printLabel();
			$html .= $this->printTextarea($myCols, $myRows);
			break;
		case 'hidden':
			$html .= $this->printImput();
			break;
		case 'button':
			$html = $this->printLabel(1);
			$html .= $this->printImput();
			break;
		case 'submit':
			$html = $this->printLabel(1);
			$html .= $this->printImput();
			break;
		case 'checkbox':
		case 'radio':
			$html = $this->printImput();
			$html .= $this->printLabel();
			break;
		case 'select':
			$html = $this->printLabel();
			$html .= $this->printSelect($multipleOn, $mySelect);
			break;
		default:
			$html = $this->printLabel();
			$html .= $this->printImput(); 
			break; 
		}
	echo $html;
	return;
	}
	
function printFieldset($myLabel){
	
	$this->myLabel = $myLabel;
	
	//Si no hemos abierto fieldset
	if ($this->fieldsetOn==0){
		$htmlup = '<fieldset>';
		$htmlup .= '<legend>'.$this->myLabel.'</legend>'."\n";
		$this->fieldsetOn = 1;
		echo $htmlup;
	}
	
	//Si tenemos abierto el fieldset
	else{
		$htmlup = '</fieldset>'."\n";
		$this->fieldsetOn = 0;
		echo $htmlup;
		$this->printFieldset($this->myLabel);
	}
	
	return;
}
	
function endForm(){
	
	//Cerramos el fieldset si está abierto
	if ($this->fieldsetOn==1){
		$html = '</fieldset>';
		$this->fieldsetOn = 0;
		}
	echo $html.'</form><br />'."\n";
	}
}
// FIN CLASE 

?>

