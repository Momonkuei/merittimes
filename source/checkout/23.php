<?php

/*
 * 第二步驟在做的事
 */

/*
 * recipient_other1 ~ recipient_other10 是預留給收件者的欄位
 * 其中前3個，是留給跟會員欄位連動的
 * 定揚購物的部份，它的情況是只用到一個(Last Name)
 */

$member = array();
$member_address = false;

if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0){
} else {
	if(!isset($_SESSION['save']['member_form_1'])){
		$_SESSION['save']['member_form_1'] = array(
			'login_account' => '',
			'login_password' => '',
			'login_password_confirm' => '',
			'name' => '',
			'gender' => '',
			'birthday' => '',
			'birthday_year' => '', // 記得寫入的時候要刪掉
			'birthday_month' => '', // 記得寫入的時候要刪掉
			'birthday_day' => '', // 記得寫入的時候要刪掉
			'phone' => '',
			'addr' => '',
			'addr_county' => '',
			'addr_district' => '',
			'addr_zipcode' => '',
			'need_dm' => 0,
			'accept_privacy' => 0,

			// 預留
			'other1' => '', // 跟收件人的other1連動
			'other2' => '', // 跟收件人的other2連動 
			'other3' => '', // 跟收件人的other3連動
		);
	}
}

if(!isset($_SESSION['save']['member_form_2'])){
	$_SESSION['save']['member_form_2'] = array(
		'recipient_name' => '',
		'recipient_gender' => '',
		'recipient_phone' => '',
		'recipient_mobile' => '',
		'recipient_addr' => '',
		'recipient_addr_county' => '',
		'recipient_addr_district' => '',

		// 預留
		'recipient_other1' => '', // 跟會員欄位的other1連動
		'recipient_other2' => '', // 跟會員欄位的other2連動
		'recipient_other3' => '', // 跟會員欄位的other3連動
		'recipient_other4' => '',
		'recipient_other5' => '',
		'recipient_other6' => '',
		'recipient_other7' => '',
		'recipient_other8' => '',
		'recipient_other9' => '',
		'recipient_other10' => '',
	);
}

$recipient = array(
	'recipient_name' => '',
	'recipient_gender' => '',
	'recipient_phone' => '',
	'recipient_mobile' => '',
	'recipient_addr' => '',

	// 預留
	'recipient_other1' => '', // 跟會員欄位的other1連動
	'recipient_other2' => '', // 跟會員欄位的other2連動
	'recipient_other3' => '', // 跟會員欄位的other3連動
	'recipient_other4' => '',
	'recipient_other5' => '',
	'recipient_other6' => '',
	'recipient_other7' => '',
	'recipient_other8' => '',
	'recipient_other9' => '',
	'recipient_other10' => '',
);

// 如果是非會員且選擇同訂購人的情況，那資料優先權不是依照這裡
if(isset($_SESSION['save']['member_form_2']) and !empty($_SESSION['save']['member_form_2'])){
	foreach($_SESSION['save']['member_form_2'] as $k => $v){
		$recipient[$k] = $v;
	}
}

/*
 * 發票
 */ 

if(!isset($_SESSION['save']['invoice_1'])){
	$_SESSION['save']['invoice_1'] = array(
		'invoice_type' => '',
		'invoice_type_2' => '',
		'invoice_type_2_barcode' => '',
		'invoice_tax_id' => '',
		'invoice_name' => '',
		'detail' => '',
		'captcha' => '',
	);
}

$invoice = array();

if(isset($_SESSION['save']['invoice_1']) and !empty($_SESSION['save']['invoice_1'])){
	foreach($_SESSION['save']['invoice_1'] as $k => $v){
		$invoice[$k] = $v;
	}
}

