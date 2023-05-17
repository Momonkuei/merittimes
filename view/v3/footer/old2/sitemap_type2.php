<?php
/*
 * 在V3階段，跟據設計部版型的配置，來切換V1第二版的資料流
 */

$ls = ' ls="webmenu:bottom" ';
if(isset($layoutv3_struct_map_keyname['v3/footer/sitemap_type1'])){
	$ls = ' ls="webmenuchild:" lp="index:name---shop_footer_link" ';
}
?>
<section z="">
	<ul class="siteMap type2" l="layer" <?php echo $ls?> >
		<li l="list"><a attr2="" <?php // href="{/url/}"?>>{/name/}</a></li>

		<?php if(0)://2019-12-09?>
			<?php if(isset($layoutv3_struct_map_keyname['v3/footer/sitemap_type1'])):?>
				<li l="list"><a href="{/url/}">{/name/}</a></li>
			<?php else:?>
				<li l="list"><a attr2="">{/name/}</a></li>
			<?php endif?>
		<?php endif?>

		<li><a href="about.php">關於我們</a></li>
		<li><a href="products.php">商品介紹</a></li>
		<li><a href="album.php?type=1">活動花絮</a></li>
		<li><a href="download.php?type=1">下載專區</a></li>
		<li><a href="news.php?type=1">最新消息</a></li>
		<li><a href="faq.php">問與答</a></li>
		<li><a href="contact.php">聯絡我們</a></li>
	</ul>
</section>
