<div class="memberBlockReg">

	<section class="block">
		<div class="blockTitle">SIGN IN WITH...</div>
	</section>

<?php if(isset($data['external_member']) && $data['external_member']!=false)://by lota?>

	<section class="block">
		<h4><?php echo t('快速註冊')?></h4>
			<?php if(preg_match('/fb/',$data['external_member'])):?>
				<button onclick="window.location.href='facebook.php';" class="btn-fb">FACEBOOK</button>
			<?php endif?>
			<?php if(preg_match('/g+/',$data['external_member'])):?>	
				<button onclick="window.location.href='google.php';" class="btn-google">GOOGLE</button>
			<?php endif?>
<?php if(0):?>
			<form>
			</form>
<?php endif?>
	</section>

	<div class="hrTitle"><span><?php echo t('OR','en')?></span></div>

<?php endif?>
	

	<section class="block">		
		<h4><?php echo t('註冊會員')?></h4>
		<div class="blockInfoTxt">xxxxxxxxx Enter your message in the box provided and include as many details as possible to help us assist you with your inquiry. Fields marked with * are required.</div>
		<form target="hideframe" action="" method="post" name="memberForm" id="memberForm" onsubmit="MM_validateForm('<?php echo t('姓名')?>','','R','<?php echo t('E-Mail','en')?>','','RisEmail','<?php echo t('密碼')?>','', 'R', '<?php echo t('再次輸入密碼')?>', '', 'R', '<?php echo t('認證碼')?>', '', 'R', this); return document.MM_returnValue;" <?php // enctype="multipart/form-data" ?> > <input type="hidden" name="gtoken" class="gtoken" />

			<?php // https://stackoverflow.com/questions/7083325/firefox-form-targeting-an-iframe-is-opening-new-tab?noredirect=1&lq=1?>
			<iframe id="hideframe" name="hideframe" style="display:none" src=""></iframe>

			<div class="formItem">
				<label  class="must"><?php echo t('E-mail','en')?></label>
				<input type="text" id="<?php echo t('E-mail','en')?>" name="login_account" value="<?php if(isset($_SESSION['save']['guestlogin']['login_account']) and $_SESSION['save']['guestlogin']['login_account'] != ''):?><?php echo $_SESSION['save']['guestlogin']['login_account']?><?php endif?>" placeholder="" />
			</div>
			<div class="Bbox_in_2c">
				<div>
					
					<div class="formItem">
						<label  class="must"><?php echo t('姓名')?></label>
						<input type="text" id="<?php echo t('姓名')?>" name="name" value="<?php if(isset($_SESSION['save']['guestlogin']['name']) and $_SESSION['save']['guestlogin']['name'] != ''):?><?php echo $_SESSION['save']['guestlogin']['name']?><?php endif?>" placeholder="" />
					</div>
					<div class="formItem">
						<label><?php echo t('性別')?></label>
						<div class="radio">
							<label><input type="radio" name="gender" value="1" />  <span><?php echo t('男')?></span> </label>
							<label><input type="radio" name="gender" value="2" />  <span><?php echo t('女')?></span> </label>
						</div>
					</div>								
					<div class="formItem">
						<label class="must"><?php echo t('密碼')?></label>
						<input type="password" id="<?php echo t('密碼')?>" name="login_password" placeholder="">
					</div>	
										
					<div class="formItem">
						<label class="must"><?php echo t('再次輸入密碼')?></label>
						<input type="password" id="<?php echo t('再次輸入密碼')?>" name="login_password_confirm" placeholder="">
					</div>

					<div class="formItem">
						<label><?php echo t('生日')?></label>
						<input type="date" name="birthday" >
					</div>
				
					
					<div class="formItem">
						<label ><?php echo t('電話')?></label>
						<input type="text" id="phone" name="phone" placeholder="">
					</div>							


				</div>
			</div>						
			<div>
				<div class="formItem oneLine">
					<label><?php echo t('地址')?></label>
					<span class="twzipcode_form_1"></span>
				</div>	

				<div class="formItem">
					<input type="text" id="addr" name="addr" placeholder="<?php echo t('地址')?>">
				</div>
			</div>

			<div class="formItem agreementBlock">					
				<div class="checkbox">						
					<label><input type="checkbox" name="need_dm" id="" value="1" />  <span><?php echo t('願意收到產品相關訊息或活動資訊')?></span> </label>						
				</div>
				<div class="checkbox">						
				<label><input type="checkbox" name="accept_privacy" id="" value="1" />  <span><?php echo t('同意隱私權政策')?><a href="#_" class="openBtn underLine" data-target="#memberPrivacy"><?php echo t('隱私權政策')?></a></span> </label>
					<label></label>
				</div>
			</div>	

			<p><?php echo t('如有任何問題歡迎來電聯絡。若想知道會員詳請，請參考')?> <a href="#_" class="openBtn underLine" data-target="#memberTerm"><?php echo t('會員需知')?></a></p>
						
			<div>
				<label class="must"><?php echo t('認證碼')?></label>
				<input type="text" id="captcha" name="captcha" /><img id="valImageId" src="captcha.php" gwidth="100" gheight="40" /><a href="javascript:void(0)" class="icon-link" onclick="RefreshImage('valImageId')"><i class="fa fa-refresh" aria-hidden="true"></i><?php echo t('更新認證碼')?></a>
			</div>	
			

			<div>
				<button><i class="fa fa-user-plus"></i><?php echo t('加入會員')?></button>				
			</div>
			<?php // 這樣才不會出現 "請檢查您的欄位是否有填" 的錯誤訊息視窗?>
			<input type="hidden" id="force_save" value="" />
			<input type="hidden" name="_social_type" value="<?php if(isset($_SESSION['save']['guestlogin']['_social_type']) and $_SESSION['save']['guestlogin']['_social_type'] != ''):?><?php echo $_SESSION['save']['guestlogin']['_social_type']?><?php endif?>" />
			<input type="hidden" name="_social_id" value="<?php if(isset($_SESSION['save']['guestlogin']['_social_id']) and $_SESSION['save']['guestlogin']['_social_id'] != ''):?><?php echo $_SESSION['save']['guestlogin']['_social_id']?><?php endif?>" />
		</form>
	</section>
