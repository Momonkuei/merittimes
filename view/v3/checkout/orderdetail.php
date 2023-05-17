<!-- // DATA2:SINGLE -->
<?php $shipment = $data[$ID]?>
<!-- // DATA2:SINGLE -->
<?php $payment = $data[$ID];//所選取的那筆金流?>
<!-- // DATA2:SINGLE -->
<?php $order = $data[$ID];//訂單相關狀態?>
<!-- // DATA2:SINGLE -->
<?php $recipient = $data[$ID];//收件人資料?>
<!-- // DATA2:SINGLE -->
<?php $invoice_config = $data[$ID];//發票設定?>
<!-- // DATA2:SINGLE -->
<?php $invoice = $data[$ID];//發票資訊和備註?>
<?php //var_dump($invoice)?>

<!-- // DATA2:MULTI -->
<?php $car = $data[$ID];//購物車裡面的東西?>
<!-- // DATA2:MULTI -->
<?php $calculate_logs = $data[$ID];//計算機?>

<?php
// var_dump($this->data['bankcodeatm_tmp']);
// var_dump($order);

// 訂單狀態
$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type', array(':type'=>'shoporderstatus'))->order('sort_id asc')->queryAll();
$orderstatus_tmp = array();
if($rows and !empty($rows)){
	foreach($rows as $k => $v){
		$orderstatus_tmp[$v['other1']] = $v['topic'];
	}
}

if(!isset($order['order_status_handle'])){
	$order['order_status_handle'] = $orderstatus_tmp[$order['order_status']];
}
?>

<?php if(!empty($payment)):?>
	<section class="block flex2c orderStatus">	
		<div>
			<?php if($order['status'] === true):?>
				<div class="formItem">
					<label><?php echo t('訂單編號')?>：<?php echo $order['order_number']?></label>
				</div>					
				<div class="formItem">
					<label><?php echo t('訂購時間')?>：<?php echo $order['create_time']?></label>
				</div>			
			<?php endif?>

			<div class="formItem">
				<label><?php echo t('付款方式')?>：<span class="payTypeTxt"><?php echo $payment['name']?></span></label>
			</div>			
			
			<div class="formItem">
				<label><?php echo t('訂單狀態')?>：
					<span>
						<?php $no_action = false//只是為了減少程式碼的層次?>
						<?php if($order['order_status'] == 99)://己取消?>
							<span class="orderStatus del"><?php echo $order['order_status_handle']?></span>
						<?php elseif($order['order_status'] == 0)://未付款?>
							<?php foreach ($payments_tmp as $k => $v):?>
								<?php if($v['func'] == $order['payment_func']):?>
									<?php if($v['payment_notice']):?>
										<a href="membernoticepayment_<?php echo $this->data['ml_key']?>.php?order_number=<?php echo $order['order_number']?>" class=""><span class="orderStatus noticPay"><?php echo t('通知付款')?></span></a>
									<?php else:?>
										<?php $no_action = true?>
									<?php endif?>
								<?php endif?>
							<?php endforeach?>							
						<?php elseif($order['order_status_handle'] == '己出貨')://這個是隱藏的?>
							<span class="orderStatus ship"><?php echo $order['order_status_handle']?></span>
						<?php else:?>
							<?php $no_action = true?>
						<?php endif?>
						<?php if($no_action === true):?>
							<?php echo $order['order_status_handle']?>
						<?php endif?>
					</span>
				</label>
			</div>


			<?php if(0):?>		
			<div class="formItem">
				<label><?php echo t('訂單狀態')?>：<span><?php if($order['payment_status'] === true):?><?php echo t('已付款')?><?php else:?><?php echo t('未付款')?><?php endif?></span></label>
			</div>
			<?php endif?>
			
			<div class="formItem">
				<?php if($invoice['invoice_type'] == 1):?>
				<label><?php echo t('發票資訊')?>：<?php echo t('二聯式電子發票')?>/<?php if($invoice['invoice_type_2'] == '1'):?><?php echo t('手機條碼')?><?php else:?><?php echo t('自然人憑證條碼')?><?php endif?>/<?php echo $invoice['invoice_type_2_barcode']?></label>
				<?php elseif($invoice['invoice_type'] == 2):?>
				<label><?php echo t('發票資訊')?>：<?php echo t('捐贈發票')?>/<?php echo $invoice_config['donate_name']?></label>
				<?php elseif($invoice['invoice_type'] == 3):?>
				<label><?php echo t('發票資訊')?>：<?php echo t('三聯式紙本發票(公司行號報帳用)')?>/<?php echo $invoice['invoice_name']?>/<?php echo $invoice['invoice_tax_id']?></label>
				<?php elseif($invoice['invoice_type'] == 4)://#41989?>
				<label><?php echo t('發票資訊')?>：<?php echo t('二聯式紙本發票隨商品寄出')?></label>
				<?php endif?>
			</div>
		</div>

		<div>
			<div class="formItem"><label><?php echo t('收件人姓名')?>：<?php echo $recipient['recipient_name']?></label></div>
			<div class="formItem"><label><?php echo t('收件人電話')?>：<?php echo $recipient['recipient_phone']?></label></div>
			<div class="formItem"><label><?php echo t('收件人地址')?>：<?php echo $recipient['recipient_addr_merge']?></label></div>
			<div class="formItem"><label><?php echo t('訂單備註')?>：<?php echo $invoice['detail']?></label></div>
		</div>
	</section>

	<?php if(
		$order['status'] === true and $order['payment_status'] === false
		and preg_match('/^(ecpay_cvs|ecpay_barcode|ecpay_webatm|ecpay_vatm|atm)$/', $payment['func'])
	):?>
		<section class="block payInformation">
			<div>
				<h4 class="articleTitle"><?php echo t('付款資訊')?></h4>
				<div class="blockInfoTxt"><?php echo t('該筆訂單未完成付款，請依以下付款資訊完成付款。')?></div>

				<?php if($payment['func'] == 'ecpay_cvs'):?>
					<p><?php echo t('超商繳費代碼')?>：<?php echo $order['ecpay_cvs_paymentno']?></p>
					<p><?php echo t('繳費期限')?>：<?php echo $order['ecpay_cvs_expiredate']?></p>
				<?php endif?>

				<?php if($payment['func'] == 'ecpay_barcode'):?>
					<p><img src="<?php echo FRONTEND_DOMAIN?>/barcode.php?text=<?php echo $order['ecpay_barcode_barcode1']?>"></p>
					<p><img src="<?php echo FRONTEND_DOMAIN?>/barcode.php?text=<?php echo $order['ecpay_barcode_barcode2']?>"></p>
					<p><img src="<?php echo FRONTEND_DOMAIN?>/barcode.php?text=<?php echo $order['ecpay_barcode_barcode3']?>"></p>
					<p><?php echo t('繳費期限')?>：<?php echo $order['ecpay_barcode_expiredate']?></p>
				<?php endif?>

				<?php if($payment['func'] == 'ecpay_webatm' or $payment['func'] == 'ecpay_vatm'):?>
					<p><?php echo t('銀行代號')?>：<?php echo $order[$payment['func'].'_bank_code']?> <?php if(isset($this->data['bankcodeatm_tmp'][$order[$payment['func'].'_bank_code']])):?><?php echo $this->data['bankcodeatm_tmp'][$order[$payment['func'].'_bank_code']]['name']?><?php endif?></p>
					<p><?php echo t('銀行帳號')?>：<?php echo $order[$payment['func'].'_vaccount']?></p>
					<p><?php echo t('繳費期限')?>：<?php echo $order[$payment['func'].'_expiredate']?></p>
				<?php endif?>

				<?php if($payment['func'] == 'atm'):?>
					<p><?php echo t('銀行代號')?>：<?php echo $order[$payment['func'].'_bank_code']?> <?php if(isset($this->data['bankcodeatm_tmp'][$order[$payment['func'].'_bank_code']])):?><?php echo $this->data['bankcodeatm_tmp'][$order[$payment['func'].'_bank_code']]['name']?><?php endif?></p>
					<p><?php echo t('銀行帳號')?>：<?php echo $order[$payment['func'].'_account']?></p>
					<?php if(0)://李哥說這個不需要?>
						<p><?php echo t('繳費期限')?>：<?php echo $order[$payment['func'].'_expiredate']?></p>
					<?php endif?>
				<?php endif?>

			</div>
		</section>
	<?php endif?>
