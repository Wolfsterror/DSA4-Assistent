<?php
/**
 * MySQL object for easy query execution
 * 
 * @author  Pascal Pohl
 * @version 1.0
 * @since   2012-11-17
 */
class mysql {

	private $host = "127.0.0.1";
	private $user = "root";
	private $password = "";
	private $database = "dsa4assistant";
	private $prefix = "";

	private $connection;

	/**
	 * Constructor of the mysql object. Connects to database host and selects database
	 *
	 * @return void
	 */
	function __construct() {
		$this->connection = mysql_connect( $this->host, $this->user, $this->password );
		if( $this->connection ) {
			if( !mysql_select_db( $this->database, $this->connection ) ) {
				die( "<br />#" . mysql_errno() . ": " . mysql_error() );
			}
		} else {
			die( "<br />#" . mysql_errno() . ": " . mysql_error() );
		}
	}

	/**
	 * Executes sql query and returns data array if wanted
	 *
	 * @param string $query Query to be executed
	 * @param boolean $return Data return request
	 * @return array|boolean Returns array if data requested else returns boolean
	 */
	public function query( $query, $return = false ) {
		$result = mysql_query( $query, $this->connection );
		if( $return ) {
			if( $result ) {
				$res = array();
				while( $row = mysql_fetch_array( $result ) ) {
					array_push( $res, $row );
				}

				return $res;
			} else {
				return false;
			}
		} else {
			if( $result ) return true;
			else return false;
		}
	}


	/**
	 * Returns table prefix
	 *
	 * @return string Table prefix
	 */
	public function prefix() {
		return $this->prefix;
	}

	/**
	 * Returns last inserted index id
	 *
	 * @return int
	 */
	public function getLastInsertId(){
		return mysql_insert_id( $this->connection );
	}

	/**
	 * Destructor of the mysql object. Closes database connection.
	 *
	 * @return void
	 */
	function __destruct() {
		mysql_close( $this->connection );
	}

}