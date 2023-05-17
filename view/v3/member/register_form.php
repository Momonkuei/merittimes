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
		<form action="" method="post" name="form_data" id="form_data">
			<div class="formItem">
				<label  class="must"><?php echo t('E-mail','en')?></label>
				<input type="text" id="login_account" name="login_account" value="<?php if(isset($_SESSION['save']['guestlogin']['login_account']) and $_SESSION['save']['guestlogin']['login_account'] != ''):?><?php echo $_SESSION['save']['guestlogin']['login_account']?><?php endif?>" placeholder="" />
			</div>
			<div class="Bbox_in_2c">
				<div>
					
					<div class="formItem">
						<label  class="must"><?php echo t('姓名')?></label>
						<input type="text" id="name" name="name" value="<?php if(isset($_SESSION['save']['guestlogin']['name']) and $_SESSION['save']['guestlogin']['name'] != ''):?><?php echo $_SESSION['save']['guestlogin']['name']?><?php endif?>" placeholder="" />
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
						<input type="password" id="login_password" name="login_password" placeholder="">
					</div>	
										
					<div class="formItem">
						<label class="must"><?php echo t('再次輸入密碼')?></label>
						<input type="password" id="login_password_confirm" name="login_password_confirm" placeholder="">
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
					<label><input type="checkbox" name="need_dm" id="" value="1" checked="checked" />  <span><?php echo t('願意收到產品相關訊息或活動資訊')?></span> </label>						
				</div>
				<div class="checkbox">						
				<label><input type="checkbox" name="accept_privacy" id="" value="1" checked="checked" disabled="disabled" />  <span><?php echo t('同意隱私權政策')?><a href="#_" class="openBtn underLine" data-target="#memberPrivacy"><?php echo t('隱私權政策')?></a></span> </label>
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
<script src="js_common/reload.js"></script>
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
