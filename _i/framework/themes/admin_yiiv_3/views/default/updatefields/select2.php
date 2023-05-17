<?php // 這裡是模組欄位必要的程式碼?>
<?php $kk = $this->data['vv_type_kk']?>
<?php $vv = $this->data['vv_type_vv']?>

<?php if(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'js'):?>

	<?php // do nothing?>

<?php elseif(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'view'):?>
	<?php // 這裡是模組欄位(view)必要的程式碼?>
	<?php $formattr = $this->data['vv_type_formattr']?>

	<?php if(isset($vv['other']['html_start'])):?><?php echo $vv['other']['html_start']?><?php endif?>
	<select <?php echo $formattr?>>
		<?php if(!empty($updatecontent[$kk])):?>
			<?php $isselectedvalue = ''?>
				<?php $select2_value = ''?>
			<?php if(isset($vv['other']['default'])):?>
				<?php $isselectedvalue = $vv['other']['default']?>
			<?php endif?>
			<?php foreach($updatecontent[$kk] as $kkk => $vvv):?>
				<?php if(isset($vvv['value']) and $vvv['value'] == "__empty"):?>
					<?php $select2_value = ''?>
				<?php else:?>
					<?php if(isset($vvv['value'])):?>
						<?php $select2_value = $vvv['value']?>
					<?php endif?>
				<?php endif?>

				<?php if(isset($vv['other']['default']) and $vv['other']['default'] != '' and $def['updatefield']['method'] == 'create'):?>
					<?php if($kkk == $isselectedvalue):?>
						<?php $isselected = 'selected'?>
					<?php endif?>
				<?php else:?>
					<?php if(isset($vvv['is_selected'])):?>
						<?php $isselected = $vvv['is_selected']?>
					<?php endif?>
				<?php endif?>

				<option value="<?php echo $select2_value?>" <?php echo $isselected?> ><?php echo $vvv['name']?></option>

				<?php $isselected = ''?>
			<?php endforeach?>
		<?php endif?>
	</select>
	<?php if(isset($vv['other']['html_end'])):?><?php echo $vv['other']['html_end']?><?php endif?>
<?php endif?>
