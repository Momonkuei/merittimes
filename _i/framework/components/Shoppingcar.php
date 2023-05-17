<?php

/*
 * 商品的東西可能都放這裡
 * 最剛開始只是先弄麵包屑而以
 */
class Shoppingcar
{

	protected $_session_name = 'shop'; // 購物車
	protected $_session_name_attr = 'shop_attr'; // 其它的相關購物屬性
	protected $session = array();
	protected $data = '';

	// 基本運費
	protected $default_shipment = 200;
	// 滿多少免運費
	protected $free_shipment = 2000;

	protected $prefix = 'shop'; // Shop前綴的名稱，因為後台和前台設計可以換名稱

	function __construct()
	{
		$this->db = Yii::app()->db;
		$this->cidb = Yii::app()->params['cidb'];
		$this->session = Yii::app()->session;

		if(!isset($this->session[$this->_session_name])){
			$this->session[$this->_session_name] = array();
		}

		if(!isset($this->session[$this->_session_name_attr])){
			$this->session[$this->_session_name_attr] = array();
		}

		$_SESSION['Shoppingcar_msg'] = '';

		/*
		 * 想要在這裡寫一個處理Empty_orm的hack
		 */
		//$tmp = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/controllers/share/').'Empty_source_orm.php');
		$tmp = file_get_contents(Yii::getPathOfAlias('system').ds('/frontend/controllers/share/').'Empty_source_orm.php');
		$this->data['empty_orm'] = explode("\n", $tmp);
		$this->data['empty_orm_title'] = ' extends CActiveRecord';
		$this->data['empty_orm_count'] = 0;
		$this->data['empty_orm'][2] = 'class Empty_orm';
		unset($this->data['empty_orm'][0]);
		unset($this->data['empty_orm'][1]);

		// reindex array
		// http://stackoverflow.com/questions/5217721/how-to-remove-array-element-and-then-re-index-array
		$this->data['empty_orm'] = array_values($this->data['empty_orm']);

		// 使用新款Empty的原始方式
		// $this->data['empty_orm_count']++;
		// $eval_content = $this->data['empty_orm'];
		// $eval_content[0] .= (string)$this->data['empty_orm_count'].$this->data['empty_orm_title'];
		// eval(implode("\n", $eval_content));
		// $name = 'Empty_orm'.$this->data['empty_orm_count'];
		// $u = new $name('insert', $this->def['empty_orm_data']);

		$this->data['empty_orm_eval']  = ''; 
		$this->data['empty_orm_eval'] .= '$this->data[\'empty_orm_count\']++;'."\n";
		$this->data['empty_orm_eval'] .= '$eval_content = $this->data[\'empty_orm\'];'."\n";
		$this->data['empty_orm_eval'] .= '$eval_content[0] .= (string)$this->data[\'empty_orm_count\'].$this->data[\'empty_orm_title\'];'."\n";
		$this->data['empty_orm_eval'] .= 'eval(implode("\n", $eval_content));'."\n";
		$this->data['empty_orm_eval'] .= '$name = \'Empty_orm\'.$this->data[\'empty_orm_count\'];'."\n";

		$rows = $this->db->createCommand()->from('sys_config')->queryAll();
		$sys_configs = array();
		if(count($rows) > 0){
			foreach($rows as $k => $v){
				$sys_configs[$v['keyname']] = $v['keyval'];
			}
		}
		$this->data['sys_configs'] = $sys_configs;

		// 基本運費與滿多少免運費
		if(isset($this->data['sys_configs']['sys_config_shop_default_shipment']) and (int)$this->data['sys_configs']['sys_config_shop_default_shipment'] > 0){
			$this->default_shipment = $this->data['sys_configs']['sys_config_shop_default_shipment'];
		}

		if(isset($this->data['sys_configs']['sys_config_shop_free_shipment']) and (int)$this->data['sys_configs']['sys_config_shop_free_shipment'] > 0){
			$this->free_shipment = $this->data['sys_configs']['sys_config_shop_free_shipment'];
		}

	}

	public function d($field_name, $key)
	{
		//var_dump($_SESSION[$this->_session_name_attr]);
		//die;
		if(isset($_SESSION[$this->_session_name_attr][$key][$field_name])){
			return $_SESSION[$this->_session_name_attr][$key][$field_name];
		}
	}

	public function dradio($field_name,$value,$key,$first=false)
	{
		if(!isset($_SESSION[$this->_session_name_attr][$key][$field_name]) and $first){
			return 'checked';
		} else {
			if(isset($_SESSION[$this->_session_name_attr][$key][$field_name]) and $_SESSION[$this->_session_name_attr][$key][$field_name] == $value){
				return 'checked';
			}
		}
	}

	public function dselect($field_name,$value,$key,$first=false)
	{
		//if(!isset($this->data['listcontent']) and $first){
		//	return 'selected';
		//} else {
		//	if(isset($this->data['listcontent'][$field_name]) and $this->data['listcontent'][$field_name] == $value){
		//		return 'selected';
		//	}
		//}

		if(!isset($_SESSION[$this->_session_name_attr][$key][$field_name]) and $first){
			return 'selected';
		} else {
			if(isset($_SESSION[$this->_session_name_attr][$key][$field_name]) and $_SESSION[$this->_session_name_attr][$key][$field_name] == $value){
				return 'selected';
			}
		}
	}

	// 前台電子發票的欄位開或是關
	public function has_invoice_fields()
	{
		if(isset($_SESSION[$this->_session_name_attr]['paymenttype']['type']) and $_SESSION[$this->_session_name_attr]['paymenttype']['type'] != ''){
			$row = $this->db->createCommand()->from($this->prefix.'paymenttype')->where('is_enable=1 and func=:func',array(':func'=>$_SESSION[$this->_session_name_attr]['paymenttype']['type']))->queryRow();
			if($row and isset($row['id']) and isset($row['has_invoice']) and $row['has_invoice'] == 1){
				return true;
			}
		}
		return false;
	}

	//特殊字元置換
	public function allpay_replaceChar($value)
	{
		$search_list = array('%2d', '%5f', '%2e', '%21', '%2a', '%28', '%29');
		$replace_list = array('-', '_', '.', '!', '*', '(', ')');
		$value = str_replace($search_list, $replace_list ,$value);

		return $value;
	}
	//產生檢查碼
	public function allpay_getMacValue($hash_key, $hash_iv, $form_array)
	{
		$encode_str = "HashKey=" . $hash_key;
		foreach ($form_array as $key => $value)
		{
			$encode_str .= "&" . $key . "=" . $value;
		}
		$encode_str .= "&HashIV=" . $hash_iv;
		$encode_str = strtolower(urlencode($encode_str));
		$encode_str = $this->allpay_replaceChar($encode_str);

		return strtoupper(md5($encode_str));
	}

