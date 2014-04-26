<?php

if( !isset( $_GET["c"] ) ) {
	$_GET["c"] = 0;
}


switch( $_GET["c"] ) {
	
	default:
		$template->contentTemplate = 'homepage.tpl.php';
		break;
	case 1:
		$template->content = '
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
		$template->content = '
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
			$template->content = '
			<header><h1><span aria-hidden="true" class="icon-enter"></span> Einloggen</h1></header>';
			if( isset( $_GET["loggedout"] ) ) {
				$template->content .= '
			<strong style="color:green">Erfolgreich ausgeloggt.</strong>';
			} else if( isset( $_GET["registered"] ) ) {
				$template->content .= '
			<strong style="color:green">Erfolgreich registriert. Du kannst dich nun einloggen.</strong>';
			} else if( isset( $_POST["login_usr"] ) ) {
				switch( LOGINERROR ) {
					default:
						$template->content .= '
			<strong style="color:red">Einloggen fehlgeschlagen.</strong>';
						break;
					case users::AUTH_USER_UNKNOWN:
						$template->content .= '
			<strong style="color:red">Benutzer nicht gefunden.</strong>';
						break;
					case users::AUTH_PASSWORD_WRONG:
						$template->content .= '
			<strong style="color:red">Falsches Passwort.</strong>';
						break;
				}
			}
			$template->content .= '
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
		$template->content .= '
			<header><h1><span aria-hidden="true" class="icon-key"></span> Neuen Benutzer registrieren</h1></header>';
		if( LOGGEDIN ) {
			$template->content .= '<strong>Du bist hier falsch. Wenn du eigentlich nicht eingeloggt sein solltest, <a href="index.php?c=3">logge dich bitte sofort aus.</a></strong>';
		} else {
			include 'lib/register.php';
			if( defined( "REGISTER_ERROR" ) ) {
				$template->content .= '
			<strong style="color:red">' . REGISTER_ERROR . '</strong>';
			}
			$template->content .= '
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
	case 5:
		$template->content .= '
			<header><h1><span aria-hidden="true" class="icon-wrench"></span> Einstellungen</h1></header>
			<article>
				<br />
				Text folgt
				<br />
			</article>';
		break;
	case 6:
		if( LOGGEDIN ) {
			$template->content .= '
			<header><h1><span aria-hidden="true" class="icon-book"></span> Gruppen</h1></header>
			<article>';
			if( isset( $_POST["newgame"] ) ) {
				if( !empty( $_POST["gname"] ) ) {
					$newgame = new game( -1, $_POST["gname"], "", $users->getUserById( LOGGEDIN ), array() );
					$newgame->save( $mysql );
					$games->addNewGame( $newgame );
				}
			}

			$games = $games->getGamesByUID( LOGGEDIN );
			if( count( $games ) <= 0 ) {
				$template->content .= '
				<strong>Du bist leider noch in gar keiner Gruppe.</strong><br />
				Einladungen in eine Gruppe werden hier angezeigt und du kannst natürlich auch eigene erstellen.';
			}
			foreach( $games as $g ) {
				$template->content .= '
				<div class="nicelist">
					<a href="index.php?c=7&amp;gid=' . $g->getID() . '">' . $g->getName() . '</a><br />
					<small><strong>' . $g->getMaster()->getName() . '</strong>';
				$usrlist = '';
				foreach( $g->getUser() as $usr ) {
					if( $usr != $g->getMaster() )
						$usrlist .= ', ' . $usr->getName();
				}
				$template->content .= $usrlist . '</small>
				</div>';
			}
			$template->content .= '
				<hr />
				<form action="index.php?c=6" method="post">
					<strong>Neue Gruppe:</strong> <input type="text" name="gname" /> <input type="submit" name="newgame" value="Anlegen" />
				</form>
			</article>';
		}
		break;
	case 7:

		if( LOGGEDIN && isset( $_GET["gid"] ) ) {
			$game = $games->getGameById( $_GET["gid"] );
			if( $game ) {
				$master = $game->getMaster();
				$template->content .= '
			<header><h1><span aria-hidden="true" class="icon-book"></span> Gruppe: ' . $game->getName() . '</h1></header>
			<article>
				<h3>Spielleiter</h3>
				<div class="nicelist">' . ( ($master->getUID() == LOGGEDIN) ? 'Du' : $master->getName() ) . '</div>
				<h3>Spieler</h3>';
				foreach( $game->getUser() as $player ) {
					$char = $player->getCharacter( $game->getID() );
					$charid = -1;
					if( count( $char ) > 0 )
						$charid = $char[0]->getInfo( character::$infoid["ID"] );
					$template->content .= '
				<div class="nicelist">
					<div class="options"><a href="index.php?c=8&amp;gid=' . $game->getID() . '&amp;uid=' . $player->getUID() . '&amp;cid=' . $charid . '">Charakter</a>' . (($master->getUID() == LOGGEDIN)? ' | <a href="">Spieler entfernen</a> | <a href="">Spielleiter ernennen</a>' : '') . '</div>
					' . $player->getName() . '
				</div>';
				}
				$template->content .= '
				<h3>Notizen</h3>';
				if( $master->getUID() == LOGGEDIN ) {
					if( isset( $_POST["newnotes"] ) ) {
						$game->setNotes( $_POST["newnotes"] );
						$game->save( $mysql );
					}
					$template->content .= '
				<form action="index.php?c=7&amp;gid=' . $game->getID() . '" method="post">
					<textarea name="newnotes" style="width:100%;height:200px;resize:vertical;">' . htmlentities( $game->getNotes() ) . '</textarea><br />
					<input type="submit" name="savenotes" value="Speichern" />
				</form>';
				} else {
					$template->content .= str_replace( "\n", "<br />", htmlentities( $game->getNotes() ) );
				}
				$template->content .= '
			</article>';
			} else {
				$err = str_replace( "{OBJECT}", "Gruppe", $notfound );
				$template->content .= str_replace( "{REASON}", "", $err );
			}
		}

		break;
	case 8:

		if( isset( $_GET["cid"] ) ) {
			if( intval( $_GET["cid"] ) == -1 ) {
				if( isset( $_GET["gid"] ) && isset( $_GET["uid"] ) ) {
					$game = $games->getGameById( $_GET["gid"] );
					$user = $users->getUserById( $_GET["uid"] );
					if( $game && $user && ($game->getMaster()->getUID() == LOGGEDIN || $user->getUID() == LOGGEDIN) ) {
						$races = json_decode( file_get_contents( "res/rassen.json" ), true );
						$raceselect = '';
						foreach( $races as $k => $r ) {
							$raceselect .= '<option value="' . $k . '">' . $r["name"] . '</option>';
						}
						$template->content = '
			<header><h1><span aria-hidden="true" class="icon-clipboard"></span> Neuer Character für ' . $user->getName() . ' in ' . $game->getName() . '</h1></header>
			<article>
				<table style="width:100%">
					<tr>
						<td colspan="2">
							<fieldset>
								<legend>Grunddaten</legend>
								<table style="width:100%">
									<tr>
										<td style="width:20%"><strong>Name:</strong></td>
										<td style="width:30%"><input type="text" name="name" style="width:90%" /></td>
										<td style="width:20%"><strong>Generierungspunkte:</strong></td>
										<td style="width:30%"><output id="gp">110</output></td>
									</tr>
									<tr>
										<td style="width:20%"><strong>Rasse:</strong></td>
										<td style="width:30%"><select name="race"><option value="-1">---</option>' . $raceselect . '</select></td>
										<td style="width:20%"><strong>(Modifikationen):</strong></td>
										<td style="width:30%"><output id="racemod"></output></td>
									</tr>
									<tr>
										<td style="width:20%"><strong>Kultur:</strong></td>
										<td style="width:30%"><i>Bitte Rasse wählen</i></td>
										<td style="width:20%"><strong>(Modifikationen):</strong></td>
										<td style="width:30%"><output id="culturemod"></output></td>
									</tr>
									<tr>
										<td style="width:20%"><strong>Profession:</strong></td>
										<td style="width:30%"><select name="profession"></select></td>
										<td style="width:20%"><strong>(Modifikationen):</strong></td>
										<td style="width:30%"><output id="profemod"></output></td>
									</tr>
								</table>
							</fieldset>
						</td>
					</tr>
					<tr>
						<td style="width:50%" valign="top">
							<fieldset>
								<legend>Aussehen</legend>
								<table style="width:100%">
									<tr>
										<td style="width:35%"><strong>Geschlecht:</strong></td>
										<td style="width:65%"><select name="sex"><option value="3">Unbekannt</option><option value="1">Männlich</option><option value="2">Weiblich</option></td>
									</tr>
									<tr>
										<td style="width:35%"><strong>Alter:</strong></td>
										<td style="width:65%"><input type="text" name="age" style="width:90%" /></td>
									</tr>
									<tr>
										<td style="width:35%"><strong>Größe:</strong></td>
										<td style="width:65%"><input type="text" name="size" style="width:90%" /></td>
									</tr>
									<tr>
										<td style="width:35%"><strong>Gewicht:</strong></td>
										<td style="width:65%"><input type="text" name="weight" style="width:90%" /></td>
									</tr>
									<tr>
										<td style="width:35%"><strong>Haarfarbe:</strong></td>
										<td style="width:65%"><select name="haircolor"><option value="-1">Eigene</option></select></td>
									</tr>
									<tr>
										<td style="width:35%"><strong>Augenfarbe:</strong></td>
										<td style="width:65%"><select name="eyecolor"><option value="-1">Eigene</option></select></td>
									</tr>
									<tr>
										<td colspan="2"><strong>Aussehen:</strong></td>
									</tr>
									<tr>
										<td colspan="2"><textarea name="description" style="width:100%;height:100px;resize:vertical;"></textarea></td>
									</tr>
								</table>
							</fieldset>
						</td>
						<td style="width:50%" valign="top">
							<fieldset>
								<legend>Geschichte</legend>
								<table style="width:100%">
									<tr>
										<td style="width:35%"><strong>Stand:</strong></td>
										<td style="width:65%"><input type="text" name="class" style="width:90%" /></td>
									</tr>
									<tr>
										<td style="width:35%"><strong>Titel:</strong></td>
										<td style="width:65%"><input type="text" name="title" style="width:90%" /></td>
									</tr>
									<tr>
										<td style="width:35%"><strong>Sozialstatus:</strong></td>
										<td style="width:65%"><input type="text" name="social" style="width:90%" /></td>
									</tr>
									<tr>
										<td colspan="2"><strong>Familie/Herkunft/Hintergrund:</strong></td>
									</tr>
										<td colspan="2"><textarea name="story" style="width:100%;height:100px;resize:vertical;"></textarea></td>
									</tr>
								</table>
							</fieldset>
						</td>
					</tr>
				</table>
			</article>';
					}
				}
			} else {
				$user = $users->getUserByCharacterId( $_GET["cid"] );
				if( $user ) {

				}
			}
		}

		break;

}