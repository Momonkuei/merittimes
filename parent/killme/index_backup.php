<?php

// SEO
// @session_start();
// $_SESSION['web_ml_key'] = 'tw';
// $layoutv3_parent_path = 'tw/'; // 本程式在子資料夾內，相關檔案在根目錄 (通常是Yii和cig前台在用) ex: contact/
// $layoutv3_path = ''; // 本程式在子資料夾內，相關檔案也在該層目錄裡面 (通常是cig後台在用) ex: contact/
// include '../layoutv3/init.php';


include 'layoutv3/init.php';

$page = array(
	array(
		'file' => '$layout_main',
		// 'file' => '$layout_v2',
		'hole' => array(

			array('file' => 'v3/home/index_content_01'),
			
			// 套每一個首頁區塊
			// array(
			// 	// 'file' => 'system/dom', // 靜態規則
			// 	// 'file' => 'system/dom2', // 動態規則
			// 	'file' => 'system/dom3', // Datasource控制權
			// 	'hole' => array(
			// 		// array('file' => 'home/index_content_01'),
			// 		// array('file' => 'home/index_content_02'),
			// 		// array('file' => 'home/index_content_05'),
			// 		// array('file' => 'home/index_content_06'),
			// 		// array('file' => 'home/index_content_07'),
			// 		// array('file' => 'home/index_content_15'),
			// 	),
			// ),

			// dom ajax的範例
			// array(
			// 	'hole' => array(
			// 		array('file' => 'home/index_content_01'),
			// 		// array('file' => 'system/dom_ajax'),
			// 		array('file' => 'system/dom_ajax2'),
			// 	),
			// ),

			// W01的動態首頁
			// array(
			// 	'file' => 'v3/home/indexcontent1',
			// 	'hole' => array(
			// 		array(
			// 			'hole' => array(
			// 				array('file' => 'v3/home/home_marquee'),
			// 				array('file' => 'v3/home/home_ad'),
			// 				array('file' => 'v3/home/home_content'),
			// 			),
			// 		),
			// 	),
			// ),


			// w02
			// array('file' => 'v3/home/index_content_02'),
			// array('file' => 'v3/home/indexcontent2'),

			// W03
			// array('file' => 'v3/home/index_content_03'),

			// w05
			// array('file' => 'v3/home/index_content_05'),

			// w06
			// array('file' => 'v3/home/index_content_06'),

			// w06和LayoutV1的測試
			// array(
			// 	'file' => 'system/dom',
			// 	'hole' => array(
			// 		array('file' => 'v3/home/index_content_06'),
			// 	),
			// ),

			// w07
			// array('file' => 'v3/home/indexcontent7'),

			// w08
			// array('file' => 'v3/home/index_content_08'),

			// w09
			// array('file' => 'v3/home/index_content_09'),
			// array('file' => 'v3/home/indexcontent9'),

			// w10
			// array('file' => 'v3/home/index_content_10'),

			// w12
			//array('file' => 'v3/home/index_content_12'),

			// w13
			// array('file' => 'v3/home/index_content_13'),

			// w14
			// array('file' => 'v3/home/index_content_14'),

			// w15
			// array('file' => 'v3/home/index_content_15'),
			// array('file' => 'v3/home/indexcontent15'),

		),
	),
);

/*
 * 記得首頁改了以後，要去改開環境的程式，不然一定會有問題，尤其是page source
 */

// 挑選所需要的資料
$page_source = array(
	'member-login_post', // 這個是浮起來的登入視窗在使用的，記得，驗證碼欄位有加數字2哦
	'share-core',
	'top_link_menu-v1',
	'webmenu-v1',
	'webmenu-bottom',
	'webmenu-sub',
	'home-banner',

	// LayoutV1
	// 'home-dom',

	// LayoutV1 && DATA2
	// 'home-domtest2',

	// 大概是W01在用的
	// 'home-ad',
	// 'home-content',
	// 'home-marquee',

	// 大概是W02在用的
	// 'home-company_news_product',

	// 這是W09專用的
	//'home-banner2',

	// 大概是W15在用的
	// 'home-image_news',

	// W06在測試LayoutV1功能所用的
	// 'home-domtest',

	// 結尾的程式碼，通常都放這裡
	'share-end',
);

// include 'layoutv3/print_table.php';
include 'layoutv3/pre_render.php';
// include 'layoutv3/print_struct.php';

// 最新消息－資料流範例
// $o = $this->db->createCommand()->from('html');
// $o = $o->where('is_enable=1 and is_home=1 and type=:type and ml_key=:ml_key',array(':type'=>'news',':ml_key'=>$this->data['ml_key']));
// $o = $o->order('start_date desc');
// $o = $o->limit(5);
// $data['news']= $g->queryAll();
// 
// if(isset($data['news'])){
// 	foreach($data['news'] as $k => $v){
// 		$v['url'] = $v['url1'] = 'newsdetail_'.$this->data['ml_key'].'.php?id='.$v['id'];
// 		$v['pic'] = $v['pic1'];
// 		if($v['pic'] != ''){
// 			$v['pic'] = '_i/assets/upload/news/'.$v['pic'];
// 		}
// 		$data['news'][$k] = $v;
// 	}
// }

//首頁專用SEO 記得要再後台常數啟用SEO功能
// $this->data['seo_description'] = 'Used Offset Printing Machine Supplier, YU MAO PRINTING MACHINE TRADING CO., LTD. is a well-developed Manufacturer offering Used Printing Equipment,Used Binding Machine, Used Binding Machinery,  Used Offset Printing Machine, etc.';
// $this->data['seo_keywords'] = 'Used Offset Printing Machine, Used Printing Machine & Used Printing Machinery';
// $data['head_title'] = 'Used Offset Printing Machine, Used Printing Machine & Used Printing Machinery, YU MAO PRINTING MACHINE TRADING CO., LTD.';

include 'layoutv3/render.php';
