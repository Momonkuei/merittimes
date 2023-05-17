<?php // 這裡是模組欄位必要的程式碼?>
<?php $kk = $this->data['vv_type_kk']?>
<?php $vv = $this->data['vv_type_vv']?>

<?php if(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'js'):?>

	<?php // do nothing?>

<?php elseif(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'view'):?>
	<?php // 這裡是模組欄位(view)必要的程式碼?>
	<?php $formattr = $this->data['vv_type_formattr']?>

	<?php if(isset($vv['other']['html_start'])):?><?php echo $vv['other']['html_start']?><?php endif?>
	<?php // 給純狀態型的資料使用，例如是、否、開啟、停用等?>
	<select <?php echo $formattr?>>
	<?php if(!empty($vv['other'])):?>
		<?php $isselectedvalue = ''?>
		<?php if($def['updatefield']['method'] == 'create'):?>
			<?php if(isset($vv['other']['default'])):?>
				<?php $isselectedvalue = $vv['other']['default']?>
			<?php endif?>
		<?php else:?>
			<?php $isselectedvalue = $updatecontent[$kk]?>
		<?php endif?>

		<?php if($isselectedvalue == ''):?>
			<?php $isselectedvalue = '0'?>
		<?php endif?>

		<?php if(!empty($vv['other']['values'])):?>
			<?php foreach($vv['other']['values'] as $kkk => $vvv):?>
				<?php if($isselectedvalue == $kkk):?>
					<option value="<?php echo $kkk?>" selected <?php if(!empty($vv['other']['style'][$kkk])):?>style="<?php echo $vv['other']['style'][$kkk]?>"<?php endif?>><?php echo $vvv?></option>
				<?php else:?>
					<option value="<?php echo $kkk?>" <?php if(!empty($vv['other']['style'][$kkk])):?>style="<?php echo $vv['other']['style'][$kkk]?>"<?php endif?>><?php echo $vvv?></option>
				<?php endif?>
			<?php endforeach?>
		<?php endif?>
	<?php endif?>
	</select>
	<?php if(isset($vv['other']['html_end'])):?><?php echo $vv['other']['html_end']?><?php endif?>
<?php endif?>
