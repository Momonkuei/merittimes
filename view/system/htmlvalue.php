<?php

/*
 * 2019-12-06
 */

if(
	isset($_params_) and !empty($_params_)
	and isset($_params_['htmlvalue_1']) and $_params_['htmlvalue_1'] != '' // topic, name, pic1, file1...
){
	echo '{/'.$_params_['htmlvalue_1'].'/}';
}
?>
