<div class="topLink">
	<?
	foreach($data[$ID] as $k => $v){
		if($v['id']=='455'  && (isset($_SESSION['member_data']) && !empty($_SESSION['member_data']))){
			$data[$ID][$k]['attr2']='href="memberlogout_'.$this->data['ml_key'].'.php"';
			$data[$ID][$k]['name']='登出';
		}
	}?>
	<?if(!empty($data[$ID])){?>
	<ul class="topLinkMenu">
		<?foreach($data[$ID] as $k => $v){?>
		<li  <?=$v['attr1']?> ><a <?=$v['attr2']?> ><?=$v['icon']?><span><?=$v['name']?></span></a></li>
		<?}?>
	</ul>
	<?}?>
</div>
