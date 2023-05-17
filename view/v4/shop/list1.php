<!-- function -->
<?php //include 'common/proListFun.php';?>

<!-- // DATA2:SINGLE -->
<?php $other = $data[$ID]?>

<!-- // DATA2:MULTI -->
<?php $product = $data[$ID]?>

<?php $row_inherit_start = $row_inherit_end = '';include 'view/system/row_inherit.php'?>

<?php //var_dump($data[$ID])?>
<?
	$cid="";
	if(!empty($_GET['id'])){
		$cid='&cid='.$_GET['id'];
	}
	
?>

			
<?php if(0)://有分頁的時候會跑版?? 先註解起來 by lota?>
<div class="spaceList proList_style-1">
	<div class="row">
<?php endif?>

		<div class="colChange col-12">
			<a class="active" href="javascript:;" data-grid="3">
				<img src="images_v4/shop-icon-grid3.png" alt="">
			</a>
			<a href="javascript:;" data-grid="4">
				<img src="images_v4/shop-icon-grid4.png" alt="">
			</a>
			<a href="javascript:;" data-grid="1">
				<img src="images_v4/shop-icon-grid5.png" alt="">
			</a>
		</div>

<?php if(isset($product)):?>
	<?php foreach($product as $k => $v):?>
		<div class="col-6 col-sm-4"><?php //echo $row_inherit_start?>		
		<a href="<?php echo $v['url'].$cid?>">
			<div class="<?php echo $data['image_ratio'];//變數在source/core.php?>  img-rectangle  itemImgHover hoverEffect1">
				<img src="<?php echo $v['pic']?>" <?php if(isset($v['img_alt'])):?> alt="<?php echo $v['img_alt']?>" <?php endif?> onerror="javascript:this.src='images_v4/default.png';img.onerror=null;" >

				<div class="shopCart_btnpc">
					<?php if(!isset($v['pid'])):?>
						<div data-fancybox data-src="#addCartPanel_<?php echo $v['id']?>" <?php if(isset($v['specs']) and !empty($v['specs'])):?> item_specid="<?php echo $v['specid']?>" <?php else:?> data-target="#addCartPanel_<?php echo $v['id']?>" <?php endif?>>
							<i class="fa fa-shopping-cart" aria-hidden="true"></i>
						</div>
						<?php if(0): //隱藏?>
						<div class="itemAddFavor  <?php if(isset($v['has_favorite']) and $v['has_favorite'] == '1'):?> active <?php endif?>  " item_id="<?php echo $v['id']?>">
							<i class="fa fa-heart" aria-hidden="true"></i>
						</div>
						<?php endif?>
						
					<?php endif?>
				</div>
			</div>
		</a>

		<div>
			<?php if(isset($v['name']) and $v['name'] != ''):?>
				<div class="subBlockTitle"><?php echo $v['name']?></div>
			<?php endif?>
			<div  class="shop_detail textlimit"><?php echo $v['detail']?></div>
			<?php if(!isset($v['pid'])):?>
				<div class="shopCart">
				  <span class="shopDel"><?php echo $v['price_format_ds']?></span><span class="shopPrice"><?php echo $v['price2_format_ds']?></span>
				</div><!-- .shopCart -->
				<div class="shopCart_btn">
				  <a data-fancybox data-src="#addCartPanel_<?php echo $v['id']?>" data-options='{"touch" : false}' href="javascript:;" class="itemAddCart" item_id="<?php echo $v['id']?>" <?php if(isset($v['specs']) and !empty($v['specs'])):?> item_specid="<?php echo $v['specid']?>" <?php else:?> data-target="#addCartPanel_<?php echo $v['id']?>" <?php endif?> ><i class="fa fa-shopping-cart" aria-hidden="true"></i> 加入購物車<!-- <span class="tips">加入購物車</span> --></a>
						<?php if(1): //隱藏?>	
				  <a href="javascript:;" class="itemAddFavor  <?php if(isset($v['has_favorite']) and $v['has_favorite'] == '1'):?> active <?php endif?>  " item_id="<?php echo $v['id']?>" ><i class="fa fa-heart" aria-hidden="true"></i><span class="tips">加入收藏</span></a>
						<?php endif?>
				</div><!-- .shopCart_btn -->
			<?php endif?>
		</div>

		</div><?php //echo $row_inherit_end?>
	<?php endforeach?>
<?php endif?>

<?php if(0)://有分頁的時候會跑版?? 先註解起來 by lota?>
	</div>
</div>
<?php endif?>

<?php if(0):?><!-- body_end -->
<?php // 這個是從view/favorite/type1.php那邊複製來的?>
<script type="text/javascript">
$('.itemAddCart').click(function(){
	var thisobj = $(this);
	var item_id = thisobj.attr('item_id');
	var specid = thisobj.attr('item_specid');
	//alert(item_id);
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

<?php if(0):?><!-- body_end -->
<script type="text/javascript">
$('.itemAddFavor').click(function(){
	var thisobj = $(this);
	var d = new Date();

	var item_id = thisobj.attr('item_id');

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
					'id': item_id,
					'add_date': output
				},
				url: '<?php echo $this->data['router_method']?>_<?php echo $this->data['ml_key']?>.php',
				success: function(response){
					eval(response);	
					window.location.reload();
				}
			}); // ajax
		<?php else:?>
			$.ajax({
				type: "POST",
				data: {
					'id': '<?php echo $this->data['router_method']?>_favorite',
					'primary_key': item_id + '_0',
					'add_date': output
					// specid 這個是加入購物車的時候會有的元素
				},
				url: 'save.php',
				success: function(response){
					thisobj.addClass('active');
					alert('己加入我的收藏');
					window.location.reload();
					//location.reload();
				}
			}); // ajax
		<?php endif?>
	}
});
</script>
<?php endif?><!-- body_end -->
<script type="text/javascript">
$('.itemAddFavor').click(function(){
	var thisobj = $(this);
	var d = new Date();

	var item_id = thisobj.attr('item_id');

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
					'id': item_id,
					'add_date': output
				},
				url: '<?php echo $this->data['router_method']?>_<?php echo $this->data['ml_key']?>.php',
				success: function(response){
					eval(response);	
					window.location.reload();
				}
			}); // ajax
		<?php else:?>
			$.ajax({
				type: "POST",
				data: {
					'id': '<?php echo $this->data['router_method']?>_favorite',
					'primary_key': item_id + '_0',
					'add_date': output
					// specid 這個是加入購物車的時候會有的元素
				},
				url: 'save.php',
				success: function(response){
					thisobj.addClass('active');
					alert('己加入我的收藏');
					window.location.reload();
					//location.reload();
				}
			}); // ajax
		<?php endif?>
	}
});
</script>
