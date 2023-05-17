<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>EOB易貨購</title>
		<meta name="description" content="EOB易貨購"/>
		<meta name="keywords" content="EOB易貨,交易,購物,便宜,消費,批貨,商業,國際,貿易,平台,全球,行銷"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9">
		<link href="eobbarter.css" rel="stylesheet" type="text/css" />
		<link href="custom.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="Scripts/jquery.twzipcode-1.5.2.min.js"></script>
		<script src="<?php echo vir_path_c?>Scripts/confirm_form.js"></script>
		<script type="text/javascript">
			//var msgErrorTip4 = '33';
			var msgErrorTip2 = '請輸入「%s」';
			var msgErrorTip1 = '請輸入要搜尋的關鍵字。';
			var msgProcess = '處理中...';

			function resetForm(id) {
				$('#'+id).each(function(){
						this.reset();
				});
			}
		</script>
		<style type="text/css">
		.bodystyle {
			background-image:url('images/joinEOB.png');
			background-repeat:no-repeat;
		}
		.field_general {
			border:0;
			/*
			 */
			font-family: Arial;
			font-size: 16px;
			height: 17px;
			position: absolute;
			/*
			position: relative;
			left:895px;
			margin-left: 90px;
			margin-top: 12px;
			width: 175px;
			*/
		}

<?php if(!isset($this->data['updatecontent']) or count($this->data['updatecontent']) <= 0):?>
		.line_bg{
			background-color:#f2f1f0;
		}
<?php endif?>

<?php if(isset($this->data['updatecontent']) and count($this->data['updatecontent']) > 0):?>
		<?php // 少155px?>
		.line_1{top:45px}
		.line_2{top:71px}
		.line_3{top:98px}
		.line_4{top:134px}
		.line_5{top:168px}
		.line_6{top:201px}
		.line_7{top:241px}
		.line_8{top:278px}
		.line_9{top:315px}
		.line_10{top:348px}
		.line_11{top:385px}
		.line_12{top:432px}
		.line_13{top:476px}
		.line_13a{top:477px}
		.line_14{top:511px}
		.line_15{top:584px}
		.line_16{top:665px}
		.line_17{top:689px}
		.line_18{top:715px}
		.line_19{top:738px}
		.line_20{top:816px}
<?php else:?>
		.line_1{top:200px}
		.line_3{top:253px}
		.line_4{top:289px}
		.line_5{top:323px}
		.line_6{top:356px}
		.line_7{top:396px}
		.line_8{top:433px}
		.line_9{top:470px}
		.line_10{top:503px}
		.line_11{top:540px}
		.line_12{top:587px}
		.line_13{top:631px}
		.line_13a{top:634px}
		.line_14{top:666px}
		.line_15{top:739px}
		.line_16{top:820px}
		.line_17{top:844px}
		.line_18{top:870px}
		.line_19{top:893px}
		.line_20{top:975px}
<?php endif?>
		</style>
	</head>

	<body>

		<form id="join" action="<?php echo $this->createUrl('site/join')?>" method="post" enctypexxxx="multipart/form-data" onsubmit="MM_validateForm('公司名稱', '', 'R', '公司統編', '', 'R', '負責人', '', 'R', '公司電話', '', 'R', 'Email', '', 'R', this); return document.MM_returnValue;">

			<table width="1191" border="0" cellspacing="0" cellpadding="0">
<?php if(!isset($this->data['updatecontent']) or count($this->data['updatecontent']) <= 0):?>
				<tr>
					<td style="background-color:#023A91;" align="left" valign="top" class="join00"><a href="joinEOB.pdf" title="下載申請表" target="_blank"><img src="images/join_07.jpg" width="103" height="35" border="0" onmouseover="this.src='images/joinb_07.jpg'" onmouseout="this.src='images/join_07.jpg'"/></a></td>
				</tr>
