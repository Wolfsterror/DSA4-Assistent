<?php

if( !isset( $_GET["c"] ) ) {
	$_GET["c"] = 0;
}


switch( $_GET["c"] ) {
	
	default:
		echo '
			<header><h1><span aria-hidden="true" class="icon-home"></span> Startseite</h1></header>
			<article>
				</br>
				Herzlich willkommen beim DSA4-Assistenten, </br></br>

				Hast du schon immer ein Programm gesucht um schnell und einfach deine DSA4_Charaktere zu verwalten?</br>
				Egal ob es sich um reine Chat RGP Chars handelt oder richtige Pen & Paper Chars, hier kriegst du eine</br>
				ordentliche Basis um diese zu verwalten. Du kannst alle Werte Eintragen, eine Beschreibung hinzufügen, </br>
				Dinge weglassen und vieles mehr.</br></br>

				Der DSA4-Assistent wird ständig ausgebaut! Wir testen neue Funktionen und wollen</br>
				euch mehr Komfort bieten.</br></br>

				Die Idee, des DSA4-Assistent stammt von Wolfsterror.</br>
				Das Projekt wird realisiert durch die hervorragende Hilfe von <a href="http://pakldev.de" target="_blank">PakL</a>!</br>


			</article>';
		break;
	case 1:
		echo '
			<header><h1><span aria-hidden="true" class="icon-user"></span> User</h1></header>
			<article>
				</br>
				Hallo reisender,</br>
				hier würdest du deine Benutzer verwaltung finden. Wobei wir uns noch nicht sicher damit sind </br>
				Aber du bist nicht eingeloggt, deswegen ist es nicht möglich, dir diese Seite gänzlichst </br>
				zu zeigen. Also schnell registrieren oder einloggen und die Welt des DSA4-Assistent erkunden</br>
				</br>
				Viel Spaß beim weiteren Stöbern</br>

			</article>';
		break;
	case 2:		
		echo '
			<header><h1><span aria-hidden="true" class="icon-clipboard"></span> Charaktere</h1></header>
			<article>
				</br>
				Hier findest du eine auflistung aller Charaktere, die von den Usern als öffentlich makiert wurden.</br>
				Jeder Char hat seine eigene Seite, klicke einfach auf den Namen um dir einen Char genauer an zu schauen</br>
				Wenn du eingeloggt bist, kriegst du sogar noch mehr Informationen. Denn neben der Liste die du hier siehst,</br>
				bekommst du noch eine Liste deiner eigenen Chars und kannst diese modofizieren</br>
				</br>
				Also viel Spaß beim stöbern!</br>

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