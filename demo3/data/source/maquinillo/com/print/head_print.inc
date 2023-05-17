<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <title><? echo $siteName ?> · Versión imprimible</title>     
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<a href="/">
<img src="/media/boulesis_top_imprimir.gif" width="420" height="110" alt="Boulesis.com" border="0" />
</a>
<p>Versi&oacute;n imprimible de: <?=$artTitle?><br />
Fecha: <? echo convertDateU2LFormat(time(), "%d/%m/%Y | %H:%M"); ?><br />
Categoría: <? echo strip_tags($catRoot); ?><br />
Link: <? echo printLink($refPrintURL); ?>
</p>