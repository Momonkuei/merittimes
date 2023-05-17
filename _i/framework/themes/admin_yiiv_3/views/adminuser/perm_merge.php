<fieldset>
	<legend><?php G::te(null, 'Premission Config', array(), '授權表') ?></legend>
	<table width="58%" border="0" cellspacing="1" cellpadding="7" class="table1">
<thead>
<tr>
	<th><label><?php G::te(null, 'Premission Function Name', array(), '&nbsp;') ?></label></th>
	<th width="8%"><label title="打勾以外的都能用，也就是打勾的不能用以外"> &nbsp;<?php G::te(null, 'Revert', array(), '反向') ?>&nbsp;</label></th>
	<th width="8%"><label title="打勾就是能用，反之"> &nbsp;<?php G::te(null, 'Simple', array(), '簡易') ?>&nbsp;</label></th>
	<th width="45%"><label title="跟簡易一樣，但是可以細到例如能不能新增等">&nbsp;&nbsp;<?php G::te(null, 'Professional Permission', array(), '進 階 授 權') ?></label></th>
</tr>
</thead>
<tbody>
	<?php if(isset($resources) and count($resources)):?>
		<?php foreach($resources as $k => $resource):?>
			<tr class="<?php echo ($k%2==1)?'bgcolor1':'bgcolor2' ?>">
			<td><label><?php G::te(null, $resource['description'])?></label></td>
			<td>
				<label title="<?php G::te(null, $resource['description'])?> - 反向">
					<input type="checkbox" value="1" name="autrz[<?php echo $resource['name']?>]" <?php if(isset($autrzs[$resource['name']]) and $autrzs[$resource['name']] > 0): ?>checked="checked"<?php endif?> />
				</label>
			</td>
			<td>
				<label title="<?php G::te(null, $resource['description'])?> - 簡易">
					<input type="checkbox" value="1" name="autz[<?php echo $resource['name']?>]" <?php if(isset($autzs[$resource['name']]) and $autzs[$resource['name']] > 0): ?>checked="checked"<?php endif?> />
				</label>
</td>
<td>
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
			</td></tr>
		<?php endforeach; ?>
	<?php endif?>

	<?php if(isset($urls) and count($urls)):?>
		<?php foreach($urls as $k => $url):?>
			<tr class="<?php echo ($k%2==1)?'bgcolor1':'bgcolor2' ?>">
			<td><label><?php G::te(null, $url['description'])?></label></td>
			<td>
				<label>
					<input type="checkbox" value="1" name="autr[<?php echo $url['id']?>]" <?php if(isset($autrs[$url['id']]) and $autrs[$url['id']] > 0): ?>checked="checked"<?php endif?> />
				</label>
			</td>
			<td>&nbsp;</td>
			<td>
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
			</td></tr>
		<?php endforeach; ?>
	<?php endif?>
	</tbody>
</table>
</fieldset>
