<!-- // DATA2:SINGLE -->
<?php $item = $data[$ID]?>

<?php $${CONNECT_A} = $ID?>
<!-- // DATA2:MULTI -->
<?php $small_images = $data[$ID]?>
<!-- // DATA2:MULTI -->
<?php $increase_purchases = $data[$ID] // 加價購?>
<!-- // DATA2:MULTI -->
<?php $relations = $data[$ID]?>
<!-- // DATA2:MULTI -->
<?php $specs = $data[$ID];//A方案在使用的?>

<meta property="og:url"           content="<?php echo FRONTEND_DOMAIN.$_SERVER['REQUEST_URI']?>" m="head_end" />
<meta property="og:type"          content="website"  m="head_end" />
<meta property="og:title"         content="<?php echo $item['name']?>"  m="head_end" />
<meta property="og:description"   content="<?php echo strip_tags($item['detail'])?>"  m="head_end"  />
<?php if($small_images[0]['pic']!=''):?>
	<meta property="og:image"         content="<?php echo FRONTEND_DOMAIN.'/'.$small_images[0]['pic']?>"  m="head_end"  />
<?php else:?>
	<meta property="og:image"         content="<?php echo FRONTEND_DOMAIN?>/images/fb_share.jpg" m="head_end" />
<?php endif?>
<?$no_num=false;?>

<?php
/*
 * data2 struct
 * single:1 => 產品
 * multi:1 => 小圖(default)
 * multi:2 => 加價購
 * multi:3 => 相關產品
 */
?>

<div class="prod_blk">
  <div class="row prod_slider">
	<div class="col-lg-1 M_hide">
	<div class="slider-nav">
		<?php if(isset($small_images)):?>
			<?php foreach($small_images as $k => $v):?>
				<div>
					<img src="<?php echo $v['pic']?>" alt="<?php echo $v['name']?>">
				</div>
			<?php endforeach?>
		<?php endif?>
	</div>
	</div>
	<div class="col-lg-5">
		<div class="slider-for">
			<?php if(isset($small_images)):?>
				<?php foreach($small_images as $k => $v):?>
					<div class="item-image">
						<img src="<?php echo $v['pic']?>" alt="<?php echo $v['name']?>">
					</div>
				<?php endforeach?>
			<?php endif?>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="prod_title itemTitle"><?php echo $item['name']?></div>
		<span class="itemSN"><?php echo $item['name2']?></span>
		<div class="prod_price">		
		  <?php if($item['price'] > 0)://2020-11-27 原價金額小於0就不顯示 by lota?>
				<small class="del price"><?php echo t('原價')?>：<?php echo $item['price_format_ds']?></small> 
			<?php endif?>
		  <?php if($item['price2'] > 0)://2020-12-24 特價金額為0就不顯示 #38368?>
				<span class="price2"><?php echo $item['price2_format_ds']?></span> 
			<?php endif?>
			
		</div><!-- .prod_price -->

		<?php if(isset($item['promotion']) and !empty($item['promotion'])):?>
			<div class="itemSP"><a href="<?php echo str_replace('detail','',$this->data['router_method'])?>_<?php echo $this->data['ml_key']?>.php?id=s<?php echo $item['promotion']['id']?>"><?php echo $item['promotion']['name']?></a></div>
		<?php endif?>

		<?php if(0):?>
		<div class="prod_info">
		  <div class="prodInfo_title"><?php echo t('產品特色')?></div>
		  <?php echo $item['name2']?>
		</div><!-- .prod_info -->
		<?php endif?>

		<?php if(trim($item['detail']) != ''):?>
			<div class="itemInfo">
				<div class="editorBlock">
					<?php echo nl2br($item['detail'])?>
				</div>
			</div>

			<!-- <div class="hrTitle"></div> -->
		<?php endif?>

		<?php if(isset($item['detail4']) && trim($item['detail4']) != '')://警告標語?>
			<div class="hrTitle"></div>

			<div class="itemInfo">
				<div class="editorBlock" style="color:red">
					<?php echo nl2br($item['detail4'])?>
				</div>
			</div>										
		<?php endif?>

		<div class="prod_num">
				<p><?php echo t('規格')?></p>
		  <select name="specid" id="aaa">
			<option value=""><?php echo t('請選擇')?></option>
			<?php if(isset($specs)):?>
				<?php foreach($specs as $k => $v):?>
					<?if(isset($v['disabled']) && isset($v['selected'])):?>
						<?$no_num=true;?>
					<?endif?>
					<option value="<?php echo $v['value']?>" name2="<?php echo $v['name2']?>" price="<?php echo $v['price_format_ds']?>" price2="<?php echo $v['price2_format_ds']?>" <?/*php if(isset($v['disabled'])):?> disabled="disabled" <?php endif*/?> <?php if(isset($v['selected'])):?> selected="selected" <?php endif?> ><?php echo $v['name']?></option>
				<?php endforeach?>
			<?php endif?>
		  </select>
		</div><!-- .prod_price -->
		

		<?php if(1):// 不要購物車的話，請改成0?>
		<div class="itemForm">
			<form>				

				<div class="prod_num">
				  <p><?php echo t('數量')?></p>
				  <div class="number-spinner">
					<span class="ns-btn">
						  <a class="minus" data-dir="dwn"><span class="icon-minus"></span></a>
					</span>
					<input type="text" class="pl-ns-value" id="amount" name="amount" value="1" maxlength=2>
					<span class="ns-btn">
						  <a class="add" data-dir="up"><span class="icon-plus"></span></a>
					</span>
				  </div>
				  <span class="stockTips" data-stockStatus="3" id="amount_status"></span><?php // 庫存狀態文字?>
				</div><!-- .prod_num -->
				<?if($no_num==false):?>
					<div class="prod_btn">
							<button style="background-color: #24a6bb;" class="btn-orange" id="addcar"><?php echo t('加入購物車')?></button>
							<button class=" btn heart btn-pink" id="addcar2" onclick="return false;" type="button"><?php echo t('立即購買')?></button>
					</div><!-- .prod_btn -->
				<?else:?>
					<div class="prod_btn">
						<a style="background-color: #24a6bb;cursor: pointer;" class="btn-orange" onclick="javascript:location.href=\''+content+'\'">聯絡我們</a>
					</div><!-- .prod_btn -->
				<?endif?>	
				<div class="shopCart_btn">
					<?php if(0):?>
					<a id="addcar" href="javascript:;"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="tips">加入購物車</span></a>
					<?php endif?>
					<?php if(0):?>
					<a href="javascript:;" class="itemAddFavor  <?php if(isset($item['has_favorite']) and $item['has_favorite'] == '1'):?> active <?php endif?>  " item_id="<?php echo $item['id']?>" ><i class="fa fa-heart" aria-hidden="true"></i><span class="tips">加入收藏</span></a>
					<?php endif?>
				</div>

			</form>
		</div>
		<?php endif?>

	</div><!-- col-lg-6 -->
  </div><!-- .prod_slider -->

