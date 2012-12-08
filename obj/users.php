<?php
/**
 * User object gives you functions for managing all user
 *
 * @author  Pascal Pohl
 * @version 1.2
 * @since   2012-11-25
 */
class users {

	private $users = array();
	public $mysql;

	const AUTH_USER_UNKNOWN = 1;
	const AUTH_PASSWORD_WRONG = 2;
	const AUTH_SUCCESS = 3;

	/**
	 * Constructor of the user object. Gets all userinfomations and saves them local.
	 *
	 * @param mysql $mysql MySQL object for database access
	 * @return void
	 */
	function __construct( $mysql ) {
		$this->mysql = $mysql;
		$result = $this->mysql->query( "SELECT * FROM `" . $this->mysql->prefix() . "user`", true );
		if( $result !== false ) {
			$this->users = array();
			foreach( $result as $row ) {
				try {
					array_push( $this->users, new user( $this, $row["uid"], $row["uname"], $row["upermissions"], $row["password"] ) );
				} catch( Exception $e ) {}
			}
		}
	}

	/**
	 * Searches a user by its unique id and returns all user information
	 *
	 * @param int $uid User id
	 * @return user|null Returns user object. NULL if no user was found.
	 */
	public function getUserById( $uid ) {
		foreach( $this->users as $user ) {
			if( $uid == $user->getUID() ) {
				return $user;
			}
		}

		return null;
	}

	/**
	 * Searches a user by its (normaly) unique name and returns all user information.
	 * If the user name exists more than once only the first found is returned.
	 *
	 * @param string $uname User name
	 * @return user|null Returns user object. NULL if no user was found.
	 */
	public function getUserByName( $uname ) {
		foreach( $this->users as $user ) {
			if( $uname == $user->getName() ) {
				return $user;
			}
		}

		return null;
	}

	/**
	 * Get all user information by a character id
	 *
	 * @param int $cid Character id
	 * @return array Array that includes all user information. Empty array if no user was found.
	 */
	public function getUserByCharacterId( $cid ) {
		foreach( $this->users as $user ) {
			$res = $this->$mysql->query( "SELECT * FROM `" . $this->$mysql->prefix() . "character` WHERE `cid` = " . intval( $cid ), true );
			if( count( $res ) > 0 ) {
				return $this->getUserById( $res[0]["uid"] );
			}
			/*$character = $this->getCharacterByUserId( $user["uid"] );
			foreach( $character as $char ) {
				if( $char->getInfo( character::ID ) == $cid ) {
					return $user;
				}
			}*/
		}

		return array();
	}

	/**
	 * Function to authenticate a user by its user name and password
	 *
	 * @param string $uname User name
	 * @param string $password Password of the user
	 * @param boolean $crypted Defines if password is already crypted
	 * @return int Returns an error code. Can be user::AUTH_SUCCESS, user::AUTH_PASSWORD_WRONG or user::AUTH_USER_UNKNOWN
	 */
	public function authUser( $uname, $password, $crypted = false ) {
		$user = $this->getUserByName( $uname );
		if( $user != null ) {
			$pwd = $password;
			if( !$crypted ) $pwd = crypt( $password, $uname );
			if( $pwd == $user->getPassword() ) {
				return users::AUTH_SUCCESS;
			} else {
				return users::AUTH_PASSWORD_WRONG;
			}
		} else {
			return users::AUTH_USER_UNKNOWN;
		}
	}

	/**
	 * Creates a new user
	 *
	 * @param string $uname User name
	 * @param string $password Uncrypted password of the user
	 * @return boolean Returns false on error like the user already exists and returns true on success.
	 */
	public function newUser( $uname, $password ) {
		if( empty( $uname ) || empty( $password ) )
			return false;
		try {
			$newuser = new user( $this, -1, $uname, "", crypt( $password, $uname ) );
			array_push( $this->users, $newuser );
			return $newuser->save( $this->mysql );
		} catch( Exception $e ) {
			return false;
		}
	}

}