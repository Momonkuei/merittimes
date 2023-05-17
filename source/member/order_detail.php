<?php
//if(!isset($this->data['admin_id']) or count($this->data['admin_id']) <= 0){
if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0){
} else {
	$redirect_url = 'guestlogin_'.$this->data['ml_key'].'.php';
	G::alert_and_redirect(t('請先登入！'), $redirect_url, $this->data);
	die;
}

// 訂單狀態
$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type', array(':type'=>'shoporderstatus'))->order('sort_id asc')->queryAll();
$orderstatus_tmp = array();
if($rows and !empty($rows)){
	foreach($rows as $k => $v){
		$orderstatus_tmp[$v['other1']] = $v['topic'];
	}
}

// 170215000001(12碼)
if(!isset($_GET['order_number']) or $_GET['order_number'] == ''){
	echo 'please define order_number field';
	die;
}

$order_number = substr($_GET['order_number'],0,12);

$updatecontent = $this->db->createCommand()->from('shoporderform')->where('order_number=:number and customer_id=:id',array(':number'=>$order_number,':id'=>$this->data['admin_id']))->queryRow();

// 從後台複製過來的
$log_txt = '';
for($x=1;$x<=20;$x++){
	if(isset($updatecontent['log_'.$x])){
		$log_txt .= $updatecontent['log_'.$x];
	}
}
eval($log_txt);

//$order = $updatecontent;

// 從source/shop/checkout.php那邊複製過來的
if(!empty($log)){

	foreach($log as $k => $v){
		$run = '$'.$k.'='.var_export($v,true).';';
		eval($run);
	}

	// 覆寫order變數
	foreach($updatecontent as $k => $v){
		if(!preg_match('/^log/',$k)){
			$order[$k] = $v;
		}
	}

	//2017/6/26 補上 by lota
	$order['order_status_handle'] = $orderstatus_tmp[$order['order_status']];


	// $data[$layoutv3_struct_map_keyname['v3/category_title'][0]] = array(
	// 	'name' => '',
	// 	'sub_name' => '訂單記錄',
	// );

	$data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/checkout/layout_member_orderdetail'][0]] = $order;

	$data2[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/checkout/orderdetail'][0]]['single'] = array(
		$shipment,
		$payment, // 所選取的那筆金流
		$order, // 訂單相關狀態

		// 從step2那邊copy來的
		$recipient, // 收件人資料
		$invoice_config, // 發票設定
		$invoice, // 發票資訊和備註
	);

	$data2[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/checkout/orderdetail'][0]]['multi'] = array(
		$car, // 購物車裡面的東西
		$calculate_logs, // 計算機
	);
}
