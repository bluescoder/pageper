<?php include_once APPLICATION_PRIVATE_VIEW_TEMPLATES . 'templates/install_header.php'; ?>
					
<p class="install-text"><?php echo text('select.language'); ?> </p>

<div class="install-center-div">
	<form action="<?php echo URL_BASE . '/application/public/action.php'; ?>" method="post" target="_self">
		<input type="hidden" name="action" value="action_install_step_1"/>
		<div class="block-div">
			<select name="lang" class="install-select">
				<?php 
				$allLanguages = get_all_languages();
				foreach ($allLanguages as $l) {
				?>
					<option value="<?php echo $l->iso6391; ?>" <?php if($l->iso6391 == $_SESSION [SESSION_PARAM_USER_LANGUAGE]) {echo 'selected';}?>><?php echo $l->description; ?></option>
				<?php 
				}
				?>
			</select>
		</div>
		
		<input class="install-button" type="submit" value="<?php echo text('install.next.btn'); ?>"/>
	</form>
</div>