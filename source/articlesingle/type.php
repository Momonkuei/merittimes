<?php

if(isset($this->data['sys_configs'][$this->data['router_method'].'_'.$this->data['ml_key']])){
	$data[$ID] = $this->data['sys_configs'][$this->data['router_method'].'_'.$this->data['ml_key']];
} else {
	$data[$ID] = '';
}
