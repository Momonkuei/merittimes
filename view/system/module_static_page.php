<?php

/*
 * 這是編排頁在用的
 */

// echo $_SERVER['REQUEST_URI']; // /company_tw_1.php?id=ggg

$tmp = $_SERVER['REQUEST_URI'];
$tmp2 = explode('?',$tmp);
$tmp = str_replace(LAYOUTV3_PARENT_PATH,'',$tmp2[0]);//2019/3/25 因應網站放在子資料夾所處理 by lota

$tmp = str_replace('.php','',$tmp);
$tmps = explode('_',$tmp);
$tmps2 = $tmps; // 想要換個檔名
$tmps2[0] = '/html'; // view/XXX/html_tw_1.php

// 2020-01-20
$file_parent_path = _BASEPATH.'/../view/'.LAYOUTV3_PARENT_PATH.LAYOUTV3_THEME_NAME.$tmps[0].implode('_',$tmps2).'.php';

// 2018-12-10 讓規則更明確(如果要用舊版的，請註解我，因為沒有向下相容)
unset($tmps2[1]);

// $file = _BASEPATH.'/../view'.$tmps[0].implode('_',$tmps2).'.php';
$file = _BASEPATH.'/../view/'.LAYOUTV3_THEME_NAME.$tmps[0].implode('_',$tmps2).'.php';

// 2018-10-02 為了支援seo其它語系的編排頁
// if(!file_exists($file) and $url_prefix != ''){
// 	$file = _BASEPATH.'/../view/'.LAYOUTV3_THEME_NAME.str_replace($url_prefix,'/',$tmps[0]).implode('_',$tmps2).'.php';
// }


// 2018-11-05
// 舊版的使用
// $file2 = _BASEPATH.'/../view/'.$tmps[1].$tmps[0].implode('_',$tmps2).'.php';
// if(file_exists($file2)){
// 	$file = $file2;
// }

// 2018-10-29
// 新版的使用(v4)
$file2 = _BASEPATH.'/../view/'.$tmps[1].'/'.LAYOUTV3_THEME_NAME.$tmps[0].implode('_',$tmps2).'.php';
if(file_exists($file2)){
	$file = $file2;
}

// 2020-01-20
if(LAYOUTV3_PARENT_PATH != ''){
	if(file_exists($file_parent_path)){
		$file = $file_parent_path;
	}
}

if(file_exists($file)){
	// echo eval('?'.'>'.mb_convert_encoding(file_get_contents($file), 'HTML-ENTITIES', "UTF-8"));
	echo eval('?'.'>'.file_get_contents($file));
}
?>
