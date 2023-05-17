<?php //var_dump($data[$ID])?>
<ul class="topLinkMenu" l="layer" ls="lll">

	<li l="list" attr1="" ><a attr2="" >{/icon/}<span>{/name/}</span></a>
		{/child/}
	</li>
	<ul l="box">{split}</ul>

	<li><a href="member.php?type=login"><i class="fa fa-user"></i><span>登入/註冊</span></a> </li>
	<li><a href="member.php?type=center"><i class="fa fa-user"></i><span>會員中心</span></a> </li>
	<li><a href="elements.php?a=33"><i class="fa fa-search"></i><span>搜尋</span></a></li>
	<li><a href="elements.php?a=3"><i class="fa fa-share-alt"></i><span>分享</span></a></li>
	<li class="moreMenu"><a href="elements.php?a=8"><i class="fa fa-shopping-cart"></i><span>購物車</span></a>
		<ul>
			<li><a href="">中文</a></li>
			<li><a href="">ENGLISH</a></li>
		</ul>
	</li>
	<li class="moreMenu"><a href="elements.php?a=8"><i class="fa fa-globe"></i><span>語系</span></a>
		<ul>
			<li><a href="">中文</a></li>
			<li><a href="">ENGLISH</a></li>
			<li><a href="">한국어</a></li>
		</ul>
	</li>						

	<?php if(0 and isset($data[$ID])):?>
		<?php foreach($data[$ID] as $k => $v):?>
			<li class=" <?php if(isset($v['child']) and count($v['child']) > 0):?>moreMenu<?php endif?> <?php if(isset($v['func']) and $v['func'] == 'language_google'):?>moreMenu<?php endif?> " >
				<a href="<?php echo $v['url']?>" <?php if(isset($v['anchor_open'])):?><?php echo $v['anchor_open']?><?php endif?> >
					<?php if(isset($v['icon'])):?><?php echo $v['icon']?><?php endif?>
					<span><?php echo $v['name']?></span>
				</a>

				<?php if(isset($v['child']) and !empty($v['child'])):?>
					<ul>
					<?php foreach($v['child'] as $kk => $vv):?>
						<li><a href="<?php echo $vv['url']?>" <?php if(isset($vv['anchor_open'])):?><?php echo $vv['anchor_open']?><?php endif?> ><span><?php echo $vv['name']?></span></a></li>
					<?php endforeach?>
					</ul>
				<?php endif?>
			</li>
		<?php endforeach?>
	<?php endif?>


</ul>
