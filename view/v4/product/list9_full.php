<?php if(0):// 這邊在 v4/layout/row 已經套好了，不需要處理?>
<!--後台文字編輯區-->
<div class="col-sm-12 editBox">
 <p>商品介紹文字，可針對商品分類做簡單描述，以下非正式文字，另眼仍這中先星他山可這的，生來常預度味家用有題臺樂，合里微之在完子與獎名路驗火歌氣不比。</p>
</div>
<!--後台文字編輯區 End-->
<?php endif?>



<!--原V3產品列表頁(太立樣式)-->
<!--productListStyle09_full產品列表頁版型09滿版無側選單-->
<div class="productListBlock productListStyle09 productListStyle09_full" l="layer" ls="lll">

  <div class="proItem" l="list" >
    <a href="{/url/}">
      <div class="<?php echo $data['image_ratio'];//變數在source/core.php?> itemImgHover hoverEffect1"><img src="{/pic1_/}" alt=""></div>
      <div class="productBrief"><div class="leftLine"></div><div class="subBlockTitle">{/name/}</div></div>
    </a>
  </div>

  <div class="proItem">
    <a href="">
      <div class="itemImg itemImgHover hoverEffect1">
        <img src="https://via.placeholder.com/400x600" alt="">
      </div>
      <div class="productBrief"><div class="leftLine"></div><div class="subBlockTitle">商品名稱</div></div>
    </a>
  </div>

  <div class="proItem">
    <a href="">
      <div class="itemImg itemImgHover hoverEffect1"><img src="_i/assets/upload/product/45b1b5e3db54c56ee7691d5ee20e7e71.jpg" alt=""></div>
      <div class="productBrief"><div class="leftLine"></div><div class="subBlockTitle">商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱</div></div>
    </a>
  </div>

  <div class="proItem">
    <a href="">
      <div class="itemImg itemImgHover hoverEffect1"><img src="https://via.placeholder.com/400x600" alt=""></div>
      <div class="productBrief"><div class="leftLine"></div><div class="subBlockTitle">商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱</div></div>
    </a>
  </div>

  <div class="proItem">
    <a href="">
      <div class="itemImg itemImgHover hoverEffect1"><img src="_i/assets/upload/product/45b1b5e3db54c56ee7691d5ee20e7e71.jpg" alt=""></div>
      <div class="productBrief"><div class="leftLine"></div><div class="subBlockTitle">商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱</div></div>
    </a>
  </div>

  <div class="proItem">
    <a href="">
      <div class="itemImg itemImgHover hoverEffect1"><img src="https://via.placeholder.com/400x600" alt=""></div>
      <div class="productBrief"><div class="leftLine"></div><div class="subBlockTitle">商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱</div></div>
    </a>
  </div>

  <div class="proItem">
    <a href="">
      <div class="itemImg itemImgHover hoverEffect1"><img src="https://via.placeholder.com/400x600" alt=""></div>
      <div class="productBrief"><div class="leftLine"></div><div class="subBlockTitle">商品名稱</div></div>
    </a>
  </div>

</div>








<?php if(0):?>
<!-- 詢問車新流程
<a href="javascript:;" class="itemAddCart addItemAddCart"><i class="fa fa-info-circle"></i> <span>加入詢問車</span></a>
-->
<?php endif?>
<script text="text/javascript" m="body_end">
  $(".addItemAddCart").click(function(){  
  var _href = $(this).attr('href');   
  var _name = $(this).data('name');
  var _text1 = t.get('已加入詢問車','tw');  
  var _text2 = t.get('請點選這裡前往詢問車','tw');  
  // var _mod = '<?php echo $this->data['router_method'];?>';
  $.get(_href).done(function( data ) {
    $.toast({
        heading:_name+' <br/>'+_text1,
        // text:'<a href="'+_mod+'inquiry_'+ml_key+'.php">'+_text2+'</a>',
        text:'<a href="productinquiry_'+ml_key+'.php">'+_text2+'</a>',
        icon:'success',
        loader:false,
        hideAfter: 5000,
        allowToastClose: true,
        position: {
          right:15,
          bottom:30
        }
      });
    // $(".inquiry_info").attr('href',_mod+'inquiry_'+ml_key+'.php').show();       
    $(".inquiryInfo").attr('href','productinquiry_'+ml_key+'.php').show();       
  });    
  return false;
  });
</script>
