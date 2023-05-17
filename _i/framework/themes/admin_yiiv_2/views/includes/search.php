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
function change_pagination4a_count(){
	var selectedvalue = document.getElementById("pagination4a_select").selectedIndex;
	var value2 = document.getElementById("pagination4a_select").options[selectedvalue].value;
	window.location.href='<?php echo $pagination['url'].$parameter['record']?>' + value2 + '<?php echo $sort_url?>';
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

<div class="title">
	<h1><?php echo $main_content_title?></h1>
	<ul id="breadcrumbs">
		<li><a href="backend.php"><?php G::te($this->data['theme_lang'], 'Home', null, '首頁')?></a></li>
		<li>&gt;</li>
		<?php if($default_menu_title != ''):?>
			<li><a href="#"><?php echo $default_menu_title?></a></li>
			<li>&gt;</li>
		<?php endif?>
		<li class="selected"><a href="#"><?php echo $main_content_title.$main_content_title_action?></a></li>
	</ul>
	<div class="clear"></div>
</div>	

<!--建立按鈕-->
<?php if(!isset($def['disable_create']) or $def['disable_create'] != true):?>
	<?php $this->BeginWidget('system.widgets.Gw_acl', array('method'=>'create'))?>
	<div class="shortcuts-edit">
		<a class="btn btn-large" href="<?php echo $class_url?>/create&param=<?php echo $parameter['prev'].$current_base64_url?>"><?php G::te($this->data['theme_lang'], 'Create', null, '新增')?></a>
	</div>
	<?php $this->EndWidget('system.widgets.Gw_acl')?>
<?php endif?>

<?php if($search_keyword != ''):?>
<div class="tableData">
	<table style="background-color:#eff;width:100%;font-size:12px;">
		<tr>
			<td><?php G::te($this->data['theme_lang'], 'Search', null, '搜尋')?>：<?php echo $search_keyword?></td>
			<td align="right"><a class="cancel_search" href="#">取消搜尋</a></td>
		</tr>
	</table>
</div>
<?php endif?>

<form method="GET" action="<?php echo $current_url?>" id="searchFrm" name="searchFrm" onsubmit="searchkeyword(this);return false;">
	<div class="fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix">
		<?php //{{* 因為我分頁每頁最少10筆，所以我下了個條件在這裡，有需要才出現 *}}?>
		<?php if($pagination['total'] > 10):?>
		<div class="dataTables_length" id="datatable_length">
			<?php G::te($this->data['theme_lang'], 'Rows per page', null, '每頁顯示筆數')?>
			<select size="1" id="pagination4a_select" onchange="javascript:change_pagination4a_count();">
				<option <?php if($record == '10'):?>selected="selected"<?php endif?>>10</option>
				<option <?php if($record == '20'):?>selected="selected"<?php endif?>>20</option>
				<option <?php if($record == '30'):?>selected="selected"<?php endif?>>30</option>
				<option <?php if($record == '40'):?>selected="selected"<?php endif?>>40</option>
				<option <?php if($record == '50'):?>selected="selected"<?php endif?>>50</option>
			</select>
		</div>
		<?php endif?>

		<?php //{{* 自定的smarty top 區塊 *}} ?>
		<?php if(isset($def['listfield_attr']['smarty_include_top']) and $def['listfield_attr']['smarty_include_top'] != ''):?>
			<?php echo $this->renderPartial('//'.$def['listfield_attr']['smarty_include_top'], $this->data)?>
		<?php endif?>

		<?php //{{* 自定的smarty top 區塊，來自於資料庫 *}} ?>
		<?php if(isset($def['listfield_attr']['smarty_include_top_text']) and $def['listfield_attr']['smarty_include_top_text'] != ''):?>
			<?php eval($def['listfield_attr']['smarty_include_top_text'])?>
		<?php endif?>

		<div class="dataTables_filter" id="datatable_filter">
			<?php if($def['data_multilanguage'] == true and $router_method == 'index'):?>
			<select name="edit_lang" onchange="document.location.href=vir_path_c+'backend.php?r=auth/switchdataml&ml_key='+this.value+'&current_base64_url=<?php echo $current_base64_url?>';">
				<?php foreach($mls_frontend as $k => $v):?>
					<option value="<?php echo $k?>" <?php if($k == $ml_key):?>selected="selected"<?php endif?> ><?php echo $v?></option>
				<?php endforeach?>
				</select>
			<?php endif?>
			<?php //這裡我把acl拿掉，別忘了加回去?>
			&nbsp;<?php G::te($this->data['theme_lang'], 'Search', null, '搜尋')?>: <input type="text" name="search_keyword" id="search_keyword" placeholder="搜尋資料內容"><button class="button small">Go</button>
		</div>
	</div>
</form>

<?php if(0):?>
<section id="main" class="grid_12">
	<article>
		<h1>Tables</h1>
		
		<h2>Standard Table</h2>
		
		<form>
			<div class="fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix">
				<div class="dataTables_length" id="datatable_length">
					單頁顯示 
					<select size="1" name="datatable_length">
						<option value="10">10</option>
						<option value="25">25</option>
						<option value="50">50</option>
						<option value="100">100</option>
					</select>
					個產品
				</div>
				<div class="dataTables_length" id="datatable_class">
					<div class="select_menu">
						<ul>
							<li class="option_list">
								<a href="#" class="option_selected">產品分類選擇</a>
								<ul style="display: none;">
									<li>
										<a href="#" class="">平板電腦</a> 
										<ul class="children c1" style="display: none;">
											<li><a href="#" class="">Apple</a>
												<ul class="children c2" style="display: none;">
													<li><a href="#" class="">Apple</a></li>
													<li><a href="#" class="">Acer</a></li>
												</ul>
											</li>
											<li><a href="#" class="">Acer</a></li>
										</ul>
									</li>
									<li>
										<a href="#" class="">行動電話</a>
										<ul class="children c1" style="display: none;">
											<li><a href="#" class="">Apple</a></li>
											<li><a href="#" class="hovered_item">Acer</a></li>
										</ul> 
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
				<div class="dataTables_filter" id="datatable_filter">搜尋: <input type="text" placeholder="搜尋產品名稱或型號"><button class="button small">Go</button>
				</div>
			</div>
			<table id="table1" class="gtable sortable">
				<thead>
					<tr>
						<th><input type="checkbox" class="checkall" /></th>
						<th>Column 1</th>
						<th>Column 2</th>
						<th>Column 3</th>
						<th>Column 4</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><input type="checkbox" /></td>
						<td>Lorem ipsum 1</td>
						<td>dolor sit amet</td>
						<td>consectetur adipiscing elit</td>
						<td>
							<img class="move" src="images/icons/arrow-move.png" alt="Move" title="Move" />
							<a href="#" title="Edit"><img src="images/icons/edit.png" alt="Edit" /></a>
							<a href="#" title="Delete"><img src="images/icons/cross.png" alt="Delete" /></a>
						</td>
					</tr>
					<tr>
						<td><input type="checkbox" /></td>
						<td>Lorem ipsum 2</td>
						<td>dolor sit amet</td>
						<td>consectetur adipiscing elit</td>
						<td>
							<img class="move" src="images/icons/arrow-move.png" alt="Move" title="Move" />
							<a href="#" title="Edit"><img src="images/icons/edit.png" alt="Edit" /></a>
							<a href="#" title="Delete"><img src="images/icons/cross.png" alt="Delete" /></a>
						</td>
					</tr>
					<tr>
						<td><input type="checkbox" /></td>
						<td>Lorem ipsum 3</td>
						<td>dolor sit amet</td>
						<td>consectetur adipiscing elit</td>
						<td>
							<img class="move" src="images/icons/arrow-move.png" alt="Move" title="Move" />
							<a href="#" title="Edit"><img src="images/icons/edit.png" alt="Edit" /></a>
							<a href="#" title="Delete"><img src="images/icons/cross.png" alt="Delete" /></a>
						</td>
					</tr>
					<tr>
						<td><input type="checkbox" /></td>
						<td>Lorem ipsum 4</td>
						<td>dolor sit amet</td>
						<td>consectetur adipiscing elit</td>
						<td>
							<img class="move" src="images/icons/arrow-move.png" alt="Move" title="Move" />
							<a href="#" title="Edit"><img src="images/icons/edit.png" alt="Edit" /></a>
							<a href="#" title="Delete"><img src="images/icons/cross.png" alt="Delete" /></a>
						</td>
					</tr>
					<tr>
						<td><input type="checkbox" /></td>
						<td>Lorem ipsum 5</td>
						<td>dolor sit amet</td>
						<td>consectetur adipiscing elit</td>
						<td>
							<img class="move" src="images/icons/arrow-move.png" alt="Move" title="Move" />
							<a href="#" title="Edit"><img src="images/icons/edit.png" alt="Edit" /></a>
							<a href="#" title="Delete"><img src="images/icons/cross.png" alt="Delete" /></a>
						</td>
					</tr>
					<tr>
						<td><input type="checkbox" /></td>
						<td>Lorem ipsum 6</td>
						<td>dolor sit amet</td>
						<td>consectetur adipiscing elit</td>
						<td>
							<img class="move" src="images/icons/arrow-move.png" alt="Move" title="Move" />
							<a href="#" title="Edit"><img src="images/icons/edit.png" alt="Edit" /></a>
							<a href="#" title="Delete"><img src="images/icons/cross.png" alt="Delete" /></a>
						</td>
					</tr>
					<tr>
						<td><input type="checkbox" /></td>
						<td>Lorem ipsum 7</td>
						<td>dolor sit amet</td>
						<td>consectetur adipiscing elit</td>
						<td>
							<img class="move" src="images/icons/arrow-move.png" alt="Move" title="Move" />
							<a href="#" title="Edit"><img src="images/icons/edit.png" alt="Edit" /></a>
							<a href="#" title="Delete"><img src="images/icons/cross.png" alt="Delete" /></a>
						</td>
					</tr>
					<tr>
						<td><input type="checkbox" /></td>
						<td>Lorem ipsum 8</td>
						<td>dolor sit amet</td>
						<td>consectetur adipiscing elit</td>
						<td>
							<img class="move" src="images/icons/arrow-move.png" alt="Move" title="Move" />
							<a href="#" title="Edit"><img src="images/icons/edit.png" alt="Edit" /></a>
							<a href="#" title="Delete"><img src="images/icons/cross.png" alt="Delete" /></a>
						</td>
					</tr>
					<tr>
						<td><input type="checkbox" /></td>
						<td>Lorem ipsum 9</td>
						<td>dolor sit amet</td>
						<td>consectetur adipiscing elit</td>
						<td>
							<img class="move" src="images/icons/arrow-move.png" alt="Move" title="Move" />
							<a href="#" title="Edit"><img src="images/icons/edit.png" alt="Edit" /></a>
							<a href="#" title="Delete"><img src="images/icons/cross.png" alt="Delete" /></a>
						</td>
					</tr>
					<tr>
						<td><input type="checkbox" /></td>
						<td>Lorem ipsum 10</td>
						<td>dolor sit amet</td>
						<td>consectetur adipiscing elit</td>
						<td>
							<img class="move" src="images/icons/arrow-move.png" alt="Move" title="Move" />
							<a href="#" title="Edit"><img src="images/icons/edit.png" alt="Edit" /></a>
							<a href="#" title="Delete"><img src="images/icons/cross.png" alt="Delete" /></a>
						</td>
					</tr>
				</tbody>
			</table>
			<div class="tablefooter clearfix">
				<div class="actions">
					<select>
						<option>Action:</option>
						<option>Delete</option>
						<option>Move</option>
					</select>
					<button class="button small">Apply</button>
				</div>
				<div class="pagination">
					<!--<a href="#">Prev</a>-->
					<a href="#" class="current">1</a>
					<a href="#">2</a>
					<a href="#">3</a>
					<a href="#">4</a>
					<a href="#">5</a>
					...
					<a href="#">78</a>
					<a href="#">Next</a>
				</div>
			</div>
		</form>
	</article>
</section>
<?php endif?>
