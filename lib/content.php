<?php

if( !isset( $_GET["c"] ) ) {
	$_GET["c"] = 0;
}


switch( $_GET["c"] ) {
	
	default:
		echo '
			<header><h1><span aria-hidden="true" class="icon-home"></span> Startseite</h1></header>
			<article>
				<!-- TODO: Text! -->
			</article>';
		break;
	case 1:
		echo '
			<header><h1><span aria-hidden="true" class="icon-user"></span> User</h1></header>
			<article>
				<!-- TODO: Text! -->
			</article>';
		break;
	case 3:
		if( LOGGEDIN ) {
			if( isset( $_GET["login"] ) ) {
				header( "Location: index.php?c=0" );
			} else {
				session_destroy();
				header( "Location: index.php?c=3&loggedout" );
			}
		} else {
			echo '
			<header><h1><span aria-hidden="true" class="icon-enter"></span> Einloggen</h1></header>';
			if( isset( $_GET["loggedout"] ) ) {
				echo '
			<strong style="color:green">Erfolgreich ausgeloggt.</strong>';
			} else if( isset( $_POST["login_usr"] ) ) {
				switch( LOGINERROR ) {
					default:
						echo '
			<strong style="color:red">Einloggen fehlgeschlagen.</strong>';
						break;
					case users::AUTH_USER_UNKNOWN:
						echo '
			<strong style="color:red">Benutzer nicht gefunden.</strong>';
						break;
					case users::AUTH_PASSWORD_WRONG:
						echo '
			<strong style="color:red">Falsches Passwort.</strong>';
						break;
				}
			}
			echo '
			<article>
				<form action="index.php?c=3&login" method="post">
					<table>
						<tr><td><strong>Name:</strong></td><td><input type="text" name="login_usr" /></td></tr>
						<tr><td><strong>Passwort:</strong></td><td><input type="password" name="login_pwd" /></td></tr>
						<tr><td colspan="2" align="center"><input type="submit" value="Einloggen" /></td></tr>
					</table>
				</form>
			</article>';
		}
		break;

}