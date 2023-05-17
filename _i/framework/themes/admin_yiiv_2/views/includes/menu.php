<?php if(!empty($menus) and $router_class != 'auth'):?>
<ul class="sf-menu sf-js-enabled" id="mainmenu">
<?php
	foreach($menus as $k => $v){
		$link_tmp = '';
		if($v['link'] != '' and $v['link'] != '#'){
			$link_tmp = $v['link'];
		}
		// 避免只有root層，而沒有子項，而root層又沒有連結的狀況下出現
		if(empty($submenus[$v['id']]) and $link_tmp == ''){
			continue;
		}
		$current_root_menu = '';
		if($v['id'] == $default_menu){
			$current_root_menu = 'target';
		}
?>
		<li><a href="<?php echo $link_tmp?>"><?php echo $v['name']?></a>
<?php

		if(!empty($submenus[$v['id']])){
			// 子選單會跑兩次迴圈
			$current_sub_menu_showhide = 'none';
			foreach($submenus[$v['id']] as $kk => $vv){
				if($vv['id'] == $default_sub_menu){
					$current_sub_menu_showhide = 'block';
					continue;
				}
			}
?>
			<ul style="display: none; visibility: hidden;">
<?php
			foreach($submenus[$v['id']] as $kk => $vv){
				if($vv['id'] == $default_sub_menu){
					$current_sub_menu = 'target';	
				} else {
					$current_sub_menu = '';	
				}
?>
				<li><a href="<?php echo $vv['link']?>"><?php echo $vv['name']?></a></li>
<?php
			}
?>
			</ul>
<?php
		} // if
?>
		</li>
<?php
	} // foreach
?>
</ul>
<ul id="usermenu">
	<li><a href="<?php echo $this->createUrl('auth/logout', array('current_base64_url'=> $current_base64_url))?>"><?php G::te($theme_lang, 'Logout', null, '登出')?></a></li>
</ul>
<?php endif;?>

<?php if(0):?>
<ul class="sf-menu sf-js-enabled" id="mainmenu">
	<li><a href="dashboard.html">總覽</a></li>
	<li><a href="settings.html">網站設定</a></li>
	<li class="current"><a href="user.html">管理者權限設定</a></li>
	<li><a href="images.html">輪播圖管理</a></li>
	<li class=""><a href="news.html" class="sf-with-ul">最新消息管理<span class="sf-sub-indicator"> »</span></a>
	<ul style="display: none; visibility: hidden;">
		<li><a href="news.html">消息列表</a></li>
		<li><a href="add-news.html">新增消息</a></li>
	</ul>
	</li>
	<li class=""><a href="products.html" class="sf-with-ul">產品管理<span class="sf-sub-indicator"> »</span></a>
	<ul style="display: none; visibility: hidden;">
		<li><a href="products.html">產品列表</a></li>
		<li><a href="add-products.html">新增產品</a></li>
		<li><a href="products-class.html">分類管理</a></li>
	</ul>
	</li>
	<li class="">
	<a href="products.html" class="sf-with-ul">頁面管理<span class="sf-sub-indicator"> »</span></a>
	<ul style="display: none; visibility: hidden;">
		<li><a href="aboutus.html">關於我們</a></li>
		<li><a href="contact.html">聯絡我們</a></li>
	</ul>
	</li>
	<li><a href="db.html">客戶留言</a></li>
</ul>
<ul id="usermenu">
	<li><a href="#">登出</a></li>
</ul>
<?php endif;?>
