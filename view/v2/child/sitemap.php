<div class="Bbox_1c">
	<div>
		<div>
			<div class="editorBlock">					
				<UL>
				<?php if(isset($this->data['sitemap'])):?>
					<?php foreach($this->data['sitemap'] as $k => $v):?>
						<li>
							<a href="<?php echo $v['url']?>"> <?php echo $v['topic']?></a>
							<?php if(isset($v['sub_menu']) and count($v['sub_menu']) > 0):?>
								<ul>
								<?php foreach($v['sub_menu'] as $kk => $vv):?>
									<li><a href="<?php echo $vv['url']?>" ><?php echo $vv['topic']?></a></li>
								<?php endforeach?>
								</ul>
							<?php endif?>
						</li>
					<?php endforeach?>
				<?php endif?>					
				</UL>
			</div>
			
		</div>
	</div>
</div>
