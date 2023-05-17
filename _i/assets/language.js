function Language(multilanguage){
	this.ml_key = multilanguage;
	this.get = geta;
}
function geta(label){
	var aa = labels[this.ml_key][label.toLowerCase()];

	var regex = /^\[\[(.*)\]\] (.*)$/g;
	var match = regex.exec(label.toLowerCase());

	if(aa == undefined){
		if(match && match[1] != null){
			return match[2];
		} else {
			return label;
		}
	} else {
		return aa;
	}
}
// 載入多國語系，給js所使用
var l = new Language(ml_key);
var labels = {"en":{"[[adminlogin7]] login password":"Password","[[adminlogin7]] login account":"Username","[[adminlogin7]] keep login":"Stay signed in","[[adminlogin7]] default language":"Default Language","[[adminlogin7]] login section name":"Login","[[adminlogin7]] login button":"Login","[[adminlogin7]] login fail":"The username or password you entered is incorrect.","[[adminlogin7]] captcha":"Captcha Code","[[adminlogin7]] select language":"Select Language","[[adminlogin7]] frontend preview":"View Site","[[admin_1]] welcome":"Welcome","[[admin_1]] logout":"Logout","[[admin_1]] sort id":"Sort","[[admin_lang_1]] sort id":"Sort","please check your field":"Please check your field","this field is required.":"This field is required.","[[admin_lang_1]] update time":"Update Time","[[admin_lang_1]] create time":"Create Time","[[admin_lang_1]] label index":"Label Index","[[admin_lang_1]] title":"Title","[[admin_lang_1]] company english name":"Company English Name","[[admin_lang_1]] form action":"Action","[[admin_lang_1]] create":"Create","[[admin_lang_1]] submit":"Submit","[[admin_lang_1]] reset":"Reset","[[admin_lang_1]] previous":"Previous","[[admin_lang_1]] \u4ea4\u6613\u6392\u884c\u524d20\u540d":"Top 20 Trader","[[admin_lang_1]] status":"Status","[[admin_lang_1]] date":"Date","[[admin_lang_1]] full name":"Full name","[[admin_lang_1]] phone":"Phone","[[admin_lang_1]] fax":"Fax","[[admin_lang_1]] company name":"Company name","[[admin_lang_1]] vat number":"VAT Number","[[admin_lang_1]] company phone":"Company phone","[[admin_lang_1]] person in charge":"Person in charge","[[admin_lang_1]] url":"Url","[[admin_lang_1]] priority":"Priority","[[admin_lang_1]] product name":"Product Name","[[admin_lang_1]] image":"Image","[[admin_lang_1]] comments":"Comments","[[admin_lang_1]] description":"Description","[[adminlogin7]] login to your account":"Login to your account","[[admin_lang_1]] mobile":"Mobile","[[admin_lang_1]] home phone":"Home Phone","[[admin_lang_1]] company url":"Company Url","[[admin_lang_1]] sign date":"Sign Date","[[web]] \u66f4\u65b0\u9a57\u8b49\u78bc":"Update Captcha","[[admin_lang_1]] home":"Home","[[admin_lang_1]] change password":"Change Password","[[admin_lang_1]] logout":"Logout","[[admin_lang_1]] search":"Search","[[admin_lang_1]] search data":"Search Data","[[admin_lang_1]] cancel search":"Cancel Search","[[admin_lang_1]] tools":"Tools","[[admin_lang_1]] welcome login":"Welcome Login","[[admin_lang_1]] member list":"Member List","[[admin_lang_1]] member account":"Member Account","[[admin_lang_1]] first contact":"First Contact","[[admin_lang_1]] company address":"Company Address","[[admin_lang_1]] company fax":"Company Fax","[[admin_lang_1]] company email":"Company Email","[[admin_lang_1]] sales":"Sales","[[web]] \u6027\u5225":"Gender","[[contact form]] name":"aaa","[[contact_form]] abc":"456","[[web]] \u59d3\u540d":"Name","[[web]] \u7537":"Male","[[web]] \u5973":"Female","[[web]] \u96fb\u8a71":"Phone","[[web]] \u751f\u65e5":"Birthday","[[web]] \u5730\u5740":"Address","[[web]] \u610f\u898b":"Message","[[web]] \u8a8d\u8b49\u78bc":"Captcha Code","[[web]] \u516c\u53f8\u540d\u7a31":"Company Name","[[web]] \u50b3\u771f":"Fax","[[web]] \u5206\u6a5f":"Extension","[[web]] \u52a0\u5165\u8a62\u554f\u8eca":"Add Inquiry","[[web]] \u6578\u91cf":"Quantity","[[web]] \u5546\u54c1\u8aaa\u660e":"Product Description","[[web]] \u5546\u54c1\u898f\u683c":"Product Specifications","[[web]] \u56de\u5217\u8868":"Back to the list","[[web]] \u5df1\u52a0\u5165\u8a62\u554f\u8eca":"Added Inquiry","[[web]] \u522a\u9664":"Del","[[web]] \u70ba\u5fc5\u586b":"Fields marked with * are required","[[web]] \u5982\u679c\u60a8\u5c0d\u6211\u5011\u7684\u7522\u54c1\u6709\u4efb\u4f55\u554f\u984c\uff0c\u6b61\u8fce\u900f\u904e\u8aee\u8a62\u8868\u55ae\u8207\u6211\u5011\u806f\u7d61\u3002":"If you have any questions about our products, please feel free to contact us via our inquiry form.","[[web]] \u8acb\u586b\u5beb\u5728\u7dda\u8868\u683c\u8207\u6211\u5011\u806f\u7e6b\u3002":"Please fill out the online form to contact with us.","[[web]] \u9001\u51fa\u6210\u529f":"Send Success","[[web]] \u9a57\u8b49\u78bc\u932f\u8aa4":"Captcha Code Error","[[web]] \u4e0a\u4e00\u5247":"Prev","[[web]] \u4e0b\u4e00\u5247":"Next","[[web]] \u8acb\u8f38\u5165":"Please Input","[[admin_lang_1]] delete":"Delete","[[admin_lang_1]] edit":"Edit","[[admin_lang_1]] advanced search":"Advanced search","[[admin_lang_1]] move":"Move","[[admin_lang_1]] copy":"Copy"},"tw":{"[[adminlogin7]] keep login":"\u4fdd\u6301\u767b\u5165\u72c0\u614b","[[adminlogin7]] login account":"\u4f7f\u7528\u8005\u540d\u7a31","[[adminlogin7]] login password":"\u5bc6\u78bc","[[adminlogin7]] default language":"\u9810\u8a2d\u8a9e\u7cfb","[[adminlogin7]] login section name":"\u7ba1\u7406\u8005\u767b\u5165","[[adminlogin7]] login button":"\u767b\u5165","[[adminlogin7]] login fail":"\u5e33\u865f\u6216\u5bc6\u78bc\u932f\u8aa4\uff01","[[adminlogin7]] captcha":"\u9a57\u8b49\u78bc","[[adminlogin7]] select language":"\u9078\u64c7\u8a9e\u8a00","[[adminlogin7]] frontend preview":"\u700f\u89bd\u7db2\u7ad9","[[admin_1]] welcome":"\u6b61\u8fce","[[admin_1]] logout":"\u767b\u51fa","[[admin_1]] sort id":"\u6392\u5e8f","[[admin_lang_1]] sort id":"\u6392\u5e8f","please check your field":"\u8acb\u6aa2\u67e5\u60a8\u7684\u6b04\u4f4d\u662f\u5426\u6709\u586b?","this field is required.":"\u9019\u500b\u6b04\u4f4d\u662f\u5fc5\u586b","[[admin_lang_1]] update time":"\u4fee\u6539\u6642\u9593","[[admin_lang_1]] create time":"\u5efa\u7acb\u6642\u9593","[[admin_lang_1]] label index":"\u7247\u8a9e\u7d22\u5f15","[[admin_lang_1]] title":"\u6a19\u984c","[[admin_lang_1]] company english name":"\u516c\u53f8\u82f1\u6587\u540d\u7a31","[[admin_lang_1]] form action":"\u52d5\u3000\u4f5c","[[admin_lang_1]] create":"\u65b0\u589e","[[admin_lang_1]] submit":"\u9001\u51fa","[[admin_lang_1]] reset":"\u6e05\u9664","[[admin_lang_1]] previous":"\u4e0a\u4e00\u9801","[[admin_lang_1]] \u4ea4\u6613\u6392\u884c\u524d20\u540d":"\u4ea4\u6613\u6392\u884c\u524d20\u540d ","[[admin_lang_1]] status":"\u72c0\u614b","[[admin_lang_1]] date":"\u65e5\u671f","[[admin_lang_1]] full name":"\u59d3\u540d","[[admin_lang_1]] phone":"\u96fb\u8a71","[[admin_lang_1]] fax":"\u50b3\u771f","[[admin_lang_1]] company name":"\u516c\u53f8\u540d\u7a31","[[admin_lang_1]] vat number":"\u7d71\u7de8","[[admin_lang_1]] company phone":"\u516c\u53f8\u96fb\u8a71","[[admin_lang_1]] person in charge":"\u8ca0\u8cac\u4eba","[[admin_lang_1]] url":"\u7db2\u5740","[[admin_lang_1]] priority":"\u512a\u5148\u6b0a","[[admin_lang_1]] product name":"\u5546\u54c1\u540d\u7a31","[[admin_lang_1]] image":"\u5716\u7247","[[admin_lang_1]] comments":"\u5099\u8a3b\u8aaa\u660e","[[admin_lang_1]] description":"\u63cf\u8ff0","[[adminlogin7]] login to your account":"\u767b\u5165","[[admin_lang_1]] mobile":"\u884c\u52d5\u96fb\u8a71","[[admin_lang_1]] home phone":"\u4f4f\u5b85\u96fb\u8a71","[[admin_lang_1]] company url":"\u516c\u53f8\u7db2\u5740","[[admin_lang_1]] sign date":"\u767b\u8a18\u65e5\u671f","[[web]] \u66f4\u65b0\u9a57\u8b49\u78bc":"\u66f4\u65b0\u9a57\u8b49\u78bc","[[admin_lang_1]] home":"\u9996\u9801","[[admin_lang_1]] change password":"\u66f4\u6539\u5bc6\u78bc","[[admin_lang_1]] logout":"\u767b\u51fa","[[admin_lang_1]] search":"\u641c\u5c0b","[[admin_lang_1]] search data":"\u641c\u5c0b\u8cc7\u6599\u5167\u5bb9","[[admin_lang_1]] cancel search":"\u53d6\u6d88\u641c\u5c0b","[[admin_lang_1]] tools":"\u5de5\u5177","[[admin_lang_1]] welcome login":"\u6b61\u8fce\u767b\u5165EOB\u7ba1\u7406\u7cfb\u7d71","[[admin_lang_1]] member list":"\u6703\u54e1\u660e\u7d30","[[admin_lang_1]] member account":"\u6703\u54e1\u5e33\u6236","[[admin_lang_1]] first contact":"\u806f\u7d61\u4eba1","[[admin_lang_1]] company address":"\u516c\u53f8\u5730\u5740","[[admin_lang_1]] company fax":"\u516c\u53f8\u50b3\u771f","[[admin_lang_1]] company email":"\u516c\u53f8\u96fb\u5b50\u4fe1\u7bb1","[[admin_lang_1]] sales":"\u696d\u52d9","[[web]] \u59d3\u540d":"\u59d3\u540d","[[contact form]] name":"ccc","[[contact_form]] abc":"789","[[web]] \u6027\u5225":"\u6027\u5225","[[web]] \u7537":"\u7537","[[web]] \u5973":"\u5973","[[web]] \u96fb\u8a71":"\u96fb\u8a71","[[web]] \u751f\u65e5":"\u751f\u65e5","[[web]] \u5730\u5740":"\u5730\u5740","[[web]] \u610f\u898b":"\u610f\u898b","[[web]] \u8a8d\u8b49\u78bc":"\u8a8d\u8b49\u78bc","[[web]] \u516c\u53f8\u540d\u7a31":"\u516c\u53f8\u540d\u7a31","[[web]] \u50b3\u771f":"\u50b3\u771f","[[web]] \u5206\u6a5f":"\u5206\u6a5f","[[web]] \u52a0\u5165\u8a62\u554f\u8eca":"\u52a0\u5165\u8a62\u554f\u8eca","[[web]] \u6578\u91cf":"\u6578\u91cf","[[web]] \u5546\u54c1\u8aaa\u660e":"\u5546\u54c1\u8aaa\u660e","[[web]] \u5546\u54c1\u898f\u683c":"\u5546\u54c1\u898f\u683c","[[web]] \u56de\u5217\u8868":"\u56de\u5217\u8868","[[web]] \u5df1\u52a0\u5165\u8a62\u554f\u8eca":"\u5df1\u52a0\u5165\u8a62\u554f\u8eca","[[web]] \u522a\u9664":"\u522a\u9664","[[web]] \u70ba\u5fc5\u586b":"\u70ba\u5fc5\u586b","[[web]] \u5982\u679c\u60a8\u5c0d\u6211\u5011\u7684\u7522\u54c1\u6709\u4efb\u4f55\u554f\u984c\uff0c\u6b61\u8fce\u900f\u904e\u8aee\u8a62\u8868\u55ae\u8207\u6211\u5011\u806f\u7d61\u3002":"\u5982\u679c\u60a8\u5c0d\u6211\u5011\u7684\u7522\u54c1\u6709\u4efb\u4f55\u554f\u984c\uff0c\u6b61\u8fce\u900f\u904e\u8aee\u8a62\u8868\u55ae\u8207\u6211\u5011\u806f\u7d61\u3002","[[web]] \u8acb\u586b\u5beb\u5728\u7dda\u8868\u683c\u8207\u6211\u5011\u806f\u7e6b\u3002":"\u8acb\u586b\u5beb\u5728\u7dda\u8868\u683c\u8207\u6211\u5011\u806f\u7e6b\u3002","[[web]] \u9001\u51fa\u6210\u529f":"\u9001\u51fa\u6210\u529f","[[web]] \u9a57\u8b49\u78bc\u932f\u8aa4":"\u9a57\u8b49\u78bc\u932f\u8aa4","[[web]] \u4e0a\u4e00\u5247":"\u4e0a\u4e00\u5247","[[web]] \u4e0b\u4e00\u5247":"\u4e0b\u4e00\u5247","[[web]] \u8acb\u8f38\u5165":"\u8acb\u8f38\u5165","[[admin_lang_1]] delete":"\u522a\u9664","[[admin_lang_1]] edit":"\u7de8\u8f2f","[[admin_lang_1]] advanced search":"\u9032\u968e\u641c\u5c0b","[[admin_lang_1]] move":"\u79fb\u52d5","[[admin_lang_1]] copy":"\u62f7\u8c9d","[[admin_1]] are you sure you want to delete":"\u4f60\u662f\u5426\u8981\u522a\u9664","[[web]] are you sure you want to delete":"\u4f60\u662f\u5426\u8981\u522a\u9664"},"cn":{"[[admin_lang_1]] description":"\u63cf\u8ff0","[[admin_lang_1]] company english name":"\u516c\u53f8\u82f1\u6587\u540d\u79f0","[[admin_lang_1]] home":"\u9996\u9875","[[adminlogin7]] login to your account":"\u767b\u5f55","[[admin_lang_1]] mobile":"\u884c\u52a8\u7535\u8bdd","[[admin_lang_1]] home phone":"\u4f4f\u5b85\u7535\u8bdd","[[admin_lang_1]] company url":"\u516c\u53f8\u7f51\u5740","[[admin_lang_1]] image":"\u56fe\u50cf","[[admin_lang_1]] comments":"\u8bc4\u8bba","[[admin_lang_1]] sign date":"\u767b\u8bb0\u65e5\u671f","[[admin_lang_1]] product name":"\u4ea7\u54c1\u540d\u79f0","[[adminlogin7]] keep login":"\u8bf7\u767b\u5f55","[[adminlogin7]] login account":"\u767b\u5f55\u5e10\u6237","[[adminlogin7]] login password":"\u767b\u5f55\u5bc6\u7801","[[adminlogin7]] default language":"\u9ed8\u8ba4\u8bed\u8a00","[[adminlogin7]] login section name":"\u767b\u5f55\u540d\u8282","[[adminlogin7]] login button":"\u767b\u5f55\u6309\u94ae","[[adminlogin7]] login fail":"\u767b\u5f55\u5931\u8d25","[[adminlogin7]] captcha":"\u9a8c\u8bc1\u7801","[[adminlogin7]] select language":"\u9009\u62e9\u8bed\u8a00","[[adminlogin7]] frontend preview":"\u524d\u7aef\u9884\u89c8","[[admin_1]] welcome":"\u6b22\u8fce","[[admin_1]] logout":"\u9000\u51fa","[[admin_1]] sort id":"\u6392\u5e8fID","[[admin_lang_1]] sort id":"\u6392\u5e8fID","please check your field":"\u8bf7\u68c0\u67e5\u4f60\u7684\u9886\u57df","this field is required.":"\u6b64\u5b57\u6bb5\u662f\u5fc5\u9700\u7684\u3002","[[admin_lang_1]] title":"\u6807\u9898","[[admin_lang_1]] label index":"\u6807\u7b7e\u6307\u6570","[[admin_lang_1]] create time":"\u521b\u5efa\u65f6\u95f4","[[admin_lang_1]] update time":"\u66f4\u65b0\u65f6\u95f4","[[admin_lang_1]] form action":"\u8868\u683c\u884c\u52a8","[[admin_lang_1]] create":"\u521b\u5efa","[[admin_lang_1]] submit":"\u63d0\u4ea4","[[admin_lang_1]] reset":"\u590d\u4f4d","[[admin_lang_1]] previous":"\u4e0a\u4e00\u9875","[[web]] \u66f4\u65b0\u9a57\u8b49\u78bc":"\u66f4\u65b0\u9a57\u8b49\u78bc","[[admin_lang_1]] \u4ea4\u6613\u6392\u884c\u524d20\u540d":"\u4ea4\u6613\u6392\u884c\u524d20\u540d","[[admin_lang_1]] status":"\u72b6\u6001","[[admin_lang_1]] date":"\u65e5","[[admin_lang_1]] full name":"\u5168\u540d","[[admin_lang_1]] phone":"\u7535\u8bdd","[[admin_lang_1]] fax":"\u4f20\u771f","[[admin_lang_1]] company name":"\u516c\u53f8\u540d\u79f0","[[admin_lang_1]] vat number":"\u589e\u503c\u7a0e\u53f7\u7801","[[admin_lang_1]] company phone":"\u516c\u53f8\u7535\u8bdd","[[admin_lang_1]] person in charge":"\u8d1f\u8d23\u4eba","[[admin_lang_1]] url":"\u7f51\u5740","[[admin_lang_1]] priority":"\u4f18\u5148","[[admin_lang_1]] change password":"\u66f4\u6539\u5bc6\u7801","[[admin_lang_1]] logout":"\u9000\u51fa\u767b\u5f55","[[admin_lang_1]] search":"\u641c\u5bfb","[[admin_lang_1]] search data":"\u641c\u5bfb\u8d44\u6599\u5185\u5bb9","[[admin_lang_1]] cancel search":"\u53d6\u6d88\u641c\u5bfb","[[admin_lang_1]] tools":"\u5de5\u5177","[[admin_lang_1]] welcome login":"\u6b22\u8fce\u767b\u5165EOB\u7ba1\u7406\u7cfb\u7edf","[[admin_lang_1]] member list":"\u4f1a\u5458\u660e\u7ec6","[[admin_lang_1]] member account":"\u4f1a\u5458\u5e10\u6237","[[admin_lang_1]] first contact":"\u8054\u7edc\u4eba1","[[admin_lang_1]] company address":"\u516c\u53f8\u5730\u5740","[[admin_lang_1]] company fax":"\u516c\u53f8\u4f20\u771f","[[admin_lang_1]] company email":"\u516c\u53f8\u7535\u5b50\u4fe1\u7bb1","[[admin_lang_1]] sales":"\u4e1a\u52a1","[[contact form]] name":"ggg","[[contact_form]] abc":"123"},"jp":{"[[adminlogin7]] login password":"Password","[[adminlogin7]] login account":"Username","[[adminlogin7]] keep login":"Stay signed in","[[adminlogin7]] default language":"Default Language","[[adminlogin7]] login section name":"Login","[[adminlogin7]] login button":"Login","[[adminlogin7]] login fail":"The username or password you entered is incorrect.","[[adminlogin7]] captcha":"Captcha Code","[[adminlogin7]] select language":"Select Language","[[adminlogin7]] frontend preview":"View Site","[[admin_1]] welcome":"Welcome","[[admin_1]] logout":"Logout","[[admin_1]] sort id":"Sort","[[admin_lang_1]] sort id":"Sort","please check your field":"Please check your field","this field is required.":"This field is required.","[[admin_lang_1]] update time":"Update Time","[[admin_lang_1]] create time":"Create Time","[[admin_lang_1]] label index":"Label Index","[[admin_lang_1]] title":"Title","[[admin_lang_1]] company english name":"Company English Name","[[admin_lang_1]] form action":"Action","[[admin_lang_1]] create":"Create","[[admin_lang_1]] submit":"Submit","[[admin_lang_1]] reset":"Reset","[[admin_lang_1]] previous":"Previous","[[admin_lang_1]] \u4ea4\u6613\u6392\u884c\u524d20\u540d":"Top 20 Trader","[[admin_lang_1]] status":"Status","[[admin_lang_1]] date":"Date","[[admin_lang_1]] full name":"Full name","[[admin_lang_1]] phone":"Phone","[[admin_lang_1]] fax":"Fax","[[admin_lang_1]] company name":"Company name","[[admin_lang_1]] vat number":"VAT Number","[[admin_lang_1]] company phone":"Company phone","[[admin_lang_1]] person in charge":"Person in charge","[[admin_lang_1]] url":"Url","[[admin_lang_1]] priority":"Priority","[[admin_lang_1]] product name":"Product Name","[[admin_lang_1]] image":"Image","[[admin_lang_1]] comments":"Comments","[[admin_lang_1]] description":"Description","[[adminlogin7]] login to your account":"Login to your account","[[admin_lang_1]] mobile":"Mobile","[[admin_lang_1]] home phone":"Home Phone","[[admin_lang_1]] company url":"Company Url","[[admin_lang_1]] sign date":"Sign Date","[[web]] \u66f4\u65b0\u9a57\u8b49\u78bc":"Update Captcha","[[admin_lang_1]] home":"Home","[[admin_lang_1]] change password":"Change Password","[[admin_lang_1]] logout":"Logout","[[admin_lang_1]] search":"Search","[[admin_lang_1]] search data":"Search Data","[[admin_lang_1]] cancel search":"Cancel Search","[[admin_lang_1]] tools":"Tools","[[admin_lang_1]] welcome login":"Welcome Login","[[admin_lang_1]] member list":"Member List","[[admin_lang_1]] member account":"Member Account","[[admin_lang_1]] first contact":"First Contact","[[admin_lang_1]] company address":"Company Address","[[admin_lang_1]] company fax":"Company Fax","[[admin_lang_1]] company email":"Company Email","[[admin_lang_1]] sales":"Sales","[[contact form]] name":"aaa","[[contact_form]] abc":"456"},"sp":{"[[adminlogin7]] login password":"Password","[[adminlogin7]] login account":"Username","[[adminlogin7]] keep login":"Stay signed in","[[adminlogin7]] default language":"Default Language","[[adminlogin7]] login section name":"Login","[[adminlogin7]] login button":"Login","[[adminlogin7]] login fail":"The username or password you entered is incorrect.","[[adminlogin7]] captcha":"Captcha Code","[[adminlogin7]] select language":"Select Language","[[adminlogin7]] frontend preview":"View Site","[[admin_1]] welcome":"Welcome","[[admin_1]] logout":"Logout","[[admin_1]] sort id":"Sort","[[admin_lang_1]] sort id":"Sort","please check your field":"Please check your field","this field is required.":"This field is required.","[[admin_lang_1]] update time":"Update Time","[[admin_lang_1]] create time":"Create Time","[[admin_lang_1]] label index":"Label Index","[[admin_lang_1]] title":"Title","[[admin_lang_1]] company english name":"Company English Name","[[admin_lang_1]] form action":"Action","[[admin_lang_1]] create":"Create","[[admin_lang_1]] submit":"Submit","[[admin_lang_1]] reset":"Reset","[[admin_lang_1]] previous":"Previous","[[admin_lang_1]] \u4ea4\u6613\u6392\u884c\u524d20\u540d":"Top 20 Trader","[[admin_lang_1]] status":"Status","[[admin_lang_1]] date":"Date","[[admin_lang_1]] full name":"Full name","[[admin_lang_1]] phone":"Phone","[[admin_lang_1]] fax":"Fax","[[admin_lang_1]] company name":"Company name","[[admin_lang_1]] vat number":"VAT Number","[[admin_lang_1]] company phone":"Company phone","[[admin_lang_1]] person in charge":"Person in charge","[[admin_lang_1]] url":"Url","[[admin_lang_1]] priority":"Priority","[[admin_lang_1]] product name":"Product Name","[[admin_lang_1]] image":"Image","[[admin_lang_1]] comments":"Comments","[[admin_lang_1]] description":"Description","[[adminlogin7]] login to your account":"Login to your account","[[admin_lang_1]] mobile":"Mobile","[[admin_lang_1]] home phone":"Home Phone","[[admin_lang_1]] company url":"Company Url","[[admin_lang_1]] sign date":"Sign Date","[[web]] \u66f4\u65b0\u9a57\u8b49\u78bc":"Update Captcha","[[admin_lang_1]] home":"Home","[[admin_lang_1]] change password":"Change Password","[[admin_lang_1]] logout":"Logout","[[admin_lang_1]] search":"Search","[[admin_lang_1]] search data":"Search Data","[[admin_lang_1]] cancel search":"Cancel Search","[[admin_lang_1]] tools":"Tools","[[admin_lang_1]] welcome login":"Welcome Login","[[admin_lang_1]] member list":"Member List","[[admin_lang_1]] member account":"Member Account","[[admin_lang_1]] first contact":"First Contact","[[admin_lang_1]] company address":"Company Address","[[admin_lang_1]] company fax":"Company Fax","[[admin_lang_1]] company email":"Company Email","[[admin_lang_1]] sales":"Sales","[[contact form]] name":"aaa","[[contact_form]] abc":"456"},"tr":{"[[adminlogin7]] login password":"Password","[[adminlogin7]] login account":"Username","[[adminlogin7]] keep login":"Stay signed in","[[adminlogin7]] default language":"Default Language","[[adminlogin7]] login section name":"Login","[[adminlogin7]] login button":"Login","[[adminlogin7]] login fail":"The username or password you entered is incorrect.","[[adminlogin7]] captcha":"Captcha Code","[[adminlogin7]] select language":"Select Language","[[adminlogin7]] frontend preview":"View Site","[[admin_1]] welcome":"Welcome","[[admin_1]] logout":"Logout","[[admin_1]] sort id":"Sort","[[admin_lang_1]] sort id":"Sort","please check your field":"Please check your field","this field is required.":"This field is required.","[[admin_lang_1]] update time":"Update Time","[[admin_lang_1]] create time":"Create Time","[[admin_lang_1]] label index":"Label Index","[[admin_lang_1]] title":"Title","[[admin_lang_1]] company english name":"Company English Name","[[admin_lang_1]] form action":"Action","[[admin_lang_1]] create":"Create","[[admin_lang_1]] submit":"Submit","[[admin_lang_1]] reset":"Reset","[[admin_lang_1]] previous":"Previous","[[admin_lang_1]] \u4ea4\u6613\u6392\u884c\u524d20\u540d":"Top 20 Trader","[[admin_lang_1]] status":"Status","[[admin_lang_1]] date":"Date","[[admin_lang_1]] full name":"Full name","[[admin_lang_1]] phone":"Phone","[[admin_lang_1]] fax":"Fax","[[admin_lang_1]] company name":"Company name","[[admin_lang_1]] vat number":"VAT Number","[[admin_lang_1]] company phone":"Company phone","[[admin_lang_1]] person in charge":"Person in charge","[[admin_lang_1]] url":"Url","[[admin_lang_1]] priority":"Priority","[[admin_lang_1]] product name":"Product Name","[[admin_lang_1]] image":"Image","[[admin_lang_1]] comments":"Comments","[[admin_lang_1]] description":"Description","[[adminlogin7]] login to your account":"Login to your account","[[admin_lang_1]] mobile":"Mobile","[[admin_lang_1]] home phone":"Home Phone","[[admin_lang_1]] company url":"Company Url","[[admin_lang_1]] sign date":"Sign Date","[[web]] \u66f4\u65b0\u9a57\u8b49\u78bc":"Update Captcha","[[admin_lang_1]] home":"Home","[[admin_lang_1]] change password":"Change Password","[[admin_lang_1]] logout":"Logout","[[admin_lang_1]] search":"Search","[[admin_lang_1]] search data":"Search Data","[[admin_lang_1]] cancel search":"Cancel Search","[[admin_lang_1]] tools":"Tools","[[admin_lang_1]] welcome login":"Welcome Login","[[admin_lang_1]] member list":"Member List","[[admin_lang_1]] member account":"Member Account","[[admin_lang_1]] first contact":"First Contact","[[admin_lang_1]] company address":"Company Address","[[admin_lang_1]] company fax":"Company Fax","[[admin_lang_1]] company email":"Company Email","[[admin_lang_1]] sales":"Sales","[[web]] \u6027\u5225":"Gender","[[contact form]] name":"aaa","[[contact_form]] abc":"456","[[web]] \u59d3\u540d":"Name","[[web]] \u7537":"Male","[[web]] \u5973":"Female","[[web]] \u96fb\u8a71":"Phone","[[web]] \u751f\u65e5":"Birthday","[[web]] \u5730\u5740":"Address","[[web]] \u610f\u898b":"Message","[[web]] \u8a8d\u8b49\u78bc":"Captcha Code","[[web]] \u516c\u53f8\u540d\u7a31":"Company Name","[[web]] \u50b3\u771f":"Fax","[[web]] \u5206\u6a5f":"Extension","[[web]] \u52a0\u5165\u8a62\u554f\u8eca":"Add Inquiry","[[web]] \u6578\u91cf":"Quantity","[[web]] \u5546\u54c1\u8aaa\u660e":"Product Description","[[web]] \u5546\u54c1\u898f\u683c":"Product Specifications","[[web]] \u56de\u5217\u8868":"Back to the list","[[web]] \u5df1\u52a0\u5165\u8a62\u554f\u8eca":"Added Inquiry","[[web]] \u522a\u9664":"Del","[[web]] \u70ba\u5fc5\u586b":"Fields marked with * are required","[[web]] \u5982\u679c\u60a8\u5c0d\u6211\u5011\u7684\u7522\u54c1\u6709\u4efb\u4f55\u554f\u984c\uff0c\u6b61\u8fce\u900f\u904e\u8aee\u8a62\u8868\u55ae\u8207\u6211\u5011\u806f\u7d61\u3002":"If you have any questions about our products, please feel free to contact us via our inquiry form.","[[web]] \u8acb\u586b\u5beb\u5728\u7dda\u8868\u683c\u8207\u6211\u5011\u806f\u7e6b\u3002":"Please fill out the online form to contact with us.","[[web]] \u9001\u51fa\u6210\u529f":"Send Success","[[web]] \u9a57\u8b49\u78bc\u932f\u8aa4":"Captcha Code Error","[[web]] \u4e0a\u4e00\u5247":"Prev","[[web]] \u4e0b\u4e00\u5247":"Next","[[web]] \u8acb\u8f38\u5165":"Please Input"}};