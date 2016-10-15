<?php 

// If application is already installed redirects to admin 
if(is_installed()) {
	header('Location: '. URL_BASE_ADMIN);
}

// Checks what is current installation step
if(!isset($_SESSION[PARAM_INSTALL_STEP])) {
	$_SESSION[PARAM_INSTALL_STEP] = 1;
}
$step = $_SESSION[PARAM_INSTALL_STEP];

?>

<html>
	<head>
		<?php include_once APPLICATION_PRIVATE_VIEW_TEMPLATES . 'head.php'; ?>
	</head>

	<body>
		<div id="admin-dialog">
				<?php
				if ($step == 1) {
					include_once APPLICATION_PRIVATE_VIEW_TEMPLATES . 'templates/install_step_1.php';
				} else if ($step == 2) {
					include_once APPLICATION_PRIVATE_VIEW_TEMPLATES . 'templates/install_step_2.php';
				} else if ($step == 3) {
					include_once APPLICATION_PRIVATE_VIEW_TEMPLATES . 'templates/install_step_3.php';
				} else {
					header('Location: '. URL_ADMIN);
				}
				?>
			</div>
	</body>
</html>