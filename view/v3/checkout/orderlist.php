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
<section class="memberOrderList block">
	<table class="rwdTable" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<th><?php echo t('訂單編號')?></th>
			<th><?php echo t('消費時間')?></th>
			<th><?php echo t('訂單金額')?></th>
			<th><?php echo t('付款方式')?></th>
			<th><?php echo t('訂單狀態')?></th>
			<th><?php echo t('查看明細')?></th>
		</tr>
		<?php foreach($data[$ID] as $k => $v):?>
			<?php
			if(!isset($v['order_status_handle'])){
				$v['order_status_handle'] = $orderstatus_tmp[$v['order_status']];
			}
			?>
			<tr>
				<td><label class="th"><?php echo t('訂單編號')?></label><a href="memberorderdetail_<?php echo $this->data['ml_key']?>.php?order_number=<?php echo $v['order_number']?>"><?php echo $v['order_number']?></a></td>
				<td><label class="th"><?php echo t('消費時間')?></label><small><?php echo $v['create_time']?></small></td>
				<td><label class="th"><?php echo t('訂單金額')?></label><span><?php echo $v['total']?></span></td>
				<td><label class="th"><?php echo t('付款方式')?></label><span><?php echo $v['payment_func_name']?></span></td>
<!-- func|start|remove_new_line -->
				<td><label class="th"><?php echo t('訂單狀態')?></label>
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
				<td><label class="th"></label><a href="memberorderdetail_<?php echo $this->data['ml_key']?>.php?order_number=<?php echo $v['order_number']?>"><i class="fa fa-th-list" aria-hidden="true"></i><?php echo t('查看明細')?></a></td>
			</tr>
		<?php endforeach?>
<?php if(0):?>
		<tr>
			<td><label class="th">訂單編號</label><a href="member.php?type=orderdetail">151021010062</a></td>
			<td><label class="th">消費時間</label><small>2015-10-21 16:31:58</small></td>
			<td><label class="th">訂單金額</label><span>$300</span></td>
			<td><label class="th">付款方式</label><span>銀行匯款/ATM轉帳</span></td>
			<td><label class="th">訂單狀態</label><span class="orderStatus del">已取消</span></td>
			<td><label class="th"></label><a href="member.php?type=orderdetail"><i class="fa fa-th-list" aria-hidden="true"></i>查看明細</a></td>
		</tr>
		<tr>
			<td><label class="th">訂單編號</label><a href="member.php?type=orderdetail">151021010062</a></td>
			<td><label class="th">消費時間</label><small>2015-10-21 16:31:58</small></td>
			<td><label class="th">訂單金額</label><span>$300</span></td>
			<td><label class="th">付款方式</label><span>銀行匯款/ATM轉帳</span></td>
			<td><label class="th">訂單狀態</label><a href="member.php?type=noticepay" class=""><span class="orderStatus noticPay">通知付款</span></a></td>
			<td><label class="th"></label><a href="member.php?type=orderdetail"><i class="fa fa-th-list" aria-hidden="true"></i>查看明細</a></td>
		</tr>
		<tr>
			<td><label class="th">訂單編號</label><a href="member.php?type=orderdetail">151021010062</a></td>
			<td><label class="th">消費時間</label><small>2015-10-21 16:31:58</small></td>
			<td><label class="th">訂單金額</label><span>$300</span></td>
			<td><label class="th">付款方式</label><span>銀行匯款/ATM轉帳</span></td>
			<td><label class="th">訂單狀態</label><span class="orderStatus ship">出貨中</span></td>
			<td><label class="th"></label><a href="member.php?type=orderdetail"><i class="fa fa-th-list" aria-hidden="true"></i>查看明細</a></td>
		</tr>
		<tr>
			<td><label class="th">訂單編號</label><a href="member.php?type=orderdetail">151021010062</a></td>
			<td><label class="th">消費時間</label><small>2015-10-21 16:31:58</small></td>
			<td><label class="th">訂單金額</label><span>$300</span></td>
			<td><label class="th">付款方式</label><span>銀行匯款/ATM轉帳</span></td>
			<td><label class="th">訂單狀態</label><span class="orderStatus done">已出貨</span></td>
			<td><label class="th"></label><a href="member.php?type=orderdetail"><i class="fa fa-th-list" aria-hidden="true"></i>查看明細</a></td>
		</tr>
		<tr>
			<td><label class="th">訂單編號</label><a href="member.php?type=orderdetail">151021010062</a></td>
			<td><label class="th">消費時間</label><small>2015-10-21 16:31:58</small></td>
			<td><label class="th">訂單金額</label><span>$300</span></td>
			<td><label class="th">付款方式</label><span>銀行匯款/ATM轉帳</span></td>
			<td><label class="th">訂單狀態</label><span class="orderStatus done">已出貨</span></td>
			<td><label class="th"></label><a href="member.php?type=orderdetail"><i class="fa fa-th-list" aria-hidden="true"></i>查看明細</a></td>
		</tr>
<?php endif?>
	</table>

</section>
<?php endif?>
