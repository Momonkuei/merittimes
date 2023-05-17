<?php

/*
 * 2020-01-09
 */

if(isset($_params_) and !empty($_params_) and isset($_params_['include_1']) and $_params_['include_1'] != ''){
	$phpend = '';
	if(isset($_params_['include_2']) and $_params_['include_2'] == '1'){
		$phpend = '?'.'>';
	}
	if(file_exists(_BASEPATH.'/../'.LAYOUTV3_PATH.$_params_['include_1'])){
		$ggaa = file_get_contents(_BASEPATH.'/../'.LAYOUTV3_PATH.$_params_['include_1']).$phpend;
		eval('?'.'>'.$ggaa);
	}
}
?>
