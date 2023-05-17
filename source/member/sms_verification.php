<?php
//會員登入型態
unset($_constant);
eval('$_constant = CUSTOMER_LOGIN_TYPE'.';');

if($_constant=='phone'){
	if(empty($_POST)){
		if(isset($_SESSION['authw_admin_account']) or isset($_SESSION['authw_admin_account_verification'])){
			if(isset($_SESSION['authw_admin_account'])){
				$login_account = $_SESSION['authw_admin_account'];
			}elseif(isset($_SESSION['authw_admin_account_verification'])){
				$login_account = $_SESSION['authw_admin_account_verification'];
			}
			if(isset($_SESSION['authw_admin_name'])){
				$admin_name = $_SESSION['authw_admin_name'];
			}elseif(isset($_SESSION['authw_admin_name_verification'])){
				$admin_name = $_SESSION['authw_admin_name_verification'];
			}			


			$row = $this->cidb->where('login_account',$login_account)->get('customer')->row_array();
			if($row['is_sms']==1){
				$redirect_url = 'index_'.$this->data['ml_key'].'.php';
				G::alert_and_redirect(t('您已通過簡訊驗證','tw'), $redirect_url, $this->data,true);
				die;
			}

			if(isset($_GET['resend'])){
				$_now_time = strtotime('-1 minute',time());
				$_check_time = date('Y-m-d H:i:s',$_now_time);
				if($row['sms_time'] > $_check_time ){
					$redirect_url = 'memberverification_'.$this->data['ml_key'].'.php';
					$_last_time = strtotime($row['sms_time']) - $_now_time ;
					G::alert_and_redirect(t('請勿過度簡訊驗證，等待時間剩餘 :'.$_last_time.' 秒','tw'), $redirect_url, $this->data,true);
					die;
				}

				$sms_verification = '';$word='0123456789';$len = strlen($word);
			    for ($i = 0; $i < 4; $i++) {
			        $sms_verification .= $word[rand() % $len];
			    }		
				$sendtime = date('Y-m-d H:i:s');
				$this->cidb->where('login_account',$login_account)->update('customer',array('sms_text'=>$sms_verification,'sms_time'=>$sendtime));

				include _BASEPATH.'/config/sms.php';
				
				$url = $_sms_url;
				$sms_key = $_sms_key;
				$cust_domain = $_cust_domain;

				$subject = '驗證會員手機 '.$login_account;
				$content = $admin_name.'您好，您的驗證碼為 '.$sms_verification;
				$mobile = $login_account;
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
		        if (isset($code[1]) && $code[1] == "00000") {
		            $redirect_url = 'memberverification_'.$this->data['ml_key'].'.php';
					G::alert_and_redirect(t('已發送簡訊到手機，請輸入簡訊驗證碼','tw'), $redirect_url, $this->data,true); // current sample
					die;
		        } else {            
		        	// var_dump($code);die;
		            $redirect_url = 'memberverification_'.$this->data['ml_key'].'.php';
		            G::alert_and_redirect(t('簡訊發送失敗','tw'), $redirect_url, $this->data);
		            die;
		        }
			}
		}else{
			$redirect_url = 'guestlogin_'.$this->data['ml_key'].'.php';
			G::alert_and_redirect(t('請先登入','tw'), $redirect_url, $this->data,true);
			die;
		}		
	}else{
		//驗證簡訊碼
		$_code = $_POST['sms_verification'];

		if(isset($_SESSION['authw_admin_account'])){
			$login_account = $_SESSION['authw_admin_account'];
		}elseif(isset($_SESSION['authw_admin_account_verification'])){
			$login_account = $_SESSION['authw_admin_account_verification'];
		}

		$row = $this->cidb->where('login_account',$login_account)->where('sms_text',$_code)->get('customer')->row_array();
		if($row){
			//驗證成功，直接登入
			Yii::app()->session->add('authw_admin_id', $row['id']);  
			Yii::app()->session->add('authw_admin_account', $row['login_account']);  
			Yii::app()->session->add('authw_admin_name', $row['name']); 
			//更新資料
			$this->cidb->where('login_account',$login_account)->update('customer',array('sms_text'=>'','is_sms'=>1));

			// 購物站的加入會員後，才會寄信，而形象站不會
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
						'name' => '使用者帳號(手機)',
						'value' => $row['login_account'],
						'style' => '',
					),
					array(
						'name' => '會員姓名',
						'value' => $row['name'],
						'style' => '',
					),
					array(
						'name' => 'E-Mail',
						'value' => $row['email'],
						'style' => '',
					),
				);
				
				//因為信件通知從會員註冊那邊copy的，要帶入這個變數
				$savedata = array();
				$savedata['name'] = $row['name'];

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
				// if(defined('CC_MAIL_OPEN') && CC_MAIL_OPEN==true){
					// $cc_mail = $row['email'];
				// } else {
					$cc_mail = NULL;
				// }

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
				if($row['email']!=''){
					$tos = array(
						array(
							'id' => '',
							'name' => $row['name'],
							// 'email' => $row['login_account'],
							'email' => $row['email'],
						),
					);
				}
				

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

			$redirect_url = 'membercenter_'.$this->data['ml_key'].'.php';
		    G::alert_and_redirect(t('驗證成功','tw'), $redirect_url, $this->data);
		    die;
		}else{
			$redirect_url = 'memberverification_'.$this->data['ml_key'].'.php';
		    G::alert_and_redirect(t('驗證碼錯誤','tw'), $redirect_url, $this->data);
		    die;
		}
	}	
}else{
	header('HTTP/1.1 404 Not Found');
	die;
}

