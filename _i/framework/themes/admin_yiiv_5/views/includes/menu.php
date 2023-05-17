<?php if(!empty($menus) and $router_class != 'auth'):?>
	<div class="page-sidebar navbar-collapse collapse">
		<ul class="page-sidebar-menu" id="mainmenu">
			<li>
				<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				<div class="sidebar-toggler hidden-phone"></div>
				<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
			</li>
			
			<?php
				$tmp = $this->_get_admin_menu_classes();
				$menu_items = $tmp['data'];

				//2022/11/01 #46127  增加線上捐款功能開關----------------------------------------------------------------------------------------------
				$donation_data = $this->cidb->where('keyname','function_constant_donation')->get('sys_config')->row_array();
				$productcontent_data = $this->cidb->where('keyname','function_constant_product_content')->get('sys_config')->row_array();
				if(!empty($donation_data) && $donation_data['keyval']=='false'){
					foreach($menu_items as $k => $v){
						if(stristr($v['link'],'donationorder')){
							unset($menu_items[$k]);
						}
					}
				}
				//2023/01/04 #46799 產品圖文功能開關---------------------------------------------------------------------------------------------------
				if(!empty($productcontent_data) && $productcontent_data['keyval']=='false'){
					foreach($menu_items as $k => $v){
						if(stristr($v['link'],'productcontent')){
							unset($menu_items[$k]);
						}
					}
				}
				//--------------------------------------------------------------------------------------------------------------------------------end

				/*
				 *  ["REQUEST_URI"]=>
				 *    string(24) "/_i/backend.php?r=banner"
				 */
				 // 2016/8/13 lota 加入 vir_path_c 常數
				if(preg_match('/index\.php/', $_SERVER['REQUEST_URI'])){
					$url = str_replace(vir_path_c.'index.php?r=', '', $_SERVER['REQUEST_URI']);
				} else {
					$url = str_replace(vir_path_c.'backend.php?r=', '', $_SERVER['REQUEST_URI']);
				}
				
				$tmps = explode('/', $url);
				$tmps = explode('&', $tmps[0]);
				$url = $tmps[0];
				$url = 'backend.php?r='.$tmps[0];
				// $row = $this->cidb->where('is_enable',1)->where('link',trim($url))->get('admin_menu')->row_array();

				if(defined('BACKEND_MENU_MERGE')){
					if(BACKEND_MENU_MERGE == true){ // 2019-11-21
						$row = $this->cidb->where('is_enable',1)->where('ml_key','tw')->where('link',trim($url))->get('admin_menu')->row_array();
					} else {
						$row = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['admin_switch_data_ml_key'])->where('link',trim($url))->get('admin_menu')->row_array();
					}
				} else {
					$row = $this->cidb->where('is_enable',1)->where('link',trim($url))->get('admin_menu')->row_array();
				}

				if(isset($row['name'])){
					$focus = $this->_search_admin_menu_tree($tmp['tree'], $tmp['sample'], $row['name'], 'xxxxxxx');

					// render menu
					if(count($focus) > 0){
						$top_menu = $this->bootstrap_menu($menu_items,0,array(),$focus);
					} else {
						$top_menu = $this->bootstrap_menu($menu_items,0,array());
					}

					// 把那個因為權限不足而只剩節點的情況，利用simplehtmldom把空節點刪掉
					$simplehtml = new SimpleHtmlDom;
					$html = str_get_html($top_menu, true, true, DEFAULT_TARGET_CHARSET, false);
					foreach($html->find('*[class=hideme]') as $k => $v){ // 規則也可以下成 *[rulev1] 
						$html->find('*[class=hideme]', $k)->parent()->innertext = '';
					}
					echo $html;
				}
			?>

		</ul>
	</div>
<?php endif?>
