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

$update_default_1 = $this->renderPartial('includes/default_validate', $this->data)."\n";
if(isset($update_success) and $update_success == '1'){
	$update_default_1 .= "alert(l.get('Update success'));\n";
}

$update_default_1 .= $this->renderPartial('default/update_javascript', $this->data)."\n";
// 自定的javascript區塊，存放在實體檔案
if(isset($def['updatefield']['smarty_javascript']) and $def['updatefield']['smarty_javascript'] != ''){
	$update_default_1 .= $this->renderPartial($def['updatefield']['smarty_javascript'], $this->data)."\n";
}

// 自定的javascript區塊，存放資料庫
if(isset($def['updatefield']['smarty_javascript_text']) and $def['updatefield']['smarty_javascript_text'] != ''){
	$update_default_1 .= $def['updatefield']['smarty_javascript_text']."\n";
}

$update_default_1 .= <<<XXX1
XXX1;

Yii::app()->clientScript->registerScript('update_default_1', $update_default_1, CClientScript::POS_END);

//Yii::app()->clientScript->registerCssFile($this->assetsUrl.$this->data['template_path'].'/css/demo_table_jui.css');
if(isset($updatecontent['pid']) and isset($def['sortable']['enable']) and $def['sortable']['enable'] == true and ((isset($sort_field_nobase64) && $sort_field_nobase64 == $sort_id_tmp and $sort_direction == 'asc') or (isset($sort_field) && $sort_field == '' and $sort_direction == '' and $def['default_sort_field'] == $sort_id_tmp)) ){ // $updatecontent['pid'] == '0' and  //2021-12-20 Gary發現使用獨立的通用結構資料表不會產出sort_field及sort_field_nobase64，加上判斷變數存活 by lota
	Yii::app()->clientScript->registerCoreScript('jquery.ui');
	// 當即時排序的開關啟用，以及目前狀況是使用sort_id正向排序，才會啟用即時排序
	$this->data['sort_id_tmp'] = $sort_id_tmp;
	echo $this->renderPartial('//includes/jquery_sortable_init', $this->data);
}

if(isset($parameter)){ // 2018-09-05 如果沒加這行，單頁會報錯
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
}

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

<?php $this->data['action'] = $def['updatefield']['method']?>
<?php echo $this->renderPartial('includes/function_title', $this->data)?>

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

<?php //*麵包或是功能標題*}} ?>
<div class="row">

	<?php if(isset($render_tree_current)):// 2018-04-12 本顆樹?>
		<div class="col-md-12">
			<div class="portlet box light-grey" style="border-style:none">
				<div class="portlet-body">
					<?php echo $render_tree_current?>
					<div>&nbsp;</div>
				</div>
			</div> <!-- portlet box -->
		</div> <!-- col-md-12(10) -->
	<?php endif?>

	<?php if(count($this->data['tcofastmenus']) > 0):?>
	<div class="col-md-10">
	<?php else:?>
	<div class="col-md-12">
	<?php endif?>

	<div class="portlet box light-grey" style="border-style:none">
	<div class="portlet-body">

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
			
		<?php echo $this->renderPartial('default/update_fields', $this->data)?>

		<div class="buttons indexgo03" style2="clear:both;">
			<?php if(!isset($this->data['router_method_view']) or $this->data['router_method_view'] != '1'):?>
				<button class="btn blue" type="submit"><i class="icon-ok"></i><?php G::te($this->data['theme_lang'], 'Submit', null, '送出')?></button>
				<button class="btn red" type="reset"><?php G::te($this->data['theme_lang'], 'Reset', null, '清除')?></button>
<?php if(isset($prev_url) and $prev_url != ''):?>
			<button onclick="document.location.href='<?php echo $prev_url?>';" class="btn green" type="button"><?php G::te($this->data['theme_lang'], 'Previous', null, '上一頁')?></button>
