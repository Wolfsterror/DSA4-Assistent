<?php
/**
 * Characterproperties object gives you funcutions to manage your characterproperties
 *
 * @author  Georg Lucas Jakob Nisbach
 * @version 0.1
 * @since   2012-11-17
 */
class characterproperties {

	private $charproperties = array() ;
	
	public static $infoid = array (
		"Courage" => "courage" 
		"Intelligence" => "intelligence" 
		"Intuition" => "intuition" 
		"Charisma" => "charisma" 
		"Dexterity" => "dexterity" 
		"Agility" => "agility" 
		"Constitution" => "constitution" 
		"Strength" => "strength" 
	);
	
	private $charproperties_mod = array() ;
		
	const PROP_START = 1 ;
	const PROP_MOD = 2 ;
	const PROP_CURRENT = 3 ;

	/**
	 * Constructor of the characterproperties object. All properties are given as array in the constructor
	 * 
	 * @param array $charpropertiesarray ALL properties about the character.
	 * @param array $charproperties_modarray array ALL modification properties about the character.
	 * @return void
	 */
	function __construct ( $charpropertiesarray , $charproperties_modarray ) {
		$this->charproperties = $charpropertiesarray ;
		$this->charproperties_mod = $charproperties_modarray ;
	}
	
	/**
	 * Gets an info by its ID. 
	 *
	 * @todo Documentiation
	 *
	 * @return string|int
	 */
	public function getInfo ($infoid, $flag = characterproperties::PROP_START ) {
		if ( $flag == characterproperties::PROP_START )
			return $this->characterproperties[ $infoid ];
		else if ( $flag == characterproperties::PROP_MOD ){
			return $this->characterproperties_mod[ $infoid ];
		} else if ( $flag == characterproperties::PROP_CURRENT )
			return $this->characterproperties[ $infoid ]+$this->characterproperties_mod[$infoid];
	}
}