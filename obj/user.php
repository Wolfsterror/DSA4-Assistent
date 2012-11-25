<?php
/**
 * User object gives you functions for managing all user
 *
 * @author  Pascal Pohl
 * @version 1.0
 * @since   2012-11-25
 */
class user {
		
	private $users;
	private $uid;
	private $uname;
	private $upermissions;
	private $password;

	private $character;

	/**
	 * Constructor of the user object.
	 *
	 * @param users $users users object that created the user
	 * @param int $uid UserID (-1 if new user)
	 * @param string $uname Name of the User
	 * @param string $upermissions String of the permissions (until we have permission object)
	 * @param string $password Crypted password
	 * @return void
	 */
	function __construct( $users, $uid, $uname, $upermissions, $password ) {
		$this->users = $users;

		$this->uid = intval( $uid );
		$this->uname = $uname;
		$this->upermissions = $upermissions;
		$this->password = $password;

		$u = $this->users->getUserByName( $uname );
		if( $u != null && $u->getUID() != $this->uid ) {
			throw new Exception( "Username already exists." );
		}
	}

	/**
	 * Get user id
	 *
	 * @return int
	 */
	public function getUID() {
		return $this->uid;
	}

	/**
	 * Get user name
	 *
	 * @return string
	 */
	public function getName(){
		return $this->uname;
	}

	/**
	 * Has user permission
	 *
	 * @todo Well... everything
	 */
	public function hasPermission(){
		// TODO: Permissions
	}

	/**
	 * Get crypted user password
	 *
	 * @return string
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * Set user name
	 *
	 * @param string $uname The (new) name of the user. Must not be empty.
	 * @return boolean Returns false if $uname empty
	 */
	public function setName( $uname ) {
		if( !empty( $uname ) ) {
			$u = $this->users->getUserByName( $uname );
			if( $u != null && $u->getUID() != $this->uid ) {
				return false;
			}
			$this->uname = $uname;
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Set user password
	 *
	 * @param string $password The (new,) crypted password of the use. Most not be empty.
	 * @return boolean Returns false if $password empty
	 */
	public function setPassword( $password ) {
		if( !empty( $password ) ) {
			$this->password = $password;
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Get all characters of that user
	 *
	 * @return array Array that includes all characters. Empty array if no character were found.
	 */
	public function getCharacter() {
		if( $this->uid == -1 )
			return array();

		if( !isset( $this->character ) || !is_array( $this->character ) || $this->character == null ) {
			$result = $this->users->mysql->query( "SELECT * FROM `" . $this->users->mysql->prefix() . "character` WHERE `uid` = " . $this->uid, true );
			$this->character = array();
			foreach( $result as $row ) {
				array_push( $this->character, new character( $row ) );
			}
		}

		return $this->character;
	}

	/**
	 * Creates a new character for a user
	 *
	 * @param mysql $mysql MySQL object in which the character gets created
	 * @param string $cname Character name
	 * @param array $infos Additional infos for the character
	 * @return boolean Returns false on error and true on success
	 */
	public function ceateCharacter( $mysql, $cname, $infos = array() ) {
		if( $this->uid == -1 )
			return false;

		if( empty( $cname ) )
			return false;

		if( !is_array( $infos ) )
			return false;

		$res = $mysql->query( "SELECT * FROM `" . $mysql->prefix() . "character` WHERE `cname` = '" . mysql_real_escape_string( $cname ) . '"', true );
		if( count( $res ) > 0 )
			return false;

		$infos["uid"] = $this->uid;
		$infos["cname"] = $cname;

		$c = new character( $infos );
		return $c->save( $mysql );
	}

	/**
	 * Saves all changes in the user object in the database provided
	 *
	 * @param mysql $mysql MySQL object in which the changes getting saved
	 * @return boolean True on succes, false otherwise
	 */
	public function save( $mysql ) {
		if( empty( $this->uname ) )
			return false;

		if( empty( $this->password ) )
			return false;

		if( $this->uid == -1 ) {
			$res = $mysql->query( "INSERT INTO `" . $mysql->prefix() . "user` ( `uname`, `upermissions`, `password` ) VALUES" .
																			" ( '" . mysql_real_escape_string( $this->uname ) . "', '" . mysql_real_escape_string( $this->upermissions ) . "', '" . mysql_real_escape_string( $this->password ) . "' )" );
			$this->uid = $mysql->getLastInsertId();
			return $res;
		} else {
			return $mysql->query( "UPDATE  `" . $mysql->prefix() . "user` SET `uname` = '" . mysql_real_escape_string( $this->uname ) . "'," .
																			" `upermissions` = '" . mysql_real_escape_string( $this->upermissions ) . "'," .
																			" `password` = '" . mysql_real_escape_string( $this->password ) . "' WHERE `uid` = " . $this->uid );
		}
	}

}