<section class="articleBlockStyle03">
	<div class="Bbox_1c">
		<div>
			<div>
				<div class="blockTitle txtCenter">
<!-- // DATA_SINGLE -->
					<span><?php echo $data[$ID]['name']?></span>
					<small><?php echo $data[$ID]['sub_name']?></small>
				</div>

				<div class="slidBlock"  data-slick='{"slidesToShow": 4, "slidesToScroll": 1}'>					
<!-- // DATA_MULTI -->
					<?php if(isset($data[$ID])):?>
						<?php foreach($data[$ID] as $k => $v):?>
							<div class="slidItem">
								<div class="itemImg share"><img src="<?php echo $v['pic']?>"></div>
								<h4><?php echo $v['name']?></h4>		
								<p><?php echo $v['content']?></p>					
							</div>
						<?php endforeach?>
					<?php endif?>

					<?php if(0):?>
					<div class="slidItem">
						<div class="itemImg share"><img src="images/team_5.jpg"></div>
						<h4>李英明</h4>		
						<p>“於紐約和台灣擁有豐富的品牌識別與商業設計經驗。為企業建立獨特品牌形象。“</p>					
					</div>
					<div class="slidItem">
						<div class="itemImg share"><img src="images/team_2.jpg"></div>
						<h4>王大頭</h4>		
						<p>“擁有豐富的品牌策略與行銷溝通經驗，曾服務於全球知名品牌顧問公司。“</p>					
					</div>
					<div class="slidItem">
						<div class="itemImg share"><img src="images/team_3.jpg"></div>
						<h4>陳小胖</h4>		
						<p>“擅長品牌管理、行銷組織運作、產品行銷、行銷溝通、通路建置及業務拓展。“</p>					
					</div>
					<div class="slidItem">
						<div class="itemImg share"><img src="images/team_4.jpg"></div>
						<h4>潔西卡艾巴</h4>		
						<p>“結合知名4A廣告代理商的經歷，為企業建立獨特品牌形象。“</p>					
					</div>
					<div class="slidItem">
						<div class="itemImg share"><img src="images/team_1.jpg"></div>
						<h4>潔西卡艾巴</h4>		
						<p>“擁有豐富的品牌策略與行銷溝通經驗，曾服務於全球知名品牌顧問公司。“</p>					
					</div>
					<?php endif?>

				</div>
			</div>
		</div>
	</div>
</section>
