<div id="fastLogin_modal" class="modal">
  <div class="row">
    <div class="col-lg-6">
      <div class="pageTitleStyle-1">
        <span>帳號登入</span>
      </div>
	  <form class="row cont_form" action="index_<?php echo $this->data['ml_key']?>.php" method="post" name="memberForm" id="memberForm" onsubmit="MM_validateForm('<?php echo t('帳號')?>　','','RisEmail','<?php echo t('密碼')?>　','','R', '<?php echo t('認證碼')?>　', '', 'R', this); return document.MM_returnValue;">

		<input type="hidden" name="gtoken" class="gtoken" />
		<input type="hidden" name="next" value="checkout_<?php echo $this->data['ml_key']?>.php" />

        <div class="form_group col-lg-12">
			<label class="must"><?php echo t('帳號　')?></label>
			<input type="text" id="<?php echo t('帳號')?>　" name="login_account" placeholder="Enter your Email">
        </div>
        <div class="form_group col-lg-12">
			<label class="must"><?php echo t('密碼')?></label>
			<input type="password" id="<?php echo t('密碼')?>　" name="login_password" placeholder="Password">
        </div>
	    <div class="form_group col-lg-12">
	      <label class="must" t="* tw ucfirst">認證碼</label>
	      <div class="authenticateCode">
	      	<input type="text" id="<?php echo t('認證碼')?>　" name="captcha2" />
	      	<img id="valImageId2" src="captcha2.php" width="100" gheight="40" />
	      	<a href="javascript:void(0)" class="icon-link" onclick="RefreshImage('valImageId2')"><i class="fa fa-refresh" aria-hidden="true"></i><span t="* tw ucfirst">更新認證碼</span></a>
	      </div><!-- .authenticateCode -->
	    </div>
        <div class="form_group col-lg-12">
          <button class="btn-cis1"><i class="fa fa-sign-out" aria-hidden="true"></i><?php echo t('登入')?></button>
          <a class="icon-link" href="memberforget_<?php echo $this->data['ml_key']?>.php"><i class="fa fa-expeditedssl" aria-hidden="true"></i><?php echo t('忘記密碼')?></a>
        </div>
      </form><!-- .cont_form -->
    </div>
    <div class="col-lg-6">
      <div class="innerBlock_small_mb checkout_now">
        <div class="pageTitleStyle-1">
          <span><?php echo t('立即結帳')?></span>
        </div>
		<p><?php echo t('為簡化流程，第一次購物您不需要加入會員就可以直接進行購物。完成訂購後，系統將自動將您升級為會員。')?></p>
        <button class="btn-cis1" onclick="self.location.href='checkout_<?php echo $this->data['ml_key']?>.php?step=1'"><i class="fa fa-shopping-cart" aria-hidden="true"></i><?php echo t('第一次購物')?></button>
        <button class="btn-white" onclick="self.location.href='guestregister_<?php echo $this->data['ml_key']?>.php'"><i class="fa fa-user" aria-hidden="true"></i><?php echo t('註冊會員')?></button>
      </div><!-- .innerBlock_small -->
		<?php if(isset($data['external_member']) && $data['external_member']!=false)://by lota?>
		  <div class="innerBlock_small fast_loginBtn">
			<div class="pageTitleStyle-1">
			  <span>快速登入</span>
			</div>
			<div>
			  <a class="btn-white" href="facebook.php"><span class="icon_mbm icon_fb"></span>FACEBOOK</a>
			  <a class="btn-white" href="google.php"><span class="icon_mbm icon_google"></span>GOOGLE</a>

				<?php if(0):?>
			  <a class="btn-white" href=""><span class="icon_mbm icon_line"></span>LINE</a>
				<?php endif?>
			</div>
		  </div><!-- .innerBlock_small -->
		<?php endif?>
    </div>
  </div>
</div><!-- #fastLogin_modal-->

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
