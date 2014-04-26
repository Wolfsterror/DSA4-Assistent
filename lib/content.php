<?php

if( !isset( $_GET["c"] ) ) {
	$_GET["c"] = 0;
}


switch( $_GET["c"] ) {
	
	default:
		$template->activePage = 0;
		$template->contentTemplate = '01_homepage.tpl.php';
		break;
	case 1:
		$template->activePage = 1;
		$template->contentTemplate = '02_user.tpl.php';
		break;
	case 2:
		$template->activePage = 2;
		$template->contentTemplate = '03_characters.tpl.php';
		break;
	case 3:
		if(LOGGEDIN) {
			if( isset( $_GET["login"] ) ) {
				header( "Location: index.php?c=0" );
			} else {
				session_destroy();
				header( "Location: index.php?c=3&loggedout" );
			}
		} else {
			$template->activePage = 3;
			$template->contentTemplate = '04_login.tpl.php';

			if( isset( $_GET["loggedout"] ) ) {
				$template->success = 'Erfolgreich ausgeloggt.';
			} else if( isset( $_GET["registered"] ) ) {
				$template->success = 'Erfolgreich registriert. Du kannst dich nun einloggen.';
			} else if( isset( $_POST["login_usr"] ) ) {
				switch( LOGINERROR ) {
					default:
						$template->error = 'Einloggen fehlgeschlagen.';
						break;
					case users::AUTH_USER_UNKNOWN:
						$template->error = 'Benutzer nicht gefunden.';
						break;
					case users::AUTH_PASSWORD_WRONG:
						$template->error = 'Falsches Passwort.';
						break;
				}
			}
		}
		break;
	case 4:
		$template->activePage = 4;
		$template->contentTemplate = '05_register.tpl.php';
		if( LOGGEDIN ) {
			$template->error = 'Du bist hier falsch. Wenn du eigentlich nicht eingeloggt sein solltest, logge dich bitte sofort aus.';
		} else {
			include 'lib/register.php';
			if( defined( "REGISTER_ERROR" ) ) {
				$template->error = REGISTER_ERROR;
			}
		}
		break;
	case 5:
		$template->activePage = 5;
		$template->contentTemplate .= '06_settings.tpl.php';
		break;
	case 6:
		$template->activePage = 6;
		$template->contentTemplate = '07_group.tpl.php';

		if(LOGGEDIN) {
			if(!isset($_GET["gid"]) || $games->getGameById($_GET["gid"]) === false) {
				if(isset($_GET["gid"])) $template->error = "Gruppe nicht gefunden";

				if( isset( $_POST["newgame"] ) ) {
					if( !empty( $_POST["gname"] ) ) {
						$newgame = new game( -1, $_POST["gname"], "", $users->getUserById( LOGGEDIN ), array() );
						$newgame->save( $mysql );
						$games->addNewGame( $newgame );
					}
				}

				$games = $games->getGamesByUID( LOGGEDIN );
				$template->games = $games;
			} else {
				$template->game = $games->getGameById($_GET["gid"]);

				if(isset($_POST["inviteuser"])) {
					$template->error = "Spielereinladungen sind noch nicht möglich.";
				}

				if( $template->game->getMaster()->getUID() == LOGGEDIN ) {
					if( isset( $_POST["newnotes"] ) ) {
						$template->game->setNotes($_POST["newnotes"]);
						$template->game->save( $mysql );
					}
				}
			}
		}
		break;
	case 8:
		$template->activePage = 2;
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