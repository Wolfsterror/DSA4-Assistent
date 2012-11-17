<?php
require_once 'lib/mysql.php';
require_once 'obj/user.php';

$mysql = new mysql();
$user = new user( $mysql );
?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>DSA4-Assistent</title>
	</head>
	<body>
<?php

//$user->newUser( "test", "test" );

var_dump( $user->authUser( "test", "test" ) );

?>		
	</body>
</html>