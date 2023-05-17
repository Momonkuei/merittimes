<?php

$tmps = $this->db->createCommand()->from($this->data['router_method'].'type')->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->queryAll();
$tmps_tmp = array();
if($tmps){
	foreach($tmps as $k => $v){
		$tmps_tmp[$v['id']] = $v['name'];
	}
}

if($rows and count($rows) > 0){
	foreach($rows as $k => $v){
		$v['url'] = $v['url1'] = $v['url2'] = $url_prefix.$this->data['router_method'].'detail'.$url_suffix.'?id='.$v['id'];
		$v['pic'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$v['pic1'];

		$v['name2'] = $v['name'];
		$v['img_alt'] = $v['name']; // SEO

		if(isset($tmps_tmp[$v['class_id']])){
			$v['name'] = $tmps_tmp[$v['class_id']];
		}
		

		$v['url3'] = 'save.php?id=productinquiry&_append=&amount=1&primary_key='.$this->data['router_method'].'___'.$v['id'].'___0';
		
		$v['content1'] = $v['field_data'];
		$v['content2'] = $v['field_tmp'];

		if(isset($seos_tmp[$v['id']]) and $seos_tmp[$v['id']]['seo_script_name'] != ''){
			$v['url1'] = $v['url2'] = $url_prefix.$seos_tmp[$v['id']]['seo_script_name'].'.html';
		} else {
			$v['url1'] = $v['url2'] = $url_prefix.$this->data['router_method'].'detail'.$url_suffix.'?id='.$v['id'];
		}

		// 2020-12-30 system/search方法四

		// 	if($v['product'] == 'product'){
		// 		$v['url'] = $v['url1'] = $v['url2'] = $url_prefix.'productdetail'.$url_suffix.'?id='.$v['id'];
		// 		$v['pic'] = '_i/assets/upload/product/'.$v['pic1'];
		// 	} elseif($v['product'] == 'applications'){
		// 		$v['url'] = $v['url1'] = $v['url2'] = $url_prefix.'applicationsdetail'.$url_suffix.'?id='.$v['id'];
		// 		$v['pic'] = '_i/assets/upload/applications/'.$v['pic1'];
		// 	}
		// }

		$rows[$k] = $v;
	}
}
