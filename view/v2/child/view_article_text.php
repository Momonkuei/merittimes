[POS1]
<?php if(isset($this->data['sys_configs'][$this->data['router_method'].'_'.$this->data['ml_key']]) and trim($this->data['sys_configs'][$this->data['router_method'].'_'.$this->data['ml_key']]) != ''):?>
	<?php echo $this->data['sys_configs'][$this->data['router_method'].'_'.$this->data['ml_key']]?>
<?php endif?>