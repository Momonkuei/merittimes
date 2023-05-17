<?php $tmp_first = 0?>
<?php $configed = array()?>
<?php $configed2 = array()?>
<?php foreach($v['field'] as $kk => $vv):?>
	<?php $formattr = ''?>
	<?php if(!empty($vv['attr'])):?>
		<?php foreach($vv['attr'] as $kkk => $vvv):?>
			<?php $formattr = $formattr.' '.$kkk.'="'.$vvv.'"'?>
		<?php endforeach?>
	<?php endif?>

	<?php $field_is_required = ''?>
	<?php if(isset($updatecontent_jqueryvalidation[$kk]['required']) and $updatecontent_jqueryvalidation[$kk]['required'] == 'true'):?>
		<?php $field_is_required = '*'?>
	<?php endif?>

	<?php if(!isset($vv['type'])):?>
		<?php continue?>
	<?php endif?>

	<?php if(!preg_match('/hidden/', $vv['type'])):?>
		<?php if(!isset($configed[$v['type']])):?>
			<?php $configed[$v['type']] = 0?>
		<?php endif?>
		<?php $configed[$v['type']]++?>
	<?php endif?>

	<?php if(isset($updatecontent[$kk]) and isset($vv['other']['number_format']) and $vv['other']['number_format']):?>
		<?php $updatecontent[$kk] = number_format((int)$updatecontent[$kk])?>
	<?php endif?>
		
	<?php // 每個欄位的包頭?>
	<?php if(!preg_match('/hidden/', $vv['type'])):?>
		<?php if($v['type'] == '1'):?>

			<?php $formattr_td1 = ''?>
			<?php if(!empty($vv['attr_td1'])):?>
				<?php foreach($vv['attr_td1'] as $kkk => $vvv):?>
					<?php $formattr_td1 = $formattr_td1.' '.$kkk.'="'.$vvv.'"'?>
				<?php endforeach?>
			<?php endif?>

			<?php $formattr_td2 = ''?>
			<?php if(!empty($vv['attr_td2'])):?>
				<?php foreach($vv['attr_td2'] as $kkk => $vvv):?>
					<?php $formattr_td2 = $formattr_td2.' '.$kkk.'="'.$vvv.'"'?>
				<?php endforeach?>
			<?php endif?>

			<?php if(isset($vv['merge'])):?>
				<?php // 如果有啟用merge，而且是1，才會包頭?>
				<?php if($vv['merge'] == '1'):?>
					<tr class="<?php echo ($configed[$v['type']]%2==1)?'bgcolor1':'bgcolor2' ?>"><td <?php echo $formattr_td1?> >
							<?php //G::te($this->data['theme_lang'], G::a($vv, 'vv.label'))?>
							<?php if(isset($vv['label']) and $vv['label'] != ''):?>
								<?php if(isset($vv['translate_source']) and $vv['translate_source'] != ''):?>
									<?php echo G::_($vv['label'], $vv['translate_source'])?>
								<?php else:?>
									<?php echo $vv['label']?>
								<?php endif?>
							<?php endif?>
							<?php if(0 and isset($vv['mlabel'])):?><?php G::te(G::a($vv, 'vv.mlabel.0'), G::a($vv, 'vv.mlabel.1'), G::a($vv, 'vv.mlabel.2'), G::a($vv, 'vv.mlabel.3'))?><?php endif?>
<?php if(0):?>
						<label>
						</label>
