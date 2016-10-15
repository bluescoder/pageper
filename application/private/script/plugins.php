<?php 

/**
 * Script to manage plugins added to the application
 */

define ('PARAM_PLUGINS', 'param_plugins');
define ('PARAM_CURRENT_PLUGIN', 'param_current_plugin');

register_action('set_current_plugin');

/**
 * Loads all plugins
 */
function load_all_plugins() {
	
	load_plugins_in_folder(PRIVATE_PLUGIN_FOLDER);
	
	if(isset($_REQUEST [PARAM_PLUGINS])) {
		foreach ($_REQUEST [PARAM_PLUGINS] as $plg) {
			$plg->installed = true;
			$plg->userPlugin = false;
		}
	}
	
	load_plugins_in_folder(PUBLIC_PLUGIN_FOLDER);
	
	if(isset($_REQUEST [PARAM_PLUGINS])) {
		usort($_REQUEST [PARAM_PLUGINS], 'compare_plugins_order');
	}
	
}

/**
 * Loads all plugins in the given folder
 * @param $folder Folder where search plugins
 */
function load_plugins_in_folder($folder) {
	$plugins = glob ( $folder . '*', GLOB_ONLYDIR );
	$loadedPlugins = array();
	foreach ( $plugins as $plg ) {
		$pluginInfo = load_plugin_info($plg);
		if(isset($pluginInfo)) {
			$loadedPlugins[$pluginInfo->folder] = $pluginInfo;
			load_plugin_texts($pluginInfo);
		}
	}
	if (isset ( $_REQUEST [PARAM_PLUGINS] )) {
		$_REQUEST [PARAM_PLUGINS] = array_merge( $_REQUEST [PARAM_PLUGINS], $loadedPlugins );
	} else {
		$_REQUEST [PARAM_PLUGINS] = $loadedPlugins;
	}

}

/**
 * Gets an object with plugin information
 * @param unknown $dir
 * @return Object created or null
 */
function load_plugin_info($dir) {
	$plugin = null;
	$fileName = $dir . '/resources/plugin.properties';
	
	if (file_exists ( $fileName )) {
		$info = parse_ini_file ( $fileName );
		if (isset ( $info ) && $info) {
			$nameKey = isset($info ['name']) ? $info ['name'] : null;
			$descriptionKey = isset($info ['description']) ? $info ['description'] : null;
			$version = isset($info ['version']) ? $info ['version'] : null;
			$requiredLevelAccess = isset($info ['required.level.access']) ? $info ['required.level.access'] : null;
			$order = isset($info ['order']) ? $info ['order'] : null;
			$folder = $dir;
			$installed = check_plugin_installed($folder);
			$pluginObj = new Plugin($folder, $installed, $version, $nameKey, $descriptionKey, $requiredLevelAccess);
			if(isset($pluginObj) && $pluginObj->check_minimum_data_provided()) {
				$plugin = $pluginObj;
			}
		}
	}
	return $plugin;
}

/**
 * Check if a plugin is installed
 * @param $folder
 */
function check_plugin_installed($folder) {
	$db = get_db_handler();
	$pps = $db->prepare ( "SELECT COUNT(*) as plugin_count
				 FROM pgp_plugin
				 WHERE folder = :folder" );
	$pps->bindParam(':folder', $folder);
	$pps->execute ();
	$pluginCount = $pps->fetchAll ();
	return $pluginCount[0]['plugin_count'] == 1 ? true : false;
}

/**
 * Loads texts for a plugin
 * @param $plugin
 */
function load_plugin_texts($plugin) {
	$filename = $plugin->folder . '/resources/languages/application_' . $_SESSION [SESSION_PARAM_LOGGED_USER]->language . '.properties';
	if(!file_exists($filename)) {
		$filename = $plugin->folder . '/resources/languages/application.properties';
		add_file_texts($filename);
	} else {
		add_file_texts($filename);
	}
}

/**
 * Gets the plugins information
 */
function get_plugins() {
	if(!isset($_REQUEST [PARAM_PLUGINS]) && isset($_SESSION [SESSION_PARAM_LOGGED_USER])) {
		load_all_plugins();
	}
	
	if(!isset($_REQUEST [PARAM_PLUGINS])) {
		$_REQUEST [PARAM_PLUGINS] = array();
	}
	
	return $_REQUEST [PARAM_PLUGINS];
}

/**
 * Compares two plugins order
 * @param $a
 * @param $b
 * @return Negative number, zero or positive number
 */
function compare_plugins_order($a, $b){
	return $b->order - $a->order;
}

/**
 * Gets the current plugin from session
 */
function get_current_plugin() {
	if(!isset($_SESSION[PARAM_CURRENT_PLUGIN])) {
		$plugins = get_plugins();
		if(isset($plugins) && count($plugins)>0) {
			$_SESSION[PARAM_CURRENT_PLUGIN] = reset($plugins);
		}
	}
	
	return isset($_SESSION[PARAM_CURRENT_PLUGIN]) ? $_SESSION[PARAM_CURRENT_PLUGIN] : null;
}

/**
 * Gets the plugins installed by user
 */
function get_user_plugins() {
	if(!isset($_REQUEST [PARAM_PLUGINS])) {
		load_all_plugins();
	}
	
	$userPlugins = array();
	foreach ($_REQUEST [PARAM_PLUGINS] as $pl) {
		if($pl->userPlugin) {
			$userPlugins[$pl->folder] = $pl;
		}
	}
	
	return $userPlugins;
}

/**
 * Gets a user plugin information by its folder
 * @param $folder
 */
function get_user_plugin_by_folder($folder) {
	$plugin = null;
	if (isset ( $folder )) {
		$userPlugins = get_user_plugins ();
		if (isset ( $userPlugins ) && count ( $userPlugins )) {
			foreach ( $userPlugins as $up ) {
				if ($up->folder == $folder) {
					$plugin = $up;
				}
			}
		}
	}
	return $plugin;
}

/**
 * Selects current plugin
 * @param $folder
 */
function set_current_plugin() {
	$plugins = get_plugins();
	if (isset($_POST['plugin-folder'])) {
		foreach ($plugins as $plg) {
			if($plg->folder == $_POST['plugin-folder']) {
				$_SESSION [PARAM_CURRENT_PLUGIN] = $plg;
			}
		}
	}
}


?>