<?php endif?>
				<tr height="1684" heights="992" valign="top">
					<td class="bodystyle">
						<?php if(isset($this->data['updatecontent']) and count($this->data['updatecontent']) > 0):?>
							<input name="create_time_year"   value="<?php echo date('Y', strtotime($this->data['updatecontent']['create_time']))?>" type="text" class="field_general line_1"  id="申請年" style="left:932px;width:60px;" />
							<input name="create_time_month"  value="<?php echo date('m', strtotime($this->data['updatecontent']['create_time']))?>" type="text" class="field_general line_1"  id="申請月" style="left:1020px;width:27px;" />
							<input name="create_time_day"    value="<?php echo date('d', strtotime($this->data['updatecontent']['create_time']))?>" type="text" class="field_general line_1"  id="申請日" style="left:1076px;width:27px;" />

							<input name="card_password" value="<?php echo $this->data['updatecontent']['card_password']?>" type="text" class="field_general line_2"  id="卡密" style="left:932px;width:190px;" />

							<input name="card_number" value="<?php echo $this->data['updatecontent']['card_number']?>" type="text" class="field_general line_3"  id="卡號" style="left:932px;width:190px;" />
						<?php endif?>

						<input name="company_name"         <?php if(isset($this->data['updatecontent']['company_name'])):?>         value="<?php echo $this->data['updatecontent']['company_name']?>"         <?php endif?> type="text" class="field_general line_bg line_4"  id="公司名稱" style="left:167px;width:600px;" />
						<input name="vat_number"           <?php if(isset($this->data['updatecontent']['vat_number'])):?>           value="<?php echo $this->data['updatecontent']['vat_number']?>"           <?php endif?> type="text" class="field_general line_bg line_4"  id="公司統編" style="left:895px;width:230px;" />
						<input name="company_english_name" <?php if(isset($this->data['updatecontent']['company_english_name'])):?> value="<?php echo $this->data['updatecontent']['company_english_name']?>" <?php endif?> type="text" class="field_general line_bg line_5"  id="英文名稱" style="left:167px;width:600px;"/>
						<input name="sign_date"            <?php if(isset($this->data['updatecontent']['sign_date'])):?>            value="<?php echo $this->data['updatecontent']['sign_date']?>"            <?php endif?> type="text" class="field_general line_bg line_5"  id="登記日期" style="left:895px;width:230px;"/>
						<input name="name"                 <?php if(isset($this->data['updatecontent']['name'])):?>                 value="<?php echo $this->data['updatecontent']['name']?>"                 <?php endif?> type="text" class="field_general line_bg line_6"  id="負責人"   style="left:249px;width:255px;"/>
						<input name="email"                <?php if(isset($this->data['updatecontent']['email'])):?>                value="<?php echo $this->data['updatecontent']['email']?>"                <?php endif?> type="text" class="field_general line_bg line_6"  id="Email"    style="left:619px;width:506px;"/>
						<input name="name_sign"            <?php if(isset($this->data['updatecontent']['name_sign'])):?>            value="<?php echo $this->data['updatecontent']['name_sign']?>"            <?php endif?> type="text" class="field_general line_bg line_7"  id="簽約代表人" style="left:186px;width:196px;"/>
						<input name="email_sign"           <?php if(isset($this->data['updatecontent']['email_sign'])):?>           value="<?php echo $this->data['updatecontent']['email_sign']?>"           <?php endif?> type="text" class="field_general line_bg line_7"  id="Email2"   style="left:559px;width:566px;" />
						<input name="company_url"          <?php if(isset($this->data['updatecontent']['company_url'])):?>          value="<?php echo $this->data['updatecontent']['company_url']?>"          <?php endif?> type="text" class="field_general line_bg line_8"  id="公司網址" style="left:167px;width:958px;" />
						<input name="company_phone"        <?php if(isset($this->data['updatecontent']['company_phone'])):?>        value="<?php echo $this->data['updatecontent']['company_phone']?>"        <?php endif?> type="text" class="field_general line_bg line_9"  id="公司電話" style="left:254px;width:257px;" />
						<input name="fax"                  <?php if(isset($this->data['updatecontent']['fax'])):?>                  value="<?php echo $this->data['updatecontent']['fax']?>"                  <?php endif?> type="text" class="field_general line_bg line_9"  id="傳真"     style="left:640px;width:259px;" />
						<input name="home_phone"           <?php if(isset($this->data['updatecontent']['home_phone'])):?>           value="<?php echo $this->data['updatecontent']['home_phone']?>"           <?php endif?> type="text" class="field_general line_bg line_10" id="住宅電話" style="left:254px;width:257px;" />
						<input name="mobile"               <?php if(isset($this->data['updatecontent']['mobile'])):?>               value="<?php echo $this->data['updatecontent']['mobile']?>"               <?php endif?> type="text" class="field_general line_bg line_10" id="行動電話" style="left:640px;width:259px;" />

						<?php if(isset($this->data['updatecontent']['company_addr_county'])):?>
							<span id="x_company_addr_county"><?php echo $this->data['updatecontent']['company_addr_county']?></span>
							<span id="x_company_addr_district"><?php echo $this->data['updatecontent']['company_addr_district']?></span>
						<?php else:?>
							<span id="twzipcode">
								<span data-role="county" data-style="county"></span>
								<span data-role="district" data-style="district"></span>
								<span data-role="zipcode" data-style="zipcode"></span>
							</span> 
						<?php endif?>
						<input name="company_addr"         <?php if(isset($this->data['updatecontent']['company_addr'])):?>         value="<?php echo $this->data['updatecontent']['company_addr']?>"               <?php endif?> type="text" class="field_general line_bg line_11" id="公司地址" style="left:541px;width:580px;" />

						<?php if(isset($this->data['updatecontent']['user_addr_county'])):?>
							<span id="x_user_addr_county"><?php echo $this->data['updatecontent']['user_addr_county']?></span>
							<span id="x_user_addr_district"><?php echo $this->data['updatecontent']['user_addr_district']?></span>
						<?php else:?>
							<span id="twzipcode2">
								<span data-role="county" data-style="county"></span>
								<span data-role="district" data-style="district"></span>
								<span data-role="zipcode" data-style="zipcode"></span>
							</span> 
						<?php endif?>
						<input name="home_addr"            type="text" class="field_general line_bg line_12" id="申請者戶籍地址" style="left:605px;width:519px;" />
						<span class="field_general line_bg line_13a" style="font-size: 18px;background-color:#fff;left:545px;width:60px;height:40px;">其它</span>

						<?php if(isset($this->data['updatecontent']['bill_type'])):?>
							<?php // left都要加5px，才能到指定的位置?>
							<?php if($this->data['updatecontent']['bill_type'] == '1'):?>
								<span id="1_bill_type" class="field_general line_bg line_13" style="left:221px;">V</span>
							<?php endif?>

							<?php if($this->data['updatecontent']['bill_type'] == '2'):?>
								<span id="2_bill_type" class="field_general line_bg line_13" style="left:369px;">V</span>
							<?php endif?>

							<?php if($this->data['updatecontent']['bill_type'] == '3'):?>
								<span id="3_bill_type" class="field_general line_bg line_13" style="left:519px;">V</span>
							<?php endif?>
						<?php else:?>
						<input name="bill_type"            type="radio" class="field_general line_bg line_13" id="帳單寄送地址" value="1" style="left:216px;width:506px;" />
						<input name="bill_type"            type="radio" class="field_general line_bg line_13" id="帳單寄送地址" value="2" style="left:364px;width:506px;" />
						<input name="bill_type"            type="radio" class="field_general line_bg line_13" id="帳單寄送地址" value="3" style="left:514px;width:506px;" />
						<input name="bill_addr"            type="text" class="field_general line_bg line_13" id="帳單其它地址" style="left:620px;width:506px;" />
						<?php endif?>

						<input name="product_and_service"  type="text" class="field_general line_bg line_14" id="產品與服務" style="left:167px;width:960px;" />
						<textarea name="company_description" class="field_general line_bg line_15" id="公司簡介" style="left:160px;width:970px;height:60px;"></textarea>

						<input name="family_name_1" type="text" class="field_general line_bg line_16" id="親友1姓名" style="left:160px;width:400px" />
						<input name="family_phone_1" type="text" class="field_general line_bg line_17" id="親友1電話" style="left:160px;width:400px" />
						<input name="family_addr_1" type="text" class="field_general line_bg line_18" id="親友1地址" style="left:160px;width:400px" />
						<input name="family_email_1" type="text" class="field_general line_bg line_19" id="親友1email" style="left:160px;width:400px" />

						<input name="family_name_2" type="text" class="field_general line_bg line_16" id="親友2姓名" style="left:695px;width:400px" />
						<input name="family_phone_2" type="text" class="field_general line_bg line_17" id="親友2電話" style="left:695px;width:400px" />
						<input name="family_addr_2" type="text" class="field_general line_bg line_18" id="親友2地址" style="left:695px;width:400px" />
						<input name="family_email_2" type="text" class="field_general line_bg line_19" id="親友2email" style="left:695px;width:400px" />

						<?php if(isset($this->data['updatecontent']['card_type'])):?>
							<?php // left都要加5px，才能到指定的位置?>
							<?php if($this->data['updatecontent']['card_type'] == '3'):?>
								<span id="3_card_type" class="field_general line_bg line_20" style="left:120px;">V</span>
							<?php endif?>

							<?php if($this->data['updatecontent']['card_type'] == '2'):?>
								<span id="2_card_type" class="field_general line_bg line_20" style="left:485px;">V</span>
							<?php endif?>

							<?php if($this->data['updatecontent']['card_type'] == '1'):?>
								<span id="1_card_type" class="field_general line_bg line_20" style="left:852px;">V</span>
							<?php endif?>

						<?php else:?>
						<input name="card_type" type="radio" class="field_general line_bg line_20" id="卡別" value="3" style="left:115px;" checked="checked" />
						<input name="card_type" type="radio" class="field_general line_bg line_20" id="卡別" value="2" style="left:480px;" />
						<input name="card_type" type="radio" class="field_general line_bg line_20" id="卡別" value="1" style="left:847px;" />
						<?php endif?>
			
					</td>
				</tr>

