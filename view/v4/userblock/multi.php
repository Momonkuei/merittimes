<?php

if(isset($_params_['id']) and $_params_['id'] > 0){
	$data[$ID] = $this->cidb->where('class_id',$_params_['id'])->order_by('sort_id')->get('html')->result_array();
}
