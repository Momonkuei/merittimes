<?php

/*
 * 2019-12-02
 */

// var_dump($_params_);

$row = array();
$rows = array();

if(
	isset($_params_) and !empty($_params_)
	and isset($_params_['cidb_1']) and $_params_['cidb_1'] == 'rows'
	and isset($_params_['cidb_2']) and $_params_['cidb_2'] != '' // table
	and isset($_params_['cidb_3']) and $_params_['cidb_3'] != '' // type
){
	$date_sort = false;
	$rowg111 = $this->cidb->where('is_home',1)->where('type','webmenu')->where('ml_key',$this->data['ml_key'])->where('url1',$_params_['cidb_3'].$url_suffix)->get('html')->row_array();

	$common_date_sort = 0;
	if($rowg111){
		$common_date_sort = $rowg111['pic3'];
	}

	$o = $this->cidb;
	if($_params_['cidb_2'] == 'html'){
		$o = $o->select('*, topic as name');
	}
	$o = $o->where('is_enable',1)->where('ml_key',$this->data['ml_key']);
	if($common_date_sort == 1){
		$o = $o->order_by('start_date','desc');
	} else {
		$o = $o->order_by('sort_id','asc');
	}

	if($_params_['cidb_2'] == 'html'){
		$o = $o->where('type',$_params_['cidb_3']);
		$rows = $o->get('html')->result_array();

		$table = $_params_['cidb_3'];
	} else {
		$rows = $o->get($_params_['cidb_2'])->result_array();

		$table = $_params_['cidb_2'];
	}

	if(isset($_params_['cidb_4']) and $_params_['cidb_4'] == '1'){ // debug dump array
		var_dump($rows);
		die;
	}

	$router_method = $table;
	if(preg_match('/type$/', $router_method)){
		$router_method = str_replace('type', '', $router_method);
	}

	// 2019-12-04 有無內頁
	$common_has_page_detail = false;
	if(file_exists(_BASEPATH.'/../'.LAYOUTV3_PATH.'parent/'.$router_method.'detail.php')){
		$common_has_page_detail = true;
	} else {
		$tmp2 = $this->cidb->query('select * from layoutv3pagetype where is_enable=1 and pid=0 and theme_name="'.LAYOUTV3_THEME_NAME.'" and ( name="'.$router_method.'detail" or concat(",",other_func,",") LIKE "%,'.$router_method.'detail,%" )')->row_array();
		if($tmp2 and isset($tmp2['id'])){
			$common_has_page_detail = true;
		}
	}

	unset($_constant);
	eval('$_constant = '.strtoupper('seo_open').';');

	if(preg_match('/type$/', $table)){
		// SEO 分類
		$seos = $this->db->createCommand()->from('seo')->where('seo_ml_key =:ml_key and seo_type=:type',array(':ml_key'=>$this->data['ml_key'],':type'=>$table))->queryAll();
		$seos_type_tmp = array();
		if($seos){
			foreach($seos as $k => $v){
				$seos_type_tmp[$v['seo_item_id']] = $v;
			}
		}
		if($rows){
			foreach($rows as $k => $v){
				if(!isset($v['url']) and isset($v['id'])){
					if(isset($seos_type_tmp[$v['id']]) and $seos_type_tmp[$v['id']]['seo_script_name'] != '' and $_constant === true){
						$rows[$k]['url'] = $url_prefix.$seos_type_tmp[$v['id']]['seo_script_name'].'.html';
					} else {
						$rows[$k]['url'] = $router_method.$url_suffix.'?id='.$v['id'];
					}
				}
			}
		}
	} else {
		if($common_has_page_detail === true){
			// SEO 項目
			// 通常SEO都是做在分類上面，不過這裡還是先撰寫，然後給該功能的source/XXX/general_item.php所使用
			$seos = $this->db->createCommand()->from('seo')->where('seo_ml_key =:ml_key and seo_type=:type',array(':ml_key'=>$this->data['ml_key'],':type'=>$router_method))->queryAll();
			$seos_tmp = array();
			if($seos){
				foreach($seos as $k => $v){
					$seos_tmp[$v['seo_item_id']] = $v;
				}
			}
			if($rows){
				foreach($rows as $k => $v){
					if(!isset($v['url']) and isset($v['id'])){
						if(isset($seos_tmp[$v['id']]) and $seos_tmp[$v['id']]['seo_script_name'] != '' and $_constant === true){
							$rows[$k]['url'] = $url_prefix.$seos_tmp[$v['id']]['seo_script_name'].'.html';
						} else {
							$rows[$k]['url'] = $router_method.'detail'.$url_suffix.'?id='.$v['id'];
						}
					}
					if(!isset($v['attr2']) and isset($v['id'])){
						if(isset($seos_tmp[$v['id']]) and $seos_tmp[$v['id']]['seo_script_name'] != '' and $_constant === true){
							$rows[$k]['attr2'] = ' href="'.$url_prefix.$seos_tmp[$v['id']]['seo_script_name'].'.html" ';
						} else {
							$rows[$k]['attr2'] = ' href="'.$router_method.'detail'.$url_suffix.'?id='.$v['id'].'" ';
						}
					}
				}
			}
		} else {
			if($rows){
				foreach($rows as $k => $v){
					if(!isset($v['url']) and isset($v['id'])){
						$rows[$k]['url'] = '#';
					}
					if(!isset($v['attr2']) and isset($v['id'])){
						$rows[$k]['attr2'] = ' href="#" ';
					}
				}
			}
		}
	}

	if(isset($_params_['cidb_0'])){
		$data[$ID] = $rows;
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
		$data[$next_id] = $rows;
	}

	// 底下程式銜接的方式3 (V1第二版)
	$this->data['_general_rows'] = $rows;
} elseif(
	isset($_params_) and !empty($_params_)
	and isset($_params_['cidb_1']) and $_params_['cidb_1'] == 'row'
	and isset($_params_['cidb_2']) and $_params_['cidb_2'] != '' // table
	and isset($_params_['cidb_3']) and $_params_['cidb_3'] != '' // type
	and isset($_params_['cidb_4']) and $_params_['cidb_4'] != '' // id
){
	$o = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key']);
	$has_id = true;
	if($_params_['cidb_4'] == 'id'){
		if(isset($_GET['id']) and $_GET['id'] != ''){
			$o = $o->where('id',$_GET['id']);
		} else {
			$has_id = false;
		}
	} else {
		$o = $o->where('id',$_params_['cidb_4']);
	}

	if($has_id === true){
		if($_params_['cidb_2'] == 'html'){
			$o = $o->where('type',$_params_['cidb_3']);
			$row = $o->get('html')->row_array();

			$table = $_params_['cidb_3'];
		} else {
			$row = $o->get($_params_['cidb_2'])->row_array();

			$table = $_params_['cidb_2'];
		}

		if(isset($_params_['cidb_5']) and $_params_['cidb_5'] == '1'){ // debug dump array
			var_dump($row);
			die;
		}

		$router_method = $table;
		if(preg_match('/type$/', $router_method)){
			$router_method = str_replace('type','',$router_method);
		}

		// 2019-12-04 有無內頁
		$common_has_page_detail = false;
		if(file_exists(_BASEPATH.'/../'.LAYOUTV3_PATH.'parent/'.$router_method.'detail.php')){
			$common_has_page_detail = true;
		} else {
			$tmp2 = $this->cidb->query('select * from layoutv3pagetype where is_enable=1 and pid=0 and theme_name="'.LAYOUTV3_THEME_NAME.'" and ( name="'.$router_method.'detail" or concat(",",other_func,",") LIKE "%,'.$router_method.'detail,%" )')->row_array();
			if($tmp2 and isset($tmp2['id'])){
				$common_has_page_detail = true;
			}
		}

		unset($_constant);
		eval('$_constant = '.strtoupper('seo_open').';');

		if(preg_match('/type$/', $table)){
			// SEO 分類
			$seos = $this->db->createCommand()->from('seo')->where('seo_ml_key =:ml_key and seo_type=:type',array(':ml_key'=>$this->data['ml_key'],':type'=>$table))->queryAll();
			$seos_type_tmp = array();
			if($seos){
				foreach($seos as $k => $v){
					$seos_type_tmp[$v['seo_item_id']] = $v;
				}
			}
			if($row and !isset($row['url']) and isset($row['id'])){
				if(isset($seos_type_tmp[$row['id']]) and $seos_type_tmp[$row['id']]['seo_script_name'] != '' and $_constant === true){
					$row['url'] = $url_prefix.$seos_type_tmp[$row['id']]['seo_script_name'].'.html';
				} else {
					$row['url'] = $router_method.$url_suffix.'?id='.$row['id'];
				}
			}
		} else {
			if($common_has_page_detail === true){
				// SEO 項目
				// 通常SEO都是做在分類上面，不過這裡還是先撰寫，然後給該功能的source/XXX/general_item.php所使用
				$seos = $this->db->createCommand()->from('seo')->where('seo_ml_key =:ml_key and seo_type=:type',array(':ml_key'=>$this->data['ml_key'],':type'=>$router_method))->queryAll();
				$seos_tmp = array();
				if($seos){
					foreach($seos as $k => $v){
						$seos_tmp[$v['seo_item_id']] = $v;
					}
				}
				if($row and !isset($row['url']) and isset($row['id'])){
					if(isset($seos_tmp[$row['id']]) and $seos_tmp[$row['id']]['seo_script_name'] != '' and $_constant === true){
						$row['url'] = $url_prefix.$seos_tmp[$row['id']]['seo_script_name'].'.html';
					} else {
						$row['url'] = $router_method.'detail'.$url_suffix.'?id='.$row['id'];
					}
				}
				if($row and !isset($row['attr2']) and isset($row['id'])){
					if(isset($seos_tmp[$row['id']]) and $seos_tmp[$row['id']]['seo_script_name'] != '' and $_constant === true){
						$row['attr2'] = ' href="'.$url_prefix.$seos_tmp[$row['id']]['seo_script_name'].'.html" ';
					} else {
						$row['attr2'] = ' href="'.$router_method.'detail'.$url_suffix.'?id='.$row['id'].'" ';
					}
				}
			} else {
				if($row and !isset($row['url']) and isset($row['id'])){
					$row['url'] = '#';
				}
				if($row and !isset($row['attr2']) and isset($row['id'])){
					$row['url'] = ' href="#" ';
				}
			}
		}

		// 2019-12-11
		if(isset($row['name']) and !isset($row['topic'])){
			$row['topic'] = $row['name'];
		}

		if(isset($_params_['cidb_0'])){
			$data[$ID] = $row;
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
			$data[$next_id] = $row;
		}

		// 底下程式銜接的方式3 (V1第二版)
		$this->data['_general_detail'] = $row;
	}
}
?>
