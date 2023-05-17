
<h2><?=$catName?></h2>
<p class="subtitle"><?=$catDesc?></p>
<? if($catText): ?>
<div class="rightbox">
<div class="lastbox">
<h2>¿Qué es?</h2>
<?=$catText?>
</div>
</div>
<? endif; ?>
<?=$subCats?>
<div class="frontitems">
<?=$artsList?>
</div>
<p class="right"><?=$artViewAll?></p>