<div class="copyRight">Copyright © <?php echo date('Y') ?> 讀報教育 All Rights Reserved.網頁設計 by BLC
	<span>
		<a href="https://www.buyersline.com.tw" class="copyrightTxt Designed" title="網頁設計" target="_blank">
			<? if ($this->data['ml_key'] == "tw") { ?>
				<img alt="網頁設計" title="網頁設計" src="images_v4/footer/txt-copyright.svg">網頁設計
			<? } else { ?>
				<img alt="Designed" title="Designed" src="images_v4/footer/txt-copyright.svg">Designed
			<? } ?>
		</a>
		<span class="copyrightTxt byBLC">
			<img alt="BuyersLine Company" title="BuyersLine Company" src="images_v4/footer/txt-byBLC.svg">
			by BLC
		</span>
		<?php
		unset($_constant);
		eval('$_constant = ' . strtoupper('seo_open') . ';');
		?>
		<?php if ($_constant) : ?>
			<a href="<?php echo $url_prefix . 'sitemap' . $url_suffix //2020-01-07 下午Ming說的
						?>">Sitemap</a>
		<?php endif ?>
	</span>
</div><!-- .copyRight -->


<?php
unset($_constant);
eval('$_constant = ' . strtoupper('seo_open') . ';');
?>
<?php if ($this->data['router_method'] == 'index' and $_constant and isset($this->data['sys_configs']['seo_index_footer_h1_content_' . $this->data['ml_key']])) : ?>
	<?php echo $this->data['sys_configs']['seo_index_footer_h1_content_' . $this->data['ml_key']] ?>
<?php endif ?>