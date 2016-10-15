<?php 

	$loggedUser = $_SESSION[SESSION_PARAM_LOGGED_USER];
	$current_plugin_option = get_current_plugin();

?>
<div id="panel-area">
	<div class="ap-header-div">
		<div class="ap-header-element">
			<p class="ap-header-text"> <?php echo $loggedUser->alias; ?> </p>
		</div>
		<div class="ap-header-element">
			<p id="closeSessionBtn" class="ap-header-text ap-text-link"> <?php echo text('close.session'); ?> </p>
			<form id="closeSessionForm" action="<?php echo PUBLIC_ACTION_URL; ?>" method="post" target="_self">
				<input type="hidden" name="action" value="action_logout"/>
			</form>
		</div>
	</div>

	<div id="ap-main-area">
		<div id="menu-plugin">
			<?php 
				$plugins = get_plugins();
				if(isset($plugins)) {
					foreach ($plugins as $plg) {
						if(isset($plg->installed) && $plg->installed && isset($plg->requiredLevelAccess) 
								&& $plg->requiredLevelAccess>=$loggedUser->admin_user_level) {
						$selected = isset($current_plugin_option) ? $current_plugin_option->nameKey == $plg->nameKey : false;
			?>
			
			<div class="ap-plugin-menu <?php if($selected ) {echo 'ap-plugin-menu-selected'; } ?>">
				<form action="<?php echo PUBLIC_ACTION_URL; ?>" method="post" target="_self">
					<input type="hidden" name="action" value="set_current_plugin"/>
					<p class="ap-plugin-menu-name"><?php echo text($plg->nameKey); ?></p>
					<input name="plugin-folder" type="hidden" value="<?php echo $plg->folder; ?>" />
				</form>
			</div>
			
			<?php 
						}
					}
				}
			?>
		</div>
		
		<div id="content-plugin">
			<?php 
				if(isset($current_plugin_option) && $current_plugin_option->installed) {
					include $current_plugin_option->folder . '/index.php';
				}
			?>
		</div>
	</div>
	
</div>

	
	<script>
	
		$("#closeSessionBtn").click(function() {
			$("#closeSessionForm").submit();
		});

		$(".ap-plugin-menu-name").click(function() {
			$(this).parent().submit();
		});
		
	</script>
