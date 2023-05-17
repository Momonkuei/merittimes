<?php

$ID = layoutv3_next_data_id($layoutv3_struct, $ID);

// 重設預設值
$DATA_SINGLE = false;
$DATA_MULTI = false;
// $DATA_SINGLE_MULTI_{ID} = array();

// var_dump($layoutv3_data_single_multi);
// die;

if(isset($layoutv3_data_single_multi[$ID])){
	if(isset($layoutv3_data_single_multi[$ID]['DATA_SINGLE'])){
		$DATA_SINGLE = $layoutv3_data_single_multi[$ID]['DATA_SINGLE'];
	}
	if(isset($layoutv3_data_single_multi[$ID]['DATA_MULTI'])){
		$DATA_MULTI = $layoutv3_data_single_multi[$ID]['DATA_MULTI'];
	}
}

if(isset($layoutv3_data_single_multi_detail[$ID])){
	$run = '$DATA_SINGLE_MULTI = '.var_export($layoutv3_data_single_multi_detail[$ID], true).';';
	eval($run);
}
