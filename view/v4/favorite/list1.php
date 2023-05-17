<?php //include('view/banner/pageBanner.php'); ?>

<?php if(0):?>
<div class="favoriteContent">

  <div class="container">
    <?php //include('widget/breadcrumb.php'); ?>
  </div>
<?php endif?>

  <section class="sectionBlock">
    <div class="container">

      <div class="pageTitleStyle-2 text-center">
        <span>FAVORITE LIST</span>
        <small>收藏清單</small>
      </div>

<?php //var_dump($data[$ID])?>
      <div class="proList">
        <div class="spaceList">
          <div class="row">
			<?php if(isset($data[$ID])):?>
				<?php foreach($data[$ID] as $k => $v):?>
					<div class="col-lg-3 col-md-4 col-sm-6">
					  <a href="<?php echo $v['url1']?>">
						<div class="itemImg img-rectangle square itemImgHover hoverEffect1">
						  <img src="<?php echo $v['pic']?>" alt="">
						</div>
					  </a>
					  <div class="subBlockTitle"><?php echo $v['name']?></div>
					  <div class="shopCart_btn">
						<a data-fancybox data-src="#addCartPanel_<?php echo $v['id']?>" href="javascript:;" class="itemAddCart" item_id="<?php echo $v['id']?>" <?php if(isset($v['specs']) and !empty($v['specs'])):?> item_specid="<?php echo $v['specid']?>" <?php else:?> data-target="#addCartPanel_<?php echo $v['id']?>" <?php endif?> ><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="tips">加入購物車</span></a>
						<a href="<?php echo $v['url2']?>"><i class="fa fa-trash" aria-hidden="true"></i><span class="tips"></span></a>
					  </div><!-- .shopCart_btn -->
					</div>
				<?php endforeach?>
			<?php endif?>
          </div>
        </div><!-- .spaceList -->
      </div><!-- .proList -->

    </div><!-- .container -->
  </section><!-- .sectionBlock -->

<?php if(0):?>
</div><!-- .favoriteContent -->
<?php endif?>
