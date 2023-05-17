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

<?php
//Kevin 寫的紅利機制，用在形向
// if(isset($this->data['admin_id']) && $this->data['admin_id'] > 0){
// 	$sql=$this->pdo->prepare("select SUM(bonus) as bonus from bonus where memberID=:memberID and status=2  group by memberID");
// 	$sql->execute(array(":memberID"=>$this->data['admin_id']));
// 	$row=$sql->fetch(PDO::FETCH_ASSOC);
// 	if($sql->rowCount()==0){
// 		$total_bonus=0;
// 		$canuse_bonus=0;
// 	}else{
// 		$Kbonus=$row['bonus'];

// 		$sql_now=$this->pdo->prepare("select SUM(bonus) as bonus from bonus where memberID=:memberID and status=2 and end_time > :date group by memberID");
// 		$sql_now->execute(array(":memberID"=>$this->data['admin_id'],":date"=>date("Y-m-d H:i:s")));
// 		$row_now=$sql_now->fetch(PDO::FETCH_ASSOC);
// 		$Kbonus_now=$row_now['bonus'];
	
// 		if($Kbonus > $Kbonus_now){
// 			$total_bonus=$Kbonus_now;
// 		}else{
// 			$total_bonus=$Kbonus;
// 		}
// 		$orderPrice=0;
// 		for($x=0;$x<=count($calculate_logs);$x++){
// 			if(isset($calculate_logs[$x]) && $calculate_logs[$x][0]!='總計' && $calculate_logs[$x][0]!='運費' && $calculate_logs[$x][0]!='紅利' ){
// 				$orderPrice += intval(str_replace(array("$", ","), "", $calculate_logs[$x][1]));
// 			}
			
// 		}
// 		$order_bonus=floor($orderPrice/2);
// 		if($order_bonus>$total_bonus){
// 			$canuse_bonus=$total_bonus;
// 		}else{
// 			$canuse_bonus=$order_bonus;
// 		}
		
// 	}
	
// }
?>


	<div>

<!-- // DATA2:MULTI -->

	<?php // 訂單內容?>
	<section class="orderProList block">

		<?php if(isset($car) and !empty($car)):?>

			<div class="hrTitle"><span><?php echo t('訂單內容')?></span></div>
			
			<?php // 商品列表?>
			<?php // include 'common/shop_order_prolist.php';?>
			<form>
				<table class="rwdTable" width="100%" cellspacing="0" cellpadding="0">
					<tr>
						<th><?php echo t('商品名稱')?></th>
						<th><?php echo t('商品規格')?></th>
						<th><?php echo t('價格')?></th>			
						<th><?php echo t('小計')?></th>
						<th><?php echo t('修改')?></th>
						<th><?php echo t('刪除')?></th>
					</tr>

					<?php foreach($car as $k => $v):?>
						<tr>
							<td>
								<div class="itemTitle">
									<div>
										<div class="itemImg">
											<img src="<?php echo $v['item']['pic']?>">
										</div>
									</div>
									<div>
										<span><?php echo $v['item']['name']?></span><br>
										<?php if(isset($v['item']['promotion'])):?>
											<small><a href="<?php echo $v['item']['url3']?>" class="itemSP"><?php echo $v['item']['promotion_name']?><?php if(isset($v['item']['promotion']['match_log']) and isset($v['promotion_id'])):?><?php echo $v['item']['promotion']['match_log']?><?php endif?></a></small>
										<?php else:?>
											<small><a href="javascript:;" class="itemSP"></a></small>
										<?php endif?>
									</div>
								</div>
							</td>

							<td class="itemSpec">
								<?php if(0 and isset($v['specs']) and !empty($v['specs'])):?>
									<?php foreach($v['specs'] as $kk => $vv):?>
										<div><label class="th"><?php echo $vv['name']?>：</label><span class=""><?php if(isset($vv['value'])):?><?php echo $vv['value']?><?php endif?><?php if(isset($vv['pic']) && $vv['pic']!='_i/assets/upload/shopspec/'):?><img src="<?php echo $vv['pic']?>"><?php endif?></span></div>
									<?php endforeach?>
								<?php endif?>

								<?php if(isset($v['spec']) and $v['spec'] != ''):?>
									<div><span class=""><?php echo $v['spec']?></span></div>
								<?php endif?>

								<?php if(isset($v['amount'])):?>
									<div><label class="th"><?php echo t('數量')?>：</label><span class=""><?php echo $v['amount']?></span></div>
								<?php endif?>

								<?php if(0 and isset($v['inventory'])):?>
									<div><label class="th"><?php echo t('庫存數量')?>：</label><span class=""><?php echo $v['inventory']?></span></div>
								<?php endif?>
