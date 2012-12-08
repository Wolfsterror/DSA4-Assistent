<?php
/**
 * Register logic
 *
 * @author  Pascal Pohl
 * @version 1.0
 * @since   2012-12-08
 */

// Is the register form posted?
if( isset( $_POST["register_usr"] ) && isset( $_POST["register_pwd"] ) && isset( $_POST["register_repwd"] ) ) {
	// Is the password 6 character long?
	if( strlen( $_POST["register_pwd"] ) >= 6 ) {
		// Are the passwords equal?
		if( $_POST["register_pwd"] == $_POST["register_repwd"] ) {
			// Trim string - removes empty spaces on start and end of the string
			$_POST["register_usr"] = trim( $_POST["register_usr"] );
			if( !empty( $_POST["register_usr"] ) ) {
				// Create new user
				if( $users->newUser( $_POST["register_usr"], $_POST["register_pwd"] ) ) {
					// Redirect user to login interface
					header( "Location: index.php?c=3&registered" );
				} else {
					define( "REGISTER_ERROR", "Benutzer existiert möglicherweise schon." );
				}
			} else {
				define( "REGISTER_ERROR", "Benutzername darf nicht leer sein." );
			}
		} else {
			define( "REGISTER_ERROR", "Passwörter stimmen nicht überein." );
		}
	} else {
		define( "REGISTER_ERROR", "Passwort muss mindestens 6 Zeichen lang sein." );
	}
}