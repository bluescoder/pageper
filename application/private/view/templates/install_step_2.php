<?php include_once APPLICATION_PRIVATE_VIEW_TEMPLATES . 'templates/install_header.php'; ?>

<p class="install-text"><?php echo text('fill.form'); ?> </p>

<div class="install-center-div">
	<form action="<?php echo PUBLIC_ACTION_URL; ?>" method="post" target="_self">
		<input type="hidden" name="action" value="action_install_step_2"/>
		<div class="block-div">
			<input class="install-text" type="text" name="firstName" placeholder="<?php echo text('first.name'); ?>" <?php if(isset($_POST['firstName'])) { echo "value=\"" . $_POST['firstName'] . "\""; }?> />
			<input class="install-text" type="text" name="lastName" placeholder="<?php echo text('last.name'); ?>" <?php if(isset($_POST['firstName'])) { echo "value=\"" . $_POST['lastName'] . "\""; }?>/>
			<input class="install-text" type="text" name="alias" placeholder="<?php echo text('username'); ?>" <?php if(isset($_POST['firstName'])) { echo "value=\"" . $_POST['alias'] . "\""; }?>/>
			<input class="install-text" type="text" name="email" placeholder="<?php echo text('email'); ?>" <?php if(isset($_POST['firstName'])) { echo "value=\"" . $_POST['email'] . "\""; }?>/>
			<input class="install-text" type="password" name="pass1" placeholder="<?php echo text('password'); ?>" />
			<input class="install-text" type="password" name="pass2" placeholder="<?php echo text('password.repeat'); ?>"/>
		</div>
		
		<?php 
		if(isset($_SESSION["error"])) {
		?>
		<p class="install-error"> <?php echo $_SESSION["error"]; ?> </p>
		<?php 
		unset($_SESSION["error"]);
		}
		?>
		
		<input id="backBtn" class="install-button line" type="button" value="<?php echo text('install.previous.btn'); ?>"/>
		<input class="install-button line" type="submit" value="<?php echo text('install.next.btn'); ?>"/>
	</form>
	
	<form id="backForm" action="<?php echo PUBLIC_ACTION_URL; ?>" method="post" target="_self">
		<input type="hidden" name="action" value="action_install_step_2_back"/>
		<input type="hidden" name="back"/>
	</form>
</div>

<script>
$("#backBtn").click(function() {
	$("#backForm").submit();
});
</script>