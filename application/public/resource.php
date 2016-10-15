<?php 

/** 
 * Script responsible for prividing resources from plugins
 */

require_once '/../private/script/application.php';

if(isset($_SESSION[PARAM_CURRENT_PLUGIN]) && isset($_GET['resource'])) {
	$currentPlugin = $_SESSION[PARAM_CURRENT_PLUGIN];
	$resource = $currentPlugin->folder . '/public/' . $_GET['resource'];

	if(file_exists($resource)) {
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$mimeType = finfo_file($finfo, $resource);
		$fileContent = file_get_contents($resource);
		if (isset ( $mimeType )) {
			header ( 'Content-type: ' . $mimeType . ';' );
		}
		header ( "Content-Length: " . strlen ( $fileContent ) );
		echo $fileContent;
	} 
	
}

?>