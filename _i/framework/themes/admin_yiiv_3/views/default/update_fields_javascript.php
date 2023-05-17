<?php 
foreach($v['field'] as $kk => $vv){
	$tmp = '';
	$tmp2 = '';

	// debug
	if(0 and !isset($vv['type'])){
		var_dump($v);
		die;
		continue;
	}

	if(!isset($vv['type'])) continue;

	if($vv['type'] == 'fileuploader_multi5'){
	} elseif($vv['type'] == 'kcfinder_swfupload_abs'){
		$tmp = <<<XXX
var currentIframe_tmp = document.getElementById('{$kk}');
if (currentIframe_tmp.attachEvent){
	currentIframe_tmp.attachEvent("onload", kcfinder_swfupload_func_{$kk});
} else {
	currentIframe_tmp.onload = kcfinder_swfupload_func_{$kk};
}

function kcfinder_swfupload_func_{$kk}(){
	var currentIframe = $('#{$kk}');
	currentIframe.contents().find('#upload').remove();
	currentIframe.contents().find('#toolbar').children('div').find('a:first').hide();
	currentIframe.contents().find('#left').remove();
	currentIframe.contents().find('#right').css('width', '99%');
	currentIframe.contents().find('#files').css('width', '99%');
}
XXX;
	//} elseif($vv['type'] == 'ckeditor_js'){
		//Yii::app()->clientScript->registerCoreScript('ckeditor');
		//$tmp = <<<XXX
//var editor = CKEDITOR.replace("{$kk}");
//CKFinder.setupCKEditor(editor, '/ckfinder/'); 
//XXX;
	} elseif($vv['type'] == 'multiselect2' or $vv['type'] == 'select4'){
		$tmp = <<<XXX
// IE not working
$('#{$kk} option').hover(
	function(){
		$('#{$kk}_display_html').html($(this).attr('html'));
	},
	function(){
		//$(this).css('background-color', 'transparent');
		//$('#{$kk}_display_html').html('');
	}
);
{{* 讓IE和Chrome能夠在點的時候出現預覽 *}}
$('#{$kk}').change(function(){
	var val = $(this).val();
	$('#{$kk}_display_html').html($('#{$kk}_display_html_'+val).html());
});
XXX;
	} elseif($vv['type'] == 'multi-select_killme'){
		$tmp = <<<XXX
// 這是一般般的多選，有左右兩邊
//$('#{$kk}').multiSelect();

// 這是多了搜尋的多選，左右各有一個搜尋欄位
$('#{$kk}').multiSelect({
	selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
	selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
	afterInit: function (ms) {
		var that = this,
			\$selectableSearch = that.\$selectableUl.prev(),
			\$selectionSearch = that.\$selectionUl.prev(),
			selectableSearchString = '#' + that.\$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
			selectionSearchString = '#' + that.\$container.attr('id') + ' .ms-elem-selection.ms-selected';

		that.qs1 = \$selectableSearch.quicksearch(selectableSearchString)
			.on('keydown', function (e) {
				if (e.which === 40) {
					that.\$selectableUl.focus();
					return false;
				}
			});

		that.qs2 = \$selectionSearch.quicksearch(selectionSearchString)
			.on('keydown', function (e) {
				if (e.which == 40) {
					that.\$selectionUl.focus();
					return false;
				}
			});
	},
	afterSelect: function () {
		this.qs1.cache();
		this.qs2.cache();
	},
	afterDeselect: function () {
		this.qs1.cache();
		this.qs2.cache();
	}
});
XXX;
	} elseif($vv['type'] == 'radio4'){
		$tmp = <<<XXX
$('#{{$kk}} label').hover(
	function(){
		$('#{{$kk}}_display_html').html($(this).attr('html'));
	},
	function(){
	}
);
XXX;
	} elseif($vv['type'] == 'codemirror2'){
		$tmp = <<<XXX
var editor = CodeMirror.fromTextArea(document.getElementById("{{$kk}}"),{lineNumbers: true});
$('.CodeMirror').css('background-color', '#eee');
XXX;
	} elseif($vv['type'] == 'pass_regen_killme'){

		if(!isset($vv['other']['len']) or $vv['other']['len'] == ''){
			$len = '6';
		} else {
			$len = $vv['other']['len'];
		}

		if(!isset($vv['other']['no_value_trigger']) or $vv['other']['no_value_trigger'] == ''){
			$no_value_trigger = false;
		} else {
			$no_value_trigger = true;
		}

		$data = false;
		if(isset($updatecontent[$kk]) and $updatecontent[$kk] != ''){
			$data = $updatecontent[$kk];
		}

		$tmp2 = <<<XXX
$('#{$vv['attr']['id']}_regen').click(function(){
	$.ajax({
		type: "POST",
		url: '{$class_url}/regen&len={$len}',
		success: function(response){
			$('#{$vv['attr']['id']}').attr('value', response);
		}
	});
	return false;
});
XXX;

		if($no_value_trigger and !$data){
		$tmp2 .= <<<XXX

$('#{$vv['attr']['id']}_regen').click();

XXX;
		}

	} elseif($vv['type'] == 'kcfinder_input_killme'){
		$vir_path_c = vir_path_c;

		// 除掉_ozman資料夾，先個案處理，之後在看看
		$vir_path_c2 = str_replace('/_i', '', $vir_path_c);
		// type，例如files
		// dir，例如files/public
		$tmp2 = <<<XXX
function openKCFinder(field, uploadurl_id, type, dir) {
    window.KCFinder = {
        callBack: function(url) {
			url = url.replace("{$vir_path_c2}", '');
            field.value = url;
            window.KCFinder = null;
        }
    };
	//alert('{$vir_path_c}kcfinder/browse.php?uploadurl_id='+uploadurl_id+'&type='+type+'&dir='+dir);
    window.open('{$vir_path_c}kcfinder/browse.php?uploadurl_id='+uploadurl_id+'&lang=zh-tw&type='+type+'&dir='+dir, 'kcfinder_textboxg',
        'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
        'resizable=1, scrollbars=0, width=800, height=600'
    );
}
$('#{$vv['attr']['id']}_clear').click(function(){
	$('#{$vv['attr']['id']}').attr('value', '');
	$('#{$vv['attr']['id']}').parent().find('img').remove();
	return false;
});
XXX;
	} elseif($vv['type'] == 'kcfinder_input_school_killme'){
		$vir_path_c = vir_path_c;

		$vir_path_c2 = $vir_path_c;

		// 請注意，如果在httpd.conf裡面使用了VirtualDocumentRoot，那這裡會不一樣
		$tmp01 = explode('.', $_SERVER['HTTP_HOST']);
		if($tmp01[1] == 'web' and $tmp01[2] == 'buyersline'){
			$vir_path_c2 = '/'.$tmp01[0].$vir_path_c2;
		}

		// 除掉_ozman資料夾，先個案處理，之後在看看
		//$vir_path_c2 = str_replace('/_ozman', '', $vir_path_c);
		// type，例如files
		// dir，例如files/public
		$tmp2 = <<<XXX
function openKCFinder(field, uploadurl_id, type, dir, school_id) {
    window.KCFinder = {
        callBack: function(url) {
			url = url.replace("{$vir_path_c2}", '');
            field.value = url;
            window.KCFinder = null;
        }
    };
	//alert('{$vir_path_c}kcfinder/browse.php?uploadurl_id='+uploadurl_id+'&type='+type+'&dir='+dir);
    window.open('{$vir_path_c}kcfinder/browse.php?uploadurl_id='+uploadurl_id+'&lang=zh-tw&type='+type+'&dir='+dir+'&school_id='+school_id, 'kcfinder_textboxg',
        'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
        'resizable=1, scrollbars=0, width=800, height=600'
    );
}
$('#{$vv['attr']['id']}_clear').click(function(){
	$('#{$vv['attr']['id']}').attr('value', '');
	$('#{$vv['attr']['id']}').parent().find('img').remove();
	return false;
});
XXX;
	} elseif($vv['type'] == 'kcfinder_xxx' or $vv['type'] == 'kcfinder2_xxx'){
		if(!isset($vv['other']['url']) or $vv['other']['url'] == ''){
			$kcfinder_url = '/'.$vv['type'].'/browse.php?langCode=zh&type=';
		} else {
			$kcfinder_url = $vv['other']['url'];
		}
		$tmp = <<<XXX
$('#{$vv['attr']['id']}_select').change(function(){
	$('#{$vv['attr']['id']}').attr('src', '{$kcfinder_url}' + $(this).attr('value'));
});
XXX;
	} elseif($vv['type'] == 'inputml'){
		$label_url = $this->createUrl('label/autocomplete');
		$tmp = <<<XXX
$("#{$vv['attr']['id']}").autocomplete("{$label_url}", {
	width: 320,
	max: 10,
	highlight: false,
	scroll: true,
	scrollHeight: 300,
	formatItem: function(data, i, n, value) {
		var returnvalue = '';
		var tmps1 = value.split('----')[0];
		var tmps2 = value.split('----')[1];
		returnvalue = '片語名稱 : ml:' + tmps1 + '<br />';
		var tmpsa = tmps2.split('*****');
		for(var keya in tmpsa){
			returnvalue += tmpsa[keya].split('===')[0]+' : '+tmpsa[keya].split('===')[1]+'<br />';
		}
		return returnvalue;
	},
	formatResult: function(data, value) {
		return 'ml:'+value.split('----')[0];
	}
});
XXX;
	} elseif($vv['type'] == 'textarea_autoheight_js_killme'){
		$tmp = <<<XXX
$("#{$kk}").autosize();
XXX;
	} elseif($vv['type'] == 'tag_input_killme'){ //2016/8/2 lota add tag_input
		$tmp = <<<XXX
$("#{$kk}").tagsInput({width:'auto'});
XXX;
	} else {
		$tmp = '';
		if($vv['type'] != ''){
			$module_field_content = '';

			// 因為模組裡面會有很多成份
			$this->data['vv_type_select'] = 'js';/* view|js */

			// 這是view的專用模組變數
			// 因為一般的變數是傳不過去的
			$this->data['vv_type_kk'] = $kk;
			$this->data['vv_type_vv'] = $vv;

			try {
			  $module_field_content = $this->renderPartial('//default/updatefields/'.$vv['type'], $this->data, true);
			}catch(Exception $e){}

			if($module_field_content != ''){
				$tmp = $module_field_content;
			}

		}
	} // 結束
	if($tmp != ''){
		Yii::app()->clientScript->registerScript('update_fields_javascript_'.$kk, $tmp, CClientScript::POS_READY);
	}

	if($tmp2 != ''){
		Yii::app()->clientScript->registerScript('update_fields_javascript2_'.$kk, $tmp2, CClientScript::POS_END);
	}
}
?>
