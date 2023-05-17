<?php // 這裡是模組欄位必要的程式碼?>
<?php $kk = $this->data['vv_type_kk']?>
<?php $vv = $this->data['vv_type_vv']?>

<?php
// 模組相關設定
$tmp_module_config = array(
	'name' => 'Radio自定',
	'fields' => array(
		'html__id' => 'ID|',
		'html__name' => 'NAME|',
		'other__merge' => '合併左右欄位|',
		'other__html_start' => '左邊HTML|',
		'other__html_end' => '右邊HTML|',
		'emptyorm_rules__required' => '是否必填|0,1,true,false',
		'other__table_type' => '欄位類型|varchar,int,tinyint',
		'other__table_length' => '欄位長度|例：10',
	),
);

?>

<?php if(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'js'):?>

	<?php // do nothing?>

<?php elseif(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'view'):?>
	<?php // 這裡是模組欄位(view)必要的程式碼?>
	<?php $formattr = $this->data['vv_type_formattr']?>

	<?php if(isset($vv['other']['html_start'])):?><?php echo $vv['other']['html_start']?><?php endif?>
	<?php if($def['updatefield']['method'] == 'update'):?>

		<?php $isselectedvalue = ''?>
		<?php $isselectedvalue = $updatecontent[$kk]?>

		<?php if($isselectedvalue == ''):?>
			<?php if(isset($vv['other']['default']))://2021-08-05 lota add?>
				<?php $isselectedvalue = $vv['other']['default']?>
			<?php else:?>
				<?php $isselectedvalue = '0';?>
			<?php endif?>
		<?php endif?>

		<?php if(!empty($vv['other']['values'])):?>
			<?php foreach($vv['other']['values'] as $kkk => $vvv):?>
				<?php if(isset($vv['other']['html_start1'])):?><?php echo $vv['other']['html_start1']?><?php endif?>
				<?php if($isselectedvalue == $kkk):?>
					<label><input type="radio" <?php echo $formattr?> value="<?php echo $kkk?>" checked /><?php echo $vvv?></label>
				<?php else:?>
					<label><input type="radio" <?php echo $formattr?> value="<?php echo $kkk?>" /><?php echo $vvv?></label>
				<?php endif?>
				<?php if(isset($vv['other']['html_end1'])):?><?php echo $vv['other']['html_end1']?><?php endif?>
			<?php endforeach?>
		<?php endif?>

	<?php else:?>

		<?php if(!empty($vv['other']['values'])):?>
			<?php foreach($vv['other']['values'] as $kkk => $vvv):?>
				<?php if(isset($vv['other']['default']) and $vv['other']['default'] == $kkk):?>
					<label><input type="radio" <?php echo $formattr?> value="<?php echo $kkk?>" checked /><?php echo $vvv?></label>
				<?php else:?>
					<label><input type="radio" <?php echo $formattr?> value="<?php echo $kkk?>" /><?php echo $vvv?></label>
				<?php endif?>
			<?php endforeach?>
		<?php endif?>

	<?php endif?>
	<?php if(isset($vv['other']['html_end'])):?><?php echo $vv['other']['html_end']?><?php endif?>
<?php endif?>
