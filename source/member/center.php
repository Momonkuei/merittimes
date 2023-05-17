<?php

// PHP7
if(!isset($this->data['admin_id'])){
	$this->data['admin_id'] = 0;
}

if($this->data['admin_id'] <= 0){
	$redirect_url = 'guestlogin_'.$this->data['ml_key'].'.php';
	G::alert_and_redirect(t('請先登入！'), $redirect_url, $this->data);
	die;
}

$row = $this->db->createCommand()->select('name,login_account,gender,need_dm,phone,email,birthday,other1,other2,other3,is_sms,addr,addr_county,addr_district,addr_zipcode')->from('customer')
->where('is_enable=1 and id=:id', array(':id' => $this->data['admin_id']))
->queryRow();
$member = $row;

// $admin_field_router_class = $this->data['router_method'];
$admin_field_router_class = 'customer';
$admin_field_section_id = 0;
include _BASEPATH.'/../source/system/admin_field_get.php';

unset($admin_def['empty_orm_data']['rules'][0]); // remove login_account

$validation = G::getJqueryValidation($admin_def['empty_orm_data']['rules']);

// 其它額外條件
// $validation['captcha']['required'] = true;

// 其它範本
// $validation['old_time_3']['selectcheck'] = true;
// $validation['old_time_4']['selectcheck'] = true;
// $validation['old_time_5']['selectcheck'] = true;
// $validation['old_time_1']['selectcheck'] = true;
// //$validation['old_time_2']['selectcheck'] = true; // #13507
// $validation['old_addr_1']['selectcheck'] = true;
// $validation['old_addr_1_2']['selectcheck'] = true;
// $validation['new_addr_1']['selectcheck'] = true;
// $validation['new_addr_1_2']['selectcheck'] = true;
// $validation['service[]']['roles'] = true;
// $validation['GGGAAA']['selects'] = true;

/* JQuery.validate
required：必填欄位
email：格式要符合E-Mail格式
url：格式要符合網址格式，如：https://www.minwt.com
number：數字格包含小數點
digits：數字為正整數
date：日期格式
dateISO：日期格式，格式必需為YYYY/MM/DD、YYYY-MM-DD、YYYYMMDD
equalTo：與某一欄位值相同

minValue：最小字元長度
maxValue：最大字元長度
rangeValue：字元長度區間長度

minLength：最小字元長度(漢字算一個字符)
maxLength：最大字元長度(漢字算一個字符)
rangeLength：字元長度區間長度(漢字算一個字符)
 */

$this->data['jqueryvalidation'] = json_encode($validation);
$this->data['updatecontent_jqueryvalidation'] = $validation;

// 訂單狀態
$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type', array(':type'=>'shoporderstatus'))->order('sort_id asc')->queryAll();
$orderstatus_tmp = array();
if($rows and count($rows) > 0){
	foreach($rows as $k => $v){
		$orderstatus_tmp[$v['other1']] = $v['topic'];
	}
}

$order = $this->db->createCommand()->from('shoporderform')->where('id > 0 and customer_id=:id and is_enable=1', array(':id' => $this->data['admin_id']))->order('create_time desc')->limit(3)->queryAll();
if($order and !empty($order)){
	foreach($order as $k => $v){
		$updatecontent = $v;
		$log = array();
		$log_txt = '';
		for($x=1;$x<=20;$x++){
			if(isset($updatecontent['log_'.$x])){
				$log_txt .= $updatecontent['log_'.$x];
			}
		}
		//echo $log_txt;die;
		eval($log_txt);

		$v['total'] = '$'.number_format($v['total']);

		// 如果是物流代收款項，那付款方式的型態就會被改成物流的名稱
		if(isset($log['session']['save']['selecxt_physical']['func']) and preg_match('/cash_on_delivery/', $log['session']['save']['selecxt_physical']['func'])){
			$v['payment_func'] = $log['shipment']['func'];
		}

		if(isset($this->data['payments_tmp2'][$v['payment_func']]['name'])){
			$v['payment_func_name'] = $this->data['payments_tmp2'][$v['payment_func']]['name'];
		}

		// 如果是物流代收款項，那付款方式就會被改成物流的名稱
		if(isset($log['session']['save']['selecxt_physical']['func']) and preg_match('/cash_on_delivery/', $log['session']['save']['selecxt_physical']['func'])){
			$v['payment_func_name'] = $log['shipment']['name'];
		}

		$v['order_status_handle'] = $orderstatus_tmp[$v['order_status']];

		$order[$k] = $v;
	}
}

