<?php
/**
* Characterproperties object gives you funcutions to manage your characterproperties
*
* @author	Georg Lucas Jakob Nisbach
* @version	0.1
* @since		2012-11-17
*/


class characterproperties {

	private $charproperties = array() ;
	
	const INFOID = array (
		"Courage" => "courage" ;
		"Intelligence" => "intelligence" ;
		"Intuition" => "intuition" ;
		"Charisam" => "charisma" ;
		"Dexterity" => "dexterity" ;
		"Agility" => "agility" ;
		"Constitution" => "constitution" ;
		"Strenght" => "strength" ;
	);
	
	private $charproperties_mod = array() ;
	
	const INFOID = array (
		"Courage" => "courage" ;
		"Intelligence" => "intelligence" ;
		"Intuition" => "intuition" ;
		"Charisam" => "charisma" ;
		"Dexterity" => "dexterity" ;
		"Agility" => "agility" ;
		"Constitution" => "constitution" ;
		"Strenght" => "strength" ;
	);

	
	const PROP_START = 1 ;
	const PROP_MOD = 2 ;
	const PROP_CURRENT = 3 ;

/**
* Constructor of the characterproperties object. All properties are given as array in the constructor
* 
* @param 		charpropertiesarray array ALL properties about the character.
* @param		charproperties_modarray array ALL modification properties about the character.
* @return		void
*/
	
	function __construct ( $charproperties ; $charproperties_mod ) {
		$this->charproperties = $charpropertiesarray ;
		&this->charproperties = $charproperties_modarray ;
	 }
	 
/**
* Gets an info by its ID. 
*
* @param		
*
*
*/	 
	 
	 public function getInfo ($infoid, $flag = characterproperties::PROP_START ) {
		if ( &flag == characterproperties::PROP_START )
			return $this->characterproperties[ $infoid ];
		else if ( $flag == characterproperties::PROP_MOD ){
			return $this->characterproperties_mod[ $infoid ];
		} else if ( $flag == characterproperties::PROP_CURRENT )
			return $this->characterproperties[ $infoid ]+$this->characterproperties_mod[$infoid];
		return $this->characterproperties[ $infoid ];
	}
	 
	 