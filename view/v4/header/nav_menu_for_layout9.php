<div class="fullMenu_nav">
  <div class="fullMenuNav_list">
    <ul>

<?php if(0):?>
      <li><a href="about.php">關於我們</a></li>
      <li><a href="products.php">商品介紹</a></li>
      <li><a href="album.php">活動花絮</a></li>
      <li><a href="download.php">下載專區</a></li>
      <li><a href="news.php">最新消息</a></li>
      <li><a href="faq.php">問與答</a></li>
<?php endif?>

		<?php if(isset($data[$ID])):?>
			<?php foreach($data[$ID] as $k => $v):?>
				<li id="navlight_webmenu_<?php echo $v['id']?>" >
					<a href="<?php echo $v['url']?>"
						<?php if(isset($v['target']) and $v['target'] != ''):?> target="<?php echo $v['target']?>" <?php endif?> 
						<?php if(isset($v['anchor_class']) and $v['anchor_class'] != ''):?> class="<?php echo $v['anchor_class']?>" <?php endif?> 
						<?php if(isset($v['anchor_data_target']) and $v['anchor_data_target'] != ''):?> data-target="<?php echo $v['anchor_data_target']?>" <?php endif?> 
					>
						<span
						>
							<?php echo $v['name']?>
						</span>
					</a>
				</li>
			<?php endforeach?>
		<?php endif?>

    <?php if(0)://範例，設計需要的時候可以開?>
      <li class="navMenu_icon"><a href=""><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>ONLINE STORE</span></a></li>
    <?php endif?>
    </ul>
  </div><!-- .fullMenuNav_list -->
  <div class="fullMenu_social">
    <ul>
      <li><a href=""><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
      <li><a href=""><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
    </ul>
  </div><!-- .fullMenu_social -->
</div><!-- .fullMenu_nav -->
