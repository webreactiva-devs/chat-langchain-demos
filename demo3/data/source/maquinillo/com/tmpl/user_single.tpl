<h3><?=$userName?></h3>

<div class="rightbox">
<div class="lastbox">
<h2>�ltimos documentos</h2>
<ul>
<?=$docList?>
</ul>
</div>
<div class="lastbox">
<h2>�ltimos art�culos</h2>
<ul>
<?=$artsList?>
</ul>
</div>
</div>

<p><?=$userDesc?></p>
<ul>
<? if($userEmail): ?><li><a href="mailto:<?=$userEmail?>">Correo electr�nico</a></li><? endif; ?>
<? if($userWeb): ?><li><a href="<?=$userWeb?>">Sitio web</a></li><? endif; ?>
</ul>

