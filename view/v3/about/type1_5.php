<section class="articleBlockStyle01">
	<div class="Bbox_1c">
		<div>
			<div>

				<div class="flex3c">
					<?php if(isset($data[$ID])):?>
						<?php foreach($data[$ID] as $k => $v):?>
							<div><img src="<?php echo $v['pic']?>"></div>
						<?php endforeach?>
					<?php endif?>

					<?php if(0):?>
						<div><img src="images/pic_1.jpg"></div>
						<div><img src="images/pic_2.jpg"></div>
						<div><img src="images/pic_3.jpg"></div>
					<?php endif?>
				</div>
				
			</div>
		</div>
	</div>
</section>	