if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0){
	//登入後的欄位檢查
	$member = $this->db->createCommand()->from('customer')->where('is_enable=1 and id=:id', array(':id'=>$this->data['admin_id']))->queryRow();

	// 
	if($member['addr_county'] != ''){
		$_SESSION['save']['member_form_1']['addr_county'] = $member['addr_county'];
	} else {
		$_SESSION['save']['member_form_1']['addr_county'] = '';
	}

	//
	if($member['addr_district'] != ''){
		$_SESSION['save']['member_form_1']['addr_district'] = $member['addr_district'];
	} else {
		$_SESSION['save']['member_form_1']['addr_district'] = '';
	}

	//2021-06-21 lota fix
	if($member['addr'] != ''){
		$_SESSION['save']['member_form_1']['addr'] = $member['addr'];
	} else {
		$_SESSION['save']['member_form_1']['addr'] = '';
	}


	$member_address = $this->db->createCommand()->from('customer_address')->where('is_enable=1 and customer_id=:id', array(':id'=>$this->data['admin_id']))->order('create_time desc')->limit(3)->queryAll();
	$member_address_tmp = array();
	if($member_address and !empty($member_address)){
		foreach($member_address as $k => $v){
			$member_address_tmp[$v['id']] = $v;
		}
	}

	if(isset($_SESSION['save']['member_form_2']['select_recipient']) and $_SESSION['save']['member_form_2']['select_recipient'] != ''){
		if(preg_match('/^addr_(.*)$/', $_SESSION['save']['member_form_2']['select_recipient'], $matches)){
			if(isset($member_address_tmp[$matches[1]])){
				$tmp = $member_address_tmp[$matches[1]]; 
				$recipient = array(
					'select_recipient' => $_SESSION['save']['member_form_2']['select_recipient'],
					'recipient_name' => $tmp['name'],
					'recipient_gender' => $tmp['gender'],
					'recipient_phone' => $tmp['phone'],
					'recipient_mobile' => $tmp['mobile'],
					'recipient_addr' => $tmp['addr'],
					'recipient_addr_county' => $tmp['addr_county'],
					'recipient_addr_district' => $tmp['addr_district'],
				);

				// 2020-05-29 nemo發現的問題
				if($recipient['recipient_gender'] === null){
					unset($recipient['recipient_gender']);
				}

				// 覆寫
				$_SESSION['save']['member_form_2'] = $recipient;

				// 為了程式碼好寫
				$_SESSION['save']['member_form_2']['recipient_addr_county'] = $tmp['addr_county'];
				$_SESSION['save']['member_form_2']['recipient_addr_district'] = $tmp['addr_district'];
			}
		} elseif($_SESSION['save']['member_form_2']['select_recipient'] == 'buyer' && !isset($_GET['ajax']) && !isset($_GET['go_to_step2']) && !isset($_SESSION['save']['step2']['go_to_step2']) && $_SESSION[$this->data['router_method']]['step']!=3 ){ 
		//2020-12-16 加入 GET 變數，在view/checkout/step2.php 841 帶過來的，要確定已經不是重新整理而是送出到下個階段 by lota 
		//2021-06-24 因為改成拆解寫法，所以這邊要多加不要再第三步驟處理 by lota
		//2021-11-17 目前的檢查架構會把本身核心程式當作ajax程式去檢查，會員資料會直接覆蓋所編寫的資料 所以把參數$_GET['ajax']跳脫掉 by lota
			// $recipient = array(
			// 	'recipient_name' => $_SESSION['save']['member_form_1']['name'],
			// 	'recipient_gender' => $_SESSION['save']['member_form_1']['gender'],
			// 	'recipient_phone' => $_SESSION['save']['member_form_1']['phone'],
			// 	'recipient_mobile' => $_SESSION['save']['member_form_2']['recipient_mobile'],
			// 	'recipient_addr' => $_SESSION['save']['member_form_1']['addr'],
			// );

			$recipient['recipient_name'] = $_SESSION['save']['member_form_2']['recipient_name'] = $member['name'];
			$recipient['recipient_gender'] = $_SESSION['save']['member_form_2']['recipient_gender'] = $member['gender'];
			$recipient['recipient_phone'] = $_SESSION['save']['member_form_2']['recipient_phone'] = $member['phone'];
			$recipient['recipient_mobile'] = $_SESSION['save']['member_form_2']['recipient_mobile'] = $member['mobile'];
			$recipient['recipient_addr'] = $_SESSION['save']['member_form_2']['recipient_addr'] = $member['addr'];
			$recipient['recipient_addr_county'] = $_SESSION['save']['member_form_2']['recipient_addr_county'] = $member['addr_county'];
			$recipient['recipient_addr_district'] = $_SESSION['save']['member_form_2']['recipient_addr_district'] = $member['addr_district'];

			// 預留
			$recipient['recipient_other1'] = $_SESSION['save']['member_form_2']['recipient_other1'] = $member['other1'];
			$recipient['recipient_other2'] = $_SESSION['save']['member_form_2']['recipient_other2'] = $member['other2'];
			$recipient['recipient_other3'] = $_SESSION['save']['member_form_2']['recipient_other3'] = $member['other3'];

			// $_SESSION['save']['member_form_2']['select_recipient'] = 'buyer_sel';// 拷貝後就把這個參數改為非buyer by lota，這個有些情境不適用，改用 GET 變數來判斷 by lota

			// 2020-05-29 nemo發現的問題
			if($recipient['recipient_gender'] === null){
				unset($recipient['recipient_gender']);
			}
		}
	}
} else {
	//登入前的欄位檢查
	if(isset($_SESSION['save']['member_form_1']['login_account']) and $_SESSION['save']['member_form_1']['login_account'] != ''){
		// 檢查email帳號是否存在
		$row = $this->db->createCommand()->from('customer')->where('is_enable=1 and login_account=:account', array(':account'=>$_SESSION['save']['member_form_1']['login_account']))->queryRow();
		if($row and isset($row['id'])){
			$_SESSION['save']['member_form_1']['login_account'] = '';
			$error_logs[] = array(
				'guest_email_exist',
				t('訂購人| 請使用其它Email'),
				2, // 第幾步驟
			);
			$step2_javascript_evals[] = '$("input[name=login_account]").addClass("error");';
		}

		// 檢查email格式
		if (!filter_var($_SESSION['save']['member_form_1']['login_account'], FILTER_VALIDATE_EMAIL)) {
			$_SESSION['save']['member_form_1']['login_account'] = '';
			$error_logs[] = array(
				'guest_email_no_match',
				t('訂購人| Email信箱格式錯誤'),
				2, // 第幾步驟
			);
			$step2_javascript_evals[] = '$("input[name=login_account]").addClass("error");';
		}
	} else {
		$error_logs[] = array(
			'guest_email_required',
			t('訂購人| Email欄位沒有填'),
			2, // 第幾步驟
		);
		$step2_javascript_evals[] = '$("input[name=login_account]").addClass("error");';
	}

	/*
	 * 檢查未登入的基本欄位
	 */

	if($_SESSION['save']['member_form_1']['name'] == ''){
		$error_logs[] = array(
			'guest_name_required',
			t('訂購人| 姓名欄位沒有填'),
			2, // 第幾步驟
		);
		$step2_javascript_evals[] = '$("input[name=name]").addClass("error");';
	}
	if($_SESSION['save']['member_form_1']["gender"]=="男"){//20220818 lin 增加
		$_SESSION['save']['member_form_1']["gender"]=1;
	}
	if($_SESSION['save']['member_form_1']["gender"]=="女"){//20220818 lin 增加
		$_SESSION['save']['member_form_1']["gender"]=2;
	}
	// 如果會員那3個預留欄位，需要檢查欄位的情況
	// if($_SESSION['save']['member_form_1']['other1'] == ''){
	// 	$error_logs[] = array(
	// 		'guest_name_required',
	// 		t('訂購人| OTHER1欄位沒有填'),
	// 		2, // 第幾步驟
	// 	);
	// 	$step2_javascript_evals[] = '$("input[name=other1]").addClass("error");';
	// }

	if($_SESSION['save']['member_form_1']['phone'] == ''){
		$error_logs[] = array(
			'guest_phone_required',
			t('訂購人| 電話欄位沒有填'),
			2, // 第幾步驟
		);
		$step2_javascript_evals[] = '$("input[name=phone]").addClass("error");';
	}

	// 2020-05-29
	// 生日是非必填，只要有填一個欄位，才會檢查欄位是否有填
	if($_SESSION['save']['member_form_1']['birthday_year'] != '' or $_SESSION['save']['member_form_1']['birthday_month'] != '' or $_SESSION['save']['member_form_1']['birthday_day'] != ''){
		if($_SESSION['save']['member_form_1']['birthday_year'] == '' or $_SESSION['save']['member_form_1']['birthday_month'] == '' or $_SESSION['save']['member_form_1']['birthday_day'] == ''){
			$error_logs[] = array(
				'guest_addr_required',
				t('訂購人| 生日欄位沒有填'),
				2, // 第幾步驟
			);
			foreach(array('year','month','day') as $v){
				if($_SESSION['save']['member_form_1']['birthday_'.$v] == ''){
					$step2_javascript_evals[] = '$("select[name=birthday_'.$v.']").addClass("error");';
				}
			}
			$_SESSION['save']['member_form_1']['birthday'] = '';
		} elseif($_SESSION['save']['member_form_1']['birthday_year'] != '' and $_SESSION['save']['member_form_1']['birthday_month'] != '' and $_SESSION['save']['member_form_1']['birthday_day'] != ''){
			$_SESSION['save']['member_form_1']['birthday'] = $_SESSION['save']['member_form_1']['birthday_year'].'-'.str_pad($_SESSION['save']['member_form_1']['birthday_month'],2,'0',STR_PAD_LEFT).'-'.$_SESSION['save']['member_form_1']['birthday_day'];
		}
	}

	if($_SESSION['save']['member_form_1']['addr_county'] == '' 
		or $_SESSION['save']['member_form_1']['addr_district'] == ''
		or $_SESSION['save']['member_form_1']['addr'] == ''
	){
		$error_logs[] = array(
			'guest_addr_required',
			t('訂購人| 地址欄位沒有填'),
			2, // 第幾步驟
		);
		$step2_javascript_evals[] = '$("select[name=addr_county]").addClass("error");';
		$step2_javascript_evals[] = '$("select[name=addr_district]").addClass("error");';
		$step2_javascript_evals[] = '$("input[name=addr]").addClass("error");';
	}

	if($_SESSION['save']['member_form_1']['login_password'] == '' 
		or $_SESSION['save']['member_form_1']['login_password_confirm'] == ''
		or ($_SESSION['save']['member_form_1']['login_password'] != $_SESSION['save']['member_form_1']['login_password_confirm'])
	){
		$error_logs[] = array(
			'email_required',
			t('訂購人| 密碼欄位沒有填、或是與再次輸入密碼不相符'),
			2, // 第幾步驟
		);
		$step2_javascript_evals[] = '$("input[name=login_password]").addClass("error");';
		$step2_javascript_evals[] = '$("input[name=login_password_confirm]").addClass("error");';
	}

	if($_SESSION['save']['member_form_1']['accept_privacy'] <= 0){
		$error_logs[] = array(
			'accept_privacy_required',
			t('訂購人| 請同意隱私權政策'),
			2, // 第幾步驟
		);
		$step2_javascript_evals[] = '$("input[name=accept_privacy]").addClass("error");';
	}

	//var_dump($_SESSION['save']['member_form_1']);die;
	$member = $_SESSION['save']['member_form_1'];

	// 同訂購人 (非會員)
	if(isset($_SESSION['save']['member_form_2']['select_recipient']) and $_SESSION['save']['member_form_2']['select_recipient'] != ''){
		if($_SESSION['save']['member_form_2']['select_recipient'] == 'buyer' && !isset($_GET['ajax']) && !isset($_GET['go_to_step2']) && !isset($_SESSION['save']['step2']['go_to_step2']) && $_SESSION[$this->data['router_method']]['step']!=3 ){ 
		//2020-12-16 加入 GET 變數，在view/checkout/step2.php 841 帶過來的，要確定已經不是重新整理而是送出到下個階段 by lota 
		//2021-06-24 因為改成拆解寫法，所以這邊要多加不要再第三步驟處理 by lota
		//2021-11-17 目前的檢查架構會把本身核心程式當作ajax程式去檢查，前面訂購者的資料會覆蓋後來填寫的 所以把參數$_GET['ajax']跳脫掉 by lota
			// $recipient = array(
			// 	'recipient_name' => $_SESSION['save']['member_form_1']['name'],
			// 	'recipient_gender' => $_SESSION['save']['member_form_1']['gender'],
			// 	'recipient_phone' => $_SESSION['save']['member_form_1']['phone'],
			// 	'recipient_mobile' => $_SESSION['save']['member_form_2']['recipient_mobile'],
			// 	'recipient_addr' => $_SESSION['save']['member_form_1']['addr'],
			// );

			$recipient['recipient_name'] = $_SESSION['save']['member_form_2']['recipient_name'] = $_SESSION['save']['member_form_1']['name'];
			$recipient['recipient_gender'] = $_SESSION['save']['member_form_2']['recipient_gender'] = $_SESSION['save']['member_form_1']['gender'];
			$recipient['recipient_mobile'] = $_SESSION['save']['member_form_2']['recipient_mobile'];
			$recipient['recipient_addr'] = $_SESSION['save']['member_form_2']['recipient_addr'] = $_SESSION['save']['member_form_1']['addr'];

			// 預留給會員和收件人連動的欄位
			$recipient['recipient_other1'] = $_SESSION['save']['member_form_2']['recipient_other1'] = $_SESSION['save']['member_form_1']['other1'];
			$recipient['recipient_other2'] = $_SESSION['save']['member_form_2']['recipient_other2'] = $_SESSION['save']['member_form_1']['other2'];
			$recipient['recipient_other3'] = $_SESSION['save']['member_form_2']['recipient_other3'] = $_SESSION['save']['member_form_1']['other3'];

			// #36112
			if(!isset($_SESSION['save']['member_form_2']['recipient_phone']) or $_SESSION['save']['member_form_2']['recipient_phone'] == ''){
				$recipient['recipient_phone'] = $_SESSION['save']['member_form_2']['recipient_phone'] = $_SESSION['save']['member_form_1']['phone'];
			}

			$_SESSION['save']['member_form_2']['recipient_addr_county'] = $recipient['recipient_addr_county'] = $_SESSION['save']['member_form_1']['addr_county'];
			$_SESSION['save']['member_form_2']['recipient_addr_district'] = $recipient['recipient_addr_district'] = $_SESSION['save']['member_form_1']['addr_district'];

			// 2020-05-29 nemo發現的問題
			if($recipient['recipient_gender'] === null){
				unset($recipient['recipient_gender']);
			}

			// $_SESSION['save']['member_form_2']['select_recipient'] = 'buyer_sel';// 拷貝後就把這個參數改為非buyer by lota，這個有些情境不適用，改用 GET 變數來判斷 by lota

		}
	}
}


