<?php if(!empty($def['updatefield']['sections'])):?>
	<?php if(!isset($this->data['updatecontent'])):?>
		<?php $this->data['updatecontent'] = array()?>
	<?php endif?>
	<?php $have_tabm = ''?>
	<?php foreach($def['updatefield']['sections'] as $k => $v):?>

		<?php // 每一個section可以有獨立的form tag?>
		<?php if(isset($v['form']['enable']) and $v['form']['enable'] == true):?>
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
		<?php if(!empty($v['field']) and isset($v['type'])):?>
				<?php if($v['type'] == '1' or $v['type'] == '2'):?>
					<table width="98%" border="0" cellspacing="1" cellpadding="7" class="table1 table">
						<tbody>
							<?php $this->data['k'] = $k?>
							<?php $this->data['v'] = $v?>
							<?php echo $this->renderPartial('//default/update_fields_section', $this->data)?>
						</tbody>
					</table>
				<?php endif?>
				<?php if($v['type'] == '3'):?>
					<?php $this->data['k'] = $k?>
					<?php $this->data['v'] = $v?>
					<?php echo $this->renderPartial('//default/update_fields_section', $this->data)?>
				<?php endif?>
			<?php if($v['type'] == 'tab'):?>
			<div style="height: 15px;" class="clearBoth"></div>
			<div class="tabSwitchFunction">
				<ul class="tabMenu tabs">
					<?php $tmp_first = 0?>
					<?php foreach($v['field'] as $kk => $vv):?>
					<li class="tabmenu_<?php echo $kk?> <?php if($tmp_first == 0):?>target<?php endif?>">
						<a href="javascript:;"><span><?php G::tf($this->data['theme_lang'], $vv['label'])?></span></a>
					</li>
					<?php $tmp_first++?>
					<?php endforeach?>
				</ul>
				<ul class="tabContent tabcontent">
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

		<?php if(isset($v['form']['enable']) and $v['form']['enable'] == true):?></form><?php endif?>
	<?php endforeach?>

	<?php if($have_tabm == '1'):?>
		<ul class="tabs">
			<?php $is_first = ''?>
			<?php foreach($def['updatefield']['sections'] as $k => $v):?>
				<?php if($v['type'] != 'tabm'){continue;}?>
				<?php if($is_first == ''){$is_first == '1';}?>

				<?php if(!empty($v['field'])):?>
					<?php if($v['type'] == 'tabm'):?>
						<li classg="<?php if($is_first == '1'){?>target<?php }?>">
							<a href="#tabs-<?php echo $k?>"><span><?php G::tf($this->data['theme_lang'], $v['label'])?></span></a>
						</li>
					<?php endif?>
				<?php endif?>
				<?php $is_first = '2'?>
			<?php endforeach?>
		</ul>
		<div class="tabcontent">
			<?php $is_first = ''?>
			<?php foreach($def['updatefield']['sections'] as $k => $v):?>
				<?php if($v['type'] != 'tabm'){continue;}?>
				<?php if($is_first == ''){$is_first == '1';}?>
				<div id="tabs-<?php echo $k?>" classg="<?php if($is_first == '1'){?>target<?php }?>">
					<?php $this->data['k'] = $k?>
					<?php $this->data['v'] = $v?>
					<?php echo $this->renderPartial('//default/update_fields_section', $this->data)?>
				</div>
				<?php $is_first = '2'?>
			<?php endforeach?>
		</div>
	<?php endif?>
<?php endif?>
