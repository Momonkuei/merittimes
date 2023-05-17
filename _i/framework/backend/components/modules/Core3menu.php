<?php

class XXXXXXXX_A extends XXXXXXXX_B
{
	public function _get_admin_menu_classes()
	{

		$acl = new Admin_acl();
		$acl->start();

		// 取得所有的分類，目標做到2層以上
		$conditions = array(
			//'ml_key' => $data['ml_key'],
			'is_enable' => '1',
		);

		if(defined('BACKEND_MENU_MERGE')){
			if(BACKEND_MENU_MERGE == true){ // 2019-11-21
				$conditions['ml_key'] = 'tw';
			} else {
				$conditions['ml_key'] = $this->data['admin_switch_data_ml_key'];
			}
		}

		// $query = $this->cidb->select('id, class_id, class_name, class_name AS class_name_id')->where($conditions)->get('product_class');
		// $query = $this->cidb->select('id, pid AS class_id, name AS class_name, name AS class_name_id,link,class2')->where($conditions)->order_by('sort_id')->get('admin_menu');
		$query = $this->cidb->select('*, pid AS class_id, name AS class_name, name AS class_name_id')->where($conditions)->order_by('sort_id')->get('admin_menu');
		$productclasses = array();
		$productclasses_sample = array();
		$no_acl_ids = array();
		foreach($query->result_array() as $row){

			//$row['has_no_acl'] = false;

			if($row['link'] == '#' or $row['link'] == '' or $row['link'] == 'javascript:;'){
				// do nothing
			} else {
				// 把沒有權限的給弄掉
				if(!$acl->hasAcl($this->data['admin_id'], str_replace('backend.php?', '', $row['link']))){
					$no_acl_ids[] = $row['class_id'];
					continue;
				}
			}

			$row['url'] = $row['link'];
			$row['title'] = $row['class_name'];
			$row['parent_id'] = $row['class_id'];
			$row['class_name_id'] = $row['class_name_id'].'__'.$row['id'];
			$productclasses[] = $row;
			$productclasses_sample[$row['id']] = $row;
		}

		$productclasses_has_acl = array();
		foreach($productclasses as $k => $v){
			if(in_array($v['id'], $no_acl_ids)){
				$v['has_no_acl_item'] = true;
			}
			if($v['parent_id'] == 0 and $v['class2'] == ''){
				$v['class2'] = 'icon-map-marker';
			}
			$productclasses_has_acl[$k] = $v;
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
				// 不確定能不能修正失去上一層的資料問題
				if(!isset($tree['_orphans_'])){
					continue;
				   	//$tree['_orphans_'] = array();
				}
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
			'data_source' => $productclasses,

			// has acl element
			'data' => $productclasses_has_acl,

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
	public function _search_admin_menu_tree($tree, $classes, $class_name, $product_name, $char = ' / ')
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
		//die;

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
			@eval($run);
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

	// http://avenir.ro/revisiting-the-multilevel-menu-in-php-with-some-additional-code-bootstrap-framework/
	public function bootstrap_menu($array,$parent_id = 0,$parents = array(),$focus = array())
	{
		if($parent_id==0)
		{
			foreach ($array as $element) {
				if (($element['parent_id'] != 0) && !in_array($element['parent_id'],$parents)) {
					$parents[] = $element['parent_id'];
				}
			}
		}
		$menu_html = '';
		foreach($array as $element)
		{
			if($element['parent_id']==$parent_id)
			{
				if(in_array($element['id'],$parents))
				{
					if(isset($focus['keyvalue'][$element['id']])){
						$menu_html .= '<li class="xdropdown active">';
					} else {
						$menu_html .= '<li class="xdropdown">';
					}

					// 2019-11-28
					$target = '';
					if(isset($element['is_target_blank']) and $element['is_target_blank'] == 1){
						$target = ' target="_blank" ';
					}

					$menu_html .= '<a href="'.$element['url'].'" '.$target.' class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">';
					if(isset($element['class2']) and $element['class2'] != ''){
						$menu_html .= '<i class="'.$element['class2'].'"></i>';
					} else {
						//$menu_html .= '<i class="icon-map-marker"></i>';
					}
					$menu_html .= '<span class="title">'.$element['title'].'</span> <span class="arrow "></span></a>';
				}
				else {
					if(isset($focus['keyvalue'][$element['id']])){
						$menu_html .= '<li class="active">';
					} else {
						$menu_html .= '<li>';
					}

					// 2019-11-28
					$target = '';
					if(isset($element['is_target_blank']) and $element['is_target_blank'] == 1){
						$target = ' target="_blank" ';
					}

					$menu_html .= '<a href="' . $element['url'] . '" '.$target.' >';
					if(isset($element['class2']) and $element['class2'] != ''){
						$menu_html .= '<i class="'.$element['class2'].'"></i>';
					} else {
						//$menu_html .= '<i class="icon-map-marker"></i>';
					}
					$menu_html .= '<span class="title">'.$element['title'].'</span></a>';
				}

				$has_submenu = false;
				if(in_array($element['id'],$parents))
				{
					$menu_html .= '<ul class="sub-menu xdropdown-menu" role="menu">';
					$menu_html .= $this->bootstrap_menu($array, $element['id'], $parents, $focus);
					$menu_html .= '</ul>';
					$has_submenu = true;
				}

				if(!$has_submenu and isset($element['has_no_acl_item']) and $element['has_no_acl_item']){
					$menu_html .= '<span class="hideme" style="display:none"></span>';
				}

				$menu_html .= '</li>';
			}
		}
		return $menu_html;
	}

}
