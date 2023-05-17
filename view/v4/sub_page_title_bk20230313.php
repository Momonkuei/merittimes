<div class="text-center apply-title">
	<?php
	// 有開SEO功能才需要
	unset($_constant);
	eval('$_constant = ' . strtoupper('seo_open') . ';');
	if ($_constant && $this->data['router_method'] != 'productdetail') {
		$_sptxt = 'h1';
		$_sptxt2 = 'h2';
	} else {
		//2020-11-04 jane說ming說主標副標交換
		$_sptxt2 = 'span';
		$_sptxt = 'small';

		//如果是非中文語系就還原原本的樣子 2021-04-27 by lota
		if ($this->data['ml_key'] != 'tw') {
			//$_sptxt = 'span';
			//$_sptxt2 = 'small';	

			//不知道為十麼非中文語系的主標會不見...這邊手動拉麵包屑補回 by lota 2021-6-2
			if (isset($this->data['_breadcrumb'][1])) {
				$_breadcrumb = $this->data['_breadcrumb'][1];
				$data[$ID]['sub_name'] = $_breadcrumb['name'];
			}
			//非中文環境 最新消息的副標怪怪的...用這段修正 by lota 2021-08-10
			if (($this->data['router_method'] == 'news' or $this->data['router_method'] == 'newsdetail') and isset($_GET['id']) and $_GET['id'] > 0) {
				$_breadcrumb = $this->data['_breadcrumb'][2];
				$data[$ID]['name'] = $_breadcrumb['name'];
			}
			//有些狀況非中文版的需要把副標移除
			if (isset($data[$ID]['name']) && $data[$ID]['name'] == $data[$ID]['sub_name']) {
				unset($data[$ID]['name']);
			}
		}

		// if(isset($data[$ID]['name']) && $data[$ID]['name']!='' && $data[$ID]['sub_name']==''){
		// 	$data[$ID]['sub_name'] = $data[$ID]['name'];
		// 	unset($data[$ID]['name']);
		// }
	}
	// 客製 for 羅布森路跑 等待有緣人把這邊的規則併入....by lota
	// if($this->data['router_method'] == 'journey' and isset($_GET['id']) and $_GET['id'] > 0){
	// 	$_count = count($this->data['_breadcrumb']);
	// 	if($_count == 4){
	// 		$data[$ID]['name'] = $this->data['_breadcrumb'][2]['name'];
	// 	}
	// }
	// #
	if (($this->data['router_method'] == 'product' or $this->data['router_method'] == 'photo') and isset($_GET['id']) and $_GET['id'] > 0) {
		$_count = count($this->data['_breadcrumb']);

		$_breadcrumb = end($this->data['_breadcrumb']);

		$data[$ID]['name'] = $_breadcrumb['name'];
	}
	$_mode = 1;		// 1: 英文在上，中文在下, 2: 中文在上，英文在下,  3: 只有中文

	//產品內頁強迫改 mode 1 2022-02-17 ming說的
	if ($this->data['router_method'] == 'productdetail') {
		$_mode = 1;
	}

	switch ($_mode) {
		default:
		case '1':
			//這段是防呆，目的是避免後台沒有填小標時，中文在下面不好看...
			if (!isset($data[$ID]['sub_name']) or (isset($data[$ID]['sub_name']) && $data[$ID]['sub_name'] == '')) {
				$data[$ID]['sub_name'] = $data[$ID]['name'];
				unset($data[$ID]['name']);
			}
	?>

			<<?php echo $_sptxt2 ?>><?php if (isset($data[$ID]['sub_name'])) : ?><?php echo $data[$ID]['sub_name'] ?><?php endif ?></<?php echo $_sptxt2 ?>>
			<<?php echo $_sptxt ?>><?php if (isset($data[$ID]['name'])) : ?><?php echo $data[$ID]['name'] ?><?php endif ?></<?php echo $_sptxt ?>>
		<?php
			break;
		case '2':
			$_sptxt = 'span';
			$_sptxt2 = 'small';
		?>
			<<?php echo $_sptxt ?>><?php if (isset($data[$ID]['name'])) : ?><?php echo $data[$ID]['name'] ?><?php endif ?></<?php echo $_sptxt ?>>
			<<?php echo $_sptxt2 ?>><?php if (isset($data[$ID]['sub_name'])) : ?><?php echo $data[$ID]['sub_name'] ?><?php endif ?></<?php echo $_sptxt2 ?>>
		<?php
			break;
		case '3':
			$_sptxt = 'span';
			$_sptxt2 = 'small';
			if (!isset($data[$ID]['name'])) {
				$data[$ID]['name'] = $data[$ID]['sub_name'];
			}
		?>
			<<?php echo $_sptxt ?>><?php if (isset($data[$ID]['name'])) : ?><?php echo $data[$ID]['name'] ?><?php endif ?></<?php echo $_sptxt ?>>
	<?php
			break;
	}
	?>
</div>