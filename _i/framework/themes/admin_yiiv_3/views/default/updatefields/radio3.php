<?php // 這裡是模組欄位必要的程式碼?>
<?php $kk = $this->data['vv_type_kk']?>
<?php $vv = $this->data['vv_type_vv']?>

<?php if(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'js'):?>

	<?php // do nothing?>

<?php elseif(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'view'):?>
	<?php // 這裡是模組欄位(view)必要的程式碼?>
	<?php $formattr = $this->data['vv_type_formattr']?>

	<?php // 給純狀態型的資料使用，例如是、否、開啟、停用等?>
	<?php if(!empty($vv['other'])):?>
		<?php if($def['updatefield']['method'] == 'create'):?>
			<?php $isselectedvalue = $vv['other']['default']?>
		<?php else:?>
			<?php $isselectedvalue = $updatecontent[$kk]?>
		<?php endif?>

		<?php if($isselectedvalue == ''):?>
			<?php $isselectedvalue = '0'?>
		<?php endif?>

		<?php if(!empty($vv['other']['values'])):?>
			<?php foreach($vv['other']['values'] as $kkk => $vvv):?>
				<?php if($isselectedvalue == $kkk):?>
				<label><input <?php echo $formattr?> value="<?php echo $kkk?>" checked /><?php echo $vvv?></label><?php if(!isset($vv['other']['nobr']) or $vv['other']['nobr'] != true):?><br /><?php endif?>
				<?php else:?>
					<label><input <?php echo $formattr?> value="<?php echo $kkk?>" /><?php echo $vvv?></label><?php if(!isset($vv['other']['nobr']) or $vv['other']['nobr'] != true):?><br /><?php endif?>
				<?php endif?>
			<?php endforeach?>
		<?php endif?>
	<?php endif?>
<?php endif?>