	// 金流在使用的回傳網址
	//
	/* 歐付寶的信用卡傳來的東西
array (
  'AlipayID' => '',
  'AlipayTradeNo' => '',
  'amount' => '100',
  'ATMAccBank' => '',
  'ATMAccNo' => '',
  'auth_code' => '777777',
  'card4no' => '2222',
  'card6no' => '431195',
  'eci' => '0',
  'ExecTimes' => '',
  'Frequency' => '',
  'gwsr' => '13468471',
  'MerchantID' => '2000132',
  'MerchantTradeNo' => 'test1445907800',
  'PayFrom' => '',
  'PaymentDate' => '2015/10/27 09:00:08',
  'PaymentNo' => '',
  'PaymentType' => 'Credit_CreditCard',
  'PaymentTypeChargeFee' => '5',
  'PeriodAmount' => '',
  'PeriodType' => '',
  'process_date' => '2015/10/27 09:00:08',
  'red_dan' => '0',
  'red_de_amt' => '0',
  'red_ok_amt' => '0',
  'red_yet' => '0',
  'RtnCode' => '1',
  'RtnMsg' => '交易成功',
  'SimulatePaid' => '0',
  'staed' => '0',
  'stage' => '0',
  'stast' => '0',
  'TenpayTradeNo' => '',
  'TotalSuccessAmount' => '',
  'TotalSuccessTimes' => '',
  'TradeAmt' => '100',
  'TradeDate' => '2015/10/27 08:59:23',
  'TradeNo' => '1510270859233755',
  'WebATMAccBank' => '',
  'WebATMAccNo' => '',
  'WebATMBankName' => '',
  'CheckMacValue' => '0B835D594269778DB34F0F786C75CEC8',
)
	 */
	public function return_url($func)
	{
		$check = '1'; // 要回傳1，不然它們3分鐘會丟一次
		$form_array = $_POST;

		$row = $this->db->createCommand()->from($this->prefix.'paymenttype')->where('is_enable=1 and func=:func',array(':func'=>$func))->queryRow();
		if($row and isset($row['id'])){
			$hash_key = $row['other_allpay_hash_key'];
			$hash_iv = $row['other_allpay_hash_iv'];
		} else {
			$check = '0';
			echo $check;
			die;
		}

		/*
		 * 檢查：訂單是否存在
		 */
		//MerchantTradeNo
		$row = $this->db->createCommand()->from($this->prefix.'orderform')->where('order_number=:order_number',array(':order_number'=>$form_array['CheckMacValue']))->queryRow();
		if($row and isset($row['id'])){
			$orderform_id = $row['id'];
		} else {
			$check = '0';
			echo $check;
			die;
		}

		/*
		 * 檢查：checkmacvalue
		 */

		$allpay_checkmacvalue = $form_array['CheckMacValue'];

		// http://ithelp.ithome.com.tw/question/10146436
		unset($form_array['CheckMacValue']);

		$tmp_array = array();
		foreach($form_array as $key => $value){
			$tmp_array[strtolower($key)] = $value;
		}
		$aa = $tmp_array;
		ksort($aa, SORT_STRING);

		$calc_checkmacvalue = $this->allpay_getMacValue($hash_key, $hash_iv, $aa);

		if($calc_checkmacvalue == $allpay_checkmacvalue){
			// do nothing
		} else {
			$check = '0';
			echo $check;
			die;
		}

		/*
		 * 檢查：付款是否成功
		 */
		if(isset($form_array['RtnCode']) and $form_array['RtnCode'] == '1'){
			// do nothing
		} else {
			$check = '0';
			echo $check;
			die;
		}

		if($check == '1'){
			$empty_orm_data_orderform = array(
				'table' => 'orderform',
				'created_field' => 'create_time', 
				//'updated_field' => 'update_time',
				'primary' => 'id',
				'rules' => array(
					//array('name, phone, email', 'required'),
				),
			);

			eval($this->data['empty_orm_eval']);
			$c = new $name('insert', $empty_orm_data_orderform);
			// 修改專用
			$u = $c::model()->findByPk($orderform_id);
			$u->setAttributes(array('order_status'=>'paymented'));
			// 失敗就失敗
			if(!$u->update()){
				$check = '0';
				echo $check;
				die;
			}
		} // $check

		// 這是最後一行
		echo $check;
		die;
	}

	/*
 	 * id	int(11)
	 * order_number 	varchar(30)
	 * customer_id 	int(11)
	 * from_login_account 	varchar(30)
	 * from_name 	varchar(30)
	 * to_name 	varchar(50)
	 * to_phone 	varchar(60)
	 * to_mobile 	varchar(60)
	 * to_addr 	varchar(200)
	 * to_email 	varchar(100)
	 * total 	int(11)
	 * payment_type 	varchar(30)
	 * order_status 	varchar(30)
	 * invoice_type 	tinyint(1)
	 * invoice_tax_id 	varchar(50)
	 * invoice_title 	varchar(100)
	 * invoice_addr 	varchar(200)
	 * atm_name 	varchar(100)
	 * atm_date 	date
	 * atm_blank 	varchar(40)
	 * atm_price 	varchar(30)
	 * atm_last 	varchar(20)
	 * detail 	text 	utf8_unicode_ci
	 * detail_admin 	text
	 * is_enable 	tinyint(1)
	 * create_time 	datetime
	 * update_time		datetime
	 */
	public function check_form_buyer()
	{
		$key = 'buyer';

		$check = true;

		// 先檢查是不是都有填
		$tmp = array(
			'帳號' => 'login_account',
			'密碼' => 'login_password',
			'密碼確認' => 'login_password_confirm',
			'姓名' => 'name',
			//'性別' => 'sex',
			'生日' => 'birthday',
			'聯絡電話' => 'phone',
			'地址' => 'addr',
		);
		foreach($tmp as $k => $v){
			if(!isset($_SESSION[$this->_session_name_attr][$key][$v]) or $_SESSION[$this->_session_name_attr][$key][$v] == ''){
				$_SESSION['Shoppingcar_msg'] .= '訂購人 / '.$k.'\n'; // 跳行是單引號哦，因為是在JS裡面
				$check = false;
			}
		}

		if(!isset($_SESSION[$this->_session_name_attr][$key]['sex'])){
			$_SESSION[$this->_session_name_attr][$key]['sex'] = '1'; // 預設男生
		}

		// 檢查密碼
		if($_SESSION[$this->_session_name_attr][$key]['login_password'] != $_SESSION[$this->_session_name_attr][$key]['login_password_confirm']){
			$_SESSION['Shoppingcar_msg'] .= '訂購人 / 密碼欄位不相同\n'; // 跳行是單引號哦，因為是在JS裡面
			$check = false;
		}

		// 檢查帳號是否存在
		if(isset($_SESSION[$this->_session_name_attr][$key]['login_account'])){
			$row = $this->db->createCommand()->from('customer')->where('is_enable=1 and login_account=:account',array(':account'=>$_SESSION[$this->_session_name_attr][$key]['login_account']))->queryRow();
			if(isset($row) and isset($row['id'])){
				$_SESSION['Shoppingcar_msg'] .= '訂購人 / 登入帳號己經存在，請換一個\n'; // 跳行是單引號哦，因為是在JS裡面
				return false;
			}
		}

		return $check;

		/*
		$empty_orm_data = array(
			'table' => 'orderform',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				array('login_password', 'required'),
				array('login_password', 'system.backend.extensions.myvalidators.sha1passchange'),
			),
		);

		eval($this->data['empty_orm_eval']);
		$update = array(
			'passforgetcheck' => '',
			'login_password' => $_POST['login_password'],
		);
		$c = new $name('insert', $empty_orm_data);
		// 修改專用
		$u = $c::model()->findByPk($_SESSION['authw_admin_id']);
		$u->setAttributes($update);
		// 做了這個動作，才會處理預設值等validator(像是處理create_time和update_time的動作)
		if(!$u->validate()){
			G::dbm($u->getErrors());
		}
		 */
	}

