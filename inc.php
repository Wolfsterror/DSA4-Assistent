<?php
// Options

$pagetitle = "DSA4-Assistent";
$notfound = '
			<header><h1><span aria-hidden="true" class="icon-wrench"></span> {OBJECT} nicht gefunden</h1></header>
			<article><strong>{OBJECT} konnte nicht gefunden werden.</strong><br />{REASON}</article>';


// Do not change anything after this comment
require_once 'lib/mysql.php';
require_once 'obj/user.php';
require_once 'obj/users.php';
require_once 'obj/character.php';
require_once 'obj/game.php';
require_once 'obj/games.php';