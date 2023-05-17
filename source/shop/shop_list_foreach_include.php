<?php

$v['url'] = $url_prefix.'shopdetail'.$url_suffix.'?id='.$v['id'];
$v['pic'] = '_i/assets/upload/shop/'.$v['pic1'];

//從規格表拉出金額帶入 2021-04-26 by lota
if(!isset($v['price']) && !isset($v['price2'])){
    $v['price_int'] = 0;
    $v['price2_int'] = 0;
	$_rows = $this->cidb->where('is_enable',1)->where('data_id',$v['id'])->get('shopspec')->row_array();
	if(isset($_rows['id'])){
		$v['price'] = 'NT$'.number_format($_rows['price']);
		$v['price2'] = 'NT$'.number_format($_rows['price2']);
		$v['price_int'] = $_rows['price'];
		$v['price2_int'] = $_rows['price2'];
	}
}else{
	$v['price'] = 'NT$'.number_format($v['price']);
	$v['price2'] = 'NT$'.number_format($v['price2']);
	$v['price_int'] = $v['price'];
	$v['price2_int'] = $v['price2'];
}


// 檢查收藏
$v['has_favorite'] = 0;
if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0){
	$row = $this->db->createCommand()->from('html')->where('(start_date BETWEEN NOW() - INTERVAL 20 DAY AND NOW() ) and is_enable=1 and type=:type and ml_key=:ml_key and member_id=:member_id and other1=:id'/*other2是規格編號*/,array(':id'=>$v['id'],':member_id'=>$this->data['admin_id'],':type'=>'favorite',':ml_key'=>$this->data['ml_key']))->queryRow();
	if(isset($row['id']) and $row['id'] > 0){
		$v['has_favorite'] = 1;
	}
} else {
	if(isset($_SESSION['save']['shop_favorite']) and !empty($_SESSION['save']['shop_favorite'])){
		foreach($_SESSION['save']['shop_favorite'] as $kkg => $vvg){
			if(preg_match('/^'.$v['id'].'_(\d+)$/', $kkg)){
				$v['has_favorite'] = 1;
				break;
			}
		}
	}
}