	// 這裡可能要檢查舊會員的欄位有沒有齊全，例如地址和電話
	public function check_old_member_status()
	{
		$check = true;

		$row = $this->db->createCommand()->from('customer')->where('is_enable=1 and id=:id',array(':id'=>$_SESSION['authw_admin_id']))->queryRow();

		if($row and isset($row['id'])){
		} else {
			$_SESSION['Shoppingcar_msg'] .= '舊會員 / 帳號錯誤，請洽網站管理員\n'; // 跳行是單引號哦，因為是在JS裡面
			$check = false;
			return $check;
		}

		// 先檢查是不是都有填
		$tmp = array(
			'姓名' => 'name',
			'聯絡電話' => 'phone',
			'地址' => 'addr',
		);
		foreach($tmp as $k => $v){
			if(!isset($row[$v]) or $row[$v] == ''){
				$_SESSION['Shoppingcar_msg'] .= '舊會員 / '.$k.'\n'; // 跳行是單引號哦，因為是在JS裡面
				$check = false;
			}
		}

		return $check;
	}

	public function check_form_recipient()
	{
		$key = 'recipient';

		$check = true;

		// 先檢查是否同訂購人，是的話，就不用在繼續檢查下去了
		if(isset($_SESSION[$this->_session_name_attr][$key]['same']) and $_SESSION[$this->_session_name_attr][$key]['same'] == '1'){
			return $check;
		}

		// 先檢查是不是都有填
		$tmp = array(
			'姓名' => 'name',
			//'性別' => 'sex',
			'聯絡電話' => 'phone',
			'地址' => 'addr',
		);
		foreach($tmp as $k => $v){
			if(!isset($_SESSION[$this->_session_name_attr][$key][$v]) or $_SESSION[$this->_session_name_attr][$key][$v] == ''){
				$_SESSION['Shoppingcar_msg'] .= '收件人 / '.$k.'\n'; // 跳行是單引號哦，因為是在JS裡面
				$check = false;
			}
		}

		if(!isset($_SESSION[$this->_session_name_attr][$key]['sex'])){
			$_SESSION[$this->_session_name_attr][$key]['sex'] = '1'; // 預設男生
		}

		return $check;
	}

	// 因為都是選填，那就直接回覆檢查成功
	public function check_form_invoice()
	{
		return true;
	}

	// 有需要的檢查付款的部份，就寫在這裡，目前沒有
	// 如果有儲值，可能就會寫在這裡
	public function check_paymenttype()
	{
		return true;
	}

	// 檢查購買的商品的狀況
	// 例如零元商品
	// 或是零庫存
	// 或是零商品(沒有購物)
	public function check_product()
	{
		$check = true;

		if($this->counts() <= 0){
			$_SESSION['Shoppingcar_msg'] .= '商品 / 購物車是空的，請繼續選購\n'; // 跳行是單引號哦，因為是在JS裡面
			$check = false;
		}

		$products = $this->get();
		foreach($products as $k => $v){
			if($v['price'] <= 0){
				$_SESSION['Shoppingcar_msg'] .= '商品 / '.$v['name'].' / 價格為0，無法購買，請移除 \n'; // 跳行是單引號哦，因為是在JS裡面
				$check = false;
			}
			if($v['inventory'] <= 0){
				$_SESSION['Shoppingcar_msg'] .= '商品 / '.$v['name'].' / 庫存為0，無法購買，請移除 \n'; // 跳行是單引號哦，因為是在JS裡面
				$check = false;
			}
		}

		return $check;
	}

	// 結帳前的檢查
	public function checkout_check()
	{
		$step2 = true;

		if(isset($_SESSION['authw_admin_id']) and $_SESSION['authw_admin_id'] != ''){
			// 己登入
			if(!$this->check_old_member_status()) $step2 = false; // 檢查舊會員的帳號狀況
		} else {
			// 沒登入
			if(!$this->check_form_buyer()) $step2 = false; // 檢查購買人欄位
		}

		if(!$this->check_form_recipient()) $step2 = false; // 檢查收件人欄位
		if(!$this->check_form_invoice()) $step2 = false; // 檢查發票

		if(!$this->check_paymenttype()) $step2 = false; // 檢查付款的狀況，初期沒有的話就預留空的
		if(!$this->check_product()) $step2 = false; // 檢查購物車的商品欄位是否正常

		return $step2;
	}

