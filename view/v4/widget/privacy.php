<div id="memberPrivacy_modal" class="modal">
	<?php //if(isset($this->data['sys_configs']['shoparticle2_'.$this->data['ml_key']]) && $this->data['sys_configs']['shoparticle2_'.$this->data['ml_key']]!=''):?>
		<?php //echo $this->data['sys_configs']['shoparticle2_'.$this->data['ml_key']]?>
	<?php //endif?>

	<?php //2020-12-28 改為新資料流
		$_row1 = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('type','shoparticle5')->get('html')->row_array();
		if(isset($_row1['detail']) && $_row1['detail']!=''):?>
		<?php echo $_row1['detail']?>
	<?php endif?>
</div><!-- #memberPrivacy_modal-->
