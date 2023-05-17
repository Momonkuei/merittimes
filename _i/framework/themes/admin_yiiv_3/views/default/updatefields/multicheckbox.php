
<?php // 這裡是模組欄位必要的程式碼?>
<?php $kk = $this->data['vv_type_kk']?>
<?php $vv = $this->data['vv_type_vv']?>

<?php if(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'js'):?>

	<?php // do nothing?>

<?php elseif(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'view'):?>
	<?php // 這裡是模組欄位(view)必要的程式碼?>
	<?php $formattr = $this->data['vv_type_formattr']?>

	<?php // 一般的多選、或是class屬性加上"form-control input-large select2me"會變Tags?>
	<?php if(!empty($updatecontent[$kk])):?>
		<?php if(isset($vv['other']['html_start'])):?><?php echo $vv['other']['html_start']?><?php endif?>
		<?php $tmp01 = 0?>
		<?php foreach($updatecontent[$kk] as $kkk => $vvv):?>
			<?php $tmp01++?>
			<label><input <?php echo $formattr?> value="<?php echo $kkk?>" <?php if(isset($vvv['is_checked'])) echo $vvv['is_checked']?> /><?php echo $vvv['value']?></label>
			<?php if(!isset($vv['other']['split'])):?>
				<br />
			<?php else:?>
				<?php echo $vv['other']['split']?>
			<?php endif?>
			<?php if(isset($vv['other']['count'])):?>
				<?php if($tmp01 % $vv['other']['count'] == 0):?>
					<?php echo $vv['other']['split2']?>
				<?php endif?>
			<?php endif?>
		<?php endforeach?>
		<?php if(isset($vv['other']['html_end'])):?><?php echo $vv['other']['html_end']?><?php endif?>
	<?php else:?>
	<?php endif?>
<?php endif?>
