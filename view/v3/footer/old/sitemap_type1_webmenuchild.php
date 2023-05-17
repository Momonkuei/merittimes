<section>

	<ul class="siteMap type1" l="layer" ls="webmenuchild:" lp="index:name---shop_footer_link">

		<li l="list"><a href="{/url/}">{/name/}</a>
			{/child/}
		</li>
		<ul l="box">{split}</ul>

		<li><a href="about.php">關於我們</a></li>
		<li><a href="products.php">商品介紹</a></li>
		<li><a href="album.php?type=1">活動花絮</a></li>
		<li><a href="download.php?type=1">下載專區</a></li>
		<li><a href="news.php?type=1">最新消息</a></li>
		<li><a href="faq.php">問與答</a></li>
		<li><a href="contact.php">聯絡我們</a></li>
	</ul>

	<?php if(0):?>
		<ul class="siteMap type1">
			<?php if(isset($data[$ID])):?>
				<?php foreach($data[$ID] as $k => $v):?>
					<li><a href="<?php echo $v['url']?>"><span><?php echo $v['name']?></span></a></li>
				<?php endforeach?>
			<?php endif?>
		</ul>
	<?php endif?>

</section>
