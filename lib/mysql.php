<?php

class mysql {

	var $host = "localhost";
	var $user = "root";
	var $password = "";
	var $database = "dsa4assistant";
	var $prefix = "";

	var $connection;

	/**
	 * Constructor of the mysql object. Connects to database host and selects database
	 *
	 * @return	void
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
	 * @param	string				Query to be executed
	 * @param	optional boolean	Data return request
	 * @return	mixed				Returns array if data requested else returns boolean
	 */
	public function query( $query, $return = false ) {
		$result = mysql_query( $query, $this->connection );
		if( $return ) {
			$res = array();
			while( $row = mysql_fetch_array( $result ) ) {
				array_push( $res, $row );
			}

			return $res;
		} else {
			if( $result ) return true;
			else return false;
		}
	}


	/**
	 * Returns table prefix
	 *
	 * @return string	Table prefix
	 */
	public function prefix() {
		return $this->prefix;
	}


	function __destruct() {
		mysql_close( $this->connection );
	}

}