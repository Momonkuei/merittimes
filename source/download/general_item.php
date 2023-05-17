<?php

// function human_filesize($bytes, $decimals = 2) {
//     $factor = floor((strlen($bytes) - 1) / 3);
//     if ($factor > 0) $sz = 'KMGT';
//     return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor - 1] . 'B';
// }

if($rows and !empty($rows)){
	foreach($rows as $k => $v){

		/*
		 * 2020-04-01 和李哥討論後的結果，就是連結1和連結2都是一樣的，如果有需要在客製
		 */
		$url = 'javascript:;';
		$v['file_size'] = '';
		if($v['file1'] != ''){
			if(is_file('_i/assets/file/'.$this->data['router_method'].'/'.$v['file1'])){
				$url = '_i/assets/file/'.$this->data['router_method'].'/'.$v['file1'];
				$num=1;
				$bytes=filesize($url);
    			$factor = floor((strlen($bytes) - 1) / 3);			
    			if($factor > 0)$sz = 'KMGT';	   			
				$v['file_size'] = sprintf("%.{$num}f", $bytes / pow(1024, $factor)) . @$sz[$factor - 1] . 'B';

				//20220520 更新 function 導致錯誤
				// $v['file_size'] = human_filesize(filesize($url),1);
			}		
		}

		if($v['url1'] != ''){
			$url = $v['url1'];
		}

		$v['href1'] = $v['href2'] = $url;

		// 底下是額外的功能

		/*
		 * 需要密碼的下載 2016-12-28
		 * 會有記錄在經銷商的後台功能裡面
		 */
		// $v['href1'] = $v['href2'] = 'agent.php?id='.$v['id'];
		// if(isset($_SESSION['agent_id']) and $_SESSION['agent_id'] > 0){
		// 	// do nothing
		// } else {
		// 	$v['anchor1_data_target'] = '#loginPanel_normal';
		// 	$v['anchor1_class'] = 'openBtn ';

		// 	$v['anchor2_data_target'] = '#loginPanel_normal';
		// 	$v['anchor2_class'] = 'openBtn ';
		// }

		/*
		 * 需要記錄的下載 2017-04-20
		 */
		// $v['href1'] = $v['href2'] = 'record.php?id='.$v['id'];
		
		//上面連結(href1) 跟 下面連結(href2) 分開，上面的 帶入連結記得先關閉	
		// $v['href2'] = 'record.php?id='.$v['id'];
		// if($url == 'javascript:;'){
		//     $v['href1'] = $v['href2'];
		// }

		// cttdemo在使用的
		$tmps = explode('.', $v['file1']);
		$v['file_type'] = strtoupper($tmps[count($tmps)-1]);

		// 移到上層
		// $v['pic'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$v['pic1'];
		// $v['name'] = $v['topic'];

		$v['content'] = $v['detail'];

		$rows[$k] = $v;
	}
}


