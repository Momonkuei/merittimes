<?php if(0):?>
  * 分頁Smarty區塊，比較特別的是mysqleric引數，如果為1，那就不會顯示"每頁顯示"的功能
  *
  * $pagination.control.(total|now|current_start_record|current_end_record|prevten|nextten|first|last|prev|next)
  * $pagination.number(array)
<?php endif?>

<?php
if($sort_url != ''){
	$sort_url = '-'.$sort_url;
}

//{{*做上一頁的判斷檢查，沒有加的話，第一頁時，上一頁會異常*}}
$pagi_prev = '';
if(isset($pagination['control']['prev']) and $pagination['control']['prev'] != ''){
	$prev_tmp = $pagination['control']['prev'];
	$pagi_prev = $prev_tmp.$sort_url;
}

//{{*只做下一頁的判斷檢查，沒有加的話，最後一頁時，下一頁會異常*}}
$pagi_next = '';
if(isset($pagination['control']['next']) and $pagination['control']['next'] != ''){
	$next_tmp = $pagination['control']['next'];
	$pagi_next = $next_tmp.$sort_url;
}

if($pagi_prev == ''){
	$pagi_prev = '#';
}
if($pagi_next == ''){
	$pagi_next = '#';
}
?>

<?php if(0):?>
	{{*只做下一頁的判斷檢查，沒有加的話，最後一頁時，下一頁會異常*}}
	{{assign var="pagi_next" value=""}}
	{{if $pagination.control.next != ''}}
		{{assign var="next_tmp" value=$pagination.control.next}}
		{{assign var="pagi_next" value=$next_tmp$sort_url}}
	{{/if}}
<?php endif?>

<script type="text/javascript">
var sort_url = '<?php echo $sort_url?>';
// FF, IE
function change_pagination4b_count(){
	var selectedvalue = document.getElementById("pagination4b_select").selectedIndex;
	var value2 = document.getElementById("pagination4b_select").options[selectedvalue].value;
	window.location.href='<?php echo $pagination['url'].$parameter['record']?>' + value2 + '<?php echo $sort_url?>';
}
</script>
<div class="tablefooter clearfix">
	<div class="pagination" style="margin:auto;">
		<?php if($pagination['control']['total'] > 0):?>
<?php 
$pagi_params = array(
	$pagination['control']['now'],
	$pagination['control']['total'],
	$pagination['current_start_record'],
	$pagination['current_end_record'],
	$pagination['total'],
);
?>
			<?php G::te($this->data['theme_lang'], 'Page %d / %d, Current Page by %d- %d, total $d', $pagi_params, '頁次 %d / %d, 本頁顯示 %d - %d 筆, 全部共 %d 筆')?>

			<?php G::te($this->data['theme_lang'], 'Rows per page', null, '每頁顯示筆數')?>
			<select id="pagination4b_select" onchange="javascript:change_pagination4b_count();">
				<option <?php if($record == '10'):?>selected="selected"<?php endif?>>10</option>
				<option <?php if($record == '20'):?>selected="selected"<?php endif?>>20</option>
				<option <?php if($record == '30'):?>selected="selected"<?php endif?>>30</option>
				<option <?php if($record == '40'):?>selected="selected"<?php endif?>>40</option>
				<option <?php if($record == '50'):?>selected="selected"<?php endif?>>50</option>
			</select>
		<?php endif?>

		&nbsp;

		<?php if($pagination['control']['total'] > 1):?>
			<?php if(!empty($pagination['control']['prevten'])):?>
				<a href="<?php echo $pagination['control']['prevten'].$sort_url?>"><?php G::te($this->data['theme_lang'], 'Prev Ten Page', null, '上十頁')?></a>
			<?php endif?>
			<a href="<?php echo $pagination['control']['first'].$sort_url?>" class="first"><?php G::te($this->data['theme_lang'], 'First Page', null, '第一頁')?></a>
			<?php if(!empty($pagination['control']['prev'])):?>
			<a href="<?php echo $pagi_prev?>"><?php G::te($this->data['theme_lang'], 'Prev Page', null, '&lt;')?></a>
			<?php endif?>

			<?php foreach($pagination['number'] as $k => $v):?>
				<?php // *如果是當前的分頁，會使用不同的方式來呈現*?>
				<?php if($v['name'] == $pagination['control']['now']):?>
				<a class="current" href="#"><?php echo $v['name']?></a>
				<?php else:?>
					<a href="<?php echo $v['link'].$sort_url?>"><?php echo $v['name']?></a>
				<?php endif?>
			<?php endforeach?>

			<?php if(!empty($pagination['control']['next'])):?>
			<a href="<?php echo $pagi_next?>"><?php G::te($this->data['theme_lang'], 'Next Page', null, '&gt;')?></a>
			<?php endif?>
			<a href="<?php echo $pagination['control']['last'].$sort_url?>"><?php G::te($this->data['theme_lang'], 'Last Page', null, '最未頁')?></a>
			<?php if(!empty($pagination['control']['nextten'])):?>
			<a href="<?php echo $pagination['control']['nextten'].$sort_url?>"><?php G::te($this->data['theme_lang'], 'Next Ten Page', null, '下十頁')?></a>
			<?php endif?>
		<?php else:?>
		&nbsp;
		<?php endif?>
	</div>

	<?php if(0):?>
	<div class="actions">
		<select>
			<option>批次管理</option>
			<option>刪除</option>
		</select>
		<button class="button small">執行</button>
	</div>
	<?php endif?>

</div>

<?php if(0):?>
<div class="infoList">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td align="left"><div class="pageNav"><label>頁次 1 , 本頁顯示 1 - 3 筆 , 全部共 3 筆紀錄</label></div></td>
			<td align="right">
    		<div class="pageNav" style="">
				<a class="first" title="第一頁">&nbsp;</a>
				<a class="previous" title="上一頁">&nbsp;</a>　
				<span class="selected">1</span>　<a href="/website/website_list-f2-dir0-pg1">2</a>　<a href="/website/website_list-f2-dir0-pg2">3</a>　<a href="/website/website_list-f2-dir0-pg3">4</a>　<a href="/website/website_list-f2-dir0-pg4">5</a>　<a href="/website/website_list-f2-dir0-pg5">6</a>　<a href="/website/website_list-f2-dir0-pg6">7</a>　<a href="/website/website_list-f2-dir0-pg7">8</a>　<a href="/website/website_list-f2-dir0-pg8">9</a>　<a href="/website/website_list-f2-dir0-pg9">10</a>　<a href ="/website/website_list-f2-dir0-pg10">11...</a>　
				<a href ="/website/website_list-f2-dir0-pg1" class="next" title="下一頁">&nbsp;</a>
				<a href ="/website/website_list-f2-dir0-pg23" title="最末頁" class="last">&nbsp;</a>
			</div>
			</td>
		</tr>
	</table>
</div><!--end infoList-->

<div class="tablefooter clearfix">
	<div class="actions">
		<select>
			<option>批次管理</option>
			<option>刪除</option>
		</select>
		<button class="button small">執行</button>
	</div>
	<div class="pagination">
		<a href="#">Prev</a>
		<a class="current" href="#">1</a>
		<a href="#">2</a>
		<a href="#">3</a>
		<a href="#">4</a>
		<a href="#">5</a>
		...
		<a href="#">20</a>
		<a href="#">下一頁</a>
	</div>
</div>
<?php endif?>
