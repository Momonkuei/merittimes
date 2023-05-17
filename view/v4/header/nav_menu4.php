<?php //.hoverEffect_01選單特效-底線由下至上浮出，.hoverEffect_02選單特效-底線由中間展開，.hoverEffect_03選單特效-底線由左邊展開
?>
<ul class="navMenu hoverEffect_03">
	<?php //print_r($data[$ID]);  
	?>
	<?php if (isset($data[$ID])) : ?>
		<?php foreach ($data[$ID] as $k => $v) : ?>
			<li class="moreMenu" id="navlight_webmenu_<?php echo $v['id'] ?>">
				<a href="<?php echo $v['url'] ?>" <?php if (isset($v['target']) and $v['target'] != '') : ?> target="<?php echo $v['target'] ?>" <?php endif ?> <?php if (isset($v['anchor_class']) and $v['anchor_class'] != '') : ?> class="<?php echo $v['anchor_class'] ?>" <?php endif ?> <?php if (isset($v['anchor_data_target']) and $v['anchor_data_target'] != '') : ?> data-target="<?php echo $v['anchor_data_target'] ?>" <?php endif ?>>
					<span>
						<?php echo $v['name'] ?>
					</span>
				</a>
				<?php if (isset($v['child']) and !empty($v['child']) and $v['has_child'] === true) : ?>
					<ul>
						<?php foreach ($v['child'] as $kk => $vv) : ?>
							<li class=" <?php if (isset($vv['child']) and !empty($vv['child'])) : ?>moreMenu<?php endif ?>  <?php if (isset($vv['class'])) : ?><?php echo $vv['class'] //留給商品用的，可以加上moreMenu
																																								?><?php endif ?> ">
								<a href="<?php echo $vv['url'] ?>" <?php if (isset($vv['target']) and $vv['target'] != '') : ?> target="<?php echo $vv['target'] ?>" <?php endif ?> <?php if (isset($vv['anchor_class']) and $vv['anchor_class'] != '') : ?> class="<?php echo $vv['anchor_class'] ?>" <?php endif ?> <?php if (isset($vv['anchor_data_target']) and $vv['anchor_data_target'] != '') : ?> data-target="<?php echo $vv['anchor_data_target'] ?>" <?php endif ?>>
									<span>
										<?php echo $vv['name'] ?>
									</span>
								</a>
								<?php if (isset($vv['child']) and !empty($vv['child'])) : ?>
									<ul>
										<?php foreach ($vv['child'] as $kkk => $vvv) : ?>
											<li>
												<a href="<?php echo $vvv['url'] ?>" <?php if (isset($vvv['target']) and $vvv['target'] != '') : ?> target="<?php echo $vvv['target'] ?>" <?php endif ?> <?php if (isset($vvv['anchor_class']) and $vvv['anchor_class'] != '') : ?> class="<?php echo $vvv['anchor_class'] ?>" <?php endif ?> <?php if (isset($vvv['anchor_data_target']) and $vvv['anchor_data_target'] != '') : ?> data-target="<?php echo $vvv['anchor_data_target'] ?>" <?php endif ?>>
													<span>
														<?php echo $vvv['name'] ?>
													</span>
												</a>
											</li>
										<?php endforeach ?>
									</ul>
								<?php endif ?>
							</li>
						<?php endforeach ?>
					</ul>
				<?php endif ?>
			</li>
		<?php endforeach ?>
	<?php endif ?>

	<?php if (0) : ?>
		<li class="moreMenu"><a href="about.php?type=1"><span>關於我們</span></a>
			<ul>
				<li class="moreMenu"><a href="#">分類1-1</a>
					<ul>
						<li><a href="#">分類2-1</a></li>
						<li><a href="#">分類2-2</a></li>
						<li><a href="#">分類2-3</a></li>
					</ul>
				</li>
				<li class="moreMenu"><a href="#">分類1-2</a>
					<ul>
						<li><a href="#">分類2-1</a></li>
						<li><a href="#">分類2-2</a></li>
					</ul>
				</li>
				<li><a href="#">分類1-3</a></li>
			</ul>
		</li>
		<li class="moreMenu"><a href="products.php?type=1"><span>商品介紹</span></a>
			<ul>
				<li class="moreMenu"><a href="#">分類1-1</a>
					<ul>
						<li><a href="#">分類2-1</a></li>
						<li><a href="#">分類2-2</a></li>
						<li><a href="#">分類2-3</a></li>
					</ul>
				</li>
				<li class="moreMenu"><a href="#">分類1-2</a>
					<ul>
						<li><a href="#">分類2-1</a></li>
						<li><a href="#">分類2-2</a></li>
					</ul>
				</li>
				<li><a href="#">分類1-3</a></li>
			</ul>
		</li>
		<li class="moreMenu"><a href="album.php"><span>活動花絮</span></a>
			<ul>
				<li class="moreMenu"><a href="#">分類1-1</a>
					<ul>
						<li><a href="#">分類2-1</a></li>
						<li><a href="#">分類2-2</a></li>
					</ul>
				</li>
				<li class="moreMenu"><a href="#">分類1-2</a>
					<ul>
						<li><a href="#">分類2-1</a></li>
					</ul>
				</li>
			</ul>
		</li>
		<li class="moreMenu"><a href="news.php?type=1"><span>最新消息</span></a>
			<ul>
				<li class="moreMenu"><a href="#">分類1-1</a>
					<ul>
						<li><a href="#">分類2-1</a></li>
						<li><a href="#">分類2-2</a></li>
					</ul>
				</li>
				<li class="moreMenu"><a href="#">分類1-2</a>
					<ul>
						<li><a href="#">分類2-1</a></li>
					</ul>
				</li>
			</ul>
		</li>

		<li class="moreMenu"><a href="download.php?type=1"><span>下載專區</span></a>
			<ul>
				<li class="moreMenu"><a href="#">分類1-1</a>
					<ul>
						<li><a href="#">分類2-1</a></li>
						<li><a href="#">分類2-2</a></li>
					</ul>
				</li>
				<li class="moreMenu"><a href="#">分類1-2</a>
					<ul>
						<li><a href="#">分類2-1</a></li>
					</ul>
				</li>
			</ul>
		</li>
		<li><a href="contact.php"><span>聯絡我們</span></a>
		</li>
	<?php endif ?>

	<?php if (0) : ?>
		<li class="navMenu_icon"><a href=""><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>ONLINE STORE</span></a></li>
		<li class="navMenu_control">
			<div class="swiper-button-prev"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27 44" width="11" height="16">
					<path d="M0,22L22,0l2.1,2.1L4.2,22l19.9,19.9L22,44L0,22L0,22L0,22z">
				</svg></div>
		</li>
		<li class="navMenu_control">
			<div class="swiper-button-next"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27 44" width="11" height="16">
					<path d="M27,22L27,22L5,44l-2.1-2.1L22.8,22L2.9,2.1L5,0L27,22L27,22z">
				</svg></div>
		</li>
	<?php endif ?>
</ul>