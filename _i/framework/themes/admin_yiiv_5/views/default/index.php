<?php

if(!empty($def['searchfield']['head'])){
	foreach($def['searchfield']['head'] as $v){
		Yii::app()->clientScript->registerCoreScript($v);
	}// foreach
} //if

// 為了要支援sort_id改欄位名稱
$sort_field = 'sort_id';
if(isset($this->def['func_field']['sort_id']) and $this->def['func_field']['sort_id'] != ''){
	$sort_field = $this->def['func_field']['sort_id'];
}

// 設定預設的排版欄位名稱
$sort_id_tmp = '';
if(isset($def['sortable'][$sort_field.'_name'])){
	$sort_id_tmp = $def['sortable'][$sort_field.'_name'];
}
if($sort_id_tmp == ''){
	$sort_id_tmp = $sort_field;
}

//Yii::app()->clientScript->registerCssFile($this->assetsUrl.$this->data['template_path'].'/css/demo_table_jui.css');
if(isset($def['sortable']['enable']) and $def['sortable']['enable'] == true and (($sort_field_nobase64 == $sort_id_tmp and $sort_direction == 'asc') or ($sort_field == '' and $sort_direction == '' and $def['default_sort_field'] == $sort_id_tmp)) ){ 
	Yii::app()->clientScript->registerCoreScript('jquery.ui');
	// 當即時排序的開關啟用，以及目前狀況是使用sort_id正向排序，才會啟用即時排序
	$this->data['sort_id_tmp'] = $sort_id_tmp;
	echo $this->renderPartial('includes/jquery_sortable_init', $this->data);
}
//2017/7/12 刪除提醒字眼加入名稱 by lota
// $_alert_txt = G::t('en','Are you sure you want to delete');
$_alert_txt = '你是否要刪除';
$script_default_a = <<<XXX0
	$('.del_button').click(function(){
		var id = $(this).attr('itemid');
		var name = $(this).attr('itemname');
		if(confirm('{$_alert_txt}' + ' ' + name + ' ? ')){
			window.location.href = '{$class_url}/delete&param={$parameter['value']}' + id + '-{$parameter['prev']}{$current_base64_url}';
		}
	});

	//即時點選，即時更改
	$('.checkbox_listcontent_trigger').click(function(){
		var value = 0;
		if($(this).attr('checked')){
			value = 1;
		}

		var ids_tmp = $(this).attr('id');
		// checkbox_listcontent_trigger__fieldvalue
		var ids = ids_tmp.split('__');
		var id = ids[1];
		var field;
		if(ids.length > 2){
			field = ids[2];
		}

		// 其它的控制變數
		var id_reload = $(this).attr('id_reload');
		var id_alert = $(this).attr('id_alert');
		//lota add 紀錄修改的時間 2016/7/19
		var id_uptime = $(this).attr('id_uptime');

		$.ajax({
			type: "POST",
			data: {
				'value': value,
				'id': id,
				'field': field,
				'uptime': id_uptime
			},
			url: '{$class_url}/checkbox_listcontent_trigger',
			success: function(response){
				if(response == '1'){
					if(id_alert != ''){
						alert(id_alert);
					}
					if(id_reload == '1'){
						location.reload();
					}
				}
			}
		}); // ajax
	});
XXX0;
Yii::app()->clientScript->registerScript('script_default_a', $script_default_a, CClientScript::POS_READY);

if(isset($def['sortable']['url'])){
	$condition = '';
	if(isset($def['sortable']['condition'])){
		$condition = stripslashes($def['sortable']['condition']);
	}
	$script_default_b = <<<XXX1
	// item_id 物件編號
	// position 從1開始的位置
	function arrow_sort(item_id, position){
		$.post('{$def['sortable']['url']}', { nnn: '{$def['table']}', id: item_id, position: position, mmm: '{$condition}', ppp: '{$sort_id_tmp}' },
			function(data){
				if(data != '1'){
					// 我知道可能會失敗，不過不理它，只要沒反應就好了
					//alert('動作失敗');
				} else {
					location.reload();
				}
			}, "html"
		);
	}
XXX1;
	Yii::app()->clientScript->registerScript('script_default_b', $script_default_b, CClientScript::POS_END);
}

