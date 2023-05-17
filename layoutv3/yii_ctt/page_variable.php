<?php

// http://stackoverflow.com/questions/8587341/recursive-function-to-generate-multidimensional-array-from-database-result
function buildTree(array $elements, $parentId = 0) {
    $branch = array();

    foreach ($elements as $element) {
        if ($element['parent_id'] == $parentId) {
            $children = buildTree($elements, $element['id']);
            if ($children) {
                $element['hole'] = $children;
            }
            $branch[] = $element;
        }
    }

    return $branch;
}

if(!isset($page) or count($page) <= 0){
	$rows = $this->db->createCommand()->select('id, name as file, pid as parent_id')->from('layoutv3_page')->where('is_enable=1')->order('sort_id')->queryAll();
	if($rows and count($rows) > 0){
		$tmp = str_replace('/', '', str_replace('.php','', $_SERVER['REQUEST_URI']));
		foreach($rows as $k => $v){
			if($v['parent_id'] == 0 and $v['file'] != $tmp){
				unset($rows[$k]);
			}
		}
	}
	$result = buildTree($rows);
	//var_dump($result);
	//die;
	$page = $result[0]['hole'];
}