<?php if(!isset($this->data['updatecontent']) or count($this->data['updatecontent']) <= 0):?>
				<tr>
					<td>
						<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#023A91;">
							<tr>
								<td width="918">&nbsp;</td>
								<td height="97" align="left" valign="bottom" class="join22"><input type="checkbox" id="is_check" name="is_check" id="確認閱讀左上方條款" value="1" /><span style="color:#fff">確認閱讀左上方條款</span>
									<br /><br /><br />
									<table border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td><a href="javascript:;" id="form_reset" onclick="resetForm('join');" title="清除重填"><img src="images/join_11.jpg" width="100" height="30" border="0" onmouseover="this.src='images/joinb_11.jpg'" onmouseout="this.src='images/join_11.jpg'"/></a></td>
											<td width="5">&nbsp;</td>
											<td><a href="javascript:;" id="form_submit" title="確定送出"><img src="images/join_13.jpg" width="100" height="30" border="0" onmouseover="this.src='images/joinb_13.jpg'" onmouseout="this.src='images/join_13.jpg'"/></a></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
<?php endif?>

			</table>

		</form>


	</body>
</html>

<?php
$tmp = <<<XXX
$('#twzipcode').twzipcode({
	countyName: 'company_addr_county',
	districtName: 'company_addr_district',
	zipcodeName: 'company_addr_zipcode'
});
$('#company_addr_county').attr('class', 'field_general line_bg line_11');
$('#company_addr_county').attr('style', 'left:169px;width:96px;height:24px;');
$('#company_addr_district').attr('class', 'field_general line_bg line_11');
$('#company_addr_district').attr('style', 'left:329px;width:90px;height:24px;');
$('#company_addr_zipcode').attr('class', 'field_general line_bg line_11');
$('#company_addr_zipcode').hide();

