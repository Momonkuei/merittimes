<?php

//var_dump($error_logs);die;

// 第三驟，設立這裡的目的，就是除了render以外、和訂單完成後以外的，都是寫在這裡
if($ajax == 1){
	if(!empty($error_logs)){
		foreach($error_logs as $k => $v){
			if($v[2] < 3){
				echo 'window.location.href="checkout_'.$this->data['ml_key'].'.php?step='.$v[2].'";';
			}
		}
	}
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

// 如果有第二步驟的問題，那就要回到第二步驟(李哥建議)
if(!empty($error_logs)){
	foreach($error_logs as $k => $v){
		if($v[2] < 3){
			//echo 'window.location.href="checkout_'.$this->data['ml_key'].'.php?step=1";';
			header('location: checkout_'.$this->data['ml_key'].'.php?step=2');
		}
	}
}

// 因為有些物流是會幫忙收錢的
if(isset($_SESSION['save']['selecxt_physical']['func'])){
	// ecpay_711_cash_on_delivery
	if(
		preg_match('/^ecpay_(711|fami)_cash_on_delivery/', $_SESSION['save']['selecxt_physical']['func'])
		or $_SESSION['save']['selecxt_physical']['func'] == 'cash_on_delivery'
	){
		$payment = array(); // 清空它！避免任何金流的干擾
		$payment['has_postpay'] = true;
		$payment['func'] = '';
		$payment['name'] = $shipment['name'];
		$payment['payment_notice'] = false;
		$_SESSION['save']['step3']['go_to_finish!!'] = '1';
	}
}

// 付款方式的特例
if(isset($_SESSION['save']['selecxt_payment']['func'])){
	if($_SESSION['save']['selecxt_payment']['func'] == 'cash_on_delivery'){
		$_SESSION['save']['step3']['go_to_finish!!'] = '1';
	} elseif($_SESSION['save']['selecxt_payment']['func'] == 'atm'){
		$_SESSION['save']['step3']['go_to_finish!!'] = '1';
	}
}

// 有沒有付款的檢查
if(isset($payment) and !empty($payment)){
	if($payment['has_postpay'] === true){ // 這個是純ATM在用的
		$payment['has_check_finish'] = true;
	}
}

// 這裡的程式欄位，記得，不要跟資料庫的欄位名稱相沖
$order = array(
	'payment_func' =>false, // by lota 不加在第三步會報錯 #以皇冠為例
	'order_status' =>0, //by lota 不加在第三步會報錯  #以皇冠為例
	'status' => false,
	'payment_status' => false, // 只有線上刷卡才能更改這裡的狀態，記到…！
);

if(isset($_SESSION['save']['selecxt_payment']['func'])){
	if($_SESSION['save']['selecxt_payment']['func'] == 'atm'){
		if(!empty($this->data['atm_config'])){
			foreach($this->data['atm_config'] as $k => $v){
				if($k == 'atm_expire_day' and $v > 0){ // 李哥說這個不需要
					$order['atm_expiredate'] = date('Y-m-d',strtotime('+'.$v.' day'));
				}
				$order[$k] = $v;
			}
		}
	}
}

/*
 * 金流註解
 */

/*
 * 這裡會寫入訂單
 */
if(isset($_SESSION['save']['step3']['go_to_finish!!']) and $_SESSION['save']['step3']['go_to_finish!!'] == '1'){
	$order['status'] = true;

	// Vencen 提供的範例
	// $gOrderStatus = Array("未付款", "已付款", "已出貨", "已通知付款", "付款失敗", "取消訂單");  //訂單狀態

	/*
	 * 我打算規劃的訂單狀態
	 * 0 未付款
	 * 1 己付款
	 * 2 己出貨
	 *
	 * 所有錯誤類的都從11開始
	 * 11 己通知付款
	 * 12 付款失敗
	 * 
	 * 99 取消訂單
	 */
	

	if(!isset($_SESSION['save']['step3']['order_created_id']) or $_SESSION['save']['step3']['order_created_id'] == ''){ 

		// 先假設失敗
		$_SESSION['save']['step3']['order_created_id'] = -1;

		// 基本欄位
		$save = array(
			'sum' => $total_sub, // 合計
			'shipment' => $shipping_total, // 運費
			'total' => $total, // 總計
			'payment_func' => $payment['func'],
			'order_status' => 0,
			'detail' => $invoice['detail'],
			//  'log_1' => var_export($log_1, true),
			//  'log_2' => var_export($log_2, true),
			//  'car' => var_export($car, true), // 可能只會用在後台訂單內頁的列表、和資料匯出
			//  'calculate' => var_export($calculate_logs, true),
			//  'search_raw' => var_export($search_raw, true),
			'is_enable' => 1,
			'create_time' => date('Y-m-d H:i:s'),
			'ml_key' => $this->data['ml_key'],
		);

		//這是給美安訂單用的訂單總金額變數(不含運費)
		$_SESSION['save']['step3']['MarketAn_total_sub'] = $total_sub;

		// 第三步驟，這一行，一定要放在log_result之前
		include 'source/shop/log_save_include.php';

		// 資料切割後，欄位的數量在前面己經檢查過沒有問題了，所以這裡可以放心的寫入
		foreach($log_result as $k => $v){
			$save['log_'.($k+1)] = $v;
		}

		if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0){
			$save['customer_id'] = $this->data['admin_id'];
		}

		// 發票
		$invoice_save = $invoice; // 因為等一下render還要用，所以這裡完全不要去覆寫它
		unset($invoice_save['captcha']);
		foreach($invoice_save as $k => $v){
			$save[$k] = $v;
		}

		// 購買人
		$member_save = $member; // 因為等一下render還要用，所以這裡完全不要去覆寫它
		$member_save['addr'] = $member_save['addr_county'].$member_save['addr_district'].$member_save['addr'];
		foreach($member_save as $k => $v){
			if(preg_match('/(pass|birthday|county|district|zip|need_dm|accept_privacy|company)/', $k)) continue; // 非會員
			if(preg_match('/(is_enable|time|email|fax|id|salt)/', $k)) continue; // 會員
			if(preg_match('/(other|is_send)/', $k)) continue; // unknow
			$save['buyer_'.$k] = $v;
		}

		// 收件人
		$recipient_save = $recipient; // 因為等一下render還要用，所以這裡完全不要去覆寫它
		$recipient_save['recipient_addr'] = $recipient_save['recipient_addr_merge'];
		unset($recipient_save['recipient_addr_merge']);
		foreach($recipient_save as $k => $v){
			if(preg_match('/(county|district|zipcode|merge|select_recipient)/', $k)) continue; // 非會員 //2017/7/6 移除add的關鍵字 by lota
			if(preg_match('/(recipient_address_add)/', $k)) continue;
			$save[$k] = $v;
		}

		// 看一下當月有幾筆了
		// 這個部分，放在寫入前的最後一個步驟
		// 2017-02-09 李哥說的訂單編號規則
		$rows = $this->db->createCommand()->select('id')->from($prefix.'orderform')->where('create_time like "%'.date('Y-m-d').'%"')->queryAll();
		$save['order_number'] = substr(date('Ymd'), 2, 6).str_pad((count($rows)+1), 6, '0', STR_PAD_LEFT);

		//美安訂單 檢查欄位寫入 2020-09-17
		if( isset($this->data['MarketAn']) && $this->data['MarketAn']['is_enable'] == 1 ){
			if( isset($_SESSION["RID"]) && isset($_SESSION["Click_ID"]) ){
				$save['RID'] = $_SESSION["RID"];
				$save['Click_ID'] = $_SESSION["Click_ID"];					
			}
		}

		//這邊會多出func的欄位，要移除 by lota
		if(isset($save['func'])){
			unset($save['func']);
		}

		// ServerZoo_4 為了這台主機而修正的問題
		// 2021-01-21 已經有修正save.php那隻程式
		foreach($save as $k => $v){
			if(preg_match('/(PHPSESSID|KCFINDER|_ga|_gid)/', $k)){
				unset($save[$k]);
			}
		}

		// 2020-06-11 513發現的問題 2020-12-16 加入 recipient_gender 2021-01-04 改變判斷模式 by lota 2021/03/02 加入 buyer_mobile
		foreach(array('buyer_phone','buyer_mobile','buyer_gender','recipient_mobile','recipient_gender') as $v){
			//if(!isset($save[$v]) && is_null($save[$v]) ){
			if(@is_null($save[$v]) ){ // 2021-05-11 千千萬萬不要在寫isset進來了，保證壞，原因不明，有緣人留 //2021-10-13 用is_null 有時候會出現Notice錯誤訊息... 先隱藏起來 by lota
				unset($save[$v]);
			}
		}

		//2021-06-21 lota fix  這兩個是會員簡訊驗證用 要移除 
		foreach(array('buyer_is_sms','buyer_sms_text') as $v){
			if(isset($save[$v])){
				unset($save[$v]);
			}
		}
		
		//file_put_contents('123.txt', var_export($save,true),FILE_APPEND);
		
		// 2020-06-10 李哥說不要用這種寫法，所以後來就改用orm
		// $this->cidb->insert($prefix.'orderform', $save); 
		// $order_id = $this->cidb->insert_id();
		// if(!$order_id or $order_id <= 0){
		// 	unset($_SESSION['save']['step3']['order_created_id']);
		// 	unset($_SESSION['save']['step3']['go_to_finish!!']);
		// 	//G::alert_captcha(t('欄位資料驗證失敗'), $redirect_url, $this->data);
		// 	$redirect_url = 'checkout_'.$this->data['ml_key'].'.php?step=2';
		// 	G::alert_and_redirect(t('訂單寫入失敗'), $redirect_url, $this->data); // current sample
		// }

		// 2020-06-10 改用orm寫法
		$empty_orm_data = array(
			'table' => $prefix.'orderform',
			//'created_field' => 'create_time', 
			//'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				//array('name, email', 'required'),
			),
		);

		$orm = new gorm($this->cidb, $empty_orm_data);
		$orm->data($save);
		$status = $orm->validate(); // 回傳true或false

		if($status === false){
			// var_dump($orm->message());
			unset($_SESSION['save']['step3']['order_created_id']);
			unset($_SESSION['save']['step3']['go_to_finish!!']);
		 	$redirect_url = 'checkout_'.$this->data['ml_key'].'.php?step=2';
			G::alert_and_redirect(t('訂單欄位資料驗證失敗'), $redirect_url, $this->data); // current sample
		}

		$status = $orm->insert(); // 回傳寫入狀態
		$order_id = $this->cidb->insert_id(); //寫入資料後，下面程式會判斷第三方串接程式是否成功去改變$order_id數值

		if($status === false){
			unset($_SESSION['save']['step3']['order_created_id']);
			unset($_SESSION['save']['step3']['go_to_finish!!']);
		 	$redirect_url = 'checkout_'.$this->data['ml_key'].'.php?step=1';
			G::alert_and_redirect(t('訂單寫入失敗'), $redirect_url, $this->data); // current sample
		}

		// 可以考慮把金流放到這裡來處理
		if(isset($_SESSION['save']['selecxt_payment']['func'])){
			// 失敗的話，刪除訂單，並且取消選取的付款方式和取消finish，然後回到第二步
			// 成功的話，修改訂單為付款成功、order[payment_status]要改成true，還有新增order_created_id的session變數，最後也是回到第三步
			// https://www.ecpay.com.tw/Content/files/ecpay_011.pdf
			if(preg_match('/^ecpay_(credit_card|cvs|barcode|webatm|vatm)$/', $_SESSION['save']['selecxt_payment']['func'], $matches)){

				$func_sub = $matches[1];

				require('ecpay/ECPay.Payment.Integration.php'); // 放在母體
				$aaa = new ECPay_AllInOne();
				$aaa->ServiceURL = $Config['Allpay']['URL'];
				$aaa->HashKey = $Config['AllPay']['HashKey'];
				$aaa->HashIV = $Config['AllPay']['HashIV'];
				$aaa->MerchantID = $Config['AllPay']['MerchantID'];

				//基本參數
				//$aaa->Send['ClientBackURL'] = FRONTEND_DOMAIN.'/checkout.php?step=3'; // 下面會設定
				$aaa->Send['MerchantTradeNo'] = $save['order_number'];
				$aaa->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');
				$aaa->Send['TotalAmount'] = (int)$total;
				$aaa->Send['TradeDesc'] =  t('您於本站本次的交易名細');

				array_push($aaa->Send['Items'], array('Name' => t("網路購物商品"), 'Price' => (int)$total, 'Currency' => "元", 'Quantity' =>"1", 'URL' => ""));

				if($func_sub == 'credit_card'){ // 信用卡
					$aaa->Send['ChoosePayment'] = ECPay_PaymentMethod::Credit;
				} elseif($func_sub == 'cvs'){ // 超商代碼
					$aaa->Send['ChoosePayment'] = ECPay_PaymentMethod::CVS;
				} elseif($func_sub == 'barcode'){ // 超商條碼
					$aaa->Send['ChoosePayment'] = ECPay_PaymentMethod::BARCODE;
				} elseif($func_sub == 'webatm'){ // WebATM (插卡) 測試環境下僅有台新銀行提供測試，使用時須注意是否安裝讀卡機，並使用IE瀏覽器
					$aaa->Send['ChoosePayment'] = ECPay_PaymentMethod::WebATM;
				} elseif($func_sub == 'vatm'){ // 虛擬ATM (要自己去匯款)
					$aaa->Send['ChoosePayment'] = ECPay_PaymentMethod::ATM;
				}

				// 基本參數
				if($is_site_production === true){
					if(preg_match('/^(cvs|barcode|webatm|vatm|unionpay)$/', $func_sub)){
						// CVS、ATM、Barcode、銀聯卡，不支援OrderResultUrl
						$aaa->Send['ClientBackURL'] = FRONTEND_DOMAIN.'/checkout_'.$this->data['ml_key'].'.php?step=3';
					} else {
						// 當消費者付款完成後，綠界會將付款結果參數以幕前(Client  POST)回傳到該網址。
						//$aaa->Send['OrderResultURL'] = FRONTEND_DOMAIN.'/checkout_'.$this->data['ml_key'].'.php?step=3';
						$aaa->Send['OrderResultURL'] = FRONTEND_DOMAIN.'/reply.php';
					}

					// 幕後
					$id_number = substr(md5(rand(1, 1000000)),0,15);
					$save = array(
						'id_number' => $id_number,
						'session_id' => session_id(),
						'func' => $_SESSION['save']['selecxt_payment']['func'],
						'url1' => 'xxx',
						'url2' => FRONTEND_DOMAIN.'/reply.php',
						//'back' => 'checkout.php?step=2',
						'is_enable' => '1',
						'create_time' => date('Y-m-d H:i:s'),
					);

					if(preg_match('/^(cvs|barcode|webatm|vatm)$/', $func_sub)) $save['func'] .= '_server_reply';

					$this->cidb->insert('short', $save); 
					$id = $this->cidb->insert_id();
					$aaa->Send['ReturnURL'] = FRONTEND_DOMAIN . '/short.php?id='.$id_number;
				} else {
					$aaa->Send['ClientBackURL'] = FRONTEND_DOMAIN.'/checkout_'.$this->data['ml_key'].'.php?step=3';

					$public_key = EIP_APIV1_PUBLICKEY;
					$private_key = EIP_APIV1_PRIVATEKEY;
					$server_ip = EIP_APIV1_DOMAIN;
					$url = 'index.php?r=api/short';

					$params = array(
						'url' => 'xxx',
						'url2' => FRONTEND_DOMAIN.'/reply.php',
						'func' => $_SESSION['save']['selecxt_payment']['func'],
						'_____session_id' => session_id(), // 因為會跟EIPAPI的衝到
						//'back' => 'checkout.php?step=2', // 子站的reply處理完後，要去的地方
					);

					if(preg_match('/^(cvs|barcode|webatm|vatm)$/', $func_sub)) $params['func'] .= '_server_reply';

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

					// 會回傳以下的元素
					// url
					// id_number
					// $row = $return;
					//var_dump($return);die;
					if(isset($return) and !empty($return)){
						$aaa->Send['ReturnURL'] = EIP_APIV1_DOMAIN . '/short.php?id='.$return['id_number'];
					}
				}

				// 額外的參數作用
				// CVS : 取碼
				// Barcode : 取碼
				// (web|v)ATM : 取得虛擬帳號
				if(preg_match('/^(cvs|barcode|webatm|vatm)$/', $func_sub)){
					if($is_site_production === true){
						$id_number = substr(md5(rand(1, 1000000)),0,15);
						$save = array(
							'id_number' => $id_number,
							'session_id' => session_id(),
							'func' => $_SESSION['save']['selecxt_payment']['func'],
							//'url' => 'xxx', // 2021-02-08 這裡有很大的問題，不知道為什麼，加上這個元素，會導致第二次的寫入會失敗
							'url2' => FRONTEND_DOMAIN.'/reply.php',
							//'back' => 'checkout.php?step=2',
							'is_enable' => '1',
							'create_time' => date('Y-m-d H:i:s'),
						);
						$this->cidb->insert('short', $save); 
						$id = $this->cidb->insert_id();
						$aaa->SendExtend['PaymentInfoURL'] = FRONTEND_DOMAIN . '/short.php?id='.$id_number;
					} else {
						$public_key = EIP_APIV1_PUBLICKEY;
						$private_key = EIP_APIV1_PRIVATEKEY;
						$server_ip = EIP_APIV1_DOMAIN;
						$url = 'index.php?r=api/short';

						$params = array(
							'url' => 'xxx',
							'url2' => FRONTEND_DOMAIN.'/reply.php',
							'func' => $_SESSION['save']['selecxt_payment']['func'],
							'_____session_id' => session_id(), // 因為會跟EIPAPI的衝到
							//'back' => 'checkout.php?step=2', // 子站的reply處理完後，要去的地方
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

						// 會回傳以下的元素
						// url
						// id_number
						// $row = $return;
						//var_dump($return);die;
						if(isset($return) and !empty($return)){
							$aaa->SendExtend['PaymentInfoURL'] = EIP_APIV1_DOMAIN . '/short.php?id='.$return['id_number'];
						}
					}
				}

				if(preg_match('/^(webatm|vatm)$/', $func_sub)){
					// $aaa->SendExtend['ExpireDate'] = 3; // 若需設定最長60天，最短1天。未設定此參數則預設為3天
				}

				$aaa->CheckOut();
				die;
			}

			//Payapl 付款 for 定揚購物
			if(preg_match('/^paypal$/', $_SESSION['save']['selecxt_payment']['func'], $matches)){
				include 'checkout_include_paypal.php';
				die;
			}

			//華南銀行 付款 for 香山財神廟
			if(preg_match('/^hncb$/', $_SESSION['save']['selecxt_payment']['func'], $matches)){
				include 'checkout_include_hncb.php';
				die;
			}

			//玉山銀行 付款 for 艾可眼鏡
			if(preg_match('/^esun_credit_card$/', $_SESSION['save']['selecxt_payment']['func'], $matches)){
				include 'checkout_include_esun_credit_card.php';
				die;
			}

			//中國信託銀行 付款 for 裕軒
			if(preg_match('/^ctb$/', $_SESSION['save']['selecxt_payment']['func'], $matches)){
				include 'checkout_include_ctb.php';
				die;
			}
		} // 金流 selecxt_payment

	} elseif(isset($_SESSION['save']['step3']['order_created_id']) and $_SESSION['save']['step3']['order_created_id'] < 0){
		// 2020-05-22 這裡是網路異常，完全沒回傳的狀態
		unset($_SESSION['save']['step3']['order_created_id']);
		unset($_SESSION['save']['step3']['go_to_finish!!']);
		header('location: checkout_'.$this->data['ml_key'].'.php?step=2');
	} else {
		$order_id = $_SESSION['save']['step3']['order_created_id'];
	} // order_created_id

	// 重建order變數，最後，跟剛建好的那筆訂單的資料合併
	// 我是說底下這個啦：
	// $order = array(
	//	   status => false
	//	   payment_status => false // 只有線上刷卡才能更改這裡的狀態，記到…！
	// )
	$row = $this->db->createCommand()->from($prefix.'orderform')->where('id=:id',array(':id'=>$order_id))->queryRow();
	if($row and !empty($row)){
		foreach($row as $k => $v){
			$order[$k] = $v; // 記得，原有的order元素，不要跟db的欄位相沖
		}
	}

	if(isset($_SESSION['save']['step3']['order_created_id']) and $_SESSION['save']['step3']['order_created_id'] != ''){
		// 金流付款成功的話，金流返回的時候，要讓消費者看到付款成功的字眼
		if($order['order_status'] == 1){
			$order['payment_status'] = true;
		}
	}

	// 扣庫存
	//判斷是否需要扣除庫存 by lota
	unset($_constant_1);
	eval('$_constant_1 = '.strtoupper('shop_show_electronic_invoice').';');
	if($_constant_1==true){
		if($car and !empty($car)){
			foreach($car as $k => $v){
				$row = $this->cidb->where('data_id',$v['item']['id'])->where('id',$v['specid'])->where('is_enable',1)->get($prefix.'spec')->row_array();
				$update = array(
					'inventory' => $row['inventory'] - $v['amount'],
				);
				$this->cidb->where('data_id', $v['item']['id']);
				$this->cidb->where('id', $v['specid']);
				$this->cidb->where('is_enable', 1);
				$this->cidb->update($prefix.'spec', $update); 
			}
		}
	}
	

	// 處理優惠卷
	// 上面都檢查完了
	// 本來這裡是放在finish的開頭
	if(isset($_SESSION['save']['goodies_number']['gift_serial_number']) and $_SESSION['save']['goodies_number']['gift_serial_number'] != ''){
		$row = $this->db->createCommand()->from($prefix.'goodies')->where('pid!=0 and func=1 and is_enable=1 and gift_serial_number=:number',array(':number'=>$_SESSION['save']['goodies_number']['gift_serial_number']))->queryRow();
		$update = $row;
		$update['update_time'] = date('Y-m-d H:i:s');

		unset($update['id']);
		unset($update['create_time']);

		$update['gift_only_use_count2']++;

		if($update['gift_only_use_count2'] >= $update['gift_only_use_count']){
			$update['is_enable'] = 0;
		}

		$this->cidb->where('id', $row['id']);
		$this->cidb->update($prefix.'goodies', $update); 
		//要同步更新給後台的記錄 by lota
		$this->cidb->where('id', $row['pid']);
		unset($update['pid']);
		$this->cidb->update($prefix.'goodies', $update); 
	} // 處理優惠卷

	// 處理紅利
	// if(
	// 	isset($this->data['admin_id']) and $this->data['admin_id'] > 0
	// 	and isset($_SESSION['save']['use_bonus']['use']) 
	// 	and $_SESSION['save']['use_bonus']['use'] == '1' 
	// 	and $bonus_can_use > 0
	// ){

	// 	// 扣掉所使用的紅利
	// 	$update = array(
	// 		'bonus_left' => $bonus_list[0]['bonus_point'],
	// 		'is_enable' => 0,
	// 	);
	// 	$this->cidb->where('id', $bonus_list[0]['id']);
	// 	$this->cidb->update($prefix.'goodies', $update); 

	// 	// 寫入紅利記錄
	// 	$save = array(
	// 		'member_id' => $v['id'],
	// 		'name' => $save['name'],
	// 		'order_number' => $order['order_number'],
	// 		'point' => $save['bonus_point'],
	// 		'start_date' => $save['start_date'],
	// 		'end_date' => $save['end_date'],
	// 		'create_time' => date('Y-m-d H:i:s'),
	// 	);
	// 	$this->cidb->insert($prefix.'goodies_log', $save); 
	// 	//$id = $this->cidb->insert_id();

	// } // 處理紅利

	/*
	 * 寫入訂單後，如果非會員的話，馬上加入會員
	 */
	if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0){

		// 如果是會員的話...就不需要做什麼事…吧

	} else {

		// ！！這裡可以參考register，寫入後，在select出來
		$save = $member;

		unset($save['login_password_confirm']);
		//unset($save['addr_zipcode']); // 有這個欄位，不用刪掉
		unset($save['captcha']);

		$save['email'] = $save['login_account'];
		$save['is_enable'] = 1;
		$save['create_time'] = date('Y-m-d H:i:s');

		$save['salt'] = G::GeraHash(10);
		$save['login_password'] = '{GGG3AAA}'.str_replace('a','ɢ', sha1(G::utf8_strrev($save['login_password'].$save['salt'])));

		// ServerZoo_4 為了這台主機而修正的問題
		// 2021-01-21 已經有修正save.php那隻程式
		foreach($save as $k => $v){
			if(preg_match('/(PHPSESSID|KCFINDER|_ga|birthday_)/', $k)){
				unset($save[$k]);
			}
		}

		// $this->cidb->insert('customer', $save); 
		// $member_id = $this->cidb->insert_id();

		// 2020-06-10 改用orm寫法
		$empty_orm_data = array(
			'table' => 'customer',
			//'created_field' => 'create_time', 
			//'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				//array('name, email', 'required'),
			),
		);

		$orm = new gorm($this->cidb, $empty_orm_data);
		$orm->data($save);
		$status = $orm->validate(); // 回傳true或false

		if($status === false){
			// var_dump($orm->message());
			unset($_SESSION['save']['step3']['order_created_id']);
			unset($_SESSION['save']['step3']['go_to_finish!!']);

			// 2020-06-10
			// 訂單標註為刪除，因為步驟要倒退(李哥建議)
			$this->cidb->where('id', $order_id);
			$this->cidb->update($prefix.'orderform', array('is_enable'=>0)); 

		 	$redirect_url = 'checkout_'.$this->data['ml_key'].'.php?step=1';
			G::alert_and_redirect(t('會員欄位資料驗證失敗'), $redirect_url, $this->data); // current sample
		}

		$status = $orm->insert(); // 回傳寫入狀態
		$member_id = $this->cidb->insert_id();

		if($status === false){
			unset($_SESSION['save']['step3']['order_created_id']);
			unset($_SESSION['save']['step3']['go_to_finish!!']);

			// 2020-06-10
			// 訂單標註為刪除，因為步驟要倒退(李哥建議)
			$this->cidb->where('id', $order_id);
			$this->cidb->update($prefix.'orderform', array('is_enable'=>0)); 

		 	$redirect_url = 'checkout_'.$this->data['ml_key'].'.php?step=1';
			G::alert_and_redirect(t('會員寫入失敗'), $redirect_url, $this->data); // current sample
		}

		// 2020-06-11
		// Rigo發現的，為了避免用到別人已經刪除的資料的問題
		$this->cidb->delete('html', array('type'=>'favorite','member_id'=>$member_id)); 
		$this->cidb->delete('customer_address', array('customer_id'=>$member_id)); 
		// echo $this->cidb->affected_rows();

		$row = $this->db->createCommand()->from('customer')->where('is_enable=1 and id=:id',array(':id'=>$member_id))->queryRow();

		// 從母版的登入那邊複製過來的
		Yii::app()->session->add('authw_admin_id', $row['id']);  
		Yii::app()->session->add('authw_admin_account', $row['login_account']);  
		Yii::app()->session->add('authw_admin_name', $row['name']);  

		// 從母體複製過來的
		//$all_session = Yii::app()->session;
		$all_session = $_SESSION;
		foreach($all_session as $k => $v){
			if(preg_match('/^authw_(.*)$/', $k, $matches)){
				$this->data[$matches[1]] = $v;
			}
		}

		// 把剛才的訂單，加註會員編號
		$this->cidb->where('id', $order_id);
		$this->cidb->update($prefix.'orderform', array('customer_id'=>$row['id'])); 

		/*
		 * 檢查我的收藏
		 */
		if(isset($_SESSION['save'][$prefix.'_favorite']) and !empty($_SESSION['save'][$prefix.'_favorite'])) {
			foreach($_SESSION['save'][$prefix.'_favorite'] as $k => $v){
				// 先看有沒有(此時不管時間)
				$row2 = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and member_id=:member_id and other1=":id"',array(':id'=>$k,':member_id'=>$row['id'],':type'=>'favorite',':ml_key'=>$this->data['ml_key']))->queryRow();
				if($row2 and isset($row2['id'])){
					$update = array(
						'start_date' => $v['add_date'],
					);
					$this->cidb->where('id', $row2['id']);
					$this->cidb->update('html', $update); 
				} else {
					$id_tmp = explode('_', $k);
					$save = array(
						'type' => 'favorite',
						'ml_key' => $this->data['ml_key'],
						'is_enable' => 1,
						'start_date' => $v['add_date'],
						'other1' => $id_tmp[0],
						'other2' => $id_tmp[1],
						'member_id' => $row['id'],
					);
					$this->cidb->insert('html', $save); 
				}
			}
			unset($_SESSION['save'][$prefix.'_favorite']);
		}

		$savedata = $row;
		// 寄件人、網站管理者Mail
		$to = $this->data['sys_configs']['service_admin_mail'];

		// 主旨
		$subject2 = t('加入會員成功通知函'); // 預設值
		$subject = $this->data['sys_configs']['admin_title'].' '.$subject2;

		$aaa_url = aaa_url;
		$aaa_name = $this->data['sys_configs']['admin_title'];
		$no_reply = t('此信為系統發出，請勿回覆');

		$body = '';
		$body .= $no_reply."\n\n";

		$form_fields = array(
			array(
				'name' => t('註冊日期'),
				'value' => date('Y-m-d'),
				'style' => '',
			),
			array(
				'name' => t('使用者名稱'),
				'value' => $savedata['login_account'],
				'style' => '',
			),
			array(
				'name' => t('會員姓名'),
				'value' => $savedata['name'],
				'style' => '',
			),
			array(
				'name' => 'E-Mail',
				'value' => $savedata['login_account'],
				'style' => '',
			),
		);

		$embeddedimages = array();
		$embeddedimages[] = array(
			//'path' => _BASEPATH.'/../images/sendmail_title.png',
			'path' => _BASEPATH.'/../images/logo_banner.jpg',
			'cid' => 'logo',
		);
		
		ob_start();
		include _BASEPATH.'/../view/mail_template/member_success.php';
		$body_html = ob_get_clean();

		// 找一下寄件人有沒有設定
		$from = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_home=1',array(':type'=>'email',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryRow();

		// 找一下收件人有沒有設定
		$tos = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_news=1',array(':type'=>'email',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();

		//設定cc收件者
		if(defined('CC_MAIL_OPEN') && CC_MAIL_OPEN==true){
			$cc_mail = $savedata['email'];
		} else {
			$cc_mail = NULL;
		}

		// 2019-04-23 #31761 李哥說，需要做的
		$email_return = array();

		// 寄給管理者
		// 有需要在打開
		// if($from and !empty($from) and isset($from['id']) and isset($from['email'])
		// 	and $tos and !empty($tos) and isset($tos[0]['id'])
		// ){
		// 	if(isset($this->data['sys_configs']['smtp_ssl']) and $this->data['sys_configs']['smtp_ssl'] == 'sendmail'){
		// 		$email_return = $this->email_send_to_by_sendmail($from, $tos, $subject, $body, $body_html, $cc_mail, $embeddedimages);
		// 	} else {
		// 		$email_return = $this->email_send_to_v2($from,$tos, $subject, $body, $body_html,$cc_mail);
		// 	}
		// } else {	
		// 	//$this->email_send_to($to, $subject, $body, $body_html,$cc_mail);//如果後台沒設定就不寄信
		// }

		// 寄給註冊者
		$tos = array(
			array(
				'id' => '',
				'name' => $savedata['name'],
				'email' => $savedata['login_account'],
			),
		);

		if($from and !empty($from) and isset($from['id']) and isset($from['email'])
			and $tos and !empty($tos) and isset($tos[0]['id'])
		){
			if(isset($this->data['sys_configs']['smtp_ssl']) and $this->data['sys_configs']['smtp_ssl'] == 'sendmail'){
				$email_return = $this->email_send_to_by_sendmail($from, $tos, $subject, $body, $body_html, $cc_mail, $embeddedimages);
			} else {
				$email_return = $this->email_send_to_v2($from,$tos, $subject, $body, $body_html,$cc_mail);
			}
		} else {	
			//$this->email_send_to($to, $subject, $body, $body_html,$cc_mail);//如果後台沒設定就不寄信
		}

	} // 如果非會員…就登入會員

	// 寫入地址簿，這裡就一定是會員了哦
	if(
		(
		isset($_SESSION['save']['member_form_2']['recipient_address_add']) 
		and $_SESSION['save']['member_form_2']['recipient_address_add'] == '1'
		) 
			or 
		(
			$member_address === false
		)
	){
		$save = array(
			'customer_id' => $this->data['admin_id'],
			'is_enable' => 1,
		);

		foreach(array('name','gender','phone','mobile','addr','addr_county','addr_district') as $v){
			$save[$v] = $_SESSION['save']['member_form_2']['recipient_'.$v];			
		}
		$save['create_time'] = date('Y-m-d H:i:s');//2021-06-15 lota fix

		$this->cidb->insert('customer_address', $save); 
	}

} // 寫入訂單

