<?php

if(!empty($_POST)){
	// print_r($_POST);die;	
	$_SESSION['apply_register']=$_POST;
	$check_array = array('school_name', 'school_compilation', 'the_code', 'school_type', 'administrative', 'contact_person', 'job_title', 'account', 'password', 'landline', 'phone', 'email');
	foreach($check_array as $k => $v){
		if(empty($_POST[$v])){
			unset($_POST);
			echo "
				<meta http-equiv='content-type' content='text/html; charset=utf-8'>
				<script>
					alert('資料未填寫!');
					window.location.href='/apply_".$this->data['ml_key']."_11.php';
				</script>";
		}
	}
	//地址拼湊
	$address=$_POST['postal'].'_'.$_POST['county'].'_'.$_POST['street'].'_'.(!empty($_POST['part'])?$_POST['part']:'no').'_'.(!empty($_POST['lane'])?$_POST['lane']:'no').'_'.(!empty($_POST['alley'])?$_POST['alley']:'no').'_'.(!empty($_POST['no_of'])?$_POST['no_of']:'no').'_'.(!empty($_POST['no_of2'])?$_POST['no_of2']:'no').'_'.(!empty($_POST['lou_of'])?$_POST['lou_of']:'no').'_'.(!empty($_POST['lou_of2'])?$_POST['lou_of2']:'no').'_'.(!empty($_POST['other'])?$_POST['other']:'no');

	//ˋ密碼加密 拉原本註冊功能的方法
	$post['salt'] = G::GeraHash(10);
	$password = '{GGG3AAA}'.str_replace('a','ɢ', sha1(G::utf8_strrev($_POST['password'].$post['salt'])));

	$register_data=array(
		'member_grade'=>1,
		'school_name'=>$_POST['school_name'],
		'other2'=>$_POST['school_compilation'],
		'code'=>mb_strtoupper($_POST['the_code']),
		'other3'=>$_POST['school_type'],
		'other4'=>$_POST['administrative'],
		'addr'=>$address,
		'name'=>$_POST['contact_person'],
		'jobtitle'=>$_POST['job_title'],
		'login_account'=>$_POST['account'],
		'salt'=>$post['salt'],
		'login_password'=>$password,
		'phone'=>$_POST['landline'],
		'phone_area'=>$_POST['landline_area'],
		'p_extension'=>$_POST['extension'],
		'mobile'=>$_POST['phone'],
		'line_id'=>$_POST['line_id'],
		'fax'=>$_POST['fax'],
		'fax_area'=>$_POST['fax_area'],
		'email'=>$_POST['email'],
		'is_enable'=>0,
		'update_time'=>date('Y-m-d H:i:s'),
		'create_time'=>date('Y-m-d H:i:s'),
	);
	$this->cidb->insert('customer',$register_data);
	$id = $this->cidb->insert_id();
	if(!empty($id)){
		/*** 寄信區塊*/

        // 找一下寄件人有沒有設定
        $query = $cidb->select('*,topic as name,other1 as email')->where('type','email')->where('is_enable',1)->where('is_home',1)->order_by('sort_id')->get('html');
        $from = $query->row_array();
        $tos=array(
			'name'=>$_POST['contact_person'],
			'email'=>$_POST['email'],
		);
        //網站名稱
        $query = $cidb->select('*')->where('keyname','admin_title')->get('sys_config');
        $web_data = $query->row_array();
        
        $body_html = "  ＊此郵件是系統自動發送，請勿直接回覆此郵件！<br>
                        親愛的 ".$_POST['contact_person']." 您好，<br>
                        以下是您的驗證連結，我們將遵守個人資料隱私權之重要性。<br>
						<a href='https://".$_SERVER['HTTP_HOST']."/registerverify.php?d=".md5($_POST['account'])."&s=".$post['salt'].",".$id."&t=".md5($post['salt'])."' target='_blank'>請點擊此處</a><br>
                        若您有任何疑問，您可透過以下資訊與我們連絡<br>
                        ".$web_data['keyval']."敬上<br>";
						

        $cc_mail = NULL;
        if($from and count($from) > 0 and isset($from['id']) and isset($from['email']) and $tos and count($tos) > 0 and isset($tos[0]['id'])){
            $email_return = email_send_to_by_sendmail($from,$tos, '註冊通知信件', '', $body_html,$cc_mail);               
        }
        //寄信區塊END 
		unset($_POST);
		unset($_SESSION['appapply_registerly_1']);
		echo "
			<meta http-equiv='content-type' content='text/html; charset=utf-8'>
			<script>
				alert('註冊成功!請至註冊信箱點擊驗證信之連結，開啟帳號權限');
				window.location.href='/guestlogin_".$this->data['ml_key'].".php';
			</script>";
	}else{
		unset($_POST);
		echo "
			<meta http-equiv='content-type' content='text/html; charset=utf-8'>
			<script>
				alert('註冊失敗，請從新填寫!');
				window.location.href='/apply_".$this->data['ml_key']."_11.php';
			</script>";
	}
}	



?>

