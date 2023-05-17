<?php 
foreach($v['field'] as $kk => $vv){
	$tmp = '';
	$tmp2 = '';

	//if(!isset($vv['type'])){
	//	continue;
	//}

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
	} elseif($vv['type'] == 'ckeditor_js'){
		Yii::app()->clientScript->registerCoreScript('ckeditor');
		$tmp = <<<XXX
var editor = CKEDITOR.replace("{$kk}");
CKFinder.setupCKEditor(editor, '/ckfinder/'); 
XXX;
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
	} elseif($vv['type'] == 'inputselect'){
		$tmp = <<<XXX
$('#{$kk}_{$vv['type']}').change(function(){
	var val = $(this).val();
	$('#{$kk}').attr('value', val);
});
XXX;
	} elseif($vv['type'] == 'codemirror2'){
		$tmp = <<<XXX
var editor = CodeMirror.fromTextArea(document.getElementById("{{$kk}}"),{lineNumbers: true});
$('.CodeMirror').css('background-color', '#eee');
XXX;
	} elseif($vv['type'] == 'kcfinder_input'){
		$vir_path_c = vir_path_c;

		// 除掉_ozman資料夾，先個案處理，之後在看看
		$vir_path_c2 = str_replace('/_butterfly', '', $vir_path_c);
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
    window.open('{$vir_path_c}kcfinder/browse.php?uploadurl_id='+uploadurl_id+'&type='+type+'&dir='+dir, 'kcfinder_textboxg',
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
	} elseif($vv['type'] == 'kcfinder_input_school'){
		$vir_path_c = vir_path_c;

		// 除掉_ozman資料夾，先個案處理，之後在看看
		$vir_path_c2 = str_replace('/_ozman', '', $vir_path_c);
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
    window.open('{$vir_path_c}kcfinder/browse.php?uploadurl_id='+uploadurl_id+'&type='+type+'&dir='+dir+'&school_id='+school_id, 'kcfinder_textboxg',
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
	} elseif($vv['type'] == 'textarea_autoheight_js'){
		$tmp = <<<XXX
$("#{$kk}").autosize();
XXX;
	}
	if($tmp != ''){
		Yii::app()->clientScript->registerScript('update_fields_javascript_'.$kk, $tmp, CClientScript::POS_READY);
	}

	if($tmp2 != ''){
		Yii::app()->clientScript->registerScript('update_fields_javascript2_'.$kk, $tmp2, CClientScript::POS_END);
	}
}
?>
