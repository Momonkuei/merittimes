<div class="indexContent_5">
	<div class="indexBlock_1">
		<section class="w1200px block">

			<div class="gridBox" data-grid="2">
				<div class="col_1" data-rwd="l1m2">
					<h2 class="blockTitle">
						<span>最新消息</span>
						<small>news</small>
					</h2>
					<?/*
					<ul class="newsList" l="layer" ls="html:news" lp="andwhere:is_home---1,orderby:start_date desc,pidas:is_news,limit:1---5" >
						<li l="list"><a href="newsdetail_<?php echo $this->data['ml_key']?>.php?id={/id/}"><span class="newsDate">{/start_date/}</span><span>{/topic/}</span></a></li>
						<li><a href="news.php?type=2"><span class="newsDate">2015.01.30</span>持續深耕鋼鐵本業外，亦致力協助下游相關產業升級，提升整體產業國際競爭力。</a></li>
						<li><a href="news.php?type=2"><span class="newsDate">2013.01.28</span>追求成長，持續節能環保及價值創新，成為值得信賴的全球卓越鋼鐵企業</a></li>
						<li><a href="news.php?type=2"><span class="newsDate">2015.01.30</span>持續深耕鋼鐵本業外，亦致力協助下游相關產業升級，提升整體產業國際競爭力。</a></li>
						<li><a href="news.php?type=2"><span class="newsDate">2010.01.20</span>98年榮獲經濟部頒發第17屆「產業科技發展卓越創新成就獎」</a></li>
					</ul>
					*/?>
					<!-- ul 的 idxNewsListType 這個class不要用 -->
					<ul class="newsList" l="layer" ls="html:news" lp="andwhere:is_home---1,orderby:start_date desc,pidas:is_news,limit:1---5" >
						<li l="list" style="text-overflow: unset;white-space: unset;">
							<a href="newsdetail_<?php echo $this->data['ml_key']?>.php?id={/id/}" style="display: flex;justify-content: space-between;">
								<div class="newsText"><span style="line-height: 19px;">{/topic/}</span></div>
								<span class="newsDate" style="margin-right: 0;margin-left: .5em;">{/start_date/}</span>
							</a>
						</li>
						<li><a href="news.php?type=2"><span class="newsDate">2015.01.30</span>持續深耕鋼鐵本業外，亦致力協助下游相關產業升級，提升整體產業國際競爭力。</a></li>
						<li><a href="news.php?type=2"><span class="newsDate">2013.01.28</span>追求成長，持續節能環保及價值創新，成為值得信賴的全球卓越鋼鐵企業</a></li>
						<li><a href="news.php?type=2"><span class="newsDate">2015.01.30</span>持續深耕鋼鐵本業外，亦致力協助下游相關產業升級，提升整體產業國際競爭力。</a></li>
						<li><a href="news.php?type=2"><span class="newsDate">2010.01.20</span>98年榮獲經濟部頒發第17屆「產業科技發展卓越創新成就獎」</a></li>
					</ul>
					<p>
						<a href="news_<?php echo $this->data['ml_key']?>.php" class="btn-link">Read More</a>
					</p>
				</div>
				<div class="col_1" data-rwd="l1m2">
					<img src="<?=$imgPath;?>/index-ad-1.jpg" alt="">
					<!-- <div class="gridBox closest" data-grid="2">
						<div>
							<a href="shop.php" class="itemImg w">
								<img src="<?=$imgPath;?>/index-ad-1.jpg" alt="">
							</a>
						</div>
						<div>
							<a href="shop.php" class="itemImg w">
								<img src="<?=$imgPath;?>/index-ad-2.jpg" alt="">
							</a>
						</div>
						<div>
							<a href="shop.php" class="itemImg w">
								<img src="<?=$imgPath;?>/index-ad-3.jpg" alt="">
							</a>
						</div>
						<div>
							<a href="shop.php" class="itemImg w">
								<img src="<?=$imgPath;?>/index-ad-4.jpg" alt="">
							</a>
						</div>
					</div> -->
				</div>
			</div>
		</section>
	</div>
	<div class="indexBlock_2">
		<div class="Bbox_1c">
			<div>
				<div>
					<h2 class="blockTitle txtCenter">
						<span>LOOK BOOK</span>
						<small>New & Hot</small>
					</h2>
					<!-- <div class="slidBlock"  data-slick='{"slidesToShow": 4, "slidesToScroll": 1}'> -->
					<div class="indexProListSlidBlock gridBox" data-grid="12">
						<a class="slidItem col_3" data-rwd="l4x6">
							<div class="itemImg share"><img src="<?=$imgPath;?>demo/pro_5.jpg"></div>
							<h4 class="slidItemTitle">Summer</h4>
							<p class="slidItemDesc">Lorem ipsum dolor</p>
						</a>
						<a class="slidItem col_3" data-rwd="l4x6">
							<div class="itemImg share"><img src="<?=$imgPath;?>demo/pro_2.jpg"></div>
							<h4 class="slidItemTitle">Winter</h4>
							<p class="slidItemDesc">Lorem ipsum dolor</p>
						</a>
						<a class="slidItem col_3" data-rwd="l4x6">
							<div class="itemImg share"><img src="<?=$imgPath;?>demo/pro_3.jpg"></div>
							<h4 class="slidItemTitle">Snow</h4>
							<p class="slidItemDesc">Lorem ipsum dolor</p>
						</a>
						<a class="slidItem col_3" data-rwd="l4x6">
							<div class="itemImg share"><img src="<?=$imgPath;?>demo/pro_4.jpg"></div>
							<h4 class="slidItemTitle">Fall</h4>
							<p class="slidItemDesc">Lorem ipsum dolor</p>
						</a>
						<a class="slidItem col_3" data-rwd="l4x6">
							<div class="itemImg share"><img src="<?=$imgPath;?>demo/pro_1.jpg"></div>
							<h4 class="slidItemTitle">Spring</h4>
							<p class="slidItemDesc">Lorem ipsum dolor</p>
						</a>
						<a class="slidItem col_3" data-rwd="l4x6">
							<div class="itemImg share"><img src="<?=$imgPath;?>demo/pro_5.jpg"></div>
							<h4 class="slidItemTitle">Summer</h4>
							<p class="slidItemDesc">Lorem ipsum dolor</p>
						</a>
						<a class="slidItem col_3" data-rwd="l4x6">
							<div class="itemImg share"><img src="<?=$imgPath;?>demo/pro_2.jpg"></div>
							<h4 class="slidItemTitle">Winter</h4>
							<p class="slidItemDesc">Lorem ipsum dolor</p>
						</a>
						<a class="slidItem col_3" data-rwd="l4x6">
							<div class="itemImg share"><img src="<?=$imgPath;?>demo/pro_3.jpg"></div>
							<h4 class="slidItemTitle">Snow</h4>
							<p class="slidItemDesc">Lorem ipsum dolor</p>
						</a>
						<a class="slidItem col_3" data-rwd="l4x6">
							<div class="itemImg share"><img src="<?=$imgPath;?>demo/pro_4.jpg"></div>
							<h4 class="slidItemTitle">Fall</h4>
							<p class="slidItemDesc">Lorem ipsum dolor</p>
						</a>
						<a class="slidItem col_3" data-rwd="l4x6">
							<div class="itemImg share"><img src="<?=$imgPath;?>demo/pro_1.jpg"></div>
							<h4 class="slidItemTitle">Spring</h4>
							<p class="slidItemDesc">Lorem ipsum dolor</p>
						</a>
						<a class="slidItem col_3" data-rwd="l4x6">
							<div class="itemImg share"><img src="<?=$imgPath;?>demo/pro_5.jpg"></div>
							<h4 class="slidItemTitle">Summer</h4>
							<p class="slidItemDesc">Lorem ipsum dolor</p>
						</a>
						<a class="slidItem col_3" data-rwd="l4x6">
							<div class="itemImg share"><img src="<?=$imgPath;?>demo/pro_2.jpg"></div>
							<h4 class="slidItemTitle">Winter</h4>
							<p class="slidItemDesc">Lorem ipsum dolor</p>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
