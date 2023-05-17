<?php if(0):// 這邊在 v4/layout/row 已經套好了，不需要處理?>
<!--後台文字編輯區-->
<div class="col-sm-12 editBox">
 <p>商品介紹文字，可針對商品分類做簡單描述，以下非正式文字，另眼仍這中先星他山可這的，生來常預度味家用有題臺樂，合里微之在完子與獎名路驗火歌氣不比。</p>
</div>
<!--後台文字編輯區 End-->
<?php endif?>



<!--原V3產品列表頁(野寶樣式)，選單功能請參考http://www.buyersline.com.tw/demo/RWDDemo/Web/01/products.php?type=21-->
<!--選單有寫好.active(亮燈)樣式，請在相對應頁面的主選單和側選單的li元素加入class="active"-->
<div class="productListStyle08">
  <!--上方選單區域-->
  <div class="productTopMenu">
    <!--產品主選單-->
    <div>
      <ul class="productMainMenu">
        <li><a href="">產品一</a></li>
        <li><a href="">產品二</a></li>
        <li><a href="">產品三</a></li>
      </ul>
    </div>
    <!--產品主選單 End-->
    <!--產品次分類--->
    <div>
      <ul class="productSubMenu">
        <li><a href="">全部產品</a></li>
        <li><a href="">分類<span class="num">(3)</span></a></li>
        <li><a href="">分類<span class="num">(12)</span></a></li>
        <li><a href="">分類<span class="num">(2)</span></a></li>
      </ul>
    </div>
    <!--產品次分類 End--->
  </div>
  <!--上方選單區域 End-->
  <!-- 下方產品列表區域-->
  <div class="productListBlock">

    <div class="proItem">
      <div class="proItemBorder">
        <a href="">
          <div class="itemImg">
            <img src="https://via.placeholder.com/400x600" alt="">
          </div>
        </a>
      </div>
      <div class="productBrief">
        <div class="subBlockTitle">商品名稱</div>
      </div>
    </div>

    <div class="proItem">
      <div class="proItemBorder">
        <a href="">
          <div class="itemImg"><img src="_i/assets/upload/product/45b1b5e3db54c56ee7691d5ee20e7e71.jpg" alt=""></div>
        </a>
      </div>
      <div class="productBrief">
        <div class="subBlockTitle">商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱</div>
      </div>
    </div>

    <div class="proItem">
      <div class="proItemBorder">
        <a href="">
          <div class="itemImg"><img src="https://via.placeholder.com/400x600" alt=""></div>
        </a>
      </div>
      <div class="productBrief">
        <div class="subBlockTitle">商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱</div>
      </div>
    </div>

    <div class="proItem">
      <div class="proItemBorder">
        <a href="">
          <div class="itemImg"><img src="_i/assets/upload/product/45b1b5e3db54c56ee7691d5ee20e7e71.jpg" alt=""></div>
        </a>
      </div>
      <div class="productBrief">
        <div class="subBlockTitle">商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱</div>
      </div>
    </div>

    <div class="proItem">
      <div class="proItemBorder">
        <a href="">
          <div class="itemImg"><img src="https://via.placeholder.com/400x600" alt=""></div>
        </a>
      </div>
      <div class="productBrief">
        <div class="subBlockTitle">商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱</div>
      </div>
    </div>

    <div class="proItem">
      <div class="proItemBorder">
        <a href="">
          <div class="itemImg"><img src="https://via.placeholder.com/400x600" alt=""></div>
        </a>
      </div>
      <div class="productBrief">
        <div class="subBlockTitle">商品名稱商品名稱商品名稱商品名稱商品名稱商品名稱</div>
      </div>
    </div>

  </div>
  <!-- 下方產品列表區域-->
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
  var _text1 = t.get('已加入詢問','tw');  
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