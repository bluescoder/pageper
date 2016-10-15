<div class="p_header">
	<h1 class="p_title"><?php echo text('pgp.plugin.admin.name') . " - " . text('pgp.plugin.admin.description'); ?></h1>
</div>

<div class="p_content">
	<div class="p_table">
		<table>
			<thead>
			  <tr>
			    <th>Name</th>
			    <th>Description</th>
			    <th>Folder</th>
			    <th>Version</th>
			    <th>Installed</th>
			    <th></th>
			  </tr>
			</thead>
			<tbody>
				<?php 
					$alt = false;
					$userPlugins = get_user_plugins();
					foreach ($userPlugins as $up) {
				?>
			  <tr <?php if($alt) { echo 'class="alt"'; } $alt = !$alt; ?>>
					<form action="<?php echo URL_BASE . '/application/public/action.php'; ?>" method="post" target="_self">
						<input type="hidden" name="action" value="<?php if($up->installed) { echo 'pgp_plugin_uninstall'; } else { echo 'pgp_plugin_install'; }?>"/>
						<input type="hidden" name="plugin" value="<?php echo $up->folder; ?>"/>
				    <td><?php echo text($up->nameKey); ?></td>
				    <td><?php echo text($up->descriptionKey); ?></td> 
				    <td><?php echo $up->get_short_folder_name(); ?></td>
				    <td><?php echo $up->version; ?></td>
				    <td><?php if($up->installed) { echo text('word.yes'); } else {echo text('word.no');}?></td>
				    <td><input class="p_button" type="submit" value="<?php if($up->installed) { echo text('pgp.plugin.admin.uninstall'); } else { echo text('pgp.plugin.admin.install');}?>"/></td>
			    </form>
			  </tr>
				<?php 					
					}
				?>
			</tbody>
		</table>
	</div>
</div>
