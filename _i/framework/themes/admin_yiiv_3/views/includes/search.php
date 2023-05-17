<script type="text/javascript">
	<!--
$(document).ready(function() {
	$('.cancel_search').click(function(){
		$('#search_keyword').attr('value', '');
		$('#searchFrm').submit();
	});
});

function searchkeyword(form)
{
	var aaa = base64_encode(form.search_keyword.value);
	if(aaa == ''){
		document.location.href='<?php echo $current_url?>&param=<?php echo $parameter['nosearch']?>1';
	} else {
		document.location.href='<?php echo $current_url?>&param=<?php echo $parameter['search']?>' + aaa;
	}
	return false;
}
//-->
</script>

<?php $main_content_title_action = ''?>
<?php if(isset($action)):?>
	<?php if($action == ''):?>
		<?php $main_content_title_action = ''?>
	<?php elseif($action == 'update'):?>
		<?php $main_content_title_action = ' :: '.G::t($this->data['theme_lang'], 'Modify an Data', null, '修改資料')?>
	<?php elseif($action == 'create'):?>
		<?php $main_content_title_action = ' :: '.G::t($this->data['theme_lang'], 'Establish an Data', null, '新增資料')?>
	<?php else:?>
		<?php $main_content_title_action = ''?>
	<?php endif?>
<?php endif?>


<?php if(0):?>
	<div class="formtop clearfix">
		<a href="AddUser.html"><div class="t_add fle">新增</div></a>
		<a href="#"><div class="t_delete fle">刪除</div></a>
		<div class="t_export fle">匯出</div>
	</div>
<?php endif?>

<?php if(0):?>
<h1>使用者管理系統&nbsp;&nbsp;<span class="h1blue">使用者管理</span></h1>
<?php endif?>

<form method="GET" action="<?php echo $current_url?>" id="searchFrm" name="searchFrm" onsubmit="searchkeyword(this);return false;">


	<div class="searchCopy"> <span class="fle"><?php G::te($this->data['theme_lang'], 'Search', null, '搜尋')?></span>
		<input type="text" name="search_keyword" id="search_keyword" placeholder="搜尋資料內容" />
		<input type="image" class="search_icon" title="搜尋" src="<?php echo $this->assetsUrl.$this->data['template_path']?>/images/icon007.gif" align="top" />
		<?php if(isset($search_keyword) and $search_keyword != '' and 0):?>
		<span class="search_re"><a class="cancel_search2" href="#">清除設定</a></span>
		<?php endif?>
	</div>

</form>

<?php //if(!isset($main_content_title)):?>
<?php //$main_content_title = ''?>
<?php //endif?>

<h1>
	<?php echo $main_content_title?>
	&nbsp;&nbsp;<a href="backend.php"><span class="h1blue"><?php G::te($this->data['theme_lang'], 'Home', null, '首頁')?></span></a>
	&gt;
	<?php if($default_menu_title != ''):?>
		&nbsp;&nbsp;<a href="#"><span class="h1blue"><?php echo $default_menu_title?></span></a>
		&gt;
	<?php endif?>
	&nbsp;&nbsp;<span class="h1blue"><?php echo $main_content_title.$main_content_title_action?></span>
</h1>

<!--建立按鈕-->
<div class="formtop clearfix">
	<?php if(!isset($def['disable_create']) or $def['disable_create'] != true):?>
		<?php $this->BeginWidget('system.widgets.Gw_acl', array('method'=>'create'))?>
			<a class="btn btn-large" href="<?php echo $class_url?>/create&param=<?php echo $parameter['prev'].$current_base64_url?>"><div class="t_add fle"><?php G::te($this->data['theme_lang'], 'Create', null, '新增')?></div></a>
		<?php $this->EndWidget('system.widgets.Gw_acl')?>
	<?php endif?>


	<?php if(isset($search_keyword) and $search_keyword != ''):?>
	<br />
	<div class="tableData">
		<table style="background-color:#eff;width:100%;font-size:12px;">
			<tr>
				<td><?php G::te($this->data['theme_lang'], 'Search', null, '搜尋')?>：<?php echo $search_keyword?></td>
				<td align="right"><span class="search_re"><a class="cancel_search" href="#">取消搜尋</a></span></td>
			</tr>
		</table>
	</div>
	<?php endif?>
</div>

	<?php //{{* 自定的smarty top 區塊，來自於資料庫 *}} ?>
	<?php if(isset($def['listfield_attr']['smarty_include_top_text']) and $def['listfield_attr']['smarty_include_top_text'] != ''):?>
		<?php eval($def['listfield_attr']['smarty_include_top_text'])?>
	<?php endif?>

