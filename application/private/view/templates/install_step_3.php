<?php include_once APPLICATION_PRIVATE_VIEW_TEMPLATES . 'templates/install_header.php'; ?>

<div class="install-center-div">
	<form action="<?php echo URL_BASE . '/application/public/action.php'; ?>" method="post" target="_self">
		<input type="hidden" name="action" value="action_install_step_3"/>
		<p class="install-text"> <?php echo text('install.complete.text'); ?> </p>
		<input class="install-button line" type="submit" value="<?php echo text('install.finish.btn'); ?>"/>
	</form>
	
</div>
