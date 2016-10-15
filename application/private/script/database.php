<?php 

/**
 * Provides basic access to database
 */

/**
 * Gets the handler for database access
 */
function get_db_handler() {
	static $dbHandler;
	if (! isset ( $dbHandler )) {
		$dbHandler = new PDO ( 'sqlite:' . DB_PATH );
		$dbHandler->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	}
	return $dbHandler;
}

/**
 * Checks if a table exists in the database
 * @param $tableName
 */
function check_table_exists($tableName) {
	$db = get_db_handler();
	$pps = $db->prepare ( "SELECT COUNT(*) as tables_count
			 FROM sqlite_master
			 WHERE type='table'
			 	 AND name = :tableName" );
	$pps->bindParam(':tableName', $tableName);
	$pps->execute ();
	$results = $pps->fetchAll ();
	return $results [0] ['tables_count'] == 1;
}

/**
 * Drops a table
 * @param $tableName
 */
function drop_table($tableName) {
	if (check_table_exists ( $tableName )) {
		$db = get_db_handler ();
		$pps = $db->prepare ( "DROP TABLE " . $tableName );
		$pps->execute ();
	}
}

?>