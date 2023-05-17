<?php

/*
 * @is_type bool 是否為分類
 */

if(isset($copy_is_type)){

	$save_type = array();

	foreach($copy_rows as $k => $v){

		// 濾掉分類
		// if($copy_is_type === true or preg_match('/type$/', $v['topic'])){
		// 	continue;
		// }

		// 不管是分類，還是分項，都可能會有參照
		$refs = array();
		//$map2 = array();
		if(trim($v['detail']) != ''){
			$tmps = explode("\n", $v['detail']);

			// 防呆
			if($tmps and !empty($tmps)){
				foreach($tmps as $kk => $vv){
					if(trim($vv) == ''){
						unset($tmps[$kk]);
					}
				}
			}

			if($tmps and !empty($tmps)){
				// @vv 1,class_id,newstype
				foreach($tmps as $kk => $vv){
					$tmps2 = explode(',', $vv);
					if(count($tmps2) != 3){
						continue;
					}

					// 單選1，複選2
					if($tmps2[0] == ''){
						continue;
					}

					// Table欄位名稱
					if($tmps2[1] == ''){
						continue;
					}

					// 資料流
					if($tmps2[2] == ''){
						$tmps2[2] = $v['topic'].'type';
					}

					if(!isset($refs[$tmps2[0]])){
						$refs[$tmps2[0]] = array();
					}
					$refs[trim($tmps2[0])][] = array(
						'field' => trim($tmps2[1]),
						'datasource' => trim($tmps2[2]), // trim的這個動作很重要
					);

				}
			}
		}

		// 'label' => '通用(0) / 獨立(1) / 單頁(2)',
		if($v['sort_id_home'] == 0){

			$this->cidb->delete('html', array('ml_key'=>$session['dest'],'type'=>$v['topic'])); 

			// 通用資料表
			$rows2 = $this->cidb->select('*, id as old_id')->where('type',$v['topic'])->where('ml_key',$session['source'])->get('html')->result_array();
			if($rows2){
				foreach($rows2 as $kk => $vv){
					unset($vv['id']); // 因為己經另存到old_id
					$vv['ml_key'] = $session['dest'];

					if($refs and !empty($refs)){
						// @kkk 單選1, 複選2
						foreach($refs as $kkk => $vvv){
							foreach($vvv as $kkkk => $vvvv){
								if($kkk == 1){
									if(isset($vv[$vvvv['field']]) and $vv[$vvvv['field']] != 0){
										// 找找看，資料流是通用還是獨立，從通用那邊開始找
										if(isset($map['html'][$vv[$vvvv['field']]])){
											$vv[$vvvv['field']] = $map['html'][$vv[$vvvv['field']]];
										} elseif(isset($map[$vvvv['datasource']][$vv[$vvvv['field']]])){
											$vv[$vvvv['field']] = $map[$vvvv['datasource']][$vv[$vvvv['field']]];
										}
									}
								} elseif($kkk == 2){
									if(isset($vv[$vvvv['field']]) and $vv[$vvvv['field']] != ''){
										$tmpsa = explode(',', $vv[$vvvv['field']]);
										$tmpsb = array();
										$has_dot_start_end = false; // 因為ids欄位，有分那個有逗號開頭結尾的，和沒有的
										if($tmpsa and !empty($tmpsa)){
											foreach($tmpsa as $kkkkk => $vvvvv){
												if($kkkkk == 0 and $vvvvv == ''){
													$has_dot_start_end = true;
												}
												if($vvvvv != '' and $vvvvv > 0){
													if(isset($map['html'][$vvvvv])){
														$tmpsb[] = $map['html'][$vvvvv];
													} elseif(isset($map[$vvvv['datasource']][$vvvvv])){
														$tmpsb[] = $map[$vvvv['datasource']][$vvvvv];
													}
												}
											}
										}
										if(!empty($tmpsb)){
											if($has_dot_start_end === true){
												$vv[$vvvv['field']] = ','.implode(',', $tmpsb).',';
											} else {
												$vv[$vvvv['field']] = implode(',', $tmpsb);
											}
										}
									}
								}
							}
						}
					}
					$rows2[$kk] = $vv;
				}

				if($copy_is_type === true){
					foreach($rows2 as $kk => $vv){
						if(!isset($save_type['html'])){
							$save_type['html'] = array();
						}
						$save_type['html'][] = $vv;
					}
				} else {
					foreach($rows2 as $kk => $vv){
						// 寫在這裡，為了支援other1的那個欄位
						$old_id = $vv['old_id'];
						unset($vv['old_id']);
						$this->cidb->insert('html', $vv); 
						$id = $this->cidb->insert_id();

						$map['html'][$old_id] = $id;
						$html_map[$old_id] = $v['topic'];
						$html_map[$id] = $v['topic']; // 新編號是預留

					}
				}
			}
		} elseif($v['sort_id_home'] == 1){

			$this->cidb->delete($v['topic'], array('ml_key'=>$session['dest'])); 

			// 獨立資料表
			$rows2 = $this->cidb->select('*, id as old_id')->where('ml_key',$session['source'])->get($v['topic'])->result_array();
			if($rows2){
				foreach($rows2 as $kk => $vv){
					unset($vv['id']); // 因為己經另存到old_id
					$vv['ml_key'] = $session['dest'];

					if($refs and !empty($refs)){
						// @kkk 單選1, 複選2
						foreach($refs as $kkk => $vvv){
							foreach($vvv as $kkkk => $vvvv){
								if($kkk == 1){
									if(isset($vv[$vvvv['field']]) and $vv[$vvvv['field']] != 0){
										// 找找看，資料流是通用還是獨立，從通用那邊開始找
										if(isset($map['html'][$vv[$vvvv['field']]])){
											$vv[$vvvv['field']] = $map['html'][$vv[$vvvv['field']]];
										} elseif(isset($map[$vvvv['datasource']][$vv[$vvvv['field']]])){
											$vv[$vvvv['field']] = $map[$vvvv['datasource']][$vv[$vvvv['field']]];
										}
									}
								} elseif($kkk == 2){
									if(isset($vv[$vvvv['field']]) and $vv[$vvvv['field']] != ''){
										$tmpsa = explode(',', $vv[$vvvv['field']]);
										$tmpsb = array();
										$has_dot_start_end = false;
										if($tmpsa and !empty($tmpsa)){
											foreach($tmpsa as $kkkkk => $vvvvv){
												if($kkkkk == 0 and $vvvvv == ''){
													$has_dot_start_end = true;
												}
												if($vvvvv != '' and $vvvvv > 0){
													if(isset($map['html'][$vvvvv])){
														$tmpsb[] = $map['html'][$vvvvv];
													} elseif(isset($map[$vvvv['datasource']][$vvvvv])){
														$tmpsb[] = $map[$vvvv['datasource']][$vvvvv];
													}
												}
											}
										}
										if(!empty($tmpsb)){
											if($has_dot_start_end === true){
												$vv[$vvvv['field']] = ','.implode(',', $tmpsb).',';
											} else {
												$vv[$vvvv['field']] = implode(',', $tmpsb);
											}
										}
									}
								}
							}
						}
					}

					$rows2[$kk] = $vv;
				}

				if($copy_is_type === true){
					foreach($rows2 as $kk => $vv){
						if(!isset($save_type[$v['topic']])){
							$save_type[$v['topic']] = array();
						}
						$save_type[$v['topic']][] = $vv;
					}
				} else {
					foreach($rows2 as $kk => $vv){
						// 寫在這裡，為了支援other1的那個欄位
						$old_id = $vv['old_id'];
						unset($vv['old_id']);
						$this->cidb->insert($v['topic'], $vv); 
						$id = $this->cidb->insert_id();
						$map[$v['topic']][$old_id] = $id;
					}
				}
			}
		} elseif($v['sort_id_home'] == 2 and $copy_is_type === false){

			$this->cidb->delete('sys_config', array('keyname'=>$v['topic'].'_'.$session['dest'])); 
			$row2 = $this->cidb->where('keyname',$v['topic'].'_'.$session['source'])->get('sys_config')->row_array();
			if($row2 and isset($row2['keyname'])){
				$this->cidb->insert('sys_config', array('keyname'=>$v['topic'].'_'.$session['dest'],'keyval'=>$row2['keyval'])); 
				// $id = $this->cidb->insert_id();
			}

		}
	}

	// 寫入並更新$map -1
	if($copy_is_type === true and !empty($save_type)){
		// @k {XXX}type
		foreach($save_type as $k => $v){
			foreach($v as $kk => $vv){
				$old_id = $vv['old_id'];
				unset($vv['old_id']);
				// echo $k;
				$this->cidb->insert($k, $vv); 
				$id = $this->cidb->insert_id();
				$map[$k][$old_id] = $id;

				if($k == 'html'){
					$html_map[$old_id] = $vv['type'];
					$html_map[$id] = $vv['type']; // 新編號是預留
				}
			}
		}

		// 無限層的部份，要分兩次做，這裡是第二次
		foreach($save_type as $k => $v){
			foreach($v as $kk => $vv){
				if($k != 'html' and $vv['pid'] > 0 and isset($map[$k][$vv['pid']])){ // 無限層
					// $this->cidb->where('id', $vv['id']);
					$this->cidb->where('id', $map[$k][$vv['old_id']]);
					$this->cidb->update($k, array('pid'=>$map[$k][$vv['pid']])); 
				}
			}
		}
	}

	unset($save_type);
	unset($copy_rows);
	unset($copy_is_type);
}
