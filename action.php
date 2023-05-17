<?php

/*
 * Action
 *
 * 結帳步驟二
 * 裡面的"選擇取貨門市"按鈕，按下去要做的動作
 * 1.準備好short
 * 2.建立好按鈕
 * 3.把按鈕放進表單裡面，並且用js送出
 * 4.就會看到選便利商店的介面
 * 5.選中商店後，就會透過幕前的方式，傳到reply那裡
 */

include 'layoutv3/init.php';

// 2018-04-16 非實體頁面，可能需要載入的項目
include 'layoutv3/libs.php'; // pre_render
include 'source/core_seo.php';

// var_dump($Config);
// var_dump($is_site_production);die;

// 2021-01-21
// 在使用$_REQUEST要很小心，因為每個伺服器的設定不一樣
//
// 開發環境以為的設定(不包含COOKIE)
// request_order:GP
// variables_order:GPCS
//
// 有些線上環境的設定(包含COOKIE)
// * 例如bigcloud_2 big2 經銷主機60.248.112.142
// request_order:(empty) *空白就會依照variables_order的設定
// variables_order:EGPCS
//
// variables_order的其它說明
// 設定 EGPCS（Environment，GET，POST，Cookie，Server）變量解析的順序。默認設定為「EGPCS」。
// 舉例說，將其設為「GP」，會導致 PHP 完全忽略環境變量，cookies 和 server 變量，並用 GET 方法的變量覆蓋 POST 方法的同名變量。
// 
// $row = $_REQUEST;

// 2021-01-21
// 手動撰寫GP規則(GET優先，覆寫POST)
$row = $_GET;
if(!empty($_POST)){
	foreach($_POST as $k => $v){
		$row[$k] = $v;
	}
}

if(!isset($row['func'])) die;

if(preg_match('/^ecpay_(711|fami)_no_payment_for_pickup$/', $row['func']) and isset($_SESSION['save']['selecxt_physical']['func'])){
	/* 
	 * 2021-01-27 
	 * 這個動作，會由short.php去處理(url1)
	 *
	 * <div style="text-align:center;">
	 *   <form id="ECPayForm" method="POST" action="https://logistics.ecpay.com.tw/Express/map" target="_self">
	 * 	<input type="hidden" name="MerchantID" value="2000132" />
	 * 	<input type="hidden" name="MerchantTradeNo" value="Ecpay18e65805bbdd3b4" />
	 * 	<input type="hidden" name="LogisticsSubType" value="UNIMART" />
	 * 	<input type="hidden" name="IsCollection" value="N" />
	 * 	<input type="hidden" name="ServerReplyURL" value="http://rwd_v3.web.buyersline.com.tw/checkout.php" />
	 * 	<input type="hidden" name="ExtraData" value="測試額外資訊" />
	 * 	<input type="hidden" name="Device" value="0" />
	 * 	<input type="hidden" name="LogisticsType" value="CVS" />
	 * 	<input type="submit" id="__paymentButton" value="選擇7-11取貨門市" />
	 *   </form>
	 * </div>
	 */

	if($is_site_production === true){
		$id_number = substr(md5(rand(1, 1000000)),0,15);
		$save = array(
			'id_number' => $id_number,
			'session_id' => session_id(),
			'func' => $row['func'],
			'url1' => FRONTEND_DOMAIN.'/reply.php',
			'back' => 'checkout_'.$this->data['ml_key'].'.php?step=2',
			'is_enable' => '1',
			'create_time' => date('Y-m-d H:i:s'),
		);
		$this->cidb->insert('short', $save); 
		$id = $this->cidb->insert_id();
		$return = array(
			'url' => FRONTEND_DOMAIN.'/short.php?id='.$id_number, // 這一個用不到
			'id_number' => $id_number,
		);
	} else {
		$public_key = EIP_APIV1_PUBLICKEY;
		$private_key = EIP_APIV1_PRIVATEKEY;
		$server_ip = EIP_APIV1_DOMAIN;
		$url = 'index.php?r=api/short';

		$params = array(
			'url' => FRONTEND_DOMAIN.'/reply.php',
			'func' => $row['func'],
			'_____session_id' => session_id(), // 因為會跟EIPAPI的衝到
			'back' => 'checkout_'.$this->data['ml_key'].'.php?step=2', // 子站的reply處理完後，要去的地方
		);

		// 這支是客戶端

		$postdata = http_build_query(
			array(
				'get_client_code' => '',
			)
		);
		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header'  => 'Content-type: application/x-www-form-urlencoded',
				'content' => $postdata
			)
		);
		$context  = stream_context_create($opts);
		$code = file_get_contents($server_ip.'/apiv1/code.php', false, $context);

		//$code = stripslashes($code);
		eval('?'.'>'.$code);

		// debug
		//var_dump($result);die;
	}

	if(isset($return) and !empty($return)){
		//var_dump($return);die;

		// 會回傳以下的元素
		// url
		// id_number
		// $row = $return;
		//var_dump($return);die;

		// https://www.ecpay.com.tw/CascadeFAQ/CascadeFAQ_Qa?nID=3003
		require('ecpay/integration.php');
		$AL2 = new ECPayLogistics();

		$send = array(
			'MerchantID' => $Config['AllPay']['MerchantID'],
			'MerchantTradeNo' => 'Ecpay' . $return['id_number'], // 記得限制位數最多20
			//'LogisticsSubType' => 'UNIMART',
			'IsCollection' => IsCollection::NO,
			'ServerReplyURL' => EIP_APIV1_DOMAIN . '/short.php?id='.$return['id_number'],
			'ExtraData' => '測試額外資訊',
			'Device' => Device::PC
		);

		if($is_site_production === true){
			$send['ServerReplyURL'] = $return['url'];
		}

		// if($row['func'] == 'ecpay_711_no_payment_for_pickup'){
		// 	$send['LogisticsSubType'] = 'UNIMART';
		// } elseif($row['func'] == 'ecpay_fami_no_payment_for_pickup'){
		// 	$send['LogisticsSubType'] = 'FAMI';
		// }

		// 2020-06-10 高紘
		// 2021-01-27 目前都是C2C，姓名有特定的規則，還有電話是必填。B2C沒有這個規則，但是要另外套和擴充，目前是不支援的
		if($row['func'] == 'ecpay_711_no_payment_for_pickup'){
			$send['LogisticsSubType'] = 'UNIMARTC2C';
		} elseif($row['func'] == 'ecpay_fami_no_payment_for_pickup'){
			$send['LogisticsSubType'] = 'FAMIC2C';
		}

		$AL2->Send = $send;

		// CvsMap(Button名稱, Form target)
		$button = $_SESSION['save']['selecxt_physical']['button'] = $AL2->CvsMap('選擇取貨門市');
		// var_dump($send);die;
		
		$szHtml =  '<!DOCTYPE html>';
		$szHtml .= '<html>';
		$szHtml .=     '<head>';
		$szHtml .=         '<meta charset="utf-8">';
		$szHtml .=     '</head>';
		$szHtml .=     '<body>';
		$szHtml .=         $button;
		$szHtml .=         '<script type="text/javascript">document.getElementById("ECPayForm").submit();</script>';
		$szHtml .=     '</body>';
		$szHtml .= '</html>';
		echo $szHtml ;
	}

	exit;

} // $row['func']

die;
