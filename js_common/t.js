/*
2017-11-10 李哥早上說可以開發js的版本
使用方式
<script type="text/javascript">
	var ml_key = 'en'; // 當前語系
</script>
<script src="t.js"></script>
<script type="text/javascript">
	alert(t.get('可以下班了嗎？','tw'));
</script>
 */

// https://stackoverflow.com/questions/8567114/how-to-make-an-ajax-call-without-jquery#18078705
var ttx = {};
ttx.x = function () {
    if (typeof XMLHttpRequest !== 'undefined') {
        return new XMLHttpRequest();
    }
    var versions = [
        "MSXML2.XmlHttp.6.0",
        "MSXML2.XmlHttp.5.0",
        "MSXML2.XmlHttp.4.0",
        "MSXML2.XmlHttp.3.0",
        "MSXML2.XmlHttp.2.0",
        "Microsoft.XmlHttp"
    ];

    var xhr;
    for (var i = 0; i < versions.length; i++) {
        try {
            xhr = new ActiveXObject(versions[i]);
            break;
        } catch (e) {
        }
    }
    return xhr;
};

ttx.send = function (url, callback, method, data, async) {
    if (async === undefined) {
        async = true;
    }
    var x = ttx.x();
    x.open(method, url, async);
    x.onreadystatechange = function () {
        if (x.readyState == 4) {
            callback(x.responseText)
        }
    };
    if (method == 'POST') {
        x.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    }
    x.send(data)
	return x.responseText;
};

ttx.get = function (url, data, callback, async) {
    var query = [];
    for (var key in data) {
        query.push(encodeURIComponent(key) + '=' + encodeURIComponent(data[key]));
    }
    ttx.send(url + (query.length ? '?' + query.join('&') : ''), callback, 'GET', null, async)
};

ttx.post = function (url, data, callback, async) {
    var query = [];
    for (var key in data) {
        query.push(encodeURIComponent(key) + '=' + encodeURIComponent(data[key]));
    }
    return ttx.send(url, callback, 'POST', query.join('&'), async)
};
function Languageb(multilanguage){
	this.ml_key = multilanguage;
	this.get = getb;
}
function getb(text, source){
	// var ggg = labels2[this.ml_key][text.toLowerCase()];
	// if(source == this.ml_key){
	// 	return text;
	// } else if(ggg == undefined){
	// 	var aaa = ttx.post('/translate.php', {
	// 			t:'', 
	// 			text: text,
	// 			source: source,
	// 			target: this.ml_key
	// 		}, 
	// 		function(responseText) {
	// 			return responseText;
	// 		},
	// 		false // non async
	// 	);
	// 	return aaa;
	// } else {
	// 	return text;
	// }

	// var aaa = ttx.post('/translate.php', {
	// 		t:'', 
	// 		text: text,
	// 		source: source,
	// 		target: this.ml_key
	// 	}, 
	// 	function(responseText) {
	// 		return responseText;
	// 	},
	// 	false // non async
	// );
	// return aaa;

	var ggg = labels2[this.ml_key][text.toLowerCase()];
	if(source == this.ml_key){
		return text;
	} else if(ggg == undefined){
	 	return text;
	} else {
		return ggg;
	}

}
var t = new Languageb(ml_key);

// alert(t.get('圖片'));
