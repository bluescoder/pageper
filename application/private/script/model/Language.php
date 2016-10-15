<?php 

/**
 * Encapsulates information about a language
 * @author david
 */
class Language {
	
	public $iso6391;
	public $description;
	
	/**
	 * Constructor
	 * @param unknown $iso6391
	 * @param unknown $description
	 */
	public function __construct($iso6391, $description) {
		$this->iso6391 = $iso6391;
		$this->description = $description;
	}
	
	
}
?>