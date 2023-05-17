<?php

if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0){
	// do nothing
} else {
	if($_SESSION['save']['invoice_1']['captcha'] == '' or $_SESSION['save']['invoice_1']['captcha'] != Yii::app()->session['captcha']){
		$error_logs[] = array(
			'captcha_required',
			t('驗證碼沒有填，或是不符合'),
			2, // 第幾步驟
		);
		$step2_javascript_evals[] = '$("input[name=captcha]").addClass("error");RefreshImage(\'valImageId\');';
	}
	Yii::app()->session['captcha'] = '';
}

// 如果有第一步驟的問題，那就要回到第一步驟(李哥建議)
if(!empty($error_logs)){
	foreach($error_logs as $k => $v){
		if($v[2] == 1){
			//echo 'window.location.href="checkout_'.$this->data['ml_key'].'.php?step=1";';
			header('location: checkout_'.$this->data['ml_key'].'.php?step=1');
		}
	}
}

if($ajax == 2){
	if(!empty($error_logs)){
		if(defined('ENVIRONMENT') and ENVIRONMENT == 'development'){
			echo 'alert(\''.$error_logs[0][1].'\');';
			// echo 'alert(\''.$error_logs[0][1].' ('.$error_logs[0][0].')\');';
		} else {
			echo 'alert(\''.$error_logs[0][1].'\');';
		}

		//echo '$("input[name=login_account]").removeClass("error");';
		echo '$("input[name=login_account]").removeClass("error");';
		echo '$("input[name=login_password]").removeClass("error");';
		echo '$("input[name=login_password_confirm]").removeClass("error");';
		echo '$("input[name=name]").removeClass("error");';
		echo '$("select[name=addr_county]").removeClass("error");';
		echo '$("select[name=addr_district]").removeClass("error");';
		echo '$("input[name=addr]").removeClass("error");';
		echo '$("input[name=recipient_name]").removeClass("error");';
		echo '$("input[name=recipient_phone]").removeClass("error");';
		echo '$("select[name=recipient_addr_county]").removeClass("error");';
		echo '$("select[name=recipient_addr_district]").removeClass("error");';
		echo '$("input[name=recipient_addr]").removeClass("error");';
		echo '$("input[name=invoice_type]").parent().parent().removeClass("error");';
		echo '$("input[name=invoice_type_2_barcode]").removeClass("error");';
		echo '$("input[name=invoice_tax_id]").removeClass("error");';
		echo '$("input[name=invoice_name]").removeClass("error");';
		echo '$("input[name=captcha]").removeClass("error");';
		if(isset($step2_javascript_evals) and !empty($step2_javascript_evals)){
			foreach($step2_javascript_evals as $k => $v){
				echo $v;
			}
		}
	} else {
		// debug jerry ggggggaaaaa
		//die;
		echo 'window.location.href="checkout_'.$this->data['ml_key'].'.php?step=3";';
	}
	die;
}

include 'source/shop/log_save_include.php';

$data2[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/checkout/step2'][0]]['multi'] = array(
	$error_logs, // 錯誤訊息
	$payments, // 金流
	$physicals, // 物流
	$member_address, // 地址簿
);

$data2[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/checkout/step2'][0]]['single'] = array(
	$member, // 訂購人資料
	$shipment, // 運費與物流
	$recipient, // 收件人資料
	$invoice_config, // 發票設定
	$invoice, // 發票資訊和備註
);
