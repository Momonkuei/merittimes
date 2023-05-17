<?php

// 為了要支援sort_id改欄位名稱
$sort_field = 'sort_id';
if(isset($this->def['func_field']['sort_id']) and $this->def['func_field']['sort_id'] != ''){
	$sort_field = $this->def['func_field']['sort_id'];
}

if($action == ''){
	$action = 'update';
}

if($action == 'update'){
	$current_position = $updatecontent[$sort_field];
} elseif($action == 'create'){
	$current_position = '1';
}

?>
<label><input type="radio" value="1" id="sort_id_point" name="sort_id_point" />第一筆</label>
<label><input type="radio" value="2" id="sort_id_point" name="sort_id_point" <?php if($action == 'create'):?>checked="checked"<?php endif?> />最末筆</label>
<label><input type="radio" value="3" id="sort_id_point" name="sort_id_point" />自定</label>
<input type="text" id="sort_id_select" name="sort_id_select" value="<?php echo $current_position?>" size="6" onclick="javascript:$('input[id=sort_id_point][@value=\'3\']').attr('checked', true);" />(排序由小至大1 ~<span id="sort_id_select_max_value"><?php if(isset($class_sort_count) and $class_sort_count != ''):?><?php echo $class_sort_count?><?php else:?>1<?php endif?></span>)
<!--
<label><input type="radio" value="3" id="sort_id_point" name="sort_id_point" />##Custom position##</label>
<input type="text" id="sort_id_select" name="sort_id_select" value="1" size="5" />(排序由小至大 1 - 20)
<select id="sort_id_select" name="sort_id_select">
	<option value="">##Please select item##</option>
	{{if $sort_count != '0'}}
	{{section name="x" loop=$sort_count}}
		{{if $updatecontent.sort_id == $smarty.section.x.rownum}}
		{{continue}}
		{{/if}}
		<option value="{{$smarty.section.x.rownum}}">{{$smarty.section.x.rownum}} ({{mv len="40"}}{{$sort_datas[$smarty.section.x.rownum]}}{{/mv}})</option>
	{{/section}}
	{{/if}}
</select>
-->
