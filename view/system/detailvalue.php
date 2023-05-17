<?php

/*
 * 2019-12-06
 */

if(
	isset($_params_) and !empty($_params_)
	and isset($_params_['detailvalue_1']) and $_params_['detailvalue_1'] != '' // topic, name, pic1...
){
	if(isset($this->data['_general_detail'][$_params_['detailvalue_1']])){
		echo $this->data['_general_detail'][$_params_['detailvalue_1']];
	}
}
?>
