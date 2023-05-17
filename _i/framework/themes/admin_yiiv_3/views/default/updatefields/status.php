<?php // 這裡是模組欄位必要的程式碼?>
<?php $kk = $this->data['vv_type_kk']?>
<?php $vv = $this->data['vv_type_vv']?>

<?php if(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'js'):?>

	<?php // do nothing?>

<?php elseif(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'view'):?>
	<?php // 這裡是模組欄位(view)必要的程式碼?>
	<?php $formattr = $this->data['vv_type_formattr']?>

	<?php if(isset($vv['other']['html_start'])):?><?php echo $vv['other']['html_start']?><?php endif?>
	<?php if($def['updatefield']['method'] == 'update'):?>
	
	<label class="radio-inline"><input type="radio" <?php echo $formattr?> value="1" <?php $this->widget('system.widgets.Gw_ez', array('e'=>"checked='checked'", 'z'=>'', 'v'=>G::a($updatecontent, 'updatecontent.'.$kk)))?> /><?php if(isset($vv['other']['other1']) and $vv['other']['other1'] != ''):?><?php G::te($this->data['theme_lang'], $vv['other']['other1'])?><?php else:?><?php G::te($this->data['theme_lang'], 'Show', null, '顯示')?><?php endif?></label>
	<label class="radio-inline"><input type="radio" <?php echo $formattr?> value="0" <?php $this->widget('system.widgets.Gw_ez', array('e'=>'', 'z'=>"checked='checked'",'v'=>G::a($updatecontent, 'updatecontent.'.$kk)))?> /><?php if(isset($vv['other']['other2']) and $vv['other']['other2'] != ''):?><?php G::te($this->data['theme_lang'], $vv['other']['other2'])?><?php else:?><?php G::te($this->data['theme_lang'], 'Hidden', null, '隱藏')?><?php endif?></label>
	<?php else:?>
	<label class="radio-inline"><input type="radio" <?php echo $formattr?> value="1" <?php if(isset($vv['other']['default']) and $vv['other']['default'] == ''){?>checked="checked"<?php }elseif(isset($vv['other']['default']) and $vv['other']['default'] == '1'){?>checked="checked"<?php }?> /><?php if(isset($vv['other']['other1']) and $vv['other']['other1'] != ''){?><?php G::te($this->data['theme_lang'], $vv['other']['other1'])?><?php }else{?><?php G::te($this->data['theme_lang'], 'Show', null, '顯示')?><?php }?></label>
	<label class="radio-inline"><input type="radio" <?php echo $formattr?> value="0" <?php if(isset($vv['other']['default']) and $vv['other']['default'] == '0'){?>checked="checked"<?php }?> /><?php if(isset($vv['other']['other2']) and $vv['other']['other2'] != ''){?><?php G::te($this->data['theme_lang'], $vv['other']['other2'])?><?php }else{?><?php G::te($this->data['theme_lang'], 'Hidden', null, '隱藏')?><?php }?></label>
	<?php endif?>
	<?php if(isset($vv['other']['html_end'])):?><?php echo $vv['other']['html_end']?><?php endif?>
<?php endif?>
