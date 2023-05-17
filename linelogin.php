<?php

include 'layoutv3/init.php';

include _BASEPATH.'/config/line.php';

if($client_id!='' && $client_secret!=''){

	if(isset($_GET['code']) && $_GET['code']!='' && isset($_GET['state']) && $_SESSION['state_token'] == $_GET['state']){
	
		// 取得 授權後的access_token
		$result = 'grant_type=authorization_code&redirect_uri='.$return_url.'&client_id='.$client_id.'&client_secret='.$client_secret.'&code='.$_GET['code'];
		//傳送
		$url = 'https://api.line.me/oauth2/v2.1/token'; 
		$ch = curl_init(); 
		$timeout = 30; 
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_POST, 1); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type:application/x-www-form-urlencoded")); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $result);//Post提交的數據包
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 
		curl_setopt($ch, CURLOPT_HEADER, 0); 
		$json = curl_exec($ch);
	
		curl_close($ch); 
		
		$result = json_decode($json,true);
		//var_dump($result);	
	
		//=====
		//取得 個人profile 資料
		$url = 'https://api.line.me/v2/profile';
		$ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	
	    $headers = array();
	    $headers[] = "Authorization: Bearer ".$result['access_token'];
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	
	    $output = curl_exec($ch);
	    curl_close($ch);
	
	    $result = json_decode($output,true);

	    if($result == null or !isset($result['userId']) or $result['userId']==''){
		?>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<script type="text/javascript">
				alert('系統異常，請重新操作');
				window.location.href='guestlogin_<?php echo FRONTEND_DEFAULT_LANG?>.php';
			</script>
		<?php
			die;
		}

		$row = $this->cidb->where('is_enable',1)->where('line_id',trim($result['userId']))->get('customer')->row_array();
		if(isset($row) and isset($row['id'])){
			// 底下這一段，是從source/member/login_post.php那邊複製過來的
			Yii::app()->session->add('authw_admin_id', $row['id']);  
			Yii::app()->session->add('authw_admin_account', $row['login_account']);  
			Yii::app()->session->add('authw_admin_name', $row['name']);  

			/*
			 * 檢查我的收藏
			 */
			if(isset($_SESSION['save']['shop_favorite']) and count($_SESSION['save']['shop_favorite']) > 0) {
				foreach($_SESSION['save']['shop_favorite'] as $k => $v){
					// 先看有沒有(此時不管時間)
					//$row2 = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and member_id=:member_id and other1=:id',array(':id'=>$k,':member_id'=>$row['id'],':type'=>'favorite',':ml_key'=>$this->data['ml_key']))->queryRow();
					$row2 = $this->cidb->where('is_enable',1)->where('type','favorite')->where('ml_key',$_SESSION['web_ml_key'])->get('html')->row_array();
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
							'ml_key' => $_SESSION['web_ml_key'],
							'is_enable' => 1,
							'start_date' => $v['add_date'],
							'other1' => $id_tmp[0],
							'other2' => $id_tmp[1],
							'member_id' => $row['id'],
						);
						$this->cidb->insert('html', $save); 
					}
				}
				unset($_SESSION['save']['shop_favorite']);
			}
			?>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<script type="text/javascript">
				alert('己登入');
				window.location.href='index_<?php echo FRONTEND_DEFAULT_LANG?>.php';
			</script>
			<?php
			die;
		}

		// 沒有資料的話導向到註冊頁面，繼續填其它必需要的欄位
		//$_SESSION['save']['guestlogin']['login_account'] = trim($result['email']);
		$_SESSION['save']['guestlogin']['name'] = trim($result['displayName']);
		$_SESSION['save']['guestlogin']['_social_type'] = 'line';
		$_SESSION['save']['guestlogin']['_social_id'] = trim($result['userId']);
		?>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script type="text/javascript">
			alert('請繼續填寫其它必要的欄位');
			window.location.href='guestregister_<?php echo FRONTEND_DEFAULT_LANG?>.php';
		</script>
		<?php
		die;
	
	    //echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
		//echo "Line userId :".$result['userId']."<br/>\r\n";
		//echo "Line displayName :".$result['displayName']."<br/>\r\n";
		//echo "Line pictureUrl :<img src='".$result['pictureUrl']."'><br/>\r\n";
		//echo "Line statusMessage :".$result['statusMessage']."<br/>\r\n";
	
	}

	$state_token = md5(uniqid(rand(), true));
	$_SESSION['state_token'] =  $state_token;
	
	//傳送請求授權資訊
	$url = "https://access.line.me/oauth2/v2.1/authorize?";
	$url.= "response_type=code";
	$url.= "&client_id=".$client_id;
	$url.= "&redirect_uri=".$return_url;
	$url.= "&scope=openid%20profile";
	$url.= "&state=".$_SESSION['state_token'];
	
	header('Location: '.$url);
	die;
}else{ //使用百邇來的Line login Channel

	if(isset($_GET['return_source'])){
		$source = str_replace(" ","+",$_GET['return_source']);
		$sourcetmp=base64_decode($source);
		$result = unserialize(mb_unserialize($sourcetmp));


		if($result == null or !isset($result['userId'])){
		?>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<script type="text/javascript">
				alert('系統異常，請重新操作');
				window.location.href='guestlogin_<?php echo FRONTEND_DEFAULT_LANG?>.php';
			</script>
		<?php
			die;
		}

		$row = $this->cidb->where('is_enable',1)->where('line_id',trim($result['userId']))->get('customer')->row_array();
		if(isset($row) and isset($row['id'])){
			// 底下這一段，是從source/member/login_post.php那邊複製過來的
			Yii::app()->session->add('authw_admin_id', $row['id']);  
			Yii::app()->session->add('authw_admin_account', $row['login_account']);  
			Yii::app()->session->add('authw_admin_name', $row['name']);  

			/*
			 * 檢查我的收藏
			 */
			if(isset($_SESSION['save']['shop_favorite']) and count($_SESSION['save']['shop_favorite']) > 0) {
				foreach($_SESSION['save']['shop_favorite'] as $k => $v){
					// 先看有沒有(此時不管時間)
					//$row2 = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and member_id=:member_id and other1=:id',array(':id'=>$k,':member_id'=>$row['id'],':type'=>'favorite',':ml_key'=>$this->data['ml_key']))->queryRow();
					$row2 = $this->cidb->where('is_enable',1)->where('type','favorite')->where('ml_key',$_SESSION['web_ml_key'])->get('html')->row_array();
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
							'ml_key' => $_SESSION['web_ml_key'],
							'is_enable' => 1,
							'start_date' => $v['add_date'],
							'other1' => $id_tmp[0],
							'other2' => $id_tmp[1],
							'member_id' => $row['id'],
						);
						$this->cidb->insert('html', $save); 
					}
				}
				unset($_SESSION['save']['shop_favorite']);
			}
			?>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<script type="text/javascript">
				alert('己登入');
				window.location.href='index_<?php echo FRONTEND_DEFAULT_LANG?>.php';
			</script>
			<?php
			die;
		}

		// 沒有資料的話導向到註冊頁面，繼續填其它必需要的欄位
		//$_SESSION['save']['guestlogin']['login_account'] = trim($result['email']);
		$_SESSION['save']['guestlogin']['name'] = trim($result['displayName']);
		$_SESSION['save']['guestlogin']['_social_type'] = 'line';
		$_SESSION['save']['guestlogin']['_social_id'] = trim($result['userId']);
		?>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script type="text/javascript">
			alert('請繼續填寫其它必要的欄位');
			window.location.href='guestregister_<?php echo FRONTEND_DEFAULT_LANG?>.php';
		</script>
		<?php
		die;

		//echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
		//echo "Line userId :".$result['userId']."<br/>\r\n";
		//echo "Line displayName :".$result['displayName']."<br/>\r\n";		

	}else{

		//傳送要求連結到公司自架Server1伺服器
		$result = 'inside=test&return_url='.$return_url;
		$url = 'https://image.buyersline.com.tw/line_login.php'; 
		$ch = curl_init(); 
		$timeout = 30; 
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_POST, 1); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type:application/x-www-form-urlencoded")); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $result);//Post提交的數據包
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 
		curl_setopt($ch, CURLOPT_HEADER, 0); 
		$url = curl_exec($ch);

		header('Location: '.$url);

	}

}
