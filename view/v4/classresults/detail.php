<meta property="og:url" content="<?php echo FRONTEND_DOMAIN . $_SERVER['REQUEST_URI'] ?>" m="head_end" />
<meta property="og:type" content="website" m="head_end" />
<meta property="og:title" content="讀報教育-班級成果內頁" m="head_end" />
<meta property="og:description" content="" m="head_end" />
<?php if (isset($data[$ID]) and isset($data[$ID]['pic']) and $data[$ID]['pic'] != '') : ?>
    <meta property="og:image" content="<?php echo FRONTEND_DOMAIN . '/' . $data[$ID]['pic'] ?>" m="head_end" />
<?php else : ?>
    <meta property="og:image" content="<?php echo FRONTEND_DOMAIN ?>/images/fb_share.jpg" m="head_end" />
<?php endif ?>


<section class="sectionBlock" data-block="9">
    <div class="container">
        <div class="blockTitle text-center v4_animate fadeUp">
            <span>BlockTitle</span>
            <small>區塊標題</small>
        </div>
        <p class="v4_animate fadeUp delay_03">
            領先業界穩定品質之外，各類售後服務與定期校正的需求，在產品細節上力求設計感與形象的重要性，通過證體評鑑，榮獲經濟部標準檢驗局頒授中華民國實驗室認證體系認可證書。領先業界穩定品質之外，各類售後服務與定期校正的需求，在產品細節上力求設計感與形象的重要性，通過證體評鑑，榮獲經濟部標準檢驗局頒授中華民國實驗室認證體系認可證書。
        </p>
    </div>
</section>

<section class="sectionBlock overlap4" data-block="45">
    <div class="container">
        <div class="overlapBox colRight">
            <?php //.orderBox 992px改變overlap區塊順序，如不需要改變區塊順序請取消.orderBox 
            ?>
            <div class="textBox BoxBorderL">
                <div>
                    <div class="blockTitle text-right">
                        <small class="v4_animate fadeUp">Best Brand</small>
                        <span class="v4_animate fadeUp delay_02">ABOUT OUR COMPANY</span>
                    </div>
                    <p class="text-right v4_animate fadeUp delay_03">Lorem ipsum dolor sit amet, consectetur
                        adipiscing elit. Aliquam eget sapien sapien. Curabitur in metus urna. In hac habitasse
                        platea dictumst. Phasellus eu sem sapien, sed vestibulum velit. Nam purus nibh, lacinia non
                        faucibus et, pharetra in dolor. Sed iaculis posuere diam ut cursus. Morbi commodo sodales
                        nisi id sodales. Proin consectetur, nisi id commodo imperdiet, metus nunc consequat lectus,
                        id bibendum diam velit et dui. Proin massa magna, vulputate nec bibendum nec, posuere nec
                        lacus.</p>
                    <a class="overlapBtn text-center v4_animate fadeUp delay_04" href="">MORE ABOUT</a>
                    <div class="borderR"></div>
                </div>
            </div>
            <div class="imgBox v4_animate fadeLeft delay_06"><img src="images_v4/index/overlap4.png" alt=""></div>
        </div>
    </div>
</section>



<section class="sectionBlock overlap4" data-block="46">
    <div class="container">
        <div class="overlapBox">
            <div class="imgBox v4_animate fadeRight delay_06"><img src="images_v4/index/overlap4L.png" alt=""></div>
            <div class="textBox BoxBorderR">
                <div>
                    <div class="blockTitle text-left">
                        <small class="v4_animate fadeUp">Best Brand</small>
                        <span class="v4_animate fadeUp delay_02">ABOUT OUR COMPANY</span>
                    </div>
                    <p class="v4_animate fadeUp delay_03">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Aliquam eget sapien sapien. Curabitur in metus urna. In hac habitasse platea dictumst.
                        Phasellus eu sem sapien, sed vestibulum velit. Nam purus nibh, lacinia non faucibus et,
                        pharetra in dolor. Sed iaculis posuere diam ut cursus. Morbi commodo sodales nisi id
                        sodales. Proin consectetur, nisi id commodo imperdiet, metus nunc consequat lectus, id
                        bibendum diam velit et dui. Proin massa magna, vulputate nec bibendum nec, posuere nec
                        lacus.</p>
                    <a class="overlapBtn text-center v4_animate fadeUp delay_04" href="">MORE ABOUT</a>
                    <div class="borderL"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="sectionBlock cowboyBlock_1" data-block="49">
    <div class="container">
        <div class="blockTitle">
            <span class="v4_animate fadeUp">Manufacturing Processes</span>
            <small class="v4_animate fadeUp delay_03">Our carbon fiber production team includes craftsmen that have
                been honing in the craft of mastering composite material for decades.For more than 50 years we had
                manufactured more than 48 million rackets. And more than 1.4 million carbon fiber bicycles for the
                past 14 years. We had helped numerous sportsmen and women to win world and Olympic titles.Our
                current carbon fiber composite products, including sports, automobiles, robotics, medical and
                aerospace.</small>
        </div>

        <div class="flipster">
            <div id="flat">
                <ul class="flip-items">
                    <li data-flip-title="Sanding">
                        <img src="images_v4/flipster_01.jpg">
                        <p>Sanding</p>
                    </li>
                    <li data-flip-title="Decal Application">
                        <img src="images_v4/flipster_02.jpg">
                        <p>Decal Application</p>
                    </li>
                    <li data-flip-title="Painting">
                        <img src="images_v4/flipster_03.jpg">
                        <p>Painting</p>
                    </li>
                </ul>
            </div>

            <a class="flip-btn flip-prev" href="javascript:;">
                <img src="images_v4/arrow_left.svg" alt="">
            </a>
            <a class="flip-btn flip-next" href="javascript:;">
                <img src="images_v4/arrow_right.svg" alt="">
            </a>
        </div>
    </div>
