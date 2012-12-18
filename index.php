<?php
session_start();

$s = microtime( true );

include 'inc.php';

$mysql = new mysql();
$users = new users( $mysql );
$games = new games( $mysql, $users );

include 'lib/login.php';

include 'tpl/header.html';

include 'lib/content.php';

$e = microtime( true );
include 'tpl/footer.html';