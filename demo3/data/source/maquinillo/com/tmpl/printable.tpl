<?=$headPrintable?>
<h1><?=$artTitle?></h1>
<? if ($artExcerpt): ?>
<p><?=$artExcerpt?></p>
<? endif; ?>
<? if($artChapterTitle): 
	foreach ($artBody as $key => $body): ?>
	<h2><?=$artChapterTitle[$key]?></h2>
	<?=$body?>
	<? endforeach; 
else: ?>
	<?=$artBody[0]?>
<? endif; ?>

<?=$footPrintable?>

	