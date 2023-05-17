<ul>
<? foreach($cats as $cat): ?>
	<? if($cat['children']==1): ?>
	
	<? else: ?>
	<li><?=$cat['namelink']?>
	<? if($cat['numregs']): ?>
		(<?=$cat['numregs']?>)
	<? endif; ?>
	<? if($cat['desc']): ?>
		<br /><?=$cat['desc']?>
	<? endif; ?>
	</li>
	<? endif; ?>
<? endforeach; ?>
</ul>