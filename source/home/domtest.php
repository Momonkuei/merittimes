<?php

// echo 'ggggg';
// var_dump($page_source_result);die;

/*
 * 這個是view/home/index_content_06的動態展示範本
 */
$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>'news',':ml_key'=>$this->data['ml_key']))->order('rand()')->queryAll();
$result = array();
if($rows and count($rows) > 0){
	$root = 'find(".itemList",0)->innertext|find("a",0)->outertext'; // parent | one
	$result[$root] = array();
	foreach($rows as $k => $v){
		$title = 'find("h5",0)->innertext';
		$pic = 'find("img",0)->src';
		$tmp = array(
			$title => $v['topic'],
			$pic => '_i/assets/upload/news/'.$v['pic1'],
		);
		$result[$root][] = $tmp;
	}
} else {
	$result['find(".itemList",0)->innertext'] = '';
}
$data[$ID] = $result;

/*
 * 這個是view/home/index_content_06的靜態展示範本
 */
//    $data[$ID] = array(
//    	// 單筆的範例
//    	array(
//    		'find("span",0)->innertext' => '123',
//    	),
//    	// 多筆的範例
//    	'find(".itemList",0)->innertext|find("a",0)->outertext' => array(
//    		// 一筆裡面有很多不同欄位的規則
//    		array(
//    			'find("h5",0)->innertext' => '456',
//    			'find("img",0)->src' => 'images/default/index-img-1.jpg',
//    		),
//    		array(
//    			'find("h5",0)->innertext' => '789',
//    			'find("img",0)->src' => 'images/default/index-img-2.jpg',
//    		),
//    	),
//    );
