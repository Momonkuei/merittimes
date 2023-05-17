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

<div class="member_center">

  <section class="sectionBlock">
	<div class="container">

		<?php if(!empty($payment)):?>
		  <div class="innerBlock_mt">
			<div class="pageTitleStyle-1">
			  <span>訂單記錄</span>
			</div>
			<?php if(0):?>
			<p>會員 王小明 您好，以下是你的訂單歷史記錄</p>
			<?php endif?>
			<div class="noticepay_list">
			  <div class="row">
				<div class="col-lg-6">
				  <ul>
					<?php if($order['status'] === true):?>
						<li><span><?php echo t('訂單編號')?>：</span><?php echo $order['order_number']?></li>
						<li><span><?php echo t('訂購時間')?>：</span><?php echo $order['create_time']?></li>
					<?php endif?>
					<li><span><?php echo t('付款方式')?>：</span><?php echo $payment['name']?></li>
					<li><span><?php echo t('訂單狀態')?>：</span>
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
					</li>
					<li><span><?php echo t('發票資訊')?>：</span>
						<?php if($invoice['invoice_type'] == 1):?>
							<?php echo t('二聯式電子發票')?>/<?php if($invoice['invoice_type_2'] == '1'):?><?php echo t('手機條碼')?><?php else:?><?php echo t('自然人憑證條碼')?><?php endif?>/<?php echo $invoice['invoice_type_2_barcode']?>
						<?php elseif($invoice['invoice_type'] == 2):?>
							<?php echo t('捐贈發票')?><!--/<?php echo $invoice_config['donate_name']?>-->
						<?php elseif($invoice['invoice_type'] == 3):?>
							<?php echo t('三聯式紙本發票(公司行號報帳用)')?>/<?php echo $invoice['invoice_name']?>/<?php echo $invoice['invoice_tax_id']?>
						 <?php elseif($invoice['invoice_type'] == 4):?>
       						<?php echo t('二聯式紙本發票隨商品寄出')?>/<?php echo $invoice['invoice_name']?>/<?php echo $invoice['invoice_tax_id']?>	
						<?php endif?>
					</li>
				  </ul>
				</div>
				<div class="col-lg-6">
				  <ul>
					<li><span><?php echo t('收件人姓名')?>：</span><?php echo $recipient['recipient_name']?></li>
					<li><span><?php echo t('收件人電話')?>：</span><?php echo $recipient['recipient_phone']?></li>
					<li><span><?php echo t('收件人地址')?>：</span><?php echo $recipient['recipient_addr_merge']?></li>
					<li><span><?php echo t('訂單備註')?>：</span><?php echo $order['detail']?></li>
				  </ul>
				</div>
			  </div>
			</div><!-- .noticepay_list -->
		  </div><!-- .innerBlock_mt -->

		  <?php if(
		  	$order['status'] === true and $order['payment_status'] === false
		  	and preg_match('/^(ecpay_cvs|ecpay_barcode|ecpay_webatm|ecpay_vatm|atm)$/', $payment['func'])
		  ):?>
		  <div class="innerBlock_small">
			<div class="blockTitle">
			  <span><?php echo t('付款資訊')?></span>
			</div>
			<p class="common_red_txt"><?php echo t('該筆訂單未完成付款，請依以下付款資訊完成付款。')?></p>
			<div class="mbm_payInfo">

				<?php if($payment['func'] == 'ecpay_cvs'):?>
					<p class="mbmPayInfo_title"><span><?php echo t('超商繳費代碼')?>：</span><?php echo $order['ecpay_cvs_paymentno']?></p>
					<p class="mbmPayInfo_title"><span><?php echo t('繳費期限')?>：</span><?php echo $order['ecpay_cvs_expiredate']?></p>
				<?php endif?>

				<?php if($payment['func'] == 'ecpay_barcode'):?>
					<p><img class="rwd_img" src="<?php echo FRONTEND_DOMAIN?>/barcode.php?text=<?php echo $order['ecpay_barcode_barcode1']?>"></p>
					<p><img class="rwd_img" src="<?php echo FRONTEND_DOMAIN?>/barcode.php?text=<?php echo $order['ecpay_barcode_barcode2']?>"></p>
					<p><img class="rwd_img" src="<?php echo FRONTEND_DOMAIN?>/barcode.php?text=<?php echo $order['ecpay_barcode_barcode3']?>"></p>
					<p class="mbmPayInfo_title"><span><?php echo t('繳費期限')?>：</span><?php echo $order['ecpay_barcode_expiredate']?></p>
				<?php endif?>

				<?php if($payment['func'] == 'ecpay_webatm' or $payment['func'] == 'ecpay_vatm'):?>
					<p class="mbmPayInfo_title"><span><?php echo t('銀行代號')?>：</span><?php echo $order[$payment['func'].'_bank_code']?> <?php if(isset($this->data['bankcodeatm_tmp'][$order[$payment['func'].'_bank_code']])):?><?php echo $this->data['bankcodeatm_tmp'][$order[$payment['func'].'_bank_code']]['name']?><?php endif?></p>
					<p class="mbmPayInfo_title"><span><?php echo t('銀行帳號')?>：</span><?php echo $order[$payment['func'].'_vaccount']?></p>
					<p class="mbmPayInfo_title"><span><?php echo t('繳費期限')?>：</span><?php echo $order[$payment['func'].'_expiredate']?></p>
				<?php endif?>

				<?php if($payment['func'] == 'atm'):?>
					<p class="mbmPayInfo_title"><span><?php echo t('銀行代號')?>：</span><?php echo $order[$payment['func'].'_bank_code']?> <?php if(isset($this->data['bankcodeatm_tmp'][$order[$payment['func'].'_bank_code']])):?><?php echo $this->data['bankcodeatm_tmp'][$order[$payment['func'].'_bank_code']]['name']?><?php endif?></p>
					<p class="mbmPayInfo_title"><span><?php echo t('銀行帳號')?>：</span><?php echo $order[$payment['func'].'_account']?></p>
					<?php if(0)://李哥說這個不需要?>
						<p class="mbmPayInfo_title"><span><?php echo t('繳費期限')?>：</span><?php echo $order[$payment['func'].'_expiredate']?></p>
					<?php endif?>
				<?php endif?>
			</div>
		  </div><!-- .innerBlock_small -->
		  <?php endif//status?>
		<?php endif//payment?>

	  <div class="innerBlock_small">
		<div class="blockTitle">
		  <span>購買清單</span>
		</div>
		<div class="rwdTable">
		  <table class="tableList">
			<thead>
			  <tr>
				<th><?php echo t('商品名稱')?></th>
				<th><?php echo t('商品規格')?></th>
				<th><?php echo t('價格')?></th>			
				<th><?php echo t('小計')?></th>
			  </tr>
			</thead>
			<tbody>
				<?php foreach($car as $k => $v):?>
				  <tr>
					<td>
					  <div class="mbm_orderProItem">
						<div class="order_proImg"><img src="<?php echo $v['item']['pic']?>" alt=""></div>
						<div>
						  <?php echo $v['item']['name']?><br />
							<?php if(isset($v['item']['promotion'])):?>
								<div class="tips_active"><?php echo $v['item']['promotion_name']?><?php if(isset($v['item']['promotion']['match_log']) and isset($v['promotion_id'])):?><?php echo $v['item']['promotion']['match_log']?><?php endif?></div>
							<?php endif?>
						</div>
					  </div>
					</td>
					<td>
						<?php if(isset($v['spec']) and $v['spec'] != ''):?>
							<?php echo $v['spec']?><br />
						<?php endif?>

						<?php if(isset($v['amount'])):?>
							<?php echo t('數量')?> / <?php echo $v['amount']?>
						<?php endif?>
					</td>
					<td>
						$<?php echo $v['item']['price']?>
					</td>
					<td>$<?php echo number_format($v['item']['price'] * $v['amount'])?></td>
				  </tr>
				<?php endforeach?>
			</tbody>
		  </table>
		</div><!-- .rwdTable -->
		<div class="orderTotal">
		  <table>
			<tbody>
				<?php if(isset($calculate_logs)):?>
					<?php foreach($calculate_logs as $k => $v):?>
						<tr <?php if($v[0]=='總計'):?> class="total" <?php endif?> ><td><?php echo $v[0]?></td><td><?php if($v[0]=='總計'):?><b><?php echo $v[1]?></b><?php elseif($v[0]=='運費'):?><span class="shipPrice"><?php echo $v[1]?></span><?php else:?><?php echo $v[1]?><?php endif?></td></tr>
					<?php endforeach?>
				<?php endif?>
			</tbody>
		  </table>
		</div><!-- .orderTotal -->
		<div class="even_btn">
			<?php if(0):?>
			  <a class="btn-white2" href=""><i class="fa fa-ban" aria-hidden="true"></i>取消訂單</a>
			  <a class="btn-white2" href="javascript:history.go(-1)"><i class="fa fa-reply" aria-hidden="true"></i>返回</a>
			<?php endif?>
			<a class="btn-cis1" href="membercenter_<?php echo $this->data['ml_key']?>.php"><i class="fa fa-user" aria-hidden="true"></i>前往會員中心</a>
		</div><!-- .even_btn -->
	  </div><!-- .innerBlock_small -->


	</div><!-- .container -->
  </section><!-- .sectionBlock -->

</div><!-- .member_center -->
