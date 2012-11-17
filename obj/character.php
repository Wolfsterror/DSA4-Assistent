<?php
/**
 * Character object gives you functions for managing a character
 *
 * @author		Pascal Pohl
 * @version		0.5
 * @since		2012-11-17
 */
class character {

	private $charinformations = array();

	public static $infoid = array(
		"ID" => "cid",
		"User" => "uid",
		"Name" => "cname",
		"Race" => "crace",
		"Culture" => "cculture",
		"Profession" => "cprofession",
		"Sex" => "csex",
		"Birth" => "cbirth",
		"Size" => "csize",
		"HairColor" => "chaircolor",
		"EyeColor" => "ceyecolor",
		"Description" => "cdescription",
		"CharClass" => "cclass",
		"Title" => "ctitle",
		"Social" => "csocial",
		"Story" => "cstory"
	);

	const Sex_Male = 1;
	const Sex_Female = 2;
	const Sex_Undefined = 3;

	/**
	 * Constructor of the character object. All informations are given as array in the constructor
	 *
	 * @param charinformationarray array All informations about the character.
	 * @return void
	 */
	function __construct( $charinformationarray ) {
		$this->charinformations = $charinformationarray;
	}

	/**
	 * Gets an info by its ID. All IDs are defined in the character::INFOID array.
	 *
	 * @param infoid string Info ID
	 * @return mixed Returns the info by the given ID. Returns false if info is not defined.
	 */
	public function getInfo( $infoid ) {
		if( !isset( $this->charinformations[ $infoid ] ) )
			return false;
		return $this->charinformations[ $infoid ];
	}

	/**
	 * Sets an info by its info id and optional saves it in the database.
	 *
	 * @param infoid string Info ID
	 * @param info string The info
	 * @param save optional mysql MySQL object to use to save.
	 * @return void
	 */
	public function setInfo( $infoid, $info, $save = false ) {
		if( array_key_exists( $infoid, character::INFOID ) ) {
			$this->charinformations[ $infoid ] = $info;
			if( $save !== false && is_object( $save ) && method_exists( $save, 'query' ) ) {
				$this->save( $save );
			}
		}
	}

	/**
	 * Saves the character in the database. If character doesn't exists it gets created.
	 *
	 * @param mysql mysql MySQL object that is used to save
	 * @return boolean Returns false on error or true on success
	 */
	public function save( $mysql ) {
		$id = $this->getInfo( character::$infoid["ID"] );
		if( !empty( $id ) ) {
			$updatestr = "";
			foreach( $this->charinformations as $key => $value ) {
				if( $key != character::$infoid["ID"] ) {
					$updatestr .=  "`" . mysql_real_escape_string( $key ) . "` = '" . mysql_real_escape_string( $value ) . "',";
				}
			}
			$updatestr = substr( $updatestr, 0, strlen( $updatestr )-1 );

			return $mysql->query( "UPDATE `" . $mysql->prefix() . "character` SET " . $updatestr . " WHERE `cid` = " . intval( $id ) );
		} else {
			$insertkeys = "";
			$insertvals = "";
			foreach( $this->charinformations as $key => $value ) {
				$insertkeys .= "`" . mysql_real_escape_string( $key ) . "`,";
				$insertvals .= "'" . mysql_real_escape_string( $value ) . "',";
			}
			$insertkeys = substr( $insertkeys, 0, strlen( $insertkeys )-1 );
			$insertvals = substr( $insertvals, 0, strlen( $insertvals )-1 );

			return $mysql->query( "INSERT INTO `" . $mysql->prefix() . "character` (" . $insertkeys . ") VALUES (" . $insertvals . ")" );
		}
	}

}