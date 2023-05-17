<?php

$pagew = 1; // Splitpage
if(isset($_GET['page']) and $_GET['page'] > 0){
	$pagew = $_GET['page'];
}
$limit_count = 12;//一頁顯示幾筆
$pageRecordInfo = array();

$where = array(
	'ml_key' => $this->data['ml_key'],
	'type' => $this->data['router_method'].'tmp1', // 這個router_method是有含detail的字眼，這是正常的別亂改
	'class_id' => $_GET['id'],
);
//$rows = $this->cidb->where($where)->order_by('sort_id','asc')->get('html')->result_array();
	//使用圖片名稱排序 by lota
$rows = $this->cidb->where($where)->order_by('pic1','asc')->get('html')->result_array();
$total_rows = count($rows);

// 2019-10-16 如果數量和實際不一樣，就洗掉資料表重寫
$path = _BASEPATH.'/assets/members/'.$router_method.'_1_'.$row['id'].'/member/';
$path2 = _BASEPATH.'/';
$tmp2 = array();//初始化
if(is_dir($path)){	
	$_tmp2 = glob($path.'*.*');
	if($_tmp2 and count($_tmp2) > 0){
		foreach ($_tmp2 as $k => $v) {
			$tmp2[$k] = str_replace($path2,'',$v);
		}
		sort($tmp2);//lota 加入排序
	}
}

$_count = count($tmp2);
if($total_rows != $_count){
	$this->cidb->where('type', $this->data['router_method'].'tmp1')->where('ml_key',$this->data['ml_key'])->where('class_id', $row['id'])->delete('html'); 
	if($_count > 0){
		foreach($tmp2 as $k => $v){
			$save = array(
				'ml_key' => $this->data['ml_key'],
				'type' => $this->data['router_method'].'tmp1',
				'class_id' => $row['id'],
				'pic1' => $v,
			);
			$this->cidb->insert('html', $save); 
		}
		$total_rows = $_count;
	}
}

$url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php?id='.$_GET['id'].'&page=';

include _BASEPATH.'/../source/core/pagination.php';

//$rows = $this->cidb->where($where)->order_by('sort_id','asc')->get('html', $limit_count, ($pagew-1) * $limit_count)->result_array();
//使用圖片名稱排序 by lota
$rows = $this->cidb->where($where)->order_by('pic1','asc')->get('html', $limit_count, ($pagew-1) * $limit_count)->result_array();

if($rows and count($rows) > 0){
	foreach($rows as $k => $v){
		if($v['update_time'] == '0000-00-00 00:00:00'){
			$v['update_time'] = '';
		} else {
			$v['update_time'] = date('Y/m/d', strtotime($v['update_time']));
		}

		// 列表圖
		$v['pic'] = cache3('_i/'.$v['pic1']);

		// 大圖
		$v['url'] = cache3('_i/'.$v['pic1']);

		// #21242 需要用就把它打開吧
		$tmp2 = explode('/', $v['pic1']);
		$tmp3 = $tmp2[count($tmp2)-1];
		$tmp4s = explode('.', $tmp3);
		$tmp5 = $tmp3; // 沒有副檔名，當做圖片名稱
		if($tmp4s and count($tmp4s) > 0){
			unset($tmp4s[count($tmp4s)-1]); // 只刪掉逗點最右邊，因為怕有1個以上的小數點
			$tmp5 = implode('.', $tmp4s);
		}
		$v['name'] = $tmp5;

		$rows[$k] = $v;
	}
}

?>
