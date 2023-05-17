<meta property="og:url" content="<?php echo FRONTEND_DOMAIN . $_SERVER['REQUEST_URI'] ?>" m="head_end" />
<meta property="og:type" content="website" m="head_end" />
<meta property="og:title" content="<?php echo $data[$ID]['name'] ?>" m="head_end" />
<meta property="og:description" content="<?php echo strip_tags($data[$ID]['content']) ?>" m="head_end" />
<?php if (isset($data[$ID]) and isset($data[$ID]['pic']) and $data[$ID]['pic'] != '') : ?>
	<meta property="og:image" content="<?php echo FRONTEND_DOMAIN . '/' . $data[$ID]['pic'] ?>" m="head_end" />
<?php else : ?>
	<meta property="og:image" content="<?php echo FRONTEND_DOMAIN ?>/images/fb_share.jpg" m="head_end" />
<?php endif ?>
<div id="scroll" class="indexContent_1 web-detail-page">

	<!-- 純文字區塊 -->
	<section class="sectionBlock" data-about="1">
		<div class="container">
			<div class="innerBlock">
				<div class="blockTitle text-center">
					<span><?php echo $data[$ID]['topic'] ?></span>
					<?/*<small><?php echo $data[$ID]['topic'] ?></small>*/ ?>
				</div>

				<p class="text-center"><?= (!empty($data[$ID]['field_tmp']) ? nl2br($data[$ID]['field_tmp']) : '') ?></p>
			</div><!-- .innerBlock -->

		</div><!-- .container -->
	</section><!-- .sectionBlock -->

	<!-- 兩個區塊 -->
	<? if (!empty($left_pict)) { ?>
		<section class="sectionBlock overlap4" data-block="46">
			<div class="container">
				<div class="overlapBox">
					<div class="imgBox v4_animate fadeRight delay_06 overlapSlide">
						<? foreach ($left_pict as $k => $v) { ?>
							<img src="_i/assets/upload/news<?= $num_type ?>other1/<?= $v['pic1'] ?>" alt="">
						<? } ?>
					</div>
					<div class="textBox BoxBorderR">
						<div>
							<div class="blockTitle text-left">
								<small class="v4_animate fadeUp"><?= (!empty($data[$ID]['other1']) ? $data[$ID]['other1'] : '') ?></small>
								<?/*<span class="v4_animate fadeUp delay_02">ABOUT OUR COMPANY</span>*/ ?>
							</div>
							<p class="v4_animate fadeUp delay_03"><?= (!empty($data[$ID]['other2']) ? nl2br($data[$ID]['other2']) : '') ?></p>
							<!-- <a class="overlapBtn text-center v4_animate fadeUp delay_04" href="">MORE ABOUT</a>-->
							<div class="borderL"></div>
						</div>
					</div>
				</div>
			</div>
		</section>
	<? } ?>

	<? if (!empty($right_pict)) { ?>
		<section class="sectionBlock overlap4 overlap4-second" data-block="45">
			<div class="container">
				<div class="overlapBox colRight">
					<?php //.orderBox 992px改變overlap區塊順序，如不需要改變區塊順序請取消.orderBox 
					?>
					<div class="textBox BoxBorderL">
						<div>
							<div class="blockTitle text-right">
								<small class="v4_animate fadeUp"><?= (!empty($data[$ID]['other4']) ? $data[$ID]['other4'] : '') ?></small>
								<?/*<span class="v4_animate fadeUp delay_02">ABOUT OUR COMPANY</span>*/ ?>
							</div>
							<p class="text-right v4_animate fadeUp delay_03"><?= (!empty($data[$ID]['other5']) ? nl2br($data[$ID]['other5']) : '') ?></p>
							<div class="borderR"></div>
						</div>
					</div>
					<div class="imgBox v4_animate fadeLeft delay_06 overlapSlide">
						<? foreach ($right_pict as $k => $v) { ?>
							<img src="_i/assets/upload/news<?= $num_type ?>other2/<?= $v['pic1'] ?>" alt="">
						<? }; ?>
					</div>
				</div>
			</div>
		</section>
	<? } ?>


	<!-- 活動花絮 -->
	<? if (!empty($multi_pic)) { ?>
		<section class="sectionBlock cowboyBlock_1  sectionBlock-activities" data-block="49">
			<div class="container">
				<div class="blockTitle">
					<span class="v4_animate fadeUp text-center">活動花絮</span>
					<!-- <small class="v4_animate fadeUp delay_03">
						Our carbon fiber production team
					</small> -->
				</div>

				<div class="flipster">
					<div id="flat">
						<ul class="flip-items">
							<? foreach ($multi_pic as $k => $v) { ?>
								<li data-flip-title="Sanding">
									<img src="_i/assets/upload/news<?= $num_type ?>other3/<?= $v['pic1'] ?>">
									<p><?= $v['topic'] ?></p>
								</li>
							<? } ?>
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
	<? } ?>

	<!-- 影音播放 -->
	<? if (!empty($data[$ID]['other9']) || !empty($data[$ID]['other10'])) { ?>
		<section class="sectionBlock" data-about="13">
			<div class="container">
				<div class="blockTitle text-center">
					<span>影音分享</span>
					<!-- <span><?php echo $blockTitle_span ?></span> -->
					<!-- <small><?php echo $blockTitle_small ?></small> -->
				</div>
				<div class="row">
					<? if (!empty($data[$ID]['other9'])) {
						if (!empty($data[$ID]['pic2'])) {
							$pic = '_i/assets/upload/news' . $num_type . '/' . $data[$ID]['pic2'];
						} else {
							$pic = 'https://img.youtube.com/vi/' . $data[$ID]['other9_pic'] . '/0.jpg';
						}
					?>
						<div class="col-lg-6">
							<div class="video">
								<div class="videoContent videoContent-index detailpage-video">
									<a href="javascript:;" data-url="<?= $data[$ID]['other9'] ?>" title="">
										<div class="itemImg  itemImgHover hoverEffect1">
											<img src="<?= $pic ?>" onerror="javascript:this.src='images_v4/default.png'">
										</div>
									</a>
								</div>
							</div>
							<div class="subBlockTitle text-center"><?= (!empty($data[$ID]['other11']) ? $data[$ID]['other11'] : '') ?></div>
						</div>
					<? } ?>
					<? if (!empty($data[$ID]['other10'])) {
						if (!empty($data[$ID]['pic3'])) {
							$pic = '_i/assets/upload/news' . $num_type . '/' . $data[$ID]['pic3'];
						} else {
							$pic = 'https://img.youtube.com/vi/' . $data[$ID]['other10_pic'] . '/0.jpg';
						}
					?>
						<div class="col-lg-6">
							<div class="video">
								<div class="videoContent videoContent-index detailpage-video">
									<a href="javascript:;" data-url="<?= $data[$ID]['other10'] ?>" title="">
										<div class="itemImg  itemImgHover hoverEffect1">
											<img src="<?= $pic ?>" onerror="javascript:this.src='images_v4/default.png'">
										</div>
									</a>
								</div>
							</div>
							<div class="subBlockTitle text-center"><?= (!empty($data[$ID]['other12']) ? $data[$ID]['other12'] : '') ?></div>
						</div>
					<? } ?>
				</div>
			</div><!-- .container -->
		</section><!-- .sectionBlock -->
	<? } ?>
	<!-- 檔案下載 -->
	<?php if (isset($download_list) && !empty($download_list)) : ?>
		<div class="container">
			<section class="col-12 col-sm-12 sectionBlock">
				<div>
					<div class="pageTitleStyle-2 text-center">
						<span>Download</span>
						<small>檔案下載</small>
					</div>
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

								<?php foreach ($download_list as $k => $v) : ?>
									<tr>
										<td><?php echo $v['topic'] ?></td>
										<td><?php echo $v['file_size'] ?></td>
										<td><?php echo $v['update_time'] ?></td>
										<td>
											<a class="btn-cis1" <?php if (isset($v['href1']) and $v['href1'] != '') : ?> href="<?php echo $v['href1'] ?>" target="_blank" <?php endif ?> <?php if (isset($v['anchor1_class']) and $v['anchor1_class'] != '') : ?> class="<?php echo $v['anchor1_class'] ?>" <?php endif ?> <?php if (isset($v['anchor1_data_target']) and $v['anchor1_data_target'] != '') : ?> data-target="<?php echo $v['anchor1_data_target'] ?>" <?php endif ?>><i class="fa fa-download" aria-hidden="true"></i><?php echo t('DOWNLOAD', 'en') ?></a>
										</td>
									</tr>
								<?php endforeach ?>

								
								
							</tbody>
						</table>
					</div><!-- .responsive_tbl -->

				</div>
			</section><!-- .sectionBlock -->
		</div>
	<?php endif ?>
</div><!-- #scroll -->
</div><!-- .newsD_main -->