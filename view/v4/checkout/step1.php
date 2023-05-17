<?php if($_SESSION[$this->data['router_method']]['step'] == '1'):?>

<!-- // DATA2:SINGLE -->
<?php $bonus = $data[$ID];//會員的紅利?>

<!-- // DATA2:MULTI -->
<?php $car = $data[$ID];//購物車裡面的東西?>
<!-- // DATA2:MULTI -->
<?php $calculate_logs = $data[$ID];//計算機?>
<!-- // DATA2:MULTI -->
<?php $how_much_difference = $data[$ID];//你只差多少?>
<!-- // DATA2:MULTI -->
<?php $error_logs = $data[$ID];//錯誤訊息?>
<!-- // DATA2:MULTI -->
<?php $additional_purchases = $data[$ID];//加購(簡稱ap)?>

	<div class="innerBlock">
	  <?php if(isset($car) and !empty($car)):?>
		  <div class="blockTitle">
			<span><?php echo t('訂單內容')?></span>
		  </div>
		  <div class="rwdTable">
			<table class="tableList">
			  <thead>
				<tr>
					<th><?php echo t('商品名稱')?></th>
					<th><?php echo t('商品規格')?></th>
					<th><?php echo t('價格')?></th>			
					<th><?php echo t('小計')?></th>
					<th><?php echo t('修改')?></th>
					<th><?php echo t('刪除')?></th>
				</tr>
			  </thead>
			  <tbody>
				<?php foreach($car as $k => $v):?>
					<tr>
						<td>
							<div class="mbm_orderProItem">
							  <div class="order_proImg"><img src="<?php echo $v['item']['pic']?>" alt=""></div>
							  <div>							  	
							  	<?php if(isset($v['item']['promotion_name']) && $v['item']['promotion_name']!=''):?>
									<div class="tips_active">活動 <?php echo $v['item']['promotion_name']?></div>	
								<?php endif?>							
									<small><?php echo $v['item']['name']?></small>
							  </div>
							  	
							</div>
						</td>

						<td class="itemSpec">
							<?php if(isset($v['spec']) and $v['spec'] != ''):?>
								<?php echo $v['spec']?><br />
							<?php endif?>

							<?php if(isset($v['amount'])):?>
								<?php echo t('數量')?> / <?php echo $v['amount']?>
							<?php endif?>
						</td>

						<td>
							<?php echo '$'.$v['item']['price'];//$v['item']['price_format_ds'];//這邊不知道為什麼會帶入同產品購物車的最後一個規格金額...先改用price顯示 by lota 2021-06-08?>
						</td>

						<td>$<?php echo number_format($v['item']['price'] * $v['amount']);?></td>
						<td><a data-fancybox data-src="#addCartPanel_<?php echo $k?>" data-target="#addCartPanel_<?php echo $k?>" href="javascript:;" item_id="<?php echo $v['item_id']?>" class="openBtn icon-link"><i class="fa fa-pencil"></i><?php echo t('修改')?></a></td>
						<td><a href="javascript:;" class="icon-link delcar" item_id="<?php echo $k?>" ><i class="fa fa-trash"></i><?php echo t('刪除')?></a></td>
					</tr>
				<?php endforeach?>
			  </tbody>
			</table>
		  </div><!-- .rwdTable -->
	  <?php endif?>

	<?php if(isset($data['shop_show_coupon']) && $data['shop_show_coupon']==true):?>
	  <div class="checkCoupon">
		<form class="cont_form">
		  <p><?php echo t('請輸入優惠券代碼')?></p>
		  <input type="text" id="gift_serial_number" value="<?php if(isset($_SESSION['save']['goodies_number']['gift_serial_number'])):?><?php echo $_SESSION['save']['goodies_number']['gift_serial_number']?><?php endif?>" />
		  <div class="even_btn">
			<a id="del_goodies" class="btn-white2" href="javascript:;"><i class="fa fa-times" aria-hidden="true"></i>取消優惠券</a>
			<a id="use_goodies" class="btn-cis1" href="javascript:;"><i class="fa fa-chevron-right" aria-hidden="true"></i>使用優惠券</a>
		  </div><!-- .even_btn -->
		</form>
	  </div><!-- .orderCoupon -->
	<?php endif?>

