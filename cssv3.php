<?php

/*
 * 記得這裡必需要搭配以下這個套件，來編譯scss
 * https://github.com/sensational/sassphp
 */

error_reporting(E_ALL);
ini_set("display_errors", 1);

// include 'layoutv3/yii/init.php';
include 'layoutv3/init.php';

// 切換版型
if(isset($_GET['t']) and $_GET['t'] != ''){
	$file = 'css/skin/theme.w'.$_GET['t'].'.scss';
	if(file_exists($file)){
		copy($file, 'css/skin/theme.scss');
	}
}

$public_key = EIP_APIV1_PUBLICKEY;
$private_key = EIP_APIV1_PRIVATEKEY;

$server_ip = EIP_APIV1_DOMAIN;
$url = 'index.php?r=api/scssphpv3';

$imports['config'] = file_get_contents('css/config.scss');
$tmps = explode("\n", $imports['config']);
foreach($tmps as $k => $v){
	// @charset "utf-8";
	if(preg_match('/^\@charset\ \"utf\-8\"\;$/', trim($v), $matches)){
		unset($tmps[$k]);
		break;
	}
}

$row = $this->db->createCommand()->from('scss_config')->where('is_enable=1')->queryRow();
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
//var_dump($imports['theme']);die;

@unlink('css/style.css');
@unlink('css/skin/theme.css');

$params = $imports;
$params['url'] = FRONTEND_DOMAIN;

// 這支是客戶端
// include 'eip_client.php';

/*
 * 這是file_get_contents的版本
 */
// $postdata = http_build_query(
// 	array(
// 		'get_client_code' => '',
// 	)
// );
// $opts = array('http' =>
// 	array(
// 		'method'  => 'POST',
// 		'header'  => 'Content-type: application/x-www-form-urlencoded',
// 		'content' => $postdata
// 	)
// );
// $context  = stream_context_create($opts);
// $code = file_get_contents($server_ip.'/apiv1/code.php', false, $context);

/*
 * 這是curl的版本
 */
$postdata = http_build_query(array('get_client_code_2'=>''));
$ch = curl_init();
$options = array(
	CURLOPT_URL => $server_ip.'/apiv1/code.php',
	CURLOPT_HEADER => 0,
	CURLOPT_VERBOSE => 0,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_USERAGENT => "Mozilla/4.0 (compatible;)",
	CURLOPT_POST => true,
	CURLOPT_POSTFIELDS => $postdata,
);
curl_setopt_array($ch, $options);
$code = curl_exec($ch); 
curl_close($ch);

//$code = stripslashes($code);
eval('?'.'>'.$code);

/*
 * 跑完就可以抓來寫了
 * 這是file_get_contents的版本
 */
// file_put_contents('css/style.css', file_get_contents(EIP_APIV1_DOMAIN.'/cssv3/web/'.str_replace('http://','',FRONTEND_DOMAIN).'/style.css'));
// file_put_contents('css/skin/theme.css', file_get_contents(EIP_APIV1_DOMAIN.'/cssv3/web/'.str_replace('http://','',FRONTEND_DOMAIN).'/theme.css'));

/*
 * 這是curl的版本
 */
$url = EIP_APIV1_DOMAIN.'/cssv3/web/'.str_replace('http://','',FRONTEND_DOMAIN).'/style.css';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$content = curl_exec($ch);
curl_close($ch);
file_put_contents('css/style.css', $content);

$url = EIP_APIV1_DOMAIN.'/cssv3/web/'.str_replace('http://','',FRONTEND_DOMAIN).'/theme.css';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$content = curl_exec($ch);
curl_close($ch);
file_put_contents('css/skin/theme.css', $content);

echo 'compile success <a href="index.php">HOME</a>';

die;
