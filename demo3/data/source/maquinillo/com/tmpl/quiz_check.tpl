<p><?=$quizCheckMsg?><br />
<input type="hidden" name="quizAnswers" value='<?=$quizCheckAns?>' />
<? if($quizPerfect!=1): ?>
	<input type="submit" class="formbutton" name="btn_correct" value="Corregir errores" />
	<br />
<? endif; ?>
<input type="submit" class="formbutton" name="btn_end" value="Ver soluciones" />
</p>