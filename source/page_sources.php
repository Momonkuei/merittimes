<?php

// 資料(程式)與版型配對的規則
// 這裡面的東西將會先執行，這點很重要，先執行哦
// 如果你要穿插使用程式碼，請把衝突的部份記得拿掉
// 所以意味著next_data_id程序，將會跑兩次
$page_sources = array(
	'share' => array(
		'core' => array(
			'alias' => '共用程式或是宣告',
			// rule，沒星號，就是絕對的對應，有星號，就是條件的對應，可以下多條的規則
			'file' => array(
				'cttdemo/ctt', // cttdemo
				'v2/index',
				'v3/index', // 每次一定會符合，而且只會符合一次
				'v4/index',
				'^index', // A方案
				//'system/layoutit',
			),
			//'condition' => array(), // NULL無條件-同時這也是預設值, single, multi, single|multi, multi|single|single...
			//'eval' => '$data[$ID] = $webmenu;', // 如果這個元素有存在，那就不會去載入或處理source元素
			'source' => 'core',
		),
		'end' => array(
			'file' => array(
				'system/end$', // 每次一定會符合，而且只會符合一次
			),
			'source' => 'core/end',
		),
		// 功能的大標、小標，小標可能會沒有
		'page_title' => array(
			'file' => array(
				'v3/sub_page_title$',
				'v4/sub_page_title$',
				'cttdemo/sub_page_title', // cttdemo
			),
			'eval' => '$data[$ID]=array("name"=>$this->data["func_name"],"sub_name"=>$this->data["func_en_name"]);',
		),
		// source/system/page_source_data在用的
		'category_title' => array(
			'file' => array(
				'v3/category_title',
				'v4/category_title',
			),
			// 'source' => 'XXX',
		),
		'breadcrumb' => array(
			'file' => array(
				'v3/breadcrumb$',
				'v3/default/list_top', // 2020-01-13 #34327
				'v3/default/list_bottom', // 2020-01-13 #34327
				'v4/widget/breadcrumb',
				'cttdemo/breadcrumb', // cttdemo
				'v2/breadcrumb$',
			),
			//'eval' => '$data[$ID]=array(array("name"=>"HOME","url"=>"/"),array("name"=>$this->data["func_name"],"url"=>$this->data["func_name_href"]));',
			'source' => 'core/breadcrumb',
		),
		// 2017-11-20 試著撰寫通用分項功能
		'general_item' => array(
			'alias' => '通用分項功能',
			'file' => array(
				// product v4
				'v4/product/list*',
				'v4/news/list*',
				'v4/photo/list*',
				'v4/download/list*',
				'v4/video/list*',
				'v4/faq/list*',
				'v4/location/list*',
				'v4/news5/list*',
				'v4/news2/list*',
				'v4/news3/list*',
				'v4/news4/list*',

				// news
				'v3/news/type1_*',
				'cttdemo/news/type1_*',

				// video
				'v3/video/type*',
				'cttdemo/video/type*',

				// faq
				'v3/faq/type*',
				'cttdemo/faq/type*',

				// download
				'v3/download/type*',
				'cttdemo/download/type*',

				// location
				'v3/location/type*', 

				// product
				'v3/product/list1_*',

				// shop
				'v3/shop/list1_*',
				'v4/shop/list*',

				// album
				'v3/album/type1*',
				'v3/album/type2*',
			),
			// 'source' => 'news/type',
			'source' => 'system/general_item',
		),
		'pagenav' => array(
			'alias' => '分頁',
			'file' => array(
				'v3/pagenav*',
				'v4/widget/pageNumber',
				'cttdemo/pagenav$',
			),
			'eval' => '$data[$ID]=$pageRecordInfo;',
		),
		'post' => array(
			'alias' => '通用表單的post',
			'source' => 'system/form_post',
		),
		// 通用搜尋要放在分項資料之下、分頁之上
		'search' => array(
			'alias' => '通用搜尋功能',
			'file' => array(
				'system/search*', // 通常這個檔案的內容是空白的
			),
			'source' => 'system/search',
		),
	),
	'widget' => array(
		// source/system/page_source_data在用的
		'search_form' => array(
			'file' => array(
				'v3/widget/search_form',
				'v4/widget/search_form',
			),
			//'source' => 'XXX',
		),
	),
	'top_link_menu' => array(
		'v1' => array(
			'alias' => '最上方的連結，最多四個',
			// rule，沒星號，就是絕對的對應，有星號，就是條件的對應，可以下多條的規則
			'file' => array(
				'v3/header/top_link_menu*',
				'v4/header/toplink/*',
				'cttdemo/top', // cttdemo
			),
			'condition' => array(), // NULL無條件-同時這也是預設值, single, multi, single|multi, multi|single|single...
			// 'eval' => '$data[$ID] = $webmenu;', // 如果這個元素有存在，那就不會去載入或處理source元素
			'source' => 'top_link_menu/v1',
		),
	),
	'sitemap' => array(
		'general' => array(
			'alias' => '不知道要寫什麼',
			// rule，沒星號，就是絕對的對應，有星號，就是條件的對應，可以下多條的規則
			'file' => array(
				'v3/sitemap*',
				'v4/sitemap*',
			),
			'condition' => array(), // NULL無條件-同時這也是預設值, single, multi, single|multi, multi|single|single...
			'source' => 'sitemap/v1',
		),
	),
	'webmenu' => array(
		'v1' => array(
			'alias' => '上方主選單',
			'file' => array(
				'v3/header/nav_menu*',
				'v4/header/nav_menu*',
				'v4/header/scrollnav*',
				'cttdemo/top_menu', // cttdemo
				'v2/nav_menu*',
				'system/sitemapxml',
				'system/empty_datasource/webmenu',
				//'sitemap*',
				//'footer/sitemap_type*',
			),
			'condition' => array(), // NULL無條件-同時這也是預設值, single, multi, single|multi, multi|single|single...
			// 'source' => 'menu/v1',
			'source_eval_start' => '$this->data["_webmenu_navlight_name"]="navlight_webmenu_";',
			'source' => 'menu/v2', // 2017-11-15 大改版，也為了支援DOM第二版的先前作業
			'source_eval_end' => 'unset($this->data["_webmenu_navlight_name"]);',
		),
		'bottom' => array(
			'alias' => '下方主選單',
			//'file' => array(
			//	'^index$', // 每次一定會符合，而且只會符合一次
			//	//'^end$', // 每次一定會符合，而且只會符合一次
			//),
			// rule，沒星號，就是絕對的對應，有星號，就是條件的對應，可以下多條的規則
			'file' => array(
				//'header/nav_menu*',
				//'footer/sitemap_type*', // 形象網站
				//'footer/sitemap_type1', // 購物站(footer4) 會符合超過一次
				'v3/footer/layout*', // 購物站(footer4)
				'cttdemo/left/promenu', // cttdemo
			),
			//'condition' => array(), // NULL無條件-同時這也是預設值, single, multi, single|multi, multi|single|single...
			//'eval' => '$data[$ID] = $webmenu;', // 如果這個元素有存在，那就不會去載入或處理source元素
			'source' => 'menu/bottom',
		),
		// 2020-10-14 想要執行這裡，那product-sub、shop-sub那裡就不要勾，要不然會衝到，因為file規則一樣的關係
		'sub' => array(
			'alias' => '次選單，例如v2的中間(晨寬還有相信夢想)、webmaster的左邊',
			'file' => array(
				'v3/default/page_submenu', // 懷舊
				'v3/default/promenu*', // 2017-12-15 李哥說可以先加各功能的側邊選單
				'v3/default/sidemenu*', // 2017-12-27 winnie做的，2018-04-26 這邊會吃到兩個資料流，另一個是default/sidemenu_empty_datasource
				'v4/widget/sidemenu/*',
				'v4/widget/page_submenu*', // 懷舊
				'system/empty_datasource/sidemenu',
			),
			'condition' => array(),
			'source_eval_start' => '$this->data["_webmenu_navlight_name"]="navlight_";',
			'source' => 'menu/sub',
			'source_eval_end' => 'unset($this->data["_webmenu_navlight_name"]);',
		),
		// 2019-08-05
		'sub_other1' => array(
			'alias' => '讓沒主選單的功能，也能有側邊選單，用法請參照w/rwd_v3/source/menu/sub_other1.php',
			'file' => array(
				'v3/default/page_submenu',
				'v3/default/promenu*', // 2017-12-15 李哥說可以先加各功能的側邊選單
				'v3/default/sidemenu*', // 2017-12-27 winnie做的，2018-04-26 這邊會吃到兩個資料流，另一個是default/sidemenu_empty_datasource
				'system/empty_datasource/sidemenu',
			),
			'condition' => array(),
			'source_eval_start' => '$this->data["_webmenu_navlight_name"]="navlight_";',
			'source' => 'menu/sub_other1',
			'source_eval_end' => 'unset($this->data["_webmenu_navlight_name"]);',
		),
	),
	'home' => array(
		'banner' => array(
			'alias' => '首頁banner',
			'file' => array(
				'v3/home/banner*',
				'v4/banner/banner*',
				'v4/banner/pageBanner*',
				'cttdemo/banner', // cttdemo
				'v2/child/view_banner_01', // layoutv2
			),
			// 'source' => 'home/banner',
			'source' => 'home/banner3',
		),
		// 2020-10-29
		'shop' => array(
			'alias' => '首頁如果也要購物，點下去會彈出來的那種',
			'file' => array(
				'v3/widget/add_cart_panel',
				'v4/widget/add_cart_panel',
				'v3/end/shop',
				'v4/end/shop',
			),
			'source' => 'home/shop',
		),

		/*
		 * 大概是W01在用的
		 */
		'ad' => array(
			'alias' => '首頁ad',
			'file' => array(
				'v3/home/home_ad*',
			),
			'source' => 'home/ad',
		),
		'content' => array(
			'alias' => '首頁content',
			'file' => array(
				'v3/home/home_content*',
			),
			'source' => 'home/content',
		),
		'marquee' => array(
			'alias' => '首頁marquee',
			'file' => array(
				'v3/home/home_marquee*',
			),
			'source' => 'home/marquee',
		),

		/*
		 * 大概是W02在用的
		 */
		'company_news_product' => array(
			'alias' => '首頁的關於我們 等等',
			'file' => array(
				'v3/home/indexcontent*',
			),
			'condition' => array('single|multi|single|multi|single'),
			'source' => 'home/company_news_product',
		),

		/*
		 * 這是W09專用的
		 */
		'banner2' => array(
			'alias' => '首頁banner',
			'file' => array(
				'v3/home/indexcontent*',
			),
			'source' => 'home/banner2',
		),

		/*
		 * 大概是W15在用的
		 */
		'image_news' => array(
			'alias' => '',
			'file' => array(
				'v3/home/indexcontent*',
			),
			'condition' => array('single|multi'),
			'source' => 'home/company_news_product',
		),

		// LayoutV1
		'dom' => array(
			'alias' => '通用區塊，通常是用在首頁，這個是LayoutV1的功能',
			'file' => array(
				// 'home/index_content_*',
				'system/dom3',
			),
			'source' => 'system/dom',
		),

		// LayoutV1的測試 2017-10-20
		// 'domtest2' => array(
		// 	'alias' => '',
		// 	'file' => array(
		// 		'home/index_content_*',
		// 	),
		// 	'source' => 'system/domtest2',
		// ),

		/*
		 * dom (simple html dom)功能的測試
		 * 類似LayoutV1的功能
		 */
		// 'domtest' => array(
		// 	'alias' => '',
		// 	'file' => array(
		// 		'home/index_content_*',
		// 	),
		// 	'source' => 'home/domtest',
		// ),
	),
	'news' => array(
		'general' => array(
			'alias' => '最新消息內頁與news的區塊資料夾的配對(範例)',
			'file' => array(
				'v3/news/type1_*',
				'cttdemo/news/type1_*',
			),
			'source' => 'news/type',
		),
	),
	'newsdetail' => array(
		'general' => array(
			'alias' => '最新消息內頁與news的區塊資料夾的配對(範例)',
			'file' => array(
				'v3/news/type2_*',
				'v4/news/detail*',
				'cttdemo/news/type2_*',
			),
			'source' => 'news/detail',
		),
	),
	'news3detail' => array(
		'general' => array(
			'alias' => '教師+學生',
			'file' => array(
				'v4/news3/detail*',
			),
			'source' => 'news3/detail',
		),
	),
	'news5detail' => array(
		'general' => array(
			'alias' => '有品活動',
			'file' => array(
				'v4/news5/detail*',
			),
			'source' => 'news5/detail',
		),
	),
	'graphicsdetail' => array(
		'general' => array(
			'alias' => '相片花絮內頁與news的區塊資料夾的配對(範例)',
			'file' => array(
				'v3/album/type3_*',
			),
			'source' => 'graphics/detail',
		),
	),
	'location' => array(
		'general' => array(
			'alias' => '',
			'file' => array(
				'v3/location/type*', 
			),
			'source' => 'location/type',
		),
	),
	'articlemulti' => array(
		'general' => array(
			'alias' => '',
			'file' => array(
				'v3/about/type*',
				'v3/category_title2',
				'v4/about/editor',
			),
			'source' => 'articlemulti/type',
		),
	),
	// 'about' => array(
	// 	'general' => array(
	// 		'alias' => '公司簡介內頁與about的區塊資料夾的配對(範例)',
	// 		'file' => array(
	// 			'v3/about/type*',
	// 			'v3/category_title2',
	// 			'cttdemo/company/type', // cttdemo
	// 		),
	// 		// 'condition' => array('single','multi','single|multi'),
	// 		// 'source' => 'about/type',
	// 		'source' => 'articlemulti/type',
	// 	),
	// ),
	// 'articlesingle' => array(
	// 	'general' => array(
	// 		'alias' => '',
	// 		'file' => array(
	// 			'v3/about/articlesingle',
	// 		),
	// 		'source' => 'articlesingle/type',
	// 	),
	// ),
	'album' => array(
		'submenu' => array(
			'alias' => '就右側的分類',
			'file' => array(
				'v3/default/promenu*',
			),
			'source' => 'album/submenu',
		),
		'general' => array(
			'alias' => '活動花絮內頁與album的區塊資料夾的配對(範例)',
			'file' => array(
				'v3/album/type1*',
				'cttdemo/album/type1*',
			),
			'source' => 'album/type',
		),
	),
	'albumdetail' => array(
		'general' => array(
			'alias' => '活動花絮內頁與album的區塊資料夾的配對(範例)',
			'file' => array(
				'v3/album/type2_*',
				'cttdemo/album/type2_*',
			),
			'source' => 'album/detail3',
		),
	),
	//'photo' => array(
	//	'general' => array(
	//		'alias' => '相簿花絮內頁與album的區塊資料夾的配對(範例)',
	//		'file' => array(
	//			'v3/album/type1*',
	//		),
	//		'source' => 'photo/type',
	//	),
	//),
	//'photodetail' => array(
	//	'general' => array(
	//		'alias' => '相簿花絮內頁與album的區塊資料夾的配對(範例)',
	//		'file' => array(
	//			'v3/album/type2_*',
	//		),
	//		'source' => 'photo/detail',
	//	),
	//),
	'faq' => array(
		'general' => array(
			'alias' => 'FAQ內頁與faq的區塊資料夾的配對(範例)',
			'file' => array(
				'v3/faq/type*',
				'cttdemo/faq/type*',
			),
			'source' => 'faq/type',
		),
	),
	'video' => array(
		'general' => array(
			'alias' => '影片內頁與video的區塊資料夾的配對(範例)',
			'file' => array(
				'video/type*',
				'cttdemo/video/type*',
			),
			'source' => 'video/type',
		),
	),
	'videodetail' => array(
		'general' => array(
			'alias' => 'cttdemo專用的',
			'file' => array(
				'cttdemo/video/type*',
			),
			'source' => 'video/detail',
		),
	),
	'download' => array(
		'general' => array(
			'alias' => '檔案下載與download的區塊資料夾的配對(範例)',
			'file' => array(
				'v3/download/type*',
				'cttdemo/download/type*',
			),
			'source' => 'download/type',
		),
	),
	'contact' => array(
		'post' => array(
			'alias' => '聯絡我們的post',
			'source' => 'contact/post',
		),
		'general' => array(
			'alias' => 'validate',
			'file' => array(
				'v3/contact/type*',
			),
			'source' => 'contact/type',
		),
	),
	'product' => array(
		// 2020-10-14 想要執行這裡，那webmenu-sub那裡就不要勾，要不然會衝到，因為file規則一樣的關係
		'submenu' => array(
			'alias' => '就右側的分類',
			'file' => array(
				'v3/default/promenu*',
			),
			'source' => 'product/submenu',
		),
		'general' => array(
			'alias' => '就資料囉',
			'file' => array(
				'v3/product/list1_*',
				'cttdemo/product/list1_*', // cttdemo
			),
			'source' => 'product/type',
		),
	),
	'productdetail' => array(
		'general' => array(
			'alias' => '這是舊的',
			'file' => array(
				'v3/product/list2_*',
			),
			'condition' => array('single','multi','multi|multi|single|multi'),
			'source' => 'product/detail',
		),
		'picture' => array(
			'alias' => '這是內頁上方大圖的位置',
			'file' => array(
				'v3/product/pictures_*',
				'v4/product/detail*',
				'cttdemo/product/list2_*', // cttdemo
			),
			// 'condition' => array('single','multi','single|multi|multi|single'),
			'source' => 'product/detail3',
		),
		'related' => array(
			'alias' => '這是相關產品，通常這個都不用',
			'file' => array(
				'v3/product/related_*',
			),
			//'condition' => array('single','multi','multi|multi|single'),
			'source' => 'product/related',
		),
	),
	'productinquiry' => array(
		'general' => array(
			'alias' => '就資料囉',
			'file' => array(
				'v3/product/inquiry*',
				'v4/product/inquiry*',
				'cttdemo/product/inquiry*',
			),
			// 'condition' => array('single','multi','multi|single'),
			// 'source' => 'product/inquiry',
			// 'source' => 'product/inquiry2',
			'source' => 'product/inquiry3',
		),
		'post' => array(
			'alias' => '商品洽詢的post',
			// 'source' => 'product/inquiry_post',
			// 'source' => 'product/inquiry2_post',
			'source' => 'product/inquiry4_post',
		),
	),
	'shop' => array(
		'post' => array(
			'alias' => '',
			'source' => 'shop/post',
		),
		// 2020-10-14 想要執行這裡，那webmenu-sub那裡就不要勾，要不然會衝到，因為file規則一樣的關係
		'submenu' => array(
			'alias' => '就右側的分類',
			'file' => array(
				'v3/default/promenu*',
				'v4/default/promenu*', //從v3 copy過來v4 的，前端還沒處理過 by lota
			),
			'source' => 'shop/submenu',
		),
		'general' => array(
			'alias' => '就資料囉',
			'file' => array(
				'v3/shop/list1_*',
				'v4/shop/list*',
			),
			'source' => 'shop/list',
		),
	),
	'shopdetail' => array(
		'general' => array(
			'alias' => '就資料囉',
			'file' => array(
				'v3/shop/list2_*',
				'v4/shop/detail*',
			),
			//'condition' => array('single','multi','multi|single|multi'),
			'source' => 'shop/detail',
		),
	),
	'favorite' => array(
		'post' => array(
			'alias' => '',
			'source' => 'favorite/post',
		),
		'general' => array(
			'alias' => '我的收藏',
			'file' => array(
				'v3/favorite/type*',
				'v4/favorite/list*',
			),
			'source' => 'favorite/list',
		),
	),
	'checkout' => array(
		'general' => array(
			'alias' => '產品結帳',
			'file' => array(
				'v3/checkout/layout1',
				'v4/checkout/layout1',
			),
			//'source' => 'shop/checkout',
			'source' => 'checkout/core',
		),
	),
	'donation' => array(
		'post' => array(
			'alias' => '捐款頁面的post',
			'source' => 'donation/post',
		),		
	),
	'member' => array(
		'login_post' => array(
			'source' => 'member/login_post',
		),
		'login' => array(
			'alias' => '',
			'file' => array(
				'v3/member/member_login*',
			),
			'source' => 'member/login',
		),
		'register_post' => array(
			'alias' => '',
			// 'file' => array(
			// 	'^member/register*',
			// ),
			// 'source' => 'member/register_post', // Yii
			'source' => 'member/register2_post',
		),
		'center' => array(
			'alias' => '',
			'file' => array(
				'v3/member/member_center*',
				'v4/member/member_center*',
			),
			'source' => 'member/center',
		),
		'center_post' => array(
			'source' => 'member/center_post',
		),
		'change_password' => array(
			'alias' => '',
			'file' => array(
				'v3/member/change_password*',
				'v4/member/member_password*',
			),
			'source' => 'member/change_password',
		),
		'change_password_post' => array(
			'source' => 'member/change_password_post',
		),
		'order_list' => array(
			'alias' => '',
			'file' => array(
				'v3/checkout/layout1',
				'v4/checkout/layout1',
			),
			'source' => 'member/order_list',
		),
		'order_detail' => array(
			'alias' => '',
			'file' => array(
				'v3/checkout/layout1',
				'v4/checkout/layout1',
			),
			'source' => 'member/order_detail',
		),
		'notice_payment' => array(
			'alias' => '',
			'file' => array(
				'v3/member/notice_payment',
				'v4/member/member_noticepay',
			),
			'source' => 'member/notice_payment',
		),
		'customer_address_post' => array(
			'source' => 'member/customer_address_post',
		),
		'customer_address' => array(
			'alias' => '',
			'file' => array(
				'v3/member/customer_address',
				'v4/member/member_addressBook',
			),
			'source' => 'member/customer_address',
		),
		'bonus_list' => array(
			'alias' => '',
			'file' => array(
				'v3/member/bonus_list',
				'v4/member/bonus_list',
			),
			'source' => 'member/bonus_list',
		),
		'forget_post' => array(
			'alias' => '忘記密碼',
			//'file' => array(
			//	'v3/member/forget*',
			//	'v4/member/member_forgot*',
			//),
			'source' => 'member/forget_post',
		),
		'forgetconfirm' => array(
			'alias' => '',
			'file' => array(
				'v3/member/forget_confirm*',
				'v4/member/member_forgot_confirm*',
			),
			'source' => 'member/forget_confirm',
		),
		'verification' => array(
			'alias' => '',
			'file' => array(
				'v3/member/sms_verification*',
				'v4/member/member_verification*',
			),
			'source' => 'member/sms_verification',
		),
	),
);

// 記得要把以下的東西
//
// $page_source = array(
// 	'webmenu-v1',
// 	'company-page_title',
// 	'company-breadcrumb',
// 	'company-general',
// );
//
// 轉成以下這個
//
// $page_source[] = $page_sources['webmenu']['v1'];
// $page_source[] = $page_sources['company']['page_title'];
// $page_source[] = $page_sources['company']['breadcrumb'];
// $page_source[] = $page_sources['company']['general'];

