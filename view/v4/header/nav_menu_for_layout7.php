<div class="fullMenu_nav">
  <div class="fullMenuNav_list">
    <ul class="menuLayout_7">
        <li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i>回首頁</a></li>
      <?php if (0) : ?>
        <li class="moreMenu"><a href="#">關於我們</a>
          <ul class="submenu">
            <li><a href="#">分類1-1</a>
              <ul class="submenu">
                <li><a href="#">分類2-1</a></li>
                <li><a href="#">分類2-2</a></li>
              </ul>
            </li>
            <li><a href="#">分類1-2</a>
              <ul class="submenu">
                <li><a href="#">分類2-1</a></li>
                <li><a href="#">分類2-2</a></li>
              </ul>
            </li>
            <li><a href="about.php">分類1-3</a></li>
          </ul>
        </li>
        <li class="moreMenu"><a href="products.php">商品介紹</a>
          <ul class="submenu">
            <li><a href="#">分類1-1</a>
              <ul class="submenu">
                <li><a href="#">分類2-1</a></li>
                <li><a href="#">分類2-2</a></li>
              </ul>
            </li>
            <li><a href="#">分類1-2</a>
              <ul class="submenu">
                <li><a href="#">分類2-1</a></li>
              </ul>
            </li>
            <li><a href="#">分類1-3</a></li>
          </ul>
        </li>
        <li class="moreMenu"><a href="album.php">活動花絮</a>
          <ul class="submenu">
            <li><a href="#">分類1-1</a>
              <ul class="submenu">
                <li><a href="#">分類2-1</a></li>
                <li><a href="#">分類2-2</a></li>
              </ul>
            </li>
            <li><a href="#">分類1-2</a>
              <ul class="submenu">
                <li><a href="#">分類2-1</a></li>
              </ul>
            </li>
            <li><a href="#">分類1-3</a></li>
          </ul>
        </li>
        <li class="moreMenu"><a href="download.php">下載專區</a>
          <ul class="submenu">
            <li><a href="#">分類1-1</a>
              <ul class="submenu">
                <li><a href="#">分類2-1</a></li>
                <li><a href="#">分類2-2</a></li>
              </ul>
            </li>
            <li><a href="#">分類1-2</a>
              <ul class="submenu">
                <li><a href="#">分類2-1</a></li>
              </ul>
            </li>
            <li><a href="#">分類1-3</a></li>
          </ul>
        </li>
        <li class="moreMenu"><a href="news.php">最新消息</a>
          <ul class="submenu">
            <li><a href="#">分類1-1</a>
              <ul class="submenu">
                <li><a href="#">分類2-1</a></li>
                <li><a href="#">分類2-2</a></li>
              </ul>
            </li>
            <li><a href="#">分類1-2</a>
              <ul class="submenu">
                <li><a href="#">分類2-1</a></li>
              </ul>
            </li>
            <li><a href="#">分類1-3</a></li>
          </ul>
        </li>
        <li><a href="faq.php">問與答</a></li>
      <?php endif ?>

      <?php if (0 && isset($data[$ID])) : ?>
        <?php foreach ($data[$ID] as $k => $v) : ?>
          <li id="navlight_webmenu_<?php echo $v['id'] ?>">
            <a href="<?php echo $v['url'] ?>" <?php if (isset($v['target']) and $v['target'] != '') : ?> target="<?php echo $v['target'] ?>" <?php endif ?> <?php if (isset($v['anchor_class']) and $v['anchor_class'] != '') : ?> class="<?php echo $v['anchor_class'] ?>" <?php endif ?> <?php if (isset($v['anchor_data_target']) and $v['anchor_data_target'] != '') : ?> data-target="<?php echo $v['anchor_data_target'] ?>" <?php endif ?>>
              <span>
                <?php echo $v['name'] ?>
              </span>
            </a>
          </li>
        <?php endforeach ?>
      <?php endif ?>

      <?php if (isset($data[$ID])) : ?>
		<?php foreach ($data[$ID] as $k => $v) : ?>
			<li class="moreMenu" id="navlight_webmenu_<?php echo $v['id'] ?>">
				<a href="<?php echo $v['url'] ?>" <?php if (isset($v['target']) and $v['target'] != '') : ?> target="<?php echo $v['target'] ?>" <?php endif ?> <?php if (isset($v['anchor_class']) and $v['anchor_class'] != '') : ?> class="<?php echo $v['anchor_class'] ?>" <?php endif ?> <?php if (isset($v['anchor_data_target']) and $v['anchor_data_target'] != '') : ?> data-target="<?php echo $v['anchor_data_target'] ?>" <?php endif ?>>
					<span>
						<?php echo $v['name'] ?>
					</span>
				</a>
				<?php if (isset($v['child']) and !empty($v['child']) and $v['has_child'] === true) : ?>
					<ul class="submenu">
						<?php foreach ($v['child'] as $kk => $vv) : ?>
							<li class=" <?php if (isset($vv['child']) and !empty($vv['child'])) : ?>moreMenu<?php endif ?>  <?php if (isset($vv['class'])) : ?><?php echo $vv['class'] //留給商品用的，可以加上moreMenu
																																								?><?php endif ?> ">
								<a href="<?php echo $vv['url'] ?>" <?php if (isset($vv['target']) and $vv['target'] != '') : ?> target="<?php echo $vv['target'] ?>" <?php endif ?> <?php if (isset($vv['anchor_class']) and $vv['anchor_class'] != '') : ?> class="<?php echo $vv['anchor_class'] ?>" <?php endif ?> <?php if (isset($vv['anchor_data_target']) and $vv['anchor_data_target'] != '') : ?> data-target="<?php echo $vv['anchor_data_target'] ?>" <?php endif ?>>
									<span>
										<?php echo $vv['name'] ?>
									</span>
								</a>
								<?php if (isset($vv['child']) and !empty($vv['child'])) : ?>
									<ul class="submenu">
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

      <li class="navMenu_icon"><a href=""><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>ONLINE STORE</span></a></li>
    </ul>
  </div><!-- .fullMenuNav_list -->
  <div class="fullMenu_social">
    <ul>
      <li><a href=""><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
      <li><a href=""><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
    </ul>
  </div><!-- .fullMenu_social -->
</div><!-- .fullMenu_nav -->