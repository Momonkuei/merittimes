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
				<?php foreach($v['form']['attr'] as $kk => $vv):?>
					<?php $formattr = $formattr.' '.$kk.'="'.$vv.'"'?>
				<?php endforeach?>
			<?php endif?>
			<?php // enctype="multipart/form-data" ?>
			<form <?php echo $formattr?>>
		<?php endif?>

	<?php if(isset($v['field']) and count($v['field']) >=1):?>
		<?php foreach($v['field'] as $row_tmp => $row_val_tmp)?>
		<?php if(count($v['field']) == 1 and preg_match('/^xxx/', $row_tmp)):?><?php continue?><?php endif?>
	<?php else:?>
		<?php continue?>
	<?php endif?>


	<div class="portlet box light-grey">
		<div class="portlet-title">
			<div class="caption"><i class="icon-reorder"></i><?php if(isset($v['section_title']) and $v['section_title'] != ''):?><a name="<?php echo $v['section_title']?>"></a><?php echo $v['section_title']?><?php endif?></div>
			<div class="tools">
				<a item_id="<?php echo $k?>" class="<?php if(isset($v['section_disable']) and $v['section_disable'] == true):?>expand<?php else:?>collapse<?php endif?>" href="javascript:;"></a>
				<?php if(0):?>
					<a class="config" data-toggle="modal" href="#portlet-config"></a>
					<a class="reload" href="javascript:;"></a>
					<a class="remove" href="javascript:;"></a>
				<?php endif?>
			</div>
		</div>
	<div class="portlet-body" <?php if(isset($v['section_disable']) and $v['section_disable'] == true):?>style="display:none"<?php endif?>>

		<?php //不同類型的區塊?>
		<?php if(!empty($v['field']) and isset($v['type'])):?>
				<?php if($v['type'] == '1' or $v['type'] == '2'):?>
					<table width="98%" border="0" cellspacing="1" cellpadding="7" class="table1 table">
						<tbody>
							<?php $this->data['k'] = $k?>
							<?php $this->data['v'] = $v?>
							<?php echo $this->renderPartial('default/update_fields_section', $this->data)?>
					</tbody>
					</table>

					<?php // 合併簡易和進階授權表 ?>
					<?php //if(file_exists(Yii::getPathOfAlias('system.themes.admin_yiiv_5.views.'.$this->data['router_class'].'.perm_merge').'.php')):?>
					<?php //endif?>
						<?php echo $this->renderPartial($this->data['router_class'].'/perm_merge', $this->data)?>
				<?php endif?>
				<?php if($v['type'] == '3'):?>
					<?php $this->data['k'] = $k?>
					<?php $this->data['v'] = $v?>
					<?php echo $this->renderPartial('default/update_fields_section', $this->data)?>
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
					<?php echo $this->renderPartial('default/update_fields_section', $this->data)?>
				</ul>
			</div>
			<?php elseif($v['type'] == 'tabm'):?>
				<?php $have_tabm = '1'?>
				<?php continue?>
			<?php endif?>
		<?php endif?>

	</div>


	</div> <!-- portlet box -->


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
					<?php echo $this->renderPartial('default/update_fields_section', $this->data)?>
				</div>
				<?php $is_first = '2'?>
			<?php endforeach?>
		</div>
	<?php endif?>
<?php endif?>
