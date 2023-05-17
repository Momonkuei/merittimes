<section class="articleBlockStyle01 ">
	<div class="Bbox_1c">
		<div>
			<div>

				<div class="blockTitle txtCenter">
<!-- // DATA_SINGLE -->
					<span><?php echo $data[$ID]['name']?></span>
					<small><?php echo $data[$ID]['sub_name']?></small>
				</div>
				<div class=" flex4c">					
<!-- // DATA_MULTI -->
					<?php if(isset($data[$ID])):?>
						<?php foreach($data[$ID] as $k => $v):?>
							<div>
								<img src="<?php echo $v['pic']?>">
								<h4><?php echo $v['name']?></h4>		
								<p><?php echo $v['content']?></p>					
							</div>
						<?php endforeach?>
					<?php endif?>

					<?php if(0):?>
					<div>
						<img src="images/pic_1.jpg">
						<h4>設計</h4>		
						<p>擁有全世界超過 5000個電子商品販賣通路。能針對客戶不同的需求而做出 讓客戶最滿意之專業服務。</p>					
					</div>
					<div>
						<img src="images/pic_2.jpg">
						<h4>專業</h4>		
						<p>擁有全世界超過18 個據點，各據點之間有良好的互動，並且以優秀 的專業人才，熱誠的服務態度，配合效率高、速 度快的營業管理。</p>					
					</div>
					<div>
						<img src="images/pic_3.jpg">
						<h4>領先</h4>		
						<p>以優秀 的專業人才，熱誠的服務態度，配合效率高、速 度快的營業管理，能針對客戶不同的需求而做出 讓客戶最滿意之專業服務。</p>					
					</div>
					<div>
						<img src="images/pic_4.jpg">
						<h4>超群</h4>		
						<p>各據點之間有良好的互動，熱誠的服務態度，配合效率高、速 度快的營業管理，能針對客戶不同的需求而做出 讓客戶最滿意之專業服務。</p>					
					</div>
					<?php endif?>

				</div>
			</div>
		</div>
	</div>
</section>
