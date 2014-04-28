<?php
/**
 * Game object to manage a game with its user
 * 
 * @author  Pascal Pohl
 * @version 1.0
 * @since   2012-12-08
 */
class game {


	private $gid;
	private $gname;
	private $notes;
	private $master;
	private $user;
	private $invites;

	/**
	 * Constructor of the game object.
	 *
	 * @param int $gid Game ID
	 * @param string $gname Game name
	 * @param string $notes Notes to the game
	 * @param user $master Master user of the game
	 * @param array $user Array of users in the game
	 * @return void
	 */
	public function __construct( $gid, $gname, $notes, $master, $user, $invites ) {
		$this->gid = $gid;
		$this->gname = $gname;
		$this->notes = $notes;
		$this->master = $master;
		$this->user = $user;
		$this->invites = $invites;
	}

	/**
	 * Returns game id
	 *
	 * @return int Game id
	 */
	public function getID() {
		return $this->gid;
	}

	/**
	 * Returns game name
	 *
	 * @return string Game name
	 */
	public function getName() {
		return $this->gname;
	}

	/**
	 * Returns game notes
	 *
	 * @return string Game notes
	 */
	public function getNotes() {
		return $this->notes;
	}

	/**
	 * Returns game master
	 *
	 * @return user Game master
	 */
	public function getMaster() {
		return $this->master;
	}

	/**
	 * Returns array of game user
	 *
	 * @return array Game users
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * Returns array of invites
	 *
	 * @return array Game invites
	 */
	public function getInvites() {
		return $this->invites;
	}

	/**
	 * Sets game name
	 *
	 * @param string $gname Game name
	 * @return void
	 */
	public function setName( $gname ) {
		$this->gname = $gname;
	}

	/**
	 * Sets game note
	 *
	 * @param string $notes Game note
	 * @return void
	 */
	public function setNotes( $notes ) {
		$this->notes = $notes;
	}

	/**
	 * Sets game master
	 *
	 * @param user $master Game master
	 * @return void
	 */
	public function setMaster( $master ) {
		$this->master = $master;
	}

	/**
	 * Removes user from game if exists
	 *
	 * @param user $user User to remove
	 * @return void
	 */
	public function removeUser( $user ) {
		$s = array_search( $user, $this->user, true );
		if( $s ) {
			unset( $this->user[$s] );
		}
	}

	/**
	 * Adds a user to game if not exist
	 *
	 * @param user $user User to add
	 * @return void
	 */
	public function addUser( $user ) {
		if( !in_array( $user, $this->user ) )
			$this->user[] = $user;
	}

	/**
	 * Invites a player to a game
	 *
	 * @param user $user User to invite
	 * @return void
	 */
	public function invitePlayer( $user ) {
		if( !in_array( $user, $this->invites ) )
			array_push($this->invites, $user);
	}

	/**
	 * Saves the game data in database
	 *
	 * @param mysql $mysql MySQL object to save to
	 * @return void
	 */
	public function save( $mysql ) {
		if( $this->gid == -1 ) {
			$ins = "INSERT INTO `" . $mysql->prefix() . "games` () VALUES ()";
			$mysql->query( $ins );

			$this->gid = $mysql->getLastInsertId();
		}

		$update = "UPDATE `" . $mysql->prefix() . "games` SET " .
					"`gname` = '" . mysql_real_escape_string( $this->gname ) . "'," .
					"`notes` = '" . mysql_real_escape_string( $this->notes ) . "'," .
					"`master` = " . intval( $this->master->getUID() ) .
				" WHERE `gid` = " . intval( $this->gid );

		$mysql->query( $update );

		$delete = "DELETE FROM `" . $mysql->prefix() . "game_users` WHERE `gid` = " . intval( $this->gid );
		$mysql->query( $delete );

		foreach( $this->user as $usr ) {
			$ins = "INSERT INTO `" . $mysql->prefix() . "game_users` ( `gid`, `uid`, `invite` ) VALUES ( " . intval( $this->gid ) . ", " . intval( $usr->getUID() ) . ", 0 )";
			$mysql->query( $ins );
		}
		foreach( $this->invites as $usr ) {
			$ins = "INSERT INTO `" . $mysql->prefix() . "game_users` ( `gid`, `uid`, `invite` ) VALUES ( " . intval( $this->gid ) . ", " . intval( $usr->getUID() ) . ", 1 )";
			$mysql->query( $ins );
		}
	}

}