<?php if(0):?><!-- body_end -->
<script type="text/javascript">
$('body').on('click','#use_goodies',function(){
	$.ajax({
		type: "POST",
		data: {
			'id': 'goodies_number',
			'gift_serial_number': $('#gift_serial_number').val()
			//'primary_key': 'ggg',
			//'_append': ''
		},
		url: 'save.php',
		success: function(response){
			//window.location.reload();
			$.ajax({
				type: "GET",
				data: {
					'ajax': 1
				},
				url: 'checkout_<?php echo $this->data['ml_key']?>.php',
				success: function(response){
					eval(response);
					location.reload();
				}
			}); // ajax
		}
	}); // ajax
	return false;
});
$('body').on('click','#del_goodies',function(){
	$.ajax({
		type: "POST",
		data: {
			'id': 'goodies_number',
			'gift_serial_number': ''
			//'primary_key': 'ggg',
			//'_append': ''
		},
		url: 'save.php',
		success: function(response){
			window.location.reload();
		}
	}); // ajax
	return false;
});
$('body').on('click','.use_bonus input[name=use_bonus]',function(){
	var use_bonus = '';
	if($('.use_bonus input[name=use_bonus]').is(':checked')){
		use_bonus = $('.use_bonus input[name=use_bonus]:checked').val();
	}
	$.ajax({
		type: "POST",
		data: {
			'id': 'use_bonus',
			'use': use_bonus
		},
		url: 'save.php',
		success: function(response){
			location.reload();
		}
	}); // ajax
});
</script>
<?php endif?><!-- body_end -->
	  <div class="orderTotal">
		<table>
		  <tbody>
			<?php if(isset($calculate_logs)):?>
				<?php foreach($calculate_logs as $k => $v):?>
					<tr <?php if($v[0]=='總計'):?> class="total" <?php endif?> ><td><?php echo $v[0]?></td><td><?php if($v[0]=='總計'):?><b><?php echo $v[1]?></b><?php elseif($v[0]=='運費'):?><span class="shipPrice"><?php echo $v[1]?></span><?php else:?><?php echo $v[1]?><?php endif?></td></tr>	
				<?php endforeach?>
			<?php endif?>
		  </tbody>

			<?php if(isset($how_much_difference)):?>
				<?php foreach($how_much_difference as $k => $v):?>
					<a href="javascript:;" class="tips"><?php echo $v?></a><br />
				<?php endforeach?>
			<?php endif?>
		</table>
	  </div><!-- .orderTotal -->

	  <div class="even_btn">
		<a class="btn-white2" href="shop_<?php echo $this->data['ml_key']?>.php"><i class="fa fa-reply" aria-hidden="true"></i><?php echo t('繼續購物')?></a>
		<a class="btn-cis1 step1" href="javascript:;"><i class="fa fa-chevron-right" aria-hidden="true"></i><?php echo t('下一步')?></a>
	  </div><!-- .even_btn -->
	</div><!-- .innerBlock -->
