<?php if(isset($resources) and count($resources)):?>
	<fieldset>
		<legend><?php G::te(null, 'Simple Premission Config', array(), '簡易授權') ?></legend>
		<dl class="inline">
			<?php foreach($resources as $resource):?>
			<dt><label><?php G::te(null, $resource['description'])?></label></dt>
			<dd>
				<label>
					<input type="checkbox" value="1" name="autz[<?php echo $resource['name']?>]" <?php if(isset($autzs[$resource['name']]) and $autzs[$resource['name']] > 0): ?>checked="checked"<?php endif?> />
				</label>
			</dd>
		<?php endforeach; ?>
		</dl>
	</fieldset>

	<fieldset>
		<legend><?php G::te(null, 'Premission Detail Config', array(), '詳細授權') ?></legend>
		<dl class="inline">
			<?php foreach($resources as $resource):?>
			<dt><label><?php G::te(null, $resource['description'])?></label></dt>
			<dd>
				<?php foreach($resource['actions'] as $action):?>
					<label>
						<span>
							<input type="checkbox" <?php if(isset($autzs2[$resource['name']][$action]) and $autzs2[$resource['name']][$action] > 0): ?>checked="checked"<?php endif; ?> value="1" name="autz2[<?php echo $resource['name']?>][<?php echo $action ?>]" style="opacity: 1;">
							</span>
							<?php if($action == 'index'):
								G::te(null, $action, array(), '列表');
							elseif($action == 'create'):
								G::te(null, $action, array(), '新增');
							elseif($action == 'update'):
								G::te(null, $action, array(), '修改');
							elseif($action == 'delete'):
								G::te(null, $action, array(), '刪除');
							elseif($action == 'all'):
								G::te(null, $action, array(), '全部');
							elseif($action == 'export'):
								G::te(null, $action, array(), '匯出');
							else:
								G::te(null, $action);
							endif ?>
					</label>
				<?php endforeach; ?>
			</dd>
			<?php endforeach; ?>
		</dl>
	</fieldset>
<?php endif?>

<?php if(isset($urls) and count($urls)):?>
	<fieldset>
		<legend><?php G::te(null, 'Simple Premission Url Config', array(), '簡易網址授權') ?></legend>
		<dl class="inline">
			<?php foreach($urls as $url):?>
			<dt><label><?php G::te(null, $url['description'])?></label></dt>
			<dd>
				<label>
					<input type="checkbox" value="1" name="autr[<?php echo $url['id']?>]" <?php if(isset($autrs[$url['id']]) and $autrs[$url['id']] > 0): ?>checked="checked"<?php endif?> />
				</label>
			</dd>
		<?php endforeach; ?>
		</dl>
	</fieldset>

	<fieldset>
		<legend><?php G::te(null, 'Premission Detail Url Config', array(), '詳細網址授權') ?></legend>
		<dl class="inline">
			<?php foreach($urls as $url):?>
			<dt><label><?php G::te(null, $url['description'])?></label></dt>
			<dd>
				<?php foreach($url['actions'] as $action):?>
					<label>
						<span>
							<input type="checkbox" <?php if(isset($autrs2[$url['id']][$action]) and $autrs2[$url['id']][$action] > 0): ?>checked="checked"<?php endif; ?> value="1" name="autr2[<?php echo $url['id']?>][<?php echo $action ?>]" style="opacity: 1;">
							</span>
							<?php if($action == 'index'):
								G::te(null, $action, array(), '列表');
							elseif($action == 'create'):
								G::te(null, $action, array(), '新增');
							elseif($action == 'update'):
								G::te(null, $action, array(), '修改');
							elseif($action == 'delete'):
								G::te(null, $action, array(), '刪除');
							elseif($action == 'all'):
								G::te(null, $action, array(), '全部');
							elseif($action == 'export'):
								G::te(null, $action, array(), '匯出');
							else:
								G::te(null, $action);
							endif ?>
					</label>
				<?php endforeach; ?>
			</dd>
			<?php endforeach; ?>
		</dl>
	</fieldset>
<?php endif?>
