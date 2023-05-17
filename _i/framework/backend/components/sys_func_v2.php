<?php

/*
 * 後台產生器
 */
// if(Yii::app()->db->schema->getTable('sys_func_v2')){
if($this->cidb->table_exists('sys_func_v2')){
	$row = $this->db->createCommand()->from('sys_func_v2')->where('is_enable=1 and (func=:func OR concat(\',\',func_other,\',\') LIKE \'%,'.$this->data['router_class'].',%\')', array(':func'=>$this->data['router_class']))->queryRow();
	if($row and isset($row['id'])){

		// 先收集，然後最後在覆寫欄位的設定
		$empty_orm_rules = array();

		$rows_attr = $this->db->createCommand()->from('sys_func_v2_list1_attr')->where('is_enable=1')->queryAll();
		$rows_attr_tmp = array();
		if($rows_attr and count($rows_attr) > 0){
			foreach($rows_attr as $k => $v){
				if(!isset($rows_attr_tmp[$v['data_id']])){
					$rows_attr_tmp[$v['data_id']] = array();
				}
				$rows_attr_tmp[$v['data_id']][] = $v;
			}
		}

		// 列表頁面的欄位
		$rows = $this->db->createCommand()->from('sys_func_v2_list1')->where('is_enable=1 and data_id=:id', array(':id'=>$row['id']))->order('sort_id')->queryAll();
		if($rows and count($rows) > 0){
			$tmp = array();
			foreach($rows as $k => $v){
				$tmp[$v['keyname']] = array(
					'label' => $v['name'],
					'width' => '10%',
				);
				if(isset($rows_attr_tmp[$v['id']]) and count($rows_attr_tmp[$v['id']]) > 0){
					foreach($rows_attr_tmp[$v['id']] as $kk => $vv){
						$tmp[$v['keyname']][$vv['keyname']] = $vv['keyvalue'];
					}
				}
			}
			$this->def['listfield'] = $tmp;
		}

		$sections = array();
		
		// 進階搜尋的欄位
		$rows_attr = $this->db->createCommand()->from('sys_func_v2_search1_attr')->where('is_enable=1')->queryAll();
		$rows_attr_tmp = array();
		if($rows_attr and count($rows_attr) > 0){
			foreach($rows_attr as $k => $v){
				if(!isset($rows_attr_tmp[$v['data_id']])){
					$rows_attr_tmp[$v['data_id']] = array();
				}
				$rows_attr_tmp[$v['data_id']][] = $v;
			}
		}

		$rows_other = $this->db->createCommand()->from('sys_func_v2_search1_other')->where('is_enable=1')->queryAll();
		$rows_other_tmp = array();
		if($rows_other and count($rows_other) > 0){
			foreach($rows_other as $k => $v){
				if(!isset($rows_other_tmp[$v['data_id']])){
					$rows_other_tmp[$v['data_id']] = array();
				}
				$rows_other_tmp[$v['data_id']][] = $v;
			}
		}

		$rows = $this->db->createCommand()->from('sys_func_v2_search1')->where('is_enable=1 and data_id=:id', array(':id'=>$row['id']))->order('sort_id')->queryAll();
		if($rows and count($rows) > 0){
			$tmp = array(
				'form' => array('enable' => false),
				'type' => '1',
				'field' => array(
				),
			);
			foreach($rows as $kk => $vv){
				$tmp['field'][$vv['keyname']] = array(
					'label' => $vv['name'],
					'type' => $vv['type'],
					'attr' => array(
						'id' => $vv['keyname'],
						'name' => $vv['keyname'],
					),
				);
				if(isset($rows_attr_tmp[$vv['id']]) and count($rows_attr_tmp[$vv['id']]) > 0){
					foreach($rows_attr_tmp[$vv['id']] as $kkk => $vvv){
						$tmp['field'][$vv['keyname']]['attr'][$vvv['keyname']] = $vvv['keyvalue'];
					}
				}
				//if(isset($rows_other_tmp[$vv['id']]) and count($rows_other_tmp[$vv['id']]) > 0){
				//	foreach($rows_other_tmp[$vv['id']] as $kkk => $vvv){
				//		$tmp['field'][$vv['keyname']]['other'][$vvv['keyname']] = $vvv['keyvalue'];
				//	}
				//}
				if(isset($rows_other_tmp[$vv['id']]) and count($rows_other_tmp[$vv['id']]) > 0){
					foreach($rows_other_tmp[$vv['id']] as $kkk => $vvv){
						if($vvv['keyname'] == 'merge'){
							$tmp['field'][$vv['keyname']]['merge'] = $vvv['keyvalue'];
						} elseif($vvv['keyname'] == 'emptyorm_rules'){
							$empty_orm_rules[$vv['keyname'].'__'.$vvv['keyvalue']] = '1';
						} else {
							if(preg_match('/^PHP:(.*)$/', $vvv['keyvalue'], $matches)){
								$cmd = '$ggg='.$matches[1].';';
								eval($cmd);
								if(isset($ggg)){
									$tmp['field'][$vv['keyname']]['other'][$vvv['keyname']] = $ggg;
									//var_dump($tmp['field'][$vv['keyname']]['other'][$vvv['keyname']]);
									//die;
								}
							} else {
								$tmp['field'][$vv['keyname']]['other'][$vvv['keyname']] = $vvv['keyvalue'];
							}
						}
					}
				}
			}
		}
		

		$this->def['searchfield']['sections'][] = $tmp;

		$sections = array();
		
		// 修改頁面的欄位
		$rows_attr = $this->db->createCommand()->from('sys_func_v2_update_attr')->where('is_enable=1')->queryAll();
		$rows_attr_tmp = array();
		if($rows_attr and count($rows_attr) > 0){
			foreach($rows_attr as $k => $v){
				if(!isset($rows_attr_tmp[$v['data_id']])){
					$rows_attr_tmp[$v['data_id']] = array();
				}
				$rows_attr_tmp[$v['data_id']][] = $v;
			}
		}

		$rows_other = $this->db->createCommand()->from('sys_func_v2_update_other')->where('is_enable=1')->queryAll();
		$rows_other_tmp = array();
		if($rows_other and count($rows_other) > 0){
			foreach($rows_other as $k => $v){
				if(!isset($rows_other_tmp[$v['data_id']])){
					$rows_other_tmp[$v['data_id']] = array();
				}
				$rows_other_tmp[$v['data_id']][] = $v;
			}
		}

		$rows = $this->db->createCommand()->from('sys_func_v2_update')->where('is_enable=1 and data_id=:id', array(':id'=>$row['id']))->order('sort_id')->queryAll();
		if($rows and count($rows) > 0){
			$rows2 = array();
			foreach($rows as $k => $v){
				if($v['update_section'] <= 0) continue;
				if(!isset($rows2[$v['update_section']])){
					$rows2[$v['update_section']] = array();
				}
				$rows2[$v['update_section']][] = $v;
			}
			ksort($rows2);
			if(count($rows2) > 0){
				// @k section_number
				foreach($rows2 as $k => $v){
					$tmp = array(
						'form' => array('enable' => false),
						'type' => '1',
						'field' => array(
						),
					);
					foreach($v as $kk => $vv){
						// 預先設定，依據基本欄位
						$tmp['field'][$vv['keyname']] = array(
							'label' => $vv['name'],
							'type' => $vv['type'],
							'attr' => array(
								'id' => $vv['keyname'],
								'name' => $vv['keyname'],
							),
						);
						// 覆寫
						if(isset($rows_attr_tmp[$vv['id']]) and count($rows_attr_tmp[$vv['id']]) > 0){
							foreach($rows_attr_tmp[$vv['id']] as $kkk => $vvv){
								$tmp['field'][$vv['keyname']]['attr'][$vvv['keyname']] = $vvv['keyvalue'];
							}
						}
						if(isset($rows_other_tmp[$vv['id']]) and count($rows_other_tmp[$vv['id']]) > 0){
							foreach($rows_other_tmp[$vv['id']] as $kkk => $vvv){
								if($vvv['keyname'] == 'merge'){
									$tmp['field'][$vv['keyname']]['merge'] = $vvv['keyvalue'];
								} elseif($vvv['keyname'] == 'emptyorm_rules'){
									$empty_orm_rules[$vv['keyname'].'__'.$vvv['keyvalue']] = '1';
								} else {
									if(preg_match('/^PHP:(.*)$/', $vvv['keyvalue'], $matches)){
										$cmd = '$ggg='.$matches[1].';';
										eval($cmd);
										if(isset($ggg)){
											$tmp['field'][$vv['keyname']]['other'][$vvv['keyname']] = $ggg;
											//var_dump($tmp['field'][$vv['keyname']]['other'][$vvv['keyname']]);
											//die;
										}
									} else {
										$tmp['field'][$vv['keyname']]['other'][$vvv['keyname']] = $vvv['keyvalue'];
									}
								}
							}
						}
					}
					$sections[] = $tmp;
				}
			}
		}
		
		$this->def['updatefield']['sections'] = $sections;

		if(count($empty_orm_rules) > 0){
			foreach($empty_orm_rules as $k => $v){
				$tmp = explode('__', $k);
				if(count($tmp) != 2) continue;
				$keyname = $tmp[0];
				$keyvalue = $tmp[1];
				if($keyname == '' or $keyvalue == '') continue;
				if(!isset($this->def['empty_orm_data'])){
					$this->def['empty_orm_data'] = array();
				}
				if(!isset($this->def['empty_orm_data']['rules'])){
					$this->def['empty_orm_data']['rules'] = array();
				}
				$this->def['empty_orm_data']['rules'][] = array($keyname, $keyvalue);
			}
		}
	} // row
} // 檢查後台產生器的資料表是否存在
