<?php
/*
 * 在V3階段，跟據設計部版型的配置，來切換V1第二版的資料流
 */
$my_name = $layoutv3_struct_map[$ID];
$tmps = $layoutv3_struct_map_keyname[$my_name];

$ls_tmp = array(
	' ls="webmenu:bottom" ',
	' ls="webmenuchild:" lp="index:name---shop_footer_link" ',
);

$ls = '';
foreach($tmps as $k => $v){
	if($v == $ID){
		$ls = $ls_tmp[$k];
	}
}
?>
<section>
	<ul class="siteMap type1" l="layer" <?php echo $ls?> >
		<li l="list"><a attr2="" <?php // href="{/url/}"?> >{/name/}</a></li>

		<li><a href="about.php">關於我們</a></li>
		<li><a href="products.php">商品介紹</a></li>
		<li><a href="album.php?type=1">活動花絮</a></li>
		<li><a href="download.php?type=1">下載專區</a></li>
		<li><a href="news.php?type=1">最新消息</a></li>
		<li><a href="faq.php">問與答</a></li>
		<li><a href="contact.php">聯絡我們</a></li>
	</ul>
</section>
