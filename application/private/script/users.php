<?php 

/**
 * Script to manage user actions
 */

register_action('action_login');
register_action('action_logout', 99);


/**
 * Registra un usuario maestro
 * @param $alias
 * @param $email
 * @param $firstName
 * @param $lastName
 * @param $pass1
 * @param $pass2
 */
function register_user($user) {
	$db = get_db_handler();
	$stm = $db->prepare ( "INSERT INTO pgp_admin_user (id, alias, password, first_name, last_name, email, admin_user_level, gender, lang) 
			VALUES (null, :alias, :password, :first_name, :last_name, :email, :admin_user_level, :gender, :lang) " );
	$encr_password = encrypt($user->password);
	$stm->bindParam(':alias', $user->alias);
	$stm->bindParam(':password', $encr_password);
	$stm->bindParam(':first_name', $user->first_name);
	$stm->bindParam(':last_name', $user->last_name);
	$stm->bindParam(':email', $user->email);
	$stm->bindParam(':admin_user_level', $user->admin_user_level);
	$stm->bindParam(':gender', $user->gender);
	$stm->bindParam(':lang', $user->language);
	$stm->execute ();
}

/**
 * Checks login request
 */
function action_login() {
	if (! isset ( $_SESSION [SESSION_PARAM_LOGGED_USER] )) {
		if (isset ( $_POST ['username'] )) {
			$username = $_POST ['username'];
			$password = $_POST ['password'];
			check_login ( $username, $password );
		}
	}
}

/**
 * Do logout for logged user
 */
function action_logout() {
	if (isset ( $_SESSION [SESSION_PARAM_LOGGED_USER] )) {
		unset($_SESSION [SESSION_PARAM_LOGGED_USER]);
		session_unset();
	}
}

/**
 * Checks user credentials
 * @param $username
 * @param $password
 */
function check_login($username, $password) {
	$encr_password = encrypt($password);
	$db = get_db_handler ();
	$pps = $db->prepare (
			"SELECT id, alias, first_name, last_name, email, admin_user_level, gender, lang
				FROM pgp_admin_user
				WHERE alias = :alias and password = :password" );
	$pps->bindParam ( ':alias', $username );
	$pps->bindParam ( ':password', $encr_password );
	$pps->execute ();
	$results = $pps->fetchAll ();

	if (count ( $results ) == 1) {
		$logged_user = new AdminUser($results[0]['id'], $results[0]['alias'], '', $results[0]['first_name'], $results[0]['last_name'], $results[0]['email'], 
				$results[0]['admin_user_level'], $results[0]['lang'], $results[0]['gender']);
		$_SESSION [SESSION_PARAM_LOGGED_USER] = $logged_user;
		switch_language($logged_user->language);
	}
	
}

?>