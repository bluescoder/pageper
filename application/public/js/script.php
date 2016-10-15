<?php

require_once '/../../private/script/application.php';

// First of all send js header
header("Content-type: application/javascript");

// Array of js files
$js = array(
	'jquery.min.js', 
	'pgp.js'
);

// // Add current plugin css
$plugin = get_current_plugin ();
if (isset ( $plugin )) {
	$filename = $plugin->folder . '/resources/script.js';
	if (file_exists ( $filename )) {
		array_push ( $js, $plugin->folder . '/resources/script.js' );
	}
} 

// // Prevent a notice
$js_content = '';

// // Loop the css Array
foreach ($js as $js_file) {
    $js_content .= file_get_contents($js_file);
}

// print the css content
echo $js_content;
?>