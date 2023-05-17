<?php $product = $data[$ID]?>

<?php if(!isset($_GET['q'])):?>
<section class="proListFun">	
	<form>
		<?php if(isset($pageRecordInfo['pagination']['total']))://2020-12-28?>
			<div class="listCount"> 共有<span><?php echo $pageRecordInfo['pagination']['total']?></span>筆 </div>
		<?php else:?>
			<div class="listCount">&nbsp;</div>
		<?php endif?>

		<div class="gridChange">
			<a href="#_" data-grid="3"><img src="images/<?php echo $this->data['ml_key']?>/shop-icon-grid3.png"></a>
			<a href="#_" data-grid="4"><img src="images/<?php echo $this->data['ml_key']?>/shop-icon-grid4.png"></a>
		</div>

		<?php $is_item_type = false // 預設不是分類?>
		<?php if(isset($product) and !empty($product)):?>
			<?php if(isset($product[0]['pid'])):?>
				<?php $is_item_type = true // 我是分類?>
			<?php endif?>
		<?php endif?>

		<div class="formItem">
			<?php if($is_item_type !== true):?>
				<label>排序</label>
				<select id="dropdown_filter">					
					<option value="2" <?php if(isset($_SESSION['save'][$this->data['router_method'].'_ajax']['dropdown_filter']) and $_SESSION['save'][$this->data['router_method'].'_ajax']['dropdown_filter'] == '2'):?> selected="selected" <?php endif?> >價格 低&lt;高</option>
					<option value="1" <?php if(isset($_SESSION['save'][$this->data['router_method'].'_ajax']['dropdown_filter']) and $_SESSION['save'][$this->data['router_method'].'_ajax']['dropdown_filter'] == '1'):?> selected="selected" <?php endif?> >價格 高&gt;低</option>
					<!--
					<option value="4" <?php if(isset($_SESSION['save'][$this->data['router_method'].'_ajax']['dropdown_filter']) and $_SESSION['save'][$this->data['router_method'].'_ajax']['dropdown_filter'] == '4'):?> selected="selected" <?php endif?> >最新上架 新&gt;舊</option>
					<option value="3" <?php if(isset($_SESSION['save'][$this->data['router_method'].'_ajax']['dropdown_filter']) and $_SESSION['save'][$this->data['router_method'].'_ajax']['dropdown_filter'] == '3'):?> selected="selected" <?php endif?> >最新上架 舊&gt;新</option>
					-->
				</select>
			<?php endif?>
		</div>
	</form>
</section>
<?php endif?>
							
<!-- prolist start ， 預設一列4個，一頁24個-->
<section class="itemList">
	<div class="gridBox closest" data-grid="4">

		<?php if(isset($product)):?>
			<?php foreach($product as $k => $v):?>
				<!---pro item start-->
				<div class="item" data-itemSNo="<?php echo $v['id']?>">
					<div>
						<?php
						//#2021-07-14 為了解決購物產品分類上提後，可能連帶產生的問題(banner，麵包屑) by lota
						$_pex = '';
						if(isset($_GET['cid'])){
							$_pex = '&cid='.intval($_GET['cid']);
						}
						?>
						<a href="<?php echo $v['url1']?>&cid=<?php echo $_pex?>">														
							<div class="itemImg"> <? //直：<div class="itemImg h"> 橫：<div class="itemImg w"> ?>
								<img src="<?php echo $v['pic']?>" <?php if(isset($v['img_alt'])):?> alt="<?php echo $v['img_alt']?>" <?php endif?> > 
<?php if(0):?>
								<div class="itemIcon">																														
									<?php if(isset($v['icon']) and $v['icon'] != ''):?>
										<img src="images/<?php echo $this->data['ml_key']?>/<?php echo $v['icon']?>">
									<?php endif?>
								</div>
<?php endif?>
							</div>
						</a>
					</div>
					<div>										
						
						<div class="itemTitle"> 
							<span><?php echo $v['name']?></span>
						</div>

						<?php if(!isset($v['pid'])):?>
							<div class="">
								<?php if($v['price'] > 0)://2020-11-27 原價金額小於0就不顯示 by lota?>
								 <span class="itemPrice del"><small><?php echo $v['price_format_ds']?></small></span>
								 <?php endif?> 
								 <span class="itemPrice">
								 	<?php if($v['price2'] > 0)://2020-12-24 特價價金額小於0就不顯示 #38368?>
								 	<?php echo $v['price2_format_ds']?>
								 	<?php endif?>
								 </span> 
							</div>
							<div class="">
								<a href="javascript:;" class="itemAddCart openBtn" item_id="<?php echo $v['id']?>" <?php if(isset($v['specs']) and !empty($v['specs'])):?> item_specid="<?php echo $v['specid']?>" <?php else:?> data-target=".addCartPanel_<?php echo $v['id']?>" <?php endif?> ><i class="fa fa-shopping-cart"></i> <span class="tips">加入購物車</span></a>
								<a href="javascript:;" class="itemAddFavor  <?php if(isset($v['has_favorite']) and $v['has_favorite'] == '1'):?> active <?php endif?>  " item_id="<?php echo $v['id']?>" ><i class="fa fa-heart"></i> <span class="tips">加入收藏</span></a>
							</div>
						<?php endif?>

					</div>
					
				</div>
				<!---pro item end-->
			<?php endforeach?>
		<?php endif?>

	</div>
</section>

<?php if(0):?><!-- body_end -->
<script type="text/javascript">
	<?php if(isset($_SESSION['save'][$this->data['router_method'].'_ajax']['data_grid'])):?>
		$(".itemList>.gridBox").attr('data-grid','<?php echo $_SESSION['save'][$this->data['router_method'].'_ajax']['data_grid']?>');
	<?php endif?>
	$(".gridChange a").click(function(){
		$(".itemList>.gridBox").attr('data-grid',$(this).attr('data-grid'));
		$.ajax({
			type: "POST",
			data: {
				'id': '<?php echo $this->data['router_method']?>_ajax',
				'data_grid': $(this).attr('data-grid')
			},
			url: 'save.php',
			success: function(response){
				//alert(response);
				//eval(response);
			}
		}); // ajax
	});

	$('body').on('change','#dropdown_filter',function(){
		$.ajax({
			type: "POST",
			data: {
				'id': '<?php echo $this->data['router_method']?>_ajax',
				'dropdown_filter': $(this).val()
			},
			url: 'save.php',
			success: function(response){
				location.reload();
			}
		}); // ajax
	});
</script>
<?php endif?><!-- body_end -->

<?php if(0):?><!-- body_end -->
<?php // 這個是從view/favorite/type1.php那邊複製來的?>
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

<?php if(0):?><!-- body_end -->
<script type="text/javascript">
$('body').on('click','.itemAddFavor',function(){
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
					alert('<?php echo t('己加入我的收藏')?>');
					window.location.reload();
					//location.reload();
				}
			}); // ajax
		<?php endif?>
	}
});
</script>
<?php endif?><!-- body_end -->
