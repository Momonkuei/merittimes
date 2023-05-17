<?php if(0):// 這邊在 v4/layout/row 已經套好了，不需要處理?>
<!--後台文字編輯區-->
<div class="col-sm-12 editBox">
 <p>商品介紹文字，可針對商品分類做簡單描述，以下非正式文字，另眼仍這中先星他山可這的，生來常預度味家用有題臺樂，合里微之在完子與獎名路驗火歌氣不比。</p>
</div>
<!--後台文字編輯區 End-->
<?php endif?>


<div class="productListBlock productListStyle01">

<?php $row_inherit_start = $row_inherit_end = '';include 'view/system/row_inherit.php'?>

<?php if(isset($data[$ID])):?>
	<?php foreach($data[$ID] as $k => $v):?>
<?php //var_dump($v);die;?>
		<?php //echo $row_inherit_start?>
	<div class="col-6 col-md-4 col-sm-6 proItem">	
		<a href="<?php echo $v['url']?>">
			<div class="<?php echo $data['image_ratio'];//變數在source/core.php?> itemImgHover hoverEffect1"><?php //預設比例要到後台修改?>
				<img src="<?php echo $v['pic']?>" <?php if(isset($v['img_alt'])):?> alt="<?php echo $v['img_alt']?>" <?php endif?>>
			</div>
		</a>
		<?php unset($_constant);eval('$_constant = '.strtoupper('seo_open').';');//#37700?>
		<?php if(isset($v['name']) and $v['name'] != '' && $_constant):// 我是分類 //#31510公司決議要隱藏分類 ?>		
			<p class="subBlockTxt"><?php echo $v['name']?></p>
		<?php endif?>
		<?php if(isset($v['name2']) and $v['name2'] != ''):?>
			<div class="subBlockTitle"><?php echo $v['name2']?></div>
		<?php endif?>
		<div class="cartBox">
			<?php if(isset($v['url_inquiry']) and $v['url_inquiry'] != ''):?>
				<?php // 拿掉addItemAddCart，就會回到舊的加入詢問車的方式 2019-10-25?>
				<div class="cartBox_cart"><a href="<?php echo $v['url_inquiry']?>" class="addItemAddCart" data-name="<?php echo $v['name2']?>" ><i class="fa fa-info-circle" aria-hidden="true"></i><span><?php echo t('加入詢問')?></span></a></div>
			<?php endif?>

			<?php if(isset($v['price']) and $v['price'] > 0):?>
				<div class="cartBox_price"><span><?php echo $v['unit']?><?php echo number_format($v['price'])?></span></div>
			<?php endif?>
		</div>
	</div>
		<?php //echo $row_inherit_end?>
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
