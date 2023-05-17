<?php if(!empty($def['updatefield']['sections'])):?>
	<?php $have_tabm = ''?>
	<?php foreach($def['updatefield']['sections'] as $k => $v):?>
		<?php // 每一個section可以有獨立的form tag?>
		<?php if($v['form']['enable'] == true):?>
			<?php $formattr = ''?>
			<?php if(!empty($v['form']['attr'])):?>
				<?php foreach($v['form']['attr'] as $k => $v):?>
					<?php $formattr = $formattr.' '.$k.'="'.$v.'"'?>
				<?php endforeach?>
			<?php endif?>
			<?php // enctype="multipart/form-data" ?>
			<form <?php echo $formattr?>>
		<?php endif?>

		<?php //不同類型的區塊?>
		<?php if(!empty($v['field'])):?>
				<?php if($v['type'] == '1'):?>
					<fieldset>
						<legend><?php G::te(null, 'Normal Config', array(), '基本設定') ?></legend>
						<dl class="inline">
							<?php $this->data['k'] = $k?>
							<?php $this->data['v'] = $v?>
							<?php echo $this->renderPartial('//default/update_fields_section', $this->data)?>
						</dl>
					</fieldset>
				<?php endif?>

				<?php if(0):?>
				<?php echo $this->renderPartial('//'.$this->data['router_class'].'/perm', $this->data)?>
				<?php endif?>

				<?php // 合併簡易和進階授權表 ?>
				<?php echo $this->renderPartial('//'.$this->data['router_class'].'/perm_merge', $this->data)?>

				<?php if($v['type'] == '2'):?>
					<dl class="inline">
					<?php $this->data['k'] = $k?>
					<?php $this->data['v'] = $v?>
					<?php echo $this->renderPartial('//default/update_fields_section', $this->data)?>
					</dl>
				<?php endif?>
			<?php if($v['type'] == 'tab'):?>
			<div style="height: 15px;" class="clearBoth"></div>
			<div class="tabSwitchFunction">
				<ul class="tabMenu">
					<?php $tmp_first = 0?>
					<?php foreach($v['field'] as $kk => $vv):?>
					<li class="tabmenu_<?php echo $kk?> <?php if($tmp_first == 0):?>target<?php endif?>">
						<a href="javascript:;"><span><?php G::tf($this->data['theme_lang'], $vv['label'])?></span></a>
					</li>
					<?php $tmp_first++?>
					<?php endforeach?>
				</ul>
				<ul class="tabContent">
					<?php $this->data['k'] = $k?>
					<?php $this->data['v'] = $v?>
					<?php echo $this->renderPartial('//default/update_fields_section', $this->data)?>
				</ul>
			</div>
			<?php elseif($v['type'] == 'tabm'):?>
				<?php $have_tabm = '1'?>
				<?php continue?>
			<?php endif?>
		<?php endif?>

		<?php if($v['form']['enable'] == true):?></form><?php endif?>
	<?php endforeach?>

	<?php if($have_tabm == '1'):?>
		<div style="height: 15px;" class="clearBoth"></div>
		<div class="tabSwitchFunction">
			<ul class="tabMenu">
				<?php $is_first = ''?>
				<?php foreach($def['updatefield']['sections'] as $k => $v):?>
					<?php if($v['type'] != 'tabm'){continue;}?>
					<?php if($is_first == ''){$is_first == '1';}?>

					<?php if(!empty($v['field'])):?>
						<?php if($v['type'] == 'tabm'):?>
							<li class="tabmenu_<?php echo $k?> <?php if($is_first == '1'){?>target<?php }?>">
								<a href="javascript:;"><span><?php G::tf($this->data['theme_lang'], $vv['label'])?></span></a>
							</li>
						<?php endif?>
					<?php endif?>
					<?php $is_first = '2'?>
				<?php endforeach?>
			</ul>
			<ul class="tabContent">
				<?php $is_first = ''?>
				<?php foreach($def['updatefield']['sections'] as $k => $v):?>
					<?php if($v['type'] != 'tabm'){continue;}?>
					<?php if($is_first == ''){$is_first == '1';}?>
					<li class="tabmenu_<?php echo $k?> <?php if($is_first == '1'){?>target<?php }?>">
						<div style="height:15px;" class="clearBoth"></div>
						<?php $this->data['k'] = $k?>
						<?php $this->data['v'] = $v?>
						<?php echo $this->renderPartial('//default/update_fields_section', $this->data)?>
					</li>
					<?php $is_first = '2'?>
				<?php endforeach?>
			</ul>
		</div>
	<?php endif?>
<?php endif?>