	// 付款
	public function checkout_payment($orderform_id)
	{
		$return = true;

		// 只是先判斷，減少後面程式碼的階層
		if(isset($_SESSION[$this->_session_name_attr]['paymenttype']['type']) and $_SESSION[$this->_session_name_attr]['paymenttype']['type'] != ''){
			// do nothing
		} else {
			$return = false;
			$_SESSION['Shoppingcar_msg'] .= '請先選擇付款方式\n'; // 跳行是單引號哦，因為是在JS裡面
			return $return;
		}

		if($_SESSION[$this->_session_name_attr]['paymenttype']['type'] == 'atm'){
			// do nothing
		} elseif($_SESSION[$this->_session_name_attr]['paymenttype']['type'] == 'cash_on_delivery'){
			// do nothing
		} elseif($_SESSION[$this->_session_name_attr]['paymenttype']['type'] == 'allpay'){
			$row = $this->db->createCommand()->from($this->prefix.'paymenttype')->where('is_enable=1 and func=:func',array(':func'=>'allpay'))->queryRow();
			$orderform_row = $this->db->createCommand()->from($this->prefix.'orderform')->where('id=:id',array(':id'=>$orderform_id))->queryRow();

			//訂單編號
			//$trade_no = "test".time();
			$trade_no = $orderform_row['order_number'];
			//交易金額
			$total_amt = $orderform_row['total'];
			//交易描述
			$trade_desc = "無描述";

			$item_names = array();
			$invoice_item_names = array();
			$invoice_item_words = array();
			$invoice_item_tax_types = array();

			$item_name = '';
			$invoice_item_name = '';
			$invoice_item_word = '';
			$invoice_item_tax_type = '';
			$rows = $this->db->createCommand()->from($this->prefix.'orderformdetail')->where('order_id=:order_id',array(':order_id'=>$orderform_id))->queryAll();
			$invoice_item_count = count($rows);
			if($rows and count($rows) > 0){
				foreach($rows as $k => $v){
					//如果商品名稱有多筆，需在金流選擇頁一行一行顯示商品名稱的話，商品名稱請以井號分隔(#)
					$item_names[] = $v['name'];
					// 發票在用的
					//$invoice_item_name .= $v['name'].'|';
					//$invoice_item_word .= '件|';
					//$invoice_item_tax_type .= '1|'; // 1：要課稅、3：不用、9：混合
					$invoice_item_names[] = $v['name'];
					$invoice_item_words[] = '件';
					$invoice_item_tax_types[] = '1'; // 1：要課稅、3：不用、9：混合
				}
			}
			$item_name = urlencode(implode('|', $item_names));

			$invoice_item_name = urlencode(implode('|', $invoice_item_names));
			$invoice_item_word = urlencode(implode('|', $invoice_item_words));
			$invoice_item_tax_type = urlencode(implode('|', $invoice_item_tax_types));

			//交易返回頁面
			//$return_url = "http://www.allpay.com.tw/receive.php";
			//$return_url = "http://goart.com.tw/client/receive.php";
			//$return_url = "http://mypeople.buyersline.com.tw/aio_return.php";
			$return_url = FRONTEND_DOMAIN.'/'.$row['other_allpay_return_url'];
			//交易通知網址
			$client_back_url = FRONTEND_DOMAIN.'/index.php?r=shoppingcar/success2&order_id='.$orderform_row['id'];
			//選擇預設付款方式
			//$choose_payment = "Credit";
			//$choose_payment = "ALL";
			$choose_payment = $row['other_allpay_choose_payment'];

			//新增開立發票參數

			$invoiceMark = "Y";
			$relateNumber = "test".time();
			$customerID = "";
			$customerIdentifier = "";
			$customerName = urlencode($orderform_row['buyer_name']);
			$customerAddr = urlencode($orderform_row['invoice_addr']);
			$customerPhone = "";
			$customerEmail = urlencode($orderform_row['buyer_login_account']);
			$clearanceMark = "";
			$taxType = "1";
			$carruerType = "";
			$carruerNum = "";

			$donation = "2";
			if($orderform_row['invoice_donation'] == 1){
				$donation = '1';
			}

			$loveCode = $orderform_row['invoice_love_code'];
			$print = "1";
			$invoiceItemName = urlencode($invoice_item_name);
			$invoiceItemCount = $invoice_item_count;
			$invoiceItemWord = urlencode($invoice_item_word);
			$invoiceItemPrice = $orderform_row['total'];
			$invoiceItemTaxType = $invoice_item_tax_type;
			$invoiceRemark = urlencode($this->data['sys_configs']['admin_title'].'訂單開立電子發票');
			$delayDay = "0";
			$invType = "05";

			//交易網址
			$gateway_url = $row['other_allpay_service_url'];
			//商店代號
			$merchant_id = $row['other_allpay_merchant_id'];
			//hashkey
			$hash_key = $row['other_allpay_hash_key'];
			//iv
			$hash_iv = $row['other_allpay_hash_iv'];


			$needExtraPaidInfo = "Y"; //是否回傳詳細資訊

			// 發票欄位範本
			//$invoiceMark = "Y";
			//$relateNumber = "test".time();
			//$customerID = "";
			//$customerIdentifier = "";
			//$customerName = urlencode('測試');
			//$customerAddr = urlencode('臺北市南港區三重路一段');
			//$customerPhone = "";
			//$customerEmail = urlencode('islota@gmail.com');
			//$clearanceMark = "";
			//$taxType = "1";
			//$carruerType = "";
			//$carruerNum = "";
			//$donation = "2";
			//$loveCode = "";
			//$print = "1";
			//$invoiceItemName = urlencode("test");
			//$invoiceItemCount = "1";
			//$invoiceItemWord = urlencode("台");
			//$invoiceItemPrice = "100";
			//$invoiceItemPrice = $orderform_row['total'];
			//$invoiceItemTaxType = "1";
			//$invoiceRemark = urlencode('AIO訂單開立電子發票');
			//$delayDay = "0";
			//$invType = "05";

			$form_array = array(
				"MerchantID" => $merchant_id,
				"MerchantTradeNo" => $trade_no,
				"MerchantTradeDate" => date("Y/m/d H:i:s"),
				"PaymentType" => "aio",
				"TotalAmount" => $total_amt,
				"TradeDesc" => $trade_desc,
				"ItemName" => $item_name,
				"ReturnURL" => $return_url,
				"ChoosePayment" => $choose_payment,
				"ClientBackURL" => $client_back_url,
				"NeedExtraPaidInfo" => $needExtraPaidInfo,
				"InvoiceMark" => $invoiceMark,
				"RelateNumber" => $relateNumber,
				"CustomerID" => $customerID,
				"CustomerIdentifier" => $customerIdentifier,
				"CustomerName" => $customerName,
				"CustomerAddr" => $customerAddr,
				"CustomerPhone" => $customerPhone,
				"CustomerEmail" =>  $customerEmail,
				"ClearanceMark" => $clearanceMark,
				"TaxType" => $taxType,
				"CarruerType" => $carruerType,
				"CarruerNum" => $carruerNum, 
				"Donation" => $donation,
				"LoveCode" =>$loveCode,
				"Print" => $print,
				"InvoiceItemName" => $invoiceItemName, 
				"InvoiceItemCount" =>  $invoiceItemCount,
				"InvoiceItemWord" => $invoiceItemWord, 
				"InvoiceItemPrice" =>  $invoiceItemPrice,
				"InvoiceItemTaxType" => $invoiceItemTaxType,
				"InvoiceRemark" => $invoiceRemark,
				"DelayDay" => $delayDay,
				"InvType" => $invType

			);

			if(isset($row['other_allpay_has_invoice']) and $row['other_allpay_has_invoice'] <= 0){
				$tmp01 = array(
					"InvoiceMark",
					"RelateNumber",
					"CustomerID",
					"CustomerIdentifier",
					"CustomerName",
					"CustomerAddr",
					"CustomerPhone",
					"CustomerEmail",
					"ClearanceMark",
					"TaxType",
					"CarruerType",
					"CarruerNum",
					"Donation",
					"LoveCode",
					"Print",
					"InvoiceItemName",
					"InvoiceItemCount",
					"InvoiceItemWord",
					"InvoiceItemPrice",
					"InvoiceItemTaxType",
					"InvoiceRemark",
					"DelayDay",
					"InvType",
				);
				foreach($tmp01 as $k => $v){
					unset($form_array[$v]);
				}
			}

			$tmp_array = array();
			foreach($form_array as $key => $value)
			{
				$tmp_array[strtolower($key)] = $value;
			}
			$aa = $tmp_array;
			//$form_array = $tmp_array;


			// ksort($aa, SORT_NATURAL |SORT_FLAG_CASE);
			ksort($aa, SORT_STRING);
			// 取得 Mac Value
			$form_array['CheckMacValue'] = $this->allpay_getMacValue($hash_key, $hash_iv, $aa);

			//echo $hash_key.'<br />';
			//echo $hash_iv;
			//var_dump($form_array);
			//die;

			$postdata = http_build_query($form_array);

			$opts = array('http' =>
				array(
					'method'  => 'POST',
					'header'  => 'Content-type: application/x-www-form-urlencoded',
					'content' => $postdata
				)
			);

			$context  = stream_context_create($opts);

			// 這種方式是會失敗的
			//echo file_get_contents($gateway_url, false, $context);

			?>
			<html>
				<head>
				<meta charset='utf-8'>
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
				<script>
				</script>
				</head>
				<body>
				<?php
					//test();
					$html_code = '<form id="form_data" method="post" action="' . $gateway_url . '">';
					foreach ($form_array as $key => $val) {
						$html_code .= "<input type='hidden' name='" . $key . "' value='" . $val . "'><BR>";
					}
					$html_code .= "<input  class='button04' type='submit' value='轉向第三方支付頁面…'>";
					$html_code .= "</form>";
					echo $html_code;
				?>
				<script type="text/javascript">
					$(document).ready(function(){
						$('#form_data').submit();
					});
				</script>
				</body>
			</html>
			<?php

			die;

		} else {
			$return = false;
			$_SESSION['Shoppingcar_msg'] .= '不支援的付款方式\n'; // 跳行是單引號哦，因為是在JS裡面
			return $return;
		}

		return $return;
	}

