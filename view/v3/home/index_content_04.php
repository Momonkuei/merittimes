<?
/**
 * 第一欄、第二欄圖片相關說明
 *
 * 當產品圖片為正方 1:1 時 ( $proImgSizeType = 1)
 * 第一欄圖片大小為 600 x 840
 * 第二欄圖片大小為 600 x 400
 *
 * 當產品圖片為橫向 4:3 時 ( $proImgSizeType = 2)
 * 第一欄圖片大小為 600 x 675
 * 第二欄圖片大小為 600 x 315
 *
 * 當產品圖片為直向 A4 時 ( $proImgSizeType = 3)
 * 第一欄圖片大小為 600 x 1000
 * 第二欄圖片大小為 600 x 480
 * 
 */
?>
<div class="indexContent_4">
	<div class="indexBlock_01">
		<section class="w1400px block">
			<h2 class="blockTitle txtCenter">
				<span>服務項目</span>
				<small>SERVICE ITEMS</small>
			</h2>
			<div class="gridBox colCenter index3Col" data-grid="6">
				<div class="col_2" data-rwd="l3m3s6">
					<div class="imgBlock">
						<div class="imgBlock__Item">
							<a class="imgBlock__ImgArea" href="javascript:void(0);">
								<img src="images/w04/indexImg_01_type1.jpg">
							</a>
						</div>
					</div>
				</div>
				<div class="col_2" data-rwd="l3m3s6">
					<div class="imgBlock" l="layer" ls="html:news" lp="andwhere:is_home---1,orderby:start_date desc,pidas:is_news,limit:1---2" >
						<div l="list" class="imgBlock__Item">
							<a class="imgBlock__ImgArea" href="newsdetail_<?php echo $this->data['ml_key']?>.php?id={/id/}">
								<img src="{/pic1_/}">
							</a>
						</div>
						<div class="imgBlock__Item">
							<a class="imgBlock__ImgArea" href="javascript:void(0);">
								<img src="images/w04/indexImg_02-2_type1.jpg">
							</a>
						</div>
					</div>
				</div>
				<div class="col_2 proList" data-rwd="l5m6">
					<section class="itemList Bbox_in_2c">
						<div>
							<div class="item">
								<div>
									<a href="products.php?type=2">
										<div class="itemImg">
										<img src="images/w04/productImg_01.jpg" style="display: block; width: 100%; height: auto;">
										</div>
									</a>
								</div>
								<div>										
									<div class="itemTitle"> 
										<span>商品名稱商品名稱商品名稱商品名稱</span>
									</div>
									<div class="flexCenter">
										<div class="itemPrice"> $<span>299</span> </div>
									</div>
								</div>	
							</div>
							<div class="item">
								<div>
									<a href="products.php?type=2">
										<div class="itemImg">
										<img src="images/w04/productImg_02.jpg" style="display: block; width: 100%; height: auto;">
										</div>
									</a>
								</div>
								<div>										
									<div class="itemTitle"> 
										<span>商品名稱商品名稱商品名稱商品名稱</span>
									</div>
									<div class="flexCenter">
										<div class="itemPrice"> $<span>299</span> </div>
									</div>
								</div>
							</div>
							<div class="item">
								<div>
									<a href="products.php?type=2">
										<div class="itemImg">
										<img src="images/w04/productImg_03.jpg" style="display: block; width: 100%; height: auto;">
										</div>
									</a>
								</div>
								<div>										
									<div class="itemTitle"> 
										<span>商品名稱商品名稱商品名稱商品名稱</span>
									</div>
									<div class="flexCenter">
										<div class="itemPrice"> $<span>299</span> </div>
									</div>
								</div>
							</div>
							<div class="item">
								<div>
									<a href="products.php?type=2">
										<div class="itemImg"> <img src="images/w04/productImg_04.jpg" style="display: block;">
										</div>
									</a>
								</div>
								<div>										
									<div class="itemTitle"> 
										<span>商品名稱商品名稱商品名稱商品名稱</span>
									</div>
									<div class="flexCenter">
										<div class="itemPrice"> $<span>299</span> </div>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
		</section>
	</div>
</div>
