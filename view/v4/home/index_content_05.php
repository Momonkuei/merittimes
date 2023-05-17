
<?php
// http://網站的網址/_i/backend.php?r=datasource/update&param=v3486
// index_news - html:news
// andwhere:is_home---1,orderby:sort_id desc
$layoutv3_datasource_id = 3620;
include 'layoutv3/dom5/datasource.php';
// var_dump($content);
// $row = $content;
$this->data['html_news_3620'] = array();
if(isset($content) and count($content) > 0){
    foreach($content as $k => $v){
        // 客製欄位使用
        // blha blha 
        if($k < 5){ //預設顯示5筆
            $this->data['html_news_3620'][$k] = $v;
        }        
    }
}
// var_dump($this->data['html_news_3486']);
// $data[$ID] = $this->data['html_news_3486'];
?>

<?php //請在第一個區塊加上id="scroll",ScrollDown才會有作用 ?>

<?php //文字在左圖片在右 ?>
<section class="sectionBlock indexNews1">
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<div class="blockTitle">
					<span>NEWS</span>
					<small>最新消息</small>
					<div class="titleDot"><span></span><span></span><span></span><span></span><span></span></div>
				</div>
			<div>
				<ul class="indexnewsList" l="layer" ls="html_news_3620">
					<li l="list"><a href="news_{/ml_key/}?id={/id/}"><span class="indexNewsListText">{/topic/}</span><span class="newsTime">{/date1___year/}.{/date1___MONTH/}.{/date1___day/}</span></a></li>
					<li><a href=""><span class="indexNewsListText">持續深耕鋼鐵本業外，亦致力協助下游相關產業升級，提升整...</span><span class="newsTime">2020.10.22</span></a></li>
					<li><a href=""><span class="indexNewsListText">追求成長，持續節能環保及價值創新，成為值得信賴的全球卓...</span><span class="newsTime">2020.10.22</span></a></li>
					<li><a href=""><span class="indexNewsListText">持續深耕鋼鐵本業外，亦致力協助下游相關產業升級，提升整...</span><span class="newsTime">2020.10.22</span></a></li>
					<li><a href=""><span class="indexNewsListText">98年榮獲經濟部頒發第17屆「產業科技發展卓越創新成就獎」</span><span class="newsTime">2020.10.22</span></a></li>
				</ul>
			</div>
		<div><a class="more-text" href="news_<?php echo $this->data['ml_key']?>.php">Read More</a></div>
		</div>
		<div class="col-lg-6 img-rectangle"><img src="images_v4/w01/demo/pic_3.jpg" alt=""></div>
		</div>
	</div>
</section>

<?php //圖片在左文字在右 ?>
<section class="sectionBlock indexNews1">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 img-rectangle"><img src="images_v4/w01/demo/pic_3.jpg" alt=""></div>
			<div class="col-lg-6">
				<div class="blockTitle">
					<span>NEWS</span>
					<small>最新消息</small>
					<div class="titleDot"><span></span><span></span><span></span><span></span><span></span></div>
				</div>
			<div>
				<ul class="indexnewsList" l="layer" ls="html_news_3620">
					<li l="list"><a href="news_tw?id={/id/}"><span class="indexNewsListText">{/topic/}</span><span class="newsTime">{/date1___year/}.{/date1___MONTH/}.{/date1___day/}</span></a></li>
					<li><a href=""><span class="indexNewsListText">持續深耕鋼鐵本業外，亦致力協助下游相關產業升級，提升整...</span><span class="newsTime">2020.10.22</span></a></li>
					<li><a href=""><span class="indexNewsListText">追求成長，持續節能環保及價值創新，成為值得信賴的全球卓...</span><span class="newsTime">2020.10.22</span></a></li>
					<li><a href=""><span class="indexNewsListText">持續深耕鋼鐵本業外，亦致力協助下游相關產業升級，提升整...</span><span class="newsTime">2020.10.22</span></a></li>
					<li><a href=""><span class="indexNewsListText">98年榮獲經濟部頒發第17屆「產業科技發展卓越創新成就獎」</span><span class="newsTime">2020.10.22</span></a></li>
				</ul>
			</div>
			<div><a class="more-text" href="news_tw.php">Read More</a></div>
		</div>
		</div>
	</div>
