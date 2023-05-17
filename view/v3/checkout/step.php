<div>
	<section class="checkOutStep block">
		<ul>
			<li <?php if($_SESSION[$this->data['router_method']]['step'] == '1'):?> class="active" <?php endif?> >
				<span class="icon"><i class="fa fa-money"></i></span>
				<div class="txt"><div class="articleTitle">STEP 1</div><?php echo t('確認訂購單')?></div>
			</li>
			<li <?php if($_SESSION[$this->data['router_method']]['step'] == '2'):?> class="active" <?php endif?> >
				<span class="icon"><i class="fa fa-pencil-square-o"></i></span>
				<div class="txt"><div class="articleTitle">STEP 2</div><?php echo t('選擇付款方式')?>&amp;<?php echo t('填寫收件資料')?></div>
			</li>
			<li <?php if($_SESSION[$this->data['router_method']]['step'] == '3'):?> class="active" <?php endif?> >
				<span class="icon"><i class="fa fa-check"></i></span>
				<div class="txt"><div class="articleTitle">STEP 3</div><?php echo t('完成訂購')?></div>
			</li>
		</ul>
	</section>
</div>			