$('#x_company_addr_county').attr('class', 'field_general line_bg line_11');
$('#x_company_addr_county').attr('style', 'left:169px;width:96px;height:24px;');
$('#x_company_addr_district').attr('class', 'field_general line_bg line_11');
$('#x_company_addr_district').attr('style', 'left:329px;width:90px;height:24px;');

$('#twzipcode2').twzipcode({
	countyName: 'user_addr_county',
	districtName: 'user_addr_district',
	zipcodeName: 'user_addr_zipcode'
});
$('#user_addr_county').attr('class', 'field_general line_bg line_12');
$('#user_addr_county').attr('style', 'left:232px;width:96px;height:24px;');
$('#user_addr_district').attr('class', 'field_general line_bg line_12');
$('#user_addr_district').attr('style', 'left:392px;width:90px;height:24px;');
$('#user_addr_zipcode').attr('class', 'field_general line_bg line_12');
$('#user_addr_zipcode').hide();

$('#x_user_addr_county').attr('class', 'field_general line_bg line_12');
$('#x_user_addr_county').attr('style', 'left:232px;width:96px;height:24px;');
$('#x_user_addr_district').attr('class', 'field_general line_bg line_12');
$('#x_user_addr_district').attr('style', 'left:392px;width:90px;height:24px;');

$('#form_submit').click(function() {       
	if($('#is_check').is(":checked") == false){
		alert('請確認閱讀條款，並點選打勾'); 
	}
    $('#join').submit();
});

XXX;
//Yii::app()->clientScript->registerScript('web_site_index', $tmp, CClientScript::POS_END);
Yii::app()->clientScript->registerScript('web_join', $tmp, CClientScript::POS_READY);
?>
