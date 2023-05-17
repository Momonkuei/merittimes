<div class="indexContent_16">

	<?/*新聞跑馬燈，先隱藏
	<section class="articleBlockStyle01 text-center">
		<div class="Bbox_1c">
			<div>
				<div>
					<? // 文字跑馬燈，至多五則?>
					<? $widgetName='marquee';include 'common/common_widget.php';?>
				</div>
			</div>
		</div>
	</section>
	*/?>

	<section class="indexBlock_1 block">
		<div class="blockTitle txtCenter">
			<span>精選商品</span>
			<small>Products List</small>
		</div>
		<div class="proList shop">
			<div class="w1200px">		
				<section class="itemList">
					<div class="gridBox closest" data-grid="4">
						<?php for ($i=1;$i<=8;$i++) {?>
						<div class="item">
							<div>
								<a href="shop.php">														
									<div class="itemImg"> <? //直：<div class="itemImg h"> 橫：<div class="itemImg w"> ?>
										<img src="<?=$imgPath.'demo/pro_'. ($i%6) .'.jpg';?>"> 										
									</div>
								</a>
							</div>
							<div>	
								<div class="itemTitle"> 
									<span>產品名稱產品名稱</span>
								</div>
								<div class="">
									 <span class="itemPrice del"><small>$3,000</small></span> 
									 <span class="itemPrice">$1,900</span> 
								</div>
								<?php if(1):?>
								<div class="">
									<a href="#_" class="itemAddCart openBtn" data-target=".addCartPanel"><i class="fa fa-shopping-cart"></i> <span class="tips">加入購物車</span></a>
									<a href="#_" class="itemAddFavor"><i class="fa fa-heart"></i> <span class="tips">加入收藏</span></a>
								</div>
								<?php endif?>
							</div>							
						</div>		
						<?php }?>				
					</div>
				</section>
			</div>
		</div>
	</section>


	<section class="articleBlockStyle03">
		<div class="blockTitle txtCenter">
			<span>活動訊息</span>
			<small>Activites</small>
		</div>
		<div class="w1200px">

			
			<div class="gridBox closest" data-grid="4">					
				<div data-rwd="m2s4">
					<a href=""><div class="itemImg w"><img src="<?=$imgPath;?>index-img-1.png"></div></a>
					<h4 class="articleTitle">設計</h4>		
					<p>歐洲最大光電產業先驅，擁有全世界超過18 個據點</p>					
				</div>
				<div data-rwd="m2s4">
					<a href=""><div class="itemImg w"><img src="<?=$imgPath;?>index-img-2.png"></div></a>
					<h4 class="articleTitle">專業</h4>		
					<p>產品細節上力求設計感與形象，客戶最滿意之專業服務</p>					
				</div>
				<div data-rwd="m2s4">
					<a href=""><div class="itemImg w"><img src="<?=$imgPath;?>index-img-3.png"></div></a>
					<h4 class="articleTitle">領先</h4>		
					<p>全世界超過 5000個電子商品販賣通路，各據點之間有良好的互動</p>					
				</div>
				<div data-rwd="m2s4">
					<a href=""><div class="itemImg w"><img src="<?=$imgPath;?>index-img-4.png"></div></a>
					<h4 class="articleTitle">品質</h4>		
					<p>領先業界穩定品質，榮獲經濟部標準檢驗局頒授認證體系認可證書</p>					
				</div>
			</div>


		</div>
			
	</section>
</div>
