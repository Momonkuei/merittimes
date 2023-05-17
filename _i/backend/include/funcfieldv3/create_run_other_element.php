<?php

// 2018-02-21 自動模組處理(auto_module_handle)
// 記得！create_run_other_element那邊也有
foreach($this->data['def']['updatefield']['sections'] as $k => $v){
	foreach($v['field'] as $kk => $vv){
		if(isset($vv['type'])){
			if($vv['type'] == 'multi-select'){
				if(isset($array[$kk]) && is_array($array[$kk])){
					$_count = count($array[$kk]);
				}else{
					$_count = 0;
				}
				if(isset($array[$kk]) and $_count > 0){
					$array[$kk] = ','.implode(',', $array[$kk]).',';
				} else {
					$array[$kk] = '';
				}
			}
		}
	}
}
