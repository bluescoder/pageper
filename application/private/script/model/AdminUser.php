<?php 

/**
 * Encapsulates information about an admin user
 * @author david
 */
class AdminUser {
	
	public $id;
	public $alias;
	public $password;
	public $first_name;
	public $last_name;
	public $email;
	public $admin_user_level;
	public $language;
	public $gender;
	
	/**
	 * Constructor
	 * @param $id
	 * @param $alias
	 * @param $password
	 * @param $first_name
	 * @param $last_name
	 * @param $email
	 * @param $admin_user_level
	 * @param $language
	 * @param $gender
	 */
	public function __construct($id, $alias, $password, $first_name, $last_name, $email, $admin_user_level, 
			$language, $gender) {
		$this->id = $id;
		$this->alias = $alias;
		$this->password = $password;
		$this->first_name = $first_name;
		$this->last_name = $last_name;
		$this->email = $email;
		$this->admin_user_level = $admin_user_level;
		$this->language = $language;
		$this->gender = $gender;
	}
	
	
}
?>