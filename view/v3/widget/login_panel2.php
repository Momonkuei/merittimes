<div id="loginPanel" class="loginPanel popBox">
	<div class="closeSpace closeBtn" data-target="#loginPanel"></div>
	<div class="boxContent">
		<a href="#_" class="closeBtn" data-target="#loginPanel"><i class="fa fa-times"></i></a>
		<div class="mainContent">
			<div class="gridBox closest" data-grid="1">
				<div class="userLogin" data-rwd="">
					<div class="boxTitle"><?php echo t('會員登入')?></div>
					<section class="">
						<form action="index_<?php echo $this->data['ml_key']?>.php" method="post" name="memberForm" id="memberForm" onsubmit="MM_validateForm('<?php echo t('帳號')?>　','','RisEmail','<?php echo t('密碼')?>　','','R', '<?php echo t('認證碼')?>　', '', 'R', this); return document.MM_returnValue;">
							<input type="hidden" name="gtoken" class="gtoken" />
							<?php //if($this->data['router_method'] == 'academicjournal' ):?>
							<input type="hidden" name="next" value=""/>
							<div>
								<div class="formItem">
									<label class="must"><?php echo t('帳號　')?></label>
									<input type="text" id="<?php echo t('帳號')?>　" name="login_account" placeholder="Enter your Email">
								</div>
								<div class="formItem">
									<label class="must"><?php echo t('密碼')?></label>
									<input type="password" id="<?php echo t('密碼')?>　" name="login_password" placeholder="Password">
								</div>	
							</div>

							<div class="formItem oneLine">
								<label class="must"><?php echo t('認證碼')?></label>
								<input type="text" id="<?php echo t('認證碼')?>　" name="captcha2" /><img id="valImageId" src="captcha2.php" gwidth="100" gheight="40" /><a href="javascript:void(0)" class="icon-link" onclick="RefreshImage('valImageId')"><i class="fa fa-refresh" aria-hidden="true"></i><?php echo t('更新驗證碼')?></a>
							</div>						
								
							<div class="formItem oneLine">
								<button><i class="fa fa-user"></i><?php echo t('登入')?></button> 
								<a class="icon-link" href="memberforget_<?php echo $this->data['ml_key']?>.php"><i class="fa fa-lock"></i> <?php echo t('忘記密碼')?>?</a>
								<a href="guestregister_<?php echo $this->data['ml_key']?>.php" class="icon-link"><i class="fa fa-user"></i><?php echo t('註冊會員')?></a>
							</div>
						</form>
					</section>
					
				</div>

				<?/*
				<div class="firstShop" data-rwd="m2">
					<div class="boxTitle"><?php echo t('立即結帳')?></div>
					<section>
						<form>
							<div class="blockInfo">
								<p><?php echo t('為簡化流程，第一次購物您不需要加入會員就可以直接進行購物。完成訂購後，系統將自動將您升級為會員。')?></p>
							</div>
							<div class="formItem oneLine">
								<a href="checkout_<?php echo $this->data['ml_key']?>.php?step=1" class="btn-cis1"><i class="fa fa-shopping-cart"></i><?php echo t('第一次購物')?></a>
								<a href="guestregister_<?php echo $this->data['ml_key']?>.php" class="icon-link"><i class="fa fa-user"></i><?php echo t('註冊會員')?></a>
							</div>
						</form>
					</section>

				<?php if(isset($data['external_member']) && $data['external_member']!=false)://by lota?>

					<div class="hrTitle"><span>OR</span></div>
					<section class="">
						<form>
						<?php if(preg_match('/fb/',$data['external_member'])):?>
							<a href="facebook.php" class="btn-fb">FACEBOOK</a>
						<?php endif?>
						<?php if(preg_match('/g+/',$data['external_member'])):?>
							<a href="google.php" class="btn-google">GOOGLE</a>	
						<?php endif?>						
						</form>
					</section>
				<?php endif?>

				</div>
				*/?>
			</div>
		</div>
	</div>
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
	$("input[name=captcha2]").keydown(function (e) {
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
