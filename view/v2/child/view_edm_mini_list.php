[POS1]
		
		<div data-toggle="collapse" data-target=".menu_s_view" aria-expanded="fale">
			<p class="title-sm text-center margin_sm_tb" style="cursor:pointer"><?php echo G::t(null,'Products')?> <span class="caret hidden-md hidden-lg"></span></p>
		</div>
		<div class="menu_s_view collapse hidden-md hidden-lg">
			<ul class="list-unstyled">
				<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
					<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
						<li><a href="<?php echo $v['url1']?>" data-toggle="collapse" data-target=".submenu_<?php echo $k?>"><?php echo $v['topic']?></a>
							
						</li>
					<?php endforeach?>
				<?php endif?>

			</ul>
		</div>