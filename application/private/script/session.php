<?php 

/**
 * Script used to users session control
 */

// Session parameters
define ('SESSION_PARAM_LOGGED_USER', 'session_param_logged_user');
define ('SESSION_PARAM_FIRST_REQUEST', 'session_param_first_request');

// Start session
session_start ( [ 
		'cookie_lifetime' => SESSION_LIFETIME 
] );

$_SESSION [SESSION_PARAM_FIRST_REQUEST] = !isset ( $_SESSION [SESSION_PARAM_FIRST_REQUEST] );


/**
 * Checks if this is the first request for session
 * @return True/False
 */
function is_new_session() {
	return $_SESSION [SESSION_PARAM_FIRST_REQUEST];
}

/**
 * Checks if any user is logged
 */
function is_user_logged() {
	return isset($_SESSION [SESSION_PARAM_LOGGED_USER]);
}

?>