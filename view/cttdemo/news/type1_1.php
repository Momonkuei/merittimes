<table border="0" cellpadding="0" cellspacing="0" id="news_tab">
    <tr>
        <th>日期</th>
        <th>標題</th>
    </tr>
	<?php if(isset($data[$ID])):?>
		<?php foreach($data[$ID] as $k => $v):?>
			<?php if($k%2 == 0):?>
				<?php $tdClass = 'class="td_bg01" '?>
			<?php else:?>
				<?php $tdClass = ' class="td_bg02" '?>
			<?php endif?>
			<tr>
				<td width="100" <?php echo $tdClass?> ><small><?php echo $v['start_date']?></small></td>
				<td <?php echo $tdClass?> ><a href="<?php echo $v['url1']?>"><?php echo $v['name']?></a></td>
			</tr>
		<?php endforeach?>
	<?php endif?>
</table>