<?php if(0):?>
								<div><label class="th">顏色</label><span><img src="images/<?php echo $this->data['ml_key']?>/demo/shop-pro-color-1.jpg">紅</span></div>
								<div><label class="th">尺寸</label><span>L</span></div>
								<div><label class="th">尺碼</label><span>42</span></div>
								<div><label class="th">數量</label><span>2</span></div>
<?php endif?>
							</td>

							<td class="itemPrice">
							<div><label class="th"><?php echo t('價格')?></label><span><?php echo $v['item']['price_format_ds']?></span></div>
<?php if(0):?>
								<div><label class="th">折價</label><span>-5,000</span></div>
<?php endif?>
							</td>

							<td><label class="th"><?php echo t('小計')?></label><span>$<?php echo number_format($v['item']['price'] * $v['amount']);//這裡單純做小計，不需要有複雜的程式流程?></span></td>								
							<td class="text-center"><span><a href="javascript:;" class="openBtn icon-link" data-target=".addCartPanel_<?php echo $k?>"><i class="fa fa-pencil"></i><?php echo t('修改')?></a></span></td>
							<td class="text-center"><span><a href="javascript:;" class="icon-link delcar" item_id="<?php echo $k?>" ><i class="fa fa-trash"></i><?php echo t('刪除')?></a></span></td>
						</tr>
					<?php endforeach?>

				</table>
			</form>
		<?php endif?>

<?php if(0):?><!-- body_end -->
<script type="text/javascript">
$('body').on('click','.delcar',function(){
	var thisobj = $(this);
	var item_id = thisobj.attr('item_id');
	$.ajax({
		type: "POST",
		data: {
			'func': 'delcar',
			'id': item_id
		},
		url: 'shop_<?php echo $this->data['ml_key']?>.php',
		success: function(response){
			eval(response);	
		}
	}); // ajax
});
</script>
<?php endif?><!-- body_end -->

