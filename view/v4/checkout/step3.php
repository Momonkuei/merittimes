<?php if($_SESSION[$this->data['router_method']]['step'] == '3'):?>

<!-- // DATA2:SINGLE -->
<?php $shipment = $data[$ID]?>
<!-- // DATA2:SINGLE -->
<?php $payment = $data[$ID]//所選取的那筆金流?>
<!-- // DATA2:SINGLE -->
<?php $order = $data[$ID]//訂單相關狀態?>

<!-- // DATA2:MULTI -->
<?php $payments = $data[$ID]?>

<div id="print_order">

	<?php if($order['status'] === true):?>
		<div class="innerBlock">
		  <div class="thankyouBlk text-center">
			<img src="images_v4/thankyou.svg" alt="">
			<p><?php echo t('感謝您本次消費，我們將盡快為您處理訂單!')?></p>
		  </div>
		</div><!-- .innerBlock -->
	<?php else:?>
		<?php if(isset($payments)):?>
			<? // 選擇付款方式?>

			<?php if(!empty($payment)):?>
				<div class="nextStepBtn">
					<?php if($payment['has_check_finish'] === true):?>
						<div class="nextStepBtnGroup endOrder">
							<a class="btn-cis1 step3" href="javascript:;"><i class="fa fa-check"></i><?php echo t('確認訂購')?></a>
						</div>
					<?php endif?>

					<?php if(isset($payment['need_payment_step']) and $payment['need_payment_step'] === true):?>
						<div class="nextStepBtnGroup goPay">
							<a class="btn-cis1 step3" href="javascript:;"><i class="fa fa-money"></i><?php echo t('立即付款')?></a>
						</div>
					<?php endif?>
				</div>
			<?php endif?>
		<?php endif?>
	<?php endif?>

<?php // include 'orderdetail.php'; ?>
<?php echo $__?>

	  <div class="even_btn">
		<?php if($order['status'] === false):?>
			<a class="btn-cis1" href="checkout_<?php echo $this->data['ml_key']?>.php?step=2"><i class="fa fa-reply"></i><?php echo t('上一步')?></a>								
		<?php endif?>

		<?php if(isset($order['status']) and $order['status'] === true):?>
			<a class="btn-white2" href="#_" id="print_button"><i class="fa fa-print"></i><?php echo t('列印')?></a>	
			<a class="btn-cis1" href="memberorderlist_<?php echo $this->data['ml_key']?>.php"><i class="fa fa-file-text-o"></i><?php echo t('回訂單列表')?></a>	

			<?php if($payment['payment_notice'] == true):?>
				<a class="btn-cis1" href="membernoticepayment_<?php echo $this->data['ml_key']?>.php?order_number=<?php echo $order['order_number']?>"><i class="fa fa-bell"></i><?php echo t('通知付款')?></a>
			<?php endif?>
		<?php endif?>

	  </div><!-- .even_btn -->
	</div><!-- .innerBlock -->
</div><?php // print_order?>

<?php if(0):?><!-- body_end -->
<script type="text/javascript" src="js_v4/print-master/jQuery.print.js" />
<script type="text/javascript">
$(function(){
	$("body").on('click','#print_button',function(){
		$.print("#print_order");
	});
});
<?php if(isset($_SESSION['save']['step3']['payment_reply_alert_log']) and $_SESSION['save']['step3']['payment_reply_alert_log'] != ''):?>
	alert('<?php echo $_SESSION['save']['step3']['payment_reply_alert_log']?>');
	<?php unset($_SESSION['save']['step3']['payment_reply_alert_log'])?>
<?php endif?>
</script>
<?php endif?><!-- body_end -->

<?php
if(isset($_SESSION['save']['step3']['go_to_finish!!']) and $_SESSION['save']['step3']['go_to_finish!!'] == '1'){
	// 這個步驟留到最後做，只有這一次!
 	unset($_SESSION['save']);
	unset($_SESSION[$this->data['router_method']]);
}
else{
	if(isset($payment['auto_step3_click_run']) && $payment['auto_step3_click_run']==true ){
	//2020-12-20 增加自動按鈕 step3 的動作 讓頁面自動轉跳 by lota
?>
<script type="text/javascript" m="body_end">
$(function(){
	$(".step3").click();
});
</script>
<?php } } ?>

<?php endif?><?php // step3?>
