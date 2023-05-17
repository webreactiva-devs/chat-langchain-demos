<? foreach ($items as $key => $item): ?>
<li><span class="small"><?=$item[date]?> :: <?=$item[mag]?></span><br />
  <a href="<?=$item[link]?>"><?=$item[title]?></a></li>
<? endforeach; ?>
 

	