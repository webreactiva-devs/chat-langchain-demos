<h3><?=$userName?></h3>

<div class="rightbox">
<div class="lastbox">
<h2>Últimos documentos</h2>
<ul>
<?=$docList?>
</ul>
</div>
<div class="lastbox">
<h2>Últimos artículos</h2>
<ul>
<?=$artsList?>
</ul>
</div>
</div>

<p><?=$userDesc?></p>
<ul>
<? if($userEmail): ?><li><a href="mailto:<?=$userEmail?>">Correo electrónico</a></li><? endif; ?>
<? if($userWeb): ?><li><a href="<?=$userWeb?>">Sitio web</a></li><? endif; ?>
</ul>

