
<div class="frontitem">
<? if ($itemImage): ?>
<img src="<?=$itemImageURL?>" <?=$itemImageData?> border="1" />
<? endif; ?>
<h3><?=$artLinkTitle?></h3>
<? if ($artExcerpt): ?>
<p><?=$artExcerpt?> &raquo; <a href="<?=$artLink?>"><em>Ver</em></a></p>
<? endif; ?>
<div class="author"><a href="<?=$artLink?>">&#0167;</a> | <?=$artDate?><? if($artUserName): ?>| Enviado por <a href="/didactica/usuarios/?u=<?=$artUserID?>"><?=$artUserName?></a> <? endif; ?><? if ($artCat): ?> | <?=$artCat?><? endif; ?></div>
</div>