// 只是方便第三步驟套程式而以 2017/7/3 加入防呆 by lota
if(isset($recipient['recipient_addr_county']) && isset($recipient['recipient_addr_district'])){
	$recipient['recipient_addr_merge'] = $recipient['recipient_addr_county'].$recipient['recipient_addr_district'].$recipient['recipient_addr'];
} else {
	$recipient['recipient_addr_merge'] = $recipient['recipient_addr'];
}

//判斷是否有電子發票
unset($_constant);
eval('$_constant = '.strtoupper('shop_show_electronic_invoice').';');
if($_constant){

	// 只檢查必填
	if($_SESSION['save']['invoice_1']['invoice_type'] == ''){
		$error_logs[] = array(
			'invoice_type_required',
			t('發票資訊| 請選擇二聯或是三聯'),
			2, // 第幾步驟
		);
		$step2_javascript_evals[] = '$("input[name=invoice_type]").parent().parent().addClass("error");';
	}

	// 如果是二聯式電子發票
	if($_SESSION['save']['invoice_1']['invoice_type'] == '1'){
		if($_SESSION['save']['invoice_1']['invoice_type_2'] == ''){
			$error_logs[] = array(
				'invoice_type_2_required',
				t('發票資訊| 請選擇手機條碼、或是自然人憑證條碼'),
				2, // 第幾步驟
			);
			// 因為設計沒有做error，所以這一個沒有
		}
		if($_SESSION['save']['invoice_1']['invoice_type_2_barcode'] == ''){
			$error_logs[] = array(
				'invoice_type_2_barcode_required',
				t('發票資訊| 請輸入條碼'),
				2, // 第幾步驟
			);
			$step2_javascript_evals[] = '$("input[name=invoice_type_2_barcode]").addClass("error");';
		}
	}

	// 三聯式紙本發票(公司行號報帳用)
	if($_SESSION['save']['invoice_1']['invoice_type'] == '3'){
		if($_SESSION['save']['invoice_1']['invoice_tax_id'] == ''){
			$error_logs[] = array(
				'invoice_tax_id_required',
				t('發票資訊| 請輸入統一編號'),
				2, // 第幾步驟
			);
			$step2_javascript_evals[] = '$("input[name=invoice_tax_id]").addClass("error");';
		}
		if($_SESSION['save']['invoice_1']['invoice_name'] == ''){
			$error_logs[] = array(
				'invoice_name_required',
				t('發票資訊| 請輸入公司抬頭'),
				2, // 第幾步驟
			);
			$step2_javascript_evals[] = '$("input[name=invoice_name]").addClass("error");';
		}
	}
} // 是否有電子發票

