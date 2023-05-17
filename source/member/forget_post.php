<?php

if($_POST and !empty($_POST)){
	$post = $_POST;
	if($post['captcha'] != Yii::app()->session['captcha']){

	// 如果成功，就清session，很重要哦
	Yii::app()->session['captcha'] = '';

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript">
	alert('<?php echo t('驗證碼錯誤','tw')?>');
	window.location.href='memberforget_<?php echo $this->data['ml_key']?>.php';
</script>
<?php
		die;
	}

	// 如果成功，就清session，很重要哦
	Yii::app()->session['captcha'] = '';

	$random_hash = substr(md5(uniqid(rand(), true)), 16, 16);

	// 不管是註冊、或是重寄驗證信件，都會重新找驗證碼
	$row = $this->db->createCommand()->from('customer')
	->where('is_enable =1 and login_account=:account', array(':account' => $post['login_account']))
	->queryRow();

	if($row and isset($row['id'])){
	} else {
		$redirect_url = 'memberforget_'.$this->data['ml_key'].'.php';
		G::alert_and_redirect(t('帳號不存在','tw'), $redirect_url, $this->data);
		die;
	}

	//會員登入型態
	unset($_constant);
	eval('$_constant = CUSTOMER_LOGIN_TYPE'.';');

	if($_constant=='phone'){
		//避免過度發送驗證簡訊
		$_now_time = strtotime('-3 minute',time());
		$_check_time = date('Y-m-d H:i:s',$_now_time);
		if($row['sms_time'] > $_check_time ){
			$redirect_url = 'memberforget_'.$this->data['ml_key'].'.php';
			$_last_time = strtotime($row['sms_time']) - $_now_time ;
			G::alert_and_redirect(t('請勿過度簡訊驗證，等待時間剩餘 :'.$_last_time.' 秒','tw'), $redirect_url, $this->data,true);
			die;
		}
	}

	$empty_orm_data = array(
		'table' => 'customer',
		//'created_field' => 'create_time', 
		'updated_field' => 'update_time',
		'primary' => 'id',
		'rules' => array(
			array('login_account', 'required'),
		),
	);

	$update = array(
		'passforgetcheck' => $random_hash,
	);

	$orm = new gorm($this->cidb, $empty_orm_data);
	$orm->data($update);
	$orm->find_by_id($row['id']);
	$status = $orm->validate(); // 回傳true或false
	$logs = $orm->message();
	$status = $orm->update(); // 回傳更新狀態
	$count = $db->affected_rows();



if($_constant=='email' or $_constant=='account'){

	$to = $row['login_account'];

	// 信件格式
	$emailformat = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and other1=:topic',array(':topic'=>'密碼重設',':type'=>'emailformat',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryRow();

	// 主旨
	$subject = $this->data['sys_configs']['admin_title'].' 密碼重設申請';

	if($emailformat and isset($emailformat['id']) and $emailformat['topic'] != ''){
		$email_topic = $emailformat['topic'];
		$email_topic = str_replace('{AA}', $this->data['sys_configs']['admin_title'], $email_topic);
		// 記得最後要加上這一行，把多餘的額外欄位刪掉
		for($x=65;$x<=(65+26);$x++) $email_topic = str_replace('{'.chr($x).'}', '', $email_topic);
		$subject = $email_topic;
	}

	// $aaa_url = aaa_url; // #32089
	$aaa_url = FRONTEND_DOMAIN;
	$aaa_name = $row['name'];
	$aaa_admin_title = $this->data['sys_configs']['admin_title'];


	// $body = '親愛的會員 $aaa_name 您好，'."\n\n";
	// $body .= '我們收到您在 '.$aaa_admin_title.' 的密碼重設申請，'."\n";
	// $body .= '請進入下面的連結開始進行密碼重設，'."\n\n";
	// $body .= $aaa_url.'/memberforgetconfirm_'.$this->data['ml_key'].'.php?e='.$random_hash."\n\n";
	// $body .= '如果您無法點選以上連結，請將上方的連結複製，並到您的瀏灠器的網址列 貼上，執行 (Enter)'."\n\n";
	// $body .= '若您已完成確認作業，請忽略本通知勿需作任何處理。'."\n";
	// $body .= '如果您沒有重設密碼，或有其他任何問題，請聯絡我們。'."\n\n";
	// $body .= $aaa_admin_title."\n";

	$bodytext = '<p>我們收到您在 '.$aaa_admin_title.' 的密碼重設申請，'."</p>";
	$bodytext .= '<p>請進入下面的連結開始進行密碼重設，'."</p>";
	$bodytext .= '<p><a href="'.$aaa_url.'/memberforgetconfirm_'.$this->data['ml_key'].'.php?e='.$random_hash.'">'.$aaa_url.'/memberforgetconfirm_'.$this->data['ml_key'].'.php?e='.$random_hash."</a></p>";
	$bodytext .= '<p>如果您無法點選以上連結，請將上方的連結複製，並到您的瀏灠器的網址列 貼上，執行 (Enter)'."</p>";
	$bodytext .= '<p>若您已完成確認作業，請忽略本通知勿需作任何處理。'."</p>";
	$bodytext .= '<p>如果您沒有重設密碼，或有其他任何問題，請聯絡我們。'."</p>";

	$body='<body style="padding: 0; margin: 0;">

	<div style="width:640px;margin:0 auto 30px auto;"><img src="cid:logo" alt=""></div>
  
	<div style="width:640px;margin:0 auto;font-family:"PingFang TC","\005fae\008edf\006b63\009ed1\009ad4","Microsoft JhengHei","Helvetica Neue",Helvetica,Arial,sans-serif;">
  
	  <table style="margin-bottom:12px;width:100%;border-collapse:collapse;border-spacing:0;border:1px solid #eaeaea">
		<thead>
		  <tr>
			<th style="padding:4px;background-color:#f5a623;color:#ffffff;border-bottom:1px solid #eaeaea;letter-spacing:3px">忘記密碼通知函</th>
		  </tr>
		</thead>
		<tbody>
		  <tr>
			<td style="padding:16px">
					<p style="margin:0 0 16px 0">親愛的&nbsp;'.$aaa_name.'&nbsp;您好：</p>
					'.$bodytext.'
			</td>
		  </tr>
		</tbody>
	  </table>
  
	  <table style="margin-bottom:12px;width:100%;border:1px solid #d9d9d9;background-color:#f4f4f4">
		<tbody>
		  <tr>
			<td style="padding:6px 12px;color:#e00">
			  ＊此郵件是系統自動發送，請勿直接回覆此郵件！
			</td>
		  </tr>
		  <tr>
			<td style="padding:0 12px 12px 12px">
			  若您對我們的服務有任何疑問，您可利用線上客服 <a style="color:#06c" href="'.FRONTEND_DOMAIN.'/contact_'.$this->data['ml_key'].'.php" target="_blank">'.FRONTEND_DOMAIN.'/contact_'.$this->data['ml_key'].'.php</a> 與我們連絡，<br>
			  或直接E-Mail至客服信箱 <a style="color:#06c" href="mailto:'.$this->data['sys_configs']['service_admin_mail'].'" target="_blank">'. $this->data['sys_configs']['service_admin_mail'].'</a> 告訴我們您的需求。
			</td>
		  </tr>
		</tbody>
	  </table>
  
	</div>
  
	<p style="color:#666; font-size:12px; text-align:center; margin-top:30px;">Copyright © '.date('Y').' '.$this->data['sys_configs']['admin_title_'.$this->data['ml_key']].' All Rights Reserved.</p>
  
  </body>';

	// if($emailformat and isset($emailformat['id']) and $emailformat['detail'] != ''){
	// 	$email_content = $emailformat['detail'];

	// 	$email_content = str_replace('{AA}', $this->data['sys_configs']['admin_title'], $email_content);
	// 	$email_content = str_replace('{BB}', $aaa_name, $email_content);
	// 	$email_content = str_replace('{CC}', $aaa_url, $email_content);
	// 	$email_content = str_replace('{DD}', $random_hash, $email_content);

	// 	// 記得最後要加上這一行，把多餘的額外欄位刪掉
	// 	for($x=65;$x<=(65+26);$x++) $email_content = str_replace('{'.chr($x).'}', '', $email_content);

	// 	$body = $email_content;
	// }

	$ml_key = $this->data['ml_key'];

	$body_html = <<<XXX
<style type="text/css">
.member_mail { font-size: 16px; width: 745px; padding: 30px 65px 65px; margin: 75px auto; border: 3px solid #4562a6;}
.member_mail a { color: #9AB4F0; text-decoration: underline; }
.member_mail img.toplogo { margin-left: -14px; }
.member_mail .tit { font-size: 22px; border-left: 9px solid #dbdbdb; padding-left: 12px; margin-left: -12px;}
.member_mail h1 { color: #000; font-size: 16px; line-height: 38px; margin: 45px 10px 5px; }
.member_mail h2 { color: #4562a6; font-size: 16px; line-height: 30px; margin: 21px 10px 5px; }

</style>

$body
XXX;

	// if($emailformat and isset($emailformat['id'])){
	// 	if($emailformat['field_tmp'] != ''){
	// 		$email_html_content = $emailformat['field_tmp'];

	// 		$email_html_content = str_replace('{AA}', $this->data['sys_configs']['admin_title'], $email_html_content);
	// 		$email_html_content = str_replace('{BB}', $aaa_name, $email_html_content);
	// 		$email_html_content = str_replace('{CC}', $aaa_url, $email_html_content);
	// 		$email_html_content = str_replace('{DD}', $random_hash, $email_html_content);

	// 		// 記得最後要加上這一行，把多餘的額外欄位刪掉
	// 		for($x=65;$x<=(65+26);$x++) $email_html_content = str_replace('{'.chr($x).'}', '', $email_html_content);

	// 		$body_html = $email_html_content;
	// 	} elseif($emailformat['field_tmp'] == '' and $emailformat['detail'] != ''){
	// 		$body_html = nl2br($email_content);
	// 	}
	// }

	// 找一下寄件人有沒有設定
	$from = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_home=1',array(':type'=>'email',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryRow();

	// 找一下收件人有沒有設定
	//$tos = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_news=1',array(':type'=>'email',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();

	if(isset($this->data['sys_configs']['smtp_ssl']) and $this->data['sys_configs']['smtp_ssl'] == 'sendmail'){
		$this->email_send_to_by_sendmail($from,array(array('name'=>'','email'=>$to)), $subject, $body, $body_html,null);
	} else {
		$this->email_send_to_v2($from,array(array('name'=>'','email'=>$to)), $subject, $body, $body_html,null);
	}
}elseif($_constant=='phone'){	

	//使用tinyurl.com縮短網址
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, 'https://tinyurl.com/api-create.php?url='.urlencode(FRONTEND_DOMAIN.'/memberforgetconfirm_'.$this->data['ml_key'].'.php?e='.$random_hash));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$_reset_url_code = curl_exec($ch);
	curl_close($ch);

	include _BASEPATH.'/config/sms.php';

	$url = $_sms_url;
	$sms_key = $_sms_key;
	$cust_domain = $_cust_domain;


	$subject = '忘記密碼連結寄發 '.$post['login_account'];
	$content = '重設密碼連結 '.$_reset_url_code;
	$mobile = $post['login_account'];
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
		$sendtime = date('Y-m-d H:i:s');
		$this->cidb->where('login_account',$row['login_account'])->update('customer',array('sms_time'=>$sendtime));
	//     $redirect_url = 'memberverification_'.$this->data['ml_key'].'.php';
	// 	G::alert_and_redirect(t('已發送簡訊到手機，請輸入簡訊驗證碼','tw'), $redirect_url, $this->data,true); // current sample
	// 	die;
	} else {            
	// 	// var_dump($code);die;
	    $redirect_url = 'memberforget_'.$this->data['ml_key'].'.php';
	    G::alert_and_redirect(t('簡訊發送失敗','tw'), $redirect_url, $this->data);
	    die;
	}

}

	$redirect_url = 'memberforget_'.$this->data['ml_key'].'.php';
	G::alert_and_redirect(t('己送出密碼修改申請'), $redirect_url, $this->data);
	die;
} // POST結束


// if(isset($layoutv3_struct_map_keyname['v3/sub_page_title'][0])){
// 	$data[$layoutv3_struct_map_keyname['v3/sub_page_title'][0]] = array(
// 		'name' => '查詢密碼',
// 		'sub_name' => 'password assistance',
// 	);
// }
// 
// if(isset($layoutv3_struct_map_keyname['v3/breadcrumb'][0])){
// 	$data[$layoutv3_struct_map_keyname['v3/breadcrumb'][0]] = array(
// 		array('name' => 'HOME', 'url' => '/'),
// 		array('name' => '密碼查詢', 'url' => 'memberforget.php')
// 	);
// }
