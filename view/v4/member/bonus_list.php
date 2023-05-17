<!-- // DATA2:SINGLE -->
<?php $bonus_info = $data[$ID]?>
		
<!-- // DATA2:MULTI -->
<?php $bonus = $data[$ID]?>

<div class="member_center">

  <section class="sectionBlock">
    <div class="container">

      <?php //include('memberCenter_title.php'); ?>
<?php echo $__?>
      <div class="formLine"></div>

  <div class="innerBlock_mt">
	<div class="blockTitle">
		<span><?php echo t('可使用的紅利')?>/<?php echo t('優惠券')?></span>
	</div>
	<div class="responsive_tbl">
	<?php if(isset($bonus) and !empty($bonus)):?>
	  <table class="tableList">
		<thead>
		  <tr>
			<th><?php echo t('紅利點數')?></th>
			<th><?php echo t('紅利說明')?></th>
			<th><?php echo t('開始日期')?></th>
			<th><?php echo t('到期日')?></th>
		  </tr>
		</thead>
		<tbody>
			<?php foreach($bonus as $k => $v):?>
				<tr>
					<?php if($v['order_number'] != ''):?>
						<td><?php echo t('紅利點數')?>-<?php echo $v['point']?></td>
						<td><?php echo t('紅利說明')?><?php echo t('消費折抵')?><a href="memberorderdetail_<?php echo $this->data['ml_key']?>.php?order_number=<?php echo $v['order_number']?>"><?php echo $v['order_number']?></a></td>
						<td><?php echo t('開始日期')?>&nbsp;</td>
						<td><?php echo t('到期日')?>&nbsp;</td>
					<?php else:?>
						<td><?php echo t('紅利點數')?>+<?php echo $v['point']?></td>
						<td><?php echo t('紅利說明')?><?php echo $v['name']?></td>
						<td><?php echo t('開始日期')?><?php echo $v['start_date_name']?></td>
						<td><?php echo t('到期日')?><?php echo $v['start_date_name']?></td>
					<?php endif?>
				</tr>
			<?php endforeach?>
		</tbody>
	  </table>
	<?php endif?>
	</div><!-- .responsive_tbl -->
  </div><!-- .innerBlock_mt -->

    </div><!-- .container -->
  </section><!-- .sectionBlock -->

</div><!-- .member_center -->
