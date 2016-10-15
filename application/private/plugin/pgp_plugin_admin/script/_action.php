<?php 

/**
 * Script to process plugin actions from view
 */

register_action('pgp_plugin_install');
register_action('pgp_plugin_uninstall');

/**
 * Uninstall a plugin
 */
function pgp_plugin_uninstall() {
	if(isset($_POST['plugin'])) {
		$folder = $_POST['plugin'];
		$userPlugin = get_user_plugin_by_folder($folder);
		if (isset ( $userPlugin ) && $userPlugin->installed) {
			include_once $folder . '/script/_install.php';
			uninstall();
			unregister_installed_plugin ($userPlugin);
		}
	}
}

/**
 * Install a plugin
 */
function pgp_plugin_install() {
	if(isset($_POST['plugin'])) {
		$folder = $_POST['plugin'];
		$userPlugin = get_user_plugin_by_folder($folder);
		if (isset ( $userPlugin ) && ! $userPlugin->installed) {
			include_once $folder . '/script/_install.php';
			install ();
			register_installed_plugin ($userPlugin);
		}		
	}
}

/**
 * Register a plugin as installed
 * @param $folder
 */
function register_installed_plugin($userPlugin) {
	$db = get_db_handler();
	$pps = $db->prepare ( "INSERT INTO pgp_plugin (folder, name, version, required_user_level, ordering) 
			VALUES (:folder, :name, :version, :required_user_level, :ordering)" );
	$pps->bindParam(':folder', $userPlugin->folder);
	$pps->bindParam(':name', $userPlugin->nameKey);
	$pps->bindParam(':version', $userPlugin->version);
	$pps->bindParam(':required_user_level', $userPlugin->requiredLevelAccess);
	$pps->bindParam(':ordering', $userPlugin->order);
	$pps->execute ();
}

/**
 * Unregister an installed plugin
 * @param $folder
 */
function unregister_installed_plugin($userPlugin) {
	$db = get_db_handler();
	$pps = $db->prepare ( "DELETE FROM pgp_plugin 
			WHERE folder = :folder" );
	$pps->bindParam(':folder', $userPlugin->folder);
	$pps->execute ();
}





?>