<?php endif?>
						<?php if($vv['type'] != 'mls'):?><span class="required"><?php echo $field_is_required?></span><?php endif?>
					</td>
					<td <?php echo $formattr_td2?> >
				<?php // 如果是1.5，就不會建立欄位的名稱?>
				<?php elseif($vv['merge'] == '1.5'):?>
					<?php $formattr_tr = ''?>
					<?php if(!empty($vv['attr_tr'])):?>
						<?php foreach($vv['attr_tr'] as $kkk => $vvv):?>
							<?php $formattr_tr = $formattr_tr.' '.$kkk.'="'.$vvv.'"'?>
						<?php endforeach?>
					<?php endif?>
					<tr <?php echo $formattr_tr?>  class="<?php echo ($configed[$v['type']]%2==1)?'bgcolor1':'bgcolor2' ?>"><td <?php echo $formattr_td1?> >
						<?php //G::te($this->data['theme_lang'], G::a($vv, 'vv.label'))?>
						<?php if(isset($vv['label']) and $vv['label'] != ''):?>
							<?php if(isset($vv['translate_source']) and $vv['translate_source'] != ''):?>
								<?php echo G::_($vv['label'], $vv['translate_source'])?>
							<?php else:?>
								<?php echo $vv['label']?>
							<?php endif?>
						<?php endif?>
						<?php if(0 and isset($vv['mlabel'])):?><?php G::te(G::a($vv, 'vv.mlabel.0'), G::a($vv, 'vv.mlabel.1'), G::a($vv, 'vv.mlabel.2'), G::a($vv, 'vv.mlabel.3'))?><?php endif?>
<?php if(0):?>
						<label>
						</label>
<?php endif?>
				<?php else:?>
					<?php //G::te($this->data['theme_lang'], G::a($vv, 'vv.label'))?>
					<?php if(isset($vv['label']) and $vv['label'] != ''):?>
						<?php if(isset($vv['translate_source']) and $vv['translate_source'] != ''):?>
							<?php echo G::_($vv['label'], $vv['translate_source'])?>
						<?php else:?>
							<?php echo $vv['label']?>
						<?php endif?>
					<?php endif?>
					<?php if(0 and isset($vv['mlabel'])):?><?php G::te(G::a($vv, 'vv.mlabel.0'), G::a($vv, 'vv.mlabel.1'), G::a($vv, 'vv.mlabel.2'), G::a($vv, 'vv.mlabel.3'))?><?php endif?>
<?php if(0):?>
					<label>
					</label>
<?php endif?>
				<?php endif?>
			<?php else:?>
				<tr class="<?php echo ($configed[$v['type']]%2==1)?'bgcolor1':'bgcolor2' ?>"><td <?php echo $formattr_td1?> >
					<?php //G::te($this->data['theme_lang'], G::a($vv, 'vv.label'))?>
					<?php if(isset($vv['label']) and $vv['label'] != ''):?>
						<?php if(isset($vv['translate_source']) and $vv['translate_source'] != ''):?>
							<?php echo G::_($vv['label'], $vv['translate_source'])?>
						<?php else:?>
							<?php echo $vv['label']?>
						<?php endif?>
					<?php endif?>
					<?php if(0 and isset($vv['mlabel'])):?><?php G::te(G::a($vv, 'vv.mlabel.0'), G::a($vv, 'vv.mlabel.1'), G::a($vv, 'vv.mlabel.2'), G::a($vv, 'vv.mlabel.3'))?><?php endif?>
<?php if(0):?>
					<label>
					</label>
<?php endif?>
					<?php if($vv['type'] != 'mls'):?><span class="required"><?php echo $field_is_required?></span><?php endif?>
				</td>
				<td <?php echo $formattr_td2?> >
			<?php endif?>

		<?php elseif($v['type'] == '2'):?>
			<tr class="<?php echo ($configed[$v['type']]%2==1)?'bgcolor1':'bgcolor2' ?>"><td>

			<?php if(isset($vv['label']) and $vv['label'] != ''):?>
<?php if(0):?>
				<label><?php G::te($this->data['theme_lang'], $vv['label'])?></label>