<?php if(0)://tab第二個樣式?>
	  <div class="tabList tabListStyle02 tabList_center">
		<a href="#_" class="tabLabel active">商品說明</a>
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
		<a href="#_" class="tabLabel">商品規格</a>
		<div class="tabContent">
			<div class="editorBlock">
				商品規格敘述
			</div>
		</div>
	</div><!-- .tabListStyle02 -->
<?php endif?>

<?php //這頁籤問題很大 不要了 ?>
<?php /* if( (isset($item['content1']) and $item['content1']) != '' or (isset($item['content2']) and $item['content2'] != '') )://#31796?>
	<div class="tabList tabList_center">
	<?php if(isset($item['content1']) and $item['content1']!='')://#31796?>
		<a href="#_" class="tabLabel active"><?php echo t('商品說明')?></a>
		<div class="tabContent">
			<div class="editorBlock">
				<?php echo $item['content1']?>
			</div>
		</div>
	<?php endif?>

	<?php if(isset($item['content2']) and $item['content2']!='')://#31796?>
		<a href="#_" class="tabLabel <?php if(!isset($item['content1']) or $item['content1']==''):?>active<?php endif?>"><?php echo t('商品規格')?></a>
		<div class="tabContent">
			<div class="editorBlock">
				<?php echo $item['content2']?>
			</div>
		</div>
	<?php endif?>
  </div><!-- .tabList -->
<?php endif */?>
<?php //這頁籤問題很大 不要了 end ?>
<?php $_active = '';?>
<?php //cowboy 20210309 productdetail tabs 重製修復版 #38948?>
<?php if( (isset($item['content1']) and $item['content1']) != '' or (isset($item['content2']) and $item['content2'] != '') )://#31796?>
	<div class="cowboy_tabList">
		<?php if(isset($item['content1']) and $item['content1']!='')://#31796?>
			<?php $_active = 'active';?>
			<a class="<?php echo $_active?>" href="javascript:void(0)" data-content="1">
				<?php echo t('商品說明')?>
			</a>
		<?php endif?>

		<?php if(isset($item['content2']) and $item['content2']!='')://#31796?>
			<?php if($_active==''){ $_active = 'active';}else{ $_active = '--'; }?>
			<a class="<?php echo $_active?>" href="javascript:void(0)" data-content="2">
				<?php echo t('商品規格')?>
			</a>
		<?php endif?>
	</div>

	<div class="cowboy_tabContent">
		<?php if(isset($item['content1']) and $item['content1']!='')://#31796?>
			<div class="cowboy_theContent" data-content="1">
				<div class="editorBlock">
					<?php echo $item['content1']?>
				</div>
			</div>
		<?php endif?>

		<?php if(isset($item['content2']) and $item['content2']!='')://#31796?>
			<div class="cowboy_theContent" data-content="2">
				<div class="editorBlock">
					<?php echo $item['content2']?>
				</div>
			</div>
		<?php endif?>
	</div>
