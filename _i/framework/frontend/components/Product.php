<?php

/*
 * 商品的東西可能都放這裡
 * 最剛開始只是先弄麵包屑而以
 */
class Product
{
	function __construct()
	{
		$this->db = Yii::app()->db;
		$this->cidb = Yii::app()->params['cidb'];
		$this->session = Yii::app()->session;
	}

	public function _get_product_classes($data)
	{
		// 取得所有的分類，目標做到2層以上
		$conditions = array(
			'ml_key' => $data['ml_key'],
			'is_enable' => '1',
		);
		//$query = $this->cidb->select('id, class_id, class_name, class_name AS class_name_id')->where($conditions)->get('product_class');
		$query = $this->cidb->select('id, pid AS class_id, name AS class_name, name AS class_name_id')->where($conditions)->get('product_type');
		$productclasses = array();
		$productclasses_sample = array();
		foreach($query->result_array() as $row){
			$row['class_name_id'] = $row['class_name_id'].'__'.$row['id'];
			$productclasses[] = $row;
			$productclasses_sample[$row['id']] = $row;
		}

		// 將分類轉成Tree
		// http://www.mombu.com/php/php/t-creating-tree-structure-from-associative-array-11767756.html
		// Set up indexing of the above list (in case it wasn't indexed).
		$lookup = array();
		foreach( $productclasses as $item ){
			$item['children'] = array();
			$lookup[$item['id']] = $item;
		}
		
		// Now build tree.
		$tree = array();
		foreach( $lookup as $id => $foo ){
			$item = &$lookup[$id];
			if( $item['class_id'] == 0 ){
				$tree[$id] = &$item;
			} else if( isset( $lookup[$item['class_id']] ) ){
				$lookup[$item['class_id']]['children'][$id] = &$item;
			} else {
				$tree['_orphans_'][$id] = &$item;
			}
		}

		// 想要做無限層轉一層(例如用在下拉選單)
		$tmp = var_export($tree,true);
		$tmps = explode("\n",$tmp);
		$tmp1 = array();
		foreach($tmps as $k => $v){
			if(preg_match('/^(.*)\'class_name_id\'\ =\>\ \'(.*)__(\d+)\'\,$/', $v, $matches)){
				//echo strlen($matches[1]).' '.$matches[3].$matches[2].'<br />'."\n";
				$tmp1[] = array(
					'layer' => strlen($matches[1])/4,
					'name' => $matches[2],
					'id' => $matches[3],
				);
			}
		}

		$return = array(
			'data' => $productclasses,
			'sample' => $productclasses_sample,
			'tree' => $tree,
			'layer_one' => $tmp1,
		);

		return $return;
	}

	/*
	 * 這裡會回應一個陣列
	 * 其中斜線是$char變數
	 * array(
	 *   'ids' => array(IDA, IDB, IDC),
	 *   'keyvalue' => array(
	 *		'CLASSID - A' => 'classA',
	 *		'CLASSID - B' => 'classB',
	 *		'CLASSID - N' => 'classN',
	 *   );
	 *   'values' => array(
	 *		'classA',
	 *		'classB',
	 *		'classN',
	 *   );
	 *   'value' => 'classA / classB / classN',
	 * )
	 *
	 * @class_name string 是分類名稱__分類編號所組成
	 */
	// http://php.chinaunix.net/manual/tw/function.array-search.php 也可以參考這裡，搜尋關建字是getParentStack
	public function _search_product_class_tree($tree, $classes, $class_name, $product_name, $char = ' / ')
	{
		/* 搜尋結果是2層的狀況
		 * array(1) {
		 *   [1]=>
		 *   array(1) {
		 *     ["children"]=>
		 *     array(1) {
		 *       [25]=>
		 *       array(1) {
		 *         ["class_id_name"]=>
		 *         string(6) "RD3011__25"
		 *       }
		 *     }
		 *   }
		 * }
		 */
		// 搜尋陣列，把搜尋的"第1個"結果給找出來
		$return_tmp = $this->_getParentStack($class_name, $tree);

		/*
		 * 來看一下$return_tmp裡面是什麼東東
array(1) {
  [23]=>
  array(1) {
    ["children"]=>
    array(1) {
      [24]=>
      array(1) {
        ["children"]=>
        array(1) {
          [31]=>
          array(1) {
            ["class_name"]=>
            string(7) "test1gg"
          }
        }
      }
    }
  }
}
*/
		//var_dump($return_tmp);

		$return = array();

		// 開始解無限層
		for($x=1;$x<=100;$x++){
			$tmp = '';
			$run = '';
			for($y=1;$y<=($x-1);$y++){
				$tmp .= '[$L'.$y.']["children"]';
			} // for y
			//echo $tmp."\n";
			$run = <<<XXX
if(!isset(\$return_tmp$tmp)){
	\$x = 100;
} else {
	foreach(\$return_tmp$tmp as \$L$y => \$v) break;
}
XXX;
			eval($run);
		} // for x

		$return['ids'] = array();
		for($x=1;$x<=100;$x++){
			eval('if(isset($L'.$x.')) $return["ids"][] = $L'.$x.';');
		}
		//var_dump($return);
		//die;


		//if(isset($classes[$root_class_id]['class_name'])){
		$return['keyvalue'] = array();
		$return['values'] = array();
		if(count($return['ids']) > 0){
			foreach($return['ids'] as $v){
				$return['keyvalue'][$v] = $classes[$v]['class_name'];
				$return['values'][] = $classes[$v]['class_name'];
			}
		}
		$return['value'] = implode(' / ', $return['values']);

		return $return;
	}

