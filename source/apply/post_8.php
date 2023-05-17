<?php
if(empty($_SESSION['member_data'])){
	echo "<script>alert('請先登入');window.location.href='/guestlogin_".$this->data['ml_key'].".php';</script>";
}
if($_SESSION['member_data']['member_grade']!=1){
	echo "<script>alert('師生成員請至班級頁面操作');window.location.href='/class_".$this->data['ml_key']."_1.php';</script>";
}
//註冊資料
$member_array=$this->cidb->where('id',$_SESSION['member_data']['id'])->where('is_enable',1)->get('customer')->row_array();
//學期資料
if(!empty($member_array['addr'])){
	$address=explode('_',$member_array['addr']);
}

if(!empty($_POST)){
	// print_r($_POST);die;	
	$_SESSION['apply_register']=$_POST;
	$check_array = array('school_name', 'school_compilation', 'school_type', 'administrative', 'contact_person', 'job_title', 'landline', 'phone', 'email');
	foreach($check_array as $k => $v){
		if(empty($_POST[$v])){
			unset($_POST);
			echo "
				<meta http-equiv='content-type' content='text/html; charset=utf-8'>
				<script>
					alert('資料未填寫!');
					window.location.href='/apply_".$this->data['ml_key']."_8.php';
				</script>";
		}
	}
	//地址拼湊
	$address=$_POST['postal'].'_'.$_POST['county'].'_'.$_POST['street'].'_'.(!empty($_POST['part'])?$_POST['part']:'no').'_'.(!empty($_POST['lane'])?$_POST['lane']:'no').'_'.(!empty($_POST['alley'])?$_POST['alley']:'no').'_'.(!empty($_POST['no_of'])?$_POST['no_of']:'no').'_'.(!empty($_POST['no_of2'])?$_POST['no_of2']:'no').'_'.(!empty($_POST['lou_of'])?$_POST['lou_of']:'no').'_'.(!empty($_POST['lou_of2'])?$_POST['lou_of2']:'no').'_'.(!empty($_POST['other'])?$_POST['other']:'no');
	if(!empty($_POST['password'])){
		//ˋ密碼加密 拉原本註冊功能的方法
		$post['salt'] = G::GeraHash(10);
		$password = '{GGG3AAA}'.str_replace('a','ɢ', sha1(G::utf8_strrev($_POST['password'].$post['salt'])));
	}
	

	$register_data=array(
		'school_name'=>$_POST['school_name'],
		'other2'=>$_POST['school_compilation'],
		'other3'=>$_POST['school_type'],
		'other4'=>$_POST['administrative'],
		'addr'=>$address,
		'name'=>$_POST['contact_person'],
		'jobtitle'=>$_POST['job_title'],
		// 'salt'=>$post['salt'],
		// 'login_password'=>$password,
		'phone'=>$_POST['landline'],
		'p_extension'=>$_POST['extension'],
		'mobile'=>$_POST['phone'],
		'line_id'=>$_POST['line_id'],
		'fax'=>$_POST['fax'],
		'email'=>$_POST['email'],
	);
	if(!empty($_POST['password'])){
		$register_data['salt']=$post['salt'];
		$register_data['login_password']=$password;
	}
	
	$this->cidb->where('id',$_SESSION['member_data']['id']);
	$this->cidb->update('customer',$register_data); 
	$_SESSION['member_data']['name']=$_POST['contact_person'];
	$_SESSION['member_data']['school_name']=$_POST['school_name'];
	$_SESSION['member_data']['jobtitle']=$_POST['job_title'];
		echo "
			<meta http-equiv='content-type' content='text/html; charset=utf-8'>
			<script>
				alert('資料修改成功!');
				window.location.href='/apply_".$this->data['ml_key']."_8.php';
			</script>";
	
}
?>

