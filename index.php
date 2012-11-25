<?php
$s = microtime( true );

include 'inc.php';

$mysql = new mysql();
$user = new users( $mysql );

include 'tpl/header.html';

include 'lib/content.php';

$e = microtime( true );
include 'tpl/footer.html';