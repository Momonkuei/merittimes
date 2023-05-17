<section class="articleBlockStyle03 ">
	<div class="Bbox_1c text-center">
		<div>
			<div>

				
				<div class="flex4c">					
					<?php if(isset($data[$ID])):?>
						<?php foreach($data[$ID] as $k => $v):?>
							<div>
								<a href="<?php echo $v['url']?>"><div class="itemImg"><img src="<?php echo $v['pic']?>" alt="<?php echo $v['topic']?>"></div></a>
								<h4><?php echo $v['name']?></h4>		
								<p><?php echo $v['content']?></p>					
							</div>
						<?php endforeach?>
					<?php endif?>

					<?php if(0):?>
					<div>
						<a href=""><div class="itemImg"><img src="images/pic_2.jpg"></div></a>
						<h4>設計</h4>		
						<p>歐洲最大光電產業先驅，擁有全世界超過18 個據點</p>					
					</div>
					<div>
						<a href=""><div class="itemImg"><img src="images/pic_3.jpg"></div></a>
						<h4>專業</h4>		
						<p>產品細節上力求設計感與形象，客戶最滿意之專業服務</p>					
					</div>
					<div>
						<a href=""><div class="itemImg"><img src="images/pic_1.jpg"></div></a>
						<h4>領先</h4>		
						<p>全世界超過 5000個電子商品販賣通路，各據點之間有良好的互動</p>					
					</div>
					<div>
						<a href=""><div class="itemImg"><img src="images/pic_4.jpg"></div></a>
						<h4>品質</h4>		
						<p>領先業界穩定品質，榮獲經濟部標準檢驗局頒授認證體系認可證書</p>					
					</div>
					<?php endif?>

				</div>


			</div>
		</div>
	</div>
</section>
