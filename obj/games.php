<?php
/**
 * Games object to manage and list all games
 * 
 * @author  Pascal Pohl
 * @version 1.0
 * @since   2012-12-08
 */
class games {

	private $games = array();

	/**
	 * Constructor of the games object.
	 *
	 * Gets all games from the database, creates the objects an saves them in an array
	 *
	 * @param mysql $mysql MySQL to get the data from
	 * @param users $users Users object to resolve the user
	 * @return void
	 */
	public function __construct( $mysql, $users ) {
		$res = $mysql->query( "SELECT * FROM `" . $mysql->prefix() . "games`", true );
		foreach( $res as $row ) {
			$usrs = $mysql->query( "SELECT * FROM `" . $mysql->prefix() . "game_users` WHERE `gid` = " . intval( $row["gid"] ) );
			$uarr = array();
			foreach( $usrs as $u ) {
				array_push( $uarr, $users->getUserById( intval( $u["uid"] ) ) );
			}

			$game = new game(
								intval( $row["gid"] ),
								$row["gname"],
								$row["notes"],
								$users->getUserById( intval( $row["master"] ) ),
								$uarr
							);

			array_push( $this->games, $game );
		}
	}

	/**
	 * Returns a game by its id
	 *
	 * @param int $gid The game id
	 * @return game Returns the game or false when nothing was found.
	 */
	public function getGameById( $gid ) {
		foreach( $this->games as $game ) {
			if( $game->getID() == $gid ) {
				return $game;
			}
		}

		return false;
	}

}