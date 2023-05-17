<?php

$rows[] = array(
	// #21242
	'name' => $row['name'],
	'pic' => cache3($row['pic1'],'_i/assets/upload/'.$router_method.'/'),
);

//$path = 'webroot._i.assets.members.'.$router_method.'_1_'.$row['id'].'.member';
//$tmp2 = array();
//if(is_dir(Yii::getPathOfAlias($path))){
//	$tmp2 = $this->_getFiles(Yii::getPathOfAlias($path));
//	sort($tmp2);//lota 加入排序
//}
//使用 Yii涵式如果遇到客戶主機的資料有 . 的話會解析錯誤，改用PHP原生涵式去抓取 by lota 2019/5/23
// $path = dirname(dirname(dirname(__FILE__))).'/_i/assets/members/'.$router_method.'_1_'.$row['id'].'/member/';
$path = _BASEPATH.'/assets/members/'.$router_method.'_1_'.$row['id'].'/member/';
$tmp2 = array();//初始化
if(is_dir($path)){	
	$_tmp2 = glob($path.'*.*');
	if($_tmp2 and !empty($_tmp2)){
		foreach ($_tmp2 as $k => $v) {
			$tmp2[$k] = str_replace($path,'',$v);
		}
		sort($tmp2);//lota 加入排序
	}
}

// 多張圖
if($tmp2){
	foreach($tmp2 as $k => $v){
		$tmp2 = explode('/', $v);
		$tmp3 = $tmp2[count($tmp2)-1];
		$tmp4s = explode('.', $tmp3);
		$tmp5 = $tmp3; // 沒有副檔名，當做圖片名稱
		if($tmp4s and count($tmp4s) > 0){
			unset($tmp4s[count($tmp4s)-1]); // 只刪掉逗點最右邊，因為怕有1個以上的小數點
			$tmp5 = implode('.', $tmp4s);
		}
		// 為了要符合前台版型的規範
		$rows[] = array(
			'pic' => cache3('_i/assets/members/'.$router_method.'_1_'.$row['id'].'/member/'.$tmp3),
			// #21242
			'name' => $tmp5,
		);
	}
}

?>
