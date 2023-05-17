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
			<h4 class="text-center">		
				<img src="images/<?php echo $this->data['ml_key']?>/shop-checkout-thankyou.svg"><br>
				<?php echo t('感謝您本次消費，我們將盡快為您處理訂單!')?>
			</h4>	
			<div class="hrTitle"><span><?php echo t('訂單明細')?></span></div>
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

				<div class="hrTitle"><span><?php echo t('訂單明細')?></span></div>		
			<?php endif?>
		<?php endif?>


<?php // include 'orderdetail.php'; ?>
<?php echo $AA?>

		<?php if($order['status'] === false):?>
			<div>
				<a class="btn-prev" href="checkout_<?php echo $this->data['ml_key']?>.php?step=2"><i class="fa fa-reply"></i><?php echo t('上一步')?></a>

				<?php if(!empty($payment)):?>
					<?php if(isset($payment['need_payment_step']) and $payment['need_payment_step'] === true):?>
						<a class="shopBtn whiteBtn step3" href="javascript:;"><i class="fa fa-money" aria-hidden="true"></i>立即付款</a>
					<?php endif?>
				<?php endif?>						
						
			</div>
		<?php endif?>

		<?php if(isset($order['status']) and $order['status'] === true):?>
			<a class="btn-cis1" href="#_" id="print_button"><i class="fa fa-print"></i><?php echo t('列印')?></a>	
			<a class="btn-cis1" href="memberorderlist_<?php echo $this->data['ml_key']?>.php"><i class="fa fa-file-text-o"></i><?php echo t('回訂單列表')?></a>	

			<?php if($payment['payment_notice'] == true):?>
				<a class="btn-cis1" href="membernoticepayment_<?php echo $this->data['ml_key']?>.php?order_number=<?php echo $order['order_number']?>"><i class="fa fa-bell"></i><?php echo t('通知付款')?></a>
			<?php endif?>
		<?php endif?>

	</div><?php // print_order?>

<?php  
if(isset($_SESSION['save']['step3']['go_to_finish!!']) and $_SESSION['save']['step3']['go_to_finish!!'] == '1'){
/*
* 美安訂單
*/
if( isset($this->data['MarketAn']) && $this->data['MarketAn']['is_enable'] == 1 ){
	if( isset($_SESSION["RID"]) && isset($_SESSION["Click_ID"]) && isset($order['order_number']) && (isset($_SESSION['save']['step3']['MarketAn_total_sub']) && $_SESSION['save']['step3']['MarketAn_total_sub'] > 0 ) ){

		$_mn_c_amount = $_SESSION['save']['step3']['MarketAn_total_sub']; //總計 (不含運費)

		$_mn_OFFER_ID = $this->data['MarketAn']['OFFER_ID'];

		$_mn_Advertiser_ID = $this->data['MarketAn']['Advertiser_ID'];

		$_mn_commission = $this->data['MarketAn']['commission'];

?>
<!-- Offer Conversion: -->
<iframe src="https://api.hasoffers.com/Api?Format=json&Target=Conversion&Method=create&Service=HasOffers&Version=2&NetworkId=marktamerica&NetworkToken=NETPYKNAYOswzsboApxaL6GPQRiY2s&data[offer_id]=<?php echo $_mn_OFFER_ID?>&data[advertiser_id]=<?php echo $_mn_Advertiser_ID?>&data[sale_amount]=<?php echo $_mn_c_amount?>&data[affiliate_id]=12&data[payout]=<?php echo round($_mn_c_amount * $_mn_commission,2);//佣金?>&data[revenue]=<?php echo round($_mn_c_amount * $_mn_commission,2);//佣金?>&data[advertiser_info]=<?php echo $order['order_number']?>&data[affiliate_info1]=<?php echo $_SESSION["RID"]?>&data[ad_id]=<?php echo $_SESSION["Click_ID"]?>&data[session_datetime]=<?php echo date('Y-m-d')?>" width="1" height="1" />
<!-- // End Offer Conversion -->
<?php } } }?>

<?php if(0):?><!-- body_end -->
<?php //2021-1-11 這個套件chrome好像失效了..改用其他方式列印?>
<!--<script type="text/javascript" src="js_v3/print-master/jQuery.print.js" />-->

<script type="text/javascript">
function printHtml(html) {
	var bodyHtml = document.body.innerHTML;
	document.body.innerHTML = html;
	window.print();
	document.body.innerHTML = bodyHtml;
	//window.location.reload(); //列印輸出後更新頁面
}

function onprint(printarea) {
	//去除超連結設置
	//$('a').each(function(index) {
	//	$(this).replaceWith($(this).html());
	//});

	var html = $(printarea).html();
	printHtml(html);
}

$(function(){
	$("body").on('click','#print_button',function(){
		// $.print("#print_order");
		onprint('#print_order');
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
 	//如果要要兩個購物車，就把上面註解，換下面的
 	// unset($_SESSION['save']['step2']);
 	// unset($_SESSION['save']['step3']);
 	// unset($_SESSION['save']['shop_car']);
 	// unset($_SESSION['save']['invoice_1']);
 	// unset($_SESSION['save']['member_form_1']);
 	// unset($_SESSION['save']['member_form_2']);
 	// unset($_SESSION['save']['selecxt_payment']);
 	// unset($_SESSION['save']['selecxt_physical']);
	
	unset($_SESSION[$this->data['router_method']]);
	//美安訂單 處理完後就刪除session
	unset($_SESSION["RID"]);
	unset($_SESSION["Click_ID"]);
}else{
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
