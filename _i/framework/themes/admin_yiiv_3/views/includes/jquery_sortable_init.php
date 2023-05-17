<?php 

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

if(!isset($def['sortable']['condition'])){
	$def['sortable']['condition'] = '';
}

$jquery_sortable_1 = <<<XXXjquerysortable1
var fixHelper = function(e, ui) {
	ui.children().each(function() {
		$(this).width($(this).width());
	});
	return ui;
};
$('table.sortable tbody').sortable({
	//handle: 'img.move',
	//handle: 'td:first',
	//cancel: "table.sortable tbody #index_dropdown",
	//
	handle: 'a.move',
	helper: fixHelper,
	placeholder: 'ui-state-highlight',
	forcePlaceholderSize: true,

	/*
	* ui.helper - the current helper element (most often a clone of the item)
	* ui.position - current position of the helper (ui.position.top, or left)
	* ui.offset - current absolute position of the helper (ui.position.top, or left)
	* ui.item - the current dragged element
	* ui.placeholder - the placeholder (if you defined one)
	* ui.sender - the sortable where the item comes from (only exists if you move from one connected list to another)
	*/
	update : function(event, ui){
		// 拖起來的物件，它的完整ID，我指的是item1_N
		var dragged_ids = ui.item.attr('id');

		// 拖起來的物件，實際它的編號
		// product_id_\{id\}
		var old_id = dragged_ids.split('_')[2];

		var new_tablelist_array = $('table.sortable tbody').sortable('toArray');

		// 取得新位置的項目編號(從零開始)
		var dragged_position = $.inArray(dragged_ids, new_tablelist_array);

		// 取得新位置"舊"的項目編號(從零開始)
		new_id_tmp = old_tablelist_array[dragged_position]
		new_id = new_id_tmp.split('_')[2];

		$.post('{$def['sortable']['url']}', { nnn: '{$def['table']}', id: old_id, new_id: new_id, mmm: '{$def['sortable']['condition']}', ppp: '{$sort_id_tmp}' },
			function(data){
				if(data != '1'){
					$('table.sortable tbody').sortable('cancel');
					alert('動作失敗，回復上一個動作');
				} else {
					// 將更新後的動作，在次將位置群存到變數裡面，先寫著，或是未來不重新reload的時候可以用得到
					old_tablelist_array = $('table.sortable tbody').sortable('toArray');
					location.reload();
				}
			}, "html"
		);
	}
});

// 這個啟用後，會讓下拉無法使用
//}).disableSelection();

// 拖拉排序前，原有的位置群，拖拉的程序中，會使用這個陣列
var old_tablelist_array = $('table.sortable tbody').sortable('toArray');
XXXjquerysortable1;
Yii::app()->clientScript->registerScript('jquery_sortable_1', $jquery_sortable_1, CClientScript::POS_READY);
?>
