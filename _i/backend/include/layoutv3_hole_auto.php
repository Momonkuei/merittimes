<?php

// 2018-05-07 李哥早上己有看過這個東西
$count = 0;
$handle = true;

if($handle === true and !isset($datas['name']) or $datas['name'] == ''){
	$handle = false;
}

if($handle === true and !isset($datas['pid']) or $datas['pid'] == 0){
	$handle = false;
}

if($handle === true and $this->data['router_method'] == 'update'){
	$rows = $this->cidb->select('id')->where('is_enable',1)->where('pid',$this->data['id'])->get($this->data['router_class'])->result_array();
	if(count($rows) > 0){
		$handle = false;
	}
}

if($handle === true){
	if(preg_match('/^\$(.*)$/', $datas['name'], $matches)){ // Group
		$name = $matches[1];

		// 先看實體在看虛擬
		$file = _BASEPATH.'/../group/'.$name.'.php';
		if(file_exists($file)){
			$tmps = explode("\n", file_get_contents($file));
			foreach($tmps as $k => $v){
				if(preg_match('/\/\/\ HOLE/', $v)){
					$count++;
				}
			}
		}

		// 看看虛擬
		$row = $this->cidb->select('id')->where('is_enable',1)->where('pid',0)->where('name',$name)->get('layoutv3grouptype')->row_array();
		if($row and isset($row['id']) and $row['id'] > 0){
			$count = 0; // 洗掉實體的洞的數量
			$tmps = $this->layout_show($row['id'],1,'　','layoutv3grouptype');//'　└'	
			foreach($tmps as $k => $v){
				if(preg_match('/\/\/\ HOLE/', $v)){
					$count++;
				}
			}
		}
	} elseif($datas['name'] == '-group'){ // 容器
		$count = 2;
	} elseif(preg_match('/^\%(.*)$/', $datas['name'], $matches)){ // DB View
		$name = $matches[1];

		$row = $this->cidb->select('field_tmp')->where('is_enable',1)->where('type','layoutv3view')->where('topic',$name)->get('html')->row_array();
		if($row and isset($row['field_tmp']) and $row['field_tmp'] != ''){
			$has_phy_hole = false;

			// 先看看裡面有沒有實體的洞
			$checks = explode("\n", $row['field_tmp']);
			foreach($checks as $k => $v){
				if(preg_match('/echo\ \$(AA|BB|CC|DD|EE|FF|GG|HH|II|JJ|KK|LL|MM|NN|OO|PP|QQ|RR|SS|TT|UU|VV||WW|XX|YY|ZZ)\?/', $v)){
					$has_phy_hole = true;
				}
			}

			// 從layoutv3/libs.php裡面複製過來的
			// 2018-05-14 李哥早上說可以做include置換成洞的這個功能
			if($checks and count($checks) > 0 and $has_phy_hole === false){
				$repeat = -1; // 如果有連續include，那實際上產出的標記只會有一個
				foreach($checks as $k => $v){
					if(trim($v) == ''){ // 為了要排除兩個include中間，夾著一個空白行
						continue;
					}
					// < ? php include('common/header.php'); ? >
					if(preg_match('/\?php\ include\(\'(.*)\'\);\?\>/', $v, $matches)){
						if($repeat >= 0){ // 有重覆
							// $check = str_replace_first('<'.'?'.'php include(\''.$matches[1].'\');?'.'>','',$check,1);
						} else {
							// $checks[$k] = '<'.'?'.'php echo $__?'.'>';
							// $check = str_replace_first('<'.'?'.'php include(\''.$matches[1].'\');?'.'>','<'.'?'.'php echo $__?'.'>',$check,1);
							$count++;
						}
						$repeat = $k;
					} else {
						$repeat = -1;
					}
				}
			}

			foreach($tmps as $k => $v){
				if($has_phy_hole === true){
					if(preg_match('/echo\ \$(AA|BB|CC|DD|EE|FF|GG|HH|II|JJ|KK|LL|MM|NN|OO|PP|QQ|RR|SS|TT|UU|VV||WW|XX|YY|ZZ)\?/', $v)){
						$count++;
					} elseif(preg_match('/echo\ \$\_\_\?/', $v)){
						// 忽略標記
					}
				} else {
					if(preg_match('/echo\ \$\_\_\?/', $v)){
						$count++;
					}
				}
			}
		}
	} else { // View
		$name = $datas['name'];

		$file = _BASEPATH.'/../view/'.$name.'.php';
		if(file_exists($file)){
			$has_phy_hole = false;

			// 先看看裡面有沒有實體的洞
			$checks = explode("\n", file_get_contents($file));
			foreach($checks as $k => $v){
				if(preg_match('/echo\ \$(AA|BB|CC|DD|EE|FF|GG|HH|II|JJ|KK|LL|MM|NN|OO|PP|QQ|RR|SS|TT|UU|VV||WW|XX|YY|ZZ)\?/', $v)){
					$has_phy_hole = true;
				}
			}

			// 從layoutv3/libs.php裡面複製過來的
			// 2018-05-14 李哥早上說可以做include置換成洞的這個功能
			if($checks and count($checks) > 0 and $has_phy_hole === false){
				$repeat = -1; // 如果有連續include，那實際上產出的標記只會有一個
				foreach($checks as $k => $v){
					if(trim($v) == ''){ // 為了要排除兩個include中間，夾著一個空白行
						continue;
					}
					// < ? php include('common/header.php'); ? >
					if(preg_match('/\?php\ include\(\'(.*)\'\);\?\>/', $v, $matches)){
						if($repeat >= 0){ // 有重覆
							// $check = str_replace_first('<'.'?'.'php include(\''.$matches[1].'\');?'.'>','',$check,1);
						} else {
							// $checks[$k] = '<'.'?'.'php echo $__?'.'>';
							// $check = str_replace_first('<'.'?'.'php include(\''.$matches[1].'\');?'.'>','<'.'?'.'php echo $__?'.'>',$check,1);
							$count++;
						}
						$repeat = $k;
					} else {
						$repeat = -1;
					}
				}
			}

			foreach($checks as $k => $v){
				if($has_phy_hole === true){
					if(preg_match('/echo\ \$(AA|BB|CC|DD|EE|FF|GG|HH|II|JJ|KK|LL|MM|NN|OO|PP|QQ|RR|SS|TT|UU|VV||WW|XX|YY|ZZ)\?/', $v)){
						$count++;
					} elseif(preg_match('/echo\ \$\_\_\?/', $v)){
						// 忽略標記
					}
				} else {
					if(preg_match('/echo\ \$\_\_\?/', $v)){
						$count++;
					}
				}
			}
		}
	}
}

if($count > 0){
	for($x=1;$x<=$count;$x++){
		$save = array(
			'name' => 'system/empty',
			//'pid' => $this->data['_last_insert_id'],
			'is_enable' => 1,
			'sort_id' => $x,
		);

		if($this->data['router_method'] == 'create'){
			$save['pid'] = $this->data['_last_insert_id'];
		} else {
			$save['pid'] = $this->data['id'];
		}

		$this->cidb->insert($this->data['router_class'], $save); 
		// $id = $this->cidb->insert_id();
	}
}
