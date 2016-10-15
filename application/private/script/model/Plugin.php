<?php 

/**
 * Class which encapsulates plugin information
 */
class Plugin {
	
	public $folder;
	public $installed;
	public $version;
	public $nameKey;
	public $descriptionKey;
	public $requiredLevelAccess;
	public $order;
	public $userPlugin;
	
	/**
	 * Constructor
	 * @param $folder
	 * @param $installed
	 * @param $version
	 * @param $nameKey
	 * @param $descriptionKey
	 * @param $requiredLevelAccess
	 * @param $order
	 * @param $userPlugin
	 */
	public function __construct($folder, $installed, $version, $nameKey, $descriptionKey, $requiredLevelAccess, 
			$order = 9999, $userPlugin = true) {
		$this->folder = $folder;
		$this->installed = $installed;
		$this->version = $version;
		$this->nameKey = $nameKey;
		$this->descriptionKey = $descriptionKey;
		$this->requiredLevelAccess = $requiredLevelAccess;
		$this->order = $order;
		$this->userPlugin = $userPlugin;
	}
	
	/**
	 * Checks if minimum data is provided for plugin
	 * @return True/False
	 */
	public function check_minimum_data_provided() {
		return isset ( $this->folder ) && isset ( $this->nameKey ) && isset ( $this->installed ) && 
			isset ( $this->requiredLevelAccess ) && isset ( $this->version );
	}
	
	/**
	 * Gets a short name for plugin folder
	 * @return Short name for plugin folder
	 */
	public function get_short_folder_name() {
		return substr(strrchr($this->folder, "/"), 1);
	}
	
}

?>