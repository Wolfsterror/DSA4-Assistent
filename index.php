<?php
$s = microtime( true );

require_once 'lib/mysql.php';
require_once 'obj/user.php';
require_once 'obj/users.php';
require_once 'obj/character.php';

$mysql = new mysql();
$user = new users( $mysql );

?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>DSA4-Assistent</title>
	</head>
	<body>
<?php

//$user->newUser( "test", "test" );

switch( $user->authUser( "test", "test" ) ) {
	case users::AUTH_SUCCESS:
		echo 'user::AUTH_SUCCESS';
		break;
	case users::AUTH_PASSWORD_WRONG:
		echo 'user::AUTH_PASSWORD_WRONG';
		break;
	case users::AUTH_USER_UNKNOWN:
		echo 'user::AUTH_USER_UNKNOWN';
		break;
}

echo '<br>';

$usr = $user->getUserByCharacterId( 2 );
$chars = $usr->getCharacter();

foreach( $chars as $char ) {
	echo $char->getInfo( character::$infoid["Name"] ) . '<br>';
}
$e = microtime( true );

echo '<footer>Created in ' . ($e-$s) . ' seconds.</footer>';
?>		
	</body>
</html>