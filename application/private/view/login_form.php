	<div id="admin-dialog">
		<h1 class="admin-dialog-title"><?php echo text('head.admin.login.title');?></h1>
		<form action="<?php echo PUBLIC_ACTION_URL; ?>" method="post" target="_self">
			<input type="hidden" name="action" value="action_login"/>
			<input class="admin-dialog-input-text" type="text" name="username" placeholder="Username"/>
			<input class="admin-dialog-input-text" type="password" name="password" placeholder="Password"/>
			<div class="center-div">
				<a class="admin-dialog-link" href=""><?php echo text('head.admin.login.forgotten.password');?></a>
			</div> 
			<input class="admin-dialog-input-button" type="submit" value="<?php echo text('head.admin.login.button');?>"/>
		</form>
	</div>