<?php 

/**
 * Script responsible for form actions processing
 */

require_once '/../private/script/application.php';

$currentPlugin = get_current_plugin();
if(isset($currentPlugin)) {
	include_once $currentPlugin->folder . "/script/_action.php";
}

if(isset($_POST['action'])) {
	$action = $_POST['action'];
	process_action($action);
} 

header('Location:' . URL_BASE_ADMIN);

?>