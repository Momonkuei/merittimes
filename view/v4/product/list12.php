<?php if(0):// 這邊在 v4/layout/row 已經套好了，不需要處理?>
<!--後台文字編輯區-->
<div class="col-sm-12 editBox">
 <p>商品介紹文字，可針對商品分類做簡單描述，以下非正式文字，另眼仍這中先星他山可這的，生來常預度味家用有題臺樂，合里微之在完子與獎名路驗火歌氣不比。</p>
</div>
<!--後台文字編輯區 End-->
<?php endif?>


<?php //原v3產品列表頁(單排圖文左右排列)，參考http://www.buyersline.com.tw/demo/RWDDemo/Web/01/products.php?type=20 ?>
<div class="productListBlock productListStyle12">

<?php if(isset($data[$ID])):?>
	<?php foreach($data[$ID] as $k => $v):?>

	<?php if($k%2==0):?>
		<div class="col-sm-12 proItem">
			<div class="imgBox">
			<a href="<?php echo $v['url']?>"><div class="<?php echo $data['image_ratio'];//變數在source/core.php?> itemImgHover hoverEffect1">
				<img src="<?php echo $v['pic']?>" <?php if(isset($v['img_alt'])):?> alt="<?php echo $v['img_alt']?>" <?php endif?>></div>
			</a>
			</div>
			<div class="productBrief">
				<?php if(isset($v['name2']) and $v['name2'] != ''):?>
				<a class="subBlockTitle" href="<?php echo $v['url']?>"><?php echo $v['name2']?></a>
				<?php endif?>
				<div class="underLine"></div>
				<div class="productBriefText"><?php echo nl2br($v['detail'])?></div>
			</div>
		</div>
	<?php else:?>
		<div class="col-sm-12 proItem">
			<div class="imgBox"><a href="<?php echo $v['url']?>"><div class="<?php echo $data['image_ratio'];//變數在source/core.php?> itemImgHover hoverEffect1"><img src="<?php echo $v['pic']?>" <?php if(isset($v['img_alt'])):?> alt="<?php echo $v['img_alt']?>" <?php endif?> onerror="javascript:this.src='images_v4/default.png';img.onerror=null;"></div></a></div>
			<div class="productBrief">
				<?php if(isset($v['name2']) and $v['name2'] != ''):?>
				<a class="subBlockTitle" href="<?php echo $v['url']?>"><?php echo $v['name2']?></a>
				<?php endif?>
				<div class="underLine"></div>
				<div class="productBriefText"><?php echo nl2br($v['detail'])?></div>
			</div>
		</div>
	<?php endif?>
	<?php endforeach?>
<?php endif?>

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