<?php endif?>
<?php //cowboy 20210309 productdetail tabs 重製修復版 end ?>

</div><!-- .prod_blk -->


<?php if($data['shop_related_products'] and isset($relations) and !empty($relations)):?>
			<section class="relatedPro block">
				<div class="hrTitle"><span><?php echo t('相關商品')?></span></div>

				<?php //include 'common/shop_relateProSlid.php';?>

				<div class="proList shop">
					<div class="itemList">
						<div id="relateProSlid">
							<?php foreach($relations as $k => $v):?>

								<!---pro item start-->
								<div class="item">
									<div>
										<a href="<?php echo $v['url1']?>">
											<div class="<?php echo $data['image_ratio'];//變數在source/core.php?> ">
												<img src="<?php echo $v['pic']?>">
<?php if(0):?>
												<div class="itemIcon">
													<img src="images/<?php echo $this->data['ml_key']?>/shop-icon-sale.svg">
												</div>
<?php endif?>
											</div>
										</a>
									</div>
									<div>

										<div class="itemTitle">
											<span><?php echo $v['name']?></span>
										</div>
										<div class="">
											<?php if($v['price'] > 0):?>
											<span class="itemPrice del">$<?php echo number_format($v['price'])?></span>
											<?php endif?>
											 <span class="itemPrice">$<?php echo number_format($v['price2'])?></span>
										</div>
										<?php if(0)://經理開會決議，內頁相關產品大部分不需要購物車跟收藏，如果這邊要打開 記得加上彈跳視窗 by lota 2020/12/10?>
										<div class="">
											<a href="#_" class="itemAddCart openBtn" data-target=".addCartPanel_<?php echo $v['id']?>"><i class="fa fa-shopping-cart"></i> <span class="tips"><?php echo t('加入購物車')?></span></a>
											<a href="#_" class="itemAddFavor"><i class="fa fa-heart"></i> <span class="tips"><?php echo t('加入收藏')?></span></a>
										</div>
										<?php endif?>
									</div>

								</div>
								<!---pro item end-->

							<?php endforeach?>
						</div>
					</div>
				</div>
			</section>
			<?php endif?>


<?php if(isset($data[$this->data['router_method'].'_return_url'])):?>
<div class="text-center">
	<a href="<?php echo $data[$this->data['router_method'].'_return_url']?>" class="btn-cis1"><i class="fa fa-reply"></i><?php echo t('回列表')?></a>
</div>
<?php endif?>

<?php if(0):?><!-- body_end -->
<script type="text/javascript">
<?php $item = $data2[$${CONNECT_A}]['single'][0]?>
var gggid_detail = 'aaa';
$('body').on('change','#' + gggid_detail,function(){
	$('.itemSN').html($('#'+gggid_detail+' :selected').attr('name2'));	

	if($('#'+gggid_detail+' :selected').val()!='' && $('#'+gggid_detail+' :selected').val()!=null){
		$('.price').html('<?php echo t('原價')?>：'+$('#'+gggid_detail+' :selected').attr('price'));
		$('.price2').html($('#'+gggid_detail+' :selected').attr('price2'));
	}
	
	$.ajax({
		type: "POST",
		data: {
			'id': '<?php echo str_replace('detail','',$this->data['router_method'])?>_spec',
			'primary_key': '<?php echo $item['id']?>',
			'specid': $(this).val()
		},
		url: 'save.php',
		success: function(){
			//location.reload();
		}
	}); // ajax
	var num = $("#amount").val();
    var color = $(this).val();
	if(color){
		$.ajax({
			url: 'shop_<?php echo $this->data['ml_key']?>.php',
			type: "POST",
			data: {
				"num": num,
				"productno": '<?php echo $item['id']?>',
				"color": color,
				'func': 'changSpec',
			}
		}).done(function(msg) {
			if (msg != 1) {
				var content='contact/<?=$_SESSION['save']['contact_dynamic_url']?>.html';
				$('.prod_btn').html('<p style="color:red;">庫存不足!</p><a style="background-color: #24a6bb;cursor: pointer;" class="btn-orange" onclick="javascript:location.href=\''+content+'\'">聯絡我們</a>');                 
			}else{
				$('.prod_btn').html('<button style="background-color: #24a6bb;" class="btn-orange" id="addcar">加入購物車</button><button class="btn heart btn-pink" id="addcar2" onclick="return false;" type="button">立即購買</button>'); 
			}
		}).fail(function (jqXHR, textStatus) {
				console.log(textStatus);
		});
	}
});

