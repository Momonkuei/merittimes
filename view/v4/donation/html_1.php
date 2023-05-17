<?php 
if(isset($_SESSION['form_data'])){
	$row_data = $_SESSION['form_data'];
}

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
			<div class="stepProcess__Item">
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
						<h2>填寫表單</h2>
					</div>				
					<?php if(0):?>
					<div class="formItem">
						<label>捐款項目<span class="must">*</span>：</label>
						<select name="donationSelect" id="donationSelect">
							<option value="線上捐款" <?php if(!empty($row_data['donationSelect']) && $row_data['donationSelect'] =='線上捐款' ){?>selected<?php }?> >線上捐款</option>
						</select>
					</div>
					<?php else:?>
							<input type="hidden" name="donationSelect" value="線上捐款">
					<?php endif?>

					<div class="formItem">
						<label>捐款方式<span class="must">*</span>：</label>
						<select name="paySelect" id="paySelect">
							<option value="credit_car" <?php if(!empty($row_data['paySelect']) && $row_data['paySelect'] =='credit_car' ){?>selected<?php }?> >線上刷卡</option>
							<option value="web_atm" <?php if(!empty($row_data['paySelect']) && $row_data['paySelect'] =='web_atm' ){?>selected<?php }?> >ATM付款</option>

							<option value="store_ibon" <?php if(!empty($row_data['paySelect']) && $row_data['paySelect'] =='store_ibon' ){?>selected<?php }?> >超商付款</option>

						</select>
					</div>

					<?php //#38120 ?>
					<div class="formTitle _regular">
						<label></label>
						<h3 class="must">定期定額(限定線上刷卡使用)： </h3>
					</div>				

					<div class="formItem money _regular">
						<label><span class="must">定期定額每期捐款金額*</span>：</label>
						<div class="donation_radio_area">
							<div class="radioBox_group">
				    <input type="radio" name="regular_money" id="regular_500" value="500" <?php if(!empty($row_data['regular_money']) && $row_data['regular_money'] =="500" ){?>checked<?php }?> >
				    <label for="regular_500"><span class="signIcon"></span>新台幣 500元整</label>
							</div>
							<div class="radioBox_group">
				    <input type="radio" name="regular_money" id="regular_1000" value="1000" <?php if(!empty($row_data['regular_money']) && $row_data['regular_money'] =="1000" ){?>checked<?php }?> >
				    <label for="regular_1000"><span class="signIcon"></span>新台幣 1000元整</label>
							</div>
							<div class="radioBox_group">
				    <input type="radio" name="regular_money" id="regular_2000" value="2000" <?php if(!empty($row_data['regular_money']) && $row_data['regular_money'] =="2000" ){?>checked<?php }?> >
				    <label for="regular_2000"><span class="signIcon"></span>新台幣 2000元整</label>
							</div>
							<div class="radioBox_group">
				    <input type="radio" name="regular_money" id="regular_5000" value="5000" <?php if(!empty($row_data['regular_money']) && $row_data['regular_money'] =="5000" ){?>checked<?php }?> >
				    <label for="regular_5000"><span class="signIcon"></span>新台幣 5000元整</label>
							</div>
							<div class="radioBox_group">
				    <input type="radio" name="regular_money" id="regular_money_other" value="other" <?php if(!empty($row_data['regular_moneyCustom']) ){?>checked<?php }?> >
				    <label for="regular_money_other"><span class="signIcon"></span>其他金額
								<input type="text" id="regular_moneyCustom" name="regular_moneyCustom" <?php if(isset($row_data['regular_moneyCustom'])):?>value="<?php echo $row_data['regular_moneyCustom']?>"<?php endif?>>
								</label>
							</div>
						</div><!-- .donation_radio_area -->
					</div>

					<div class="formItem _regular">
						<label>定期定額(線上刷卡)期數<span class=""></span>：</label>
						<select name="payRegular" id="payRegular">
							<option value="" <?php if( (!empty($row_data['payRegular']) && $row_data['payRegular'] =='') or !isset($row_data['payRegular']) ){?>selected<?php }?> >
							請選擇</option>
							<option value="3" <?php if(!empty($row_data['payRegular']) && $row_data['payRegular'] =='3' ){?>selected<?php }?> >
							三期</option>
							<option value="6" <?php if(!empty($row_data['payRegular']) && $row_data['payRegular'] =='6' ){?>selected<?php }?> >
							六期</option>
							<option value="9" <?php if(!empty($row_data['payRegular']) && $row_data['payRegular'] =='9' ){?>selected<?php }?> >
							九期</option>
							<option value="12" <?php if(!empty($row_data['payRegular']) && $row_data['payRegular'] =='12' ){?>selected<?php }?> >
							十二期</option>
							<option value="24" <?php if(!empty($row_data['payRegular']) && $row_data['payRegular'] =='24' ){?>selected<?php }?> >
							二四期</option>						
						</select><br/>
						<span class="must" style="display:block;margin-top:10px;">每一個月依所選擇的金額,信用卡固定扣款,直到選擇的期數定期自動扣款圓滿<br/>例如您選擇每期捐款500元、期數12期，則一年圓滿後，刷卡實際累積捐款總金額為6000元</span>

					</div>

					<div class="formItem money">
						<label><span class="must">單次捐款金額*</span>：<span class="remark">(金額最低為新台幣100元整)</span></label>
						<div class="donation_radio_area">
							<div class="radioBox_group">
				    <input type="radio" name="money" id="money_1000" value="1000" <?php if(!empty($row_data['money']) && $row_data['money'] =="1000" ){?>checked<?php }?> >
				    <label for="money_1000"><span class="signIcon"></span>新台幣 1000元整</label>
							</div>
							<div class="radioBox_group">
				    <input type="radio" name="money" id="money_2000" value="2000" <?php if(!empty($row_data['money']) && $row_data['money'] =="2000" ){?>checked<?php }?> >
				    <label for="money_2000"><span class="signIcon"></span>新台幣 2000元整</label>
							</div>
							<div class="radioBox_group">
				    <input type="radio" name="money" id="money_5000" value="5000" <?php if(!empty($row_data['money']) && $row_data['money'] =="5000" ){?>checked<?php }?> >
				    <label for="money_5000"><span class="signIcon"></span>新台幣 5000元整</label>
							</div>
							<div class="radioBox_group">
				    <input type="radio" name="money" id="money_10000" value="10000" <?php if(!empty($row_data['money']) && $row_data['money'] =="10000" ){?>checked<?php }?> >
				    <label for="money_10000"><span class="signIcon"></span>新台幣 10000元整</label>
							</div>
							<div class="radioBox_group">
				    <input type="radio" name="money" id="money_other" value="other" <?php if(!empty($row_data['moneyCustom']) ){?>checked<?php }?> >
				    <label for="money_other"><span class="signIcon"></span>其他金額
								<input type="text" id="moneyCustom" name="moneyCustom" <?php if(isset($row_data['moneyCustom'])):?>value="<?php echo $row_data['moneyCustom']?>"<?php endif?>>
								</label>
							</div>
						</div><!-- .donation_radio_area -->
					</div>

					<br>




					<div class="formTitle">
						<h2>捐款人資料</h2>
					</div>
					<div class="formItem">
						<label>姓名<span class="must">*</span>：</label>
						<input type="text" name="name" id="name" placeholder="請輸入名稱" <?php if(isset($row_data['name'])):?>value="<?php echo $row_data['name']?>"<?php endif?>>
					</div>
					<div class="formItem">
						<label>聯絡電話<span class="must">*</span>：</label>
						<input type="text" name="phone" id="phone" placeholder="請輸入電話號碼" <?php if(isset($row_data['phone'])):?>value="<?php echo $row_data['phone']?>"<?php endif?>>
					</div>
					<div class="formItem">
						<label>電子郵件<span class=""></span>：</label>
						<input type="text" name="login_account" id="login_account" placeholder="請輸入電子郵件" <?php if(isset($row_data['login_account'])):?>value="<?php echo $row_data['login_account']?>"<?php endif?> >
						<?php if(0):?>
						(日後捐款會員之帳號)
						<?php endif?>
					</div>
					<?php if(empty($_SESSION['authw_admin_id']) && 0):?>
					<div class="formItem password">
						<label>設定密碼<span class="must">*</span>：</label>
						<input type="password" name="password" id="password" placeholder="請輸入密碼">
						(日後捐款會員之密碼)					
					</div>
					<div class="formItem password">
						<label>確認密碼<span class="must">*</span>：</label>
						<input type="password" name="password2" id="password2" placeholder="請再次輸入密碼">
					</div>				
					<?php endif?>
					<div class="formItem">
						<label>收據抬頭<span class="must">*</span>：</label>
						<input type="text" name="title" id="title" placeholder="請輸入收據抬頭" <?php if(isset($row_data['title'])):?>value="<?php echo $row_data['title']?>"<?php endif?>>
						<div class="donation_radio_area radio_inb">
							<div class="radioBox_group">
								<input type="radio" name="sameName" id="sameName" value="1">
								<label for="sameName"><span class="signIcon"></span>同姓名</label>
							</div>
						</div>
					</div>
					<!-- <div class="formItem">
						<label>是否上傳國稅局<span class="must">*</span>：</label>
						<input type="radio" name="isUploadIRS_YN" id="isUploadIRS_Y" value="1">是
						<input type="radio" name="isUploadIRS_YN" id="isUploadIRS_N" value="2">否
						<div class="remark IRS">若您選擇上傳國稅局，身分字號為必填欄位，屆時報稅不需附抵本收據</div>
					</div> -->
					<div class="formItem">
						<label>身分別：</label>
						<div class="donation_radio_area radio_inb">
							<div class="radioBox_group">
								<input type="radio" name="identity" id="identityPerson" value="1"  <?php if( (isset($row_data['identity']) && $row_data['identity']=='1') or !isset($row_data['identity']) ):?>checked <?php endif?>>
								<label for="identityPerson"><span class="signIcon"></span>個人</label>
							</div>
							<div class="radioBox_group">
								<input type="radio" name="identity" id="identityCompany" value="2" <?php if(isset($row_data['identity']) && $row_data['identity']=='2'):?>checked <?php endif?>>
								<label for="identityCompany"><span class="signIcon"></span>公司</label>
							</div>
						</div>
					</div>
					<?php if(1): //#44238?>
					<div class="formItem">
						<label class="checkbox">
							<input type="checkbox" name="willing" value="1" <?php if(isset($row_data['willing']) && $row_data['willing']=='1'):?>checked <?php endif?>>本捐款人願意將捐款資料上傳至國稅局以供報稅用
						</label>
					</div>
					<?php endif?>					
					<?php if(1): //#44238?>
					<div class="formItem">
						<?php 
							$personId_txt = '身份證號';
							$personId_txt1 = '請輸入身份證號';
							if(isset($row_data['identity']) && $row_data['identity']=='2' ){
								$personId_txt = '公司統編';
								$personId_txt1 = '請輸入公司統編';
							}
						?>
						<label id="personId_txt"><?php echo $personId_txt?>：</label>
						<input type="text" name="personId" id="personId" placeholder="<?php echo $personId_txt1?>" <?php if(isset($row_data['personId'])):?>value="<?php echo $row_data['personId']?>"<?php endif?>>
					</div>
					<?php endif?>
					<br>


					<div class="formTitle">
						<h2>開立收據</h2>
					</div>
					<?php //#33057?>
					<div class="formItem">
						<label>紙本收據<span class="must">*</span>：</label>
						<div class="donation_radio_area radio_inb">
							<div class="radioBox_group">
								<input type="radio" name="receipt" id="receipt" value="1">
								<label for="receipt"><span class="signIcon"></span>需要</label>
							</div>
							<div class="radioBox_group">
								<input type="radio" name="receipt" id="receipt_no" value="2" checked>
								<label for="receipt_no"><span class="signIcon"></span>不需要</label>
							</div>
						</div>
					</div>
					<div class="formItem">
						<div class="remark"><span class="must">*</span>如需紙本收據，請填寫下方地址欄位。</div>
						<label>收據地址：</label>
						<input type="text" name="addr" id="addr" placeholder="" <?php if(isset($row_data['addr'])):?>value="<?php echo $row_data['addr']?>"<?php endif?>>
					</div>
					<div class="formItem">
						<label>備註：</label>
						<textarea cols="30" rows="10" name="memo" class="memo"><?=(isset($row_data['memo'])?$row_data['memo']:'')?></textarea>
					</div>					
					<div class="text-center" style="margin-top: 30px;">
						<input type="hidden" name="post_type" value="1">
						<button type="submit">送出表單</button>
					</div>
				</div>
			</div>
		</div>
	</form>

</div>



<script type="text/javascript" m="body_end">
	$(function(){
		$("#paySelect").change(function(){
			if($(this).val()!='credit_car'){
				$("._regular").hide();
				$("#payRegular").val('');
				// $("input[name^='regular_money']").each(function(){
				// 	$(this).attr("checked","checked");
				// });
			}else{
				$("._regular").show();
			}
		});

		$("input[name='regular_money']").click(function(){			
			$("input[name='money']:checked").prop("checked",false);
		});

		$("input[name='money']").click(function(){			
			$("input[name='regular_money']:checked").prop("checked",false);
		});


		$("input[name*='identity']:radio").change(function(){
			var val = $(this).val();
	       	if(val == 1){
	       		$('#personId_txt').text('身份證號：');    
	       		$("#personId").attr("placeholder", "請輸入身份證號"); 
	       	}
	       	else if(val == 2){
	       		$('#personId_txt').text('公司統編：');     
	       		$("#personId").attr("placeholder", "請輸入公司統編");
	       	}
	    });

	    $("#sameName").change(function(){
			var name = $("#name").val();
	        $('#title').val(name);
	    });
	});
</script>