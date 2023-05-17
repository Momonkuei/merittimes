<?php

class Ml2
{
	function __construct()
	{
		//$CI =& get_instance();
		//$this->db = $CI->db;
		//$this->ci = $CI;
		$this->db = Yii::app()->db;
		$this->session = Yii::app()->session;
	}

	// 讓所有的雲端網站的片語，都依照這個網站的該片語做更新
	// 不存在的，就建立，存在的，就修改該語系的內容
	public function related_label($label_name)
	{
		// 取得片語值
		$query = $this->db->where('label_key', $label_name)->get('ml_lang');
		$labels = array();
		foreach($query->result_array() as $row){
			$labels[$row['ml_key']] = $row['value'];
		}

		// 取得資料庫列表
		$this->ci->load->dbutil();
		$dbs = $this->ci->dbutil->list_databases();
		foreach ($dbs as $db){
			// 當然是不處理自己的
			if($db == aaa_dbname){
				continue;
			}
			// debug區段
			//if($db != 'sjv3cloudweb_linklabel'){
			//	continue;
			//}
			if(preg_match('/^sjv3cloudweb_/', $db)){
				$dsn = 'mysqli://'.aaa_dbuser.':'.aaa_dbpass.'@'.aaa_dbhost.'/'.$db;
				$dbn = $this->ci->load->database($dsn, true);

				if(count($labels) > 0){
					foreach($labels as $k => $v){
						// 看一下他的片語值是否有存在
						$conditions = array(
							'ml_key' => $k,
							'label_key' => $label_name,
						);
						$query = $dbn->where($conditions)->get('ml_lang');
						if($query->num_rows() > 0){
							$update = array(
								'value' => $v,
								'update_time' => date('Y-m-d H:i:s'),
							);
							$dbn->where($conditions);
							$dbn->update('ml_lang', $update);
						} else {
							$conditions = array(
								'key' => $label_name,
							);
							$query = $dbn->where($conditions)->get('ml_label');
							// 不存在就新增
							$save = array(
								'label_key' => $label_name,
								'create_time' => date('Y-m-d H:i:s'),
							);
							if($query->num_rows() > 0){
								$dbn->insert('ml_label', $save);
							}
							$save['ml_key'] = $k;
							$save['value'] = $v;
							$dbn->insert('ml_lang', $save);
						}
					} // foreach

					// 叫該網站當有人觸發讀取的時候，自動做一次的重新export片語
					$conditions = array(
						'key' => '_need_label_export',
					);
					$query = $dbn->where($conditions)->get('sys_config');
					if($query->num_rows() > 0){
						$update = array(
							'value' => '1',
							'update_time' => date('Y-m-d H:i:s'),
						);
						$dbn->where($conditions);
						$dbn->update('ml_lang', $update);
					} else {
						// 不存在就新增
						$save = array();
						$save['key'] = '_need_label_export';
						$save['value'] = '1';
						$dbn->insert('sys_config', $save);
					}
				}

				$dbn->close();
			}
		}
	}

	/*
	 * ,
	 * tw,key,en,cn,ru
	 * 阿富汗,[[sehoepaper]] AFG-AFGHANISTAN,,,
	 * 阿爾巴尼亞,[[sehoepaper]] ALB-ALBANIA,,,
	 */
	public function export_txt()
	{
		$splitchar = '|||';
		$return = $splitchar."\n";

		//$query = $this->db->where('is_enable', '1')->get('ml');
		//$mls = array();
		//foreach($query->result_array() as $row){
		//	$mls[] = $row['key'];
		//}
		$mls_tmp = $this->db->createCommand()->from('ml')->where('is_enable=1')->queryAll();
		foreach($mls_tmp as $row){
			$mls[] = $row['key'];
		}

		$return .= 'key'.$splitchar.implode($splitchar, $mls)."\n";

		// 取得所有片語
		//$query = $this->db->get('ml_label');
		//$labels = $query->result_array();
		$labels = $this->db->createCommand()->from('ml_label')->queryAll();

		// 參考用的片語
		$labels_tmp = array();
		$labels_tmp2 = array();
		if(count($labels) > 0){
			foreach($labels as $k => $v){
				$labels_tmp[] = $v['key'];
				$labels_tmp2[$v['key']] = '1';
			}
		}

		// 取得所有片語值
		//$query = $this->db->get('ml_lang');
		//$labelvalues = $query->result_array();
		$labelvalues = $this->db->createCommand()->from('ml_lang')->queryAll();

		$values = array();
		if(count($labelvalues) > 0){
			foreach($labelvalues as $k => $v){
				if(!isset($labels_tmp2[$v['label_key']])){
					continue;
				}
				$values[$v['label_key']][$v['ml_key']] = $v['value'];
			}
		}

		if(count($values) > 0){
			foreach($values as $k => $v){
				//$tmp = $v;
				//var_dump($tmp);
				//die;
				$tmp1 = array();
				if(count($mls) > 0){
					foreach($mls as $kk => $vv){
						$tmp1[$vv] = $v[$vv];
					}
				}
				$values[$k] = $tmp1;
			}
		}

		//var_dump($values);
		//die;

		if(count($values) > 0){
			foreach($values as $k => $v){
				$return .= $k.$splitchar;
				$tmp = array();
				foreach($v as $kk => $vv){
					$tmp[] = $vv;
				}
				$return .= implode($splitchar, $tmp)."\n";
			}
		}
		//echo nl2br($return);
		//die;

		return $return;
	}

