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
		//validator.focusInvalid();
		$.each(validator.invalid,function(key,value){
			tmpkey = key;
			tmpval = value;
			validator.invalid = {};
			validator.invalid[tmpkey] = value;
			// 只要強制送出的按鈕存在，就不會出現"請檢查您的欄位是否有填"的訊息
			if($('#force_save').length <= 0){
				alert(l.get('Please check your field'));
			}
			//document.location.href="#";
			// http://stackoverflow.com/questions/1458605/how-to-display-messages-in-invalidhandler-in-jquery-validator
		});
		//return false;
	},
	// 這行沒加的話，在alert之後，如果有欄位沒過，還是會送出的，當你按下Enter的時候
	onfocusout: false
	//errorPlacement:function(error, element) {
	//},
	//onkeyup: false,
	//onfocusout:false,
	//focusInvalid: true
});

// http://demo.tc/post/677
jQuery.extend(jQuery.validator.defaults,
{
    errorPlacement: function (error, element) {
        if (element.is(':radio') || element.is(':checkbox')) {
            var eid = element.attr('name');
            $('input[name=' + eid + ']:last').next().after(error);
        }
        else {
            error.insertAfter(element);
        }
    }
});

/*
 * select的欄位必填的做法，是不一樣的
 * http://jsfiddle.net/tPRNd/
 */
$.validator.addMethod('selectcheck', function (value) {
	return (value != '0');
}, '&nbsp;<font style="color: red;">' + l.get('This field is required.') + '</font>');


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
