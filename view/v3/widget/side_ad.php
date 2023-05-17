<?php if(isset($this->data['sys_configs']['sidead_enable_'.$this->data['ml_key']]) and $this->data['sys_configs']['sidead_enable_'.$this->data['ml_key']] == 1):?>
<section class="sideAD">
	<div class="adBanner">
		<a href="<?php echo $this->data['sys_configs']['sidead_text_'.$this->data['ml_key']]?>"><img src="_i/assets/upload/sidead/<?php echo $this->data['sys_configs']['pic3_'.$this->data['ml_key']]?>"></a>
	</div>
</section>
<?php endif?>
