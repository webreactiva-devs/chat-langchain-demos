<?php
$link = mysql_connect('localhost', 'boule_iolsty', 'iv4QHUw8kjdLKw');
if (!$link) {
    die('Not connected : ' . mysql_error());
}

// make foo the current db
$db_selected = mysql_select_db('boule_boulesis', $link);
if (!$db_selected) {
    die ('Can\'t use boule_boulesis : ' . mysql_error());
}
?>

