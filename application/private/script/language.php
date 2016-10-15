<?php 

/**
 * Script for languages management
 */

// Constants
define ('LANGUAGE_RESOURCES_PATH', APPLICATION_PRIVATE . 'resources/language/');
define ('LANGUAGE_FILE_TEMPLATE', LANGUAGE_RESOURCES_PATH . 'application_[CODE].properties');
define ('SESSION_PARAM_USER_LANGUAGE', 'session_param_user_language');
define ('GLOBAL_LANGUAGE_TEXTS', 'global_language_texts');

start_language();

/**
 * Determines language for user and load texts
 */
function start_language() {
if (! isset ( $_SESSION [SESSION_PARAM_USER_LANGUAGE] )) {
		$lang = strtolower ( substr ( $_SERVER ['HTTP_ACCEPT_LANGUAGE'], 0, 2 ) );
		if (is_valid_lang_code ( $lang )) {
			$_SESSION [SESSION_PARAM_USER_LANGUAGE] = $lang;
		} else {
			$_SESSION [SESSION_PARAM_USER_LANGUAGE] = DEFAULT_LANGUAGE;
		}
	}
	
	load_language_texts ( $_SESSION [SESSION_PARAM_USER_LANGUAGE] );
}

/**
 * Cgecks if received code is valid for any available language
 * @param $code
 * @return True/False
 */
function is_valid_lang_code($code) {
	return file_exists(str_replace("[CODE]", $code, LANGUAGE_FILE_TEMPLATE));
}

/**
 * Gets all available languages 
 */
function get_all_languages() {
	static $allLanguages;
	if (!isset ( $allLanguages )) {
		$db = get_db_handler ();
		$pps = $db->prepare ( "SELECT iso_639_1, description
				 FROM pgp_language" );
		$pps->execute ();
		$languagesResults = $pps->fetchAll ();
		if (count ( $languagesResults ) > 0) {
			$allLanguages = array();
			foreach($languagesResults as $l) {
				$languageVo = new Language($l['iso_639_1'], $l['description']);
				if(is_valid_lang_code($languageVo->iso6391)) {
					$allLanguages[$languageVo->iso6391] = $languageVo;
				} 
			}
		}
		
	}
	return $allLanguages;
}

/**
 * Load texts for given language code
 * @param $langCode
 */
function load_language_texts($langCode) {
	$texts = parse_ini_file(str_replace("[CODE]", $langCode, LANGUAGE_FILE_TEMPLATE));
	if(isset($texts) && $texts) {
		$GLOBALS[GLOBAL_LANGUAGE_TEXTS] = $texts;
	}
}

/**
 * Traduce el texto asociado a la clave recibida
 * @param $key
 * @return Texto traducido
 */
function text($key) {
	$text = $key;
	if(isset($GLOBALS[GLOBAL_LANGUAGE_TEXTS]) && isset($GLOBALS[GLOBAL_LANGUAGE_TEXTS][$key])) {
		$text = $GLOBALS[GLOBAL_LANGUAGE_TEXTS][$key];
	}
	return $text;
}

/**
 * Switch to received language
 * @param $code
 */
function switch_language($code) {
	$_SESSION[SESSION_PARAM_USER_LANGUAGE] = $code;
	start_language();
}

/**
 * Adds texts from a properties file
 * @param $filename
 */
function add_file_texts($filename) {
	if(isset($filename) && file_exists($filename)) {
		$texts = parse_ini_file ($filename);
		if(isset($GLOBALS[GLOBAL_LANGUAGE_TEXTS]) && isset($texts)) {
			foreach ($texts as $key => $value) {
				$GLOBALS[GLOBAL_LANGUAGE_TEXTS][$key] = $value;
			}
		}
	}
}

?>