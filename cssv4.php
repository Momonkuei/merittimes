<?php

/*
 * 2017-12-01
 * 記得這裡必需要搭配以下這個套件，來編譯scss
 * http://leafo.github.io/scssphp/
 * http://www.yiiframework.com/extension/sass/
 *
 * 因為現在應該沒有PHP版本的問題，所以回過頭來測試之前所用的
 *
 * 2017-12-01 早上11點，winnie大略測過沒有問題
 *
 * 後續winnie有發現這兩個問題
 * https://github.com/leafo/scssphp/issues/544
 * https://github.com/leafo/scssphp/issues/548
 */

error_reporting(E_ALL);
ini_set("display_errors", 1);


// include 'layoutv3/init.php';

$run = '<p></p>'."\n";
/*
 * DOM第二版初始化
 */
@session_start();
$simplehtml = ''; // 假裝init
$old_struct = true;
$_SESSION['web_ml_key'] = 'tw'; // 注意！！！預設語系不是繁體中文的網站，要記得改這裡
define('FRONTEND_DOMAIN','');

// 純參考而以，千千萬萬不要打開
// $Db_Server = 'localhost';
// $Db_User = 'ordertrading_use';
// $Db_Pwd = '';
// $Db_Name = 'rwd_v3'; 

include 'standalone_simplehtmldom.php';
include 'layoutv3/dom4.php';

require '_i/scssphp-0.7.1/scss.inc.php';
use Leafo\ScssPhp\Compiler;

// 測試css編譯
// http://XXX.web.buyersline.com.tw/cssv4.php?test=css/test.scss&imports=bootstrap/,css/,css/skin/,css/skin/theme/
if(isset($_GET['test']) and $_GET['test'] != ''){

	$scss = new Compiler();
	if(isset($_GET['imports']) and $_GET['imports'] != ''){
		$scss->setImportPaths(explode(',',$_GET['imports']));
	}
	$result = $scss->compile(file_get_contents($_GET['test']));
	echo $result;
	die;
}

// 切換版型
if(isset($_GET['t']) and $_GET['t'] != ''){
	$file = 'css/skin/theme.w'.$_GET['t'].'.scss';
	if(file_exists($file)){
		copy($file, 'css/skin/theme.scss');
	}
}

$imports['config'] = file_get_contents('css/config.scss');
$tmps = explode("\n", $imports['config']);
foreach($tmps as $k => $v){
	// @charset "utf-8";
	if(preg_match('/^\@charset\ \"utf\-8\"\;$/', trim($v), $matches)){
		unset($tmps[$k]);
		break;
	}
}

$row = $cidb->where('is_enable',1)->get('scss_config')->row_array();
if($row and count($row) > 0){

	// 2016-10-07 下午，winnie所要增加的
	if(isset($row['googlefont_import']) and $row['googlefont_import'] != ''){
		foreach($tmps as $k => $v){
			// @import url(https://fonts.googleapis.com/css?family=Lato:400,300,100italic,300italic,100,400italic,700,700italic,900,900italic);
			if(preg_match('/^\@import(.*)fonts(.*)googleapis/', trim($v), $matches)){
				$tmps[$k] = $row['googlefont_import'];
				break;
			}
		}
	}

	unset($row['id']);
	unset($row['topic']);
	unset($row['googlefont_import']);
	unset($row['is_enable']);
	unset($row['create_time']);
	unset($row['update_time']);
	foreach($row as $k => $v){
		//if($k == 'grid-gutter-width') continue;
		if($k == 'googlefont'){
			// $googlefont:"Lato";  //非必填
			$tmps[] = '$'.$k.':"'.str_replace('"','',$v).'";'."\n";
		//} else {
		//} elseif($k == 'pageTitleDecoContent'){
		} elseif(preg_match('/^(pageTitleDecoContent|pageTitleDecoPath)$/', $k)){ // 加上雙引號
			$tmps[] = '$'.$k.':"'.$v.'";'."\n";
		} elseif($v != ''){
			$tmps[] = '$'.$k.':'.$v.';'."\n";
		}
	}
}

$imports['config'] = implode("\n", $tmps);
//var_dump($imports['config']);die;

$imports['style'] = file_get_contents('css/style.scss');
$tmps = explode("\n", $imports['style']);
foreach($tmps as $k => $v){
	// 參考@import "bootstrap";
	if(preg_match('/^\@import\ \"(.*)\"\;/', trim($v), $matches) and isset($imports[$matches[1]])){
		$tmps[$k] = $imports[$matches[1]];
	}

	// dry hack
	// content: "/\\00a0";  要改成=> content: "/ ";
	// content: "/\\\\00a0";
	if(preg_match('/content:\ "\/\\\\\\\\00a0/', $v)){
		$tmps[$k] = 'content: "/ ";';
	}
}

$imports['style'] = implode("\r\n", $tmps);

/*
 * 繼續theme的編譯
 */

$imports['theme'] = file_get_contents('css/skin/theme.scss');
$tmps = explode("\r\n", $imports['theme']);
foreach($tmps as $k => $v){
	// 參考@import "bootstrap";
	if(preg_match('/^\@import\ \"\.\.\/config/', trim($v))){
		$tmps[$k] = $imports['config'];
	}
}
$imports['theme'] = implode("\r\n", $tmps);

@unlink('css/style.css');
@unlink('css/skin/theme.css');

// require '_i/scssphp-0.7.1/scss.inc.php';
// use Leafo\ScssPhp\Compiler;

$scss = new Compiler();
$scss->setImportPaths(array('bootstrap/','css/'));
$result = $scss->compile($imports['style']);
file_put_contents('css/style.css',$result);

$scss = new Compiler();
// $scss->setLineNumberStyle(Compiler::LINE_COMMENTS);
$scss->setImportPaths(array('bootstrap/','css/','css/skin/','css/skin/theme/'));
$result = $scss->compile($imports['theme']);
file_put_contents('css/skin/theme.css',$result);

echo 'compile success <a href="index.php">HOME</a>';

die;
