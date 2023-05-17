
<!-- // DATA2:SINGLE -->
<?php $item = $data[$ID]?>
<?php $${CONNECT_B} = $ID?>

<!-- // DATA2:MULTI -->
<?php $small_images = $data[$ID]?>
<!-- // DATA2:MULTI -->
<?php $increase_purchases = $data[$ID] // 加價購?>
<?php $${CONNECT_A} = $ID?>
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
<?php endif?>


<?php
/*
 * data2 struct
 * single:1 => 產品
 * multi:1 => 小圖(default)
 * multi:2 => 加價購
 * multi:3 => 相關產品
 */
?>
<section class="Bbox_1c">
	<div>
		<div>

			<section class="proDetail">
				<div>
					<?php //proDetail start ------?>
					<div>


						<div class="Bbox_in_2c_L6">
							<div>
								<div>

									<div class="itemProShow">
<?php if(0):?>
										<div class="itemIcon">
											<?php if(isset($item['icon']) and $item['icon'] != ''):?>
												<img src="images/<?php echo $this->data['ml_key']?>/<?php echo $item['icon']?>">
											<?php endif?>
										</div>
<?php endif?>
										<div class="itemSlick">
											<?php if(!empty($small_images)):?>
												<?php foreach($small_images as $k => $v):?>
													<div><a class="swipebox" rel="proShow" href="<?php echo $v['pic']?>"><div class="itemImg"><img src="<?php echo $v['pic']?>"></div></a></div>
												<?php endforeach?>
											<?php endif?>
										</div>
									</div>

									<div class="itemSlickNav">
										<?php if(!empty($small_images)):?>
											<?php foreach($small_images as $k => $v):?>
												<div><div class="itemImg"><img src="<?php echo $v['pic']?>"></div></div>
											<?php endforeach?>
										<?php endif?>
									</div>

									<?/*<div>
										<iframe src="https://www.facebook.com/plugins/share_button.php?href=http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>&layout=button&size=large&mobile_iframe=true&width=66&height=28&appId" width="66" height="28" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
									</div>*/?>

								</div>


								<div>

									<div class="itemTitle"><?php echo $item['name']?></div>
									<span class="itemSN"><?php echo $item['name2']?></span>
									<div class="itemPrice">
										<?php if($item['price2'] > 0)://2020-12-24 特價金額為0就不顯示 #38368?>
										<span class="price2"><?php echo $item['price2_format_ds']?></span> 
										<?php endif?>
										<?php if($item['price'] > 0)://2020-11-27 原價金額小於0就不顯示 by lota?>
										<small class="del price"><?php echo t('原價')?>：<?php echo $item['price_format_ds']?></small> 
										<?php endif?>
									</div>

									<?php if(isset($item['promotion']) and !empty($item['promotion'])):?>
										<div class="itemSP"><a href="<?php echo str_replace('detail','',$this->data['router_method'])?>_<?php echo $this->data['ml_key']?>.php?id=s<?php echo $item['promotion']['id']?>"><?php echo $item['promotion']['name']?></a></div>
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

									<div class="itemForm">
										<form>