	/*
	 * @keys array 裡面放的是array(key,en,cn,tw, ...)
	 * @keys array 裡面放的是array(hello,Hello,你好,你好, ...)
	 */
	public function import($keys, $values, $split = ',')
	{
		if(count($keys) <= 0 or count($values) <= 0 and !in_array('key', $keys)){
			return false;
		}

		// 如果裡面一個以上的key
		$key_count = 0;
		foreach($keys as $k => $v){
			$keys[$k] = strtolower($v);
			if($v == 'key'){
				$key_count++;
			}
		}
		if($key_count > 1){
			return false;
		}

		// @v 語系別名（key,en,tw...)

		// 對一下位置
		$key_position = 0;
		$ml_positions = array();
		foreach($keys as $k => $v){
			$v = trim($v);
			if($v == 'key'){
				$key_position = $k;
			} else {
				$ml_positions[$k] = $v;
			}
		}
		//var_dump($ml_positions);

		// 取得所有片語，等一下要做比對，不存在的才建
		$query = $this->db->get('ml_label');
		$labels_tmp = array();
		foreach($query->result_array() as $row){
			$labels_tmp[strtolower($row['key'])] = '1';
		}

		// 取得所有語系，等一下要做比對，不存在的才建
		$query = $this->db->where('is_enable', '1')->get('ml');
		$mls_tmp = array();
		foreach($query->result_array() as $row){
			$mls_tmp[$row['key']] = '1';
		}

		/*
		 * 第一次處理，整理一下
		 */

		// 存放處理後的結果
		$result = array();

		// 要寫入label資料表的東西
		$labels = array();
		$label_values = array();

		foreach($values as $k => $v){
			/*
			 * array(5) {
			 *   [0]=>
			 *   string(9) "阿富汗"
			 *   [1]=>
			 *   string(30) "[[sehoepaper]] AFG-AFGHANISTAN"
			 *   [2]=>
			 *   string(0) ""
			 *   [3]=>
			 *   string(0) ""
			 *   [4]=>
			 *   string(1) "
			 * "
			 * }
			 */
			$tmps = explode($split, $v);
			// 存放片語和片語內容，每一個語系的資料
			$tmp = array();
			$is_break = 0;
			$label_name = '';
			foreach($tmps as $kk => $vv){
				if($key_position == $kk){
					// // 不存在的片語才建立
					// if(!isset($labels_tmp[strtolower($vv)])){
					// 	$label_name = $vv;
					// 	$labels[] = $vv;
					// } else {
					// 	// 己存在的不會去做
					// 	unset($values[$k]);
					// 	$is_break = 1;
					// 	break;
					// }
					$label_name = $vv;
					$labels[] = $vv;
				} else {
					//echo $ml_positions[$kk];
					if(isset($ml_positions[$kk])){
						$tmp[$ml_positions[$kk]] = $vv;
					}
				}
			}
			if($is_break == 0 and $label_name != '' and count($tmp) > 0){
				$label_values[$label_name] = $tmp;
			}
		}

		if(count($labels) > 0){
			foreach($labels as $k => $v){
				$u = new Label_orm();
				$u->get_by_key($v);
				if($u->key == ''){
					$u = new Label_orm();
					$u->key = $v;
					if(!$u->save()){
						show_error($u->error->string);
					}
				}
			}
		}

		//$save_values = array();
		if(count($label_values) > 0){
			// @k string 片語名稱
			foreach($label_values as $k => $v){
				//var_dump($v);
				// @kk string 語系
				// @vv string 片語值
				foreach($v as $kk => $vv){
					// 不存在的語系不會處理
					if(!isset($mls_tmp[$kk])){
						continue;
					}
					$query = $this->db->where('ml_key', $kk)->where('label_key', $k)->get('ml_lang', 1);
					if($query->num_rows() > 0){
						// 如果有的話，就修改
						$row = $query->row_array();
						$u = new Lang_orm();
						$u->get_by_id($row['id']);
						//$u->ml_key = $kk;
						//$u->label_key = $k;
						$u->value = $vv;
						if(!$u->save()){
							show_error($u->error->string);
						}
					} else {
						// 沒有的話就新增
						if($v != ''){
							$row = $query->row_array();
							$u = new Lang_orm();
							$u->ml_key = $kk;
							$u->label_key = $k;
							$u->value = $vv;
							if(!$u->save()){
								show_error($u->error->string);
							}
						} // v要有值才會新增
					}
				}
			}
		}

		return true;
	}

