<?php
//會員登入型態
unset($_constant);
eval('$_constant = CUSTOMER_LOGIN_TYPE'.';');
?>

<div class="memberBlockForgot">
	
	<section class="block">
		<div class="blockTitle"><?php echo t('密碼查詢')?></div>
		<?php if($_constant=='email' or $_constant=='account'):?>
		<p class="blockInfoTxt">
			1.<?php echo t('索取 [密碼查詢信件]')?><br>
			2.<?php echo t('收取電子郵件')?><br>
			3.<?php echo t('請輸入您註冊時填寫的E-mail，您的新密碼將通過電子郵件重新設定！')?>
		</p>
		<?php elseif($_constant=='phone'):?>
		<p class="blockInfoTxt">
			1.<?php echo t('索取 [密碼查詢簡訊]')?><br>
			2.<?php echo t('收取簡訊')?><br>
			3.<?php echo t('請輸入您註冊時填寫的手機號碼，您的新密碼將通過簡訊重新設定！')?>
		</p>
		<?php endif?>

	<?php if($_constant=='email' or $_constant=='account'):?>
		<form action="" method="post" name="memberForm" id="memberForm" onsubmit="MM_validateForm('<?php echo t('E-Mail','en')?>','','R', '<?php echo t('認證碼')?>', '', 'R', this); return document.MM_returnValue;">

			<div class="formItem">
				<label class="must"><?php echo t('E-Mail','en')?></label>
				<input type="email" id="<?php echo t('E-Mail','en')?>" name="login_account" placeholder="<?php echo t('請輸入您的電子郵件信箱')?>" inputmode="email">
			</div>

	<?php elseif($_constant=='phone'):?>
		<form action="" method="post" name="memberForm" id="memberForm" onsubmit="MM_validateForm('<?php echo t('mobile','en')?>','','R', '<?php echo t('認證碼')?>', '', 'R', this); return document.MM_returnValue;">	

			<div class="formItem">
				<label class="must"><?php echo t('手機號碼')?></label>
				<input type="text" id="<?php echo t('mobile','en')?>" name="login_account" placeholder="<?php echo t('請輸入您的手機號碼')?>" inputmode="tel">
			</div>
	<?php endif?>

			<div>
				<label class="must"><?php echo t('認證碼')?></label>
				<input type="text" id="<?php echo t('認證碼')?>" name="captcha" inputmode="numeric" /><img id="valImageId" src="captcha.php" gwidth="100" gheight="40" /><a href="javascript:void(0)" class="icon-link" onclick="RefreshImage('valImageId')"><i class="fa fa-refresh" aria-hidden="true"></i><?php echo t('更新認證碼')?></a>
			</div>	
									
			<div class="Bbox_flexBetween">
				<button><i class="fa fa-paper-plane"></i><?php echo t('送出')?></button>					
			</div>
		</form>
	</section>
	
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
<?php endif?><!-- body_end -->
