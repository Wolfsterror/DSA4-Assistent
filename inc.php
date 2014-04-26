<?php
// Options

$pagetitle = "DSA4-Assistent";
$notfound = '
			<header><h1><span aria-hidden="true" class="icon-wrench"></span> {OBJECT} nicht gefunden</h1></header>
			<article><strong>{OBJECT} konnte nicht gefunden werden.</strong><br />{REASON}</article>';

$templateOptions = array(
						"template_path" => "tpl/",
						"resource_path" => "tpl/res/",
						"error_text" => "Es ist ein Fehler im Template aufgetreten."
					);


// Do not change anything after this comment
require_once 'lib/password.php'; // ircmaxell's password_compat (https://github.com/ircmaxell/password_compat)
require_once 'lib/mysql.php';
require_once 'lib/Savant3.php';
require_once 'obj/user.php';
require_once 'obj/users.php';
require_once 'obj/character.php';
require_once 'obj/game.php';
require_once 'obj/games.php';