	/*
	 * 這裡會回應一個陣列
	 * 其中斜線是$char變數
	 * array(
	 *   'keyvalue' => array(
	 *		'CLASSID - A' => 'classA',
	 *		'CLASSID - B' => 'classB',
	 *		'CLASSID - N' => 'classN',
	 *   );
	 *   'values' => array(
	 *		'classA',
	 *		'classB',
	 *		'classN',
	 *   );
	 *   'value' => 'classA / classB / classN',
	 * )
	 *
	 * @class_name string 是分類名稱__分類編號所組成
	 */
	public function _search_product_class_tree_old($tree, $classes, $class_name, $product_name, $char = ' / ')
	{
		/* 搜尋結果是2層的狀況
		 * array(1) {
		 *   [1]=>
		 *   array(1) {
		 *     ["children"]=>
		 *     array(1) {
		 *       [25]=>
		 *       array(1) {
		 *         ["class_id_name"]=>
		 *         string(6) "RD3011__25"
		 *       }
		 *     }
		 *   }
		 * }
		 */
		// 搜尋陣列，把搜尋的"第1個"結果給找出來
		$return_tmp = $this->_getParentStack($class_name, $tree);

		//var_dump($return_tmp);

		$return = array();

		if(count($return_tmp) == 1 and $return_tmp != false){
			$root_class_id = '';
			$sub_class_id = '';
			// @k 大分類編號
			foreach($return_tmp as $k => $v){
				$root_class_id = $k;
				// @kk 小分類編號
				if(isset($v['children']) and count($v['children']) > 0){
					foreach($v['children'] as $kk => $vv){
						$sub_class_id = $kk;
						break;
					}
				}
			}

			$root_class_name = '';
			if(isset($classes[$root_class_id]['class_name'])){
				$root_class_name = $classes[$root_class_id]['class_name'];
			}
			$sub_class_name = '';
			if(isset($classes[$sub_class_id]['class_name'])){
				$sub_class_name = $classes[$sub_class_id]['class_name'];
			}

			$return['value'] = $root_class_name.$char.$sub_class_name;
			$return['values'] = array(
				$root_class_name,
				$sub_class_name,
			);
			$return['ids'] = array(
				$root_class_id,
				$sub_class_id,
			);
			$return['keyvalue'] = array(
				$root_class_id => $root_class_name,
				$sub_class_id => $sub_class_name,
			);

			// 建立另一個變數，處理跟商品名稱一樣的狀況，大小分類都要比對
			$return['handle_value'] = '';
			$return['handle_values'] = array();
			if($product_name == $sub_class_name){
				$return['handle_value'] = $root_class_name;
				$return['handle_values'][0] = $root_class_name;
				$return['handle_ids'][0] = $root_class_id;
				if($product_name == $root_class_name){
					$return['handle_value'] = '';
					$return['handle_values'] = array();
				} else {
					$return['handle_value'] = $root_class_name;
				}
			} else {
				$return['handle_value'] = $root_class_name.$char.$sub_class_name;
				$return['handle_values'][0] = $root_class_name;
				$return['handle_values'][1] = $sub_class_name;
				$return['handle_ids'][0] = $root_class_id;
				$return['handle_ids'][1] = $sub_class_id;
			}

		} // $return_tmp == 1
		
		// 反向的合併分類資料，威全專用
		if(isset($return['handle_values']) and count($return['handle_values'] > 0)){
			$return['handle_revert_values'] = array_reverse($return['handle_values']);
		}

		return $return;
	}

	/**
	 * Gets the parent stack of a string array element if it is found within the
	 * parent array
	 *
	 * This will not search objects within an array, though I suspect you could
	 * tweak it easily enough to do that
	 *
	 * @param string $child The string array element to search for
	 * @param array $stack The stack to search within for the child
	 * @return array An array containing the parent stack for the child if found,
	 *               false otherwise
	 */
	public function _getParentStack($child, $stack) {
		foreach ($stack as $k => $v) {
			if (is_array($v)) {
				// If the current element of the array is an array, recurse it and capture the return
				$return = $this->_getParentStack($child, $v);
			   
				// If the return is an array, stack it and return it
				if (is_array($return)) {
					return array($k => $return);
				}
			} else {
				// Since we are not on an array, compare directly
				if ($v == $child) {
					// And if we match, stack it and return it
					return array($k => $child);
				}
			}
		}
	   
		// Return false since there was nothing found
		return false;
	}
}
