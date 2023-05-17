<?php

// 設定預設的排版欄位名稱
$sort_id_tmp = '';
if(isset($def['sortable']['sort_id_name'])){
	$sort_id_tmp = $def['sortable']['sort_id_name'];
}
if($sort_id_tmp == ''){
	$sort_id_tmp = 'sort_id';
}

//Yii::app()->clientScript->registerCssFile($this->assetsUrl.$this->data['template_path'].'/css/demo_table_jui.css');
if(isset($def['sortable']['enable']) and $def['sortable']['enable'] == true and (($sort_field_nobase64 == $sort_id_tmp and $sort_direction == 'asc') or ($sort_field == '' and $sort_direction == '' and $def['default_sort_field'] == $sort_id_tmp)) ){ 
	Yii::app()->clientScript->registerCoreScript('jquery.ui');
	// 當即時排序的開關啟用，以及目前狀況是使用sort_id正向排序，才會啟用即時排序
	$this->data['sort_id_tmp'] = $sort_id_tmp;
	echo $this->renderPartial('includes/jquery_sortable_init', $this->data);
}

$script_default_a = <<<XXX0
	$('.del_button').click(function(){
		var id = $(this).attr('itemid');
		if(confirm(l.get('Are you sure you want to delete?'))){
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

		$.ajax({
			type: "POST",
			data: {
				'value': value,
				'id': id,
				'field': field
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
	/*
	 * 底下是新增在使用的
	 */
	if(!empty($def['updatefield']['head'])){
		foreach($def['updatefield']['head'] as $v){
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
}
?>


<?php echo $this->renderPartial('includes/search', $this->data)?>

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
			<div class="caption"><i class="icon-search"></i>進階搜尋</div>
<?php else:?>
			<div class="caption"><i class="icon-search"></i><?php echo $def['searchfield']['advanced_title']?></div>
<?php endif?>
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
					<button class="btn blue" type="submit"><i class="icon-ok"></i><?php G::te($this->data['theme_lang'], 'Search', null, '送出搜尋')?></button>
					<button class="btn red" type="submit" onclick="javascript:location.href='<?php echo $this->createUrl($this->data['router_class'].'/cancel_search')?>';return false;"><i class="icon-remove"></i><?php G::te($this->data['theme_lang'], 'Cancel Search', null, '取消搜尋')?></button>
				<?php endif?>
	<?php if(isset($prev_url) and $prev_url != ''):?>
				<button onclick="document.location.href='<?php echo $prev_url?>';" class="btn green" type="button"><?php G::te($this->data['theme_lang'], 'Previous', null, '上一頁')?></button>
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

		<?php if(!empty($listcontent)): ?>
			<?php if(isset($this->data['listfield_start_html']) and $this->data['listfield_start_html'] != ''):?>
				<?php echo $this->data['listfield_start_html']?>
			<?php endif?>

<?php ob_start()?>
		<table id="tablelist" class="table1 sortable table table-striped table-bordered table-hover dataTable" aria-describedby="sample_1_info">
			<?php if(isset($this->data['listfield_caption_html']) and $this->data['listfield_caption_html'] != ''):?>
				<?php echo $this->data['listfield_caption_html']?>
			<?php endif?>
			<thead>
			<tr>
				<?php // 顯示欄位名稱，包含排序 ?>
				<?php echo $this->renderPartial('default/index_fields_top', $this->data)?>
	
				<?php if(!isset($def['disable_action']) or $def['disable_action'] != true):?>
				<th width="10%"><?php G::te($this->data['theme_lang'], 'Form Action', null, '動　作')?></th>
				<?php endif?>
			</tr>
			</thead>
			<tbody oncontextmenu="return false;">
			<?php foreach($listcontent as $k =>$v): ?>
			<tr class="<?php echo ($k%2==1)?'bgcolor1':'bgcolor2' ?>" id="sortable_id_<?php echo $v['id']?>">
				<?php // 這裡欄位資料的顯示，會依照欄位的定義，自動顯示出來 ?>
				<?php $this->data['k'] = $k?>
				<?php $this->data['v'] = $v?>
				<?php $this->data['listcontent'] = $listcontent?>
				<?php echo $this->renderPartial('default/index_fields_bottom', $this->data)?>

				<?php if(!isset($def['disable_action']) or $def['disable_action'] != true):?>
					<td>
						<?php //當即時排序有啟動的時候，或者是預設就有排序的狀況，或者是沒有排序的狀況，才會啟用 ?>
						<?php if(isset($def['sortable']['enable']) and $def['sortable']['enable'] == true and (($sort_field_nobase64 == $sort_id_tmp and $sort_direction == 'asc') or ($sort_field == '' and $sort_direction == '' and $def['default_sort_field'] == $sort_id_tmp))):?>
							<a class="btn default btn-xs blue move" href="#" title="移動"><i class="icon-move"></i>Move</a>
						<?php endif?>

						<?php if(!isset($def['disable_edit']) or $def['disable_edit'] != true):?>
							<?php $this->BeginWidget('system.widgets.Gw_acl', array('method'=>'update'))?>
							<a class="btn default btn-xs purple" href="<?php echo $class_url?>/update&param=<?php echo $parameter['value'].$v['id'].'-'.$parameter['prev'].$current_base64_url?>" title="Edit"><i class="icon-edit"></i>Edit</a>
							<?php $this->EndWidget('system.widgets.Gw_acl')?>
						<?php endif?>

						<?php if(!isset($def['disable_delete']) or $def['disable_delete'] != true):?>
							<?php $this->BeginWidget('system.widgets.Gw_acl', array('method'=>'delete'))?>
							<a class="btn default btn-xs black del_button" href="javascript:;" title="Delete" itemid="<?php echo $v['id']?>"><i class="icon-trash"></i>Delete</a>
							<?php $this->EndWidget('system.widgets.Gw_acl')?>
						<?php endif?>
					</td>
				<?php endif?>
			</tr>
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
		<?php if(isset($this->data['listfield_end_html']) and $this->data['listfield_end_html'] != ''):?>
			<?php echo $this->data['listfield_end_html']?>
		<?php endif?>

<?php
$x_content = ob_get_contents();
ob_end_clean();
?>

		<table border="0" cellspacing="0" cellpadding="0" width="98%">
			<tbody>
				<tr>
					<td align="left" valign="top" width="200" style="background-color:#fdfefe;border:0px #000 solid;padding-left:5px">
						<?php echo $this->data['render_tree']?>
					</td>
					<td width="20">&nbsp;</td>
					<td align="left" valign="top"><?php echo $x_content?></td>
				</tr>
			</tbody>
		</table>

		<?php else: ?>
			<?php echo $this->renderPartial('includes/no_data', $this->data)?>
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
						<button class="btn blue" type="submit"><i class="icon-ok"></i><?php G::te($this->data['theme_lang'], 'Add', null, '新增')?></button>
						<button class="btn red hide" type="submit"><?php G::te($this->data['theme_lang'], 'Reset', null, '清除')?></button>
					<?php endif?>
		<?php if(isset($prev_url) and $prev_url != ''):?>
					<button onclick="document.location.href='<?php echo $prev_url?>';" class="btn green" type="button"><?php G::te($this->data['theme_lang'], 'Previous', null, '上一頁')?></button>
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

	<?php echo $this->renderPartial('includes/tcofastmenu', $this->data)?>

</div> <!-- row -->

<?php //*麵包或是功能標題*}} ?> 
