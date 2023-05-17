<?php if(isset($data[$ID])):?>
	<?php foreach($data[$ID] as $k => $v):?>
		<?php // newslist item start ------ ?>
		<div class="item">
			<div>
				<a href="<?php echo $v['url1']?>">
					<div class="itemImg"> <img src="<?php echo $v['pic']?>" <?php if(isset($v['img_alt'])):?> alt="<?php echo $v['img_alt']?>" <?php endif?> > </div>
				</a>
			</div>
			<div>
				<?php unset($_constant);eval('$_constant = '.strtoupper('seo_open').';');//#37700?>
				<?php if(isset($v['name']) and $v['name'] != '' && $_constant):// 我是分類 //#31510公司決議要隱藏分類 ?>
				<a href="<?php echo $v['url2']?>" class="itemInfo">
					<span><?php echo $v['name']?></span>
				</a>
				<?php endif?>
				<?php if(isset($v['name2']) and $v['name2'] != ''):?>
					<div class="itemTitle">
						<a href="<?php echo $v['url1']?>">
							<span><?php echo $v['name2']?></span>
						</a>
					</div>
				<?php endif?>
				<?php if(isset($v['item_name']) and $v['item_name'] != ''):?>
					<div class="itemTitle">
						<a href="<?php echo $v['url1']?>">
							<span><?php echo $v['item_name']?></span>
						</a>
					</div>
				<?php endif?>
				<?php if(isset($v['describe']) and $v['describe'] != '')://簡述?>
					<div class="itemContent">
						<?php echo $v['describe']?>
					</div>
				<?php endif?>
				<div class="Bbox_flexBetween">
					<?php if(0)://#34016 按鈕二選一?>
						<a class="item_btn" href="_i/assets/file/<?php echo $this->data['router_method']?>/<?php echo $v['file1']?>"><i class="fa fa-cloud-download"></i>下載</a>
					<?php else:?>
						<?php if(isset($v['url_inquiry']) and $v['url_inquiry'] != ''):?>
							<?php // 拿掉addItemAddCart，就會回到舊的加入詢問車的方式 2019-10-25?>
							<a href="<?php echo $v['url_inquiry']?>" class="itemAddCart addItemAddCart" data-name="<?php echo $v['name2']?>" ><i class="fa fa-info-circle"></i> <span><?php echo t('加入詢問車')?></span></a>
						<?php endif?>
					<?php endif?>

					<?php if(isset($v['price']) and $v['price'] > 0):?>
						<div class="itemPrice"> <?php echo $v['unit']?><span><?php echo number_format($v['price'])?></span> </div>
					<?php endif?>
				</div>
			</div>

		</div>
		<?php // newslist item end ------ ?>
	<?php endforeach?>
<?php endif?>

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
		$(".inquiry_info").attr('href','productinquiry_'+ml_key+'.php').show();		   
	});		 
	return false;
	});
</script>
