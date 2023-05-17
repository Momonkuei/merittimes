<?php if(isset($data[$ID])):?>
	<?php $product = $data[$ID]['items']?>
	<?php $images_big = $data[$ID]['big']?>
	<?php $images_small = $data[$ID]['small']?>

	<div>
		<div>

			<?php 
			// #34410
			unset($_constant);
			eval('$_constant = '.strtoupper('seo_open').';');
			if($_constant){
				$_sptxt = 'h1';
			}else{
				$_sptxt = 'div';
			}
			?>

			<div class="flexCenter">
				<<?php echo $_sptxt?> class="itemTitle" id="_itemTitle"><?php echo $product['name']?></<?php echo $_sptxt?>><br/>
				<div class="itemTitle"><?php echo $product['item_name']?></div>
			</div>

			<div class="w600px">
				<div class="itemSlick">
					<?php if(isset($images_big)):?>
						<?php foreach($images_big as $k => $v):?>
							<div><a class="swipebox" rel="proShow" href="<?php echo $v['pic']?>"><div class="itemImg"><img src="<?php echo $v['pic']?>"></div></a></div>
						<?php endforeach?>
					<?php endif?>

				</div>

			<?php if(isset($images_small) && count($images_small) > 1)://#32497?>
				<div class="itemSlickNav w300px" style="margin:auto;">			
						<?php foreach($images_small as $k => $v):?>
							<div><div class="itemImg"><img src="<?php echo $v['pic']?>"></div></div>
						<?php endforeach?>
				</div>
			<?php endif?>



				<?php if(isset($product['price']) and $product['price'] > 0):?>
					<div class="itemPrice"><?php echo $product['unit']?><?php echo number_format($product['price'])?></div>
				<?php endif?>
				<div class="itemForm">
					<form action="save.php" method="get" class="Bbox_flexBetween" id="idForm">

						<?php if(0):// 不要數量的話，請打開這裡?>
							<?php if(isset($product['inquiry']) and !empty($product['inquiry'])):?>
								<?php foreach($product['inquiry'] as $k => $v):?>
									<?php if(preg_match('/^(url)$/', $k)):?><?php continue?><?php endif?>
									<input type="hidden" name="<?php echo $k?>" value="<?php echo $v?>" />
								<?php endforeach?>
							<?php endif?>
						<?php endif?>

						<div class="">
							<div>
								<?php if(1):// 要／不要數量?>
									<div class="formItem">
										<label><?php echo t('數量')?></label>
										<div class="numSet">
											<button class="minus">-</button><input type="text" name="amount" value="1" /><button class="add">+</button>
										</div>
										<?php if(isset($product['inquiry']) and !empty($product['inquiry'])):?>
											<?php foreach($product['inquiry'] as $k => $v):?>
												<?php if(preg_match('/^(url|amount)$/', $k)):?><?php continue?><?php endif?>
												<input type="hidden" name="<?php echo $k?>" value="<?php echo $v?>" />
											<?php endforeach?>
										<?php endif?>
									</div>
								<?php endif?>
							</div>
						</div>
						<div>
							<button><i class="fa fa-info-circle"></i><?php echo t('加入詢問車')?></button>
						</div>

<meta property="og:url"           content="<?php echo FRONTEND_DOMAIN.$_SERVER['REQUEST_URI']?>" m="head_end" />
<meta property="og:type"          content="website"  m="head_end" />
<meta property="og:title"         content="<?php echo $product['name']?>"  m="head_end" />
<meta property="og:description"   content="<?php echo $product['name2']?>"  m="head_end"  />
<?php if(!empty($images_big)):?>
	<meta property="og:image"         content="<?php echo FRONTEND_DOMAIN.'/'.$images_big[0]['pic']?>"  m="head_end"  />
<?php endif?>

						<div>
							<iframe src="https://www.facebook.com/plugins/share_button.php?href=http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>&layout=button&size=large&mobile_iframe=true&width=66&height=28&appId" width="66" height="28" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>

<?php endif?>

<?php if(0):?><!-- body_end -->
<script type="text/javascript">
function numCal(calType,nowVal){

	if(calType=="-"){
		var newVal=parseInt(nowVal)-1;
		newVal=(newVal<=0)?1:newVal;
	}
	if(calType=="+"){
		var newVal=parseInt(nowVal)+1;
	}

	return newVal;
}
$(".numSet .minus").click(function(){
	var nowVal=$(this).siblings("input").val();
	$(this).siblings("input").val(numCal("-",nowVal));
	return false;
});
$(".numSet .add").click(function(){
	var nowVal=$(this).siblings("input").val();
	$(this).siblings("input").val(numCal("+",nowVal));
	return false;
});

$("#idForm").submit(function(e) {

    var form = $(this);
    var url = form.attr('action');
  
	var _name = $('#_itemTitle').html();
	var _text1 = t.get('已加入詢問車','tw');	
	var _text2 = t.get('請點選這裡前往詢問車','tw');	
	// var _mod = '<?php echo str_replace('detail','',$this->data['router_method']);?>';

    $.ajax({
           type: "GET",
           url: url,
           data: form.serialize(), // serializes the form's elements.
           success: function(data)
           {
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
           }
         });

    e.preventDefault(); // avoid to execute the actual submit of the form.
});
</script>
<?php endif?><!-- body_end -->
