<?php

/*
 * 2019-12-02
 */

// var_dump($_params_);

if(
	isset($_params_) and !empty($_params_)
	and isset($_params_['datasource_1']) and $_params_['datasource_1'] != '' // 例8787
){
	$layoutv3_datasource_id = $_params_['datasource_1'];
	include 'layoutv3/dom5/datasource.php';

	if(!isset($content)){
		$content = array();
	}

	// dirty hack
	// 如果有必要，條件還是要下pidas:XXX的條件
	if($content and !empty($content) and !isset($content['id'])){
		foreach($content as $k => $v){
			if(isset($v['pid'])){
				$content[$k]['pid'] = 0;
			}
		}
	}

	// 底下程式銜接的方式3 (V1第二版)
	if($content){
		if(isset($content['id'])){ // 單筆
			$this->data['_general_detail'] = $content;
		} elseif(!empty($content)){ // 多筆
			$this->data['_general_rows'] = $content;
		}
	}

	if(isset($_params_['datasource_0'])){
		$data[$ID] = $content;
	} else {
		// 把後一個區塊的內容，取代成這裡的內容
		$tmp2 = explode('-', $ID);

		// 用群組包起來的解析方式
		// unset($tmp2[count($tmp2)-1]);
		// $tmp3 = explode('_', end($tmp2));
		// $tmp2[count($tmp2)-1] = $tmp3[0]+1;

		// 直接使用的方式
		$tmp2[count($tmp2)-1] = end($tmp2)+1;

		$next_id = implode('-',$tmp2);
		// var_dump($data[$next_id]);

		// 底下程式銜接的方式2 (LayoutV3)
		$data[$next_id] = $content;

		// if($_params_['datasource_1'] == 2751){
		// 	var_dump($content);
		// }
	}

}
?>
