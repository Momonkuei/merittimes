<?php
//這邊修改上線的伺服器yii路徑
//$on_line_yii_path = '/www/web/image3/public_html/';// 自架 Server3
$on_line_yii_path = '/var/zpanel/hostdata/zadmin/public_html/image3/';// 自架 Server2
//$on_line_yii_path = '/home2/image/';// 自架 Server1
//$on_line_yii_path = '/home/imagebuy/public_html/';// 遠振 image1

$base_path = $DIR.$yiipath_a;


//如果子站有framework，則直接使用
$yii = $base_path.'/framework/yii.php';

// 測試用
//if(file_exists('/home/gisanfu/hg/w/889/_i/yii2/yii.php')){
//	$yii = '/home/gisanfu/hg/w/889/_i/yii2/yii.php';
//}

// 測試用 V1.1.16
//if(file_exists('/home/gisanfu/hg/w/889/_i/framework_1116/yii.php')){
//	$yii = '/home/gisanfu/hg/w/889/_i/framework_1116/yii.php';
//}

//if(file_exists('/home/gisanfu/hg/killme/buyerline_889/_i/framework/yii.php')){
//	$yii = '/home/gisanfu/hg/killme/buyerline_889/_i/framework/yii.php';
//}

//if(file_exists('/home/gisanfu/hg/_i/framework/yii.php')){
//	$yii = '/home/gisanfu/hg/_i/framework/yii.php';
//}
// jerry linux
//if(file_exists('/home/gisanfu/hg/w/889/_i/framework/yii.php') && !file_exists($yii)){
//	$yii = '/home/gisanfu/hg/w/889/_i/framework/yii.php';
//}
// 200環境
if(file_exists('/var/www/html/889/_i/framework/yii.php') && !file_exists($yii)){
	$yii = '/var/www/html/889/_i/framework/yii.php';
}
//上線環境
// Server1
if(file_exists($on_line_yii_path.'_i/framework/yii.php') && !file_exists($yii)){
	$yii = $on_line_yii_path.'_i/framework/yii.php';
}