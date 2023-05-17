[POS1]
<div class="collapse navbar-collapse navbar_menu">
	<ul class="nav navbar-nav">
		<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
			<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
				<li <?php if($v['url1'] == 'index.php?r='.$this->data['router_class'].'/'.$this->data['router_method']):?>class="active"<?php endif?>><a href="<?php echo $v['url1']?>"><?php echo $v['topic']?></a></li>
			<?php endforeach?>
		<?php endif?>
	</ul>
</div>
