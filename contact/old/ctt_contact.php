<?php

// 這是正解(名子轉ID)
 // if(!isset($_SESSION) and isset($_GET['id']) and !is_numeric($_GET['id'])){ // 這是舊版的(李哥發現的)
if(isset($_GET['id']) and !is_numeric($_GET['id'])){
	@session_start();
	$id_name = $_GET['id'];

	// debug
	if(0){
		echo $_SESSION['save']['contact_dynamic_url'].' / ';
		echo $id_name;
	}

	if(!isset($_SESSION['save']['contact_dynamic_url']) or $_SESSION['save']['contact_dynamic_url'] != $id_name){
		// 李哥2017-10-26 早上說，不要404，轉到首頁去
		//header("HTTP/1.0 404 Not Found");
		// die;

		header('Location: /');
	}
}

$layoutv3_parent_path = 'contact/';

include '../layoutv3/init.php';

$page = array(
	array(
		'file' => '$layout_main',
		'hole' => array(
			array(
				'file' => '$sub_ctt',
				'hole' => array(
					array(
						'hole' => array(
							array(
								'file' => 'ctt/default/layout1',
								'hole' => array(
									array('file' => 'ctt/contact/type1'),
								),
							),
						),
					),
				),
			),
		),
	),
);

/*
 * 記得首頁改了以後，要去改開環境的程式，不然一定會有問題，尤其是page source
 */

// 挑選所需要的資料
$page_source = array(
	'contact-post',
	'share-core',
	'share-page_title',
	'share-breadcrumb',
	'top_link_menu-v1',
	'webmenu-v1',
	'webmenu-bottom',
	'home-banner',

	// 結尾的程式碼，通常都放這裡
	'share-end',
);

include '../layoutv3/pre_render.php';
// include '../layoutv3/print_struct.php';

//首頁專用SEO
// $this->data['seo_description'] = 'Used Offset Printing Machine Supplier, YU MAO PRINTING MACHINE TRADING CO., LTD. is a well-developed Manufacturer offering Used Printing Equipment,Used Binding Machine, Used Binding Machinery,  Used Offset Printing Machine, etc.';
// $this->data['seo_keywords'] = 'Used Offset Printing Machine, Used Printing Machine & Used Printing Machinery';
// $data['head_title'] = 'Used Offset Printing Machine, Used Printing Machine & Used Printing Machinery, YU MAO PRINTING MACHINE TRADING CO., LTD.';

include '../layoutv3/render.php';
