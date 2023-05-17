<?php
/*
 * 2017-11-17 這個區塊是V3專用的，不過因為新功能的推出，所以盡量的不要用這個區塊
 */
?>
<section>
	<ul class="siteMap type1">
		<?php if(isset($data[$ID])):?>
			<?php foreach($data[$ID] as $k => $v):?>
				<li><a href="<?php echo $v['url']?>"><span><?php echo $v['name']?></span></a></li>
			<?php endforeach?>
		<?php endif?>
	</ul>

	<?php if(0):?>
		<ul class="siteMap type1">
			<li><a href="about.php">關於我們</a></li>
			<li><a href="products.php">商品介紹</a></li>
			<li><a href="album.php?type=1">活動花絮</a></li>
			<li><a href="download.php?type=1">下載專區</a></li>
			<li><a href="news.php?type=1">最新消息</a></li>
			<li><a href="faq.php">問與答</a></li>
			<li><a href="contact.php">聯絡我們</a></li>
		</ul>
	<?php endif?>

</section>
