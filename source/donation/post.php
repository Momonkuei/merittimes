<?php

/*
 * 2018-06-29 這裡是通用表單POST程式
 * 目前只有連絡我們在使用 beta版
 */


$donation_data =$this->cidb->where('keyname','function_constant_donation')->get('sys_config')->row_array();
if(!empty($donation_data) && $donation_data['keyval']=='true'){
	if(!empty($_POST)){ // and $this->data['router_method'] == 'XXX_1' 編排頁專用
		//第一步驟，更新資訊並顯示資訊
		if(isset($_POST['post_type']) && $_POST['post_type']=="1"){
			if (empty($_POST['donationSelect']) or $_POST["donationSelect"] == '') {
				echo "<script>
						alert('請選擇捐贈項目');	
						parent.prayForm.donationSelect.focus();
					</script>";
				exit;
			}
			//非定期定額的部分
			if ( (empty($_POST['money']) or $_POST["money"] == '') and $_POST['payRegular']=='' ) {
				echo "<script>
						alert('請選擇固定捐贈金額');	
						parent.prayForm.money.focus();
					</script>";
				exit;
			}
			if($_POST['money'] == 'other' and $_POST['payRegular']==''){
				if (empty($_POST['moneyCustom']) or $_POST["moneyCustom"] == '') {
					echo "<script>
							alert('請填寫固定捐贈金額');	
							parent.prayForm.moneyCustom.focus();
						</script>";
					exit;
				}
				elseif($_POST['moneyCustom'] < "100"){
						echo "<script>
								alert('金額最低為新台幣100元整');	
								parent.prayForm.moneyCustom.focus();
							</script>";
						exit;
				}
			}
			//定期定額的部分 #38120
			if ( (empty($_POST['regular_money']) or $_POST["regular_money"] == '') and $_POST['payRegular']!='' ) {
				echo "<script>
						alert('請選擇定期定額捐贈金額');	
						parent.prayForm.money.focus();
					</script>";
				exit;
			}
			if($_POST['regular_money'] == 'other' and $_POST['payRegular']!=''){
				if (empty($_POST['regular_moneyCustom']) or $_POST["regular_moneyCustom"] == '') {
					echo "<script>
							alert('請填寫定期定額捐贈金額');	
							parent.prayForm.moneyCustom.focus();
						</script>";
					exit;
				}
				elseif($_POST['regular_moneyCustom'] < "100"){
						echo "<script>
								alert('金額最低為新台幣100元整');	
								parent.prayForm.moneyCustom.focus();
							</script>";
						exit;
				}
			}

			if (empty($_POST['name']) or $_POST["name"] == '') {
				echo "<script>
						alert('請填寫姓名');	
						parent.prayForm.name.focus();
					</script>";
				exit;
			}
			if (empty($_POST['phone']) or $_POST["phone"] == '') {
				echo "<script>
						alert('請填寫聯絡電話');	
						parent.prayForm.phone.focus();
					</script>";
				exit;
			}
			//信箱+電話的正規表達式判斷
			if (!preg_match('/(\d{2,3}-?|\(\d{2,3}\))\d{3,4}-?\d{4}|09\d{2}(\d{6}|-\d{3}-\d{3})$/', $_POST['phone'])) {
				echo "<script>
						alert('請填寫正確電話');	
						parent.prayForm.phone.focus();
					</script>";
				exit;
			}			
			// if(!isset($this->data['admin_id']) or count($this->data['admin_id']) <= 0){
			// 	if (empty($_POST['login_account']) or $_POST["login_account"] == '') {
			// 		echo "<script>
			// 				alert('請填寫電子郵件');	
			// 				parent.prayForm.login_account.focus();
			// 			</script>";
			// 		exit;
			// 	}
			// 	if (c_mail($_POST['login_account'])==false) {
			// 		echo "<script>
			// 				alert('請確認您的電子郵件格式');	
			// 				parent.prayForm.email.focus();
			// 			</script>";
			// 		exit;
			// 	}
			// }else{
			// 	$_POST['login_account'] = $this->data['admin_account'];
			// }
			
			if (empty($_POST['title']) or $_POST["title"] == '') {
				echo "<script>
						alert('請填寫收據抬頭');	
						parent.prayForm.title.focus();
					</script>";
				exit;
			}
			if ((empty($_POST['addr']) or $_POST["addr"] == '') and $_POST['receipt']=='1') {
				echo "<script>
						alert('請輸入收據地址');	
						parent.prayForm.addr.focus();
					</script>";
				exit;
			}

			//非定期定額
			if($_POST['payRegular']==''){
				if($_POST['money'] != 'other'){
					$money = $_POST['money'];
				}else{
					$money = $_POST['moneyCustom'];
					//這邊原本是other 我把它變為金額
					$_POST['money'] = $money;
				}
			}elseif($_POST['payRegular']!=''){
			//定期定額 #38120
				if($_POST['regular_money'] != 'other'){
					$_POST['money'] = $money = $_POST['regular_money'];
				}else{
					$money = $_POST['regular_moneyCustom'];
					//這邊原本是other 我把它變為金額
					$_POST['money'] = $money;
				}

			}

			//
			if(isset($_POST['willing'])){
				if (empty($_POST['personId']) or $_POST["personId"] == '') {
					$_identity = $_POST['identity'];
					if($_identity==1){
						$_tt ='請輸入身份證號';
					}
					if($_identity==2){
						$_tt ='請輸入公司統編';
					}
					echo "<script>
							alert('".$_tt."');	
							parent.prayForm.title.focus();
						</script>";
					exit;
				}
			}


			// if(empty($_SESSION['authw_admin_id'])){

			// 	if (!empty($_POST['password']) && !empty($_POST['password2']) && $_POST['password'] != $_POST["password2"]) {
			// 		echo "<script>
			// 				alert('密碼與確認密碼不符');	
			// 				parent.prayForm.password.focus();
			// 			</script>";
			// 		exit;
			// 	}

			// 	if (!empty($_POST['password']) && !empty($_POST['password2']) && $_POST['password'] == $_POST["password2"]) {
			// 		//查詢帳號是否重複
			// 		$rec_LoginID = $_POST["login_account"];
			// 		$query = $this->cidb->select('id, name, login_account')->where('login_account',$rec_LoginID)->get('customer');	
			// 		if ($query->num_rows() > 0){
			// 			echo "<script>
			// 					alert('該信箱已註冊過，請先登入後再捐款');
			// 					parent.prayForm.name.focus();
			// 				</script>";
			// 			exit;
			// 		}
			// 	}
			// }
		
			$_SESSION['form_data'] = $_POST;
			unset($_SESSION['form_data']['post_type']);
			//var_dump($_SESSION['form_data']);
			//header('Location: donation_tw_2.php');
			//die;
				echo "
				<script>
				if (parent!=self) parent.location.href='/donation_tw_2.php'; else location.href='/donation_tw_2.php';	
				</script>";
			exit;


		}

		//第二步驟，送到綠界刷卡
		if(isset($_POST['post_type']) && $_POST['post_type']=="2"){


			

			if(!isset($_POST['gtoken']) or $_POST['gtoken'] == '' or !isset(Yii::app()->session['gtoken']) or Yii::app()->session['gtoken'] == '' or Yii::app()->session['gtoken'] != $_POST['gtoken']){
				echo 'Incorrent token, please contact administrator';
				exit;
			}

			$temp = "";
			$temp = $_SESSION['form_data'];
			//#33057
			if(isset($temp['receipt']) && $temp['receipt']==1){
				$temp['receipt_value'] ='需要';
			}
			if(isset($temp['receipt']) && $temp['receipt']==2){
				$temp['receipt_value'] ='不需要';
			}

			

			/**
			* 存入前檢查資訊是否存在...
			*/
			if( empty($temp) ){
				echo "
				<script>
				alert('請確認您的捐款資訊');
				if (parent!=self) parent.location.href='/donation_tw_1.php'; else location.href='/donation_tw_1.php';	
				</script>";
				exit;
			}//END	

			
			/**
			* 需要加入會員者...
			*/
			// if( empty($_SESSION['authw_admin_id']) && !empty($temp['password']) ){ 

			// 	if (!empty($temp['password']) && !empty($temp['password2']) && $temp['password'] == $temp['password2']) {
			// 		//查詢帳號是否重複 again
			// 		$query = $this->cidb->select('id, name, login_account')->where('login_account',$temp["login_account"])->get('customer');	
			// 		if ($query->num_rows() > 0){
			// 			echo "<script>
			// 					alert('該信箱已註冊過，請先登入後再捐款');
			// 					if (parent!=self) parent.location.href='/donation_tw_1.php'; else location.href='/donation_tw_1.php';	
			// 				</script>";
			// 			exit;
			// 		}
			// 	}

			// 	$_salt = G::GeraHash(10);
			// 	$_login_password = '{GGG3AAA}'.str_replace('a','ɢ', sha1(G::utf8_strrev($temp['password'].$_salt)));


			// 	$Array = array();
			// 	$ddate = date('Y-m-d H:i:s');
			// 	$Array = array(
			// 		"name" => $temp['name'],
			// 		"phone" => EncrptyPwd(WEB_KEY,$temp['phone']),
			// 		//"login_password" => EncrptyPwd(WEB_KEY,$temp['password']),
			// 		"login_password" => $_login_password,
			// 		"salt" => $_salt,
			// 		"login_account" => $temp['login_account'],
			// 		"addr" => $temp['addr'],
			// 		"title" =>$temp['title'],
			// 		"identity" =>$temp['identity'],
			// 		"personId" =>$temp['personId'],
			// 		"receipt" =>$temp['receipt'],//#33057
			// 		"is_enable" => 1,
			// 		"create_time" => $ddate,
			// 		"update_time" => $ddate,
			// 	);

			// 	$res = $this->cidb->insert('customer',$Array);
			// 	$cus_id =  $this->cidb->insert_id();
			// 	if(!$cus_id){
			// 		echo "<script>
			// 				alert('會員加入失敗');
			// 				if (parent!=self) parent.location.href='/donation_tw_2.php'; else location.href='/donation_tw_2.php';	
			// 			</script>";
			// 		exit;	
			// 	}else{
			// 		$_SESSION['authw_admin_id'] = $cus_id; //新增後保持登入狀態		
			// 		$_SESSION['authw_admin_account'] =$temp['login_account']; //新增後保持登入狀態		
			// 		$_SESSION['authw_admin_name'] = $temp['name']; //新增後保持登入狀態		
			// 	}

			// }//需要加入會員者... END
			



			




			


			/**
			* 處理項目資訊
			*/
			if($temp['money'] < 0 || empty($temp['donationSelect']) ){ //金額
				echo "
				<script>
					alert('請確認您的捐款金額 / 項目');
					parent.location.href='/donation_tw_1.php';	
				</script>";
				exit;
			}

			if( $temp['paySelect'] == 'credit_car' ){ //各種捐款方式狀態初始
				$order_status = 0;
			}elseif( $temp['paySelect'] == 'web_atm' ){
				$order_status = 3;
			}elseif( $temp['paySelect'] == 'store_ibon' ){
				$order_status = 3;
			}
			$order_date = date('Y-m-d H:i:s');
			$order = array(
				// "customer_id" => !empty($_SESSION['authw_admin_id'])?$_SESSION['authw_admin_id']:'',
				"buyer_login_account" => !empty($temp['login_account'])?$temp['login_account']:'',
				"buyer_name" 		  => $temp['name'],
				// "buyer_phone" => EncrptyPwd(WEB_KEY,$temp['phone']),
				"buyer_phone" 		  => $temp['phone'],
				"total" 			  => $temp['money'],
				"order_status" 		  => $order_status,
				"payment_func" 		  => $temp['paySelect'], 
				"title" 			  => $temp['title'],
				"identity" 			  => !empty($temp['identity'])?$temp['identity']:'',
				"personId" 			  => !empty($temp['personId'])?$temp['personId']:'',	
				"receipt" 			  => $temp['receipt_value'],//#33057
				"address" 			  => $temp['addr'],
				"item_name" 		  => $temp['donationSelect'],
				"create_time" 		  => $order_date,
				"update_time" 		  => $order_date,
				"detail"			  => $temp['memo'],
			);
			//2020-12-02 淨土寺沒辦法做分期...
			// if(isset($temp['moneyCustom']) && $temp['moneyCustom']!=''){
			// 	//no thing
			// }else{
			// 	//如果是點選快速付款 經理來信 增加分期
			// 	if($temp['money']=='6000' or $temp['money']=='12000' or $temp['money']=='24000' or $temp['money']=='36000' or $temp['money']=='48000' or $temp['money']=='60000')
			// 	$order['creditnum'] = '3,6,12';
			// }

			//定期定額 期數
			if($temp['payRegular']!='' && $temp['paySelect']=='credit_car'){
				$order['payRegular'] = $temp['payRegular'];
			}

			$this->cidb->insert('donationorder',$order);
			$order_id =  $this->cidb->insert_id();
			$_SESSION['OrderNumber'] = setOrdeNumber($order_id,$order_date);
			$this->cidb->where('id', $order_id);
			$this->cidb->update('donationorder', array("order_number" => setOrdeNumber($order_id,$order_date) ));
			//處理項目資訊 END



			/**
			* 寄信區塊
			*/

			//// 找一下寄件人有沒有設定
			//$query = $this->cidb->select('*,topic as name,other1 as email')->where('type','email')->where('is_enable',1)->where('is_home',1)->order_by('sort_id')->get('html');
			//$from = $query->row_array();
			//
			//// 找一下收件人有沒有設定
			//$query = $this->cidb->select('*,topic as name,other1 as email')->where('type','email')->where('is_enable',1)->where('is_news',1)->order_by('sort_id')->get('html');
			//$tos = $query->result_array();

		
			//$body_html = "	＊此郵件是系統自動發送，請勿直接回覆此郵件！<br>
			//			親愛的 ".$temp['name']." 您好，<br>
			//			感謝您的捐款！<br> 
			//		  	以下是您的填寫的捐款資訊，我們將遵守個人資料隱私權之重要性。<br>
			//		  	捐款編號： ".$_SESSION['OrderNumber']." <br>
			//		  	日期： ".$order_date." <br>
			//		  	會員姓名︰ ".$temp['name']." <br>
			//			E-Mail︰".$temp['login_account']."<br>
			//			項目︰".$temp['donationSelect']."<br>
			//			金額︰".$temp['money']."<br>
			//			若您有任何疑問，您可利用線上客服與我們連絡!";

			////設定cc收件者
			//if(defined('CC_MAIL_OPEN') && CC_MAIL_OPEN==true){
			//	if(!empty($temp['login_account'])) {$cc_mail = $temp['login_account'];}
			//}else{
			//	$cc_mail = NULL;
			//}

			//if($from and count($from) > 0 and isset($from['id']) and isset($from['email'])
			//	and $tos and count($tos) > 0 and isset($tos[0]['id'])){

			//	if(isset($this->data['sys_configs']['smtp_ssl']) and $this->data['sys_configs']['smtp_ssl'] == 'sendmail'){
			//        $email_return = $this->email_send_to_by_sendmail($from,$tos, '捐款信件', '', $body_html,$cc_mail);
			//    } else {
			//        $email_return = $this->email_send_to_v2($from,$tos, '捐款信件', '', $body_html,$cc_mail);
			//    }
			//}
			//寄信區塊END	


			/**
			* 洗牌
			*/
			Yii::app()->session['gtoken'] = rand(10000,99999)."WIO#@("; 
			$_SESSION['Success_form_data']=""; //初始
			$_SESSION['Success_form_data'] = $_SESSION['form_data'];
			
			

			/*
			* 金流
			*/
			if($temp['paySelect'] == 'credit_car'){
				echo "
				<script>
					parent.location.href='/creditPay.php';	
				</script>";
				exit;


			}
			elseif( $temp['paySelect'] == 'web_atm' ){
				echo "
				<script>
					parent.location.href='/atmPay.php';	
				</script>";
				exit;
			}elseif( $temp['paySelect'] == 'store_ibon' ){
				echo "
				<script>
					parent.location.href='/store_ibon.php';	
				</script>";
				exit;
			}






		}

	}
}

function c_mail($email){
	$result = TRUE;
	if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email)) {
		$result = FALSE;
	}
	return $result;
}



function setOrdeNumber($oSN,$date){
	if(!empty($oSN)){
		$datestr = str_replace('-','',$date);
		if(!empty($date)) return substr($datestr, 2, 6).str_pad($oSN, 6, '0', STR_PAD_LEFT);
		else return $oSN;
	}
}
