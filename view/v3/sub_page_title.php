<section class="Bbox_1c">
	<div>
		<div class="text-right">
<?php echo $AA?>
		</div>
	</div>
</section>


<section class="Bbox_1c">
	<?php 
	// 有開SEO功能才需要
	unset($_constant);
	eval('$_constant = '.strtoupper('seo_open').';');
	if($_constant && $this->data['router_method']!='productdetail'){
		$_sptxt = 'h1';
		$_sptxt2 = 'h2';
	}else{
		//2020-11-04 jane說ming說主標副標交換 2020-12-22 ming說 V3 不需交換
		// $_sptxt2 = 'span';
		// $_sptxt = 'small';
		$_sptxt = 'span';
		$_sptxt2 = 'small';
		if(!isset($data[$ID]['name'])){
			$_sptxt2 = 'span';
		}			
	}
	//2021-07-14 這裡是給購物產品用的 by lota
	if(isset($_GET['cid'])){
		$_breadcrumb = $this->data['_breadcrumb'][1];		
		$data[$ID]['name'] = $_breadcrumb['name'];
	}
	?>

	<div>
		<div>
			<div class="pageTitle">
				<?php if(isset($data[$ID]['name'])):?><<?php echo $_sptxt?>><?php echo $data[$ID]['name']?></<?php echo $_sptxt?>><?php endif?>
				<<?php echo $_sptxt2?>><?php if(isset($data[$ID]['sub_name'])):?><?php echo $data[$ID]['sub_name']?><?php endif?></<?php echo $_sptxt2?>>
			</div>   
		</div>
	</div>
</section>