<?php //設定預設為第一個選項 需要的時候開啟?>
// $(function(){
// 	$("#aaa").get(0).selectedIndex=1
// 	$("#aaa").change();
// });

</script>
<?php endif?><!-- body_end -->

<?php if(0):?><!-- body_end -->
<script type="text/javascript">
$('body').on('click','.itemAddFavor',function(){
	var thisobj = $(this);
	var d = new Date();

	var month = d.getMonth()+1;
	var day = d.getDate();

	var output = d.getFullYear() + '-' +
		((''+month).length<2 ? '0' : '') + month + '-' +
		((''+day).length<2 ? '0' : '') + day;

	if(thisobj.hasClass('active')){
		// do nothing
	} else {
		<?php if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0):?>
			$.ajax({
				type: "POST",
				data: {
					'func': 'addfavorite',
					'id': <?php echo $_GET['id']?>,
					'add_date': output
				},
				url: '<?php echo str_replace('detail','',$this->data['router_method'])?>_<?php echo $this->data['ml_key']?>.php',
				success: function(response){
					eval(response);
				}
			}); // ajax
		<?php else:?>
			$.ajax({
				type: "POST",
				data: {
					'id': '<?php echo str_replace('detail','',$this->data['router_method'])?>_favorite',
					'primary_key': '<?php echo $_GET['id']?>_0',
					'add_date': output
					// specid 這個是加入購物車的時候會有的元素
				},
				url: 'save.php',
				success: function(response){
					thisobj.addClass('active');
					alert('己加入我的收藏');
					//window.location.reload();
				}
			}); // ajax
		<?php endif?>
	}
});
</script>
<?php endif?><!-- body_end -->

<?php if(0):?><!-- body_end -->
<script type="text/javascript" >
$('body').on('click','.number-spinner .minus',function(){
	var nowVal=$(this).parent().parent().find(".pl-ns-value").val();
	if(nowVal <= 1){
		nowVal = 1;
	}
	$(this).parent().parent().find(".pl-ns-value").val(nowVal);
	$('#amount').change();
	return false;
});
$('body').on('click','.number-spinner .add',function(){
	var nowVal=$(this).parent().parent().find(".pl-ns-value").val();
	$(this).parent().parent().find(".pl-ns-value").val(nowVal);
	$('#amount').change();
	return false;
});
</script>

<?php $url = str_replace('detail','',$this->data['router_method']).'_'.$this->data['ml_key'].'.php'?>
<script type="text/javascript">
$('body').on('change','#amount',function(){
	$.ajax({
		type: "POST",
		data: {
			'id': '<?php echo str_replace('detail','',$this->data['router_method'])?>_spec',
			'primary_key': '<?php echo $_GET['id']?>',
			'amount': $('input[name=amount]').val()
			//'_append': ''
		},
		url: 'save.php',
		success: function(response){
			//location.reload();
		}
	}); // ajax
});
$('body').on('click','#addcar',function(e){
	$.ajax({
		type: "POST",
		data: {
			'func': 'addcar',
			'id': '<?php echo $_GET['id']?>',
			'has_additional_purchase':<?=($item['has_additional_purchase']=='1'?1:0)?>,
			'has_additional_promo':<?=($item['has_additional_promo']=='1'?1:0)?>,
		},
		url: '<?php echo $url?>',
		success: function(response){
			eval(response);
		}
	}); // ajax
	e.preventDefault();
});
$('body').on('click','#addcar2',function(e){
	$.ajax({
		type: "POST",
		data: {
			'func': 'addcar',
			'id': '<?php echo $_GET['id']?>',
			'has_additional_purchase':<?=($item['has_additional_purchase']=='1'?1:0)?>,
			'has_additional_promo':<?=($item['has_additional_promo']=='1'?1:0)?>,
			'now': 1 // 直接購買
		},
		url: '<?php echo $url?>',
		success: function(response){
			eval(response);
		}
	}); // ajax
	e.preventDefault();
});
</script>
<?php endif?><!-- body_end -->

<?php if(0):?><!-- body_end -->
<script type="text/javascript">
$('body').on('click','.itemAddCart',function(){
	var thisobj = $(this);
	var item_id = thisobj.attr('item_id');
	var specid = thisobj.attr('item_specid');
	if(parseInt(specid) > 0){
		$.ajax({
			type: "POST",
			data: {
				'func': 'addcar',
				'id': item_id,
				'specid': specid
			},
			url: 'shop_<?php echo $this->data['ml_key']?>.php',
			success: function(response){
				eval(response);
			}
		}); // ajax
		//return false;
	}
});
</script>
<?php endif?><!-- body_end -->
