<?php

include 'layoutv3/init.php';

/* //V4 不需要這塊
$page = array(
	array(
		'file' => '$layout_main',
		'hole' => array(
		array('file' => 'v3/home/index_content_01'),
		),
	),
);
*/

// 挑選所需要的資料
$page_source = array(
	'member-login_post', // 這個是浮起來的登入視窗在使用的，記得，驗證碼欄位有加數字2哦
	'share-core',
	'top_link_menu-v1',
	'webmenu-v1',
	'webmenu-bottom',

	// 如果是W09，請把我註解
	'home-banner',

	// 這是W09專用的(這個用不到了)
	// 'home-banner2',

	// 首頁通用區塊(LayoutV1)
	// 'home-dom',

	// 結尾的程式碼，通常都放這裡
	'share-end',
);

include 'layoutv3/pre_render.php';
//include 'layoutv3/print_struct.php';

$o = $this->db->createCommand()->from('html');
$o = $o->where('is_enable=1 and is_home=1 and type=:type and ml_key=:ml_key',array(':type'=>'news',':ml_key'=>$this->data['ml_key']));
$o = $o->order('start_date desc');
$o = $o->limit(6);
$data['news']= $o->queryAll();

// $data['news'] = $this->cidb->where('is_enable',1)->where('is_home',1)->where('type','news')->where('ml_key',$this->data['ml_key'])->order_by('start_date','desc')->get('html')->result_array();

if(isset($data['news'])){
	foreach($data['news'] as $k => $v){
		$v['url'] = $v['url1'] = 'newsdetail_'.$this->data['ml_key'].'.php?id='.$v['id'];
		$v['pic'] = $v['pic1'];
		if($v['pic'] != ''){
			$v['pic'] = '_i/assets/upload/news/'.$v['pic'];
		}
		$data['news'][$k] = $v;
	}
}

//首頁專用SEO
// $this->data['seo_description'] = 'Used Offset Printing Machine Supplier, YU MAO PRINTING MACHINE TRADING CO., LTD. is a well-developed Manufacturer offering Used Printing Equipment,Used Binding Machine, Used Binding Machinery,  Used Offset Printing Machine, etc.';
// $this->data['seo_keywords'] = 'Used Offset Printing Machine, Used Printing Machine & Used Printing Machinery';
// $data['head_title'] = 'Used Offset Printing Machine, Used Printing Machine & Used Printing Machinery, YU MAO PRINTING MACHINE TRADING CO., LTD.';

include 'layoutv3/render.php';
