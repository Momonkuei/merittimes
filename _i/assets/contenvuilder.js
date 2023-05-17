var domain = 'https://image.buyersline.com.tw';

var ifrm = document.getElementById('cbiframe').contentWindow;

$('#cbiframe').attr('src',domain+'/contenvuilder/');

function openif(t){

        var content_old = CKEDITOR.instances[t].getData();
        
        ifrm.postMessage(disdiv(content_old),domain); 

        $('#buyeditor').hide();
        $('#cbiframe').show();
        // $('#ctidx').val(t); //當前範本id
}
    //與對方約好的 回傳值
    if (typeof window.addEventListener != "undefined") {
        window.addEventListener('message',function(event) {
            if(event.data=="=@cancel@=")            {
                if(confirm("您確認要取消編輯?!")){
                    $('#cbiframe').hide();
                    $('#buyeditor').show();
                }
            }
            else
            {
                // if(event.data!=''){
                    // console.log(event.data); //test ok
                if(event.origin != domain) return;                   
                save() ;
                // }
                
            }
        },false);
    }
    else  //for ie
    {
        window.attachEvent("message", function(event) {
            if(event.data=="=@cancel@=")            {
                if(confirm("您確認要取消編輯?!")){
                    $('#cbiframe').hide();
                    $('#buyeditor').show();
                }
            }
            else
            {
                if(event.origin != domain) return;               
                save() ;
            }
        });
    }



function save() {
        //Save all images first
    //     $("#ctarea").saveimages({
    //        // handler: 'https://cartdemo4-1.odo.tw/WDN15400/about/saveimg',
    //         onComplete: function () {
    //     		ctidx = $('#ctidx').val() ;
				// CKEDITOR.instances[ctidx].setData(adddiv($("#ctarea").html()));
    //         }
    //     });

        
        
        // $("#ctarea").data('saveimages').save();

        $('#detail').html(event.data) ;
        CKEDITOR.instances["detail"].setData(event.data);

        $("html").fadeOut(2000,function(){
			$('#cbiframe').hide();
			$('#buyeditor').show();
			$(this).show();
        });
 }

function disdiv(str) {
        //         var disstr = /src\=\"\/upload/gi;//判斷取代正規表達式參數
        // var disstr2 = /src\=\"\/images/gi;//判斷取代正規表達式參數
        // str = str.replace(disstr, 'src\=\"https://cartdemo4-1.odo.tw/upload');//取代網址路徑
        // str = str.replace(disstr2, 'src\=\"https://cartdemo4-1.odo.tw/images');//取代網址路徑
        // var password = "";
        // $.ajax({
        //     type: "get",
        //     async: false,
        //     url:  'https://cartdemo4-1.odo.tw/WDN15400/about/getps',
        //     data: {},
        //     success: function(resault) {
        //         password = resault ;
        //     },
        //     error: function(){
        //         alert("網頁出現重大錯誤，請聯絡管理人員!") ;
        //         return ;
        //     }
        // });
        // if(str.indexOf('<div class="is-container-in">')==0)
        // {
        //     str = str.trim() ;
        //     str = str.slice(29) ;
        //     str = str.slice(0,-6) ;
        // }
        // str = password + str ;
        return str ;
}

// function adddiv(str) {
//     var addstr = /src\=\"https\:\/\/cartdemo4-1.odo.tw\/upload/gi;//判斷取代正規表達式參數
//     var addstr2 = /src\=\"https\:\/\/cartdemo4-1.odo.tw\/images/gi;//判斷取代正規表達式參數
//     str = str.replace(addstr, 'src\=\"\/upload');//取代網址路徑
//     str = str.replace(addstr2, 'src\=\"\/images');//取代網址路徑
//     str = '<div class="is-container-in">'+str+"</div>";
//     return str ;
// }