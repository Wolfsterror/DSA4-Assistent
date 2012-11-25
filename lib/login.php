<?php
/**
 * Login logic
 *
 * If the constant LOGGEDIN is not defined and the $users object is defined
 * it tries to log a user in. If the session variables login_usr and login_pwd
 * are set it will login with these. Otherwise it looks for similiar POST data.
 * Anyway if LOGGEDIN is not defined and $users is, it will create the constant
 * LOGGEDIN with the user id or with a boolean false an failure and cannot be changed afterwards.
 *
 * @author  Pascal Pohl
 * @version 1.0
 * @since   2012-11-25
 */
if( !defined( "LOGGEDIN" ) && isset( $users ) ) {

	// Working with the session variables. If login is not authorized the session data
	// will be destroyed.
	if( isset( $_SESSION["login_usr"] ) && isset( $_SESSION["login_pwd"] ) ) {
		$auth = $users->authUser( $_SESSION["login_usr"], $_SESSION["login_pwd"], true );
		if( $auth ) {
			$user = $users->getUserByName( $_SESSION["login_usr"] );
			define( "LOGGEDIN", $user->getUID() );

			unset( $user );
		} else {
			session_destroy();
			define( "LOGGEDIN", false );
		}
		unset( $auth );

	// Working with POST data. If login is successfull it will create SESSION data.
	} else if( isset( $_POST["login_usr"] ) && isset( $_POST["login_pwd"] ) ) {
		$auth = $users->authUser( $_SESSION["login_usr"], $_SESSION["login_pwd"] );
		if( $auth ) {
			$user = $users->getUserByName( $_SESSION["login_usr"] );
			$_SESSION["login_usr"] = $user->getName();
			$_SESSION["login_pwd"] = $user->getPassword();
			define( "LOGGEDIN", $user->getUID() );

			unset( $user );
		} else {
			define( "LOGGEDIN", false );
		}
		unset( $auth );

	// If nothing is provided the user is not logged in and isn't trying to.
	} else {
		define( "LOGGEDIN", false );
	}
}