<?php endif?>
			<?php endif?>
			<?php if(isset($this->data['submit_buttons'])):?>
				<?php foreach($this->data['submit_buttons'] as $k => $v):?>
					<?php if(!isset($v['html'])):?><?php break?><?php endif?>
					<?php $v1 = $v?>
					<?php unset($v1['html'])?>
					<button <?php foreach($v1 as $kk => $vv):?><?php echo ' '.$kk.'="'.$vv.'" ' ?><?php endforeach?>><?php echo $v['html']?></button>
				<?php endforeach?>
			<?php endif?>

		</div>
						
		<?php //if(isset($updatecontent['pid'])):?>
			<?php if(isset($updatecontent['pid']) and $def['updatefield']['method'] == 'update'):?>
				<?php if($updatecontent['pid'] != 0):?>
				<?php else:?>
					<input type="hidden" name="pid" value="<?php echo $updatecontent['pid']?>" />
				<?php endif?>
			<?php else:?>
				<input type="hidden" name="pid" value="<?php if(!isset($parent_data['id']) or $parent_data['id'] <= 0):?>0<?php else:?><?php echo $parent_data['id']?><?php endif?>" />
			<?php endif?>
		<?php //endif?>
					
		<?php if($def['updatefield']['method'] == 'update'):?>
		<input type="hidden" name="hidden_id" value="<?php G::ae($updatecontent, 'updatecontent.'.$def['func_field']['id'])?>" />
		<?php elseif($def['updatefield']['method'] == 'create'):?>
		<input type="hidden" name="hidden_id" value="<?php G::ae($updatecontent, 'updatecontent.random_id')?>" />
		<?php endif?>
		<input type="hidden" name="update_base64_url" value="<?php if(isset($update_base64_url)){ echo $update_base64_url; }?>" />
		<input type="hidden" name="prev_url" value="<?php if(isset($update_base64_url)){ echo $prev_url; }?>" />

		<?php if($def['updatefield']['form']['enable'] == true):?>
		</form>
		<?php endif?>

	<?php endif?><?php //empty($def.updatefield)?>
			
	<?php if(isset($updatecontent['pid']) and ( (isset($updatecontent['allow_child']) and $updatecontent['allow_child'] === true) or !isset($updatecontent['allow_child']) ) ): //and $updatecontent['pid'] == 0):?>
		<?php //$this->data['other_content_title'] = $updatecontent['name']?>
		<?php // 取消第2個title //$this->data['disable_title'] = true?>
		<?php //echo $this->renderPartial('//includes/function_title', $this->data)?>

		<div class="row">
			<div class="col-md-12"><br />
			</div>
		</div>

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
					<button id="sample_editable_1_new" class="btn green" onclick="javascript:location.href='<?php echo $class_url?>/create&param=<?php echo $parameter['value'].$updatecontent['id'].'-'.$parameter['prev'].$current_base64_url?>';">
					<?php G::te($this->data['theme_lang'], 'Create', null, '新增')?> <i class="icon-plus"></i>
					</button>
				<?php $this->EndWidget('system.widgets.Gw_acl')?>
			<?php endif?>
		</div>
	<?php endif?>

	<?php if(isset($parameter) and isset($updatecontent['pid']) and ( (isset($updatecontent['allow_child']) and $updatecontent['allow_child'] === true) or !isset($updatecontent['allow_child']) )):// 2018-09-05 加上parameter，是為了單頁不要出現這一塊?>
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
						<?php if(isset($def['sortable']['enable']) and $def['sortable']['enable'] == true and (($sort_field_nobase64 == $sort_id_tmp and $sort_direction == 'asc') or ($sort_field == '' and $sort_direction == '' and $def['default_sort_field'] == $sort_id_tmp)))://$updatecontent['pid'] == 0 and ?>
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

		<?php if(isset($updatecontent['pid']) && !isset($updatecontent['member_id'])): //and $updatecontent['pid'] == 0): //2021-12-20 Gary發現使用獨立的通用結構資料表會報錯，多加member_id欄位做判斷 by lota?>
			<?php echo $this->renderPartial('//includes/pagination4c', $this->data)?>
		<?php else:?>
			<?php echo '<script>console.log("No include pagination4c Because of member_id");</script>';?>
		<?php endif?>
	<?php endif?>

	</div> <!-- body -->

	</div> <!-- portlet box -->

	</div> <!-- col-md-N -->

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
