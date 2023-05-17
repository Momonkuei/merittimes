<?php if(0): // 2018-04-30 測試A方案的手機版選單?>
<ul class="mobileMenu">
	<li>Menu</li>
	<li>我是指標，不要刪掉我</li>
</ul>
<?php endif?>

<?php if(0)://這個是開頭範例?>
<div style="display:none" k="aabbcc">
	<li><a href=""><span>123</span></a></li>
</div>
<?php endif?>

<?php if(0)://這個是結尾範例，目前支援ul和div?>
<div style="display:none" k="aabbgg">
	<li><a href=""><span>456</span></a></li>
</div>
<?php endif?>

<ul l="layer" ls="lll" class="navMenu navlight" data-active=">li" data-multimenu="true" data-defactive="active" data-defactiveid="navlight_webmenu_<?php echo $this->data['func_name_id']?>" <?php if(0)://這是開頭範例?>kg="aabbcc"<?php endif?>>

	<li l="list" attr1="" ><a attr2="" >{/icon/}<span>{/name/}</span></a>
		{/child/}
	</li>
	<ul l="box">{split}</ul>

	<li class="moreMenu"><a href="about.php?type=1"><span>關於我們</span></a>
		<ul>
			<li><a href="about.php?type=1"><span>公司簡介</span></a></li>
			<li><a href="about.php?type=2"><span>歷史沿革</span></a></li>
		</ul>
	</li>
	<li class="moreMenu multiMenu"><a href="products.php"><span>商品介紹</span></a>
		<ul>
			<li><a href="products.php"><span>照明元件</span></a>
				<ul>
					<li><a href="products.php">PLCC Series</a></li>
					<li><a href="products.php">COB Series</a></li>
					<li><a href="products.php">Federal Series</a></li>
					<li><a href="products.php">ES Series</a></li>
					<li><a href="products.php">Flash Series</a></li>
					<li><a href="products.php">Filament Series</a></li>
				</ul>
			</li>
			<li><a href="products.php"><span>LED模組</span></a>
				<ul>
					<li><a href="products.php">ES Series</a></li>
					<li><a href="products.php">Flash Series</a></li>
					<li><a href="products.php">Filament Series</a></li>
				</ul>
			</li>
			<li><a href="products.php"><span>LED模組</span></a>
				<ul>
					<li><a href="products.php">ES Series</a></li>
					<li><a href="products.php">Flash Series</a></li>
					<li><a href="products.php">Filament Series</a></li>
					<li><a href="products.php">COB Series</a></li>
					<li><a href="products.php">Federal Series</a></li>
				</ul>
			</li>
			<li><a href="products.php"><span>車用模組</span></a>
				<ul>
					<li><a href="products.php">ES Series</a></li>
					<li><a href="products.php">Flash Series</a></li>
					<li><a href="products.php">Filament Series</a></li>
					<li><a href="products.php">PLCC Series</a></li>
				</ul>
			</li>
			<li><a href="products.php"><span>照明成品</span></a>
				<ul>
					<li><a href="products.php">ES Series</a></li>
					<li><a href="products.php">Flash Series</a></li>
					<li><a href="products.php">Filament Series</a></li>
					<li><a href="products.php">PLCC Series</a></li>
				</ul>
			</li>
			<li><a href="products.php"><span>照明元件</span></a>
				<ul>
					<li><a href="products.php">PLCC Series</a></li>
					<li><a href="products.php">COB Series</a></li>
					<li><a href="products.php">Federal Series</a></li>
					<li><a href="products.php">ES Series</a></li>
					<li><a href="products.php">Flash Series</a></li>
					<li><a href="products.php">Filament Series</a></li>
				</ul>
			</li>
		</ul>
	</li>														
	<li class="moreMenu"><a href="album.php?type=1"><span>活動花絮</span></a>
		<ul>
			<li class="moreMenu"><a href="album.php?type=1"><span>相簿</span></a>
				<ul>
					<li><a href="album.php?type=1"><span>相簿列表</span></a></li>
					<li><a href="album.php?type=2"><span>相片列表 (一般)</span></a></li>
					<li><a href="album.php?type=3"><span>相片列表 (瀑布流)</span></a></li>
				</ul>
			</li>
			<li><a href="video.php?"><span>影片</span></a></li>
		</ul>
	</li>
	<li class="moreMenu"><a href="download.php?type=1"><span>下載專區</span></a>
		<ul>
			<li><a href="download.php?type=1"><span>檔案下載</span></a></li>
			<li><a href="download.php?type=2"><span>型錄下載</span></a></li>
		</ul>
	</li>
	<li class="moreMenu"><a href="news.php?type=1"><span>最新消息</span></a>
		<ul>
			<li><a href="news.php?type=1"><span>文字列表</span></a></li>
			<li><a href="news.php?type=2"><span>圖文列表</span></a></li>
		</ul>
	</li>
	<li class="moreMenu"><a href=""><span>其他頁面</span></a>
		<ul>
			<li><a href="faq.php"><span>問與答</span></a></li>
			<li class="moreMenu"><a href="contact.php?type=1"><span>聯絡我們</span></a>
				<ul>
					<li><a href="contact.php?type=1"><span>B to B</span></a></li>
					<li><a href="contact.php?type=2"><span>B to C</span></a></li>
				</ul>
			</li>
		</ul>
	</li>

</ul><?php if(0)://這個是結尾範例?><span>aabbgg</span><?php endif?>