	// 清除購物車
	public function clear()
	{
		unset($_SESSION[$this->_session_name]);
		unset($_SESSION[$this->_session_name_attr]);
	}

	// 結帳
	public function checkout()
	{
		$return = array();

		/*
		 * 寫入訂單主資料表
		 */

		$savedata = array();

		// 預設未付款
		$savedata['order_status'] = 'nopayment';

		$tmp = $this->total();
		if($tmp and count($tmp) > 0){
			foreach($tmp as $k => $v){
				$savedata[$k] = $v;
			}
		}

		//	'sum' => 0,			// 合計
		//	'shipment' => 0,	// 運費
		//	'total' => 0,		// 總計
		//);

		$key = 'buyer';
		if(isset($_SESSION['authw_admin_id']) and $_SESSION['authw_admin_id'] != ''){
			$row = $this->db->createCommand()->from('customer')->where('is_enable=1 and id=:id',array(':id'=>$_SESSION['authw_admin_id']))->queryRow();
			$savedata['customer_id'] = $_SESSION['authw_admin_id'];
			$savedata[$key.'_login_account'] = $row['login_account'];
			$savedata[$key.'_name'] = $row['name'];
			$savedata[$key.'_sex'] = $row['sex'];
			$savedata[$key.'_phone'] = $row['phone'];
			$savedata[$key.'_addr'] = $row['addr_zipcode'].$row['addr_county'].$row['addr_district'].$row['addr'];
		} else {
			$savedata[$key.'_name'] = $_SESSION[$this->_session_name_attr][$key]['name'];
			$savedata[$key.'_sex'] = $_SESSION[$this->_session_name_attr][$key]['sex'];
			$savedata[$key.'_phone'] = $_SESSION[$this->_session_name_attr][$key]['phone'];
			$savedata[$key.'_addr'] = $_SESSION[$this->_session_name_attr][$key]['addr_zipcode'].$_SESSION[$this->_session_name_attr][$key]['addr_county'].$_SESSION[$this->_session_name_attr][$key]['addr_district'].$_SESSION[$this->_session_name_attr][$key]['addr'];
		}

		$key = 'recipient';
		if(isset($_SESSION[$this->_session_name_attr][$key]['same']) and $_SESSION[$this->_session_name_attr][$key]['same'] == '1'){
			$savedata[$key.'_name'] = $savedata['buyer_name'];
			$savedata[$key.'_sex'] = $savedata['buyer_sex'];
			$savedata[$key.'_phone'] = $savedata['buyer_phone'];
			$savedata[$key.'_addr'] = $savedata['buyer_addr'];
		} else {
			$savedata[$key.'_name'] = $_SESSION[$this->_session_name_attr][$key]['name'];
			$savedata[$key.'_sex'] = $_SESSION[$this->_session_name_attr][$key]['sex'];
			$savedata[$key.'_phone'] = $_SESSION[$this->_session_name_attr][$key]['phone'];
			$savedata[$key.'_addr'] = $_SESSION[$this->_session_name_attr][$key]['addr_zipcode'].$_SESSION[$this->_session_name_attr][$key]['addr_county'].$_SESSION[$this->_session_name_attr][$key]['addr_district'].$_SESSION[$this->_session_name_attr][$key]['addr'];
		}

		$key = 'invoice';
		if(!isset($_SESSION[$this->_session_name_attr][$key]['donation'])) $_SESSION[$this->_session_name_attr][$key]['donation'] = '2'; // 否
		if(!isset($_SESSION[$this->_session_name_attr][$key]['love_code'])) $_SESSION[$this->_session_name_attr][$key]['love_code'] = ''; // 否
		if(!isset($_SESSION[$this->_session_name_attr][$key]['tax_id'])) $_SESSION[$this->_session_name_attr][$key]['tax_id'] = ''; // 否
		if(!isset($_SESSION[$this->_session_name_attr][$key]['name'])) $_SESSION[$this->_session_name_attr][$key]['name'] = ''; // 否
		if(!isset($_SESSION[$this->_session_name_attr][$key]['addr'])) $_SESSION[$this->_session_name_attr][$key]['addr'] = ''; // 否
		$savedata[$key.'_donation'] = $_SESSION[$this->_session_name_attr][$key]['donation'];
		$savedata[$key.'_love_code'] = $_SESSION[$this->_session_name_attr][$key]['love_code'];
		$savedata[$key.'_tax_id'] = $_SESSION[$this->_session_name_attr][$key]['tax_id'];
		$savedata[$key.'_name'] = $_SESSION[$this->_session_name_attr][$key]['name'];
		$savedata[$key.'_addr'] = $_SESSION[$this->_session_name_attr][$key]['addr'];

		$key = 'paymenttype';
		$savedata['payment_type'] = $_SESSION[$this->_session_name_attr][$key]['type'];

		// 看一下當月有幾筆了
		// 這個部分，放在寫入前的最後一個步驟
		$rows = $this->db->createCommand()->from($this->prefix.'orderform')->where('create_time like "%'.date('Y-m-d').'%"')->queryAll();
		$savedata['order_number'] = substr(date('Ymd'), 2, 6).str_pad((count($rows)+1), 6, '0', STR_PAD_LEFT);

		$empty_orm_data_orderform = array(
			'table' => 'orderform',
			'created_field' => 'create_time', 
			//'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				//array('name, phone, email', 'required'),
			),
		);

