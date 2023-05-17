<?php

$has_full = false; // 是否滿版，預設否

if(isset($_params_['id']) and $_params_['id'] > 0){
	$gggzz = $this->cidb->where('id',$_params_['id'])->get('html')->row_array();
	if($gggzz){
		if($gggzz['is_home'] == 1){
			$has_full = true; // 滿版
		}
	}
}
