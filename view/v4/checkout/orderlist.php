<?php
// 訂單狀態
$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type', array(':type'=>'shoporderstatus'))->order('sort_id asc')->queryAll();
$orderstatus_tmp = array();
if($rows and !empty($rows)){
	foreach($rows as $k => $v){
		$orderstatus_tmp[$v['other1']] = $v['topic'];
	}
}
?>

<?php if(isset($data[$ID]) and !empty($data[$ID])):?>
<div class="member_center">

  <section class="sectionBlock">
	<div class="container">

	  <div class="innerBlock_mt">
		<div class="pageTitleStyle-1">
		  <span>歷史訂單記錄</span>
		</div>
<?php if(0):?>
		<p>會員 王小明 您好，以下是你的訂單歷史記錄</p>
<?php endif?>
		<div class="responsive_tbl">
		  <table class="tableList">
			<thead>
			  <tr>
				<th><?php echo t('訂單編號')?></th>
				<th><?php echo t('消費時間')?></th>
				<th><?php echo t('訂單金額')?></th>
				<th><?php echo t('付款方式')?></th>
				<th><?php echo t('訂單狀態')?></th>
				<th><?php echo t('查看明細')?></th>
			  </tr>
			</thead>
			<tbody>
			<?php foreach($data[$ID] as $k => $v):?>
				<?php
				if(!isset($v['order_status_handle'])){
					$v['order_status_handle'] = $orderstatus_tmp[$v['order_status']];
				}
				?>
				<tr>
					<td><a href="memberorderdetail_<?php echo $this->data['ml_key']?>.php?order_number=<?php echo $v['order_number']?>"><?php echo $v['order_number']?></a></td>
					<td><?php echo $v['create_time']?></td>
					<td><?php echo $v['total']?></td>
					<td><?php echo $v['payment_func_name']?></td>
<!-- func|start|remove_new_line -->
					<td>
						<?php $no_action = false//只是為了減少程式碼的層次?>
						<?php if($v['order_status'] == 99)://己取消?>
							<span class="orderStatus del"><?php echo $v['order_status_handle']?></span>
						<?php elseif($v['order_status'] == 0)://未付款?>
							<?php foreach ($payments_tmp as $k1 => $v1):?>
								<?php if($v1['func'] == $v['payment_func']):?>
									<?php if($v1['payment_notice']):?>
										<a href="membernoticepayment_<?php echo $this->data['ml_key']?>.php?order_number=<?php echo $v['order_number']?>" class=""><span class="orderStatus noticPay"><?php echo t('通知付款')?></span></a>
									<?php else:?>
										<?php $no_action = true?>
									<?php endif?>
								<?php endif?>
							<?php endforeach?>
						<?php elseif($v['order_status_handle'] == '己出貨')://這個是隱藏的?>
							<span class="orderStatus ship"><?php echo $v['order_status_handle']?></span>
						<?php else:?>
							<?php $no_action = true?>
						<?php endif?>
						<?php if($no_action === true):?>
							<?php echo $v['order_status_handle']?>
						<?php endif?>
					</td>
<!-- func|end|remove_new_line -->
					<td><a href="memberorderdetail_<?php echo $this->data['ml_key']?>.php?order_number=<?php echo $v['order_number']?>"><i class="fa fa-th-list" aria-hidden="true"></i><?php echo t('查看明細')?></a></td>
				</tr>
			<?php endforeach?>
			</tbody>
		  </table>
		</div><!-- .responsive_tbl -->
		<div class="text-center"><a class="btn-cis1" href="membercenter_<?php echo $this->data['ml_key']?>.php"><i class="fa fa-user" aria-hidden="true"></i>前往會員中心</a></div>
	  </div><!-- .innerBlock_mt -->

	</div><!-- .container -->
  </section><!-- .sectionBlock -->

</div><!-- .member_center -->
<?php endif?>
