<?php
// 這個是驗證表單的預設值，因為是javascript，而且每一支都會用得到，所以才這樣子做
// 修改，和新增頁面或是功能專用

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
				alert(t.get('Please check your field','en'));
			}

			// 客製，多項的checkbox範例，至少選中一項
			// if(key == 'service[]'){
			// 	alert(t.get('項目至少要選一項','tw'));
			// }

			// 客製，多個select，至少選中一項
			// if(key == 'GGGAAA'){
			// 	alert(t.get('搬家的項目請至少選擇一項','tw'));
			// }

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

			if(eid.indexOf('[]')){
				// do nothing
			} else {
				$('input[name=' + eid + ']:last').next().after(error);
			}
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
	return (value != '0' && value != '');
}, '&nbsp;<font style="color: red;">' + t.get('This field is required.','en') + '</font>');

// http://stackoverflow.com/questions/3035634/jquery-validate-check-at-least-one-checkbox
// 使用方式 <input class='roles' name='roles' type='checkbox' value='1' />
$.validator.addMethod("roles", function(value, elem, param) {
    if($(".roles:checkbox:checked").length > 0){
       return true;
   }else {
       return false;
   }
}, '&nbsp;<font style="color: red;">' + t.get('You must select at least one!','en') + '</font>');

// http://stackoverflow.com/questions/22475001/validate-multiple-select-boxes-selecting-only-one
$.validator.addMethod("selects", function(value, elem, param) {
    var result=false;

    $( ".selects" ).each(function(){
        var id=$(this).attr("id");                      
        var value = $("#"+id+" option:selected").val();
        if(value){
           result = true;
        }
    })

    return result;
}, '&nbsp;<font style="color: red;">' + t.get('You must select at least one!','en') + '</font>');

$.extend($.validator.messages, {
	required: '&nbsp;<font style="color: red;">' + t.get('This field is required.','en') + '</font>',
	email: '&nbsp;<font style="color: red;">' + t.get('Please enter a valid email address.','en') + '</font>',
	remote: '&nbsp;<font style="color: red;">' + t.get('Please fix this field.','en') + '</font>',
	equalTo: '&nbsp;<font style="color: red;">' + t.get('Please enter the same value again.','en') + '</font>',
	minlength: '&nbsp;<font style="color: red;">' + t.get('Please enter at least {0} characters.','en') + '</font>',
	maxlength: '&nbsp;<font style="color: red;">' + t.get('Please enter no more than {0} characters.','en') + '</font>',
	number: '&nbsp;<font style="color: red;">' + t.get('Please enter a valid number.','en') + '</font>',
	digits: '&nbsp;<font style="color: red;">' + t.get('Please enter only digits.','en') + '</font>',
	rangelength: '&nbsp;<font style="color: red;">' + t.get('Please enter a value between {0} and {1} characters long.','en') + '</font>',
	range: '&nbsp;<font style="color: red;">' + t.get('Please enter a value between {0} and {1}.','en') + '</font>',
	max: '&nbsp;<font style="color: red;">' + t.get('Please enter a value less than or equal to {0}.','en') + '</font>',
	min: '&nbsp;<font style="color: red;">' + t.get('Please enter a value greater than or equal to {0}.','en') + '</font>',
	step: '&nbsp;<font style="color: red;">' + t.get('Please enter a multiple of {0}.','en') + '</font>'
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
if(!empty($this->data['updatecontent_jqueryvalidation'])){
	$default_validate_1 .= 'form_data_validate.rules = '.$this->data['jqueryvalidation']."\n";
	$default_validate_1 .= '$("#form_data").validate(form_data_validate);'."\n";
}
?>

<script src="js_common/jquery.validate.min.js" m="body_end"></script>
<script type="text/javascript" m="body_end">
	$( document ).ready(function() {
<?php echo $default_validate_1?>
	});
</script>
