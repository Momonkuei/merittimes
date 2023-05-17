<?php

// 2018-01-04
// 靜態縮圖
// http://redmine.buyersline.com.tw:4000/issues/18231?issue_count=39&issue_position=38&next_issue_id=17463&prev_issue_id=18525#note-38
// _i/cache3/members/product{ID}/member/w800h800zc3_AAA.jpg

/*
 * @_file        絕對路徑
 * @_width       選填，預設800
 * @_height      選填，預設800
 * @_other_param 選填，timthumb的GET額外參數，記得開頭要加上&
 */

if(!isset($_width) or $_width <= 0){
	$_width = 800;
}

if(!isset($_height) or $_height <= 0){
	$_height = 800;
}

// $_file = str_replace(_BASEPATH.'/', '', $v);

if(isset($_file) and $_file != '' and file_exists($_file)){
	$_key = md5(uniqid()).rand(10, 99);
	$_tmp = array(
		'label' => '&nbsp;',
		'type' => 'iframe',
		'attr' => array(
			'id' => 'iframe_timthumb_physical_file_cache3_'.$_key,
			'width' => '100%',
			'height' => '0px',
			'src' => '/_i/timthumb.php?src='.str_replace(_BASEPATH.'/','',$_file),
		),
	);
	// dry hack
	$_info = getimagesize($_file);
	if($_info[0] < $_width and $_info[1] < $_height){
		$_tmp['attr']['src'] .= '&nocache=';
	} else {
		$_tmp['attr']['src'] .= '&nocache=&zc=3&w='.$_width.'&h='.$_height;
	}
	if(isset($_other_param) and $_other_param != ''){
		$_tmp['attr']['src'] .= $_other_param;
	}
	if(isset($this)){ // 因為rebuild cache3的程式，也會使用這一支
		$this->data['def']['updatefield']['sections'][0]['field']['iframe_images_timthumb_'.$_key] = $_tmp;
	}
}

unset($_key);
unset($_file);
unset($_width);
unset($_height);
unset($_other_param);
