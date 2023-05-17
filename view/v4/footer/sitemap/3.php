<?php 
// sitemap_type2
?>

<ul class="ftMenu_list">
	<?php if(isset($data[$ID]) and !empty($data[$ID])):?>
		<?php foreach($data[$ID] as $k => $v):?>
			<li><a href="<?php echo $v['url']?>"><?php echo $v['name']?></a></li>
		<?php endforeach?>
	<?php endif?>

	<?php if(0):?>
		<li><a href="about.php">關於我們</a></li>
		<li><a href="products.php">商品介紹</a></li>
		<li><a href="album.php">活動花絮</a></li>
		<li><a href="download.php">下載專區</a></li>
		<li><a href="news.php">最新消息</a></li>
		<li><a href="video.php">影音專區</a></li>
		<li><a href="faq.php">問與答</a></li>
		<li><a href="location.php">服務據點</a></li>
		<li><a href="member.php?type=privacy">隱私權政策</a></li>
	<?php endif?>

	<li>
	<?php //$socialWidget='social_type1'; include 'social_list.php'; ?>
<?php echo $__?>
	</li>
</ul>
