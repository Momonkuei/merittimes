<?php

// 這是正解(名子轉ID)
// if(!isset($_SESSION) and isset($_GET['id']) and !is_numeric($_GET['id'])){ // 這是舊版的(李哥發現的)
if(isset($_GET['id']) and !is_numeric($_GET['id'])){
	@session_start();
	$id_name = $_GET['id'];

	// debug
	// if(0){
	// 	echo $_SESSION['save']['contact_dynamic_url'].' / ';
	// 	echo $id_name;
	// }

	// 動態網址
	// if(!isset($_SESSION['save']['contact_dynamic_url']) or $_SESSION['save']['contact_dynamic_url'] != $id_name){
	// 	// 李哥2017-10-26 早上說，不要404，轉到首頁去
	// 	//header("HTTP/1.0 404 Not Found");
	// 	// die;

	// 	header('Location: /');
	// }

	// 動態網址 (第2版)
	$tmps = explode('/', $_SERVER['REQUEST_URI']);
	if(0){
		echo $_SESSION['save'][$tmps[1].'_dynamic_url'].' / ';
		echo $id_name;
	}
	if(!isset($_SESSION['save'][$tmps[1].'_dynamic_url']) or $_SESSION['save'][$tmps[1].'_dynamic_url'] != $id_name){
		// 李哥2017-10-26 早上說，不要404，轉到首頁去
		//header("HTTP/1.0 404 Not Found");
		// die;

		header('Location: /');
	}
}

$layoutv3_parent_path = 'contact/'; // 本程式在子資料夾內，相關檔案在根目錄 (通常是Yii和cig前台在用) ex: contact/
// $layoutv3_path = ''; // 本程式在子資料夾內，相關檔案也在該層目錄裡面 (通常是cig後台在用) ex: contact/

include '../layoutv3/init.php';

$page = array(
	array(
		'file' => '$layout_main',
		'hole' => array(
			array(
				'hole' => array(
					array(
						'file' => '$sub_page_has_menu',
						'hole' => array(
							array('file' => 'contact/info'), // sidemenu
							array('file' => 'system/empty'), // category_title

							// B2B (二選一)
							array(
								'file' => 'contact/type1',
								'hole' => array(
									array('file' => 'system/default_validate'),
								),
							),

							// B2C (二選一)
							// array(
							// 	'file' => 'contact/type2',
							// 	'hole' => array(
							// 		array('file' => 'system/default_validate'),
							// 	),
							// ),

							array('file' => 'system/empty'), // shop banner
						),
					),
					// array('file' => 'contact/googlemap1'), // iframe
					array('file' => 'contact/googlemap2'), // api
				)
			),
			// array(
			// 	'hole' => array(
			// 		array(
			// 			'file' => 'sub_page_title',
			// 			'hole' => array(
			// 				array('file' => 'breadcrumb'),
			// 			),
			// 		),
			// 		array(
			// 			'file' => 'contact/layout1', // 表單在右邊 (預設)
			// 			// 'file' => 'contact/layout2', // 表單在左
			// 			// 'file' => 'contact/layout3', // 無側欄 (winnie)，記得把info註解掉
			// 			'hole' => array(
			// 				array('file' => 'contact/info'), 
			// 				array('file' => 'contact/type1'), // B2B
			// 				// array('file' => 'contact/type2'), // B2C (預設)
			// 			),
			// 		),
			// 		// array('file' => 'contact/googlemap1'), // iframe
			// 		array('file' => 'contact/googlemap2'), // api
			// 	),
			// ),
		),
	),
);

// // 挑選所需要的資料
$page_source = array(
	'contact-post',
	'share-core',
	'webmenu-v1',
	'share-page_title',
	'share-breadcrumb',
	'top_link_menu-v1',
	'webmenu-bottom',
	'home-banner',

	'contact-general',

	// 結尾的程式碼，通常都放這裡
	'share-end',
);

include '../layoutv3/pre_render.php';
//include '../layoutv3/print_struct.php';

include '../layoutv3/render.php';
