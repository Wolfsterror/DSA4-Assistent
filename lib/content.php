<?php

if( !isset( $_GET["c"] ) ) {
	$_GET["c"] = 0;
}


switch( $_GET["c"] ) {
	
	default:
		echo '
			<header><h1><span aria-hidden="true" class="icon-home"></span> Startseite</h1></header>
			<article>
				<p>
				Herzlich willkommen beim DSA4-Assistenten, <p>

				Hast du schon immer ein Programm gesucht um schnell und einfach deine DSA4_Charaktere zu verwalten?<br />
				Egal ob es sich um reine Chat RGP Chars handelt oder richtige Pen & Paper Chars, hier kriegst du eine<br />
				ordentliche Basis um diese zu verwalten. Du kannst alle Werte Eintragen, eine Beschreibung hinzufügen,<br />
				Dinge weglassen und vieles mehr.<p>

				Der DSA4-Assistent wird ständig ausgebaut! Wir testen neue Funktionen und wollen<br />
				euch mehr Komfort bieten.<p>

				Die Idee, des DSA4-Assistent stammt von Wolfsterror.<br />
				Das Projekt wird realisiert durch die hervorragende Hilfe von <a href="http://pakldev.de" target="_blank">PakL</a>!<br />

			</article>';
		break;
	case 1:
		echo '
			<header><h1><span aria-hidden="true" class="icon-user"></span> User</h1></header>
			<article>
				<br />
				Hallo Reisender,<br />
				hier würdest du deine Benutzer verwaltung finden. Wobei wir uns noch nicht sicher damit sind<br />
				Aber du bist nicht eingeloggt, deswegen ist es nicht möglich, dir diese Seite gänzlichst <br />
				zu zeigen. Also schnell registrieren oder einloggen und die Welt des DSA4-Assistent erkunden<p>
				
				Viel Spaß beim weiteren Stöbern<p>

			</article>';
		break;
	case 2:
		echo '
			<header><h1><span aria-hidden="true" class="icon-clipboard"></span> Charaktere</h1></header>
			<article>
				<br />
				Hier findest du eine auflistung aller Charaktere, die von den Usern als öffentlich makiert wurden.<br />
				Jeder Char hat seine eigene Seite, klicke einfach auf den Namen um dir einen Char genauer an zu schauen<br />
				Wenn du eingeloggt bist, kriegst du sogar noch mehr Informationen. Denn neben der Liste die du hier siehst,<br />
				bekommst du noch eine Liste deiner eigenen Chars und kannst diese modofizieren<p>
				
				Also viel Spaß beim stöbern!<p>

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
			} else if( isset( $_GET["registered"] ) ) {
				echo '
			<strong style="color:green">Erfolgreich registriert. Du kannst dich nun einloggen.</strong>';
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
	case 4:
		echo '
			<header><h1><span aria-hidden="true" class="icon-key"></span> Neuen Benutzer registrieren</h1></header>';
		if( LOGGEDIN ) {
			echo '<strong>Du bist hier falsch. Wenn du eigentlich nicht eingeloggt sein solltest, <a href="index.php?c=3">logge dich bitte sofort aus.</a></strong>';
		} else {
			include 'lib/register.php';
			if( defined( "REGISTER_ERROR" ) ) {
				echo '
			<strong style="color:red">' . REGISTER_ERROR . '</strong>';
			}
			echo '
			<article>
				<form action="index.php?c=4&register" method="post">
					<table>
						<tr><td valign="top"><strong>Name:</strong></td><td><input type="text" name="register_usr" /><br /><small>Darf nicht leer sein. Leerzeichen und Tabs am Anfang und am Ende werden herausgeschnitten.</small></td></tr>
						<tr><td valign="top"><strong>Passwort:</strong></td><td><input type="password" name="register_pwd" /><br /><small>Muss aus mind. 6 Zeichen bestehen.</small></td></tr>
						<tr><td valign="top"><strong>Passwort bestätigen:</strong></td><td><input type="password" name="register_repwd" /><br /><small>Bestätige das Passwort damit wir prüfen können ob du es tatsächlich richtig eingegeben hast.</small></td></tr>
						<tr><td colspan="2" align="center"><input type="submit" value="Registrieren" /></td></tr>
					</table>
				</form>
			</article>';
		}
		break;

}