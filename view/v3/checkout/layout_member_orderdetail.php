<div>
	<div class="blockTitle"><span><?php echo t('訂單記錄')?></span></div>
	<p class="blockInfoTxt">					
		<?php echo $data[$ID]['buyer_name']?><?php echo t('您好，以下是你的訂單歷史記錄')?>
	</p>	

	<?php // include 'common/shop_orderdetail_orderstatus.php';?>
	<?php // include 'common/shop_orderdetail_prolist.php';?>

<?php echo $AA?>

	<a class="btn-prev" href="memberorderlist_<?php echo $this->data['ml_key']?>.php"><i class="fa fa-reply"></i><?php echo t('返回')?></a>	
	<a class="btn-cis1" href="membercenter_<?php echo $this->data['ml_key']?>.php"><i class="fa fa-reply"></i><?php echo t('會員中心')?></a>
</div>
