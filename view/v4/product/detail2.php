<?php if(isset($data[$ID])):?>
	<?php $product = $data[$ID]['items']?>
	<?php $images_big = $data[$ID]['big']?>
	<?php $images_small = $data[$ID]['small']?>

	<meta property="og:url"           content="<?php echo FRONTEND_DOMAIN.$_SERVER['REQUEST_URI']?>" m="head_end" />
	<meta property="og:type"          content="website"  m="head_end" />
	<meta property="og:title"         content="<?php echo $product['name']?>"  m="head_end" />
	<meta property="og:description"   content="<?php echo strip_tags($product['detail'])?>"  m="head_end"  />
	<?php if($images_big[0]['pic']!=''):?>
		<meta property="og:image"         content="<?php echo FRONTEND_DOMAIN.'/'.$images_big[0]['pic']?>"  m="head_end"  />
	<?php else:?>
		<meta property="og:image"         content="<?php echo FRONTEND_DOMAIN?>/images/fb_share.jpg" m="head_end"/>
	<?php endif?>

	<div class="prod_blk2 contBlock_600">
	  <div class="row prod_slider">
				<div class="col-lg-12">
					<div class="slider-for">
						<?php if(isset($images_small)):?>
							<?php foreach($images_small as $k => $v):?>
								<div>
									<div class="<?php echo $data['image_ratio'];//變數在source/core.php?> "><img src="<?php echo $v['pic']?>" alt="<?php echo $v['name']?>"></div>
								</div>
							<?php endforeach?>
						<?php endif?>
					</div>
				</div>
				<div class="col-lg-12 M_hide slideNavBottom">
					<div class="slider-nav">
						<?php if(isset($images_big)):?>
							<?php foreach($images_big as $k => $v):?>
								<div>
									<div class="<?php echo $data['image_ratio'];//變數在source/core.php?> "><img src="<?php echo $v['pic']?>" alt="<?php echo $v['name']?>"></div>
								</div>
							<?php endforeach?>
						<?php endif?>
					</div>
				</div>
				<div class="col-lg-12">
			
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
		<<?php echo $_sptxt?> class="prod_title itemTitle"><?php echo $product['name']?></<?php echo $_sptxt?>>

		<?php if(0):?>
		<div class="prod_price">
		  <small>NT$450</small>
		  <span>NT$250</span>
		</div><!-- .prod_price -->
		<?php endif?>

		<?php if(0):?>
		<div class="col-lg-6">
		  <label><?php echo t('規格')?></label>
		  <select name="xxx">
			<?php if(isset($specs)):?>
				<?php foreach($specs as $k => $v):?>
					<option value="<?php echo $v['value']?>" name2="<?php echo $v['name2']?>" price="<?php echo $v['price_format_ds']?>" price2="<?php echo $v['price2_format_ds']?>" <?php if(isset($v['disabled'])):?> disabled="disabled" <?php endif?> <?php if(isset($v['selected'])):?> selected="selected" <?php endif?> ><?php echo $v['name']?></option>
				<?php endforeach?>
			<?php endif?>
		  </select>
		</div>
		<?php endif?>

		<?php if(1):// 不要詢問車的話，請改成0?>
		<div class="itemForm">
			<form action="save.php" method="get" id="idForm">

				<?php if(0):// 不要數量的話，請改成1?>
					<?php if(isset($product['inquiry']) and !empty($product['inquiry'])):?>
						<?php foreach($product['inquiry'] as $k => $v):?>
							<?php if(preg_match('/^(url)$/', $k)):?><?php continue?><?php endif?>
							<input type="hidden" name="<?php echo $k?>" value="<?php echo $v?>" />
						<?php endforeach?>
					<?php endif?>
				<?php endif?>

				<?php if(1):// 要／不要數量?>
					<div class="prod_num">
					  <p><?php echo t('數量')?></p>
					  <div class="number-spinner">
						<span class="ns-btn">
							  <a class="minus" data-dir="dwn"><span class="icon-minus"></span></a>
						</span>
						<input type="text" class="pl-ns-value" name="amount" value="1" maxlength=2>
						<span class="ns-btn">
							  <a class="add" data-dir="up"><span class="icon-plus"></span></a>
						</span>
					  </div>
					</div><!-- .prod_num -->
					<?php if(isset($product['inquiry']) and !empty($product['inquiry'])):?>
						<?php foreach($product['inquiry'] as $k => $v):?>
							<?php if(preg_match('/^(url|amount)$/', $k)):?><?php continue?><?php endif?>
								<input type="hidden" name="<?php echo $k?>" value="<?php echo $v?>" />
						<?php endforeach?>
					<?php endif?>
				<?php endif?>

				<div class="prod_btn">
				  <button class="btn-orange"><?php echo t('加入詢問')?></button>
					<?php if(0):?>
						<button class="btn-orange"><?php echo t('加入購物車')?></button>
						<button class="btn-pink"><?php echo t('立即結帳')?></button>
					<?php endif?>
				</div><!-- .prod_btn -->
			</form>
		</div>
		<?php endif?>

		<?php if(isset($product['name2']) && $product['name2']!=''):?>
		<div class="prod_info">
		  <div class="prodInfo_title"><?php echo t('特色')?></div>
			<?php echo $product['name2']?>
		</div><!-- .prod_info -->
		<?php endif?>
			</div>
		</div>
	  </div><!-- .prod_slider -->

	<?php if(0)://tab第二個樣式?>
		  <div class="tabList tabListStyle02 tabList_center">
			<a href="#_" class="tabLabel active"><?php echo t('說明')?></a>
			<div class="tabContent">
				<div class="editorBlock">
					商品簡述，簡單敘述商品特性即可。以下非正式文字，題方進記民往際，什上收做品下但女寫只老舉可美師急人著滿在東自定：界色制眼制本環品率自希影的、自對就單。藝麼類。
					著氣藝與學放雙問容定縣自，一過做實，可的西然可是化紅模指總那傷洋歡所專下線了童。們賣談銀與速成在到的機有學活不音。
					種的這頭治！清畫山十投都中萬賽定天如放能母，失灣作起夫西還成制他兒平：強兩華到的上們容須時下邊們成五；一車來發可時，了上種！速教方們視信議看力案節。<br><br>

					比兒件認拉同顧頭：消依重於叫我雨接市、孩價童選選望……險種面？出外般色去發覺人處在現友主天速能上作臺還本據要這容，母排性全該我然手中來了府非看奇雲研們常！這時約提局天！電實走？知公生，能天來不機能，時股教葉力皮心思支類，工子生爾，興往銷；類分解否國的建過的比國了。
					斯衣親！論千們學亞展他很怕定野命中，晚乎長運們有我起的一於，長特白勢最水興全士我學處發他運得天一站入子育來又麼的個走學。
					體有父，業時發來將故得特老可，有望例省河草響、已整作滿電長事可說告買黃以過金一如王見期取年成著出全說息充流表令廠取，你方人的制企力復化越必本長母利座我朋劇不了南公內的自上利變！
				</div>
			</div>
			<a href="#_" class="tabLabel"><?php echo t('規格')?></a>
			<div class="tabContent">
				<div class="editorBlock">
					商品規格敘述
				</div>
			</div>
		</div><!-- .tabListStyle02 -->
	<?php endif?>
	<?php $_active = '';?>
	<?php if( (isset($product['content1']) and $product['content1'] != '') or (isset($product['content2']) and $product['content2'] != '') )://#31796?>
		<div class="tabList tabList_center">
		<?php if(isset($product['content1']) and $product['content1']!='')://#31796?>
			<?php $_active = 'active';?>
			<a href="#_" class="tabLabel <?php echo $_active?>"><?php echo t('說明')?></a>
			<div class="tabContent">
				<div class="editorBlock">
					<?php echo $product['content1']?>
				</div>
			</div>
		<?php endif?>

		<?php if(isset($product['content2']) and $product['content2']!='')://#31796?>
			<?php if($_active==''){ $_active = 'active';}else{ $_active = '--'; }?>
			<a href="#_" class="tabLabel <?php echo $_active?>"><?php echo t('規格')?></a>
			<div class="tabContent">
				<div class="editorBlock">
					<?php echo $product['content2']?>
				</div>
			</div>
		<?php endif?>
		
	  </div><!-- .tabList -->
	<?php endif?>
		<?php if(isset($data[$router_method.'_return_url'])):?>
		<div class="col-sm-12 text-center"><a class="btn-cis1" href="<?php echo $data[$router_method.'_return_url']?>"><i class="fa fa-reply"></i><?php echo t('回列表')?></a></div>		
	<?php endif?>
	</div><!-- .prod_blk -->
	
<?php endif?>

<?php if(0):?><!-- body_end -->
<script type="text/javascript" >
$(".number-spinner .minus").click(function(){
	var nowVal=$(this).parent().parent().find(".pl-ns-value").val();
	if(nowVal <= 1){
		nowVal = 1;
	}
	$(this).parent().parent().find(".pl-ns-value").val(nowVal);
	return false;
});
$(".number-spinner .add").click(function(){
	var nowVal=$(this).parent().parent().find(".pl-ns-value").val();
	$(this).parent().parent().find(".pl-ns-value").val(nowVal);
	return false;
});
$("#idForm").submit(function(e) {

    var form = $(this);
    var url = form.attr('action');
  
	var _name = $('.itemTitle').html();
	var _text1 = t.get('已加入詢問','tw');	
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