</div>

<?php if(0):?><!-- body_end -->
<script type="text/javascript">
if($('.twzipcode_form_1').length){
	if(typeof ml_key == 'undefined' || ml_key == 'tw'){
		//$('.twzipcode_form_1').twzipcode();
		$('.twzipcode_form_1').twzipcode({
			countyName: 'addr_county',
			districtName: 'addr_district',
			zipcodeName: 'addr_zipcode'
		});
	}
}
</script>
<?php endif?><!-- body_end -->

<?php if(0):?><!-- head_end -->
<script type="text/javascript">
var msgErrorTip1 = '<?php echo t('請輸入要搜尋的關鍵字。')?>';
var msgErrorTip2 = '<?php echo t('請輸入')?>「%s」';
var msgErrorTip3 = '<?php echo t('E-Mail','en')?>，<?php echo t('請輸入正確的Email格式')?>';
var msgProcess = '<?php echo t('處理中')?>...';
</script>
<script src="js_common/confirm_form.js"></script>
<?php endif?><!-- head_end -->

<?php if(0):?><!-- body_end -->
<script src="js_common/reload.js"></script>
<script type="text/javascript">
$("input[name=phone],input[name=fax],input[name=exten]").keydown(function (e) {
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
         // Allow: Ctrl+A, Command+A
        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
         // Allow: home, end, left, right, down, up
        (e.keyCode >= 35 && e.keyCode <= 40)) {
             // let it happen, don't do anything
             return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});
</script>
<?php endif?><!-- body_end -->
