[POS1]
		<div class="menu_lg_view">		
			<div>
				<p class="title-c text-left deco_1"><?php echo G::t(null,'EDM 選單')?></p>
			</div>
			<ul class="list-unstyled">
				<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
					<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
						<li><a href="<?php if(isset($v['url1']) and $v['url1'] != ''):?><?php echo $v['url1']?><?php else:?>#_<?php endif?>" data-toggle_xg="collapse" data-target_xg=".submenu_<?php echo $k?>"  target="_BREAK"><?php echo $v['topic']?></a>
							<?php if(isset($v['childs']) and count($v['childs']) > 0):?>
								<ul class="submenu_<?php echo $k?> nav nav-pills nav-stacked <?php if(isset($_GET['id']) and $_GET['id'] == $v['id']):?> collapse in <?php else:?> collapse <?php endif?> ">
								<?php foreach($v['childs'] as $kk => $vv):?>
									<li><a href="<?php echo $vv['url']?>" target="_BREAK"><?php echo $vv['name']?></a></li>
								<?php endforeach?>
								</ul>
							<?php endif?>
						</li>
					<?php endforeach?>
				<?php endif?>
				</div>