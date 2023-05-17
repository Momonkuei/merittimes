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
	echo $this->renderPartial('//includes/jquery_sortable_init', $this->data);
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

?>

<?php echo $this->renderPartial('//includes/search', $this->data)?>

<div class="row">

	<?php if(count($this->data['tcofastmenus']) > 0):?>
	<div class="col-md-10">
	<?php else:?>
	<div class="col-md-12">
	<?php endif?>

	<div class="portlet box light-grey" style="border-style:none">
	<div class="portlet-body">
	<form>
		<?php if(!empty($listcontent)): ?>
		<table id="tablelist" class="table1 sortable table table-striped table-bordered table-hover dataTable" aria-describedby="sample_1_info">
			<thead>
			<tr>
				<?php // 顯示欄位名稱，包含排序 ?>
				<?php echo $this->renderPartial('//default/index_fields_top', $this->data)?>
		
				<th width="10%"><?php G::te($this->data['theme_lang'], 'Form Action', null, '動　作')?></th>
			</tr>
			</thead>
			<tbody oncontextmenu="return false;">
			<?php foreach($listcontent as $k =>$v): ?>
			<tr class="<?php echo ($k%2==1)?'bgcolor1':'bgcolor2' ?>" id="sortable_id_<?php echo $v['id']?>">
				<?php // 這裡欄位資料的顯示，會依照欄位的定義，自動顯示出來 ?>
				<?php $this->data['k'] = $k?>
				<?php $this->data['v'] = $v?>
				<?php $this->data['listcontent'] = $listcontent?>
				<?php echo $this->renderPartial('//default/index_fields_bottom', $this->data)?>

				<td>
					<?php //當即時排序有啟動的時候，或者是預設就有排序的狀況，或者是沒有排序的狀況，才會啟用 ?>
					<?php if(isset($def['sortable']['enable']) and $def['sortable']['enable'] == true and (($sort_field_nobase64 == $sort_id_tmp and $sort_direction == 'asc') or ($sort_field == '' and $sort_direction == '' and $def['default_sort_field'] == $sort_id_tmp))):?>
						<a class="move" href="#" title="移動"><img class="move" src="<?php echo $this->assetsUrl.$this->data['template_path']?>/images/icons/arrow-move.png" alt="Move" title="Move" /></a>
					<?php endif?>

					<?php if(!isset($def['disable_edit']) or $def['disable_edit'] != true):?>
						<?php $this->BeginWidget('system.widgets.Gw_acl', array('method'=>'update'))?>
						<a href="<?php echo $class_url?>/update&param=<?php echo $parameter['value'].$v['id'].'-'.$parameter['prev'].$current_base64_url?>" title="Edit"><img src="<?php echo $this->assetsUrl.$this->data['template_path']?>/images/icons/edit.png" alt="Edit" /></a>
						<?php $this->EndWidget('system.widgets.Gw_acl')?>
					<?php endif?>

					<?php if(!isset($def['disable_delete']) or $def['disable_delete'] != true):?>
						<?php $this->BeginWidget('system.widgets.Gw_acl', array('method'=>'delete'))?>
						<a href="javascript:;" title="Delete" class="del_button" itemid="<?php echo $v['id']?>"><img src="<?php echo $this->assetsUrl.$this->data['template_path']?>/images/icons/cross.png" alt="Delete" /></a>
						<?php $this->EndWidget('system.widgets.Gw_acl')?>
					<?php endif?>
				</td>
			</tr>
			<?php endforeach?>
			</tbody>
		</table>
		<?php else: ?>
			<?php echo $this->renderPartial('//includes/no_data', $this->data)?>
		<?php endif?>
	</form>

		<?php echo $this->renderPartial('//includes/pagination4c', $this->data)?>

	</div>


	</div> <!-- portlet box -->

	</div> <!-- col-md-12(10) -->

	<div class="col-md-12">
		<div class="portlet box light-grey" style="border-style:none">
			<div class="portlet-body">
				<?php echo $render_tree?>
			</div>
		</div> <!-- portlet box -->
	</div> <!-- col-md-12(10) -->

	<?php echo $this->renderPartial('//includes/tcofastmenu', $this->data)?>

</div> <!-- row -->
