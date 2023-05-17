<?php

// 設定預設的排版欄位名稱
$sort_id_tmp = '';
if(isset($def['sortable']['sort_id_name'])){
	$sort_id_tmp = $def['sortable']['sort_id_name'];
}
if($sort_id_tmp == ''){
	$sort_id_tmp = 'sort_id';
}

if(!empty($def['updatefield']['head'])){
	foreach($def['updatefield']['head'] as $v){
		Yii::app()->clientScript->registerCoreScript($v);
	}// foreach
} //if

if(isset($updatecontent['pid']) and $updatecontent['pid'] == '0' and $def['sortable']['enable'] == true and (($sort_field_nobase64 == 'sort_id' and $sort_direction == 'asc') or ($sort_field == '' and $sort_direction == '' and $def['default_sort_field'] == 'sort_id')) ){
	Yii::app()->clientScript->registerCoreScript('jquery.ui');
}

$update_default_1 = $this->renderPartial('//includes/default_validate', $this->data)."\n";
if(isset($update_success) and $update_success == '1'){
	$update_default_1 .= "alert(l.get('Update success'));\n";
}

$update_default_1 .= $this->renderPartial('//default/update_javascript', $this->data)."\n";
// 自定的javascript區塊，存放在實體檔案
if(isset($def['updatefield']['smarty_javascript']) and $def['updatefield']['smarty_javascript'] != ''){
	$update_default_1 .= $this->renderPartial('//'.$def['updatefield']['smarty_javascript'], $this->data)."\n";
}

// 自定的javascript區塊，存放資料庫
if(isset($def['updatefield']['smarty_javascript_text']) and $def['updatefield']['smarty_javascript_text'] != ''){
	$update_default_1 .= $def['updatefield']['smarty_javascript_text']."\n";
}

$update_default_1 .= <<<XXX1
XXX1;

Yii::app()->clientScript->registerScript('update_default_1', $update_default_1, CClientScript::POS_END);

