<div class="text-center apply-title">
				<span>密碼查詢</span>
		</div>
<div class="member_forgot">

  <section class="sectionBlock">
    <div class="container">


      <div class="form-border">
        <div class="application-form form-border-no-title">

          <!-- <div class="pageTitleStyle-1">
            <span>PASSWORD ASSISTANCE</span>
          </div> -->

          <!-- <div class="blockTitle">
            <span>密碼查詢</span>
          </div> -->
          <p class="common_gy_txt">
            「密碼查詢功能」僅供學校代表窗口查詢使用。<br>
              若是教師或學生忘記密碼，請洽貴校的學校代表窗口聯繫索取，謝謝!<br><br>

              學校代表窗口請依據以下步驟索取密碼。<br>
              1.請輸入您註冊時填寫的「帳號」<br>
              2.您的新密碼將通過電子郵件發送給您<br>
              3.請到您註冊時填寫的 E-mail 收取電子郵件<br>
              4.依據信件中指示進行密碼重設<br>
          </p>

          <form class="row cont_form" action="" method="post" name="memberForm" id="memberForm" onsubmit="MM_validateForm('<?php echo t('認證碼') ?>', '', 'R', this); return document.MM_returnValue;">
            <div class="form_group col-lg-12">
              <label class="must">帳號</label>
              <input type="text" id="login_account" name="login_account" placeholder="<?php echo t('請輸入您的帳號') ?>">
            </div>
            <div class="form_group col-lg-12">
              <label class="must" t="* tw ucfirst">認證碼</label>
              <div class="authenticateCode">
                <input type="text" id="captcha" name="captcha" />
                <img id="valImageId" src="captcha.php" width="100" gheight="40" />
                <a href="javascript:void(0)" class="icon-link" onclick="RefreshImage('valImageId')"><i class="fa fa-refresh" aria-hidden="true"></i><span t="* tw ucfirst">更新認證碼</span></a>
              </div><!-- .authenticateCode -->
            </div>
            <div class="form_group col-lg-12">
              <button class="btn-cis1"><i class="fa fa-paper-plane-o" aria-hidden="true"></i>送出查詢</button>
            </div>
          </form><!-- .cont_form -->
        </div>
      </div>

    </div><!-- .container -->
  </section><!-- .sectionBlock -->

</div><!-- .member_forgot -->

<?php if (0) : ?><!-- head_end -->
  <script type="text/javascript">
    var msgErrorTip1 = '<?php echo t('請輸入要搜尋的關鍵字。') ?>';
    var msgErrorTip2 = '<?php echo t('請輸入') ?>「%s」';
    var msgErrorTip3 = '<?php echo t('E-Mail', 'en') ?>，<?php echo t('請輸入正確的Email格式') ?>';
    var msgProcess = '<?php echo t('處理中') ?>...';
  </script>
  <script src="js_common/confirm_form.js"></script>
<?php endif ?><!-- head_end -->

<?php if (0) : ?><!-- body_end -->
  <script src="js_common/reload.js"></script>
<?php endif ?><!-- body_end -->
<script src="js_common/reload.js" m="body_end"></script>