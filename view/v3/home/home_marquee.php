<?php if(isset($data[$ID]) and count($data[$ID]) > 0):?>
<section class="articleBlockStyle01 text-center">
	<div class="Bbox_1c">
		<div>
			<div>
				<section class="marquee">
					<ul class="">										
						<?php foreach($data[$ID] as $k => $v):?>
							<li>
								<a data-txtlen="35" href="<?php echo $v['url']?>">
									<?php echo $v['name']?>
								</a>
							</li>
						<?php endforeach?>
					</ul>
				</section>
			</div>
		</div>
	</div>
</section>
<?php endif?>			
