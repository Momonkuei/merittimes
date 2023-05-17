<?php

/*
 * 2019-12-06
 */

if(
	isset($_params_) and !empty($_params_)
	and isset($_params_['htmltags_1']) and $_params_['htmltags_1'] != '' // a, h1, div, ul, p...
){
	$result = '<'.$_params_['htmltags_1'].' ';
	$tmpg = $_params_;
	foreach($tmpg as $k => $v){
		if(preg_match('/^htmltags_/', $k)){
			unset($tmpg[$k]);
		}
	}
	if(!empty($tmpg)){
		$tmpg2 = array();
		foreach($tmpg as $k => $v){
			$tmpg2[] = ' '.$k.'="'.str_replace('：',':',$v).'" ';
		}
		$result .= implode(' ', $tmpg2);
	}
	echo $result.'>';
?>
<?php echo $__?>
<?php

	echo '</'.$_params_['htmltags_1'].'>';
}
?>
