[POS1]
		<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
			<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
				<div class="Bbox_sin_3_12 ">
					<div>
						
						<div>
							<div>
								<a href=" ">
									<h5><?php echo $v['topic']?></h5>
									<p><small><?php echo $v['other1']?></small></p>
								</a>
							</div>
						</div>
						<div>
							<a class="thumbnail " href="<?php echo $v['url1']?>">
								<img src="<?php echo $v['pic1']?>" class="img-responsive ">
							</a>
						</div>
					</div>
				</div>
			<?php endforeach?>
		<?php endif?>