if(!empty($def['searchfield']) and isset($def['enable_index_advanced_search']) and $def['enable_index_advanced_search'] == true){

	// 2019-07-09
	$this->data['def']['updatefield_tmp'] = $this->data['def']['updatefield'];
	$this->data['def']['updatefield'] = $this->data['def']['searchfield'];

	/*
	 * 底下是新增在使用的
	 */
	if(!empty($def['searchfield']['head'])){
		foreach($def['searchfield']['head'] as $v){
			Yii::app()->clientScript->registerCoreScript($v);
		}// foreach
	} //if

	$update_create_1 = $this->renderPartial('includes/default_validate', $this->data)."\n";
	//if(isset($update_success) and $update_success == '1'){
	//	$update_create_1 .= "alert(l.get('Update success'));\n";
	//}

	$update_create_1 .= $this->renderPartial('default/update_javascript', $this->data)."\n";
	// 自定的javascript區塊，存放在實體檔案
	if(isset($def['searchfield']['smarty_javascript']) and $def['searchfield']['smarty_javascript'] != ''){
		//$update_create_1 .= $this->renderPartial('//'.$def['searchfield']['smarty_javascript'], $this->data)."\n";
		$update_create_1 .= $this->renderPartial($def['searchfield']['smarty_javascript'], $this->data)."\n";
	}

	// 自定的javascript區塊，存放資料庫
	if(isset($def['searchfield']['smarty_javascript_text']) and $def['searchfield']['smarty_javascript_text'] != ''){
		$update_create_1 .= $def['searchfield']['smarty_javascript_text']."\n";
	}
	//echo $update_create_1;
	//die;

	$update_create_1 .= <<<XXX1
XXX1;

	Yii::app()->clientScript->registerScript('update_create_1', $update_create_1, CClientScript::POS_END);

	$this->data['def']['updatefield'] = $this->data['def']['updatefield_tmp'];
	$def['updatefield'] = $this->data['def']['updatefield_tmp'];
}
?>


<?php echo $this->renderPartial('includes/search', $this->data)?>

<?php // http://jsbin.com/urarem/3/edit?>
<?php // 樹狀結構在使用的(layoutv3pagetype)?>
<style type="text/css">
.boxg{
    display: none;
    width: 100%;
}
a:hover + .boxg,.boxg:hover{
    display: block;
    position: relative;
    z-index: 100;
}
</style>

<div class="row">

	<?php if(count($this->data['tcofastmenus']) > 0):?>
	<div class="col-md-10">
	<?php else:?>
	<div class="col-md-12">
	<?php endif?>

<?php //*麵包或是功能標題*}} ?>
<?php if(!empty($def['searchfield']) and isset($def['enable_index_advanced_search']) and $def['enable_index_advanced_search'] == true):?>
	<?php $this->data['def']['updatefield_tmp'] = $this->data['def']['updatefield']?>
	<?php $this->data['def']['updatefield'] = $this->data['def']['searchfield']?>
	<?php $this->data['def']['updatefield']['form']['attr']['action'] = $this->data['class_url'].'/search'?>

	<?php $def['updatefield_tmp'] = $def['updatefield']?>
	<?php $def['updatefield'] = $def['searchfield']?>
	<?php $def['updatefield']['form']['attr']['action'] = $this->data['class_url'].'/search'?>
	<?php //$this->data['def']['updatefield']['method'] = 'create'?>
	<?php //die?>
		<div class="portlet box blue">

		<div class="portlet-title">
<?php if(!isset($def['searchfield']['advanced_title'])):?>
			<div class="caption"><i class="icon-search"></i><?php echo G::_('Advanced Search', 'en')?></div>
<?php else:?>
			<div class="caption"><i class="icon-search"></i><?php echo $def['searchfield']['advanced_title']?></div>
<?php endif?>
			<div class="tools">
				<a class="<?php if(isset($v['section_disable']) and $v['section_disable'] == true and 0):?>expand<?php else:?>collapse<?php endif?>" href="javascript:;"></a>
<?php if(0):?>
				<a class="collapse" href="javascript:;"></a>
				<a class="config" data-toggle="modal" href="#portlet-config"></a>
				<a class="reload" href="javascript:;"></a>
				<a class="remove" href="javascript:;"></a>