Yii::app()->clientScript->registerCssFile($this->assetsUrl.$this->data['template_path'].'/css/demo_table_jui.css');
if(isset($updatecontent['pid']) and $updatecontent['pid'] == '0' and isset($def['sortable']['enable']) and $def['sortable']['enable'] == true and (($sort_field_nobase64 == $sort_id_tmp and $sort_direction == 'asc') or ($sort_field == '' and $sort_direction == '' and $def['default_sort_field'] == $sort_id_tmp)) ){ 
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

<?php //*麵包或是功能標題*}} ?>
<div class="main_content">

	<?php $this->data['action'] = $def['updatefield']['method']?>
	<?php $this->data['other_content_title'] = $updatecontent['name_parent']?>
	<?php echo $this->renderPartial('//includes/function_title', $this->data)?>

		<table border="0" cellspacing="0" cellpadding="0" width="98%">
			<tbody>
				<tr>
					<td align="left" valign="top" width="200" style="background-color:#bbb;border:1px #000 solid;padding-left:5px">
						<h2><?php echo $main_content_title?></h2>
						<?php echo $render_tree?>
					</td>
					<td width="20">&nbsp;</td>
					<td align="left" valign="top">

						<?php if(!empty($def['updatefield'])):?>

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

							<?php echo $this->renderPartial('//default/update_fields', $this->data)?>

							<div class="buttons indexgo03" style2="clear:both;">
								<button class="button btn_send" type="submit"><?php G::te($this->data['theme_lang'], 'Submit', null, '送出')?></button>
								<button class="button white btn_send" type="submit"><?php G::te($this->data['theme_lang'], 'Reset', null, '清除')?></button>
								<?php if(isset($updatecontent['pid']) and $updatecontent['pid'] == '0'):?>
								<button onclick="document.location.href='<?php echo $class_url?>';" class="button white btn_send" type="button"><?php G::te($this->data['theme_lang'], 'Previous', null, '上一頁')?></button>
								<?php else:?>
								<button onclick="document.location.href='<?php echo $prev_url?>';" class="button white btn_send" type="button"><?php G::te($this->data['theme_lang'], 'Previous', null, '上一頁')?></button>
								<?php endif?>
							</div>

							<?php if($def['updatefield']['method'] == 'update'):?>
								<?php if($updatecontent['pid'] != 0):?>
								<?php else:?>
									<input type="hidden" name="pid" value="<?php echo $updatecontent['pid']?>" />
								<?php endif?>
							<?php else:?>
							<input type="hidden" name="pid" value="<?php if(!isset($parent_data['id']) or $parent_data['id'] <= 0):?>0<?php else:?><?php echo $parent_data['id']?><?php endif?>" />
							<?php endif?>

							<?php if($def['updatefield']['method'] == 'update'):?>
							<input type="hidden" name="hidden_id" value="<?php echo $updatecontent['id']?>" />
							<?php endif?>
							<input type="hidden" name="update_base64_url" value="<?php echo $update_base64_url?>" />

							<input type="hidden" name="prev_url" value="<?php echo $prev_url?>" />

							<?php if($def['updatefield']['form']['enable'] == true):?>
							</form>
							<?php endif?>

						<?php endif?><?php //empty($def.updatefield)?>


						<?php if(isset($updatecontent['pid']) and $updatecontent['pid'] == 0):?>
							<?php $this->data['other_content_title'] = $updatecontent['name']?>
							<?php // 取消第2個title //$this->data['disable_title'] = true?>
							<?php echo $this->renderPartial('//includes/function_title', $this->data)?>

							<?php if(0):?>
								<!--建立按鈕-->
								<?php if(!isset($def['disable_create']) or $def['disable_create'] != true):?>
									<?php $this->BeginWidget('system.widgets.Gw_acl', array('method'=>'create'))?>
									<div class="shortcuts-edit">
										<a class="btn btn-large" href="<?php echo $class_url?>/create&param=<?php echo $parameter['value'].$updatecontent['id'].'-'.$parameter['prev'].$current_base64_url?>"><?php G::te($this->data['theme_lang'], 'Create', null, '新增')?></a>
									</div>
									<?php $this->EndWidget('system.widgets.Gw_acl')?>
								<?php endif?>
							<?php endif?>

							<div class="formtop clearfix">
								<?php if(!isset($def['disable_create']) or $def['disable_create'] != true):?>
									<?php $this->BeginWidget('system.widgets.Gw_acl', array('method'=>'create'))?>
										<a class="btn btn-large" href="<?php echo $class_url?>/create&param=<?php echo $parameter['value'].$updatecontent['id'].'-'.$parameter['prev'].$current_base64_url?>"><div class="t_add fle"><?php G::te($this->data['theme_lang'], 'Create', null, '新增')?></div></a>
									<?php $this->EndWidget('system.widgets.Gw_acl')?>
								<?php endif?>
							</div>

							<form>
								<?php if(!empty($listcontent)): ?>
								<table id="tablelist" cellspacing="1" cellpadding="7" class="table1 sortable">
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
											<?php if($updatecontent['pid'] == 0 and isset($def['sortable']['enable']) and $def['sortable']['enable'] == true and (($sort_field_nobase64 == $sort_id_tmp and $sort_direction == 'asc') or ($sort_field == '' and $sort_direction == '' and $def['default_sort_field'] == $sort_id_tmp))):?>
												<a class="move" href="#" title="移動"><img class="move" src="<?php echo $this->assetsUrl.$this->data['template_path']?>/images/icons/arrow-move.png" alt="Move" title="Move" /></a>
											<?php endif?>

											<?php $this->BeginWidget('system.widgets.Gw_acl', array('method'=>'update'))?>
											<a href="<?php echo $class_url?>/update&param=<?php echo $parameter['value'].$v['id'].'-'.$parameter['prev'].$current_base64_url?>" title="Edit"><img src="<?php echo $this->assetsUrl.$this->data['template_path']?>/images/icons/edit.png" alt="Edit" /></a>
											<?php $this->EndWidget('system.widgets.Gw_acl')?>

											<?php $this->BeginWidget('system.widgets.Gw_acl', array('method'=>'delete'))?>
											<a href="javascript:;" title="Delete" class="del_button" itemid="<?php echo $v['id']?>"><img src="<?php echo $this->assetsUrl.$this->data['template_path']?>/images/icons/cross.png" alt="Delete" /></a>
											<?php $this->EndWidget('system.widgets.Gw_acl')?>
										</td>
									</tr>
									<?php endforeach?>
									</tbody>
								</table>
								<?php else: ?>
									<?php echo $this->renderPartial('//includes/no_data', $this->data)?>
								<?php endif?>
							</form>

							<?php //Adminique後台樣版的分頁條 ?>
							<?php echo $this->renderPartial('//includes/pagination4b', $this->data)?>

						<?php endif?>

					</td>
				</tr>
			</tbody>
		</table>

</div>

<?php if(0):?>
<style type="text/css">
img.imgalign {position: relative;top: 4px;margin-top: -4px;}
</style>

<aside id="sidebar" class="grid_3 pull_9">
	<div class="box menu">
		<h2><?php echo $main_content_title?></h2>
		<section>
			<?php echo $render_tree?>
		</section>
	</div>
</aside>
<?php endif?>