//var_dump($_SESSION);die;

// render前的準備
$data2[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/checkout/step3'][0]]['multi'] = array(
	$payments,
);

$data2[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/checkout/step3'][0]]['single'] = array(
	$shipment,
	$payment, // 所選取的那筆金流
	$order, // 訂單相關狀態
);

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

if(isset($_SESSION['save']['step3']['go_to_finish!!']) and $_SESSION['save']['step3']['go_to_finish!!'] == '1'){

	/*
	 * 寄信通知 - for 管理者	by lota
	 *
	 * admin_new_order_notice
	 */

	if(1){
		// 信件格式
		$emailformat = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and other1=:topic',array(':topic'=>'後台新訂單通知',':type'=>'emailformat',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryRow();

		// 主旨
		$subject = $this->data['sys_configs']['admin_title'].t(' 新進訂單通知');

		if($emailformat and isset($emailformat['id']) and $emailformat['topic'] != ''){
			$email_topic = $emailformat['topic'];
			$email_topic = str_replace('{AA}', $this->data['sys_configs']['admin_title'], $email_topic);
			// 記得最後要加上這一行，把多餘的額外欄位刪掉
			for($x=65;$x<=(65+26);$x++) $email_topic = str_replace('{'.chr($x).'}', '', $email_topic);
			$subject = $email_topic;

			$aaa_url = aaa_url;
			$aaa_name = $member['name']; //購買者姓名
			$aaa_admin_title = $this->data['sys_configs']['admin_title'];

			//信件內容(TXT版)，由後台撈取
			if($emailformat and isset($emailformat['id']) and $emailformat['detail'] != ''){
				$email_content = $emailformat['detail'];

				$email_content = str_replace('{AA}', $this->data['sys_configs']['admin_title'], $email_content);
				$email_content = str_replace('{BB}', $aaa_name, $email_content);
				$email_content = str_replace('{CC}', $aaa_url, $email_content);		

				// 記得最後要加上這一行，把多餘的額外欄位刪掉
				for($x=65;$x<=(65+26);$x++) $email_content = str_replace('{'.chr($x).'}', '', $email_content);

				$body = $email_content;
			}

			//信件內容(HTML版)，由後台撈取
			if($emailformat and isset($emailformat['id'])){
				if($emailformat['field_tmp'] != ''){
					$email_html_content = $emailformat['field_tmp'];

					$email_html_content = str_replace('{AA}', $this->data['sys_configs']['admin_title'], $email_html_content);
					$email_html_content = str_replace('{BB}', $aaa_name, $email_html_content);
					$email_html_content = str_replace('{CC}', $aaa_url, $email_html_content);		

					// 記得最後要加上這一行，把多餘的額外欄位刪掉
					for($x=65;$x<=(65+26);$x++) $email_html_content = str_replace('{'.chr($x).'}', '', $email_html_content);

					$body_html = $email_html_content;
				} elseif($emailformat['field_tmp'] == '' and $emailformat['detail'] != ''){
					$body_html = nl2br($email_content);
				}
			}
		} else {
			$embeddedimages = array();
			$embeddedimages[] = array(
				'path' => _BASEPATH.'/../images/sendmail_title.png',
				'cid' => 'logo',
			);

			$body_type = '1'; // body
			$mail_type = '1'; // admin
			
			ob_start();
			include _BASEPATH.'/../view/mail_template/new_order_notice.php';
			$body = ob_get_contents();
			ob_end_clean();

			$body_type = '2'; // body_html
			$mail_type = '1'; // admin
			
			ob_start();
			include _BASEPATH.'/../view/mail_template/new_order_notice.php';
			$body_html = ob_get_contents();
			ob_end_clean();
		} // emailformat
	}

	// #41008
	if(0){
		// 主旨
		$subject = $body = $this->data['sys_configs']['admin_title'].t(' 新進訂單通知');

		$ggaa = $this->cidb->where('id',$order_id)->get('shoporderform')->row_array();

		//#43439
		$save['order_number'] = $ggaa['order_number'];

		if($ggaa['log_1']!=''){
			eval($ggaa['log_1']);
		}

		ob_start();
?>
<div style="padding:0px 300px 0px;color:#b3b3b3;">訂單明細</div><br>
訂單編號：<?php echo $save['order_number']?><br>
訂單日期：<?php echo $ggaa['create_time']?><br>
付款方式：<?php echo $log['payment']['name']?><br>
收件者：<?php echo $log['recipient']['recipient_name']?><br>
收件者行動：<?php echo $log['recipient']['recipient_phone']?><br>
收件地址：<?php echo $log['recipient']['recipient_addr_merge']?><br>
備註：<?php echo $log['invoice']['detail']?><br>
<table width="800px" border="0">
	<tr>
		<td style="font-weight:bold;">商品名稱</td>
		<td style="font-weight:bold;">商品規格</td>
		<td style="font-weight:bold;">價格</td>
		<td style="font-weight:bold;">小計</td>
	</tr>
	<?php if(isset($log['car']) and !empty($log['car'])):?>
		<?php foreach($log['car'] as $k => $v):?>
			<tr bgcolor="#f2f2f2" >
				<td>
					<?php echo $v['item']['name']?>
				</td>
				<td>
					<?php echo $v['spec']?><br><br>
					數量<?php echo $v['amount']?>
				</td>
				<td>價格<?php echo $v['item']['price2_format_ds']?></td>
				<td>$<?php echo $v['item']['price2'] * $v['amount']?></td>
			</tr>
		<?php endforeach?>
	<?php endif?>
</table>
<br>
<?php if(isset($log['calculate_logs']) and !empty($log['calculate_logs'])):?>
	<?php $_count = count($log['calculate_logs'])?>
	<?php foreach($log['calculate_logs'] as $k => $v):?>
		<?php if($k == ($_count - 1)):?>
			<HR color="#b3b3b3" size="1" width="100px" align="left">
		<?php endif?>
		<?php echo $v[0]?>	<?php echo $v[1]?><br />
	<?php endforeach?>
<?php endif?>
<br>
<?php
		$body_html = ob_get_contents();
		ob_end_clean();
	}

	// 找一下寄件人有沒有設定
	$from = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_home=1',array(':type'=>'email',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryRow();

	// 找一下收件人有沒有設定
	$tos = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_news=1',array(':type'=>'email',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();

	if($from and !empty($from) and isset($from['id']) and isset($from['email']) and $tos and !empty($tos) and isset($tos[0]['id'])){ //後台信箱有設定才會寄信

		if(isset($this->data['sys_configs']['smtp_ssl']) and $this->data['sys_configs']['smtp_ssl'] == 'sendmail'){
			$this->email_send_to_by_sendmail($from,$tos, $subject, $body, $body_html,null);
		} else {
			$this->email_send_to_v2($from,$tos, $subject, $body, $body_html,null);
		}
	}

	/*
	 * 寄信通知 - for 消費者 by lota
	 *
	 * user_new_order_notice
	 */

	$to = (isset($_SESSION['authw_admin_account']) && $_SESSION['authw_admin_account']!='')?$_SESSION['authw_admin_account']:$member['login_account'];//購買者信箱

	// 信件格式
	$emailformat = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and other1=:topic',array(':topic'=>'新進訂單通知',':type'=>'emailformat',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryRow();

	// 主旨
	$subject = $this->data['sys_configs']['admin_title'].t(' 新進訂單通知');

	if($emailformat and isset($emailformat['id']) and $emailformat['topic'] != ''){
		$email_topic = $emailformat['topic'];
		$email_topic = str_replace('{AA}', $this->data['sys_configs']['admin_title'], $email_topic);
		// 記得最後要加上這一行，把多餘的額外欄位刪掉
		for($x=65;$x<=(65+26);$x++) $email_topic = str_replace('{'.chr($x).'}', '', $email_topic);
		$subject = $email_topic;

		$aaa_url = aaa_url;
		$aaa_name = $member['name']; //購買者姓名
		$aaa_admin_title = $this->data['sys_configs']['admin_title'];

		//信件內容(TXT版)，由後台撈取
		if($emailformat and isset($emailformat['id']) and $emailformat['detail'] != ''){
			$email_content = $emailformat['detail'];

			$email_content = str_replace('{AA}', $this->data['sys_configs']['admin_title'], $email_content);
			$email_content = str_replace('{BB}', $aaa_name, $email_content);
			$email_content = str_replace('{CC}', $aaa_url, $email_content);		

			// 記得最後要加上這一行，把多餘的額外欄位刪掉
			for($x=65;$x<=(65+26);$x++) $email_content = str_replace('{'.chr($x).'}', '', $email_content);

			$body = $email_content;
		}

		//信件內容(HTML版)，由後台撈取
		if($emailformat and isset($emailformat['id'])){
			if($emailformat['field_tmp'] != ''){
				$email_html_content = $emailformat['field_tmp'];

				$email_html_content = str_replace('{AA}', $this->data['sys_configs']['admin_title'], $email_html_content);
				$email_html_content = str_replace('{BB}', $aaa_name, $email_html_content);
				$email_html_content = str_replace('{CC}', $aaa_url, $email_html_content);		

				// 記得最後要加上這一行，把多餘的額外欄位刪掉
				for($x=65;$x<=(65+26);$x++) $email_html_content = str_replace('{'.chr($x).'}', '', $email_html_content);

				$body_html = $email_html_content;
			} elseif($emailformat['field_tmp'] == '' and $emailformat['detail'] != ''){
				$body_html = nl2br($email_content);
			}
		}
	} else {
		$embeddedimages = array();
		$embeddedimages[] = array(
			'path' => _BASEPATH.'/../images/sendmail_title.png',
			'cid' => 'logo',
		);

		$body_type = '1'; // body
		$mail_type = '2'; // user
		
		ob_start();
		include _BASEPATH.'/../view/mail_template/new_order_notice.php';
		$body = ob_get_clean();

		$body_type = '2'; // body_html
		$mail_type = '2'; // user
		
		ob_start();
		include _BASEPATH.'/../view/mail_template/new_order_notice.php';
		$body_html = ob_get_clean();
	} // emailformat

	// 找一下寄件人有沒有設定
	$from = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_home=1',array(':type'=>'email',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryRow();

	// 找一下收件人有沒有設定
	//$tos = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_news=1',array(':type'=>'email',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();

	if($from and !empty($from) and isset($from['id']) and isset($from['email']) and $to !='' ){ //後台信箱有設定才會寄信

		if(isset($this->data['sys_configs']['smtp_ssl']) and $this->data['sys_configs']['smtp_ssl'] == 'sendmail'){
			$this->email_send_to_by_sendmail($from,array(array('name'=>'','email'=>$to)), $subject, $body, $body_html,null);
		} else {
			$this->email_send_to_v2($from,array(array('name'=>'','email'=>$to)), $subject, $body, $body_html,null);
		}
	}

} // go_to_finish

/*
 * 這裡會清除此次購物的相關資料，因為購物完成了
 * 這個動作，移至view/step3去做
 */
// if(isset($_SESSION['save']['step3']['go_to_finish!!']) and $_SESSION['save']['step3']['go_to_finish!!'] == '1'){
// 	unset($_SESSION['save']);
// 	unset($_SESSION[$this->data['router_method']]); // 這一行移到View裡面去做，不然會報錯
// }