	public function export()
	{
		// 重新輸出靜態片語陣列檔案
		//$u = new Lang_orm();
		//$u->get();

		//$listcontent = array();
		//if($u->result_count() > 0){
		//	$listcontent = $u->all_to_array();
		//}

		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "ml_lang"',array(':aaa_dbname' => aaa_dbname))->queryAll();

		if(count($lll) > 0){
			$listcontent = $this->db->createCommand()->from('ml_lang')->queryAll();
		}else{
			$listcontent = array();
		}

		$all_label = array();
		if(count($listcontent) > 0){
			foreach($listcontent as $k => $v){
				$all_label[$v['ml_key']][trim(strtolower($v['label_key']))] = $v['value'];
			}
		}

		// 輸出片語與編號的對應檔
		//$query = $this->db->select('id, key')->get('ml_label');
		//$all_label_tmp = array();
		//foreach($query->result_array() as $row){
		//	$all_label_tmp[trim(strtolower($row['key']))] = $row['id'];
		//}

		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "ml_label"',array(':aaa_dbname' => aaa_dbname))->queryAll();

		if(count($lll) > 0){
			$rows = $this->db->createCommand()->from('ml_label')->queryAll();
			$all_label_tmp = array();
			foreach($rows as $row){
				$all_label_tmp[trim(strtolower($row['key']))] = $row['id'];
			}
		}else{
			$all_label_tmp = array();
		}

$js_script = 'function Language(multilanguage){
	this.ml_key = multilanguage;
	this.get = geta;
}
function geta(label){

	// focus add [[web]] 2017-07-19 fix
	var regex = /^\[\[(.*)\]\] (.*)$/g;
	var match = regex.exec(label.toLowerCase());
	if(match && match[1] != null){
	} else {
		label = \'[[web]] \' + label;
	}

	var aa = labels[this.ml_key][label.toLowerCase()];
	var regex = /^\[\[(.*)\]\] (.*)$/g;
	var match = regex.exec(label.toLowerCase());

	if(aa == undefined){
		if(match && match[1] != null){
			return match[2];
		} else {
			return label;
		}
	} else {
		return aa;
	}
}
// 載入多國語系，給js所使用
var l = new Language(ml_key);
';

		$ggg = '?';
		//if(count($all_label) > 0){
		//	// @k en, tw...
		//	foreach($all_label as $k => $v){
		//		file_put_contents(lang_path.'/'.$k.'.php', '<'.$ggg.'php $labels = '.var_export($v, true).';');
		//	}
		//}
		if(count($all_label) > 0){
			$php_lang_path = '';
			$js_lang_path = '';

			//if(!file_exists(tmp_path)){
			//	mkdir(tmp_path, 0777, true);
			//}
			//$php_lang_path = Yii::app()->getRuntimePath() . DIRECTORY_SEPARATOR . 'language.php';
			$php_lang_path = tmp_path.DIRECTORY_SEPARATOR.'language.php';
			$js_lang_path = tmp_path.DIRECTORY_SEPARATOR.'language.js';

			file_put_contents($php_lang_path, '<'.$ggg.'php $labels = '.var_export($all_label, true).';');
			//file_put_contents($php_lang_tmp_path, '<'.$ggg.'php $labels_tmp = '.var_export($all_label_tmp, true).';');
			// 輸出給javascript所使用的多國語系片語
			file_put_contents($js_lang_path, $js_script.'var labels = '.json_encode($all_label).';');
		}
	}

	// 刪除自己的片語檔案(不是共用的哦)
	public function delete()
	{
		unlink(tmp_path.ds('/language.php'));
		unlink(tmp_path.ds('/language.js'));
	}
}