<?php endif?>
			</div>
		</div>

		
		<div class="portlet-body" <?php if(isset($v['section_disable']) and $v['section_disable'] == true and 0):?>style="display:none"<?php endif?>>

			<?php if($def['updatefield']['form']['enable'] == true):?>
				<?php $formattr = ''?>
				<?php if(!empty($def['updatefield']['form']['attr'])):?>
					<?php foreach($def['updatefield']['form']['attr'] as $k => $v):?>
						<?php $formattr = $formattr.' '.$k.'="'.$v.'"'?>
					<?php endforeach?>
				<?php endif?>
				<?php // enctype="multipart/form-data" ?>
				<form <?php echo $formattr?>>
			<?php endif?>

			<?php echo $this->renderPartial('default/update_fields', $this->data)?>

			<div class="buttons indexgo03" style2="clear:both;">
				<?php if(!isset($this->data['router_method_view']) or $this->data['router_method_view'] != '1'):?>
					<button class="btn blue" type="submit"><i class="icon-ok"></i><?php echo G::_('Search', 'en')?></button>
					<button class="btn red" type="submit" onclick="javascript:location.href='<?php echo $this->createUrl($this->data['router_class'].'/cancel_search')?>';return false;"><i class="icon-remove"></i><?php echo G::_('Cancel Search', 'en')?></button>
				<?php endif?>
	<?php if(isset($prev_url) and $prev_url != ''):?>
				<button onclick="document.location.href='<?php echo $prev_url?>';" class="btn green" type="button"><?php echo G::_('Previous Page', 'en')?></button>
	<?php endif?>
			</div>

			<input type="hidden" name="update_base64_url" value="<?php if(isset($update_base64_url)){ echo $update_base64_url; }?>" />
			<input type="hidden" name="prev_url" value="<?php if(isset($update_base64_url)){ echo $prev_url; }?>" />

			<?php if($def['updatefield']['form']['enable'] == true):?>
			</form>
			<?php endif?>

				
		</div>
		
		</div> <!-- portlet box -->		
	<?php $this->data['def']['updatefield'] = $this->data['def']['updatefield_tmp']?>
	<?php $def['updatefield'] = $this->data['def']['updatefield_tmp']?>

