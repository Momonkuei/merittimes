<div class="checkOutStep">
  <ul>
	<li <?php if($_SESSION[$this->data['router_method']]['step'] == '1'):?> class="active" <?php endif?> >
		<span class="icon"><i class="fa fa-credit-card-alt" aria-hidden="true"></i></span>
		<div class="txt"><div class="stepTitle">STEP 1</div><div class="stepTxt"><?php echo t('確認訂購單')?></div></div>
	</li>
			<li <?php if($_SESSION[$this->data['router_method']]['step'] == '2'):?> class="active" <?php endif?> >
		<span class="icon"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>
		<div class="txt"><div class="stepTitle">STEP 2</div><div class="stepTxt"><?php echo t('選擇付款方式')?>&amp;<?php echo t('填寫收件資料')?></div></div>
	</li>
	<li <?php if($_SESSION[$this->data['router_method']]['step'] == '3'):?> class="active" <?php endif?> >
		<span class="icon"><i class="fa fa-check" aria-hidden="true"></i></span>
		<div class="txt"><div class="stepTitle">STEP 3</div><div class="stepTxt"><?php echo t('完成訂購')?></div></div>
	</li>
  </ul>
</div><!-- .checkOutStep -->
