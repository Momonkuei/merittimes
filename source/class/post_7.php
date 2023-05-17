<?php
if(empty($_SESSION['member_data'])){
	echo "<script>alert('請先登入');window.location.href='/guestlogin_".$this->data['ml_key'].".php';</script>";
}
if($_SESSION['member_data']['member_grade']==1){
	echo "<script>alert('代表窗口請至總覽頁面操作');window.location.href='/apply_".$this->data['ml_key']."_4.php';</script>";
}
//帳號資料
$class_account=$this->cidb->where('id',$_SESSION['member_data']['id'])->get('customer')->row_array();

//班級資料
$class_data=$this->cidb->where('id',$_SESSION['member_data']['class_id'])->get('writeplan_class')->row_array();

if(!empty($_POST)){
	$register_data=array(
		'name'=>$_POST['name'],	
	);
	if(!empty($_POST['password'])){
		if($_POST['password']!=$_POST['password2']){
			echo "
				<meta http-equiv='content-type' content='text/html; charset=utf-8'>
				<script>
					alert('重複密碼輸入錯誤!');
					window.location.href='/apply_".$this->data['ml_key']."_7.php';
				</script>";
			die;
		}
		$password=md5($_POST['password']);
		$register_data['login_password']=$password;
	}
	$this->cidb->where('id',$_SESSION['member_data']['id']);
	$this->cidb->update('customer',$register_data); 
	if(isset($_POST['is_enable'])){
		$this->cidb->where('id',$class_data['id']);
		$this->cidb->update('writeplan_class',array('is_enable'=>$_POST['is_enable'])); 
	}
	echo "
		<meta http-equiv='content-type' content='text/html; charset=utf-8'>
		<script>
			alert('資料修改成功!');
			window.location.href='class_".$this->data['ml_key']."_7.php';
		</script>";
}
?>

