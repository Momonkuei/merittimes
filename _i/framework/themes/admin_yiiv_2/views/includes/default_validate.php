<?php
//{{* 這個是驗證表單的預設值，因為是javascript，而且每一支都會用得到，所以才這樣子做 *}}
//{{* 修改，和新增頁面或是功能專用 *}}

$default_validate_1 = <<<XXX1
// $.validator.setDefaults({
// 	/* 重写错误显示消息方法,以alert方式弹出错误消息 */
// 	showErrors: function(errorMap, errorList) {
// 		var msg = "";
// 		$.each( errorList, function(i,v){
// 		  msg += (v.name + v.message);
// 		});
// 		if(msg!="") alert(msg);
// 	},
//     onfocusout:false
// });


//{{*為了讓送出表單檢查失敗的時候，除了欄位上會顯示錯誤訊息之外，會先alert一個提示視窗*}}
$.validator.setDefaults({
	invalidHandler: function(form, validator) {
		$.each(validator.invalid,function(key,value){
			tmpkey = key;
			tmpval = value;
			validator.invalid = {};
			validator.invalid[tmpkey] = value;
			alert(l.get('Please check your field'));
			document.location.href="#";
			return false;
		});
	}
	//errorPlacement:function(error, element) {
	//},
	//onkeyup: false,
	//onfocusout:false,
	//focusInvalid: true
});

$.extend($.validator.messages, {
	//required: '##This field is required.##',
	required: '&nbsp;<font style="color: red;">' + l.get('This field is required.') + '</font>',
	email: '&nbsp;<font style="color: red;">' + l.get('Please enter a valid email address.') + '</font>',
	equalTo: '&nbsp;<font style="color: red;">' + l.get('Please enter the same value again.') + '</font>',
	minlength: $.validator.format(l.get('Please enter at least {0} characters.')),
	maxlength: $.validator.format(l.get('Please enter no more than {0} characters.'))
	//rangelength: $.validator.format("請輸入長度介於 {0} 和 {1} 之間的字串"),
	//range: $.validator.format("請輸入介於 {0} 和 {1} 之間的數值"),
	//max: $.validator.format("請輸入不大於 {0} 的數值"),
	//min: $.validator.format("請輸入不小於 {0} 的數值")
});

var form_data_validate = {
	rules: {},
	messages: {}
	//errorPlacement: function(error, element) {
	//	error.insertBefore(element);
	//}
}
XXX1;
$default_validate_1 .= "\n";
if(!empty($updatecontent_jqueryvalidation)){
	$default_validate_1 .= 'form_data_validate.rules = '.$jqueryvalidation."\n";
	$default_validate_1 .= '$("#form_data").validate(form_data_validate);'."\n";
}
Yii::app()->clientScript->registerScript('default_validate_1', $default_validate_1, CClientScript::POS_READY);
?>
