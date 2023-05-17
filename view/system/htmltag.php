<?php

/*
 * 2019-12-06
 */

if(
	isset($_params_) and !empty($_params_)
	and isset($_params_['htmltag_1']) and $_params_['htmltag_1'] != '' // br, img...
){
	$result = '<'.$_params_['htmltag_1'].' ';
	$tmpg = $_params_;
	foreach($tmpg as $k => $v){
		if(preg_match('/^htmltag_/', $k)){
			unset($tmpg[$k]);
		}
	}
	if(!empty($tmpg)){
		$tmpg2 = array();
		foreach($tmpg as $k => $v){
			//$tmpg2[] = ' '.$k.'="'.$v.'" ';
			$tmpg2[] = ' '.$k.'="'.str_replace('：',':',$v).'" ';
		}
		$result .= implode(' ', $tmpg2);
	}
	echo $result.' />';
}
?>
