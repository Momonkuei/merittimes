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
<div class="indexgo03">
	<div class="next clearfix">

		<?php if($pagination['control']['total'] > 1):?>
			<?php if(!empty($pagination['control']['prevten'])):?>
				<a href="<?php echo $pagination['control']['prevten'].$sort_url?>"><?php G::te($this->data['theme_lang'], 'Prev Ten Page', null, '上十頁')?></a>
			<?php endif?>
			<a href="<?php echo $pagination['control']['first'].$sort_url?>" class="first"><img border="0" width="21" height="22" title="<?php G::te($this->data['theme_lang'], 'First Page', null, '第一頁')?>" src="<?php echo $this->assetsUrl.$this->data['template_path']?>/images/icon010.gif"></a>
			<?php if(!empty($pagination['control']['prev'])):?>
			<a href="<?php echo $pagi_prev?>"><img src="<?php echo $this->assetsUrl.$this->data['template_path']?>/images/icon009.gif" title="<?php G::te($this->data['theme_lang'], 'Prev Page', null, '&lt;')?>" width="21" height="22" border="0" /></a>
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
			<a href="<?php echo $pagi_next?>"><img src="<?php echo $this->assetsUrl.$this->data['template_path']?>/images/icon011.gif" title="<?php G::te($this->data['theme_lang'], 'Next Page', null, '&gt;')?>" width="21" height="22" border="0" /></a>
			<?php endif?>
			<a href="<?php echo $pagination['control']['last'].$sort_url?>"><img src="<?php echo $this->assetsUrl.$this->data['template_path']?>/images/icon012.gif" title="<?php G::te($this->data['theme_lang'], 'Last Page', null, '最未頁')?>" width="21" height="22" border="0" /></a>
			<?php if(!empty($pagination['control']['nextten'])):?>
			<a href="<?php echo $pagination['control']['nextten'].$sort_url?>"><?php G::te($this->data['theme_lang'], 'Next Ten Page', null, '下十頁')?></a>
			<?php endif?>
		<?php endif?>

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

			<div class="next_r flr">
				<?php G::te($this->data['theme_lang'], 'Rows per page', null, '每頁顯示筆數')?>
				<select id="pagination4b_select" onchange="javascript:change_pagination4b_count();">
					<option <?php if($record == '10'):?>selected="selected"<?php endif?>>10</option>
					<option <?php if($record == '20'):?>selected="selected"<?php endif?>>20</option>
					<option <?php if($record == '30'):?>selected="selected"<?php endif?>>30</option>
					<option <?php if($record == '40'):?>selected="selected"<?php endif?>>40</option>
					<option <?php if($record == '50'):?>selected="selected"<?php endif?>>50</option>
					<option <?php if($record == '100'):?>selected="selected"<?php endif?>>100</option>
					<option <?php if($record == '200'):?>selected="selected"<?php endif?>>200</option>
					<option <?php if($record == '300'):?>selected="selected"<?php endif?>>300</option>
				</select>
			</div>
		<?php endif?>
	</div>

</div>

<?php if(0):?>
	<div class="indexgo03">
		<div class="next clearfix">
			<div class="next_l fle"> <a href="#"><img src="images/icon010.gif" title="第一頁" width="21" height="22" border="0" /></a> <a href="#"><img src="images/icon009.gif" title="上一頁" width="21" height="22" border="0" /></a> </div>
			<div class="next_w1 fle">第</div>
			<div class="next_s fle">
				<input name="nowPage" id="nowPage" type="text" class="next_txt" value="1" />
				<input name="jumpPage" type="button" onclick="common.jumpPage()" value="GO" />
			</div>
			<div class="next_w2 fle">頁，共 <span id="totalPage"> 18 </span> 頁</div>
			<div class="next_l fle"> <a href="#"><img src="images/icon011.gif" title="下一頁" width="21" height="22" border="0" /></a> <a href="#"><img src="images/icon012.gif" title="最後一頁" width="21" height="22" border="0" /></a> </div>
			<div class="next_r flr">顯示　1-20筆, 　共174筆</div>
		</div>
	</div>
<?php endif?>
