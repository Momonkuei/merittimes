<!-- prolist start-->
<section class="itemList ">

	<?php /* 預設一列4個 */ ?>
	<div class="gridBox closest" data-grid="4">
		
		<?php if(isset($data[$ID])):?>
			<?php foreach($data[$ID] as $k => $v):?>

			<!---pro item start-->
			<div class="item" data-itemNum="<?php echo $v['id']?>">
				<div>
					<a href="<?php echo $v['url1']?>">
						<div class="itemImg"> 
							<img src="<?php echo $v['pic']?>"> 
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
					<div class="">
						<?php if($v['price'] > 0):?>
						<span class="itemPrice del"><small>$<?php echo number_format($v['price'])?></small></span> 
						<?php endif?>
						<span class="itemPrice">$<?php echo number_format($v['price2'])?></span> 
					</div>

					
					<?php if(0)://這裡好像也沒有什麼作用，暫時先隱藏起來?>
						<div class="itemSpec">
							<?php if(isset($v['specs']) and !empty($v['specs'])):?>
								<?php foreach($v['specs'] as $kk => $vv):?>
									<div><label><?php echo $vv['name']?>：</label><span class=""><?php if(isset($vv['value'])):?><?php echo $vv['value']?><?php endif?><?php if(isset($vv['pic'])):?><img src="<?php echo $vv['pic']?>"><?php endif?></span></div>
								<?php endforeach?>
							<?php endif?>

							<?php if(isset($v['inventory'])):?>
								<div><label><?php echo t('數量')?>：</label><span class=""><?php echo $v['inventory']?></span></div>
							<?php endif?>
						</div>
					<?php endif?>

					<div class="">
						<a href="javascript:;" item_id="<?php echo $v['id']?>" <?php if(isset($v['specs']) and !empty($v['specs'])):?> item_specid="<?php echo $v['specid']?>" <?php else:?> data-target=".addCartPanel_<?php echo $v['id']?>" <?php endif?> class="itemAddCart openBtn"><i class="fa fa-shopping-cart"></i> <span class="tips"><?php echo t('加入購物車')?></span></a>
						<a href="<?php echo $v['url2']?>" class="itemRemoveFavor" data-itemNum="<?php echo $v['id']?>"><i class="fa fa-trash"></i> <span class="tips"><?php echo t('移除收藏')?></span></a>
					</div>

					

				</div>
				
			</div>
			<!---pro item end-->

			<?php endforeach?>
		<?php endif?>

	</div>
</section>
<!-- prolist end-->

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
