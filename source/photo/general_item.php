<?php

//相簿的簡述 v4
if(isset($layoutv3_struct_map_keyname['v4/layout/row']) && isset($_GET['id'])){	
	$_ggg = $this->cidb->select('detail')->where('is_enable',1)->where('id',intval($_GET['id']))->get($item_list_router_method.'type')->row_array();
	if(isset($_ggg['detail']) && $_ggg['detail']!=''){
		$data[$layoutv3_struct_map_keyname['v4/layout/row'][0]]['describe'] = $_ggg['detail'];
	}	
}

// var_dump($rows);
if($rows and count($rows) > 0){
	foreach($rows as $k => $v){
		if(isset($v['url']) and $v['url'] == '#' and isset($v['pic'])){
			// 相片列表
			$v['count'] = '';
			$v['name'] = ''; //2022-02-17 Ming說母版預設相片名稱不出現
			if(LAYOUTV3_THEME_NAME == 'v3'){
				$v['anchor_attr1'] = ' rel="gallery-1" class="swipebox" title="'.$v['name'].'" ';
				$v['anchor_attr2'] = ' rel="gallery-2" class="swipebox"  title="'.$v['name'].'" ';
			} elseif(LAYOUTV3_THEME_NAME == 'v4'){
				$v['anchor_attr1'] = ' data-fancybox="group_1" title="'.$v['name'].'" '; //2021-05-05 加入群組group_1 by lota
			}
			$v['url1'] = $v['url2'] = $v['pic'];
		} else {
			// 相簿列表
			$v['url1'] = $v['url2'] = $v['url'];

			$rowsg = $this->cidb->where('is_enable',1)->where('type',$item_list_router_method)->where('class_id',$v['id'])->get('html')->result_array();
			$v['count'] = count($rowsg);

			$v['year'] = $v['date1___year'];
			$v['month'] = $v['date1___month2'];
			$v['day'] = $v['date1___day'];
		}

		$rows[$k] = $v;
	}
}
