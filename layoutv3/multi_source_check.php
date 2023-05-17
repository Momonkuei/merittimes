<?php

// 多筆、多筆、單筆、多筆
// if(count($DATA_SINGLE_MULTI) == 4 and $DATA_SINGLE_MULTI[0] == 'DATA_MULTI' and $DATA_SINGLE_MULTI[1] == 'DATA_MULTI' and $DATA_SINGLE_MULTI[2] == 'DATA_SINGLE' and $DATA_SINGLE_MULTI[3] == 'DATA_MULTI'){

/*
 * 使用方式
 * $layoutv3_condition = 'multi|single';
 * include 'layoutv3/multi_source_check.php';
 * if($layoutv3_condition === true){
 *		do something
 * }
 */

if(isset($layoutv3_condition)){
	$tmps = explode('|', $layoutv3_condition);

	$layoutv3_condition = false;

	if(count($tmps) > 0){
		$check_count = count($tmps);

		$check_condition = '';
		foreach($tmps as $check_k => $check_v){
			$tmps[$check_k] = '$DATA_SINGLE_MULTI['.$check_k.'] == "DATA_'.strtoupper($check_v).'"';
		}
		$check_condition = implode(' and ', $tmps);

		$check_eval = <<<XXX
if(count(\$DATA_SINGLE_MULTI) == $check_count and $check_condition){
	\$layoutv3_condition = true;
}
XXX;
		eval($check_eval);
	}	
} else {
	$layoutv3_condition = false;
}
