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
function change_pagination4c_count(){
	var selectedvalue = document.getElementById("pagination4c_select").selectedIndex;
	var value2 = document.getElementById("pagination4c_select").options[selectedvalue].value;
	window.location.href='<?php echo $pagination['url'].$parameter['record']?>' + value2 + '<?php echo $sort_url?>';
}
</script>

<div class="row-fluid">
<?php if(0):?>
	<div class="span6">
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
		<span class="dataTables_info" id="sample_editable_1_info"><?php G::te($this->data['theme_lang'], 'Page %d / %d, Current Page by %d- %d, total $d', $pagi_params, '頁次 %d / %d, 本頁顯示 %d - %d 筆, 全部共 %d 筆')?></span>, 
		<?php G::te($this->data['theme_lang'], 'Rows per page', null, '每頁顯示筆數')?>
		<select style="width:50px" id="pagination4c_select" onchange="javascript:change_pagination4c_count();">
			<option <?php if($record == '10'):?>selected="selected"<?php endif?>>10</option>
			<option <?php if($record == '20'):?>selected="selected"<?php endif?>>20</option>
			<option <?php if($record == '30'):?>selected="selected"<?php endif?>>30</option>
			<option <?php if($record == '40'):?>selected="selected"<?php endif?>>40</option>
			<option <?php if($record == '50'):?>selected="selected"<?php endif?>>50</option>
			<option <?php if($record == '100'):?>selected="selected"<?php endif?>>100</option>
			<option <?php if($record == '200'):?>selected="selected"<?php endif?>>200</option>
			<option <?php if($record == '300'):?>selected="selected"<?php endif?>>300</option>
		</select>
<?php endif?>
	</div>
<?php endif?>
	<div class="span12">
		<div class="dataTables_paginate paging_bootstrap pagination" style="margin:0;float-gisanfu:right">
			<ul>
				<?php if($pagination['control']['total'] > 1):?>
					<?php if(!empty($pagination['control']['prevten'])):?>
						<li class="prev ">
							<a href="<?php echo $pagination['control']['prevten'].$sort_url?>">← <?php G::te($this->data['theme_lang'], 'Prev Ten Page', null, '上十頁')?></a>
						</li>
					<?php endif?>

					<li class="prev ">
						<a href="<?php echo $pagination['control']['first'].$sort_url?>"><?php G::te($this->data['theme_lang'], 'First Page', null, '第一頁')?></a>
					</li>

					<li class="prev <?php if(empty($pagination['control']['prev'])):?> disabled<?php endif?>">
						<a href="<?php echo $pagi_prev?>"><?php G::te($this->data['theme_lang'], 'Prev Page', null, '&lt;')?></a>
					</li>

					<?php foreach($pagination['number'] as $k => $v):?>
					<li <?php if($v['name'] == $pagination['control']['now']):?> class="active"<?php endif?>>
						<a href="<?php echo $v['link'].$sort_url?>"><?php echo $v['name']?></a>
					</li>
					<?php endforeach?>

					<li class="next <?php if(empty($pagination['control']['next'])):?> disabled<?php endif?>">
						<a href="<?php echo $pagi_next?>"><?php G::te($this->data['theme_lang'], 'Next Page', null, '&gt;')?> </a>
					</li>

					<li class="next ">
						<a href="<?php echo $pagination['control']['last'].$sort_url?>"><?php G::te($this->data['theme_lang'], 'Last Page', null, '最未頁')?></a>
					</li>

					<?php if(!empty($pagination['control']['nextten'])):?>
					<li class="next ">
						<a href="<?php echo $pagination['control']['nextten'].$sort_url?>"><?php G::te($this->data['theme_lang'], 'Next Ten Page', null, '下十頁')?></a>
					</li>
					<?php endif?>
				<?php endif?>
			</ul>
		</div>
	</div>
</div>

<?php if(0):?>
<div class="row-fluid">
	<div class="span6">
		<div class="dataTables_info" id="sample_editable_1_info">Showing 1 to 6 of 6 entries</div>
	</div>
	<div class="span6">
		<div class="dataTables_paginate paging_bootstrap pagination">
			<ul>
				<li class="prev disabled">
					<a href="#">← Previous</a>
				</li>
				<li class="active">
					<a href="#">1</a>
				</li>
				<li class="next disabled">
					<a href="#">Next → </a>
				</li>
			</ul>
		</div>
	</div>
</div>
<?php endif?>
