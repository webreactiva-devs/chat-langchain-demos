<h2><?=$docTitle?></h2>
<?=$optionsBox?>
<p><a href="<?=$docLink?>">&#0167;</a> <?=$docDesc?>
<? if($docRelLink): ?> &middot; <a href="<?=$docRelLink?>" title="Enlace relacionado con este documento">Más información</a><? endif; ?></p>
<ul>
<li>Nombre: <span style="color:#999999"><?=$docName?></span></li>
<li>Tamaño: <?=$docSize?></li>
<li>Fecha: <?=$docDate?></li>
<? if($docUserName): ?><li>Enviado por <a href="/didactica/usuarios/?u=<?=$docUserID?>"><?=$docUserName?></a> </li><? endif; ?>
</ul>

<div class="date"><!--<a href="/descargar/?d=<?=$docID?>">--><a href="<?=$docURL?>"><img src="/media/icons/i_<?=$docExt?>.gif" width="38" height="24" alt="Descargar <?=$docTitle?>. Archivo <?=$docExt?>. <?=$docExtDesc?>" border="0" class="left" style="margin-right: 5px;"/>Descargar</a>*</div>
<p class="small">* Si quieres enlazar este documento utiliza este <a href="<?=$docLink?>">enlace permanente</a></p>


