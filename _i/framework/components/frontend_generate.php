<?php
/*
 * 前台產生器
 */

		// 規則的集合
		if(!isset($this->data['sys_configs']['template_rulev1_group'])){
			$this->data['sys_configs']['template_rulev1_group'] = 'sys_rule_v1';
		}

		if(isset($_SESSION['template_rulev1_group']) and $_SESSION['template_rulev1_group'] != ''){
			$this->data['sys_configs']['template_rulev1_group'] = $_SESSION['template_rulev1_group'];
		}
		//echo $this->data['sys_configs']['template_rulev1_group'];
		//die;


// 規則的集合
//if(!isset($this->data['sys_configs']['template_rulev1_group'])){
//	$this->data['sys_configs']['template_rulev1_group'] = 'sys_rule_v1';
//}

//if(isset($_SESSION['template_rulev1_group']) and $_SESSION['template_rulev1_group'] != ''){
//	$this->data['sys_configs']['template_rulev1_group'] = $_SESSION['template_rulev1_group'];
//}
//echo $this->data['sys_configs']['template_rulev1_group'];
//die;

		/*
		 * 跟value或是content有關的屬性，要擺放在第一順位(例如value, innertext等)
		 */
		$dom_tags = array(
			'a' => array(
				'innertext', 'href', 'title',
			),
			'div' => array(
				'innertext',
			),
			'span' => array(
				'innertext',
			),
			'img' => array(
				'src', 'title',
			),
			'p' => array(
				'innertext',
			),
			'label' => array(
				'innertext',
			),
		);

		if(empty($_POST) and Yii::app()->db->schema->getTable($this->data['sys_configs']['template_rulev1_group'])){

			$class_method = $this->data['router_class'].'/'.$this->data['router_method'];
			$row01 = $this->db->createCommand()->from($this->data['sys_configs']['template_rulev1_group'])->where('is_enable=1 and (func=:func OR concat(\',\',func_other,\',\') LIKE \'%,'.$class_method.',%\')', array(':func'=>$this->data['router_class'].'/'.$this->data['router_method']))->queryRow();
			if($row01 and isset($row01['id'])){

				//    // 規則 (預先處理的東西會放這裡)
				//    $common_funcs = array();
				//    $common_descriptions = array();
				//    $rows = $this->db->createCommand()->from($this->data['sys_configs']['template_rulev1_group'].'_db')->where('is_enable=1 AND data_id=:id', array(':id'=>$row01['id']))->order('sort_id')->queryAll();
				//    if($rows and count($rows) > 0){
				//    	foreach($rows as $k => $v){
				//    		if(isset($v['type']) and $v['type'] == 'common_func'){
				//    			if($v['description'] != ''){
				//    				$common_funcs[] = array($v['description'],$v['param1']);
				//    			}
				//    		} elseif(isset($v['type']) and $v['type'] == 'common_description'){
				//    			if($v['description'] != ''){
				//    				$common_descriptions[] = array($v['description'],$v['param1']);
				//    			}
				//    		}
				//    	}
				//    }

				//    $common_func_ids = array();
				//    $common_func_sql = '';

				//    if(count($common_funcs) > 0){
				//    	// 先搜尋英文名稱是那個的編號
				//    	foreach($common_funcs as $k => $v){
				//    		//$template_rulev1_group = 'sys_rule_v1';
				//    		$template_rulev1_group = $this->data['sys_configs']['template_rulev1_group'];
				//    		if($v[1] != ''){
				//    			$template_rulev1_group = $v[1];
				//    		}
				//    		$row = $this->db->createCommand()->from($template_rulev1_group)->where('is_enable=1 and func=:func', array(':func'=>$v[0]))->queryRow();
				//    		if($row and isset($row['id'])){
				//    			$common_func_ids[] = $row['id'];
				//    		}
				//    	}
				//    	if(count($common_func_ids) > 0){
				//    		$common_func_sql = ' OR data_id='.implode(' OR data_id=', $common_func_ids);
				//    	}
				//    }

				//    $common_description_ids = array();
				//    $common_description_sql = '';

				//    if(count($common_descriptions) > 0){
				//    	foreach($common_descriptions as $k => $v){
				//    		//$template_rulev1_group = 'sys_rule_v1';
				//    		$template_rulev1_group = $this->data['sys_configs']['template_rulev1_group'];
				//    		if($v[1] != ''){
				//    			$template_rulev1_group = $v[1];
				//    		}
				//    		$row = $this->db->createCommand()->from($template_rulev1_group.'_db')->where('is_enable=1 and description=:description', array(':description'=>str_replace('　','',$v[0])))->queryRow();
				//    		if($row and isset($row['id'])){
				//    			$common_description_ids[] = $row['id'];
				//    		}
				//    	}
				//    	if(count($common_description_ids) > 0){
				//    		$common_description_sql = ' OR id='.implode(' OR id=', $common_description_ids);
				//    	}
				//    }

				// 規則 (預先處理的東西會放這裡)
				$common_funcs = array();
				$common_descriptions = array();

				$common_funcs2 = array();
				$common_descriptions2 = array();

				$rows = $this->db->createCommand()->from($this->data['sys_configs']['template_rulev1_group'].'_db')->where('is_enable=1 AND data_id=:id', array(':id'=>$row01['id']))->order('sort_id')->queryAll();
				if($rows and count($rows) > 0){
					foreach($rows as $k => $v){
						if(isset($v['type']) and $v['type'] == 'common_func'){
							if($v['description'] != '' and $v['param1'] == ''){
								$common_funcs[] = $v['description'];
							} elseif($v['description'] != '' and $v['param1'] != ''){
								$common_funcs2[] = array($v['description'],$v['param1']);
							}
						} elseif(isset($v['type']) and $v['type'] == 'common_description'){
							if($v['description'] != '' and $v['param1'] == ''){
								$common_descriptions[] = $v['description'];
							} elseif($v['description'] != '' and $v['param1'] != ''){
								$common_descriptions2[] = array($v['description'],$v['param1']);
							}
						}
					}
				}

				/*
				 * 正常的
				 */

				$common_func_ids = array();
				$common_func_sql = '';

				if(count($common_funcs) > 0){
					// 先搜尋英文名稱是那個的編號
					foreach($common_funcs as $k => $v){
						$row = $this->db->createCommand()->from($this->data['sys_configs']['template_rulev1_group'])->where('is_enable=1 and func=:func', array(':func'=>$v))->queryRow();
						if($row and isset($row['id'])){
							$common_func_ids[] = $row['id'];
						}
					}
					if(count($common_func_ids) > 0){
						$common_func_sql = ' OR data_id='.implode(' OR data_id=', $common_func_ids);
					}
				}

				$common_description_ids = array();
				$common_description_sql = '';

				if(count($common_descriptions) > 0){
					foreach($common_descriptions as $k => $v){
						$row = $this->db->createCommand()->from($this->data['sys_configs']['template_rulev1_group'].'_db')->where('is_enable=1 and description=:description', array(':description'=>str_replace('　','',$v)))->queryRow();
						if($row and isset($row['id'])){
							$common_description_ids[] = $row['id'];
						}
					}
					if(count($common_description_ids) > 0){
						$common_description_sql = ' OR id='.implode(' OR id=', $common_description_ids);
					}
				}

				/*
				 * 不正常的
				 */

				$common_func_ids2 = array();
				$common_func_sql2 = array();

				if(count($common_funcs2) > 0){
					// 先搜尋英文名稱是那個的編號
					foreach($common_funcs2 as $k => $v){
						$row = $this->db->createCommand()->from($v[1])->where('is_enable=1 and func=:func', array(':func'=>$v[0]))->queryRow();
						if($row and isset($row['id'])){
							if(!isset($common_func_ids2[$v[1]])){
								$common_func_ids2[$v[1]] = array();
								$common_func_sql2[$v[1]] = array();
							}
							$common_func_ids2[$v[1]][] = $row['id'];
						}
					}
					if(count($common_func_ids2) > 0){
						// @k 集合
						foreach($common_func_ids2 as $k => $v){
							$common_func_sql2[$k][] = ' OR data_id='.implode(' OR data_id=', $common_func_ids2[$k]);
						}
					}
				}

				$rows1 = array();

				// 收集
				if($common_func_sql2 and count($common_func_sql2) > 0){
					foreach($common_func_sql2 as $k => $v){
						foreach($v as $kk => $vv){
							$rows1[] = $this->db->createCommand()->from($k.'_db')->where('is_enable=1 AND ( '.substr($vv,3).' )')->order('sort_id')->queryAll();
						}
					}
				}

				$common_description_ids2 = array();
				$common_description_sql2 = array();

				if(count($common_descriptions2) > 0){
					foreach($common_descriptions2 as $k => $v){
						$row = $this->db->createCommand()->from($v[1].'_db')->where('is_enable=1 and description=:description', array(':description'=>str_replace('　','',$v[0])))->queryRow();
						if($row and isset($row['id'])){
							if(!isset($common_description_ids2[$v[1]])){
								$common_description_ids2[$v[1]] = array();
								$common_description_sql2[$v[1]] = array();
							}
							$common_description_ids2[$v[1]][] = $row['id'];
						}
					}
					if(count($common_description_ids2) > 0){
						// @k 集合
						foreach($common_description_ids2 as $k => $v){
							$common_description_sql2[$k][] = ' OR id='.implode(' OR id=', $common_description_ids2[$k]);
						}
					}
				}

				$rows2 = array();

				// 收集
				if($common_description_sql2 and count($common_description_sql2) > 0){
					foreach($common_description_sql2 as $k => $v){
						foreach($v as $kk => $vv){
							$rows2[] = $this->db->createCommand()->from($k.'_db')->where('is_enable=1 AND ( '.substr($vv,3).' )')->order('sort_id')->queryAll();
						}
					}
				}

				// 等一下要做sort_id的合併和排序
				// http://stackoverflow.com/questions/3701855/how-do-i-sort-a-php-array-by-an-element-nested-inside

				//var_dump($common_func_sql2);
				//var_dump($common_description_sql2);

				// 規則
				// 記得！！！底下的變數指定，千萬不能用$rows，不然保證出錯
				$rows = $this->db->createCommand()->from($this->data['sys_configs']['template_rulev1_group'].'_db')->where('is_enable=1 AND (data_id=:id '.$common_func_sql.' '.$common_description_sql.')', array(':id'=>$row01['id']))->order('sort_id')->queryAll();
				if($rows1 and count($rows1) > 0){
					foreach($rows1 as $k => $v){
						$rows = array_merge($rows,$v);
					}
				}

				function cmp($a, $b)
				{
					//var_dump($a);
					//die;
					if ($a['sort_id'] == $b['sort_id']) {
						return 0;
					}
					return ($a['sort_id'] < $b['sort_id']) ? -1 : 1;
				}

				//var_dump($rows);

				if($rows2 and count($rows2) > 0){
					foreach($rows2 as $k => $v){
						$rows = array($rows,$v);
					}
				}

				usort($rows,"cmp");

				// 資料來源
				//$rows = $this->db->createCommand()->from($this->data['sys_configs']['template_rulev1_group'].'_db')->where('is_enable=1 AND (data_id=:id '.$common_func_sql.' '.$common_description_sql.')', array(':id'=>$row01['id']))->order('sort_id')->queryAll();
				if($rows and count($rows) > 0){
					foreach($rows as $k => $v){
						if(isset($v['type']) and $v['type'] == 'yii_query_builder'){
							// 參考 $row = $this->db->createCommand()->from('html')->where('is_enable=1')->queryRow();
							$data_var = $v["param1"];
							unset($v['param1']);
							$tmp01 = array();
							foreach($v as $kk => $vv){
								if(preg_match('/^param/', $kk) and $vv != ''){
									$tmp01[] = $vv;
								}
							}
							$run = '$this->data[$data_var] = $this->db->createCommand()->'.implode('->', $tmp01).';';
							eval($run);
						} elseif(isset($v['type']) and $v['type'] == 'yii_query_builder_for_html_table_with_ml_key'){
							// 參考 $row = $this->db->createCommand()->from('html')->where('is_enable=1')->queryRow();
							$data_var = $v["param1"];
							unset($v['param1']);

							$data_type = $v["param2"];
							unset($v['param2']);

							$tmp01 = array();
							foreach($v as $kk => $vv){
								if(preg_match('/^param/', $kk) and $vv != ''){
									$tmp01[] = $vv;
								}
							}
							$run = '$this->data[$data_var] = $this->db->createCommand()->';
							$run .= '->from(\'html\')';
							$run .= '->where(\'type="'.$data_type.'"\')';
							$run .= implode('->', $tmp01).';';
							eval($run);
						} elseif(isset($v['type']) and $v['type'] == 'ci_active_record'){
							// 範本 $rows = $this->cidb->where('is_enable', 1)->like('interface', ',2,', 'both')->get('ml')->result_array();
							$data_var = $v["param1"];
							unset($v['param1']);
							$tmp01 = array();
							foreach($v as $kk => $vv){
								if(preg_match('/^param/', $kk) and $vv != ''){
									$tmp01[] = $vv;
								}
							}
							$run = '$this->data[$data_var] = $this->cidb->'.implode('->', $tmp01).';';
							eval($run);
						}
					}
				}

				// 欄位的處理程式，為了只寫一次
				$field_handle_find = <<<XXX
if(preg_match('/find\(/', xxx)){
	xxx = str_replace('find(', "find('", xxx);
}

if(preg_match('/,(\d)\)->/', xxx)){
	for(\$x=0;\$x<=10;\$x++){
		xxx = str_replace(','.\$x.')->', "',".\$x.")->", xxx);
	}
}
XXX;

				$field_handle_value = <<<XXX
if(preg_match('/^PHP:/', xxx)){
	xxx = str_replace('PHP:', '', xxx);
} else {
	xxx = "'".xxx."'";
}
XXX;

				// 規則 (預先處理的東西會放這裡)
				$common_funcs = array();
				$common_descriptions = array();

				$common_funcs2 = array();
				$common_descriptions2 = array();

				$rows = $this->db->createCommand()->from($this->data['sys_configs']['template_rulev1_group'].'_list')->where('is_enable=1 AND data_id=:id', array(':id'=>$row01['id']))->order('sort_id')->queryAll();
				if($rows and count($rows) > 0){
					foreach($rows as $k => $v){
						if(isset($v['type']) and $v['type'] == 'common_func'){
							if($v['description'] != '' and $v['param1'] == ''){
								$common_funcs[] = $v['description'];
							} elseif($v['description'] != '' and $v['param1'] != ''){
								$common_funcs2[] = array($v['description'],$v['param1']);
							}
						} elseif(isset($v['type']) and $v['type'] == 'common_description'){
							if($v['description'] != '' and $v['param1'] == ''){
								$common_descriptions[] = $v['description'];
							} elseif($v['description'] != '' and $v['param1'] != ''){
								$common_descriptions2[] = array($v['description'],$v['param1']);
							}
						}
					}
				}

				/*
				 * 正常的
				 */

				$common_func_ids = array();
				$common_func_sql = '';

				if(count($common_funcs) > 0){
					// 先搜尋英文名稱是那個的編號
					foreach($common_funcs as $k => $v){
						$row = $this->db->createCommand()->from($this->data['sys_configs']['template_rulev1_group'])->where('is_enable=1 and func=:func', array(':func'=>$v))->queryRow();
						if($row and isset($row['id'])){
							$common_func_ids[] = $row['id'];
						}
					}
					if(count($common_func_ids) > 0){
						$common_func_sql = ' OR data_id='.implode(' OR data_id=', $common_func_ids);
					}
				}

				$common_description_ids = array();
				$common_description_sql = '';

				if(count($common_descriptions) > 0){
					foreach($common_descriptions as $k => $v){
						$row = $this->db->createCommand()->from($this->data['sys_configs']['template_rulev1_group'].'_list')->where('is_enable=1 and description=:description', array(':description'=>str_replace('　','',$v)))->queryRow();
						if($row and isset($row['id'])){
							$common_description_ids[] = $row['id'];
						}
					}
					if(count($common_description_ids) > 0){
						$common_description_sql = ' OR id='.implode(' OR id=', $common_description_ids);
					}
				}

				/*
				 * 不正常的
				 */

				$common_func_ids2 = array();
				$common_func_sql2 = array();

				if(count($common_funcs2) > 0){
					// 先搜尋英文名稱是那個的編號
					foreach($common_funcs2 as $k => $v){
						$row = $this->db->createCommand()->from($v[1])->where('is_enable=1 and func=:func', array(':func'=>$v[0]))->queryRow();
						if($row and isset($row['id'])){
							if(!isset($common_func_ids2[$v[1]])){
								$common_func_ids2[$v[1]] = array();
								$common_func_sql2[$v[1]] = array();
							}
							$common_func_ids2[$v[1]][] = $row['id'];
						}
					}
					if(count($common_func_ids2) > 0){
						// @k 集合
						foreach($common_func_ids2 as $k => $v){
							$common_func_sql2[$k][] = ' OR data_id='.implode(' OR data_id=', $common_func_ids2[$k]);
						}
					}
				}

				$rows1 = array();

				// 收集
				if($common_func_sql2 and count($common_func_sql2) > 0){
					foreach($common_func_sql2 as $k => $v){
						foreach($v as $kk => $vv){
							//$rows1[] = $this->db->createCommand()->from($k.'_list')->where('is_enable=1 AND ( '.substr($vv,3).' )')->order('sort_id')->queryAll();
							$tmp = $this->db->createCommand()->from($k.'_list')->where('is_enable=1 AND ( '.substr($vv,3).' )')->order('sort_id')->queryAll();
							if($tmp and count($tmp) > 0){
								foreach($tmp as $kkk => $vvv){
									$tmp[$kkk]['table'] = $k;
								}
							}
							$rows1[] = $tmp;
						}
					}
				}

				$common_description_ids2 = array();
				$common_description_sql2 = array();

				if(count($common_descriptions2) > 0){
					foreach($common_descriptions2 as $k => $v){
						$row = $this->db->createCommand()->from($v[1].'_list')->where('is_enable=1 and description=:description', array(':description'=>str_replace('　','',$v[0])))->queryRow();
						if($row and isset($row['id'])){
							if(!isset($common_description_ids2[$v[1]])){
								$common_description_ids2[$v[1]] = array();
								$common_description_sql2[$v[1]] = array();
							}
							$common_description_ids2[$v[1]][] = $row['id'];
						}
					}
					if(count($common_description_ids2) > 0){
						// @k 集合
						foreach($common_description_ids2 as $k => $v){
							$common_description_sql2[$k][] = ' OR id='.implode(' OR id=', $common_description_ids2[$k]);
						}
					}
				}

				$rows2 = array();

				// 收集
				if($common_description_sql2 and count($common_description_sql2) > 0){
					foreach($common_description_sql2 as $k => $v){
						foreach($v as $kk => $vv){
							//$rows2[] = $this->db->createCommand()->from($k.'_list')->where('is_enable=1 AND ( '.substr($vv,3).' )')->order('sort_id')->queryAll();
							$tmp = $this->db->createCommand()->from($k.'_list')->where('is_enable=1 AND ( '.substr($vv,3).' )')->order('sort_id')->queryAll();
							if($tmp and count($tmp) > 0){
								foreach($tmp as $kkk => $vvv){
									$tmp[$kkk]['table'] = $k;
								}
							}
							$rows2[] = $tmp;
						}
					}
				}

				// 處理(載入)自動產生的規則

				$rows3 = array();

				$filename_path = Yii::getPathOfAlias('application').'/controllers/'.$this->data['sys_configs']['template_rulev1_group'].'-'.str_replace('/','-',$class_method).'.php';
				if(file_exists($filename_path)){
					$tmpx = file_get_contents($filename_path);
					eval('?'.'>'.$tmpx);
					$data_id = 0;
					$param1 = 'gggaaa';
					if($rowsx and count($rowsx) > 0){
						foreach($rowsx as $k => $v){
							if($v['is_enable'] == 0){
								unset($rowsx[$k]);
							} else {
								if($data_id <= 0){
									$data_id = $v['data_id'];
								}
								if(preg_match('/,/', $v['param1']) and preg_match('/^(single|multi)$/', $v['type'])){
									$param1 = $v['param1']; // 單筆和多筆裡面尋找
								}
							}
						}
					}
					if($rowsx and count($rowsx) > 0){
						// $rowsx[] = array(
						// 	'is_enable' => '1',
						// 	'description' => '把自動屬性移除掉(rulev1="single")',
						// 	'data_id' => $data_id,
						// 	'type' => 'search_replace',
						// 	'sort_id' => 98,
						// 	'param1' => $param1,
						// 	'param2' => 'rulev1="single"',
						// 	'param3' => '','param4' => '','param5' => '','id' => 0,
						// );
						// $rowsx[] = array(
						// 	'is_enable' => '1',
						// 	'description' => '把自動屬性移除掉(rulev1="multi")',
						// 	'data_id' => $data_id,
						// 	'type' => 'search_replace',
						// 	'sort_id' => 98,
						// 	'param1' => $param1,
						// 	'param2' => 'rulev1="multi"',
						// 	'param3' => '','param4' => '','param5' => '','id' => 0,
						// );
						// $rowsx[] = array(
						// 	'is_enable' => '1',
						// 	'description' => '把自動屬性移除掉(rulev1="1")',
						// 	'data_id' => $data_id,
						// 	'type' => 'search_replace',
						// 	'sort_id' => 98,
						// 	'param1' => $param1,
						// 	'param2' => 'rulev1="1"',
						// 	'param3' => '','param4' => '','param5' => '','id' => 0,
						// );
						// $rowsx[] = array(
						// 	'is_enable' => '1',
						// 	'description' => '把自動屬性移除掉(rulev1="n")',
						// 	'data_id' => $data_id,
						// 	'type' => 'search_replace',
						// 	'sort_id' => 98,
						// 	'param1' => $param1,
						// 	'param2' => 'rulev1="n"',
						// 	'param3' => '','param4' => '','param5' => '','id' => 0,
						// );
						// $rowsx[] = array(
						// 	'is_enable' => '1',
						// 	'description' => '把自動屬性移除掉(rulev1="ml")',
						// 	'data_id' => $data_id,
						// 	'type' => 'search_replace',
						// 	'sort_id' => 98,
						// 	'param1' => $param1,
						// 	'param2' => 'rulev1="ml"',
						// 	'param3' => '','param4' => '','param5' => '','id' => 0,
						// );
						$rows3 = $rowsx;
					}
				}

				// 等一下要做sort_id的合併和排序
				// http://stackoverflow.com/questions/3701855/how-do-i-sort-a-php-array-by-an-element-nested-inside

				//var_dump($common_func_sql2);
				//var_dump($common_description_sql2);

				// 規則
				// 記得！！！底下的變數指定，千萬不能用$rows，不然保證出錯
				$rows = $this->db->createCommand()->from($this->data['sys_configs']['template_rulev1_group'].'_list')->where('is_enable=1 AND (data_id=:id '.$common_func_sql.' '.$common_description_sql.')', array(':id'=>$row01['id']))->order('sort_id')->queryAll();
				if($rows1 and count($rows1) > 0){
					foreach($rows1 as $k => $v){
						$rows = array_merge($rows,$v);
					}
				}

				//function cmp($a, $b)
				//{
				//	//var_dump($a);
				//	//die;
				//	if ($a['sort_id'] == $b['sort_id']) {
				//		return 0;
				//	}
				//	return ($a['sort_id'] < $b['sort_id']) ? -1 : 1;
				//}

				//var_dump($rows);

				if($rows2 and count($rows2) > 0){
					foreach($rows2 as $k => $v){
						$rows = array($rows,$v);
					}
				}

				if($rows3 and count($rows3) > 0){
					$rows = array_merge($rows,$rows3);
				}


				usort($rows,"cmp");

				//var_dump($rows);
				//die;

				if($rows and count($rows) > 0){
					$simplehtml = new SimpleHtmlDom;
					// http://stackoverflow.com/questions/17202910/dynamic-add-to-current-foreach-array
					foreach($rows as $k => $v){
						//include 'frontend_generate_core.php';
						//continue;
						if(isset($v['type']) and $v['type'] == 'empty'){

							// 終於又出現了，什麼都沒有

							// 用description來當檔名，來看一下外掛的程式有沒有存在
							$plugin_file = Yii::getPathOfAlias('application').ds('/controllers/'.$this->data['sys_configs']['template_rulev1_group'].'/').$v['description'].'.php';
							if(!file_exists($plugin_file)){
								$plugin_file = '';
							}

							// 外掛程式
							if($plugin_file != ''){
								include $plugin_file;
							}

						} elseif(isset($v['type']) and $v['type'] == 'str_get_html'){
							$file = $v['param2'];
							if($v['param3'] != '' and isset($this->data[$v['param3']]) and $this->data[$v['param3']] != ''){
								$file = $this->data[$v['param3']].'/'.$file;
							}

							$content_tmp01 = file_get_contents($file);
							//$simplehtml = new SimpleHtmlDom;
							$this->data[$v['param1']] = str_get_html($content_tmp01, true, true, DEFAULT_TARGET_CHARSET, false);

							// 試著加上前台即時編輯的功能
							if(isset($_SESSION['authw_admin_id']) and $_SESSION['authw_admin_id'] == 1){
								$run = '$this->data[$v["param1"]]->find("head",0)->innertext = \'<link rel="stylesheet" type="text/css" href="html/TooltipStylesInspiration/css/tooltip-classic.css" />\'.$this->data[$v["param1"]]->find("head",0)->innertext;';
								eval($run);
							}

							if(isset($v['param4']) and $v['param4'] != ''){
								$rule = $v['param4'];
								eval(str_replace('xxx', '$rule', $field_handle_find));

								$run = '$this->data[$v["param1"]] = $this->data[$v["param1"]]->'.$rule.';';
								eval($run);
							}

						} elseif(isset($v['type']) and $v['type'] == 'str_get_html_content'){
							eval(str_replace('xxx', '$v["param2"]', $field_handle_value));

							$run = '$this->data[$v["param1"]] = str_get_html('.$v["param2"].', true, true, DEFAULT_TARGET_CHARSET, false);';
							eval($run);

						} elseif(isset($v['type']) and $v['type'] == 'assign'){
							$rule = $v['param2'];
							eval(str_replace('xxx', '$rule', $field_handle_find));

							$run = '$this->data[$v["param1"]]->'.$rule.' = ';
							eval(str_replace('xxx', '$v["param3"]', $field_handle_value));
							$run .= $v['param3'].';';
							//echo $run.'<br />';
							eval($run);

							// 試著加上前台即時編輯的功能
							//if(isset($_SESSION['authw_admin_id']) and $_SESSION['authw_admin_id'] == 1 and 0){ // preg_match('/1/', $_SESSION['auth_admin_type'])){
							if(isset($_SESSION['template_rulev1_group_edit']) and $_SESSION['template_rulev1_group_edit']){
								$tmps = explode('->', $rule);
								unset($tmps[count($tmps)-1]);
								$rulex = implode('->', $tmps); // 只是把最後的屬性給拿掉，例如"->innertext"
								$group = $this->data['sys_configs']['template_rulev1_group'];
								if(isset($v['table'])){
									$group = $v['table'];
								}
								$onlyid = $group.$v['id'];

								$description = $v['description'];
								$url = '_i/backend.php?r=rulev1assign/index&a='.$group.'&id='.$v['id'].'&prev='.base64url::encode($_SERVER['REQUEST_URI']);

								$run_value = <<<XXX
<span class="tooltip tooltip-effect-5" id="toolgtip_$onlyid" onclick=\'window.location.href="$url";\'>
	<span class="tooltip-item">$description</span>
	<span class="tooltip-content clearfix">
	<span class="tooltip-text">123</span>
	</span>
</span>
<script type="text/javascript">
$(document).ready(function(){
	$(".tooltip").hover(
		function(){
			$("."+$(this).attr("id")+"_target").addClass("tooltip_focus");
		},
		function(){
			$("."+$(this).attr("id")+"_target").removeClass("tooltip_focus");
		}
	);
});
</script>
XXX;
								//$run = '$this->data[$v["param1"]]->'.$rulex.'->outertext .= "<span class=\"tooltip tooltip-effect-5\" onclick=\'window.location.href=\"_i/backend.php?r=rulev1assign/index&a='.$group.'&id='.$v['id'].'&prev='.base64url::encode($_SERVER['REQUEST_URI']).'\"\'><span class=\"tooltip-item\">'.$v['description'].'</span><span class=\"tooltip-content clearfix\"><span class=\"tooltip-text\">123</span></span></span>";';

								// 在規則的目標，增加一個class，方便我附加class上去
								$run = '$this->data[$v["param1"]]->'.$rulex.'->class .= " toolgtip_'.$onlyid.'_target";';
								//echo $run;
								eval($run);

								$run = '$this->data[$v["param1"]]->'.$rulex.'->outertext .= \''.$run_value.'\';';
								eval($run);

							}

						} elseif(isset($v['type']) and $v['type'] == 'append_left'){
							$rule = $v['param2'];

							eval(str_replace('xxx', '$v["param3"]', $field_handle_value));

							//if(!isset($this->data[$v['param1']])){
							//	$this->data[$v['param1']] = str_get_html(''/*空白的*/, true, true, DEFAULT_TARGET_CHARSET, false);
							//}

							// 沒有下規則的時候，就是變數合併
							if($rule == ''){
								if(!isset($this->data[$v['param1']])){
									$run = '$this->data[$v["param1"]] = str_get_html('.$v["param3"].'->save(), true, true, DEFAULT_TARGET_CHARSET, false);';
								} else {
									if($v['param4'] == '2'){ // 右邊
										$run = '$this->data[$v["param1"]] = str_get_html($this->data[$v["param1"]]->save().'.$v["param3"].', true, true, DEFAULT_TARGET_CHARSET, false);';
									} else { // 左邊
										$run = '$this->data[$v["param1"]] = str_get_html('.$v["param3"].'.$this->data[$v["param1"]]->save(), true, true, DEFAULT_TARGET_CHARSET, false);';
									}
								}
								//echo $run;
								//die;
								eval($run);
							} else {
								eval(str_replace('xxx', '$rule', $field_handle_find));

								$run = '$this->data[$v["param1"]]->'.$rule.' = ';
								if($v['param4'] == '2'){
									$run .= '$this->data[$v["param1"]]->'.$rule.'.';
									$run .= $v["param3"].';';
								} else {
									$run .= $v["param3"].'.';
									$run .= '$this->data[$v["param1"]]->'.$rule.';';
								}
								eval($run);

								// dirty hack, 不要問我為什麼，因為在這個規則以下，下條件會失效
								//$this->data[$v['param1']] = str_get_html($this->data[$v['param1']]);

								$this->data[$v['param1']] = str_get_html($this->data[$v['param1']]->save(), true, true, DEFAULT_TARGET_CHARSET, false);
							}

						} elseif(isset($v['type']) and $v['type'] == 'get'){
							$rule = $v['param3'];
							eval(str_replace('xxx', '$rule', $field_handle_find));

							$run = '$this->data[$v["param1"]] = $this->data[$v["param2"]]->'.$rule.';';
							eval($run);

						} elseif(isset($v['type']) and $v['type'] == 'search_replace'){
							eval(str_replace('xxx', '$v["param3"]', $field_handle_value));
							// 原有的Object，會被搜尋取代指定變數後，會變回字串，所以不能這樣子寫
							//$run = '$this->data[$v["param1"]] = str_replace($v["param2"], '.$v["param3"].',$this->data[$v["param1"]]);';
							$run = '$this->data[$v["param1"]] = str_get_html(str_replace($v["param2"], '.$v["param3"].',$this->data[$v["param1"]]), true, true, DEFAULT_TARGET_CHARSET, false);';
							//echo $run;
							//die;
							eval($run);

						} elseif(isset($v['type']) and $v['type'] == 'search_replace_html'){
							eval(str_replace('xxx', '$v["param3"]', $field_handle_value));
							$auto = false; // 是否程式決定
							if($v["param3"] == '\'\''){
								$v["param3"] = $this->data['sys_configs']['template_rulev1_group'];
								$auto = true; // 是否程式決定
							} else {
								$v["param3"] = substr($v["param3"],1,-1);
							}

							if($auto and isset($_SESSION['template_rulev1_group']) and $_SESSION['template_rulev1_group'] != ''){
								$v["param3"] = $_SESSION['template_rulev1_group'];
							}
							$v['param3'] = str_replace('theme_', '', $v['param3']);
							$tmps = explode(',', $v["param2"]);
							if($tmps and count($tmps) > 0){
								foreach($tmps as $kk => $vv){
									// "images/xxx/xxx.png    => "html/rwd03/images/xxx/xxx.png
									$run = '$this->data[$v["param1"]] = str_get_html(str_replace("\"".$vv."/", "\"html/'.$v["param3"].'/'.$vv.'/", $this->data[$v["param1"]]), true, true, DEFAULT_TARGET_CHARSET, false);';
									eval($run);

									// "../images/xxx/xxx.png => "html/rwd03/images/xxx/xxx.png
									$run = '$this->data[$v["param1"]] = str_get_html(str_replace("\"../".$vv."/", "\"html/'.$v["param3"].'/'.$vv.'/", $this->data[$v["param1"]]), true, true, DEFAULT_TARGET_CHARSET, false);';
									eval($run);
								}
							}

						} elseif(isset($v['type']) and $v['type'] == 'renderPartial'){
							$this->data[$v['param1']] = $this->renderPartial($v['param2'], $this->data, true);

						} elseif(isset($v['type']) and $v['type'] == 'autogenerate'){

							/*
							 * 跟value或是content有關的屬性，要擺放在第一順位(例如value, innertext等)
							 */
							//$dom_tags = array(
							//	'a' => array(
							//		'innertext', 'href', 'title',
							//	),
							//	'div' => array(
							//		'innertext',
							//	),
							//	'span' => array(
							//		'innertext',
							//	),
							//	'img' => array(
							//		'src', 'title',
							//	),
							//	'p' => array(
							//		'innertext',
							//	),
							//);

							/*
							 * 處理多國語系片語
							 * 不管有沒有產生實體檔案，都跟多國語系片語"無關"
							 */
							//foreach($this->data[$v['param1']]->find('*[rulev1=ml]') as $kk => $element){ // 規則也可以下成 *[rulev1] 
							//	$attrs = array();
							//	if(isset($dom_tags[$element->tag]) and count($dom_tags[$element->tag]) > 0){
							//		$attrs = $dom_tags[$element->tag];
							//	} else {
							//		continue;
							//	}
							//	$tmp = array_shift($attrs);
							//	$element->{$tmp} = G::t('', $element->{$tmp}); // 第一個引數是category，在前台的預設是會自動補上web，所以實際會變成ml:[[web]] XXX
							//}

							/*
							 * 如果未產生規則的實體檔案，這裡會重新產生
							 */

							$filename_path = Yii::getPathOfAlias('application').'/controllers/'.$this->data['sys_configs']['template_rulev1_group'].'-'.str_replace('/','-',$class_method).'.php';
							if(file_exists($filename_path)){
								// 移除那些自定義的屬性，這裡不用做，不然自動規則會失效，要放在最後做才對
								//$run = '$this->data[$v["param1"]] = str_get_html(';
								//	$run .= 'str_replace("rulev1=\"single\"","",';
								//	$run .= 'str_replace("rulev1=\"multi\"","",';
								//	$run .= 'str_replace("rulev1=\"1\"","",';
								//	$run .= 'str_replace("rulev1=\"n\"","",';
								//		$run .= '$this->data[$v["param1"]])))), true, true, DEFAULT_TARGET_CHARSET, false);';
								//eval($run);
								//$run = '$this->data[$v["param1"]] = str_get_html(str_replace("rulev1=\"multi\"", "",$this->data[$v["param1"]]), true, true, DEFAULT_TARGET_CHARSET, false);';
								//eval($run);
							   	continue;
							}

							/*
							 * 開始處理檔案的產生流程
							 */
							$rowsx = array(); // 這個是用來輸出comment的，等一下會洗掉
							$rowsx_array_content = '';
							$rowsx_comment = '';

							$content = file_get_contents(Yii::getPathOfAlias('system').ds('/backend').ds('/controllers/').'Rulev1Controller.php');
							$contents = explode("\n", $content);
							foreach($contents as $kk => $vv){
								if($rowsx_array_content != ''){
									$rowsx_array_content .= $vv;
								}
								if($rowsx_array_content != '' and preg_match('/^\t\t\);/', $vv)){
									break;
								}
								if(preg_match('/^\t\t\$this\-\>data\[\'rule_modules\'\]/', $vv)){
									$rowsx_array_content .= $vv;
								}
							}
							//echo $rowsx_array_content;
							//die;
							eval($rowsx_array_content);
							if($this->data['rule_modules']){
								foreach($this->data['rule_modules'] as $kk => $vv){
									$tmp = array(
										'sort_id' => 5, // 順序才是最重要，所以我改成放最上面
										//'id' => 0,
										'description' => $vv['name'],
										'data_id' => $v['data_id'],
										'type' => $kk,
										'is_enable' => '1', // 預設是開啟，因為它只是註解而以
										//'param1' => str_replace('　','',$vv['param1']),
									);
									for($x=1;$x<=5;$x++){
										if($vv['param'.$x] == '') continue; // 只想表達描述，但是實際上，1~5的param都要補齊
										$tmp['param'.$x] = str_replace('　','',str_replace('<br />', '', $vv['param'.$x]));
									}
									$rowsx[] = $tmp;
								}
							}
							$rowsx_comment = '/*'."\n".'$rowsx = '.var_export($rowsx,true).';'."\n".'*/'."\n";

							// 最剛開始先動態的產生註解

							// 取用頂層的SortID
							$sort_id = $v['sort_id'];

							// 重覆使用陣列變數
							$rowsx = array();

							// 處理單筆的部份
							if(isset($this->data[$v['param1']])){
								foreach($this->data[$v['param1']]->find('*[rulev1=single]') as $kk => $element){ // 規則也可以下成 *[rulev1] 
									$attrs = array();
									if(isset($dom_tags[$element->tag]) and count($dom_tags[$element->tag]) > 0){
										$attrs = $dom_tags[$element->tag];
									} else {
										continue;
									}
									foreach($attrs as $kkk => $vvv){
										$tmp = array(
											'is_enable' => '0',
											'id' => 0,
											'description' => '上一層class:'.$element->parent()->class.', 本層class:'.$element->class.', 本層id:'.$element->id.', 本層innertext:'.$element->innertext,
											'data_id' => $v['data_id'],
											'type' => 'assign',
											'sort_id' => $sort_id,
											'param1' => $v['param1'],
											'param2' => 'find(*[rulev1=single],'.$kk.')->'.$vvv,
											'param3' => $element->{$vvv},
											'param4' => '',
											'param5' => '',
											// 用不到的欄位
											//'rule' => '',
											//'from_user_id' => 0,
											//'create_time' => date('Y-m-d H:i:s'),
											//'update_time' => date('Y-m-d H:i:s'),
										);
										$rowsx[] = $tmp;
									}
								}
							}

							$sort_id++;

							// 多筆的tag屬性，跟單筆的有一點落差
							//$dom_tags = array(
							//	'a' => array(
							//		'outertext',
							//	),
							//	'div' => array(
							//		'innertext',
							//	),
							//);

							// 接下來是處理多筆的部份
							if(isset($this->data[$v['param1']])){
								foreach($this->data[$v['param1']]->find('*[rulev1=multi]') as $kk => $element){
									$element1 = $element->find('*[rulev1=1]',0);

									$description = '上一層class:'.$element->parent()->class.', 本層class:'.$element->class.', 本層id:'.$element->id;

									/*
										'param1' => '變數(目標,回存)',
										'param2' => '資料來源',
										'param3' => '目標的規則',
										'param4' => '單筆的規則',
										'param5' => '回存的規則',
									 */
									//$attrs = array();
									//if(isset($dom_tags[$element->tag]) and count($dom_tags[$element->tag]) > 0){
									//	$attrs = $dom_tags[$element->tag];
									//} else {
									//	continue;
									//}
									$tmp = array(
										'is_enable' => '0',
										'id' => 0,
										'description' => $description,
										'data_id' => $v['data_id'],
										'type' => 'multiple_assign_root',
										'sort_id' => $sort_id,
										'param1' => $v['param1'].','.$v['param1'],
										'param2' => '資料來源',
										'param3' => 'find(*[rulev1=multi],'.$kk.')->innertext', // 預設它是	innertext，有例外的話，在補寫
										'param4' => 'find(*[rulev1=1],0)->outertext',
										'param5' => 'find(*[rulev1=multi],'.$kk.')->innertext',
										// 用不到的欄位
										//'rule' => '',
										//'from_user_id' => 0,
										//'create_time' => date('Y-m-d H:i:s'),
										//'update_time' => date('Y-m-d H:i:s'),
									);
									$rowsx[] = $tmp;
									
									$sort_id++;

									foreach($element1->find('*[rulev1=n]') as $kkk => $elementn){
										$attrs = array();
										if(isset($dom_tags[$elementn->tag]) and count($dom_tags[$elementn->tag]) > 0){
											$attrs = $dom_tags[$elementn->tag];
										} else {
											continue;
										}
										foreach($attrs as $kkkk => $vvvv){
											$tmp = array(
												'is_enable' => '0',
												'id' => 0,
												'description' => '　'.$description,
												'data_id' => $v['data_id'],
												'type' => 'multiple_assign_child',
												'sort_id' => $sort_id,
												'param1' => 'find(*[rulev1=n],'.$kkkk.')->'.$vvvv,
												'param2' => $elementn->{$vvvv},
												'param3' => '',
												'param4' => '',
												'param5' => '',
												// 用不到的欄位
												//'rule' => '',
												//'from_user_id' => 0,
												//'create_time' => date('Y-m-d H:i:s'),
												//'update_time' => date('Y-m-d H:i:s'),
											);
											$rowsx[] = $tmp;
										}
									}
								}
							}

							file_put_contents($filename_path,'<'.'?'.'php'."\n".$rowsx_comment.'$rowsx = '.var_export($rowsx,true).';');

							if(isset($this->data[$v["param1"]])){
								// 移除那些自定義的屬性
								$run = '$this->data[$v["param1"]] = str_get_html(str_replace("rulev1=\"single\"", "",$this->data[$v["param1"]]), true, true, DEFAULT_TARGET_CHARSET, false);';
								eval($run);
								$run = '$this->data[$v["param1"]] = str_get_html(str_replace("rulev1=\"multi\"", "",$this->data[$v["param1"]]), true, true, DEFAULT_TARGET_CHARSET, false);';
								eval($run);
							}

							//foreach($this->data[$v['param1']]->find('*[rulev1]') as $kk => $element){ // 規則也可以下成 *[rulev1] 
							//	//$element->rulev1 = null;
							//	$this->data[$v['param1']]->find('*[rulev1=single]',$kk)->rulev1 = '';
							//}

						} elseif(isset($v['type']) and $v['type'] == 'multiple_assign_root'){

							// 目標,回存變數
							$param1 = $v["param1"];
							$tmp01 = explode(',', $param1);
							$target_var = $tmp01[0];
							$save_var = $tmp01[1];

							// 收集child assign
							$childs = array();
							foreach($rows as $kk => $vv){
								if(str_replace('　', '', $vv['description']) == $v['description'] and $vv['type'] == 'multiple_assign_child'){
									$childs[] = $vv;
								}
							}

							//	多條規則，是用參照、參考的方式，這裡的範例就不寫了
							//	array(
							//		'name' => '多筆assign的範例',
							//		'type' => 'multiple_assign',
							//		'params' => array(
							//			'testg',
							//			'xxx', // data source
							//			'find(h1,0)->innertext', // section
							//			'find(div[class=item],0)->outertext', // single
							//		),
							//	),

							/* 程式範本
							 *
							 * // 先取得部份的section
							 * $tmp = $html->find('div[id=owl-testimonials]',0)->outertext;
							 * $html2 = str_get_html($tmp, true, true, DEFAULT_TARGET_CHARSET, false);

							 * // 取得單筆
							 * $html2_tmp = $html2->find('div[class=item]',0)->outertext;

							 * $rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type',array(':type'=>'optimumcase'))->order('sort_id')->queryAll();
							 * $tmp2 = '';
							 * if($rows){
							 * 	foreach($rows as $k => $v){
							 * 		$html3 = str_get_html($html2_tmp, true, true, DEFAULT_TARGET_CHARSET, false);
							 * 		$html3->find('h2',0)->innertext = $v['topic'];
							 * 		$html3->find('h3',0)->innertext = $v['other1'];
							 * 		$html3->find('h4',0)->innertext = $v['other2'];
							 * 		$html3->find('p',0)->innertext = $v['detail'];
							 * 		$tmp2 .= $html3;
							 * 	}
							 * }
							 * $html->find('div[id=owl-testimonials]',0)->innertext = $tmp2;
							 */

							$rule1 = $v['param3'];
							eval(str_replace('xxx', '$rule1', $field_handle_find));

							$rule2 = $v['param4'];
							eval(str_replace('xxx', '$rule2', $field_handle_find));

							$rule3 = $v['param5'];
							eval(str_replace('xxx', '$rule3', $field_handle_find));

							$run = 'if(!$this->data[$target_var]->'.$rule1.') continue;';
							eval($run);	

							// 先取得部份的section
							$run = '$tmp = $this->data[$target_var]->'.$rule1.';';
							eval($run);	
							$html2 = str_get_html($tmp, true, true, DEFAULT_TARGET_CHARSET, false);

							// 取得單筆
							$run = '$html2_tmp = $html2->'.$rule2.';';
							eval($run);

							// 用description來當檔名，來看一下外掛的程式有沒有存在
							$plugin_file = Yii::getPathOfAlias('application').ds('/controllers/'.$this->data['sys_configs']['template_rulev1_group'].'/').$v['description'].'.php';
							if(!file_exists($plugin_file)){
								$plugin_file = '';
							}

							if(preg_match('/^SESSION:/', $v['param2'])){
								$var = str_replace('SESSION:', '', $v['param2']);
								if(isset($_SESSION[$var])){
									$rowsg = $_SESSION[$var];
								} else {
									$rowsg = array();
								}
							} else {
								$rowsg = $this->data[$v['param2']];
							}
							$tmp2 = '';
							if($rowsg){
								foreach($rowsg as $kk => $vv){
									$html3 = str_get_html($html2_tmp, true, true, DEFAULT_TARGET_CHARSET, false);
									//$html3->find('h2',0)->innertext = $v['topic'];
									//$html3->find('h3',0)->innertext = $v['other1'];
									//$html3->find('h4',0)->innertext = $v['other2'];
									//$html3->find('p',0)->innertext = $v['detail'];

									// 外掛程式
									if($plugin_file != ''){
										include $plugin_file;
									}

									if($childs){
										foreach($childs as $kkk => $vvv){
											$rule1a = $vvv['param1'];
											eval(str_replace('xxx', '$rule1a', $field_handle_find));

											eval(str_replace('xxx', '$vvv["param2"]', $field_handle_value));

											$run = '$html3->'.$rule1a.' = ';
											$run .= $vvv['param2'].';';
											eval($run);
											
										}
									}
									$tmp2 .= $html3;
								}
							}
							// 回存
							//$html->find('div[id=owl-testimonials]',0)->innertext = $tmp2;
							$run = '$this->data[$save_var]->'.$rule3.' = $tmp2;';
							eval($run);

							// 試著加上前台即時編輯的功能
							//if(isset($_SESSION['authw_admin_id']) and $_SESSION['authw_admin_id'] == 1 and 0){ // preg_match('/1/', $_SESSION['auth_admin_type'])){
							if(isset($_SESSION['template_rulev1_group_edit']) and $_SESSION['template_rulev1_group_edit']){
								$rule = $rule1;
								$tmps = explode('->', $rule);
								unset($tmps[count($tmps)-1]);
								$rulex = implode('->', $tmps); // 只是把最後的屬性給拿掉，例如"->innertext"
								$group = $this->data['sys_configs']['template_rulev1_group'];
								if(isset($v['table'])){
									$group = $v['table'];
								}
								$onlyid = $group.$v['id'];

								$description = $v['description'];
								$url = '_i/backend.php?r='.str_replace('_','',$group).'/update&param=v'.$v['data_id'].'-a'.base64url::encode($_SERVER['REQUEST_URI']).'#toolgtip_'.$onlyid.'_target';

								$run_value = <<<XXX
<span class="tooltip tooltip-effect-5" id="toolgtip_$onlyid" onclick=\'window.location.href="$url";\'>
	<span class="tooltip-item">$description</span>
	<span class="tooltip-content clearfix">
	<span class="tooltip-text">123</span>
	</span>
</span>
<script type="text/javascript">
$(document).ready(function(){
	$(".tooltip").hover(
		function(){
			$("."+$(this).attr("id")+"_target").addClass("tooltip_focus");
		},
		function(){
			$("."+$(this).attr("id")+"_target").removeClass("tooltip_focus");
		}
	);
});
</script>
XXX;
								//$run = '$this->data[$v["param1"]]->'.$rulex.'->outertext .= "<span class=\"tooltip tooltip-effect-5\" onclick=\'window.location.href=\"_i/backend.php?r=rulev1assign/index&a='.$group.'&id='.$v['id'].'&prev='.base64url::encode($_SERVER['REQUEST_URI']).'\"\'><span class=\"tooltip-item\">'.$v['description'].'</span><span class=\"tooltip-content clearfix\"><span class=\"tooltip-text\">123</span></span></span>";';

								// 在規則的目標，增加一個class，方便我附加class上去
								$run = '$this->data[$target_var]->'.$rulex.'->class .= " toolgtip_'.$onlyid.'_target";';
								eval($run);

								$run = '$this->data[$save_var]->'.$rulex.'->outertext .= \''.$run_value.'\';';
								//echo $run;
								eval($run);

							}

						} elseif(isset($v['type']) and $v['type'] == 'kcfinder_get_files'){
							eval(str_replace('xxx', '$v["param1"]', $field_handle_value));
							eval('$v["param1"] = '.$v['param1'].';');
							// _BASEPATH => /var/www/html/rwd03/_i
							$tmp01 = _BASEPATH."/assets/members/".$v["param1"]."/member";
							$files = CFileHelper::findFiles($tmp01);
							sort($files);
							if($files){
								foreach($files as $kk => $vv){
									//$file = str_replace($tmp01.'/','', $vv);
									$file = str_replace(_BASEPATH,'_i', $vv);
									$this->data[$v['param2']][] = $file;
								}
							}
							//var_dump($this->data[$v['param2']]);

						} elseif(isset($v['type']) and $v['type'] == 'yii_query_builder'){
							// 參考 $row = $this->db->createCommand()->from('html')->where('is_enable=1')->queryRow();
							$data_var = $v["param1"];
							unset($v['param1']);
							$tmp01 = array();
							foreach($v as $kk => $vv){
								if(preg_match('/^param/', $kk) and $vv != ''){
									$tmp01[] = $vv;
								}
							}
							$run = '$this->data[$data_var] = $this->db->createCommand()->'.implode('->', $tmp01).';';
							eval($run);

							// 用description來當檔名，來看一下外掛的程式有沒有存在
							$plugin_file = Yii::getPathOfAlias('application').ds('/controllers/'.$this->data['sys_configs']['template_rulev1_group'].'/').$v['description'].'.php';
							if(!file_exists($plugin_file)){
								$plugin_file = '';
							}

							// 外掛程式
							if($plugin_file != ''){
								include $plugin_file;
							}

						} elseif(isset($v['type']) and $v['type'] == 'yii_query_builder_for_html_table_with_ml_key'){
							// 因為等一下會unset元素，我先存下來，後面的plugin有可能會用到
							$v_old = $v; 

							// 參考 $row = $this->db->createCommand()->from('html')->where('is_enable=1')->queryRow();
							$data_var = $v["param1"];
							unset($v['param1']);

							$data_type = $v["param2"];
							unset($v['param2']);

							$tmp01 = array();
							foreach($v as $kk => $vv){
								if(preg_match('/^param/', $kk) and $vv != ''){
									$tmp01[] = $vv;
								}
							}
							$run = '$this->data[$data_var] = $this->db->createCommand()->';
							$run .= 'from(\'html\')';
							$run .= '->where(\'type="'.$data_type.'" and is_enable=1 and ml_key="'.$this->data['ml_key'].'" \')->';
							$run .= implode('->', $tmp01).';';
							eval($run);

							// 用description來當檔名，來看一下外掛的程式有沒有存在
							$plugin_file = Yii::getPathOfAlias('application').ds('/controllers/'.$this->data['sys_configs']['template_rulev1_group'].'/').$v['description'].'.php';
							if(!file_exists($plugin_file)){
								$plugin_file = '';
							}

							// 外掛程式
							if($plugin_file != ''){
								include $plugin_file;
							}
						} elseif(isset($v['type']) and $v['type'] == 'ci_active_record'){
							// 範本 $rows = $this->cidb->where('is_enable', 1)->like('interface', ',2,', 'both')->get('ml')->result_array();
							$data_var = $v["param1"];
							unset($v['param1']);
							$tmp01 = array();
							foreach($v as $kk => $vv){
								if(preg_match('/^param/', $kk) and $vv != ''){
									$tmp01[] = $vv;
								}
							}
							$run = '$this->data[$data_var] = $this->cidb->'.implode('->', $tmp01).';';
							eval($run);

						} elseif(isset($v['type']) and $v['type'] == 'echo'){
							if(isset($_GET['ruletest']) and $_GET['ruletest'] != ''){
								$ruletest = $_GET['ruletest'].'->';
								eval(str_replace('xxx', '$ruletest', $field_handle_find));
								$run = '$this->data[$v["param1"]]->'.$ruletest.'style = "border:2px solid red";';
								eval($run);
							}

							// 就代表可能要做layout和section的合併
							if(!isset($this->data[$v['param1']]) and isset($this->data['layoutmain'])){
								for($x=1;$x<=10;$x++){
									if(isset($this->data['layoutsection'.$x])){
										$this->data['layoutmain']->find('*[rulev1=layoutsection'.$x.']',0)->outertext = $this->data['layoutsection'.$x];
									}
								}
								$this->data[$v["param1"]] = str_get_html($this->data['layoutmain']->save(), true, true, DEFAULT_TARGET_CHARSET, false);
								unset($this->data['layoutmain']);
							}

							foreach($this->data[$v['param1']]->find('*[rulev1=ml]') as $kk => $element){ // 規則也可以下成 *[rulev1] 
								$attrs = array();
								if(isset($dom_tags[$element->tag]) and count($dom_tags[$element->tag]) > 0){
									$attrs = $dom_tags[$element->tag];
								} else {
									continue;
								}
								$tmp = array_shift($attrs);
								$element->{$tmp} = G::t('', $element->{$tmp}); // 第一個引數是category，在前台的預設是會自動補上web，所以實際會變成ml:[[web]] XXX
							}

if(!isset($this->data['BEGIN_HTML'])){
	$this->data['BEGIN_HTML'] = '';
}
$this->data['BEGIN_HTML'] .= 
'<script type="text/javascript">
	var ml_key = "tw";
</script>
<script language="JavaScript" type="text/javascript" src="/_i/assets/language.js"></script>';

							// 補上JS區段
							if(isset($this->data['POS_READY'])){
								$this->data[$v['param1']]->find('*[rulev1=POS_READY]',0)->outertext = 
'<script type="text/javascript">
$( document ).ready(function() {'.
$this->data['POS_READY'].
'});
</script>';
							}

							if(!isset($this->data['POS_HTML'])){
								$this->data['POS_HTML'] = '';
							}
							$this->data['POS_HTML'] .= $this->renderPartial('//site/_google_analytics', $this->data, true);

							if(isset($this->data['POS_HTML'])){
								$this->data[$v['param1']]->find('*[rulev1=POS_HTML]',0)->outertext = $this->data['POS_HTML'];
							}

							if(isset($this->data['BEGIN_HTML'])){
								$this->data[$v['param1']]->find('*[rulev1=BEGIN_HTML]',0)->outertext = $this->data['BEGIN_HTML'];
							}

							// 移除剩下的自訂標籤
							foreach($this->data[$v['param1']]->find('*[rulev1]') as $kk => $element){ // 規則也可以下成 *[rulev1] 
								if(preg_match('/^layoutsection/', $element->rulev1)){
									$this->data[$v['param1']]->find('*[rulev1='.$element->rulev1.']',0)->outertext = '';
								} else {
									//$this->data[$v['param1']]->find('*[rulev1]',$kk)->rulev1 = null;
									$this->data[$v['param1']]->find('*[rulev1='.$element->rulev1.']',0)->rulev1 = null;
								}
								//$element->rulev1 = null;
								//$this->data[$v['param1']]->find('*[rulev1=single]',$kk)->rulev1 = '';
							}

							echo $this->data[$v['param1']];
							die;
						}
					}
				}
			}
		}
