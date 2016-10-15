<?php 

/**
 * Script to manage installation process
 */

define ('PARAM_INSTALL_STEP', 'param_install_step');

register_action('action_install_step_1');
register_action('action_install_step_2');
register_action('action_install_step_2_back');
register_action('action_install_step_3');

/**
 * Action for installation step 1
 */
function action_install_step_1() {
	$step = 1;
	if (! is_installed ()) {
		if (isset ( $_POST ['lang'] )) {
			if (is_valid_lang_code ( $_POST ['lang'] )) {
				switch_language ( $_POST ['lang'] );
				$step ++;
				$_SESSION [PARAM_INSTALL_STEP] = $step;
			}
		}
	}
}

/**
 * Action for installation step 2
 */
function action_install_step_2() {
	$step = 2;
	if(isset($_POST["back"])) {
		$step--;
		$_SESSION[PARAM_INSTALL_STEP] = $step;
	} else if(isset($_POST["alias"]) && !is_installed()) {
		$alias = trim($_POST["alias"]);
		$email = trim($_POST["email"]);
		$firstName = trim($_POST["firstName"]);
		$lastName = trim($_POST["lastName"]);
		$pass1 = trim($_POST["pass1"]);
		$pass2 = trim($_POST["pass2"]);
	
		if(preg_match("/^[A-Za-z-\\s\\*]{2,100}$/", $firstName, $output_array)!=1) {
			$_SESSION["error"] = text('install.error.first.name.not.valid');
		} else if(preg_match("/^[A-Za-z-\\s\\*]{2,100}$/", $lastName, $output_array)!=1) {
			$_SESSION["error"] = text('install.error.last.name.not.valid');
		} else if(preg_match("/^[A-Za-z0-9-_\\*]{4,20}$/", $alias, $output_array)!=1) {
			$_SESSION["error"] = text('install.error.alias.not.valid');
		} else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$_SESSION["error"] = text('install.error.email.not.valid');
		} else if(preg_match("/^[A-Za-z0-9\\*]{7,14}$/", $pass1, $output_array)!=1) {
			$_SESSION["error"] = text('install.error.password.not.valid');
		} else if (strcasecmp($pass1, $pass2) !=0) {
			$_SESSION["error"] = text('install.error.password.not.matched');
		} else {
			$user = new AdminUser(null, $alias, $pass1, $firstName, $lastName, $email, 1, $_SESSION[SESSION_PARAM_USER_LANGUAGE], 1);
			register_user($user);
			$step++;
			$_SESSION[PARAM_INSTALL_STEP] = $step;
		}
	}
	
}

/**
 * Action to go back grom step 2 to step 1
 */
function action_install_step_2_back() {
	$step = 1;
	$_SESSION[PARAM_INSTALL_STEP] = $step;
}

/**
 * Action for installation step 3
 */
function action_install_step_3() {
	unset($_SESSION[PARAM_INSTALL_STEP]);
}


/**
 * Checks if application is installed
 * @return boolean
 */
function is_installed() {
	$db = get_db_handler();
	
	if (isset ( $db )) {
		$pps = $db->prepare ( "SELECT COUNT(*) as tables_count
			 FROM sqlite_master
			 WHERE type='table'
			 	 AND name IN ('pgp_admin_user')" );
		$pps->execute ();
		$usersTable = $pps->fetchAll ();
		
		if ($usersTable [0] ['tables_count'] == 1) {
			$pps = $db->prepare ( "SELECT COUNT(*) as users_count
				 FROM pgp_admin_user" );
			$pps->execute ();
			$masterUsersCount = $pps->fetchAll ();
		} else {
			create_database();
		}
	}
	
	return !isset($_SESSION[PARAM_INSTALL_STEP]) && isset($masterUsersCount) && $masterUsersCount[0]['users_count'] > 0 ;
}

/**
 * Creates the database tables
 */
function create_database() {
	$db = get_db_handler ();
	$db->exec ( "CREATE TABLE pgp_admin_user_level (
			 id INTEGER PRIMARY KEY,
			 description VARCHAR(20))" );
	$db->exec ( "CREATE TABLE pgp_gender (
			 id INTEGER PRIMARY KEY,
			 description VARCHAR(20))" );
	$db->exec ( "CREATE TABLE pgp_language (
			 iso_639_1 CHAR(2) PRIMARY KEY,
			 description VARCHAR(20))" );
	$db->exec ( "CREATE TABLE pgp_application (
			 parameter VARCHAR(100) PRIMARY KEY,
			 value VARCHAR(200))" );
	$db->exec ( "CREATE TABLE pgp_plugin (
			 folder VARCHAR(100) PRIMARY KEY,
			 name VARCHAR(100),
			 version VARCHAR(20),
			 required_user_level SMALLINT,
			 ordering SMALLINT)" );
	$db->exec ( "CREATE TABLE pgp_admin_user (
			 id INTEGER PRIMARY KEY,
			 alias VARCHAR(20),
			 password VARCHAR(20),
			 first_name VARCHAR(100),
			 last_name VARCHAR(100), 
			 email VARCHAR(100),
			 admin_user_level INTEGER, 
			 gender INTEGER, 
			 lang CHAR(2), 
			 FOREIGN KEY(admin_user_level) REFERENCES admin_user_level(id), 
			 FOREIGN KEY(gender) REFERENCES gender(id),
			 FOREIGN KEY(lang) REFERENCES language(iso_639_1))" );
	$db->exec ( "CREATE TABLE pgp_recovery_code (
			 hashcode VARCHAR(100) PRIMARY KEY,
			 generation_time TIMESTAMP, 
			 user_id INTEGER, 
			 FOREIGN KEY(user_id) REFERENCES pgp_admin_user(id))" );
	$db->exec ( "INSERT INTO pgp_admin_user_level (id, description)
			 VALUES (1, 'MASTER'), 
			        (2, 'ADMIN')" );
	$db->exec ( "INSERT INTO pgp_gender (id, description)
			 VALUES (1, 'MALE'),
			        (2, 'FEMALE')" );
	$db->exec ( "INSERT INTO pgp_language (iso_639_1, description)
			 VALUES ('es', 'Español'),
			        ('en', 'English'),
						  ('ga', 'Galego')" );
}

?>