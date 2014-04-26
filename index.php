<?php
session_start();

$s = microtime( true );

include 'inc.php';

$mysql = new mysql();
$users = new users( $mysql );
$games = new games( $mysql, $users );

$template = new Savant3( $templateOptions ); // For setting template options please modify inc.php

include 'lib/login.php';
include 'lib/content.php';

$template->s = $s;
$template->pagetitle = $pagetitle;
$template->display("template.tpl.php");