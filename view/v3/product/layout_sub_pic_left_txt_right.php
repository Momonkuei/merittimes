<?php
/*
 * 樣式變化，將底下貼到參數裡：
 * productstyle:proList_bgColor => 底色
 * productstyle:proList_FullLine => 滿框線
 * productstyle:proList_line => 框線
 */
$_product_style = '';

if(isset($_params_) and isset($_params_['productstyle']) and $_params_['productstyle'] != ''){
	$_product_style = $_params_['productstyle'];
}
?>

<div class="proList <?php echo $_product_style?>">
	<div class="itemList listType2">
		<div>
	<?php echo $AA?>
		</div>
	</div>
</div>
