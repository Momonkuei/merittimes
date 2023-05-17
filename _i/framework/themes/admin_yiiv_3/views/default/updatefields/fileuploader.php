<?php // 這裡是模組欄位必要的程式碼?>
<?php $kk = $this->data['vv_type_kk']?>
<?php $vv = $this->data['vv_type_vv']?>

<?php if(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'js'):?>

	<?php // do nothing?>

<?php elseif(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'view'):?>
	<?php // 這裡是模組欄位(view)必要的程式碼?>
	<?php $formattr = $this->data['vv_type_formattr']?>

	<?php if(isset($vv['other']) and count($vv['other']) > 0 and isset($vv['other']['width'])):?>
		<?php if(isset($vv['other']['class']) and $vv['other']['class'] != ''):?>
			<?php $class = $vv['other']['class']?>
		<?php else:?>
			<?php $class = $router_class?>
		<?php endif?>

		<?php $this->data['action'] = $def['updatefield']['method']?>
		<?php $this->data['field'] = $kk?>
		<?php $this->data['number'] = $vv['other']['number']?>

		<?php //2016/5/13 lota fix  add ['other']['pic']?>
		<?php if(isset($vv['other']['pic']) && $vv['other']['pic']!=''):?>
			<?php $this->data['value'] = $vv['other']['pic']?>
		<?php else:?>
			<?php $this->data['value'] = G::a($updatecontent, 'updatecontent.'.$kk)?>
		<?php endif?>

		<?php $this->data['class'] = $class?>
		<?php $this->data['width'] = $vv['other']['width']?>
		<?php $this->data['height'] = $vv['other']['height']?>
		<?php $this->data['type'] = G::a($vv, 'vv.other.type')?>
		<?php $this->data['comment_size'] = $vv['other']['comment_size']?>
		<?php $this->data['top_button'] = $vv['other']['top_button']?>
		<?php $this->data['no_ext'] = $vv['other']['no_ext']?>
		<?php $this->data['no_need_delete_button'] = $vv['other']['no_need_delete_button']?>
		<?php if(isset($vv['other']['comment_file_size'])){
			$this->data['comment_file_size'] = $vv['other']['comment_file_size'];
		}
		?>

		<?php if(isset($vv['other']['comment']) and $vv['other']['comment'] != ''):?>
			<?php $this->data['comment'] = $vv['other']['comment']?>
		<?php else:?>
			<?php $this->data['comment'] = ''?>
		<?php endif?>

		<?php if(isset($vv['other']['html_start'])):?><?php echo $vv['other']['html_start']?><?php endif?>

		<?php echo $this->renderPartial('//includes/fileuploader', $this->data)?>

		<?php if($vv['other']['top_button'] != '1'):?><br /><?php endif?>
	<?php endif?>

	<?php if(isset($vv['other']['html_end'])):?><?php echo $vv['other']['html_end']?><?php endif?>
<?php endif?>