// 收件人 (檢查必填、含特殊字元的、字數長度和規則
if($_SESSION['save']['member_form_2']['recipient_name'] == ''){
	$error_logs[] = array(
		'recipient_name_required',
		t('收件人| 姓名欄位沒有填'),
		2, // 第幾步驟
	);
	$step2_javascript_evals[] = '$("input[name=recipient_name]").addClass("error");';
} else {
	$check_name = $_SESSION['save']['member_form_2']['recipient_name'];
	$check_name = str_replace(' ','',$check_name);
	$check_name = str_replace('.','',$check_name);
	$check_name = str_replace(',','',$check_name);

	if(preg_match('/(\^|\'|\`|\!|\@|\#|\%|\&|\*|\+|\\|\"|\<|\>|\||\_|\[|\])/', $check_name)){
		$error_logs[] = array(
			'recipient_name_has_special_char',
			t('收件人| 姓名欄位不能含有特殊字元'),
			2, // 第幾步驟
		);
		$step2_javascript_evals[] = '$("input[name=recipient_name]").addClass("error");';
	}

	if(!preg_match('/^([\x{4e00}-\x{9fff}\x{3400}-\x{4dbf}]{2,5}|[a-zA-Z]{4,10})$/u', $check_name)){
		$error_logs[] = array(
			'recipient_name_format_error',
			t('收件人| 姓名欄位，中文限制2~5個字，英文限制4~10個字，不能中英混合輸入'),
			2, // 第幾步驟
		);
		$step2_javascript_evals[] = '$("input[name=recipient_name]").addClass("error");';
	}
}

