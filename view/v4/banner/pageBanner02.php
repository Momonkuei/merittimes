<?php if($this->data['router_method'] != 'index' && $this->data['router_method'] != 'photocopyform_1' && !stristr($this->data['router_method'],'class_') && !stristr($this->data['router_method'],'classout_') ):?>
	<div class="pageBanner cowboyPageBanner01">
		<?php if(isset($data[$ID])):?>
			<?php foreach($data[$ID] as $k => $v):?>
				<?php if($k!=0) continue;//2021-05-06 內頁banner只顯示1張 by lota?>
				<img src="<?php echo $v['pic1g']?>" class="pc">
				<img src="<?php echo $v['pic2g']?>" class="mb">
			<?php endforeach?>
		<?php endif?>

		<?php //#43829?>
		<?php if(isset($data['pagebanner_field_data']) && $data['pagebanner_field_data']!=''):?>
			</* ?php echo $data['pagebanner_field_data']? */>
		<?php endif?>

		<?php if(0)://下面的區塊改由後台 形象首頁管理 > 內頁大圖 去上資料?>
		<div class="banner_content">
			<p class="banner_txt_one">SEE OUR</p>
			<p class="banner_txt_two">SERVICE</p>
			<div class="banner_line"></div>
			<img class="banner_line_logo" src="https://www.jaj.com.tw/images/banner-line-logo.png" alt="">
			<div class="banner_line"></div>
			<p class="banner_txt_three">INTERIOR DESIGN</p>
		</div>
		<?php endif?>
	</div>
<?php endif?>
