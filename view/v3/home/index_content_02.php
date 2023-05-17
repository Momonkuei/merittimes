<div class="indexContent_2">
	<div class="Bbox_1c">
		<div>
			<div>
				<section class="flex3c block">

					<div>
						<div>
							<h4 class="boxTitle">About Us</h4>
							<div class="aboutImg itemImg"><img src="<?=$imgPath;?>index-img-about.jpg"></div>
							<p data-txtlen="50">馬斯特是一家勇於創新、執行力強的公司，以「追求成長，持續節能環保及價值創新，成為值得信賴的全球卓越鋼鐵企業」為願景，積極落實「團隊、企業、踏實、求新」馬斯特精神，以及「增進社會福祉、落實實際績效、發揮群體力量、講求人性管理」馬斯特經營理念，除持續深耕鋼鐵本業外，亦致力協助下游相關產業升級，提升整體產業國際競爭力。</p>
						</div>
						<div>
							<a href="company_<?php echo $this->data['ml_key']?>.php" class="btn-cis1">Read More</a>
						</div>
					</div>

					<div>
						<div>
							<h4 class="boxTitle">Products</h4>
							<div class="aboutImg itemImg"><img src="<?=$imgPath;?>index-img-about.jpg"></div>
							<p data-txtlen="50">馬斯特是一家勇於創新、執行力強的公司，以「追求成長，持續節能環保及價值創新，成為值得信賴的全球卓越鋼鐵企業」為願景，積極落實「團隊、企業、踏實、求新」馬斯特精神，以及「增進社會福祉、落實實際績效、發揮群體力量、講求人性管理」馬斯特經營理念，除持續深耕鋼鐵本業外，亦致力協助下游相關產業升級，提升整體產業國際競爭力。</p>
							<?/*
							<div class="proList">
								<a href="" class="item">
									<div><div class="itemImg"> <img src="<?=$imgPath;?>demo/pro_1.jpg"> </div></div>
									<div><h4 class="itemTitle">手臂系統整合-M800</h4><p class="itemContent" data-txtlen="25">TD00002PG 主要用途為建築結構、造船、橋樑、油氣管路、機械構造、壓力容器及耐候耐蝕用鋼板。製程控制能力良好，厚度及平坦度優於國際規範標準。</p></div>
								</a>
								<a href="" class="item">
									<div><div class="itemImg"> <img src="<?=$imgPath;?>demo/pro_1.jpg"> </div></div>
									<div><h4 class="itemTitle">上卸料系統 TD00002PG</h4><p class="itemContent" data-txtlen="25">氣管路、機械構造、壓力容器及耐候耐蝕用鋼板。製程控制能力良好，厚度及平坦度優於國際規範標準。</p></div>
								</a>
								<a href="" class="item">
									<div><div class="itemImg"> <img src="<?=$imgPath;?>demo/pro_1.jpg"> </div></div>
									<div><h4 class="itemTitle">西芝手臂 TD00002PG</h4><p class="itemContent" data-txtlen="25">TD00002PG 主要用途為建築結構、造船、橋樑、油氣管路、機械構造、壓力容器及耐候耐蝕用鋼板。製程控制能力良好，厚度及平坦度優於國際規範標準。</p></div>
								</a>
							</div>
							*/?>
						</div>
						<div>
							<a href="product_<?php echo $this->data['ml_key']?>.php" class="btn-cis1">Read More</a>
						</div>
					</div>

					<div>
						<div>
							<h4 class="boxTitle">News</h4>
							<?/*
							<ul class="newsList" l="layer" ls="html:news" lp="andwhere:is_home---1,orderby:start_date desc,pidas:is_news,limit:1---5" >
								<li l="list"><a href="newsdetail_<?php echo $this->data['ml_key']?>.php?id={/id/}"><span class="newsDate">{/start_date/}</span>{/topic/}</a></li>
								<li><a href=""><span class="newsDate">2015.01.30</span>持續深耕鋼鐵本業外，亦致力協助下游相關產業升級，提升整體產業國際競爭力。</a></li>
								<li><a href=""><span class="newsDate">2013.01.28</span>追求成長，持續節能環保及價值創新，成為值得信賴的全球卓越鋼鐵企業</a></li>
								<li><a href=""><span class="newsDate">2010.01.20</span>98年榮獲經濟部頒發第17屆「產業科技發展卓越創新成就獎」</a></li>
								<li><a href=""><span class="newsDate">2009.01.10</span>持續深耕鋼鐵本業外，亦致力協助下游相關產業升級，提升整體產業國際競爭力。</a></li>
								<li><a href=""><span class="newsDate">2009.01.10</span>追求成長，持續節能環保及價值創新，成為值得信賴的全球卓越鋼鐵企業</a></li>
							</ul>
							*/?>
							<ul class="newsList idxNewsListType" l="layer" ls="html:news" lp="andwhere:is_home---1,orderby:start_date desc,pidas:is_news,limit:1---5" >
								<li l="list">
									<a href="newsdetail_<?php echo $this->data['ml_key']?>.php?id={/id/}">
										<div class="newsText"><span>{/topic/}</span></div>
										<span class="newsDate">{/start_date/}</span>
									</a>
								</li>
								<li><a href=""><span class="newsDate">2015.01.30</span>持續深耕鋼鐵本業外，亦致力協助下游相關產業升級，提升整體產業國際競爭力。</a></li>
								<li><a href=""><span class="newsDate">2013.01.28</span>追求成長，持續節能環保及價值創新，成為值得信賴的全球卓越鋼鐵企業</a></li>
								<li><a href=""><span class="newsDate">2010.01.20</span>98年榮獲經濟部頒發第17屆「產業科技發展卓越創新成就獎」</a></li>
								<li><a href=""><span class="newsDate">2009.01.10</span>持續深耕鋼鐵本業外，亦致力協助下游相關產業升級，提升整體產業國際競爭力。</a></li>
								<li><a href=""><span class="newsDate">2009.01.10</span>追求成長，持續節能環保及價值創新，成為值得信賴的全球卓越鋼鐵企業</a></li>
							</ul>
						</div>
						<div>
							<a href="news_<?php echo $this->data['ml_key']?>.php" class="btn-cis1">Read More</a>
						</div>
					</div>


				</section>


				<?/*點圖片 LightBox
				<section class="block">
					<div class="slidBlock itemList photos"  data-slick='{"slidesToShow": 6, "slidesToScroll": 1}'>
						<div class="slidItem"> <a href="<?=$imgPath;?>index-img-1.jpg" class="itemImg swipebox" rel="indexSlidAlbum"><img src="<?=$imgPath;?>index-img-1.jpg"></a> </div>
						<div class="slidItem"> <a href="<?=$imgPath;?>index-img-2.jpg" class="itemImg swipebox" rel="indexSlidAlbum"><img src="<?=$imgPath;?>index-img-2.jpg"></a> </div>
						<div class="slidItem"> <a href="<?=$imgPath;?>index-img-3.jpg" class="itemImg swipebox" rel="indexSlidAlbum"><img src="<?=$imgPath;?>index-img-3.jpg"></a> </div>
						<div class="slidItem"> <a href="<?=$imgPath;?>index-img-4.jpg" class="itemImg swipebox" rel="indexSlidAlbum"><img src="<?=$imgPath;?>index-img-4.jpg"></a> </div>
						<div class="slidItem"> <a href="<?=$imgPath;?>index-img-5.jpg" class="itemImg swipebox" rel="indexSlidAlbum"><img src="<?=$imgPath;?>index-img-5.jpg"></a> </div>
						<div class="slidItem"> <a href="<?=$imgPath;?>index-img-6.jpg" class="itemImg swipebox" rel="indexSlidAlbum"><img src="<?=$imgPath;?>index-img-6.jpg"></a> </div>
					</div>
				</section>
				*/?>


				<?/*點圖片後 連結*/?>
				<section class="block">
					<div class="blockTitle txtCenter">
						<span>服務項目</span>
						<small>SERVICE ITEMS</small>
					</div>
					<div class="slidBlock"  data-slick='{"slidesToShow": 6, "slidesToScroll": 1}'>
						<div class="slidItem"> <a href="about.php?type=1" class="itemImg"><img src="<?=$imgPath;?>index-img-1.jpg"></a> </div>
						<div class="slidItem"> <a href="about.php?type=1" class="itemImg"><img src="<?=$imgPath;?>index-img-2.jpg"></a> </div>
						<div class="slidItem"> <a href="about.php?type=1" class="itemImg"><img src="<?=$imgPath;?>index-img-3.jpg"></a> </div>
						<div class="slidItem"> <a href="about.php?type=1" class="itemImg"><img src="<?=$imgPath;?>index-img-4.jpg"></a> </div>
						<div class="slidItem"> <a href="about.php?type=1" class="itemImg"><img src="<?=$imgPath;?>index-img-5.jpg"></a> </div>
						<div class="slidItem"> <a href="about.php?type=1" class="itemImg"><img src="<?=$imgPath;?>index-img-6.jpg"></a> </div>
					</div>
				</section>




			</div>
		</div>
	</div>
</div>
