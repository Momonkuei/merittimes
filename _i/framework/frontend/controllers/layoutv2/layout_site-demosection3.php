<?php

/*
 * 顯示某一塊底下的所有東西
 */

/*
 * 這個檔案不要去修改
 */

$filename = str_replace('/', '-', $_GET['r2']);

if(file_exists(Yii::getPathOfAlias('application.controllers.layoutv2').'/layout_'.$filename.'.php')){
	$file2 = Yii::getPathOfAlias('application').'/controllers/layoutv2/layout_'.$filename.'.php';
} else {
	$file2 = Yii::getPathOfAlias('system.frontend.controllers.layoutv2').'/layout_'.$filename.'.php';
}

$tmp = file_get_contents($file2);
$tmp = str_replace('$layouts =','$tmp2 =', $tmp);
eval('?'.'>'.$tmp);

/*
 */
if($tmp2){
	// 先把pid=0的，都改成其它的編號
	foreach($tmp2 as $k => $v){
		if($v['pid'] == '0'){
			$v['pid'] = 'blackhold_0';
		}
		$tmp2[$k] = $v;
	}

	// 把match的編號，改成pid=0
	foreach($tmp2 as $k => $v){
		if($k == $_GET['key2']){
			$v['pid'] = '0';
			$tmp2[$k] = $v;
			break;
		}
	}
}

$layouts = $tmp2;

