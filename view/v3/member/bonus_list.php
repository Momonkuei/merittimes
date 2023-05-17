<div class="blockTitle"><span><?php echo t('紅利記錄')?></span></div>
<p class="blockInfoTxt">					
	您好，以下是你的紅利記錄
</p>	

<!-- // DATA2:SINGLE -->
<?php $bonus_info = $data[$ID]?>
		
<!-- // DATA2:MULTI -->
<section class="bonusBlock block">
	<div class="blockInfo">
		<label class="bonusTotal"><?php echo t('總共累積紅利')?>：<span><?php echo $bonus_info['total']?></span></label>
		<label class="bonusUsed"><?php echo t('已使用紅利')?>：<span><?php echo $bonus_info['use']?></span></label>
	</div>
	<?php if(isset($data[$ID])):?>
		<table class="rwdTable" width="100%" cellspacing="0" cellpadding="0">
			<tr>
			<th><?php echo t('紅利點數')?></th>
			<th><?php echo t('紅利說明')?></th>
			<th><?php echo t('開始日期')?></th>
			<th><?php echo t('到期日')?></th>
			</tr>
			<?php foreach($data[$ID] as $k => $v):?>
				<tr>
					<?php if($v['order_number'] != ''):?>
						<td><label class="th"><?php echo t('紅利點數')?></label><span>-<?php echo $v['point']?></span></td>
						<td><label class="th"><?php echo t('紅利說明')?></label><span><?php echo t('消費折抵')?><a href="memberorderdetail_<?php echo $this->data['ml_key']?>.php?order_number=<?php echo $v['order_number']?>"><?php echo $v['order_number']?></a></span></td>
						<td><label class="th"><?php echo t('開始日期')?></label><small>&nbsp;</small></td>
						<td><label class="th"><?php echo t('到期日')?></label><small>&nbsp;</small></td>
					<?php else:?>
						<td><label class="th"><?php echo t('紅利點數')?></label><span>+<?php echo $v['point']?></span></td>
						<td><label class="th"><?php echo t('紅利說明')?></label><span><?php echo $v['name']?></span></td>
						<td><label class="th"><?php echo t('開始日期')?></label><small><?php echo $v['start_date_name']?></small></td>
						<td><label class="th"><?php echo t('到期日')?></label><small><?php echo $v['start_date_name']?></small></td>
					<?php endif?>
				</tr>
			<?php endforeach?>

			<?php if(0):?>
				<tr>
					<td><label class="th">紅利點數</label><span>+500</span></td>
					<td><label class="th">紅利說明</label><span>註冊會員</span></td>
					<td><label class="th">開始日期</label><small>2015-10-21</small></td>
					<td><label class="th">到期日</label><small>2015-10-21</small></td>
				</tr>
				<tr>
					<td><label class="th">紅利點數</label><span>-100</span></td>
					<td><label class="th">紅利說明</label><span>消費折抵<a href="member.php?type=orderdetail">123456789</a></span></td>
					<td><label class="th">開始日期</label><small>2015-10-21</small></td>
					<td><label class="th">到期日</label><small>2015-10-21</small></td>
				</tr>
				<tr>
					<td><label class="th">紅利點數</label><span>+500</span></td>
					<td><label class="th">紅利說明</label><span>登入紅利</span></td>
					<td><label class="th">開始日期</label><small>2015-10-21</small></td>
					<td><label class="th">到期日</label><small>2015-10-21</small></td>
				</tr>
			<?php endif?>
		</table>
	<?php endif?>
</section>

<a class="btn-cis1" href="membercenter_<?php echo $this->data['ml_key']?>.php"><i class="fa fa-user"></i><?php echo t('會員中心')?></a>
