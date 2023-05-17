<?php

/*
 * 這是為了要展示指定的頁面的指定區塊
 */

$layouts = array();

if(
	isset($_GET['r2']) and $_GET['r2'] != '' and 
	isset($_GET['key2']) and $_GET['key2'] != ''
){
	$file = Yii::getPathOfAlias('application').'/controllers/layoutv2/'.'layout_'.str_replace('/', '-',$_GET['r2']).'.php';
	if(file_exists($file)){
		$file_tmp = str_replace('<'.'?'.'php $layouts', '$tmp', file_get_contents($file));
		eval($file_tmp);
		foreach($tmp as $k => $v){
			if($k == $_GET['key2']){
				$v['pid'] = 0;
				$layouts[$k] = $v;
				break;
			}
		}
	}
}