<?php endif?>
				<?php if(isset($vv['label']) and $vv['label'] != ''):?>
					<?php if(isset($vv['translate_source']) and $vv['translate_source'] != ''):?>
						<label><?php echo G::_($vv['label'], $vv['translate_source'])?></label>
					<?php else:?>
						<label><?php echo $vv['label']?></label>
					<?php endif?>
				<?php endif?>
				<?php if($vv['type'] != 'mls'):?><span class="required"><?php echo $field_is_required?></span><?php endif?>
			<?php endif?>

			<?php if(0 and isset($vv['mlabel']) and $vv['mlabel'] != ''):?>
				<label>
					<?php if(isset($vv['mlabel'])):?><?php G::te(G::a($vv, 'vv.mlabel.0'), G::a($vv, 'vv.mlabel.1'), G::a($vv, 'vv.mlabel.2'), G::a($vv, 'vv.mlabel.3'))?><?php endif?>
				</label>
				<?php if($vv['type'] != 'mls'):?><span class="required"><?php echo $field_is_required?></span><?php endif?>
			<?php endif?>

		<?php elseif($v['type'] == '3'):?>
			<div style="height: 10px;" class=""></div>
		<?php elseif($v['type'] == 'tab'):?>
		<li class="tabmenu_{{$kk}} <?php if($tmp_first == 0){?>target<?php }?>">
			<?php if(isset($vv['describe']) and $vv['describe'] != ''):?>
				<div style="height:28px;" class="clearBoth"><?php G::te($this->data['theme_lang'], G::a($vv, 'vv.describe'))?><font color="red"><?php echo $field_is_required?></font></div>
			<?php endif?>
			<?php if(isset($vv['describe_html']) and $vv['describe_html'] != ''):?>
				<?php echo $vv['describe_html']?>
			<?php endif?>
		<?php elseif($v['type'] == 'tabm'):?>
			<?php if(isset($vv['describe']) and $vv['describe'] != ''):?>
				<div style="height:28px;" class="clearBoth"><?php G::te($this->data['theme_lang'], G::a($vv, 'vv.describe'))?><font color="red"><?php echo $field_is_required?></font></div>
			<?php endif?>
			<?php if(isset($vv['describe_html']) and $vv['describe_html'] != ''):?>
				<?php echo $vv['describe_html']?>
			<?php endif?>
		<?php endif?>
	<?php endif?>

	<?php if($vv['type'] == 'mls_killme'):?>
		<?php if($def['updatefield']['method'] == 'update'):?>
		<label><?php $this->widget('system.widgets.Gw_mls', array('v'=>$updatecontent[$kk]))?></label>
		<?php else:?>
		<label><?php $this->widget('system.widgets.Gw_mls', array('v'=>$ml_key))?></label>
		<?php endif?>


	<?php //上面是不跳行欄位，而下面是 ?>

	<?php else:?>

		<?php 
			/*
			 * 欄位的模組化
			 */
		?>
		<?php if($vv['type'] != ''):?>
			<?php $module_field_content = ''?>

			<?php // 因為模組裡面會有很多成份?>
			<?php $this->data['vv_type_select'] = 'view'/* view|js|update_show_last等 */?>

			<?php // 這是view的專用模組變數?>
			<?php // 因為一般的變數是傳不過去的?>
			<?php $this->data['vv_type_kk'] = $kk?>
			<?php $this->data['vv_type_vv'] = $vv?>
			<?php $this->data['vv_type_formattr'] = $formattr?>

			<?php try { ?>
			<?php	$module_field_content = $this->renderPartial('//default/updatefields/'.$vv['type'], $this->data, true)?>
			<?php } catch(Exception $e){} ?>

			<?php if($module_field_content != ''):?>
				<?php echo $module_field_content?>
			<?php endif?>
		<?php else:?>
			<?php if($def['updatefield']['method'] == 'update' and isset($updatecontent[$kk])):?>
				<?php echo $updatecontent[$kk]?>
			<?php endif?>
		<?php endif?>

	<?php endif?>


	<?php // 每個欄位的包尾 ?>
	<?php if(!preg_match('/hidden/', $vv['type'])):?>
		<?php if($v['type'] == '1'):?>
		<?php if(isset($vv['end_text']) and $vv['end_text'] != ''):?><?php echo $vv['end_text']?><?php endif?>
			<?php if(isset($vv['merge'])):?>
				<?php // 如果有啟用merge，而且是3，才會包尾?>
				<?php if($vv['merge'] == '3'):?></td></tr><?php endif?>
			<?php else:?>
				</td></tr>
			<?php endif?>
			
		<?php elseif($v['type'] == '2'):?>
			</tr>
		<?php elseif($v['type'] == '3'):?>
		<?php // 第2個區塊沒有包尾?>
		<?php elseif($v['type'] == 'tab'):?>
		</li>
		<?php endif?>
	<?php endif?>

	<?php $tmp_first++?>
<?php endforeach?>
