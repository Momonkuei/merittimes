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

$order = $this->db->createCommand()->from('shoporderform')->where('customer_id=:id and is_enable=1', array(':id' => $this->data['admin_id']))->order('create_time desc')->queryAll();
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
		eval($log_txt);

		$v['total'] = '$'.number_format($v['total']);
		$v['order_status_handle'] = $orderstatus_tmp[$v['order_status']];

		if(isset($log['session']['save']['selecxt_physical']['func']) and preg_match('/cash_on_delivery/', $log['session']['save']['selecxt_physical']['func'])){
			$v['payment_func'] = $log['shipment']['func'];
		}

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

		// Debug用的
		// if(!isset($v['payment_func_name'])){
		// 	$v['payment_func_name'] = 'ggg';
		// }

		$order[$k] = $v;
	}
}

//$data[$ID] = $order;

$data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/checkout/orderlist'][0]] = $order;
$data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/checkout/layout_member_orderdetail'][0]]['buyer_name'] = $this->data['admin_name'];
