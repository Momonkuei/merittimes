<?php
/*
 * 2019-12-11
 * 想要寫一個東西到page
 * 單純的取範圍內的陣列元素
 *
 * 如果只取第一個，那記得第二個參數要是字串
 * 結論就是，最好數字都要是字串
 * 要不然不等於(!=)會不成功
 * 但只要寫成不等於(!==)就可以了
 */

if(
	isset($_params_) and !empty($_params_)
	and isset($_params_['array_range_1']) and $_params_['array_range_1'] >= 0 // start 0,1,2,3...
	and isset($_params_['array_range_2']) and $_params_['array_range_2'] != '' // end 1,2,3,4,?... (Vencen說要絕對等於，要不然數字0，就會被當成空白)
){

	// 預設要處理的變數
	$handle = array(
		'rows' => '1',
		'ID' => '1',
		'general_item' => '1',
		'general_rows' => '1',
	);

	// 如果是參數模式，那預設要處理的變數，只會有本身的LayoutV3的資料流
	if(isset($_params_['array_range_0']) and !isset($_params_['array_range_3'])){
		$_params_['array_range_3'] = 'ID';
	}

	// 只要處理的變數，用|(pipe)來當做分隔
	if(isset($_params_['array_range_3']) and $_params_['array_range_3'] != ''){ // rows|ID|general_item
		$tmps = explode('|', $_params_['array_range_3']);

		foreach($handle as $k => $v){
			if(!in_array($k, $tmps)){
				unset($handle[$k]);
			}
		}
	}

	if(!empty($handle)){
		foreach($handle as $k => $v){
			$tmpaa = array();
			$result = array();
			if($k == 'rows' and isset($rows)){
				$tmpaa = $rows;
			} elseif($k == 'ID' and isset($data[$ID])){
				$tmpaa = $data[$ID];
			} elseif($k == 'general_item' and isset($this->data['_general_item'])){
				$tmpaa = $this->data['_general_item'];
			} elseif($k == 'general_rows' and isset($this->data['_general_rows'])){
				$tmpaa = $this->data['_general_rows'];
			}

			if($_params_['array_range_2'] == '?'){
				$_params_['array_range_2'] = 99;
			}
			$sort_asc = true;
			if($_params_['array_range_1'] > $_params_['array_range_2']){
				$sort_asc = false;
			}

			if($sort_asc === true){ // 正向
				for($x=$_params_['array_range_1'];$x<=$_params_['array_range_2'];$x++){
					if(isset($tmpaa[$x])){
						$result[] = $tmpaa[$x];
					}
				}
			} else { // 反向
				for($x=$_params_['array_range_1'];$x>=$_params_['array_range_2'];$x--){
					if(isset($tmpaa[$x])){
						$result[] = $tmpaa[$x];
					}
				}
			}

			if($k == 'rows' and isset($rows)){
				$rows = $result;
			} elseif($k == 'ID' and isset($data[$ID])){
				if(isset($_params_['array_range_0'])){
					$data[$ID] = $result;
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
					$data[$next_id] = $result;
				}
			} elseif($k == 'general_item' and isset($this->data['_general_item'])){
				$this->data['_general_item'] = $result;
			} elseif($k == 'general_rows' and isset($this->data['_general_rows'])){
				$this->data['_general_rows'] = $result;
			}
		}
	}
}

?>
