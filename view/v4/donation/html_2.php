<?php

if(isset($_SESSION['form_data'])){
	$row_data = $_SESSION['form_data'];
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


if(empty($_SESSION['form_data'])){
	echo "
	<script>
	if (parent!=self) parent.location.href='/donation_tw_1.php'; else location.href='/donation_tw_1.php';	
	</script>";	
}





// if(!empty($_SESSION['form_data'])){
// 	echo "<pre>";
// 	print_r($_SESSION['form_data']);
// 	echo "</pre>";
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
			<div class="stepProcess__Item">
				<div class="stepProcess__ItemArea">
					<div class="stepProcess__Circle">
						<div class="stepProcess__stepText">STEP 3</div>
					</div>
					<div class="stepProcess__Title">付款頁面</div>
				</div>
			</div>
			<div class="stepProcess__Item">
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
						<label>捐款方式<span class="must">*</span>：</label>
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

					<?php if(isset($row_data['paySelect']) && $row_data['paySelect']== 'credit_car' && $row_data['payRegular']!=''):?>
					<div class="formItem">
						<label>定期定額(線上刷卡)<span class=""></span>：</label>
						<span><?php if(isset($row_data['payRegular'])){ echo $row_data['payRegular'];}?>期</span>
					</div>
					<?php endif?>

					<div class="formItem">
						<label>捐款項目<span class="must">*</span>：</label>
						<span><?php if(isset($row_data['donationSelect'])){ echo $row_data['donationSelect'];}?></span>
					</div>

					<div class="formItem money">
						<label>捐款金額<span class="must">*</span>：</label>
						<span><?php if(isset($row_data['money'])){ echo $row_data['money'];}?> 元整</span>
					</div>
					<br>


					<div class="formTitle">
						<h2>捐款人資料</h2>
					</div>
					<div class="formItem">
						<label>姓名<span class="must">*</span>：</label>
						<span><?php if(isset($row_data['name'])){ echo $row_data['name'];}?></span>
					</div>
					<div class="formItem">
						<label>聯絡電話<span class="must">*</span>：</label>
						<span><?php if(isset($row_data['phone'])){ echo $row_data['phone'];}?></span>
					</div>
					<div class="formItem">
						<label>電子郵件：</label>
						<span><?php if(isset($row_data['login_account'])){ echo $row_data['login_account'];}?></span>
					</div>				
					<div class="formItem">
						<label>收據抬頭<span class="must">*</span>：</label>
						<span><?php if(isset($row_data['title'])){ echo $row_data['title'];}?></span>
					</div>
					<!-- <div class="formItem">
						<label>是否上傳國稅局<span class="must">*</span>：</label>
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
						<div class="remark"><span class="must">*</span>如需紙本收據，請填寫下方地址欄位。</div>
						<label>收據地址：</label>
						<span><?php if(isset($row_data['addr'])){ echo $row_data['addr'];}?></span>
					</div>
					<div class="formItem">						
						<label>備註：</label>
						<span><?php if(isset($row_data['memo'])){ echo $row_data['memo'];}?></span>
					</div>
					<div class="text-center" style="margin-top: 30px;">
						<input type="hidden" class="gtoken" name="gtoken" id="gtoken"/>
						<input type="hidden" name="post_type" value="2">
						<button class="b2e" type="button" onclick="location.href='donation_tw_1.php'">返回修改</button>
						<button type="submit">送出表單</button>
					</div>
				</div>
			</div>
		</div>
	</form>

</div>