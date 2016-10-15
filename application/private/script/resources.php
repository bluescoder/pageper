<?php 

/**
 * Script with usefule functions to manage access to resources in plugins
 */

/**
 * Gets an URL to embed in the HTML to access a plugin resources located in the 
 * plugin resources directory
 * @param $resource
 */
function get_resource_request_url($resource) {
	return URL_BASE . '/application/public/resource.php?resource=' . $resource;
}
?>