		$empty_orm_data_orderform_detail = array(
			'table' => 'orderform_detail',
			//'created_field' => 'create_time', 
			//'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				//array('name, phone, email', 'required'),
			),
		);

		$empty_orm_data_product = array(
			'table' => 'product_shop',
			//'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				//array('name, phone, email', 'required'),
			),
		);

		$empty_orm_data_customer = array(
			'table' => 'customer',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				array('name,email,login_account,login_password', 'required'),
				array('login_password', 'system.backend.extensions.myvalidators.sha1passchange'),
			),
		);

		eval($this->data['empty_orm_eval']);
		$u = new $name('insert', $empty_orm_data_orderform);
		// 修改專用
		//$u = $c::model()->findByPk($row['id']);
		$u->setAttributes($savedata);
		// 失敗就失敗
		if(!$u->save()){
			//G::dbm($u->getErrors());
			$return = false;
			$_SESSION['Shoppingcar_msg'] .= '建立訂單失敗\n'; // 跳行是單引號哦，因為是在JS裡面
			return $return;
		}

		$id = $this->db->getLastInsertID();

		if(isset($_SESSION['authw_admin_id']) and $_SESSION['authw_admin_id'] != ''){
			// do nothing
		} else {
			// 非會員直接升級成會員

			// '帳號' => 'login_account',
			// '密碼' => 'login_password',
			// '密碼確認' => 'login_password_confirm',
			// '姓名' => 'name',
			// //'性別' => 'sex',
			// '生日' => 'birthday',
			// '聯絡電話' => 'phone',
			// '地址' => 'addr',

			$key = 'buyer';
			eval($this->data['empty_orm_eval']);
			$u = new $name('insert', $empty_orm_data_customer);
			$save = array(
				'login_account' => $_SESSION[$this->_session_name_attr][$key]['login_account'],
				'email' => $_SESSION[$this->_session_name_attr][$key]['login_account'],
				'login_password' => $_SESSION[$this->_session_name_attr][$key]['login_password'],
				'name' => $_SESSION[$this->_session_name_attr][$key]['name'],
				'sex' => $_SESSION[$this->_session_name_attr][$key]['sex'],
				'birthday' => $_SESSION[$this->_session_name_attr][$key]['birthday'],
				'phone' => $_SESSION[$this->_session_name_attr][$key]['phone'],
				'addr' => $_SESSION[$this->_session_name_attr][$key]['addr'],
				'is_enable' => 1,
			);
			$u->setAttributes($save);
			// save自己會做validate
			$u->save();

			$new_customer_id = $this->db->getLastInsertID();
			Yii::app()->session->add('authw_admin_id', $new_customer_id);
			Yii::app()->session->add('authw_admin_account', $save['login_account']);  
			Yii::app()->session->add('authw_admin_name', $save['name']);  

			// 將會員編號寫回訂單
			eval($this->data['empty_orm_eval']);
			$c = new $name('insert', $empty_orm_data_orderform);
			// 修改專用
			$u = $c::model()->findByPk($id);
			$u->setAttributes(array('customer_id'=>$new_customer_id));
			$u->update();
		}

		/*
		 * 寫入訂單商品資料表
		 */
		if(isset($_SESSION[$this->_session_name])){
			// @k 商品編號
			// @v 商品的完整欄位，以及訂購的數量和所選擇的規格編號
			foreach($_SESSION[$this->_session_name] as $k => $v){

				$v['order_id'] = $id;
				$v['product_id'] = $k;

				eval($this->data['empty_orm_eval']);
				$u = new $name('insert', $empty_orm_data_orderform_detail);
				// 修改專用
				//$u = $c::model()->findByPk($row['id']);
				$u->setAttributes($v);
				// 失敗就失敗
				if(!$u->save()){
					//G::dbm($u->getErrors());
					$return = false;
					$_SESSION['Shoppingcar_msg'] .= '建立訂單失敗\n'; // 跳行是單引號哦，因為是在JS裡面

					// 把上面做的動作取消
					$this->db->createCommand()->delete($this->prefix.'orderform', 'id=:id', array(':id'=>$id));
					$this->db->createCommand()->delete($this->prefix.'orderformdetail', 'order_id=:id', array(':id'=>$id));

					return $return;
				}
			}
		}

		/*
		 * 扣庫存
		 */
		if(isset($_SESSION[$this->_session_name])){
			// @k 商品編號
			// @v 商品的完整欄位，以及訂購的數量和所選擇的規格編號
			foreach($_SESSION[$this->_session_name] as $k => $v){

				$row = $this->db->createCommand()->from($this->prefix)->where('is_enable=1 and id=:id',array(':id'=>$k))->queryRow();

				eval($this->data['empty_orm_eval']);
				$c = new $name('insert', $empty_orm_data_product);
				// 修改專用
				$u = $c::model()->findByPk($k);
				$u->setAttributes(array('inventory' => ($row['inventory'] - $v['amount']) ));
				// 失敗就失敗，這裡不打算做rollback
				if(!$u->update()){
					G::dbm($u->getErrors());
				}
			}
		}

		/*
		 * 付款
		 */
		$this->checkout_payment($id);

		$return = array(
			'car' => $_SESSION[$this->_session_name],
			'attr' => $_SESSION[$this->_session_name_attr],
			'orderform' => $this->db->createCommand()->from($this->prefix.'orderform')->where('id=:id',array(':id'=>$id))->queryRow(),
		);

		/*
		 * 成功頁的付款人資料和收件人資料
		 */
		$paymenttype_tmp = array();
		//$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>'paymenttype','ml_key'=>'tw'))->queryAll();
		$rows = $this->db->createCommand()->from($this->prefix.'paymenttype')->where('is_enable=1')->queryAll();
		if($rows){
			foreach($rows as $k => $v){
				$paymenttype_tmp[$v['func']] = $v['name'];
			}
		}

		$key = 'buyer';

		$return['attr']['buyer']['raw'] = '';
		$return['attr']['buyer']['raw'] .= '<div>姓名：<span>'.$return['orderform'][$key.'_name'].'</span></div>';
		$return['attr']['buyer']['raw'] .= '<div>電話：<span>'.$return['orderform'][$key.'_phone'].'</span></div>';

		$key = 'paymenttype';

		$return['attr']['buyer']['raw'] .= '<div>付款方式：<span>'.$paymenttype_tmp[$_SESSION[$this->_session_name_attr][$key]['type']].'</span></div>';

		$key = 'invoice';

		$return['attr']['buyer']['raw'] .= '<div>是否捐贈發票：<span>';
		if($_SESSION[$this->_session_name_attr][$key]['donation'] == '1'){
			$return['attr']['buyer']['raw'] .= '是';
		} else {
			$return['attr']['buyer']['raw'] .= '否';
		}
		$return['attr']['buyer']['raw'] .= '</span></div>';

		$return['attr']['buyer']['raw'] .= '<div>愛心碼：<span>';
		if($_SESSION[$this->_session_name_attr][$key]['love_code'] == ''){
			$return['attr']['buyer']['raw'] .= '無';
		} else {
			$return['attr']['buyer']['raw'] .= $_SESSION[$this->_session_name_attr][$key]['love_code'];
		}
		$return['attr']['buyer']['raw'] .= '</span></div>';

		$return['attr']['buyer']['raw'] .= '<div>統一編號：<span>';
		if($_SESSION[$this->_session_name_attr][$key]['tax_id'] == ''){
			$return['attr']['buyer']['raw'] .= '否';
		} else {
			$return['attr']['buyer']['raw'] .= $_SESSION[$this->_session_name_attr][$key]['tax_id'];
		}
		$return['attr']['buyer']['raw'] .= '</span></div>';

		$return['attr']['buyer']['raw'] .= '<div>公司抬頭：<span>';
		if($_SESSION[$this->_session_name_attr][$key]['name'] == ''){
			$return['attr']['buyer']['raw'] .= '否';
		} else {
			$return['attr']['buyer']['raw'] .= $_SESSION[$this->_session_name_attr][$key]['name'];
		}
		$return['attr']['buyer']['raw'] .= '</span></div>';
		
		$return['attr']['buyer']['raw'] .= '<div>發票寄送地址：<span>';
		if($_SESSION[$this->_session_name_attr][$key]['addr'] == ''){
			$return['attr']['buyer']['raw'] .= '否';
		} else {
			$return['attr']['buyer']['raw'] .= $_SESSION[$this->_session_name_attr][$key]['addr'];
		}
		$return['attr']['buyer']['raw'] .= '</span></div>';

		$key = 'recipient';

		$return['attr']['recipient']['raw'] = '';
		$return['attr']['recipient']['raw'] .= '<div>姓名：<span>'.$return['orderform'][$key.'_name'].'</span></div>';
		$return['attr']['recipient']['raw'] .= '<div>電話：<span>'.$return['orderform'][$key.'_phone'].'</span></div>';
		$return['attr']['recipient']['raw'] .= '<div>地址：<span>'.$return['orderform'][$key.'_addr'].'</span></div>';

		// 將付款人資料，以及收件人資料，寫進去，方便會員訂單查詢的程式撰寫
		eval($this->data['empty_orm_eval']);
		$c = new $name('insert', $empty_orm_data_orderform);
		// 修改專用
		$u = $c::model()->findByPk($id);
		$u->setAttributes(array('buyer_raw'=>$return['attr']['buyer']['raw'],'recipient_raw'=>$return['attr']['recipient']['raw']));
		$u->update();

		/*
		 * 清除購物車
		 */
		$this->clear();

		return $return;
	}

	// 信用卡的回傳頁
	public function checkout2()
	{
		/*
		 * 成功頁的付款人資料和收件人資料
		 */
		$paymenttype_tmp = array();
		//$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>'paymenttype','ml_key'=>'tw'))->queryAll();
		$rows = $this->db->createCommand()->from($this->prefix.'paymenttype')->where('is_enable=1')->queryAll();
		if($rows){
			foreach($rows as $k => $v){
				$paymenttype_tmp[$v['func']] = $v['name'];
			}
		}

		$key = 'buyer';

		$return['attr']['buyer']['raw'] = '';
		$return['attr']['buyer']['raw'] .= '<div>姓名：<span>'.$return['orderform'][$key.'_name'].'</span></div>';
		$return['attr']['buyer']['raw'] .= '<div>電話：<span>'.$return['orderform'][$key.'_phone'].'</span></div>';

		$key = 'paymenttype';

		$return['attr']['buyer']['raw'] .= '<div>付款方式：<span>'.$paymenttype_tmp[$_SESSION[$this->_session_name_attr][$key]['type']].'</span></div>';

		$key = 'invoice';

		$return['attr']['buyer']['raw'] .= '<div>是否捐贈發票：<span>';
		if($_SESSION[$this->_session_name_attr][$key]['donation'] == '1'){
			$return['attr']['buyer']['raw'] .= '是';
		} else {
			$return['attr']['buyer']['raw'] .= '否';
		}
		$return['attr']['buyer']['raw'] .= '</span></div>';

		$return['attr']['buyer']['raw'] .= '<div>愛心碼：<span>';
		if($_SESSION[$this->_session_name_attr][$key]['love_code'] == ''){
			$return['attr']['buyer']['raw'] .= '無';
		} else {
			$return['attr']['buyer']['raw'] .= $_SESSION[$this->_session_name_attr][$key]['love_code'];
		}
		$return['attr']['buyer']['raw'] .= '</span></div>';

		$return['attr']['buyer']['raw'] .= '<div>統一編號：<span>';
		if($_SESSION[$this->_session_name_attr][$key]['tax_id'] == ''){
			$return['attr']['buyer']['raw'] .= '否';
		} else {
			$return['attr']['buyer']['raw'] .= $_SESSION[$this->_session_name_attr][$key]['tax_id'];
		}
		$return['attr']['buyer']['raw'] .= '</span></div>';

		$return['attr']['buyer']['raw'] .= '<div>公司抬頭：<span>';
		if($_SESSION[$this->_session_name_attr][$key]['name'] == ''){
			$return['attr']['buyer']['raw'] .= '否';
		} else {
			$return['attr']['buyer']['raw'] .= $_SESSION[$this->_session_name_attr][$key]['name'];
		}
		$return['attr']['buyer']['raw'] .= '</span></div>';
		
		$return['attr']['buyer']['raw'] .= '<div>發票寄送地址：<span>';
		if($_SESSION[$this->_session_name_attr][$key]['addr'] == ''){
			$return['attr']['buyer']['raw'] .= '否';
		} else {
			$return['attr']['buyer']['raw'] .= $_SESSION[$this->_session_name_attr][$key]['addr'];
		}
		$return['attr']['buyer']['raw'] .= '</span></div>';

		$key = 'recipient';

		$return['attr']['recipient']['raw'] = '';
		$return['attr']['recipient']['raw'] .= '<div>姓名：<span>'.$return['orderform'][$key.'_name'].'</span></div>';
		$return['attr']['recipient']['raw'] .= '<div>電話：<span>'.$return['orderform'][$key.'_phone'].'</span></div>';
		$return['attr']['recipient']['raw'] .= '<div>地址：<span>'.$return['orderform'][$key.'_addr'].'</span></div>';

		// 將付款人資料，以及收件人資料，寫進去，方便會員訂單查詢的程式撰寫
		eval($this->data['empty_orm_eval']);
		$c = new $name('insert', $empty_orm_data_orderform);
		// 修改專用
		$u = $c::model()->findByPk($id);
		$u->setAttributes(array('buyer_raw'=>$return['attr']['buyer']['raw'],'recipient_raw'=>$return['attr']['recipient']['raw']));
		$u->update();

		/*
		 * 清除購物車
		 */
		$this->clear();

		return $return;
	}

	public function form_buyer_input_save($row)
	{
		$_SESSION[$this->_session_name_attr]['buyer'][$row['name']] = $row['value'];
	}

	public function form_recipient_input_save($row)
	{
		$_SESSION[$this->_session_name_attr]['recipient'][$row['name']] = $row['value'];
	}

	public function form_invoice_input_save($row)
	{
		$_SESSION[$this->_session_name_attr]['invoice'][$row['name']] = $row['value'];
	}

	public function set_paymenttype($paymenttype = '')
	{
		if($paymenttype != ''){
			$_SESSION[$this->_session_name_attr]['paymenttype']['type'] = $paymenttype;
		}
	}

	// 有沒有選擇付款方式
	public function has_paymenttype()
	{
		if(isset($_SESSION[$this->_session_name_attr]['paymenttype']['type']) and $_SESSION[$this->_session_name_attr]['paymenttype']['type'] != ''){
			return true;
		} else {
			return false;
		}
	}

	public function hasid($id = 0)
	{
		if($id > 0){
			if(isset($_SESSION[$this->_session_name][$id])){
				return true;
			}
		}
		
		return false;
	}

	public function hasdata()
	{
		if(isset($_SESSION[$this->_session_name]) and count($_SESSION[$this->_session_name]) > 0){
			return true;
		}
		
		return false;
	}

	public function counts() // 因為count是函式，所以加了一個s
	{
		if(isset($_SESSION[$this->_session_name])){
			return count($_SESSION[$this->_session_name]);
		}
		
		return 0;
	}

	// 最後加入的三筆資料
	public function get_last_add_three()
	{
		$return = array();
		$productshop = array_reverse($_SESSION[$this->_session_name]);
		if($productshop and count($productshop) > 0){
			foreach($productshop as $k => $v){
				if($k == 3){
					continue;
				}
				$return[] = $v;
			}
		}
		return $return;
	}

	// 取得所有購物車裡面的東西
	public function get()
	{
		$return = array();
		if($this->hasdata()){
			return $_SESSION[$this->_session_name];
		} else {
			return $return;
		}
	}

	public function add($id = 0, $amount = 1, $spec_id = 0)
	{
		if($id > 0){
			$row = $this->db->createCommand()->from($this->prefix)->where('is_enable=1 and id=:id',array(':id'=>$id))->queryRow();
			if(isset($row) and isset($row['id'])){

				$row['amount'] = $amount;
				$row['spec_id'] = $spec_id;

				// 有一些不需要的拿掉，因為之後會完整的寫入訂單商品資料表裡面
				unset($row['id']);
				unset($row['create_time']);
				unset($row['update_time']);

				$_SESSION[$this->_session_name][$id] = $row;

				return true;
			}
		}
		return false;
	}

	public function amount($id = 0, $amount = 0)
	{
		if($id > 0){
			if(isset($_SESSION[$this->_session_name][$id])){
				$_SESSION[$this->_session_name][$id]['amount'] = $amount;
				return true;
			}
		}
		return false;
	}

	public function del($id = 0)
	{
		if($id > 0){
			if(isset($_SESSION[$this->_session_name][$id])){
				unset($_SESSION[$this->_session_name][$id]);
				return true;
			}
		}
		return false;
	}

	// 計算總計
	public function total($order_id = 0)
	{
		$return = array(
			'sum' => 0,			// 合計
			'shipment' => 0,	// 運費
			'total' => 0,		// 總計
		);
		if($order_id != 0){
			$tmp = $this->db->createCommand()->from($this->prefix.'orderformdetail')->where('order_id=:order_id',array(':order_id'=>$order_id))->queryAll();
			if(isset($tmp)){
				foreach($tmp as $k => $v){
					$return['sum'] += (int)$v['price'] * (int)$v['amount'];
				}
			}
		} else {
			if(isset($_SESSION[$this->_session_name])){
				foreach($_SESSION[$this->_session_name] as $k => $v){
					$return['sum'] += (int)$v['price'] * (int)$v['amount'];
				}
			}
		}
		if($return['sum'] >= $this->free_shipment){
			$return['total'] = $return['sum'];
		} else {
			$return['total'] = $return['sum'] + $this->default_shipment;
			$return['shipment'] = $this->default_shipment;
		}

		return $return;
	}

}
