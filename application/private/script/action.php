<?php 

/**
 * Script for processing received actions requests
 */

define ('PUBLIC_ACTION_URL', URL_BASE . '/application/public/action.php');

define ('REGISTERED_ACTIONS', 'registered_actions');

/**
 * Register an action
 * @param $name Name for action
 */
function register_action($name, $requiredLevel = 0) {
	if (! isset ( $GLOBALS [REGISTERED_ACTIONS] )) {
		$GLOBALS [REGISTERED_ACTIONS] = array ();
	}
	$GLOBALS [REGISTERED_ACTIONS] [$name] = $requiredLevel;
}

/**
 * Proccess received action
 * @param $name
 */
function process_action($name) {
	if (isset ( $GLOBALS [REGISTERED_ACTIONS] )) {
		$action = $GLOBALS [REGISTERED_ACTIONS] [$name];
		if (isset ( $action )) {
			if (isset ( $_SESSION [SESSION_PARAM_LOGGED_USER] )) {
				$loggedUser = $_SESSION [SESSION_PARAM_LOGGED_USER];
			}
			
			if ($action == 0 || (isset($loggedUser) && $loggedUser->admin_user_level<=$action)) {
				call_user_func ( $name );
			}
		}
	}
}

?>