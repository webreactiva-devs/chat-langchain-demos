<?php
include ($_SERVER['DOCUMENT_ROOT'].'/com/basic.php');
// Conexión a la BD
require (ROOT_INC.'/fun/db_mysql.php');
require(ROOT_INC.'/dbconfig.php');
$siteDB = new Db($dbServer, $dbUser, $dbPass, $dbDataBase);
// Funciones necesarias
require(ROOT_INC.'/fun/fun_jour.php');
require(ROOT_INC.'/fun/fun_articles.php');
require(ROOT_INC.'/fun/fun_docs.php');
require(ROOT_INC.'/fun/fun_news.php');
require(ROOT_INC.'/fun/fun_categories.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Estadísticas del weblog</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
TABLE{
	width: 100%;
	border-bottom: 2px solid #990033;
	border-left: 1px solid #999999;
}
CAPTION{
	font: bold italic 110% "Trebuchet MS", Arial, Helvetica, sans-serif;
}
TH, TH A, TH A:link, TH A:hover, TH A:visited {
	color: #FFFFFF;
	background-color: #990033;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 13px;
	padding: .3em 0;
}
TD{
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-size: 13px;
	border-right: 1px solid #999999;
}
-->
</style>
</head>

<body>
<table style="width:50%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr >
    <td style="border-right: 0; text-align: center;"><a href="/admin/stats/didactica.php?case=articles" >Artículos</a></td>
    <td style="border-right: 0; text-align: center;"><a href="/admin/stats/didactica.php?case=news" >Notas</a></td>
    <td style="border-right: 0; text-align: center;"><a href="/admin/stats/didactica.php?case=documents" >Documentos</a></td>
</tr>
</table>
<br />
<table width="100%"  border="0" cellspacing="0" cellpadding="2">
	<caption>Estadísticas de Didáctica</caption>
    <colgroup align="right" span="1" width="10px"></colgroup>
	<colgroup span="1"></colgroup>
	<colgroup span="1" width="8%" align="center"></colgroup>
	<colgroup span="2" width="16%" align="center"></colgroup>
	<colgroup span="2" width="8%" align="center"></colgroup>
  <tr>
    <th scope="col">&nbsp;</th>
    <th scope="col"><a href="?case=<?=$_GET['case']?>&o=tit">T&iacute;tulo</a></th>
	<th scope="col"><a href="?case=<?=$_GET['case']?>&o=hit">Visitas</a></th>
    <th scope="col"><a href="?case=<?=$_GET['case']?>&o=mag">Magazine</a></th>
	<th scope="col"><a href="?case=<?=$_GET['case']?>&o=cat">Categor&iacute;a</a></th>
    <th scope="col"><a href="?case=<?=$_GET['case']?>&o=tim">Hora</a></th>
    <th scope="col"><a href="?case=<?=$_GET['case']?>&o=tim">D&iacute;a</a></th>
  </tr>
<?php

viewStats($_GET['case']);
?>
</table>
</body>
</html>