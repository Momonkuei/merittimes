<section>
	<ul class="siteMap type3">
		<?php if(isset($data[$ID]) and count($data[$ID]) >= 2):?>
			<?php foreach($data[$ID] as $k => $v):?>
				<?php if($k == 0):?>
					<li class=" item "><a href="<?php echo $v['url']?>"><span><?php echo $v['name']?></span></a>
						<ul>
				<?php else:?>
					<li><a href="<?php echo $v['url']?>"><span><?php echo $v['name']?></span></a></li>
				<?php endif?>
			<?php endforeach?>
		<?php endif?>

		<?php if(isset($data[$ID]) and count($data[$ID]) >= 2):?>
			</ul><?php // 這個不是沒收鍊哦！?>
		</li>
		<?php endif?>
	</ul>

<?php if(0):?>
	<ul class="siteMap type3">
		<li class=" item "><a href="#_"><span>項目標題</span></a>
			<ul>
				<li><a href="about.php"><span>關於我們</span></a></li>
				<li><a href="shop.php"><span>商品介紹</span></a></li>
				<li><a href="album.php?type=1"><span>活動花絮</span></a></li>
				<li><a href="download.php?type=1"><span>下載專區</span></a></li>
				<li><a href="news.php?type=1"><span>最新消息</span></a></li>
				<li><a href="faq.php"><span>問與答</span></a></li>
				<li><a href="contact.php"><span>聯絡我們</span></a></li>
				<li><a href="member.php?type=center"><span>會員中心</span></a></li>
			</ul>
		</li>
	</ul>
<?php endif?>
</section>
