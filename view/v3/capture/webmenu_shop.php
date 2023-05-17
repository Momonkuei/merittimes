<?php

// 2018-09-13 這個檔案只是示範，目的是，可以客製電腦版的主選單的下拉，呈現不同的樣子
// "這裡不能用V1第二版"
//
// 語系的變數：$ml_key (只有這個變數可以用，因為它是從curl那邊傳來的)
//
// 使用這個功能的方式：
// source/menu/v2.php
// 搜尋capture字眼，大略在最下面，把那一段註解打開，填上menu_id，就可以使用了
//
// 或者是把下面這一段，複製到source/menu/v2.php的下面

/*
 * // 2018-09-13 試試看，加上一個可以處理不完全是ul li的結構的情況，幸康、常廣的案子有用到
 * if($position == 1){
 *		$menu_id = 1; // 從零開始的流水號
 * 
 *		$view = 'v3/capture/webmenu_product.php';
 *		$url = FRONTEND_DOMAIN.'/capture.php?ml_key='.$this->data['ml_key'].'&target='.$view;
 *		$ch = curl_init();
 *		curl_setopt($ch, CURLOPT_URL, $url);
 *		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 *		$output = curl_exec($ch);
 *		curl_close($ch);
 * 
 *		// echo $output;die;
 *		$tmp[$menu_id]['_replace_struct_0'] = $output;
 * }
 */

// 這個函式，是從source/menu/v2.php複製過來的，最初的版本，在mbpanel2.php裡面
// 跟LayoutV3放在一起的時候，不是跑這一支，而是跑source/menu/v2.php裡面的那支，要記得…
// 缺這個函式，是李哥發現的 2017-12-04
if(!function_exists('check_field_and_rebuild_array_by_multi_layer_menu')){
	function check_field_and_rebuild_array_by_multi_layer_menu($items,$seo) {

		$render = '';

		if($items and count($items) > 0){
		foreach ($items as $k => $item) {
			$render .= $k.'=>array('."\n";

			if(!isset($item['url'])){
				if(isset($item['__link']) and $item['__link'] != ''){ // 獨立資料表專用
					$item['url'] = $item['__link'];
				} elseif(isset($item['url1']) and $item['url1'] != ''){
					$item['url'] = $item['url1'];
				} else {
					$item['url'] = '';
				}
			}

			//如果網址是有效連結，則判斷是否需要做SEO化 by lota
			if($item['url'] != 'javascript:;' and isset($seo[$item['id']]) and $seo[$item['id']]['seo_script_name'] != ''){
				$item['url'] = $seo[$item['id']]['seo_script_name'].'.html';
			}

			if (!empty($item['child'])) {
				if(isset($item['child'][0]['__link']) and preg_match('/detail/', $item['child'][0]['__link'])){
				} elseif(isset($item['child'][0]['url1']) and preg_match('/detail/', $item['child'][0]['url1'])){
				} elseif(isset($item['child'][0]['url']) and preg_match('/detail/', $item['child'][0]['url'])){
					// 2017-12-13 為了在分類底下，加上分項
				} else {
					$item['url'] = 'javascript:;';
				}
				$render .= '\'child\'=>array('."\n";
				$render .= check_field_and_rebuild_array_by_multi_layer_menu($item['child'],$seo);
				$render .= '),'."\n"; // child
			}

			if(!isset($item['child'])){
				$item['child'] = array();
			}

			// 把屬性都處理好了，在顯示在頁面上
			// LI的屬性，輸出前準備
			$attr1 = '';
			$classes = array();
			if(isset($item['child']) and count($item['child']) > 0 and isset($item['depth'])){
				// 這裡要判斷層次
				if($item['depth'] == 1 and isset($item['has_child']) and $item['has_child'] === true){ 
					$classes[] = 'moreMenu';
				} elseif($item['depth'] == 2){ 
					$classes[] = 'moreMenu';
				}
			}
			if(isset($item['class']) and $item['class'] != ''){
				$classes[] = $item['class'];
			}
			if(count($classes) > 0){
				$attr1 .= ' class="'.implode(' ', $classes).'" ';
			}
			if(isset($item['id'])){
				$attr1 .= ' id="navlight_noname'.$item['id'].'" ';
			}
			$item['attr1'] = $attr1;

			// 把屬性都處理好了，在顯示在頁面上
			// Anchor的屬性，輸出前準備
			$attr2 = '';
			if(isset($item['target']) and $item['target'] != ''){
				$attr2 .= ' target="'.$item['target'].'" ';
			}
			if(isset($item['anchor_class']) and $item['anchor_class'] != ''){
				$attr2 .= ' class="'.$item['anchor_class'].'" ';
			}
			if(isset($item['anchor_data_target']) and $item['anchor_data_target'] != ''){
				$attr2 .= ' data-target="'.$item['anchor_data_target'].'" ';
			}
			if(isset($item['url'])){
				$attr2 .= ' href="'.$item['url'].'" ';
			}
			$item['attr2'] = $attr2;

			foreach($item as $kk => $vv){
				if(!is_array($vv)){
					$render .= '\''.$kk.'\'=>\''.$vv.'\','."\n";
				}
			}
			
			$render .= '),'."\n";
		}
		} // count

		return $render."\n";
	}
}

//$row = $this->cidb->where('is_enable',1)->where('type','datasource')->where('topic','shop_type_menu')->get('html')->row_array();
//if($row and isset($row['id'])){
//}

$layoutv3_datasource_id = 3706;
include GGG_BASEPATH.'../../layoutv3/dom5/datasource.php';

// 主選單用的
//$rowsg = $this->cidb->where('is_enable',1)->where('type','webmenu')->where('ml_key',$ml_key)->order_by('sort_id','asc')->get('html')->result_array();
?>

<?php if(isset($content)):?>
	<?php foreach($content as $k => $v):?>
		<li id="navlight_webmenu_<?php echo $v['id']?>" class=" <?php if(isset($v['child']) and !empty($v['child'])):?>moreMenu<?php endif?> <?php if(isset($v['class'])):?><?php echo $v['class'] //留給商品用的，可以加上multiMenu?><?php endif?>" >
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

			<?php if(isset($v['child']) and !empty($v['child'])):?>
				<ul>
				<?php foreach($v['child'] as $kk => $vv):?>
					<li class=" <?php if(isset($vv['child']) and !empty($vv['child'])):?>moreMenu<?php endif?> <?php if(isset($vv['class'])):?><?php echo $vv['class'] //留給商品用的，可以加上moreMenu?><?php endif?> ">
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
						<?php if(isset($vv['child']) and !empty($vv['child'])):?>
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
