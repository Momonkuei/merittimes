<section class="Bbox_1c">
	<div>
		<div>


			<section class="timeLine">
				
				<?php if(isset($data[$ID])):?>
					<?php foreach($data[$ID] as $k => $v):?>
				
						<div class="item">	

							<div class="itemLine">		
								<div class="itemStep">
									<span><?php echo $v['month']?></span>						
									<span><?php echo $v['year']?></span>
								</div>
							</div>

							<div class="itemContent">						
								<div class="itemPic">
									<div class="itemImg">
										<img src="<?php echo $v['pic']?>">
									</div>
								</div>
							
								<div class="itemTxt">
									<div class="itemTitle"> <span><?php echo $v['name']?></span> </div>
									<div class="itemContent"><?php echo $v['content']?></div>
								</div>
							</div>

						</div>	


					<?php endforeach?>
				<?php endif?>

			</section>		
	


		</div>		
	</div>
</section>			