// 電話 (檢查必填、電話格式)
if($_SESSION['save']['member_form_2']['recipient_phone'] == ''){
	$error_logs[] = array(
		'recipient_phone_required',
		t('收件人| 電話欄位沒有填，請填入手機號碼'),
		2, // 第幾步驟
	);
	$step2_javascript_evals[] = '$("input[name=recipient_phone]").addClass("error");';
} elseif(!preg_match('/^09........$/', $_SESSION['save']['member_form_2']['recipient_phone'])){
	$error_logs[] = array(
		'recipient_phone_error',
		t('收件人| 請填入正確手機號碼 (09xxxxxxxx)'),
		2, // 第幾步驟
	);
	$step2_javascript_evals[] = '$("input[name=recipient_phone]").addClass("error");';
}

// 備用電話 (有填才檢查格式)
if($_SESSION['save']['member_form_2']['recipient_mobile'] != '' and !preg_match('/^09........$/', $_SESSION['save']['member_form_2']['recipient_mobile'])){
	$error_logs[] = array(
		'recipient_phone_error',
		t('收件人| 請填入正確備用電話號碼 (09xxxxxxxx)'),
		2, // 第幾步驟
	);
	$step2_javascript_evals[] = '$("input[name=recipient_mobile]").addClass("error");';
}

// 收件人預留欄位的欄位檢查，請寫在這裡
// if($_SESSION['save']['member_form_2']['recipient_other1'] == ''){
// 	$error_logs[] = array(
// 		'recipient_phone_required',
// 		t('收件人| OTHER1欄位沒有填'),
// 		2, // 第幾步驟
// 	);
// 	$step2_javascript_evals[] = '$("input[name=recipient_phone]").addClass("error");';
// }

if(
	(
		$_SESSION['save']['member_form_2']['recipient_addr_county'] == '' 
		or $_SESSION['save']['member_form_2']['recipient_addr_district'] == ''
		or $_SESSION['save']['member_form_2']['recipient_addr'] == ''
	)
	and isset($shipment['addr'])
	and $shipment['addr'] == 'addr' // 當然，如果是選擇超商，就不用地址了
){
	$error_logs[] = array(
		'recipient_addr_required',
		t('收件人| 地址欄位沒有填'),
		2, // 第幾步驟
	);
	$step2_javascript_evals[] = '$("select[name=recipient_addr_county]").addClass("error");';
	$step2_javascript_evals[] = '$("select[name=recipient_addr_district]").addClass("error");';
	$step2_javascript_evals[] = '$("input[name=recipient_addr]").addClass("error");';
}