$gift = $this->db->createCommand()->from('shopgoodies')->where('is_enable=1 and pid!=0 and func=1 and gift_only_use_count>0 and member_id=:id', array(':id' => $this->data['admin_id']))->order('create_time desc')->limit(3)->queryAll();
if($gift and !empty($gift)){
	foreach($gift as $k => $row){
		$check_use_count = true; // 能夠被使用的次數，通常都是一個序號只能用一次
		if($row['gift_only_use_count2'] >= $row['gift_only_use_count']){
			$check_use_count = false;
		}

		$time = strtotime($row['start_date'].' 00:00:00');
		$time2 = strtotime($row['end_date'].' 00:00:00');
		if($time < 0) $time = 0;
		if($time2 < 0) $time2 = 0;

		//  先檢查時間
		$check_gift_date = true;
		if($time > 0){
			$now = strtotime(date('Y-m-d H:i:s'));
			//echo date('Y-m-d H:i:s');
			//echo $now;
			if($now >= $time){
				// OK
			} else {
				$check_gift_date = false;
			}
			if($time2 > 0){
				if($now < $time2){
					// OK
				} else {
					$check_gift_date = false;
				}
			}
		}
		if($check_use_count === true and $check_gift_date === true){
		} else {
			unset($gift[$k]);
		}
	}
}

$member_address = $this->db->createCommand()->from('customer_address')->where('is_enable=1 and customer_id=:id', array(':id'=>$this->data['admin_id']))->order('create_time desc')->limit(3)->queryAll();

$rows = $this->db->createCommand()->from('shopgoodies_log')->where('id > 0 and member_id=:id', array(':id'=>$this->data['admin_id']))->order('create_time desc')->queryAll();
$bonus_info = array(
	'total' => 0,
	'use' => 0,
);
if($rows and !empty($rows)){
	foreach($rows as $k => $v){
		if($v['order_number'] != ''){ // 使用
			$bonus_info['use'] += $v['point'];
		} else { // 得到
			$bonus_info['total'] += $v['point'];
		}
	}
}

$bonus = $this->db->createCommand()->from('shopgoodies_log')->where('id > 0 and member_id=:id', array(':id'=>$this->data['admin_id']))->order('create_time desc')->limit(3)->queryAll();
if($bonus and !empty($bonus)){
	foreach($bonus as $k => $v){
		if($v['start_date'] == '0000-00-00 00:00:00'){
			$v['start_date_name'] = t('無使用期限');
		} else {
			$v['start_date_name'] = $v['start_date'];
		}

		if($v['end_date'] == '0000-00-00 00:00:00'){
			$v['end_date_name'] = t('無使用期限');
		} else {
			$v['end_date_name'] = $v['end_date'];
		}

		$bonus[$k] = $v;
	}
}

$data2[$ID]['single'] = array(
	$member,
	$bonus_info,
);

$data2[$ID]['multi'] = array(
	$order, // 訂單記錄(最近三筆)
	$bonus, // 紅利(最近三筆)
	$gift, // 優惠卷(不限制)
	$member_address, // 地址簿(三筆)
);

// if(isset($layoutv3_struct_map_keyname['v3/sub_page_title'][0])){
// 	$data[$layoutv3_struct_map_keyname['v3/sub_page_title'][0]] = array(
// 		'name' => '會員中心',
// 		'sub_name' => 'member center',
// 	);
// }
// 
// if(isset($layoutv3_struct_map_keyname['v3/breadcrumb'][0])){
// 	$data[$layoutv3_struct_map_keyname['v3/breadcrumb'][0]] = array(
// 		array('name' => 'HOME', 'url' => '/'),
// 		array('name' => '會員中心', 'url' => 'membercenter.php')
// 	);
// }