<?php endif?>

<section class="orderProList block">
	<?php if(isset($car)):?>
		<table class="rwdTable" width="100%" cellspacing="0" cellpadding="0">
			<tr>
				<th><?php echo t('商品名稱')?></th>
				<th><?php echo t('商品規格')?></th>
				<th><?php echo t('價格')?></th>			
				<th><?php echo t('小計')?></th>
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
									<small><?php echo $v['item']['promotion_name']?><?php if(isset($v['item']['promotion']['match_log']) and isset($v['promotion_id'])):?><?php echo $v['item']['promotion']['match_log']?><?php endif?></small>
								<?php endif?>
							</div>
						</div>
					</td>

					<td class="itemSpec">
						<?php if(0 and isset($v['specs']) and !empty($v['specs'])):?>
							<?php foreach($v['specs'] as $kk => $vv):?>
								<div><label class="th"><?php echo $vv['name']?>：</label><span class=""><?php if(isset($vv['value'])):?><?php echo $vv['value']?><?php endif?><?php if(isset($vv['pic'])  && $vv['pic']!='_i/assets/upload/shopspec/'):?><img src="<?php echo $vv['pic']?>"><?php endif?></span></div>
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
					<div><label class="th"><?php echo t('價格')?></label><span>$<?php echo $v['item']['price']?></span></div>
<?php if(0):?>
						<div><label class="th">折價</label><span>-5,000</span></div>
<?php endif?>
					</td>

					<td><label class="th"><?php echo t('小計')?></label><span>$<?php echo number_format($v['item']['price'] * $v['amount'])?></span></td>								
				</tr>
			<?php endforeach?>
		</table>
	<?php endif?>

	<div class="orderTotal">
		<table cellspacing="0" cellpadding="0">
			<?php if(isset($calculate_logs)):?>
				<?php foreach($calculate_logs as $k => $v):?>
					<tr <?php if($v[0]=='總計'):?> class="total" <?php endif?> ><td><?php echo $v[0]?></td><td><?php if($v[0]=='總計'):?><b><?php echo $v[1]?></b><?php elseif($v[0]=='運費'):?><span class="shipPrice"><?php echo $v[1]?></span><?php else:?><?php echo $v[1]?><?php endif?></td></tr>
				<?php endforeach?>
			<?php endif?>
		</table>
	</div>

</section>

<?php if(0)://這裡遲早要套的，你放心?>
<p>
	<a class="orderCancel" href="javascript:alert('<?php echo t('依訂單狀態判斷是否可取消訂單')?>');"><i class="fa fa-ban"></i><?php echo t('取消訂單')?></a>
</p>
<?php endif?>

