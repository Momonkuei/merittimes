<?php if(isset($this->data['layoutv2_param'][$this->data['section']['key']][1])):?>
	<?php $param1 = $this->data['layoutv2_param'][$this->data['section']['key']][1]?>
	<?php if(isset($this->data['layoutv2'][$this->data['section']['key']][$param1])):?>
		<?php echo $this->data['layoutv2'][$this->data['section']['key']][$param1]?>
	<?php endif?>
<?php endif?>