<?php if(0):?>
	<div class="main_content">
		<div class="searchCopy"> <span class="fle">搜尋</span>
			<input name="Keyword" type="text" class="search_txt" id="Keyword" value="" />
			<input type="image" class="search_icon" title="搜尋" src="images/icon007.gif" align="top" />
			<span class="search_re"><a href="#">清除設定</a></span> </div>
		<h1>使用者管理系統&nbsp;&nbsp;<span class="h1blue">使用者管理</span></h1>
		<div class="formtop clearfix">
			<a href="AddUser.html"><div class="t_add fle">新增</div></a>
			<a href="#"><div class="t_delete fle">刪除</div></a>
			<div class="t_export fle">匯出</div>
		</div>
		<table width="98%" cellspacing="1" cellpadding="7" class="table1">
			<tbody>
				<tr class="bgcolor3">
					<td width="30" align="center"><input type="checkbox" name="chkall" id="chkall" onclick="common.checkAll(this, 'ChkID')" />
						<input type="hidden" name="TableName" id="TableName" value="record" /></td>
					<td width="55" align="center" class="w_s w_c">NO.</td>
					<td><a href="#"><div class="icondown fle"></div></a>帳號</td>
					<td>密碼</td>
					<td><a href="#"><div class="icontop fle"></div></a>姓名</td>
					<td><a href="#"><div class="icontop fle"></div>
					</a>部門 / 職位</td>
					<td width="35" align="center">編輯</td>
				</tr>
				<tr class="bgcolor2">
					<td align="center"><input name="ChkID" type="checkbox" value="175" /></td>
					<td align="center" class="w_c w_s1">1</td>
					<td>shopping</td>
					<td>1234567</td>
					<td>謝亞蘋</td>
					<td>TCO</td>
					<td align="center"><a href="AddUser.html">
							<div class="edit1"></div>
					</a></td>
				</tr>
				<tr class="bgcolor1">
					<td align="center"><input name="ChkID" type="checkbox" value="175" /></td>
					<td align="center" class="w_c w_s1">2</td>
					<td>ith</td>
					<td>8910111</td>
					<td>杜立仁</td>
					<td>資訊部工程師</td>
					<td align="center"><a href="AddUser.html">
							<div class="edit1"></div>
						</a>
					</td>
				</tr>
				<tr class="bgcolor2">
					<td align="center"><input name="ChkID" type="checkbox" value="175" /></td>
					<td align="center" class="w_c w_s1">3</td>
					<td>pauline</td>
					<td>1234567</td>
					<td>王珮苓</td>
					<td>TCO</td>
					<td align="center"><a href="AddUser.html">
							<div class="edit1"></div>
						</a>
					</td>
				</tr>
				<tr class="bgcolor1">
					<td align="center"><input name="ChkID" type="checkbox" value="175" /></td>
					<td align="center" class="w_c w_s1">4</td>
					<td>ryan</td>
					<td>1234567</td>
					<td>許信實</td>
					<td>資訊部經理</td>
					<td align="center"><a href="AddUser.html">
							<div class="edit1"></div>
						</a>
					</td>
				</tr>
				<tr class="bgcolor2">
					<td align="center"><input name="ChkID" type="checkbox" value="175" /></td>
					<td align="center" class="w_c w_s1">5</td>
					<td>shopping</td>
					<td>1234567</td>
					<td>謝亞蘋</td>
					<td>TCO</td>
					<td align="center"><a href="AddUser.html">
							<div class="edit1"></div>
						</a>
					</td>
				</tr>
				<tr class="bgcolor1">
					<td align="center"><input name="ChkID" type="checkbox" value="175" /></td>
					<td align="center" class="w_c w_s1">6</td>
					<td>shopping</td>
					<td>1234567</td>
					<td>謝亞蘋</td>
					<td>資訊部/網頁設計師</td>
					<td align="center"><a href="AddUser.html">
							<div class="edit1"></div>
					</a></td>
				</tr>
				<tr class="bgcolor2">
					<td align="center"><input name="ChkID" type="checkbox" value="175" /></td>
					<td align="center" class="w_c w_s1">7</td>
					<td>shopping</td>
					<td>1234567</td>
					<td>謝亞蘋</td>
					<td>資訊部/網頁設計師</td>
					<td align="center"><a href="AddUser.html">
							<div class="edit1"></div>
					</a></td>
				</tr>
				<tr class="bgcolor1">
					<td align="center"><input name="ChkID" type="checkbox" value="175" /></td>
					<td align="center" class="w_c w_s1">8</td>
					<td>shopping</td>
					<td>1234567</td>
					<td>謝亞蘋</td>
					<td>資訊部/網頁設計師</td>
					<td align="center"><a href="AddUser.html">
							<div class="edit1"></div>
					</a></td>
				</tr>
				<tr class="bgcolor2">
					<td align="center"><input name="ChkID" type="checkbox" value="175" /></td>
					<td align="center" class="w_c w_s1">9</td>
					<td>shopping</td>
					<td>1234567</td>
					<td>謝亞蘋</td>
					<td>資訊部/網頁設計師</td>
					<td align="center"><a href="AddUser.html">
							<div class="edit1"></div>
					</a></td>
				</tr>
				<tr class="bgcolor1">
					<td align="center"><input name="ChkID" type="checkbox" value="175" /></td>
					<td align="center" class="w_c w_s1">10</td>
					<td>shopping</td>
					<td>1234567</td>
					<td>謝亞蘋</td>
					<td>資訊部/網頁設計師</td>
					<td align="center"><a href="AddUser.html">
							<div class="edit1"></div>
					</a></td>
				</tr>
			</tbody>
		</table>
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
		<!--分頁end-->
	</div>
<?php endif?>
