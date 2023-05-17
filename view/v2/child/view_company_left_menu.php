[POS1]		
		<div class="menu_lg_view">
			<ul class="list-unstyled">
				<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
					<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
					<li <?php if((!isset($_GET['id']) and $k == 0) or (isset($_GET['id']) and $v['id'] == $_GET['id'])):?> class="active"<?php endif?> ><a href="<?php echo $this->createUrl('site/'.str_replace('detail','',$this->data['router_method']),array('id'=>$v['id']))?>" style="font-size: medium;"><?php echo $v['topic']?></a></li>
					<?php endforeach?>
				<?php endif?>
			</ul>
		</div>