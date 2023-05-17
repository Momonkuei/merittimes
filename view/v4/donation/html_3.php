<?php
if(isset($_SESSION['Success_form_data'])){
	$row_data = $_SESSION['Success_form_data'];
	$row_data['identity_value']='';
	if(isset($row_data['identity']) && $row_data['identity']==1){
		$row_data['identity_value'] ='個人';
	}
	if(isset($row_data['identity']) && $row_data['identity']==2){
		$row_data['identity_value'] ='公司';
	}
	//#33057
	if(isset($row_data['receipt']) && $row_data['receipt']==1){
		$row_data['receipt_value'] ='需要';
	}
	if(isset($row_data['receipt']) && $row_data['receipt']==2){
		$row_data['receipt_value'] ='不需要';
	}
}




if(!empty($_SESSION['OrderNumber'])){
	$query = $this->cidb->select('*')->where('order_number',$_SESSION['OrderNumber'])->get('donationorder');
	$result = $query->row_array();
}


// if(empty($_SESSION['Success_form_data']) || empty($result) ){
// 	echo "
// 	<script>
// 	if (parent!=self) parent.location.href='/donation_tw_2.php'; else location.href='/donation_tw_2.php';	
// 	</script>";	
// }

// if($result['payment_func'] == 'credit_car'){
// 	if($result['order_status']==1){ 
// 		unset($_SESSION['form_data']); //真正成功才刪session
// 	}

// }elseif($result['payment_func'] == 'web_atm'){
// 	if(!empty($result['vbank_account'])){
// 		unset($_SESSION['form_data']); //真正成功才刪session
// 	}
// }
// elseif($result['payment_func'] == 'store_ibon'){
// 	if(!empty($result['paymentno'])){
// 		unset($_SESSION['form_data']); //真正成功才刪session
// 	}
// }




?>
<div class="container">

	<div class="stepProcess">
		<div class="stepProcessArea">
			<div class="stepProcess__Item active">
				<div class="stepProcess__ItemArea">
					<div class="stepProcess__Circle">
						<div class="stepProcess__stepText">STEP 1</div>
					</div>
					<div class="stepProcess__Title">填寫表單</div>
				</div>
			</div>
			<div class="stepProcess__Item active">
				<div class="stepProcess__ItemArea">
					<div class="stepProcess__Circle">
						<div class="stepProcess__stepText">STEP 2</div>
					</div>
					<div class="stepProcess__Title">捐款確認</div>
				</div>
			</div>
			<div class="stepProcess__Item active">
				<div class="stepProcess__ItemArea">
					<div class="stepProcess__Circle">
						<div class="stepProcess__stepText">STEP 3</div>
					</div>
					<div class="stepProcess__Title">付款頁面</div>
				</div>
			</div>
			<div class="stepProcess__Item active">
				<div class="stepProcess__ItemArea">
					<div class="stepProcess__Circle">
						<div class="stepProcess__stepText">STEP 4</div>
					</div>
					<div class="stepProcess__Title">捐款列表</div>
				</div>
			</div>
		</div>
	</div>



	<form class="donationForm" action="" method="post" id="form_data" name="prayForm" target="hideframe" >
		<iframe id="hideframe" name="hideframe" style="display:none" src=""></iframe>
		<div class="Bbox_1c">
			<div> 
				<div>
					<div class="formTitle">
						<h2>捐款確認</h2>
					</div>
					<div class="formItem">
						<label>捐款編號：</label>
						<span><?php if(isset($_SESSION['OrderNumber'])){ echo $_SESSION['OrderNumber'];}?></span>
					</div>

					<div class="formItem">
						<label>捐款項目：</label>
						<span><?php if(isset($row_data['donationSelect'])){ echo $row_data['donationSelect'];}?></span>
					</div>


					<div class="formItem">
						<label>捐款方式：</label>
						<span>
							<?php 
								if(isset($row_data['paySelect']) && $row_data['paySelect']== 'web_atm'){ 
									echo 'ATM付款';
								}elseif(isset($row_data['paySelect']) && $row_data['paySelect']== 'credit_car'){
									echo '線上刷卡';
								}elseif(isset($row_data['paySelect']) && $row_data['paySelect']== 'store_ibon'){
									echo '超商付款';
								}
							?>
						</span>
					</div>


					<div class="formItem money">
						<label>捐款金額：</label>
						<span><?php if(isset($row_data['money'])){ echo $row_data['money'];}?> 元整</span>
					</div>

					<?php if($row_data['paySelect'] == 'web_atm'){?>

						<div class="formItem money">
							<label>銀行代碼：</label>
							<span><?php if(!empty($result['vbank_code'])){ echo $result['vbank_code'];}?> </span>
						</div>


						<div class="formItem money">
							<label>捐款帳號：</label>
							<span><?php if(!empty($result['vbank_account'])){ echo $result['vbank_account'];}else{ echo '取號失敗'; }?> </span>
						</div>



						<div class="formItem money">
							<label>代碼繳費期限：</label>
							<span><?php if(!empty($result['expiredate'])){ echo $result['expiredate'];}?> </span>
						</div>


					<?php }elseif($row_data['paySelect'] == 'store_ibon'){?>

						<div class="formItem money">
							<label>超商繳費代碼：</label>
							<span><?php if(!empty($result['paymentno'])){ echo $result['paymentno'];}else{ echo '取號失敗'; }?> </span>
						</div>



						<div class="formItem money">
							<label>超商繳費期限：</label>
							<span><?php if(!empty($result['expiredate'])){ echo $result['expiredate'];}?> </span>
						</div>
					
					<?php }?>	


					<div class="formItem money">
						<label>捐款狀態：</label>
						<span><?php if($result['order_status']==1){ echo '已付款';}else{ echo '未付款'; }?> </span>
					</div>


					<br>


					<div class="formTitle">
						<h2>捐款人資料</h2>
					</div>
					<div class="formItem">
						<label>姓名：</label>
						<span><?php if(isset($row_data['name'])){ echo $row_data['name'];}?></span>
					</div>
					<div class="formItem">
						<label>聯絡電話：</label>
						<span><?php if(isset($row_data['phone'])){ echo $row_data['phone'];}?></span>
					</div>
					<div class="formItem">
						<label>電子郵件：</label>
						<span><?php if(isset($row_data['login_account'])){ echo $row_data['login_account'];}?></span>
					</div>
					<div class="formItem">
						<label>收據抬頭：</label>
						<span><?php if(isset($row_data['title'])){ echo $row_data['title'];}?></span>
					</div>
					<!-- <div class="formItem">
						<label>是否上傳國稅局：</label>
						<span><?php echo '是'?></span>
					</div> -->
					<div class="formItem">
						<label>身分別：</label>
						<span><?php if(isset($row_data['identity_value'])){ echo $row_data['identity_value'];}?></span>
					</div>
					<div class="formItem">
						<label id="personId_txt">證號/統編：</label>
						<span><?php if(isset($row_data['personId'])){ echo $row_data['personId'];}?></span>
					</div>
					<br>


					<div class="formTitle">
						<h2>開立收據</h2>
					</div>
					<div class="formItem">
						<label>紙本收據<span class="must">*</span>：</label>
						<?php if(isset($row_data['receipt_value'])){ echo $row_data['receipt_value'];}//#33057?>
					</div>
					<div class="formItem">
						<label>收據地址：</label>
						<span><?php if(isset($row_data['addr'])){ echo $row_data['addr'];}?></span>
					</div>
					
				</div>
			</div>
		</div>
	</form>

</div>