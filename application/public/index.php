<?php 
	require_once '/../private/script/application.php';
?>

<html>
	<head>
		<?php include_once APPLICATION_PRIVATE_VIEW_TEMPLATES . 'head.php'; ?>
	</head>
	
	<body>
		<?php 
			if(!is_installed()) {
				include APPLICATION_PRIVATE_VIEW_TEMPLATES . 'install_form.php';
			} else if(is_user_logged()) {	
				include APPLICATION_PRIVATE_VIEW_TEMPLATES . 'admin_panel_form.php';
			} else {
				include APPLICATION_PRIVATE_VIEW_TEMPLATES . 'login_form.php';
			}
		?>
	</body>
</html>