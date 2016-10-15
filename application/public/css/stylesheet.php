<?php

require_once '/../../private/script/application.php';

// First of all send css header
header("Content-type: text/css");

// Array of css files
$css = array(
	'stylesheet.css'
);

// // Add current plugin css
$plugin = get_current_plugin();
if (isset ( $plugin )) {
	$filename = $plugin->folder . '/resources/stylesheet.css';
	if (file_exists ( $filename )) {
		array_push ( $css, $filename );
	}
} 

// // Prevent a notice
$css_content = '';

// // Loop the css Array
foreach ($css as $css_file) {
    $css_content .= file_get_contents($css_file);
}

// print the css content
echo $css_content;
?>
