<?php
include ('basic.php');

include (ROOT_AD_INC.'/head.inc.php');

include (ROOT_AD_INC.'/top.inc.php');

echo printContHead('CMS de boulesis.com');

$data = getLastInsert();
printLastInsert($data, 'rss');
printLastInsert($data, 'savehtml');

echo printContFoot();
include (ROOT_AD_INC.'/foot.inc.php');

?>