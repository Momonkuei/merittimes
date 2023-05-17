<div class="member_center">
<?php if(!empty($_SESSION['member_not'])){
  $member_not=$_SESSION['member_not'];
}?>
  <section class="sectionBlock">
    <div class="container">

      <?php //include('memberCenter_title.php');?>
<?php echo $__?>
      <div class="formLine"></div>

      <div class="innerBlock_small">
        <div class="blockTitle">
          <span><?php echo t('通知付款')?></span>
        </div>
        <div class="noticepay_list">
          <ul>
            <li><span><?php echo t('訂購人')?>：</span><?php echo $data[$ID]['buyer_name']?></li>
            <li><span><?php echo t('訂單編號')?>：</span><?php echo $data[$ID]['order_number']?></li>
            <li><span><?php echo t('訂單金額')?>：</span>$<?php echo number_format($data[$ID]['total'])?></li>
          </ul>
        </div><!-- .noticepay_list -->
      </div><!-- .innerBlock_small -->

      <div class="innerBlock_small">
        <div class="blockTitle">
          <span><?php echo t('填寫表單')?></span>
        </div>
		<form class="row cont_form" action="" method="post" name="memberForm" id="memberForm" onsubmit="MM_validateForm('<?php echo t('匯款日期')?>','','R','<?php echo t('匯款銀行')?>','','R','<?php echo t('匯款金額')?>','', 'R', '<?php echo t('帳號末五碼')?>', '', 'R', '<?php echo t('意見')?>', '', 'R', '<?php echo t('認證碼')?>', '', 'R', this); return document.MM_returnValue;">

			<input type="hidden" name="order_number" value="<?php echo $data[$ID]['order_number']?>" />

          <div class="form_group col-lg-6">
			<label class="must"><?php echo t('匯款日期')?></label>
			<input type="date" id="<?php echo t('匯款日期')?>" name="atm_date" value="<?php if(!empty($member_not['atm_date'])) echo $member_not['atm_date']?>">
<?php if(0):?>
            <!-- <input type="date"> -->
            <div class="form_date">
              <div class="row">
                <div class="col-lg-4">
                  <select>
                    <option value="">請選擇年份</option>
                    <?php
                      for($i=1900;$i<=2020;$i++) {
                        echo "<option value='$i'>$i</option>";
                      }
                    ?>
                  </select>
                </div>
                <div class="col-lg-4">
                  <select>
                    <option value="">請選擇月份</option>
                    <?php
                      for($i=1;$i<=12;$i++) {
                        echo "<option value='$i'>$i</option>";
                      }
                    ?>
                  </select>
                </div>
                <div class="col-lg-4">
                  <select>
                    <option value="">請選擇日期</option>
                    <?php
                      for($i=1;$i<=31;$i++) {
                        echo "<option value='$i'>$i</option>";
                      }
                    ?>
                  </select>
                </div>
              </div>
            </div><!-- .form_date -->
<?php endif?>
          </div>
          <div class="form_group col-lg-6">
			<label class="must"><?php echo t('匯款銀行')?></label>
			<input type="text" id="<?php echo t('匯款銀行')?>" name="atm_bank" value="<?php if(!empty($member_not['atm_bank'])) echo $member_not['atm_bank']?>">
          </div>
          <div class="form_group col-lg-6">
			<label class="must"><?php echo t('匯款金額')?></label>
			<input type="text" id="<?php echo t('匯款金額')?>" name="atm_price" value="<?php if(!empty($member_not['atm_price'])) echo $member_not['atm_price']?>">
          </div>
          <div class="form_group col-lg-6">
			<label class="must"><?php echo t('帳號末五碼')?></label>
			<input type="text" id="<?php echo t('帳號末五碼')?>" name="atm_number" value="<?php if(!empty($member_not['atm_number'])) echo $member_not['atm_number']?>">
          </div>
          <div class="form_group col-lg-12">
            <label class="must"><?php echo t('備註')?></label>
			<textarea rows="5" cols="80" name="atm_comment"><?php if(!empty($member_not['atm_comment'])) echo $member_not['atm_comment']?></textarea>
          </div>
		  <div class="form_group col-lg-12">
			<label class="must" t="* tw ucfirst">認證碼</label>
			<div class="authenticateCode">
				<input type="text" id="<?php echo t('認證碼')?>" name="captcha" />
				<img id="valImageId" src="captcha.php" width="100" gheight="40" />
				<a href="javascript:void(0)" class="icon-link" onclick="RefreshImage('valImageId')"><i class="fa fa-refresh" aria-hidden="true"></i><span t="* tw ucfirst">更新認證碼</span></a>
			</div><!-- .authenticateCode -->
		  </div>
          <div class="form_group col-lg-12 even_btn">
            <button class="btn-white" onclick="javascript:window.history.back();return false;"><i class="fa fa-reply" aria-hidden="true"></i><?php echo t('返回')?></button>
            <button class="btn-cis1"><i class="fa fa-paper-plane" aria-hidden="true"></i><?php echo t('送出')?></button>
          </div>
        </form><!-- .cont_form -->
      </div><!-- .innerBlock_small -->

    </div><!-- .container -->
  </section><!-- .sectionBlock -->

</div><!-- .member_center -->

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
$("input[name=atm_price],input[name=atm_number]").keydown(function (e) {
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
