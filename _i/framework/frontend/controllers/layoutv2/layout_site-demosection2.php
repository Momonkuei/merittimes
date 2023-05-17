<?php

/*
 * 這是為了要展示指定的區塊，這時頁面是不存在的
 *
 * 應該是適用非群組和layout以外的東西
 */

/*
 * 這個檔案不要去修改
 */

$other2 = '';
if(isset($_GET['other2'])){
	$other2 = $_GET['other2'];
}

$layouts = array (
  1 => 
  array (
    'tag' => 'div',
    'type' => $_GET['type'],
    'pid' => '0',
    'pos' => '1',
    'other' => '',
    'other2' => '',
  ),
);

//if(
//	isset($_GET['r2']) and $_GET['r2'] != '' and 
//	isset($_GET['key2']) and $_GET['key2'] != ''
//){
//	$file = Yii::getPathOfAlias('application').'/controllers/layoutv2/'.'layout_'.str_replace('/', '-',$_GET['r2']).'.php';
//	if(file_exists($file)){
//		$file_tmp = str_replace('<'.'?'.'php $layouts', '$tmp', file_get_contents($file));
//		eval($file_tmp);
//		foreach($tmp as $k => $v){
//			if($k == $_GET['key2']){
//				$v['pid'] = 0;
//				$layouts[$k] = $v;
//				break;
//			}
//		}
//	}
//}

