<?php
$company_member_result = $this->cidb->where('keyname','function_constant_company_member')->get('sys_config')->row_array();
$company_member_style=$company_member_result["keyval"];
if(!empty($_POST)){

	//會員登入型態
	unset($_constant);
	eval('$_constant = CUSTOMER_LOGIN_TYPE'.';');

	
	if($_constant=='email'){
		// 2018-03-27 電子信箱的在次驗證
		if (isset($_POST['login_account'])){
			if(filter_var($_POST['login_account'], FILTER_VALIDATE_EMAIL)) {
				// do nothing
			} else {
				$redirect_url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php?status=2';
			 	G::alert_captcha(t('Incorrent format `Email`','en'), $redirect_url, $this->data);
			}
		}

		$_login_account_text = t('此Email己被註冊過','tw');
	}elseif($_constant=='phone'){
		//手機號碼的驗證
		if (isset($_POST['login_account'])){
			if((!preg_match("/^[0][1-9]{1,3}[0-9]{6,8}$/", $_POST['login_account']) || strlen($_POST['login_account']) < 10 || strlen($_POST['login_account']) > 11)) {		
			
				$redirect_url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php?status=2';
			 	G::alert_captcha(t('Incorrent format `Phone`','en'), $redirect_url, $this->data);
			}
		}
		$_login_account_text = t('此手機己被註冊過','tw');
	}
	

	// 檢查是否有人申請過
	$row = $this->cidb->where('login_account',$_POST['login_account'])->get('customer')->row_array();
	if($row and isset($row['id'])){
		$redirect_url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php?status=2';
		G::alert_captcha($_login_account_text, $redirect_url, $this->data);
	}

	if(!isset($_POST['accept_privacy']) or $_POST['accept_privacy'] != 1){
		$redirect_url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php?status=2';
		G::alert_captcha(t('請同意隱私權政策','tw'), $redirect_url, $this->data);
	}

	// 2018-04-09 新增gtoken的檢查，下午有給李哥看過這個功能
	if(!isset($_POST['gtoken']) or $_POST['gtoken'] == '' or !isset(Yii::app()->session['gtoken']) or Yii::app()->session['gtoken'] == '' or Yii::app()->session['gtoken'] != $_POST['gtoken']){
		$redirect_url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php';
		//G::alert_and_redirect(G::t(null,'驗證碼錯誤'), $redirect_url, $this->data); // current sample
			G::alert_captcha(t('Incorrent token, please contact administrator','en'), $redirect_url, $this->data);
	}

	// if(!isset($_POST['captcha']) or Yii::app()->session['captcha'] != $_POST['captcha']){ // 疑似有問題 2017-08-28下午發現的
	if(!isset($_POST['captcha']) or $_POST['captcha'] == '' or !isset(Yii::app()->session['captcha']) or Yii::app()->session['captcha'] == '' or Yii::app()->session['captcha'] != $_POST['captcha']){
		$redirect_url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php?status=2';
		//G::alert_and_redirect(G::t(null,'驗證碼錯誤'), $redirect_url, $this->data); // current sample
		G::alert_captcha(t('驗證碼失效，請重新整理'), $redirect_url, $this->data); // iframe sample
		//#38830
	}
	if ($company_member_style=="true" && $_POST['other1'] == '2') {
        
        if (!isset($_POST['other2']) || $_POST['other2'] == '') {
            $redirect_url = $this->data['router_method'] . '_' . $this->data['ml_key'] . '.php?status=2';
            // $_login_account_text = t('請輸入統編','tw');
            G::alert_captcha(t('請輸入統編'), $redirect_url, $this->data); // iframe sample
        }
        if (!isset($_POST['other4']) || $_POST['other4'] == '') {
            $redirect_url = $this->data['router_method'] . '_' . $this->data['ml_key'] . '.php?status=2';
            // $_login_account_text = t('請輸入網站連結','tw');
            G::alert_captcha(t('輸入網站連結'), $redirect_url, $this->data);
        }
        if (!isset($_POST['other3']) || $_POST['other3'] == '') {
            $redirect_url = $this->data['router_method'] . '_' . $this->data['ml_key'] . '.php?status=2';
            // $_login_account_text = t('請輸入企業介紹','tw');
            G::alert_captcha(t('請輸入企業介紹'), $redirect_url, $this->data);
        }
        if (!isset($_FILES["file1"]) || $_FILES["file1"] == '') {
            $redirect_url = $this->data['router_method'] . '_' . $this->data['ml_key'] . '.php?status=2';
            // $_login_account_text = t('請輸入企業介紹','tw');
            G::alert_captcha(t('請上傳LOGO'), $redirect_url, $this->data);
        }
    }
	// 安全性
	Yii::app()->session['captcha'] = '';
	$_POST['captcha'] = '';
/*
     * 一張圖片
     * 附加檔案上傳
     * 
     * 有要使用的話，在打開
     * 預設關掉的
     */
    if ($company_member_style=="true" && $_POST['other1'] == '2') {
        // print_r($_FILES["file1"]);die;
        $target_dir = '_i/assets/upload/' . str_replace('_', '', $this->data['router_method']) . '/';
        $target_file = $target_dir . basename($_FILES["file1"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
        // Check if image file is a actual image or fake image
        if (isset($_FILES["file1"])) {
            $check = getimagesize($_FILES["file1"]["tmp_name"]);
            if ($check !== false) {
                //echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
                G::alert_and_redirect(G::t(null, '請上傳圖片檔案jpg或png格式。'), $redirect_url, $this->data);
            }
        }
        // Check file size
        if ($_FILES["file1"]["size"] > 5000000) {
            $uploadOk = 0;
            G::alert_and_redirect(G::t(null, 'Sorry, your file is too large.'), $redirect_url, $this->data);
        }
        //Allow certain file formats
        if (
            strtolower($imageFileType) != "jpg" &&
            strtolower($imageFileType) != "png" &&
            strtolower($imageFileType) != "jpeg" 
        ) {
            G::alert_and_redirect(G::t(null, '請上傳圖片檔案jpg或png格式。'), $redirect_url, $this->data);
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            G::alert_and_redirect(G::t(null, 'Sorry, your file was not uploaded.'), $redirect_url, $this->data);
            $uploadOk = 0;
            // if everything is ok, try to upload file
        } else {
            $target_dir = "_i/assets/upload/customer/" ;
            $target_file = $target_dir . date('Y-m-d-H-i-s-') . basename($_FILES["file1"]["name"]);
            // print_r($target_file);die;
            if (move_uploaded_file($_FILES["file1"]["tmp_name"], $target_file)) {
                // print_r(move_uploaded_file($_FILES["file1"]["tmp_name"], $target_file));die;
                // 含相對路徑的檔名
                // $_POST['file1'] = $target_file;
                // 上傳後台單檔上傳的格式(只有檔名，沒有路徑)
                $_POST['file1'] = str_replace($target_dir,'',$target_file);
            } else {
                // print_r(move_uploaded_file($_FILES["file1"]["tmp_name"], $target_file));die;
                G::alert_and_redirect(G::t(null, 'Sorry, there was an error uploading your file.'), $redirect_url, $this->data);
            }
        }
    }
	$savedata = $_POST;

	if($company_member_style=="true" && $savedata['other1'] == '2') {
        $savedata['is_enable'] = 0;
    } 
	else {
        $savedata['is_enable'] = 1;
    }

	if($_constant=='email'){
		$savedata['email'] = $savedata['login_account'];
	}elseif($_constant=='phone'){
		$savedata['mobile'] = $savedata['login_account'];
	}


	unset($_constant);
	eval('$_constant = '.strtoupper('customer_password_encrypt_type').';');
	if($_constant == '0'){
		// do nothing
	} elseif($_constant == '1'){
		$savedata['login_password'] = sha1($savedata['login_password']);
	} elseif($_constant == '2'){
		$savedata['salt'] = G::GeraHash(10);
		$savedata['login_password'] = '{GGG3AAA}'.str_replace('a','ɢ', sha1(G::utf8_strrev($savedata['login_password'].$savedata['salt'])));
	}

	// 如果是用Social登入的話
	if(isset($savedata['_social_type']) and $savedata['_social_type'] != ''){
		if($savedata['_social_type'] == 'facebook'){
			$savedata['facebook_id'] = $savedata['_social_id'];
		} elseif($savedata['_social_type'] == 'google'){
			$savedata['googleplus_id'] = $savedata['_social_id'];
		} elseif($savedata['_social_type'] == 'line'){ // 2019/5/6 by lota
			$savedata['line_id'] = $savedata['_social_id'];
		}
	}

	// #40983
	// 這裡A方案的部份可能會用得到
	// $savedata['addr_county'] = $savedata['county'];
	// $savedata['addr_district'] = $savedata['district'];
	// $savedata['addr_zipcode'] = $savedata['zipcode'];

	$empty_orm_data = array(
		'table' => 'customer',
		'created_field' => 'create_time', 
		//'updated_field' => 'update_time',
		'primary' => 'id',
		'rules' => array(
			// array('name,email', 'required'),
			//array('name,email,login_account,login_password', 'required'),
			array('name,login_account,login_password', 'required'),
		),
	);

	$orm = new gorm($this->cidb, $empty_orm_data);
	$orm->data($savedata);
	$status = $orm->validate(); // 回傳true或false

	if($status === false){
		// var_dump($orm->message());
		$redirect_url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php';
		G::alert_captcha(t('欄位資料驗證失敗','tw'), $redirect_url, $this->data);
	}

	$status = $orm->insert(); // 回傳寫入狀態
	$id = $db->insert_id();

	if($status === false){
		$redirect_url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php';
		G::alert_captcha(t('寫入失敗','tw'), $redirect_url, $this->data);
	}

	// 2020-06-11
	// Rigo發現的，為了避免用到別人已經刪除的資料的問題
	$this->cidb->delete('html', array('type'=>'favorite','member_id'=>$id)); 
	$this->cidb->delete('customer_address', array('customer_id'=>$id)); 
	// echo $this->cidb->affected_rows();

	//會員登入型態
	unset($_constant);
	eval('$_constant = CUSTOMER_LOGIN_TYPE'.';');
	if ($savedata['other1'] == '1') {
		if($_constant!='phone'){
			Yii::app()->session->add('authw_admin_id', $id);  
			Yii::app()->session->add('authw_admin_account', $savedata['login_account']);  
			Yii::app()->session->add('authw_admin_name', $savedata['name']); 
		}else{
			Yii::app()->session->add('authw_admin_account_verification', $savedata['login_account']); 
			Yii::app()->session->add('authw_admin_name_verification', $savedata['name']);
		}
	}

	/*
	 * 2020-05-21
	 * 檢查我的收藏
	 * 李哥說要加的
	 */
	if(isset($_SESSION['save']['shop_favorite']) and !empty($_SESSION['save']['shop_favorite'])) {
		foreach($_SESSION['save']['shop_favorite'] as $k => $v){
			// 先看有沒有(此時不管時間)
			$row2 = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and member_id=:member_id and other1="'.$k.'"',array(':member_id'=>$id,':type'=>'favorite',':ml_key'=>$this->data['ml_key']))->queryRow();
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
					'member_id' => $id,
				);
				$this->cidb->insert('html', $save); 
			}
		}
		unset($_SESSION['save']['shop_favorite']);
	}

	// $_SESSION['save'][$this->data['router_method']] = array();
	// unset($_SESSION['save'][$this->data['router_method']]);
	// unset(Yii::app()->session['save']);

	//會員登入型態
	unset($_constant);
	eval('$_constant = CUSTOMER_LOGIN_TYPE'.';');
	if ($savedata['other1'] == '1') {
		if($_constant=='email'){
			// 2020-06-17 購物站的加入會員後，才會寄信，而形象站不會
			unset($_constant);
			eval('$_constant = '.strtoupper('shop_open').';');
			if($_constant){
				// 寄件人、網站管理者Mail
				$to = $this->data['sys_configs']['service_admin_mail'];

				// 主旨
				$subject2 = '加入會員成功通知函'; // 預設值
				$subject = $this->data['sys_configs']['admin_title'].' '.$subject2;

				$aaa_url = aaa_url;
				$aaa_name = $this->data['sys_configs']['admin_title'];
				$no_reply = t('此信為系統發出，請勿回覆');

				$body = '';
				$body .= $no_reply."\n\n";

				$form_fields = array(
					array(
						'name' => '註冊日期',
						'value' => date('Y-m-d'),
						'style' => '',
					),
					array(
						'name' => '使用者名稱',
						'value' => $savedata['login_account'],
						'style' => '',
					),
					array(
						'name' => '會員姓名',
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
				$body_html .= ob_get_clean();

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
						// 'email' => $savedata['login_account'],
						'email' => $savedata['email'],
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

			} // 購物站的加入會員後，才會寄信，而形象站不會

			$redirect_url = 'index_'.$this->data['ml_key'].'.php';
			G::alert_and_redirect(t('己加入會員','tw'), $redirect_url, $this->data,true); // current sample
			die;
		}
		else if($_constant=='phone'){		
			//發送簡訊驗證，使用K1簡訊計費系統 https://sms_system.show.buyersline.com.tw/K1/login.php
			$sms_verification = '';$word='0123456789';$len = strlen($word);
			for ($i = 0; $i < 4; $i++) {
				$sms_verification .= $word[rand() % $len];
			}		
			$sendtime = date('Y-m-d H:i:s');
			$this->cidb->where('login_account',$savedata['login_account'])->update('customer',array('sms_text'=>$sms_verification,'sms_time'=>$sendtime));

			include _BASEPATH.'/config/sms.php';
		
			$url = $_sms_url;
			$sms_key = $_sms_key;
			$cust_domain = $_cust_domain;

			$subject = '驗證會員手機 '.$savedata['login_account'];
			$content = $savedata['name'].'您好，您的驗證碼為 '.$sms_verification;
			$mobile = $savedata['login_account'];
			$test = $_sms_test_mode;

			if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
				$ip = $_SERVER["HTTP_CLIENT_IP"];
			} elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
				$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			} else {
				$ip = $_SERVER["REMOTE_ADDR"];
			}

			$postdata = http_build_query(
				array(
					'url' => $cust_domain,
					'sms_key' => $sms_key,
					'subject' => $subject,
					'content' => $content,
					'mobile' => $mobile,
					'send_time' => '',//空值為直接寄送
					'ip' => $ip,
					'test' => $test
				)
			);
			$ch = curl_init();
			$options = array(
				CURLOPT_URL => $url,
				CURLOPT_HEADER => 0,
				CURLOPT_VERBOSE => 0,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_USERAGENT => "Mozilla/4.0 (compatible;)",
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => $postdata,
			);
			curl_setopt_array($ch, $options);


			$code=explode('msg',curl_exec($ch));
			curl_close($ch);
			if ($code[1] == "00000") {
				$redirect_url = 'memberverification_'.$this->data['ml_key'].'.php';
				G::alert_and_redirect(t('已發送簡訊到手機，請輸入驗證碼','tw'), $redirect_url, $this->data,true); // current sample
				die;
			} else {            
				// var_dump($code);die;
				$redirect_url = 'memberverification_'.$this->data['ml_key'].'.php';
				G::alert_captcha(t('簡訊發送失敗','tw').'- msg:'.$code, $redirect_url, $this->data);
				die;
			}		
		}
	}
	$redirect_url = 'index_'.$this->data['ml_key'].'.php';
	if ($savedata['other1'] == '2') {
        G::alert_and_redirect(t('已收到您的申請，待審核後，才可登入會員。', 'tw'), $redirect_url, $this->data, true); // current sample
    } else {
        G::alert_and_redirect(t('歡迎加入會員。', 'tw'), $redirect_url, $this->data, true); // current sample
    }
	
} // POST結束

