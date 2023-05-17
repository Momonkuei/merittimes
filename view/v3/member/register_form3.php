<?php
//會員登入型態
unset($_constant);
eval('$_constant = CUSTOMER_LOGIN_TYPE'.';');
if($_constant=='email'){
	$_login_account_text = t('E-Mail');
	$_login_account_type ='email';
}elseif($_constant=='phone'){
	$_login_account_text = t('電話');
	$_login_account_type ='text';
}elseif($_constant=='account'){
	$_login_account_text = t('帳號');
	$_login_account_type ='text';
}else{
	$_login_account_text = t('E-Mail');
	$_login_account_type ='email';
}
?>
<div class="memberBlockReg">

	<section class="block">
		<div class="blockTitle">SIGN IN WITH...</div>
	</section>

	<?php if(isset($data['external_member']) && $data['external_member']!=false):// by lota?>
		<section class="block">
			<h4 t="* tw ucfirst">快速註冊</h4>
			<?php if(preg_match('/fb/',$data['external_member'])):?>
				<button onclick="window.location.href='facebook.php';" class="btn-fb">FACEBOOK</button>
			<?php endif?>
			<?php if(preg_match('/g+/',$data['external_member'])):?>	
				<button onclick="window.location.href='google.php';" class="btn-google">GOOGLE</button>
			<?php endif?>
			<?php if(preg_match('/line/',$data['external_member'])):?>
			<a href="linelogin.php" class=""><img src="https://image.buyersline.com.tw/btn_login_base.png"></a>	
			<?php endif?>
		</section>

		<div class="hrTitle"><span>OR<?php //echo t('OR','en')?></span></div>
	<?php endif?>
	

	<section class="block">		
		<h4 t="* tw ucfirst">註冊會員</h4>
		<div class="blockInfoTxt"><?php if(0):?>xxxxxxxxx Enter your message in the box provided and include as many details as possible to help us assist you with your inquiry. Fields marked with * are required.<?php endif?></div>

		<?php // include 'view/system/form_start.php'// 2018-06-20 取代form開頭的標籤?>
		<form class="form_start">

			<div class="formItem">
				
				<label  class="must"><?php echo $_login_account_text?></label>
				
				<input type="<?php echo $_login_account_type?>" id="login_account" name="login_account" value="<?php if(isset($_SESSION['save']['guestlogin']['login_account']) && $save['login_account']==''):?><?php echo $_SESSION['save']['guestlogin']['login_account']?><?php else:?><?php echo $save['login_account']?><?php endif?>">
			</div>
			<div class="Bbox_in_2c">
				<div>
					
					<div class="formItem">
						<label class="must" t="* tw ucfirst">姓名</label>
						<input type="text" id="name" name="name" value="<?php if(isset($_SESSION['save']['guestlogin']['name']) && $save['name']==''):?><?php echo $_SESSION['save']['guestlogin']['name']?><?php else:?><?php echo $save['name']?><?php endif?>" />
					</div>
					<div class="formItem">
						<label t="* tw ucfirst">性別</label>
						<div class="radio">
							<label><input type="radio" name="gender" t="value tw ucfirst" value="1" /> <span t="* tw ucfirst">男</span> </label>
							<label><input type="radio" name="gender" t="value tw ucfirst" value="2" /> <span t="* tw ucfirst">女</span> </label>
						</div>
					</div>								
					<div class="formItem">
						<label class="must" t="* tw ucfirst">密碼</label>
						<input type="password" id="login_password" name="login_password">
					</div>	
										
					<div class="formItem">
						<label class="must" t="* tw ucfirst">再次輸入密碼</label>
						<input type="password" id="login_password_confirm" name="login_password_confirm">
					</div>

					<div class="formItem">
						<label t="* tw ucfirst">生日</label>
						<input type="date" name="birthday" value="<?php echo $save['birthday']?>">					</div>
					<?php if($_constant=='email'):?>					
					<div class="formItem">
						<label t="* tw ucfirst">電話</label>
						<input type="text" id="phone" name="phone" value="<?php echo $save['phone']?>" inputmode="tel">
					</div>	
					<?php elseif($_constant=='phone'):?>
					<div class="formItem">
						<label t="* tw ucfirst">E-mail</label>
						<input type="email" id="email" name="email" value="<?php echo $save['email']?>" inputmode="email">
					</div>
					<?php elseif($_constant=='account'):?>
					<div class="formItem">
						<label class="must" t="* tw ucfirst">E-mail</label>
						<input type="email" id="email" name="email" value="<?php echo $save['email']?>" inputmode="email">
					</div>	
					<?php endif?>

				</div>
			</div>						
			<div>
				<div class="formItem oneLine">
					<label t="* tw ucfirst">地址</label>
					<span class="twzipcode_form_3"></span>
				</div>	

				<div class="formItem">
					<input type="text" t="placeholder tw ucfirst" id="addr" name="addr" placeholder="地址">
				</div>
			</div>

			<div class="formItem agreementBlock">					
				<div class="checkbox">						
					<label><input type="checkbox" name="need_dm" id="" value="1" />  <span t="* tw ucfirst">願意收到產品相關訊息或活動資訊</span> </label>						
				</div>
				<div class="checkbox">						
				<label><input type="checkbox" name="accept_privacy" id="" value="1" />  <span><?php echo t('同意隱私權政策','tw')?><a href="#_" class="openBtn underLine" data-target="#memberPrivacy"><?php echo t('隱私權政策','tw')?></a></span> </label>
					<label></label>
				</div>
			</div>	

			<p><?php echo t('如有任何問題歡迎來電聯絡。若想知道會員詳請，請參考','tw')?> <a href="#_" class="openBtn underLine" data-target="#memberTerm" t="* tw ucfirst">會員需知</a></p>
						
			<div>
				<label class="must" t="* tw ucfirst">認證碼</label>
				<input type="text" id="captcha" name="captcha" inputmode="numeric"/><img id="valImageId" src="captcha.php" gwidth="100" gheight="40" /><a href="javascript:void(0)" class="icon-link" onclick="RefreshImage('valImageId')"><i class="fa fa-refresh" aria-hidden="true"></i><span t="* tw ucfirst">更新認證碼</span></a>
			</div>	
			

			<div>
				<button><i class="fa fa-user-plus"></i><?php echo t('加入會員','tw')?></button>
			</div>

			<input type="hidden" name="_social_type" value="<?php if(isset($_SESSION['save']['guestlogin']['_social_type']) and $_SESSION['save']['guestlogin']['_social_type'] != ''):?><?php echo $_SESSION['save']['guestlogin']['_social_type']?><?php endif?>" />
			<input type="hidden" name="_social_id" value="<?php if(isset($_SESSION['save']['guestlogin']['_social_id']) and $_SESSION['save']['guestlogin']['_social_id'] != ''):?><?php echo $_SESSION['save']['guestlogin']['_social_id']?><?php endif?>" />
		</form>
	</section>
</div>

<?php if(0)://下面這段搬移到 js_v3/page.js了?>
<!-- <script type="text/javascript">
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
</script> -->
<?php endif?>
