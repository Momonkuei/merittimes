<!-- func|start|remove_new_line -->

<?php if(0):?>
<ul class="navMenu navlight" data-active=">li" data-multimenu="true" data-defactive="active" data-defactiveid="navlight_webmenu_<?php echo $this->data['func_name_id']?>">
<ul class="navMenu navlight" data-active=">li" data-multimenu="true" data-novalue="true"><?php // data-novalue如果是false，主選單的亮燈就會依照引數?>

<ul class="menu_main cis3-bk-90 togglearea" data-item="li" data-title="li>a" data-content="ul" data-nodefault="true">
</ul>
<?php endif?>


	<?php if(isset($data[$ID])):?>
		<?php foreach($data[$ID] as $k => $v):?>
			<li id="navlight_webmenu_<?php echo $v['id']?>" class=" <?php if(0 and isset($v['child']) and count($v['child']) > 0 and $v['has_child'] === true):?>moreMenu<?php endif?> <?php if(isset($v['class'])):?><?php echo $v['class'] //留給商品用的，可以加上multiMenu?><?php endif?>" >
				<a href="<?php echo $v['url']?>"
					<?php if(isset($v['target']) and $v['target'] != ''):?> target="<?php echo $v['target']?>" <?php endif?> 
					<?php if(isset($v['anchor_class']) and $v['anchor_class'] != ''):?> class="<?php echo $v['anchor_class']?>" <?php endif?> 
					<?php if(isset($v['anchor_data_target']) and $v['anchor_data_target'] != ''):?> data-target="<?php echo $v['anchor_data_target']?>" <?php endif?> 
				>
					<span
					>
						<?php echo $v['name']?>
					</span>
					<span
					>
						<?php echo $v['other1']?>
					</span>
				</a>

				<?php if(0 and isset($v['child']) and count($v['child']) > 0 and $v['has_child'] === true):?>
					<ul>
					<?php foreach($v['child'] as $kk => $vv):?>
						<li class=" <?php if(isset($vv['class'])):?><?php echo $vv['class'] //留給商品用的，可以加上moreMenu?><?php endif?> ">
							<a href="<?php echo $vv['url']?>" 
								<?php if(isset($vv['target']) and $vv['target'] != ''):?> target="<?php echo $vv['target']?>" <?php endif?>
								<?php if(isset($vv['anchor_class']) and $vv['anchor_class'] != ''):?> class="<?php echo $vv['anchor_class']?>" <?php endif?> 
								<?php if(isset($vv['anchor_data_target']) and $vv['anchor_data_target'] != ''):?> data-target="<?php echo $vv['anchor_data_target']?>" <?php endif?> 
							>
								<span
								>
									<?php echo $vv['name']?>
								</span>
							</a>
							<?php if(isset($vv['child']) and count($vv['child']) > 0):?>
								<ul>
								<?php foreach($vv['child'] as $kkk => $vvv):?>
									<li>
										<a href="<?php echo $vvv['url']?>" 
											<?php if(isset($vvv['target']) and $vvv['target'] != ''):?> target="<?php echo $vvv['target']?>" <?php endif?> 
											<?php if(isset($vvv['anchor_class']) and $vvv['anchor_class'] != ''):?> class="<?php echo $vvv['anchor_class']?>" <?php endif?> 
											<?php if(isset($vvv['anchor_data_target']) and $vvv['anchor_data_target'] != ''):?> data-target="<?php echo $vvv['anchor_data_target']?>" <?php endif?> 
										>
											<span
											>
												<?php echo $vvv['name']?>
											</span>
										</a>
									</li>
								<?php endforeach?>
								</ul>
							<?php endif?>
						</li>
					<?php endforeach?>
					</ul>
				<?php endif?>
			</li>
		<?php endforeach?>
	<?php endif?>

	<?php if(0):?>
	<li  class="moreMenu"><a href="about.php?type=1"><span>關於我們</span></a>
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
	<?php endif?>

<!-- func|end|remove_new_line -->