<?php echo $AA?>

											<div class="formItem _Quantity">
												<label><?php echo t('數量')?></label>
												<div class="numSet">
													<button class="minus">-</button><input type="text" value="1" id="amount" name="amount"><button class="add">+</button>
												</div>
												<span class="stockTips" data-stockStatus="3" id="amount_status"></span><?php // 庫存狀態文字?>
											</div>

											<?php if(0 and isset($increase_purchases) and !empty($increase_purchases)):?>
												<div class="hrTitle"><span><?php echo t('加價購商品')?></span></div>
												<?php //$plusbuyType='checkbox'; include 'common/shop_plusbuy.php';?>

												<div class="proPlusBuy">
													<div class="gridBox nogap" data-grid="2">

														<?php foreach($data[$ID] as $k => $v):?>
														<div class="item" data-rwd="s2"  data-itemSNo="<?php echo $v['id']?>">

															<div class="checkbox">
																<label>
																	<input type="checkbox" class="<?php echo $ID?>" value="<?php echo $v['id']?>" <?php if(isset($v['disabled'])):?> disabled <?php endif?> >  <span></span>
																	<input type="hidden" class="field1" value="<?php echo $v['field1']?>" />
																	<input type="hidden" class="field2" value="<?php echo $v['field2']?>" />
																</label>
																</div>

																<div class="itemThumb">
																	<div class="itemImg"><img src="<?php echo $v['pic']?>"></div>
																</div>

																<div class="itemInfo">
																	<a href="<?php echo $v['url']?>"><?php echo t('我要加')?> <span class="itemPrice"><?php echo $v['price']?></span> <?php echo t('買')?> <span><?php echo $v['name']?></span></a>
																	<input type="hidden" class="s_<?php echo $v['field1']?>" value="<?php echo $v['field1_value']?>" />
																	<div>
																		<select class="s_<?php echo $v['field2']?> p_<?php echo $ID?>" <?php if(isset($v['disabled'])):?> disabled <?php endif?> >
																			<?php if(isset($v['list'])):?>
																				<?php foreach($v['list'] as $kk => $vv):?>
																					<option value="<?php echo $vv['value']?>" <?php if(isset($vv['disabled'])):?> disabled <?php endif?> ><?php echo $vv['name']?></option>
																				<?php endforeach?>
																			<?php endif?>
																		</select>
																	</div>
																</div>

															</div>
														<?php endforeach?>

													</div>
												</div>
											<?php endif?>

											<div class="hrTitle _Quantity"></div>
											<div class="shopDetail_button">
												<button class="" id="addcar"><i class="fa fa-shopping-cart"></i><?php echo t('加入購物車')?></button>
													<?php // <a href="javascript:;" class="btn-cis1 openBtn" data-target="#loginPanel"><i class="fa fa-shopping-cart"></i>立即結帳</a>?>
												<button class="btn heart btnColor_pink" data-toggle="modal" data-target="#loginPanel" id="addcar2" onclick="return false;" type="button"><?php echo t('立即購買')?></button>
												<a class="justlikebtn_R" style="display:none" href="contact_<?php echo $this->data['ml_key']?>.php" target="_blank"><?php echo t('聯絡我們')?></a>
												<div class="shopDetail_addFavor"> <a class="itemAddFavor <?php if(0 and isset($item['has_favorite']) and $item['has_favorite'] == '1'):?> active <?php endif?> "><span class="addFavor_circle"><i class="fa fa-heart"></i></span> <p class="tips"><?php echo t('加入收藏')?></p></a> <a class="circle_blue" target="_blank" href="http://www.facebook.com/sharer.php?u=https://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>"><span class="addFavor_circle"><i class="fa fa-facebook"></i></span> <p class="tips"><?php echo t('分享')?></p></a> </div>
											</div>

										</form>
									</div>
								</div>
							</div>
						</div>

						<?php //商品介紹?>
						<?php if( (isset($item['content1']) and $item['content1']) != '' or (isset($item['content2']) and $item['content2'] != '') )://#31796?>
						<div class="itemContent">
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
							</div>
						</div>
						<?php endif?>
					</div>
					<?php //proDetail end ------?>
				</div>
			</section>

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
											<div class="itemImg">
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

		</div>
	</div>
</section>

<?php if(0):?><!-- body_end -->
<script type="text/javascript">
var itemid = '<?php echo $${CONNECT_A}?>';
$('body').on('change','.' + itemid,function(){
	var thisobj = $(this);
	var field1 = thisobj.parent().find('.field1').val();
	var field2 = thisobj.parent().find('.field2').val();
	var json = {};
	json['id'] = '<?php echo str_replace('detail','',$this->data['router_method'])?>_increase_purchase';
	json['primary_key'] = thisobj.val();
	json[field1] = $('.s_' + field1).val();
	json[field2] = $('.s_' + field2).val();
	if($(this).is(":checked")){
		// do nothing
	} else {
		if(field1 == 'amount'){
			json[field1] = 0;
		} else if(field2 == 'amount'){
			json[field2] = 0;
		}
	}
	$.ajax({
		type: "POST",
		data: json,
		url: 'save.php',
		success: function(response){
			//location.reload();
		}
	}); // ajax
});
$('body').on('change','.p_' + itemid,function(){
	$(this).parent().parent().parent().find('.' + itemid).prop('checked',true);
	$(this).parent().parent().parent().find('.' + itemid).change();
});
</script>
<?php endif?><!-- body_end -->

<?php if(0):?><!-- body_end -->
<script type="text/javascript">
var itemid = '<?php echo $${CONNECT_B}?>';
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
					alert('<?php echo t('己加入我的收藏')?>');
					window.location.reload();
				}
			}); // ajax
		<?php endif?>
	}
});
</script>
<?php endif?><!-- body_end -->

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
$('body').on('click','.numSet .minus',function(){
	var nowVal=$(this).siblings("input").val();
	$(this).siblings("input").val(numCal("-",nowVal));
	$('#amount').change();
	return false;

});
$('body').on('click','.numSet .add',function(){
	var nowVal=$(this).siblings("input").val();
	$(this).siblings("input").val(numCal("+",nowVal));
	$('#amount').change();
	return false;

});
</script>
<?php endif?><!-- body_end -->

<?php if(0):?><!-- body_end -->
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
			'id': '<?php echo $_GET['id']?>'
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