<?php endif?><?php //empty($def.updatefield)?>

	<div class="portlet box light-grey" style="border-style:none">

	<?php if(isset($this->data['listfield_show_top_pagination']) and $this->data['listfield_show_top_pagination'] == true):?>
		<?php echo $this->renderPartial('includes/pagination4c', $this->data)?>
	<?php endif?>

	<div class="portlet-body" style="padding:0px">

		<?php if(isset($this->data['listfield_start_html']) and $this->data['listfield_start_html'] != ''):?>
		<?php echo $this->data['listfield_start_html']?>
		<?php endif?>

		<?php if(!empty($listcontent)): ?>

			<?php if(0 and isset($this->data['listfield_start_html']) and $this->data['listfield_start_html'] != ''):?>
				<?php echo $this->data['listfield_start_html']?>
			<?php endif?>
			<?php if($this->data['router_class']=='writeplan'):?>
				<div class="btn-group">
					<button class="btn red" onclick="javascript:DoReview();">
					批量審核
					</button>
				</div>
				<script type="text/javascript">
					function DoReview(){
						if($('#a_results_f').val()==''){
							alert('請選擇審核結果');
						}else{
							var have_data=false;
							$('.checkboxes').each(function(){
								if($(this).attr('checked')){
									have_data=true;
								}
							});
							if(have_data==false){
								alert('請選擇審核計畫');
							}else{
								$('#ezdelete').attr('action', '<?php echo $class_url?>/review&param=<?php echo $parameter['prev'].$current_base64_url?>');
								if (confirm('是否確定送出?')){
									$('#ezdelete').submit();
								}
							}
						}
					}					
				</script>
			<?php endif?>																	
			
				
		</div>
			<?php if((isset($def['enable_delete']) and $def['enable_delete'] == true) || $this->data['router_class']=='writeplan'):?>
			
			<form method="post" id="ezdelete" action="">				

			<?php endif?>
				<?php if($this->data['router_class']=='writeplan'):?>
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption">審核</div>
					</div>	
						<div class="portlet-body">
							<table  width="98%" border="0" cellspacing="1" cellpadding="7" class="table1 table">
								<tbody>
									<tr class="bgcolor1">
										<td>批量審查選擇-審核結果<span class="required"></span></td>
										<td>
											<select id="a_results_f" name="a_results_f" class="form-control input-large">
												<option value="">請選擇</option>
												<option value="未核可">未核可</option>
												<option value="核可">核可</option>
											</select>
										</td>
									</tr>
									<tr class="bgcolor2">
										<td>批量審查選擇-審核意見<span class="required"></span></td>
										<td>
											<select id="r_comments_f"  name="r_comments_f" class="form-control input-large">
												<option value="">請選擇</option>
												<option value="資料完整，審核順利通過">資料完整，審核順利通過</option>
												<option value="資料有缺，需補充相關資料">資料有缺，需補充相關資料</option>
												<option value="報份過多，故有調整">報份過多，故有調整</option>
												<option value="資料缺乏過多，審核未過">資料缺乏過多，審核未過</option>
											</select>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					
				</div>
				<?php endif?>		
		<table id="tablelist" class="table1 sortable table table-striped table-bordered table-hover dataTable" aria-describedby="sample_1_info">
			<?php if(isset($this->data['listfield_caption_html']) and $this->data['listfield_caption_html'] != ''):?>
				<?php echo $this->data['listfield_caption_html']?>
			<?php endif?>
			<thead>
			<tr>
				<?php // 顯示欄位名稱，包含排序 ?>
				<?php echo $this->renderPartial('default/index_fields_top', $this->data)?>
	
				<?php if(!isset($def['disable_action']) or $def['disable_action'] != true):?>
				<th width="<?php if(isset($def['action_width'])):?><?php echo $def['action_width']?><?php else:?>10%<?php endif?>"><?php if(isset($def['action_name'])):?><?php echo $def['action_name']?><?php else:?><?php echo G::_('Form Action', 'en')?><?php endif?></th>
				<?php endif?>
			</tr>
			</thead>
			<tbody oncontextmenu="return false;">
			<?php foreach($listcontent as $k =>$v): ?>

			<tr class="<?php echo ($k%2==1)?'even':'odd' ?>" id="sortable_id_<?php echo $v[$def['func_field']['id']]?>">
				<?php // 這裡欄位資料的顯示，會依照欄位的定義，自動顯示出來 ?>
				<?php $this->data['k'] = $k?>
				<?php $this->data['v'] = $v?>
				<?php $this->data['listcontent'] = $listcontent?>
				<?php echo $this->renderPartial('default/index_fields_bottom', $this->data)?>

				<?php if(!isset($def['disable_action']) or $def['disable_action'] != true):?>
					<td>
						<?php //當即時排序有啟動的時候，或者是預設就有排序的狀況，或者是沒有排序的狀況，才會啟用 ?>
						<?php if(isset($def['sortable']['enable']) and $def['sortable']['enable'] == true and (($sort_field_nobase64 == $sort_id_tmp and $sort_direction == 'asc') or ($sort_field == '' and $sort_direction == '' and $def['default_sort_field'] == $sort_id_tmp)) && $this->data['router_class']!='writeplan' ):?>
							<a class="btn default btn-xs blue move" href="#" title="移動"><i class="icon-move"></i><?php echo G::_('移動', 'tw')?></a>
						<?php endif?>

						<?php // 想要客制裡面的按鈕 2015/02/10?>
						<?php if(isset($def['action_list']) and count($def['action_list']) >0):?>
							<?php foreach($def['action_list'] as $kk => $vv):?>
								<?php if(!isset($def['disable_'.$vv['name']]) or $def['disable_'.$vv['name']] != true):?>
									<?php if(isset($v['_'.$vv['name'].'_disable']) and $v['_'.$vv['name'].'_disable'] == true):?><?php continue?><?php endif?>
									<?php $this->BeginWidget('system.widgets.Gw_acl', array('method'=>$vv['name']))?>
									<a class="<?php if(isset($vv['class'])):?><?php echo $vv['class']?><?php endif?>" href="<?php echo $vv['href']?>" <?php if(isset($vv['other_attr'])):?><?php if(!isset($vv['other_attr_field'])):?><?php $vv['other_attr_field'] = 'id'?><?php endif?><?php if(isset($v[$vv['other_attr_field']])):?><?php echo str_replace(':ID', $v[$vv['other_attr_field']], $vv['other_attr'])?><?php else:?><?php echo $vv['other_attr']?><?php endif?><?php endif?> title="<?php echo ucfirst($vv['name'])?>"><?php if(isset($vv['icon_class'])):?><i class="<?php echo $vv['icon_class']?>"></i><?php endif?><?php echo $vv['topic']?></a>
									<?php $this->EndWidget('system.widgets.Gw_acl')?>
								<?php endif?>
							<?php endforeach?>
						<?php endif?>

						<?php if(!isset($def['disable_edit']) or $def['disable_edit'] != true):?>
							<?php $this->BeginWidget('system.widgets.Gw_acl', array('method'=>'update'))?>

							<?php if(isset($def['enable_edit_button_changeto_view_button']) and $def['enable_edit_button_changeto_view_button'] == true):?>
								<?php // 當需求是：想要有純觀看的功能，但是裡面又要有欄位可以做修改的動作，那就只是改一下edit的按鈕->View的按鈕?>
								<a class="btn default btn-xs red-stripe" href="<?php echo $class_url?>/update&param=<?php echo $parameter['value'].$v[$def['func_field']['id']].'-'.$parameter['prev'].$current_base64_url?>" title="Edit"><?php echo G::_('View', 'en')?></a>
							<?php else:?>
								<a class="btn default btn-xs purple" href="<?php echo $class_url?>/update&param=<?php echo $parameter['value'].$v[$def['func_field']['id']].'-'.$parameter['prev'].$current_base64_url?>" title="Edit"><i class="icon-edit"></i><?php echo G::_('Edit', 'en')?></a>
							<?php endif?>

							<?php $this->EndWidget('system.widgets.Gw_acl')?>
						<?php endif?>
						<?php //2017/7/12 刪除提醒字眼加入名稱 by lota?>
						<?php if(!isset($def['disable_delete']) or $def['disable_delete'] != true):?>
							<?php $this->BeginWidget('system.widgets.Gw_acl', array('method'=>'delete'))?>
							<a class="btn btn-xs red del_button" href="javascript:;" title="Delete" itemid="<?php echo $v[$def['func_field']['id']]?>" itemname="<?php if(isset($v['name']) or isset($v['topic'])) { echo (isset($v['name']))?strip_tags($v['name']):strip_tags($v['topic']); }?>"><i class="icon-trash"></i><?php echo G::_('Delete', 'en')?></a>
							<?php $this->EndWidget('system.widgets.Gw_acl')?>
						<?php endif?>

						<?php if(isset($def['enable_view']) and $def['enable_view'] == true):?>
							<?php $this->BeginWidget('system.widgets.Gw_acl', array('method'=>'view'))?>
							<a class="btn default btn-xs red-stripe" href="<?php echo $class_url?>/view&param=<?php echo $parameter['value'].$v[$def['func_field']['id']].'-'.$parameter['prev'].$current_base64_url?>"><?php echo G::_('View', 'en')?></a>
							<?php $this->EndWidget('system.widgets.Gw_acl')?>
						<?php endif?>

						<?php // 當需求是：想要有連結按鈕，依據不同的資料網址，不需要權限，且要開新頁?>
						<?php foreach($v as $kk => $vv):?>
							<?php if(preg_match('/^_enable_custom_button_(.*)$/', $kk)):?>
								<?php echo $vv?>
							<?php endif?>
						<?php endforeach?>
					</td>
				<?php endif?>
			</tr>

			<?php // 2015/5/21的新功能?>
			<?php if(isset($listcontent_row_details_open[$v[$def['func_field']['id']]])):?>
			<tr class="row_details_open" id="row_details_open_<?php echo $v[$def['func_field']['id']]?>">
				<td class="details" colspan="6">
					<?php echo $listcontent_row_details_open[$v[$def['func_field']['id']]]?>
				</td>
			</tr>
			<?php endif?>

			<?php endforeach?>
			</tbody>

			<?php if(isset($this->data['listfield_foot'])):?>
				<?php if(isset($this->data['listfield_disable_foot']) and $this->data['listfield_disable_foot'] == true):?>
					<?php // do nothing?>
				<?php else:?>
					<thead>
					<tr>
						<?php // 顯示欄位名稱，包含排序 ?>
						<?php $this->data['listfield_tmp'] = $this->data['listfield']?>
						<?php $this->data['listfield'] = $this->data['listfield_foot']?>
						<?php echo $this->renderPartial('default/index_fields_top', $this->data)?>
						<?php $this->data['listfield'] = $this->data['listfield_tmp']?>
					</tr>
					</thead>
				<?php endif?>
			<?php endif?>

			<?php if(!empty($listcontent_foot)): ?>
				<tfoot>
				<?php $this->data['listfield_tmp'] = $this->data['listfield']?>
				<?php $this->data['listfield'] = $this->data['listfield_foot']?>
				<?php foreach($listcontent_foot as $k =>$v): ?>
					<tr class="<?php echo ($k%2==1)?'bgcolor1':'bgcolor2' ?>">
						<?php // 這裡欄位資料的顯示，會依照欄位的定義，自動顯示出來 ?>
						<?php $this->data['k'] = $k?>
						<?php $this->data['v'] = $v?>
						<?php $this->data['listcontent'] = $listcontent_foot?>
						<?php echo $this->renderPartial('default/index_fields_bottom', $this->data)?>
					</tr>
					<?php endforeach?>
				<?php $this->data['listfield'] = $this->data['listfield_tmp']?>
				</tfoot>
			<?php endif?>

		</table>

			<?php if((isset($def['enable_delete']) and $def['enable_delete'] == true) || $this->data['router_class']=='writeplan'):?>
			</form>
			<?php endif?>

			<?php if(0 and isset($this->data['listfield_end_html']) and $this->data['listfield_end_html'] != ''):?>
				<?php echo $this->data['listfield_end_html']?>
			<?php endif?>

		<?php else: ?>
			<?php echo $this->renderPartial('includes/no_data', $this->data)?>
		<?php endif?>

		<?php if(isset($this->data['listfield_end_html']) and $this->data['listfield_end_html'] != ''):?>
			<?php echo $this->data['listfield_end_html'] // 2019-12-26?>
		<?php endif?>

		<?php if(isset($this->data['listfield_hide_bottom_pagination']) and $this->data['listfield_hide_bottom_pagination'] == true):?>
			<?php // do nothing ?>
		<?php else: ?>
			<?php echo $this->renderPartial('includes/pagination4c', $this->data)?>
		<?php endif?>
	</div>


	</div> <!-- portlet box -->

	<?php if(!empty($def['updatefield']) and isset($def['enable_index_create']) and $def['enable_index_create'] == true):?>
		<?php $this->data['def']['updatefield']['method'] = 'create'?>
		<?php $this->data['def']['updatefield']['form']['attr']['action'] = $this->data['class_url'].'/create'?>

		<?php $def['updatefield']['method'] = 'create'?>
		<?php $def['updatefield']['form']['attr']['action'] = $this->data['class_url'].'/create'?>
			<div class="portlet box green">

			<div class="portlet-title">
				<div class="caption"><i class="icon-search"></i>新增資料</div>
				<div class="tools">
					<a class="collapse" href="javascript:;"></a>
	<?php if(0):?>
					<a class="config" data-toggle="modal" href="#portlet-config"></a>
					<a class="reload" href="javascript:;"></a>
	<?php endif?>
					<a class="remove" href="javascript:;"></a>
				</div>
			</div>

			<div class="portlet-body">

				<?php if($def['updatefield']['form']['enable'] == true):?>
					<?php $formattr = ''?>
					<?php if(!empty($def['updatefield']['form']['attr'])):?>
						<?php foreach($def['updatefield']['form']['attr'] as $k => $v):?>
							<?php $formattr = $formattr.' '.$k.'="'.$v.'"'?>
						<?php endforeach?>
					<?php endif?>
					<?php // enctype="multipart/form-data" ?>
					<form <?php echo $formattr?>>
				<?php endif?>

				<?php echo $this->renderPartial('default/update_fields', $this->data)?>

				<div class="buttons indexgo03" style2="clear:both;">
					<?php if(!isset($this->data['router_method_view']) or $this->data['router_method_view'] != '1'):?>
						<button class="btn blue" type="submit"><i class="icon-ok"></i><?php echo G::_('Create', 'en')?></button>
						<button class="btn red hide" type="submit"><?php echo G::_('Reset', 'en')?></button>
					<?php endif?>
		<?php if(isset($prev_url) and $prev_url != ''):?>
					<button onclick="document.location.href='<?php echo $prev_url?>';" class="btn green" type="button"><?php echo G::_('Previous Page', 'en')?></button>
		<?php endif?>
				</div>

				<input type="hidden" name="update_base64_url" value="<?php if(isset($update_base64_url)){ echo $update_base64_url; }?>" />
				<input type="hidden" name="prev_url" value="<?php if(isset($update_base64_url)){ echo $prev_url; }?>" />

				<?php if($def['updatefield']['form']['enable'] == true):?>
				</form>
				<?php endif?>


			</div>


			</div> <!-- portlet box -->

	<?php endif?><?php //empty($def.updatefield)?>

	</div> <!-- span12 -->

	<?php // 2018-08-31 打算把無限層的分類列表頁，和一般的列表頁結合?>
	<?php if(isset($render_tree)):?>
		<div class="col-md-12">
			<div class="portlet box light-grey" style="border-style:none">
				<div class="portlet-body">
					<?php echo $render_tree?>
				</div>
			</div> <!-- portlet box -->
		</div> <!-- col-md-12(10) -->
	<?php endif?>

	<?php echo $this->renderPartial('includes/tcofastmenu', $this->data)?>

</div> <!-- row -->

<?php //*麵包或是功能標題*}} ?> 
