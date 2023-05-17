<?php

// 移到最下面才做，針對分類的簡述的檢查
// $admin_field_router_class = $this->data['router_method'];
// $admin_field_section_id = 1;
// include _BASEPATH.'/../source/system/admin_field_get.php';

// 使用縮圖前的準備
$path = 'webroot._i.assets.thumb.'.str_replace('detail','',$this->data['router_method']);
$ggg2 = array();
if(is_dir(Yii::getPathOfAlias($path))){
	$ggg2 = $this->_getFiles(Yii::getPathOfAlias($path));
}

if($rows and count($rows) > 0){
	foreach($rows as $k => $v){

		// $v['url1'] = $v['url2'] = $url_prefix.$this->data['router_method'].'detail'.$url_suffix.'?id='.$v['id'];
		$v['url1'] = $v['url2'] = $v['url'];

		// 移到上層
		// $v['pic'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$v['pic1'];

		// 如果有縮圖，就使用縮圖
		if($ggg2){
			foreach($ggg2 as $kk => $vv){
				$ggg3 = explode('_',$vv);
				if($v['pic1'] == $ggg3[count($ggg3)-1]){
					$_DOCUMENT_ROOT = str_replace('/var/www/vhosts','/home2',$_SERVER['DOCUMENT_ROOT']); //自架Server1專用
					$v['pic'] = str_replace($_DOCUMENT_ROOT,'',$vv);
					break;
				}
			}
		}

		// 移到上層
		// if(isset($v['topic'])){
		// 	$v['name'] = $v['topic'];
		// }

		// 這裡沒有這個欄位
		// if(isset($v['field_tmp'])){
		// 	$v['content'] = $v['field_tmp'];
		// }
		// if(isset($admin_field['field_tmp']) and isset($admin_field['field_tmp']['type'])){
		// 	if($admin_field['field_tmp']['type'] == 'textarea'){
		// 		$v['content'] = nl2br($v['field_tmp']); // ckeditor_js 預設編輯器輸出
		// 	}
		// }

		//$v['year'] = date('Y', strtotime($v['create_time']));
		//$v['month'] = date('F', strtotime($v['create_time']));
		//$v['day'] = date('d', strtotime($v['create_time']));

		//2019-10-3 改用 start_date by lota 移到上層
		// $v['year'] = date('Y', strtotime($v['start_date']));
		// $v['month'] = date('F', strtotime($v['start_date']));
		// $v['day'] = date('d', strtotime($v['start_date']));

		// 移到上層
		// $tmps = array();
		// if(is_dir(_BASEPATH.'/assets/members/'.$this->data['router_method'].'_1_'.$v['id'].'/member')){
		// 	$tmps = $this->_getFiles(_BASEPATH.'/assets/members/'.$this->data['router_method'].'_1_'.$v['id'].'/member');
		// }
		// $v['count'] = count($tmps);


		// 切換成單圖上傳(1/2)
		if(0){
			$v['count'] = '';
			if($common_content_type != 1){
				$v['anchor_attr1'] = $v['anchor_attr2'] = ' rel="gallery-'.$v['id'].'" class="swipebox" ';
				$v['url'] = $v['url1'] = $v['url2'] = $v['pic'];
			} elseif($common_content_type == 1){
				$v['url1'] = $v['url2'] = $url_prefix.$this->data['router_method'].$url_suffix.'?id='.$v['id'];
			}
		}

		$rows[$k] = $v;
	}
}

// 切換成單圖上傳(2/2)
if(isset($layoutv3_struct_map_keyname['v3/category_title'][0]) and isset($_GET['id'])){
	$tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and id=:id',array(':type'=>str_replace('detail','',$this->data['router_method']).'type',':id'=>$_GET['id']))->queryRow();
	$ggg = array(
		'name' => $tmp['topic'],
		'sub_name' => $tmp['detail'],
		'year' => date('Y', strtotime($tmp['create_time'])),
		'month' => date('F', strtotime($tmp['create_time'])),
		'day' => date('d', strtotime($tmp['create_time'])),
	);

	// $admin_field_router_class = str_replace('detail', '', $this->data['router_method']);
	$admin_field_router_class = $this->data['router_method'].'type';
	$admin_field_section_id = 1;
	include _BASEPATH.'/../source/system/admin_field_get.php';

	if(isset($admin_field['detail']) and isset($admin_field['detail']['type'])){
		if($admin_field['detail']['type'] == 'textarea'){
			$ggg['sub_name'] = nl2br($tmp['detail']); // ckeditor_js 預設編輯器輸出
		}
	}

	$ggg['count'] = count($rows);

	$data[$layoutv3_struct_map_keyname['v3/category_title'][0]] = $ggg;
}
