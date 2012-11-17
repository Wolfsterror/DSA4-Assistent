<?php
/**
 * User object gives you functions for managing all user
 *
 * @author		Pascal Pohl
 * @version		1.0
 * @since		2012-11-17
 */
class user {

	private $users = array();
	private $mysql;

	const AUTH_USER_UNKNOWN = 1;
	const AUTH_PASSWORD_WRONG = 2;
	const AUTH_SUCCESS = 3;

	/**
	 * Constructor of the user object. Gets all userinfomations and saves them local.
	 *
	 * @return 	void
	 */
	function __construct( $mysql ) {
		$this->mysql = $mysql;
		$result = $mysql->query( "SELECT * FROM `" . $mysql->prefix() . "user`", true );
		if( $result !== false ) {
			$this->users = $result;
		}
	}

	/**
	 * Searches a user by its unique id and returns all user information
	 *
	 * @param uid int User id
	 * @return array Array that includes all user information. Empty array if no user was found.
	 */
	public function getUserById( $uid ) {
		foreach( $this->users as $user ) {
			if( $uid == $user["uid"] ) {
				return $user;
			}
		}

		return array();
	}

	/**
	 * Searches a user by its (normaly) unique name and returns all user information.
	 * If the user name exists more than once only the first found is returned.
	 *
	 * @param uname string User name
	 * @return array Array that includes all user information. Empty array if no user was found.
	 */
	public function getUserByName( $uname ) {
		foreach( $this->users as $user ) {
			if( $uname == $user["uname"] ) {
				return $user;
			}
		}

		return array();
	}


	/**
	 * Function to authenticate a user by its user name and password
	 *
	 * @param uname string User name
	 * @param password string Password of the user
	 * @return int Returns an error code. Can be user::AUTH_SUCCESS, user::AUTH_PASSWORD_WRONG or user::AUTH_USER_UNKNOWN
	 */
	public function authUser( $uname, $password ) {
		$user = $this->getUserByName( $uname );
		if( isset( $user["password"] ) ) {
			if( crypt( $password, $uname ) == $user["password"] ) {
				return user::AUTH_SUCCESS;
			} else {
				return user::AUTH_PASSWORD_WRONG;
			}
		} else {
			return user::AUTH_USER_UNKNOWN;
		}
	}


	/**
	 * Creates a new user
	 *
	 * @param uname string User name
	 * @param password string Password of the user
	 * @return boolean Returns false on error like the user already exists and returns true on success.
	 */
	public function newUser( $uname, $password ) {
		$usr = $this->getUserByName( $uname );
		if( isset( $usr["uid"] ) ) {
			return false;
		}

		$res = $this->mysql->query( "INSERT INTO `" . $this->mysql->prefix() . "user` ( `uname`, `password` ) VALUES ( '" . mysql_real_escape_string( $uname ) . "', '" . mysql_real_escape_string( crypt( $password, $uname ) ) . "' )" );
		if( $res ) {
			// refreshing local data
			$result = $this->mysql->query( "SELECT * FROM `" . $this->mysql->prefix() . "user`", true );
			if( $result !== false ) {
				$this->users = $result;
			}

			return true;
		} else {
			return false;
		}
	}

}