<div class="member_password">

  <section class="sectionBlock">
    <div class="container">

      <?php //include('memberCenter_title.php'); ?>
<?php echo $__?>
      <div class="formLine"></div>
      <div class="innerBlock_small">
        <div class="blockTitle">
          <span><?php echo t('重設密碼')?></span>
        </div>
		<form class="row cont_form" action="" method="post" name="memberForm" id="contactForm" onsubmit="MM_validateForm('<?php echo t('新密碼')?>','', 'R', '<?php echo t('再輸入一次新密碼')?>','','R',this); return document.MM_returnValue;">
          <div class="form_group col-lg-4">
			<label class="must"><?php echo t('新密碼')?></label>
			<input type="password" id="<?php echo t('新密碼')?>" name="login_password" placeholder="">
          </div>
          <div class="form_group col-lg-4">
			<label class="must"><?php echo t('在次輸入新密碼')?></label>
			<input type="password" id="<?php echo t('在次輸入新密碼')?>" name="login_password_confirm" placeholder="">
          </div>
          <div class="form_group col-lg-12">
            <button class="btn-cis1"><i class="fa fa-check" aria-hidden="true"></i><?php echo t('完成')?></button>
          </div>
        </form><!-- .cont_form -->
      </div>

    </div><!-- .container -->
  </section><!-- .sectionBlock -->

</div><!-- .member_password -->

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

