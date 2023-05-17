<section class="sectionBlock no-margin-top">
<div class="container">
	<div class="pageTitleStyle-2 text-center">
		<span>Sitemap</span>
		<small>網站地圖</small>
	</div>
	<div class="row">
		<div class="col-12 col-sm-12">
			<div class="editorBlock">					
				<ul class="sitemapList">

				<?php if(isset($data[$ID])):?>
					<?php foreach($data[$ID] as $k => $v):?>
						<li class=" <?php if(isset($v['child']) and !empty($v['child']) and $v['has_child'] === true):?>moreMenu<?php endif?> <?php if(isset($v['class'])):?><?php echo $v['class'] //留給商品用的，可以加上multiMenu?><?php endif?>" >
							<a href="<?php echo $v['url']?>"
								<?php if(isset($v['target']) and $v['target'] != ''):?> target="<?php echo $v['target']?>" <?php endif?> 
								<?php if(isset($v['anchor_class']) and $v['anchor_class'] != ''):?> class="<?php echo $v['anchor_class']?>" <?php endif?> 
								<?php if(isset($v['anchor_data_target']) and $v['anchor_data_target'] != ''):?> data-target="<?php echo $v['anchor_data_target']?>" <?php endif?> 
							>
								<span
								>
									<?php echo $v['name']?>
								</span>
							</a>

							<?php if(isset($v['child']) and !empty($v['child']) and $v['has_child'] === true):?>
								<ul>
								<?php foreach($v['child'] as $kk => $vv):?>
									<li class=" <?php if(isset($vv['class'])):?><?php echo $vv['class'] //留給商品用的，可以加上moreMenu?><?php endif?> ">
										<a href="<?php echo $vv['url']?>" 
											<?php if(isset($vv['target']) and $vv['target'] != ''):?> target="<?php echo $vv['target']?>" <?php endif?>
											<?php if(isset($vv['anchor_class']) and $vv['anchor_class'] != ''):?> class="<?php echo $vv['anchor_class']?>" <?php endif?> 
											<?php if(isset($vv['anchor_data_target']) and $vv['anchor_data_target'] != ''):?> data-target="<?php echo $vv['anchor_data_target']?>" <?php endif?> 
										>
											<span
											>
												<?php echo $vv['name']?>
											</span>
										</a>
										<?php if(isset($vv['child']) and !empty($vv['child'])):?>
											<ul>
											<?php foreach($vv['child'] as $kkk => $vvv):?>
												<li>
													<a href="<?php echo $vvv['url']?>" 
														<?php if(isset($vvv['target']) and $vvv['target'] != ''):?> target="<?php echo $vvv['target']?>" <?php endif?> 
														<?php if(isset($vvv['anchor_class']) and $vvv['anchor_class'] != ''):?> class="<?php echo $vvv['anchor_class']?>" <?php endif?> 
														<?php if(isset($vvv['anchor_data_target']) and $vvv['anchor_data_target'] != ''):?> data-target="<?php echo $vvv['anchor_data_target']?>" <?php endif?> 
													>
														<span
														>
															<?php echo $vvv['name']?>
														</span>
													</a>
												</li>
											<?php endforeach?>
											</ul>
										<?php endif?>
									</li>
								<?php endforeach?>
								</ul>
							<?php endif?>
						</li>
					<?php endforeach?>
				<?php endif?>

				<?php if(0 and isset($data[$ID])):?>
					<?php foreach($data[$ID] as $k => $v):?>
						<li>
							<a href="<?php echo $v['url']?>"> <?php echo $v['name']?></a>
							<?php if(isset($v['child']) and count($v['child']) > 0):?>
								<ul>
								<?php foreach($v['child'] as $kk => $vv):?>
									<li><a href="<?php echo $vv['url']?>" ><?php echo $vv['name']?></a></li>
								<?php endforeach?>
								</ul>
							<?php endif?>
						</li>
					<?php endforeach?>
				<?php endif?>					
				</ul>
			</div>
		</div>
	</div>
</div>
</section>