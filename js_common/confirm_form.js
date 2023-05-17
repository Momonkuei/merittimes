// JavaScript Document
var formIsSubmit = false;

function MM_findObj(n, d) { //v4.01
	var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
	d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
	if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
	for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
	if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
	/* //2016/7/14 lota 改用新的方式，不使用二次送出阻止方法
	if(formIsSubmit){
		show_alert(msgProcess);
		document.MM_returnValue = false;
		return false;
	}
	*/
	var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
	for (i=0; i<(args.length-2); i+=3){
		test=args[i+2]; val=MM_findObj(args[i]);
		if (val){
			nm=val.name;
			nm_id=val.id;
			if ((val=val.value)!="") {
				if (test.indexOf('isEmail')!=-1){
					p=val.indexOf('@');
					if (p<1 || p==(val.length-1)) errors+=msgErrorTip3 + '\n';
				}else if(test!='R'){
					num = parseFloat(val);
					if (isNaN(val)) errors+='「'+nm_id+'」' + msgErrorTip4 + '\n';
					if (test.indexOf('inRange') != -1){
						p=test.indexOf(':');
						min=test.substring(8,p); max=test.substring(p+1);
						if (num<min || max<num){
							var ssss = strprintf(msgErrorTip5, min, max);
							errors+='- '+nm+' ' + ssss;
						}
					}
				}
			}else if (test.charAt(0) == 'R'){
				if(nm_id == 'SearchKeyword'){
					errors += msgErrorTip1 + '\n';
				}else{
					var s_err = strprintf(msgErrorTip2, nm_id);
					errors += s_err + '\n';
				}
			}
		}
	}

	// 12/16 add
    //var text = $(".check_mobile").val();
    //  re  = /^[09]{2}[0-9]{8}$/;
    //  re1 = /^[09]{2}[0-9]{2}-[0-9]{6}$/;
    //  re2 = /^[09]{2}[0-9]{2}-[0-9]{3}-[0-9]{3}$/;
    //  re3 = /^[09]{2}[0-9]{2} [0-9]{6}$/;
    //  re4 = /^[09]{2}[0-9]{2} [0-9]{3} [0-9]{3}$/;

    //if (text.search(re)=="-1" && text.search(re1)=="-1" && text.search(re2)=="-1" && text.search(re3)=="-1"&& text.search(re4)=="-1"){
	//  errors += '你的手機格式不對！' + '\n';
    //}
	
	var frm = args[args.length-1];
	
	if(frm.new_pswd && frm.cfm_pswd){
		if(frm.new_pswd.value != frm.cfm_pswd.value) {
			var s_err = msgErrorTip6;
			errors += s_err + '\n';
		}
	}
	
	
	if (errors){
		show_alert(errors);
	}
	
	document.MM_returnValue = (errors == '');
	formIsSubmit = document.MM_returnValue;
}

function MM_validateForm_payment() { //2017/7/4 jonathan說提交前要確認
	
	var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
	for (i=0; i<(args.length-2); i+=3){
		test=args[i+2]; val=MM_findObj(args[i]);
		if (val){
			nm=val.name;
			nm_id=val.id;
			if ((val=val.value)!="") {
				if (test.indexOf('isEmail')!=-1){
					p=val.indexOf('@');
					if (p<1 || p==(val.length-1)) errors+=msgErrorTip3 + '\n';
				}else if(test!='R'){
					num = parseFloat(val);
					if (isNaN(val)) errors+='「'+nm_id+'」' + msgErrorTip4 + '\n';
					if (test.indexOf('inRange') != -1){
						p=test.indexOf(':');
						min=test.substring(8,p); max=test.substring(p+1);
						if (num<min || max<num){
							var ssss = strprintf(msgErrorTip5, min, max);
							errors+='- '+nm+' ' + ssss;
						}
					}
				}
			}else if (test.charAt(0) == 'R'){
				if(nm_id == 'SearchKeyword'){
					errors += msgErrorTip1 + '\n';
				}else{
					var s_err = strprintf(msgErrorTip2, nm_id);
					errors += s_err + '\n';
				}
			}
		}
	}

	var frm = args[args.length-1];
	
	if(frm.new_pswd && frm.cfm_pswd){
		if(frm.new_pswd.value != frm.cfm_pswd.value) {
			var s_err = msgErrorTip6;
			errors += s_err + '\n';
		}
	}
	
	
	if (errors){
		show_alert(errors);
		document.MM_returnValue = (errors == '');
		formIsSubmit = document.MM_returnValue;
	}else{
		var r = confirm('通知後即無法更新，請再次填寫資料正確？');
		if(r==true){
			document.MM_returnValue = (errors == '');
			formIsSubmit = document.MM_returnValue;
		}else{
			formIsSubmit = false;
			document.MM_returnValue = false;
			return false;
		}
	}

}

function show_alert(msg) {
	alert(msg);
}


//檢查核取方塊的必填欄位是否有值
function confirm_checkboxes(obj,val){
	var	chk_skin=0;	
	
	for(x=0;x<obj.length;x++){
		if(obj[x].checked == true) chk_skin++;
	} 
	if(chk_skin==0)
		return val;
	else
		return '';
}

function strprintf(){
	var args = strprintf.arguments;
	var str = '';
	if(args[0]){
		str = args[0];
	}
	if(args.length > 1){
		str1 = ''
		for(var i=0, j=1; i<str.length; i++){
			if((str.substring(i, i+2) == '%s') && args[j]){
				str1 += args[j];
				i++;
				j++;
			}else{
				str1 += str.substring(i, i+1);
			}
		}
		str = str1;
	}
	return str;
}
