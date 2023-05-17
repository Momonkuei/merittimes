<?php
header("Content-Type:text/html; charset=utf-8");
include 'layoutv3/init.php';

if(!empty($_GET)){
    $account=$_GET['d'];
    $salt=explode(',',$_GET['s']);
    $id=$salt[1];
    $salt=$salt[0];
    $member_data=$this->cidb->where('id',$id)->where('salt',$salt)->get('customer')->row_array();
    if(!empty($member_data)){
        if($member_data['is_enable']==1){
            echo "
				<meta http-equiv='content-type' content='text/html; charset=utf-8'>
				<script>
					alert('請勿重複驗證!');
					window.location.href='/guestlogin_".$this->data['ml_key'].".php';
				</script>";   
            die;
        }else{
            if(md5($member_data['login_account'])!=$account){
                echo '帳號驗證錯誤!';
                die;
            }else{
               $array=array('is_enable'=>1,'sms_time'=>date('Y-m-d H:i:s'),);
               $this->cidb->where('id',$id);
               $this->cidb->update('customer',$array);  
               echo "
				<meta http-equiv='content-type' content='text/html; charset=utf-8'>
				<script>
					alert('驗證通過，請登入帳號');
					window.location.href='/guestlogin_".$this->data['ml_key'].".php';
				</script>";   
            }
        }
    }else{
        echo '404';
        die;
    }
}
?>
