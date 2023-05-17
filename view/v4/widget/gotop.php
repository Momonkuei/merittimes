<?if($this->data['router_method'] != 'photocopyform_1'){?>
<div class="pageWidget floatIconBar">
	<?php
	// 2020-08-05
	// 後台/最大/常數/開啟購物功能 要打開，才會執行裡面的東西
	// 2021-01-28
	// 側邊浮動的icon要包在.pageWidget裡面，才不會被包在mbPanel裡面，手機版才能正常固定在畫面上，否則就要修正mb_panel.php裡:not()的類別
	unset($_constant);
	eval('$_constant = ' . strtoupper('shop_open') . ';');
	?>
	<?php if ($_constant == 1) : ?>
		<!-- <a class="showCart" data-fancybox data-src="#sideCart_modal" data-options='{"touch" : false}' href="javascript:;"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>			 -->
	<?php endif ?>

	<?php
	//判斷SESSION是否有詢問資料，如有則顯示提示連結 by lota
	if (isset($_SESSION['save'])) {
		$_row = $_SESSION['save'];
		if (isset($_SESSION['save']['shop_car']) && count($_SESSION['save']['shop_car']) > 0) { ?>
			<a id="showCart" class="showCart_img" data-fancybox data-src="#sideCart_modal" data-options='{"touch" : false}' href="javascript:;"><img aria-hidden="true" src="images_v4/food/shop.png" alt="" width="80px"></a>
	<? }
	}
	//var_dump($_row);
	$_inquiry = array();
	if (isset($_row)) {
		foreach ($_row as $key => $value) {
			if (preg_match('/^(.*)inquiry$/', $key, $matches)) {
				$_count_key = count($value);
				if ($_count_key > 0) {
					$_check_ml_key = false;
					foreach ($value as $key1 => $value1) {
						if ($value1['ml_key'] == $this->data['ml_key']) {
							$_check_ml_key = true;
						}
					}
					if ($_check_ml_key) {
						$_inquiry[] = $matches[1];
					}
				}
			}
		}
	}
	$_count_inquiry = count($_inquiry);
	?>
	<?php if ($_count_inquiry > 0) : ?>
		<?php foreach ($_inquiry as $key => $value) : ?>
			<?php if (0) : //原本的樣式
			?>
				<a class="inquiryInfo" href="<?php echo $value ?>inquiry_<?php echo $this->data['ml_key'] ?>.php"><i class="fa fa-info-circle" aria-hidden="true"></i><?php echo t('詢問車', 'tw') ?></a>
			<?php endif ?>
			<?php //for jane新英文版詢價
			?>
			<a class="inquiryInfo floatIcon	InquireIcon" href="<?php echo $value ?>inquiry_<?php echo $this->data['ml_key'] ?>.php"><i class="icon-Inquire"></i><span><?php echo t('詢問車', 'tw') ?></span></a>

		<?php endforeach ?>
	<?php else : ?>
		<?php if (0) : //原本的樣式
		?>
			<a class="inquiryInfo" href="" style="display:none"><i class="fa fa-info-circle" aria-hidden="true"></i><?php echo t('詢問車', 'tw') ?></a>
		<?php endif ?>
		<?php //for jane新英文版詢價
		?>
		<a class="inquiryInfo floatIcon	InquireIcon" href="" style="display:none"><i class="icon-Inquire"></i><span><?php echo t('詢問車', 'tw') ?></span></a>
	<?php endif ?>
</div>

<!-- <div class="fixedIcons">
	<a class="fixedIcons_line" style="background-image: url('images_v4/fixedIcon/Icon_line.png');" href="#"></a>
	<a class="fixedIcons_fb" href="#">
		<i class="fa fa-facebook-f"></i>
	</a>
	<a class="fixedIcons_mail" href="#">
		<i class="fa fa-envelope"></i>
	</a>
	<a class="fixedIcons_phone" href="#">
		<i class="fa fa-phone"></i>
	</a>
</div> -->

<a id="goTop" class="gotop">
	<!-- <img src="images_v4/icon/gotop.svg" alt=""> -->
	<img src="images_v4/icon/gotop.png" alt="">
</a>


<div class="videoLightboxFix pageWidget">
	<div>
		<div class="videoClose">
			<i class="fa fa-times" aria-hidden="true"></i>
		</div>
		<div class="videoIframe">
		</div>
	</div>
</div>
<?}?>