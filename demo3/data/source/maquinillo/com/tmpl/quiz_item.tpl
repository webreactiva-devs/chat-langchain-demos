<div class="itemquiz<?=$itemQCheck?>">
	<h3 class="question"><?=$itemQQuestion?>.- <?=$itemQAnswers['ask']?></h3>
<? foreach($itemQAnswers as $num => $ans): ?>
 <? if(is_int($num)): ?>
  <? if($itemQType=='end'): ?>
   <? if($itemQAnswerActive == $num): ?><span style="font-weight: bold"><? else: ?><span style="color: silver"><? endif; ?>
  <? else: ?>
<input type="radio" name="quizAnswers[<?=$itemQQuestion?>]" value="<?=$num?>" <? if($itemQAnswerActive == $num): ?>checked="checked"<? endif; ?> /><span>
  <? endif; ?>
<label><?=$ans?></label></span>
<br />
 <? endif; ?>
<? endforeach; ?>
</div>

