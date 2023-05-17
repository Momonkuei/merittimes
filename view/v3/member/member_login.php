
<div class="memberBlockLogin">
	
	<section class="block">
		<div class="blockTitle"><?php echo t('會員登入')?></div>
		<div class="blockInfo">
			xxxxx
		</div>
	</section>

	<section class="block">
		<h4><?php echo t('帳號登入')?></h4>
		<form action="" method="post" name="memberForm" id="memberForm" onsubmit="MM_validateForm('<?php echo t('帳號')?>','','RisEmail','<?php echo t('密碼')?>','','R', '<?php echo t('認證碼')?>', '', 'R', this); return document.MM_returnValue;">
			<input type="hidden" name="gtoken" class="gtoken" />
			<input type="hidden" name="gtoken" class="gtoken" />
			<div class="Bbox_in_2c">
				<div>
					<div class="formItem">
						<label class="must"><?php echo t('帳號')?></label>
						<input type="text" id="<?php echo t('帳號')?>" name="login_account" placeholder="<?php echo t('Enter your E-mail','en')?>">
					</div>
					<div class="formItem">
						<label class="must"><?php echo t('密碼')?></label>
						<input type="password" id="<?php echo t('密碼')?>" name="login_password" placeholder="<?php echo t('Password','en')?>">
					</div>	
				</div>
			</div>
			<div class="formItem oneLine">
				<label class="must"><?php echo t('認證碼')?></label>
				<input type="text" id="<?php echo t('認證碼')?>" name="captcha" /><img id="valImageId" src="captcha.php" gwidth="100" gheight="40" /><a href="javascript:void(0)" class="icon-link" onclick="RefreshImage('valImageId')"><i class="fa fa-refresh" aria-hidden="true"></i><?php echo t('更新認證碼')?></a>
			</div>						
			<div>
				<button><i class="fa fa-sign-in"></i><?php echo t('登入')?></button> 
				<a class="icon-link" href="memberforget_<?php echo $this->data['ml_key']?>.php"><i class="fa fa-lock"></i> <?php echo t('忘記密碼?')?></a>
			</div>
		</form>
	</section>

<?php if(isset($data['external_member']) && $data['external_member']!=false)://by lota?>

	<div class="hrTitle"><span>OR<?php //echo t('OR','en')?></span></div>

	<section class="block">
		<h4><?php echo t('快速登入')?></h4>
		<form>
		<?php if(preg_match('/fb/',$data['external_member'])):?>
			<a href="facebook.php" class="btn-fb">FACEBOOK</a>
		<?php endif?>
		<?php if(preg_match('/g+/',$data['external_member'])):?>
			<a href="google.php" class="btn-google">GOOGLE</a>	
		<?php endif?>
		<?php if(preg_match('/line/',$data['external_member'])):?>
			<a href="linelogin.php" class=""><img src="https://image.buyersline.com.tw/btn_login_base.png"></a>	
		<?php endif?>	
		</form>
	</section>

	<section class="block">
		<h4><?php echo t('尚未成為會員嗎？')?></h4>
		<a href="guestregister_<?php echo $this->data['ml_key']?>.php" class="btn-cis1"><i class="fa fa-user-plus"></i><?php echo t('加入會員')?></a>	
	</section>

<?php endif?>	

</div>

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
	$("input[name=captcha]").keydown(function (e) {
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
