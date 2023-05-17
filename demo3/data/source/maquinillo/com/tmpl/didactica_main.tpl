<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>
<?php
echo $title;
?>
</title>
<?php
include (ROOT_INC.'/meta.inc');
?>
</head>
<body>
<?php
include (ROOT_INC.'/top.inc');
?>
<div id="side">
<?php
printBoulesisName($selectCSS);
?>
<div id="menuver">
<?php
printMenu();
?>
</div>

<?php 
echo $contentMain;
?>

<?php include (ROOT_INC.'/footer.inc'); ?>
</body>
</html>