</section>
<section class="sectionBlock" data-about="13">
    <div class="container">
        <div class="blockTitle text-center">
            <span><?php echo $blockTitle_span ?></span>
            <small><?php echo $blockTitle_small ?></small>
        </div>
        <div class="row">
            <div class="col-lg-6 video ">
                <a href="javascript:;" data-url="https://www.youtube.com/watch?v=-NOVnVVd0NA" title="影片4">
                    <div class="<?php echo $data['image_ratio']; //變數在source/core.php
                                ?>  itemImgHover hoverEffect1">
                        <img src="https://via.placeholder.com/690x520" alt="">
                    </div>
                </a>


                <div class="subBlockTitle"><?php echo $subBlockTitle ?></div>
                <p><?php echo $defaultText2 ?></p>
            </div>
            <div class="col-lg-6">
                <a href="javascript:;" data-url="https://www.youtube.com/watch?v=-NOVnVVd0NA" title="影片4">
                    <div class="<?php echo $data['image_ratio']; //變數在source/core.php
                                ?>  itemImgHover hoverEffect1">
                        <img src="https://via.placeholder.com/690x520" alt="">
                    </div>
                </a>
                <div class="subBlockTitle"><?php echo $subBlockTitle ?></div>
                <p><?php echo $defaultText2 ?></p>
            </div>
        </div>
    </div><!-- .container -->
</section><!-- .sectionBlock -->
<?
//設定分頁基本參數 
// $page = 0;
// if (isset($_GET['page']) and $_GET['page'] > 0) {
// 	$page = $_GET['page'];
// }
// $limit_count = 14; //一頁顯示幾筆
// $page_search = '';

// $_datatable = 'praylist';
// $query = $cidb->where('is_enable', '1')->where('class_id', $_GET['d'])->order_by('sort_id asc,update_time desc,id desc')->get($_datatable);
// $_tmp_all = $query->result_array();
// // print_r($_tmp_all);die;
// $total_num = $query->num_rows();
// $total_page = ceil($total_num / $limit_count);
// $page = ($total_page < $page) ? 1 : ($page < 1) ? 1 : $page;
// $query1 = $cidb->limit($limit_count, (($page - 1) * $limit_count))->get($_datatable);

// $_tmp = $query1->result_array();
?>
<section class="col-12 col-sm-12 sectionBlock">
    <div>
        <?php /*
      <div class="pageTitleStyle-2 text-center">
        <span>DOWNLOAD</span>
        <small>檔案下載</small>
      </div>
      */ ?>

        <?php //$classificationMenu='classificationMenu_type1'; include 'view/widget/classificationMenu.php'; 
        ?>

        <?php /* //分類的標題...不知道要不要
      <div class="blockTitle">
        <span>下載分類</span>
      </div>
      */ ?>

        <?php /* //這邊應該是分類的簡述
      <p>以下一般常見問題，如有其他問題請與我們聯絡，這裡是問與答表頭簡述文字，以下為非正式文字，北是走素線關們生，識合民後知去那刻在家場意一評，道高組非得小，安沒國美音晚球一意我社樹在有開後量。他利般土何器華認上他養投才帶明們提建小。港登具技如方原樣；過酒照響、來速研說。</p>
      */ ?>
        <div class="responsive_tbl">
            <table class="dataTable">
                <thead>
                    <tr>
                        <th><?php echo t('檔案名稱', 'tw') ?></th>
                        <th><?php echo t('檔案大小', 'tw') ?></th>
                        <th><?php echo t('最後更新時間', 'tw') ?></th>
                        <th><?php echo t('下載', 'tw') ?></th>
                    </tr>
                </thead>
                <tbody>


                    <tr>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                        <td>
                            <a class="btn-cis1" <?php if (isset($v['href1']) and $v['href1'] != '') : ?> href="<?php echo $v['href1'] ?>" target="_blank" <?php endif ?> <?php if (isset($v['anchor1_class']) and $v['anchor1_class'] != '') : ?> class="<?php echo $v['anchor1_class'] ?>" <?php endif ?> <?php if (isset($v['anchor1_data_target']) and $v['anchor1_data_target'] != '') : ?> data-target="<?php echo $v['anchor1_data_target'] ?>" <?php endif ?>><i class="fa fa-download" aria-hidden="true"></i><?php echo t('DOWNLOAD', 'en') ?></a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div><!-- .responsive_tbl -->
        <?/*<div class="pageNumber">
			<ul>
				<?php if(isset($data[$ID]['prev_url'])):?>
					<?php if($data[$ID]['prev_url'] != ''):?>
						<li class="prev"><a href="<?php echo $data[$ID]['prev_url']?>"><?php echo t('Prev','en')?></a></li>
					<?php else:?>
						<li class="prev disabled"><a href="javascript:;"><?php echo t('Prev','en')?></a></li>
					<?php endif?>
				<?php endif?>
				<li><?php echo $data[$ID]['pagination']['control']['now']?></li>
				<li>/</li>
				<li><?php echo $data[$ID]['pagination']['control']['total']?></li>
				<?php if(isset($data[$ID]['next_url'])):?>
					<?php if($data[$ID]['next_url'] != ''):?>
						<li class="next"><a href="<?php echo $data[$ID]['next_url']?>"><?php echo t('Next','en')?></a></li>
					<?php else:?>
						<li class="next disabled"><a href="javascript:;"><?php echo t('Next','en')?></a></li>
					<?php endif?>
				<?php endif?>
			</ul>
		</div>*/ ?><!-- .pageNumber -->
    </div>
</section><!-- .sectionBlock -->