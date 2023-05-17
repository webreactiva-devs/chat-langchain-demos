
<div class="frontitem">
<? if ($itemImage): ?>
<img src="<?=$itemImageURL?>" <?=$itemImageData?> border="1" />
<? endif; ?>
<h3 class="with-ads"><?=$artLinkTitle?></h3>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- boulesis-titulo-apuntes -->
<ins class="adsbygoogle"
     style="display:inline-block;width:468px;height:60px"
     data-ad-client="ca-pub-7110432088770954"
     data-ad-slot="9884693973"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<? if ($artExcerpt): ?>
<p><?=$artExcerpt?> &raquo; <a href="<?=$artLink?>"><em>Ver</em></a></p>
<? endif; ?>
<div class="author"><a href="<?=$artLink?>">&#0167;</a> | <?=$artDate?><? if($artUserName): ?>| Enviado por <a href="/didactica/usuarios/?u=<?=$artUserID?>"><?=$artUserName?></a> <? endif; ?> |<? if ($artCat): ?> | <?=$artCat?><? endif; ?></div>
</div>