<!-- // DATA2:SINGLE -->

		<div class="orderCoupon">
			<form>
				<div class="Bbox_in_2c">
					<div>
					<?php if(isset($data['shop_show_coupon']) && $data['shop_show_coupon']==true):?>
						<div class="formItem">
							<label><?php echo t('請輸入優惠券代碼')?></label>
							<input type="text" id="gift_serial_number" value="<?php if(isset($_SESSION['save']['goodies_number']['gift_serial_number'])):?><?php echo $_SESSION['save']['goodies_number']['gift_serial_number']?><?php endif?>" />
							<button id="use_goodies"><i class="fa fa-check"></i><?php echo t('使用優惠券')?></button>
							<button id="del_goodies"><i class="fa fa-close"></i><?php echo t('取消優惠卷')?></button>
						</div>
					<?php endif?>
					<?php if(isset($data['shop_show_dividend']) && $data['shop_show_dividend']==true):?>
							<div class="formItem use_bonus">
								<label><?php echo t('使用紅利')?></label>
								<div class="checkbox"> 
									<?php if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0):?>
									<label><input type="checkbox" name="use_bonus" value="1" <?php if(isset($_SESSION['save']['use_bonus']['use']) and $_SESSION['save']['use_bonus']['use'] == '1'):?> checked="checked" <?php endif?> <?php if($bonus['bonus_can_use'] <= 0):?> disabled="disabled" <?php endif?> />
									<?php else:?>
										<label class="openBtn" data-target="#loginPanel"><input type="checkbox">
									<?php endif?>
									<span><?php echo t('我要使用紅利')?></span> </label> 
								</div>
								<?php if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0):?>
									<?php //會員登入後顯示?>
									<div><?php echo t('本次可使用紅利')?>：<span><?php echo $bonus['bonus_can_use']?></span></div>
									<div><?php echo t('目前剩餘紅利')?>：<span><?php echo $bonus['bonus_total']?></span></div>
								<?php endif?>
							</div>
						<?php endif?>
					</div>
				</div>
			</form>
		</div>

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
			<table cellspacing="0" cellpadding="0">
				<?php if(isset($calculate_logs)):?>
					<?php foreach($calculate_logs as $k => $v):?>
						<tr <?php if($v[0]=='總計'):?> class="total" <?php endif?> ><td><?php echo $v[0]?></td><td><?php if($v[0]=='總計'):?><b><?php echo $v[1]?></b><?php elseif($v[0]=='運費'):?><span class="shipPrice"><?php echo $v[1]?></span><?php else:?><?php echo $v[1]?><?php endif?></td></tr>
					<?php endforeach?>
				<?php endif?>

				<?php if(0):?>
					<tr><td>合計</td><td>$10,000</td></tr>
					<tr><td>紅利</td><td>-20</td></tr>
					<tr><td>折價券</td><td>-100</td></tr>
					<tr><td>全館滿5000折500</td><td>-500</td></tr>
					<tr><td>運費</td><td><span class="shipPrice">0</span></td></tr>
					<tr class="total"><td>總計</td><td><b>$10,000</b></td></tr>
				<?php endif?>
			</table>

			<?php if(isset($how_much_difference)):?>
				<?php foreach($how_much_difference as $k => $v):?>
					<a href="javascript:;" class="tips"><?php echo $v?></a><br />
				<?php endforeach?>
			<?php endif?>

			<script type="text/javascript">
				<?php if(isset($error_logs) and !empty($error_logs))://這裡不啟用，因為是第一個步驟，其它步驟都要?>
					//alert('<?php //echo $data[$ID][0][1]?>');
				<?php endif?>
			</script>

		</div>

	</section>

	<section class="block">
		<div>
			<a class="btn-prev" href="shop_<?php echo $this->data['ml_key']?>.php"><i class="fa fa-reply"></i><?php echo t('繼續購物')?></a>	
			<a class="btn-cis1 step1" href="javascript:;"><i class="fa fa-pencil-square-o"></i><?php echo t('下一步')?></a>
		</div>
	</section>

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

	<?php if(isset($data['shop_show_purchase']) && $data['shop_show_purchase']==true):?>

		<?php // 相關商品 ?>
		<?php if(isset($additional_purchases)):?>
			<section class="relatedPro block">
				<div class="hrTitle"><span><?php echo t('加購商品')?></span></div>
				<?php // $plusbuyType='list'; include 'common/shop_plusbuy.php';?>
				<div class="proList shop">
					<div class="itemList">
						<div class="gridBox closest" data-grid="4">
							<?php foreach($additional_purchases as $k => $v):?>
								<!---pro item start-->
								<div class="item">
									<div>
										<a href="javascript:;" class="openBtn" item_id="<?php echo $v['id']?>" <?php if(isset($v['specs']) and count($v['specs']) > 0):?> item_specid="<?php echo $v['specid']?>" <?php else:?> data-target=".addCartPanel_<?php echo $v['id']?>" <?php endif?> >
										<div class="itemImg <?php if(isset($v['has_ap_in_car']) and $v['has_ap_in_car'] === true):?> active <?php endif?> "> 
												<img src="<?php echo $v['pic']?>"> 
												<div class="itemIcon">																														
													<?php if(isset($v['icon']) and $v['icon'] != ''):?>
														<img src="images/<?php echo $this->data['ml_key']?>/<?php echo $v['icon']?>">
													<?php endif?>

													<?php //=$item['icon'];?>
													<?php /*圖像icon (預設)
													<img src="<?=$imgPath;?>shop-icon-sale.svg">
													<img src="<?=$imgPath;?>shop-icon-hot.svg">
													<img src="<?=$imgPath;?>shop-icon-new.svg">
													*/?>																
													<?php /*文字icon
													<span class="spIcon red"><i>SALE</i></span>
													<span class="spIcon yellow"><i>HOT</i></span>
													<span class="spIcon org"><i>NEW</i></span>
													*/?>
												</div>
											</div>
										</a>
									</div>
									<div>										
										
										<div class="itemTitle"> 
											<span><?php echo $v['name']?></span>
										</div>
											<div class="">
											<?php if(isset($v['price_int']) && $v['price_int'] > 0):?>
												<span class="itemPrice del"><?php echo $v['price']?></span>
											<?php endif?>
											<?php if(isset($v['price2_int']) && $v['price2_int'] > 0):?>
												<span class="itemPrice"><?php echo $v['price2']?></span>
											<?php endif?> 
										</div>
										<?php if(isset($v['price2_int']) && $v['price2_int'] != 0):?>
										<div class="">
											<a href="javascript:;" class="itemAddCart openBtn icon-link  <?php if(isset($v['has_ap_in_car']) and $v['has_ap_in_car'] === true):?> active <?php endif?> " item_id="<?php echo $v['id']?>" <?php if(isset($v['specs']) and count($v['specs']) > 0):?> item_specid="<?php echo $v['specid']?>" <?php else:?> data-target=".addCartPanel_<?php echo $v['id']?>" <?php endif?> ><i class="fa fa-shopping-cart"></i> <span class="tips"><?php echo t('加入購物車')?></span></a>
										</div>
										<?php endif?>
									</div>
									
								</div>
								<!---pro item end-->
							<?php endforeach?>
						</div>
					</div>
				</div>
			</section>
			</div>
		<?php endif//additional_purchases?>
	<?php endif//shop_show_purchase?>

<?php endif//step1?>
