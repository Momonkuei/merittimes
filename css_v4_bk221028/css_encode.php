<?php
// https://freexyz.cn/dev/f48669306a297ef66cec7f48921e37aa.html
// https://www.itread01.com/p/1090857.html
// 不過在轉換的時候需要注意忽略一些特殊字元和關鍵字,比如#@:;.{}-之類的,還有hover、before、after等關鍵字

header("Content-type: text/css");

$seconds_to_cache = 3600;
$ts = gmdate("D, d M Y H:i:s", time() + $seconds_to_cache) . " GMT";
header("Expires: $ts");
header("Pragma: cache");
header("Cache-Control: max-age=$seconds_to_cache");

// var_dump($_SERVER);

$aaa = $_SERVER['REQUEST_URI'];
$aaas = explode('/', $aaa);
$bbb = $aaas[count($aaas)-1];

// style.css
// echo $bbb;

$dest = $source = file_get_contents($bbb);

// $dest = str_replace('i','\0069',$dest); // 有點亂掉
// $dest = str_replace('body','\0062\006f\0064\0079',$dest);

// $handle = array(
// 	// 'import' => '\0069\006d\0070\006f\0072\0074', // 會亂
// 	'body' => '\0062\006f\0064\0079',
// 	'font-size' => '\0066\006f\006e\0074-\0073\0069\007a\0065',
// 	'line-height' => '\006c\0069\006e\0065-\0068\0065\0069\0067\0068\0074',
// 	'color' => '\0063\006f\006c\006f\0072',
// 	'background-color' => '\0062\0061\0063\006b\0067\0072\006f\0075\006e\0064-\0063\006f\006c\006f\0072',
// );
// foreach($handle as $k => $v){
// 	$dest = str_replace($k,$v,$dest);
// }

function unicode_encode($name){
	$name = iconv('UTF-8', 'UCS-2', $name);
	$len = strlen($name);
	$str = '';
	for ($i = 0; $i < $len - 1; $i = $i + 2){
		$c = $name[$i];
		$c2 = $name[$i + 1];
		if (ord($c) > 0){
			// 兩個位元組的文字
			//$str .= '\u' . base_convert(ord($c), 10, 16) . base_convert(ord($c2), 10, 16);
			$str .= '\00' . base_convert(ord($c), 10, 16);// . base_convert(ord($c2), 10, 16);
		}else{
			$str .= $c2;
		}
	}
	return $str;
}

$handle = array();

// $handle = array(
// 	'body','font-size','line-height','color','background-color',
// 	'-webkit-align-items','align-items',
// 	'-webkit-flex-wrap','-ms-flex-wrap','flex-wrap',
// 	'-webkit-justify-content','justify-content',
// 	'-webkit-box-pack','-ms-flex-pack',
// 	'-webkit-box-orient',
// 	'display','-ms-flex-wrap','-webkit-box-align','-ms-flex-align',
// 	'margin-right','margin-left',
// );


/*
 * 針對屬性的部份
 */

$sources = explode("\n",$source);
foreach($sources as $k => $v){
	if(preg_match('/(\@|http)/', $v)){
		continue;
	}
	if(preg_match('/(.*)\:(.*)/',$v,$matches)){
		if(preg_match('/\./', $matches[1])){
			continue;
		}
		$handle[] = trim($matches[1]);
	}
}
// var_dump($handle);die;

foreach($handle as $k => $v){
	$dest = str_replace($v.':',unicode_encode($v).':',$dest);
}

/*
 * 針對class的部份
 */

$handle = array(
	'col-auto',
	'col-sm-auto',
	'col-md-auto',
	'col-lg-auto',
	'col-xl-auto',

	'col-12',
	'col-11',
	'col-10',
	'col-9',
	'col-8',
	'col-7',
	'col-6',
	'col-5',
	'col-4',
	'col-3',
	'col-2',
	'col-1',
   	'col',
	'col-sm-12',
	'col-sm-11',
	'col-sm-10',
	'col-sm-9',
	'col-sm-8',
	'col-sm-7',
	'col-sm-6',
	'col-sm-5',
	'col-sm-4',
	'col-sm-3',
	'col-sm-2',
	'col-sm-1',
   	'col-sm',
	'col-md-12',
	'col-md-11',
	'col-md-10',
	'col-md-9',
	'col-md-8',
	'col-md-7',
	'col-md-6',
	'col-md-5',
	'col-md-4',
	'col-md-3',
	'col-md-2',
	'col-md-1',
   	'col-md',
	'col-lg-12',
	'col-lg-11',
	'col-lg-10',
	'col-lg-9',
	'col-lg-8',
	'col-lg-7',
	'col-lg-6',
	'col-lg-5',
	'col-lg-4',
	'col-lg-3',
	'col-lg-2',
	'col-lg-1',
   	'col-lg',
	'col-xl-12',
	'col-xl-11',
	'col-xl-10',
	'col-xl-9',
	'col-xl-8',
	'col-xl-7',
	'col-xl-6',
	'col-xl-5',
	'col-xl-4',
	'col-xl-3',
	'col-xl-2',
	'col-xl-1',
   	'col-xl',
);

foreach($handle as $k => $v){
	$dest = str_replace('.'.$v, '.'.unicode_encode($v), $dest);
}

echo str_replace("\n",'',$dest);
// echo $dest;
