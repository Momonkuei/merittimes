<nav>
	<nav class="Bbox_1c">
		<div>
			<div>
				<div>
					<ol class="breadcrumb floatright marginb0">
						<?php if(isset($data[$ID])):?>
							<?php foreach($data[$ID] as $k => $v):?>
								<li><a <?php if(isset($v['url']) and $v['url'] != ''):?> href="<?php echo $v['url']?>" <?php endif?> ><?php echo $v['name']?></a></li>
							<?php endforeach?>
						<?php endif?>
					</ol>
				</div>
			</div>
		</div>
	</nav>
</nav>