</section>

	<section class="sectionBlock">
	<div class="container">
		<div class="innerBlock">
			<div class="row">
				<div class="col-md-6">
					<div class="blockTitle">
						<span>BlockTitle</span>
						<small>區塊標題</small>
						<span class="underLine no-margin-left"></span>
     </div>
					<div class="subBlockTitle">設計、專業、領先</div>
					<p>領先業界穩定品質之外，各類售後服務與定期校正的需求，在產品細節上力求設計感與形象的重要性，通過證體評鑑，榮獲經濟部標準檢驗局頒授中華民國實驗室認證體系認可證書。</p>
				</div>
				<div class="col-md-6">
					<div class="img-rectangle img-scrollBox"><img class="" src="images_v4/w01/demo/pic_3.jpg" alt=""></div>
				</div>
			</div>
		</div>
	</div>
	</section>


  <section class="sectionBlock itemBlock1">
    <div class="container">
      <div class="innerBlock">
        <div class="blockTitle text-center">
          <span>SERVICE ITEMS</span>
          <small>服務項目</small>
          <span class="underLine"></span>
        </div>
        <div class="spaceList">
          <div class="row">
            <div class="col-lg-3 col-md-6">
              <a href=""><div class="itemImg img-rectangle itemImgHover hoverEffect2"><img src="images_v4/w01/index-img-1.jpg" alt=""></div></a>
              <div class="subBlockTitle text-center">小區塊標題</div>
              <p class="text-center">設定預設內容後，放置的每一個文字及圖片，將成為您正式網站會呈現出的內容設定。</p>
            </div>
            <div class="col-lg-3 col-md-6">
              <a href=""><div class="itemImg img-rectangle itemImgHover hoverEffect2"><img src="images_v4/w01/index-img-2.jpg" alt=""></div></a>
              <div class="subBlockTitle text-center">小區塊標題</div>
              <p class="text-center">設定預設內容後，放置的每一個文字及圖片，將成為您正式網站會呈現出的內容設定。</p>
            </div>
            <div class="col-lg-3 col-md-6">
              <a href=""><div class="itemImg img-rectangle itemImgHover hoverEffect2"><img src="images_v4/w01/index-img-3.jpg" alt=""></div></a>
              <div class="subBlockTitle text-center">小區塊標題</div>
              <p class="text-center">設定預設內容後，放置的每一個文字及圖片，將成為您正式網站會呈現出的內容設定。</p>
            </div>
            <div class="col-lg-3 col-md-6">
              <a href=""><div class="itemImg img-rectangle itemImgHover hoverEffect2"><img src="images_v4/w01/index-img-4.jpg" alt=""></div></a>
              <div class="subBlockTitle text-center">小區塊標題</div>
              <p class="text-center">設定預設內容後，放置的每一個文字及圖片，將成為您正式網站會呈現出的內容設定。</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


	<section class="sectionBlock">
		<div class="container">
			<div class="innerBlock">
				<div class="blockTitle text-center">
     <span>BlockTitle</span>
     <small>區塊標題</small>
					<span class="underLine"></span>
    </div>
				<div class="slidBlock3">
					<div class="slidItem">
						<a href="">
							<div class="itemImg square img-rectangle itemImgHover hoverEffect1"><img src="images_v4/w01/demo/team_1.jpg" alt=""></div>							
						</a>
						
					</div>
					<div class="slidItem">
						<a href="">
							<div class="itemImg square img-rectangle itemImgHover hoverEffect1"><img src="images_v4/w01/demo/team_2.jpg" alt=""></div>							
						</a>
						
					</div>
					<div class="slidItem">
						<a href="">
							<div class="itemImg square img-rectangle itemImgHover hoverEffect1"><img src="images_v4/w01/demo/team_3.jpg" alt=""></div>							
						</a>
						
					</div>
					<div class="slidItem">
						<a href="">
							<div class="itemImg square img-rectangle itemImgHover hoverEffect1"><img src="images_v4/w01/demo/team_4.jpg" alt=""></div>							
						</a>
						
					</div>
					<div class="slidItem">
						<a href="">
							<div class="itemImg square img-rectangle itemImgHover hoverEffect1"><img src="images_v4/w01/demo/team_5.jpg" alt=""></div>							
						</a>
						
					</div>
				</div>
			</div>
		</div>
	</section>











