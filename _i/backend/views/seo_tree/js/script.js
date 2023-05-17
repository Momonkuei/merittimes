$('.btn_expand').click(function(e){
  $(this).closest('li').children('ul').slideToggle();
  e.stopPropagation();
});

$('a').on('click',function(e){
	var _title = $(this).html();
	var seo_type = $(this).data('seo_type');
	var seo_item_id = $(this).data('seo_item_id');
	$("#_title").html(_title);
	$("#seo_type").val(seo_type);
	$("#seo_item_id").val(seo_item_id);

	//讀取資料
	$.get('backend.php?r=seo/getdata',{ seo_type: seo_type, seo_item_id: seo_item_id },function(data){
		console.log(data);	
		$("#seo_title").val(data.seo_title);
		$("#seo_script_name").val(data.seo_script_name);
		$("#seo_meta_keyword").val(data.seo_meta_keyword);
		$("#seo_meta_description").val(data.seo_meta_description);
	},"json");
});

$("#form_data").submit(function(e) {

    var form = $(this);
    var url = form.attr('action');

    var seo_type = $("#seo_type").val();
	var seo_item_id = $("#seo_item_id").val();

    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), // serializes the form's elements.
           success: function(data)
           {
           		//if(data==1){
           		//	alert('insert ok');
           		//	$('#'+seo_type+'_'+seo_item_id).css('color','blue');
           		//}else{
           		//	alert(data);
           		//}
           		$('#'+seo_type+'_'+seo_item_id).css('color','blue');
           		parent.jQuery.fancybox.getInstance().close();		 
           }
         });

    e.preventDefault(); // avoid to execute the actual submit of the form.
});

$("#delete").on('click',function(){
	var seo_type = $("#seo_type").val();
	var seo_item_id = $("#seo_item_id").val();
	if(confirm('確認要移除該資料?')){
		$.get('backend.php?r=seo/deldata',{ seo_type: seo_type, seo_item_id: seo_item_id },function(data){
			if(data==1){
	           	//alert('delete ok');
	           	$('#'+seo_type+'_'+seo_item_id).css('color','');
	           	parent.jQuery.fancybox.getInstance().close();
	        }
		});
	}

});

// $('.branch .tree li a').click(function(e){
//   // var i = $(this).parents('.tree').next('ul').index();//当前索引值
//   // alert(i+1);
//
//   // $( "ul" ).each(function( i ) {
//   //   alert(i);
//   // });
//   var str = $(this).parents('.branch').children('ul').index();
//   alert(str);
// });