<? //加購產品用start-----------------------------------------------------------------------------------------------------------------------------------	
unset($_constant);
eval('$_constant = '.strtoupper('shop_show_purchase').';');
if ($_constant) {
	if (isset($increase_purchases) && !empty($increase_purchases)) { 
?>
	<section class="relatedPro block">
		<div class="hrTitle"><span><?php echo t('加價購商品')?></span></div>
		<?php //include 'common/shop_relateProSlid.php';?>
		<div class="proList shop shop_add">
			<div class="itemList">
				<div id="relateProSlid" class="relate_pro_slid">
					<?php foreach($increase_purchases as $k => $v):?>
						<!---pro item start-->
						<div class="item">
							<div>
								<a href="shopdetail_tw.php?id=<?=$v['id']?>">
									<div class="<?php echo $data['image_ratio'];//變數在source/core.php?> ">
										<img src="<?php echo $v['pic']?>">
										<?php if(0):?>
											<div class="itemIcon">
												<img src="images/<?php echo $this->data['ml_key']?>/shop-icon-sale.svg">
											</div>
										<?php endif?>
									</div>
								</a>
							</div>
							<div>
								<div class="itemTitle">
									<span><?php echo $v['name']?></span>
								</div>
								<div class="">
									<?php if($v['price'] > 0):?>
									<span class="itemPrice del">$<?php echo $v['price']?></span>
									<?php endif?>
										<span class="itemPrice">$<?php echo $v['price2']?></span>
								</div>
								<div class="">
									<a data-fancybox data-src="#addCartPanel_<?php echo $v['id']?>" data-options='{"touch" : false}' href="javascript:;" class="itemAddCart" item_id="<?php echo $v['id']?>" <?php if(isset($v['specs']) and !empty($v['specs'])):?> item_specid="<?php echo $v['specid']?>" <?php else:?> data-target="#addCartPanel_<?php echo $v['id']?>" <?php endif?> ><i class="fa fa-shopping-cart" aria-hidden="true"></i> 加入購物車<!-- <span class="tips">加入購物車</span> --></a>
								</div>
							</div>

						</div>
						<!---pro item end-->

					<?php endforeach?>
				</div>
			</div>
		</div>
	</section>
<? }
}//加購產品用end-----------------------------------------------------------------------------------------------------------------------------------	
?>	
<? //滿額加購產品用start-----------------------------------------------------------------------------------------------------------------------------------	
unset($_constant);
eval('$_constant = '.strtoupper('shop_promo').';');
unset($_constant2);
eval('$_constant2 = '.strtoupper('shop_promo_price').';');
if ($_constant && ($_constant2 && $_constant2>0) && isset($data['conversion_code']['calculate_logs']['promo_total']) && $data['conversion_code']['calculate_logs']['promo_total']>= $_constant2) {
	if (isset($ipromo_array) && !empty($ipromo_array)) { 
?>
	<section class="relatedPro block">
		<div class="hrTitle"><span><?php echo t('滿額加價購商品')?></span></div>
		<?php //include 'common/shop_relateProSlid.php';?>
		<div class="proList shop shop_add">
			<div class="itemList">
				<div id="relateProSlid02" class="relate_pro_slid">
					<?php foreach($ipromo_array as $k => $v):?>
						<!---pro item start-->
						<div class="item">
							<div>
								<a href="shopdetail_tw.php?id=<?=$v['id']?>">
									<div class="<?php echo $data['image_ratio'];//變數在source/core.php?> ">
										<img src="<?php echo $v['pic']?>">
										<?php if(0):?>
											<div class="itemIcon">
												<img src="images/<?php echo $this->data['ml_key']?>/shop-icon-sale.svg">
											</div>
										<?php endif?>
									</div>
								</a>
							</div>
							<div>
								<div class="itemTitle">
									<span><?php echo $v['name']?></span>
								</div>
								<div class="">
									<?php if($v['price'] > 0):?>
									<span class="itemPrice del">$<?php echo $v['price']?></span>
									<?php endif?>
										<span class="itemPrice">$<?php echo $v['price2']?></span>
								</div>
								<div class="">
									<a data-fancybox data-src="#addCartPanel_<?php echo $v['id']?>" data-options='{"touch" : false}' href="javascript:;" class="itemAddCart" item_id="<?php echo $v['id']?>" <?php if(isset($v['specs']) and !empty($v['specs'])):?> item_specid="<?php echo $v['specid']?>" <?php else:?> data-target="#addCartPanel_<?php echo $v['id']?>" <?php endif?> ><i class="fa fa-shopping-cart" aria-hidden="true"></i> 加入購物車<!-- <span class="tips">加入購物車</span> --></a>
								</div>
							</div>

						</div>
						<!---pro item end-->

					<?php endforeach?>
				</div>
			</div>
		</div>
	</section>
<? }
}//滿額加購產品用end-----------------------------------------------------------------------------------------------------------------------------------	
?>	
<?php if(0):?><!-- body_end -->
<script type="text/javascript">
$('body').on('click','.step1',function(){
	$.ajax({
		type: "GET",
		data: {
			'ajax': 1
		},
		url: 'checkout_<?php echo $this->data['ml_key']?>.php',
		success: function(response){
			eval(response);
			//location.reload();
		}
	}); // ajax
});
$('body').on('click','.physicals input[name=is_islands]',function(){
	var is_islands = '';
	if($('.physicals input[name=is_islands]').is(':checked')){
		is_islands = $('.physicals input[name=is_islands]:checked').val();
	}
	$.ajax({
		type: "POST",
		data: {
			'id': 'selecxt_physical',
			'is_islands': is_islands
		},
		url: 'save.php',
		success: function(response){
			location.reload();
		}
	}); // ajax
});
</script>
<?php endif?><!-- body_end -->


<?php endif//step1?>
