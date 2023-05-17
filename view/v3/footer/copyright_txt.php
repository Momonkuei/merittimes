<section class="copyRightTxt">Copyright © <?php echo date('Y')?> XXXXXXXXXX All Rights Reserved. 
	<span>
		<a href="http://www.buyersline.com.tw" class="copyrightTxt Designed" title="網頁設計" target="_blank">
			<img alt="網頁設計" title="網頁設計" src="images/<?php echo $this->data['ml_key']?>/txt-copyright.svg">網頁設計
		</a>
		<?php if(0):?>
			<span class="copyrightTxt byBLC">
				<img alt="BuyersLine Company" title="BuyersLine Company" src="images/<?php echo $this->data['ml_key']?>/txt-byBLC.svg">
				by BLC
			</span>
		<?php endif?>
		<h1></h1>
		<img src="images/<?php echo $this->data['ml_key']?>/txt-byBLC.svg">
	</span>
	<?if($this->data['router_method'] == 'index'):?>
                        <h1 style="font-size: 12px">
                            <span>
                                <a href="index_tw.php">太陽能支架</a>、<a href="index_tw.php">充電站</a>、<a href="index_tw.php">充電樁經銷</a>、<a href="#">電動車充電樁</a>
                            </span>
                        </h1>
                        <?php }?>
	<?php
	unset($_constant);
	eval('$_constant = '.strtoupper('seo_open').';');
	?>
	<?php if($_constant):?>	
		<a href="<?php echo $url_prefix.'sitemap'.$url_suffix//2020-01-07 下午Ming說的?>">Sitemap</a>
	<?php endif?>
</section>

<?php
unset($_constant);
eval('$_constant = '.strtoupper('seo_open').';');
?>
<?php if($this->data['router_method'] == 'index' and $_constant and isset($this->data['sys_configs']['seo_index_footer_h1_content_'.$this->data['ml_key']])):?>
	<?php echo $this->data['sys_configs']['seo_index_footer_h1_content_'.$this->data['ml_key']]?>
<?php endif?>
