<?php
//https://developer.paypal.com/docs/paypal-payments-standard/integration-guide/formbasics/
//sandbox
$_paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
//正式
// $_paypal_url = "https://www.paypal.com/cgi-bin/webscr";

// $_paypal_business = 'volktekpaypal@volktek.com';

$_paypal_business = 'sb-ej9qs4035847@business.example.com';

$_paypal_money = (int)$total; //帶入要付多少錢

$_paypal_custom = $save['order_number'];

$_paypal_item_name = 'This transaction order:'.$save['order_number'];

$_paypal_return = FRONTEND_DOMAIN . '/reply.php';

$_paypal_return = 'https://volktek.show.buyersline.com.tw/reply.php';
?>
<form action="<?php echo $_paypal_url?>" method="post" id="PayPalForm" target="_top">
<input type="hidden" name="business" value="<?php echo $_paypal_business?>">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="rm" value="2">
<input type="hidden" name="return" value="<?php echo $_paypal_return?>">
<input type="hidden" name="cancel_return" value="<?php echo FRONTEND_DOMAIN?>/checkout_en.php?step=2">
<input type="hidden" name="custom" value="<?php echo $_paypal_custom?>">
<input type="hidden" name="item_name" value="<?php echo $_paypal_item_name?>">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="amount" value="<?php echo $_paypal_money?>">
<input type="hidden" name="quantity" value="1"><?php //undefined_quantity 可以改數量 quantity 不可改數量 ?>
</form>
<script>document.getElementById("PayPalForm").submit();</script>

