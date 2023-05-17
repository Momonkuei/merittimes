<?php

/*
 * Layout V2
 */

class Layoutv2 extends CController
{

public  function section_recursive($key)
{
	//global $this->data['session_name'];

	$current = array();
	if(isset($_SESSION[$this->data['session_name']][$key])){
		$current = $_SESSION[$this->data['session_name']][$key];
	} else {
		return;
	}

	// 測試資料
	//if(isset($this->data['editmode']) and $this->data['editmode'] == true and !isset($this->data['layoutv2'][$key])){
	if(!isset($this->data['layoutv2'][$key])){
		$this->data['layoutv2'][$key] = array(
			array(
				'id' => '123',
				'topic' => '測試A',
				'name' => '測試A',
				'other1' => '測試A',
				'url1' => '#',
				'pic1' => 'demo/testa.jpg',
				'detail' => '測試A',
				'start_date' => '',
			),
			array(
				'id' => '456',
				'topic' => '測試B',
				'name' => '測試B',
				'other1' => '測試B',
				'url1' => '#',
				'pic1' => 'demo/testb.jpg',
				'detail' => '測試B',
				'start_date' => '',
			),
			array(
				'id' => '789',
				'topic' => '測試C',
				'name' => '測試C',
				'other1' => '測試C',
				'url1' => '#',
				'pic1' => 'demo/testc.jpg',
				'detail' => '測試C',
				'start_date' => '',
			),
			//'id' => '789',
			//'topic' => '測試C',
			//'name' => '測試C',
			//'other1' => '測試C',
			//'url1' => '#',
			//'pic1' => 'demo/testc.jpg',
			//'detail' => '測試C',
		);
	}

	$tag = 'div';

	if(isset($current['tag'])){
		$tag = $current['tag'];
	}
	$type = $current['type'];
	$pid = $current['pid'];
	$pos = $current['pos']; // 我在上一層的哪一個位置
	$other = implode(' ', explode(',', $current['other']));
	$other2 = trim($current['other2']);

	/*
	 * 可以讓第2層的區塊，也能設定class名稱
	 */
	//$other3 = '';
	//if(isset($current['other3'])){
	//	$other3 = trim($current['other3']);
	//}

	// 看看other2裡面有沒有自訂引數，有的話就導出它
	if($other2 != ''){
		$other2_tmp = explode(' ', $other2);
		foreach($other2_tmp as $k => $v){
			if(preg_match('/^p(\d+)_(.*)$/', $v, $matches)){
				$this->data['layoutv2_param'][$key][$matches[1]] = $matches[2];
				unset($other2_tmp[$k]);
			}
		}
		$other2 = implode(' ', $other2_tmp);
	}

	$this->data['section'] = $current;
	$this->data['section']['key'] = $key;
	$this->data['key'] = $key; // 目前是view_echo_general_html.php在使用的


	$return = '';

	//Bbox
	//Bbox_full_top
	//Bbox_full_top NoOverTop
	//Bbox_full_bottom
	//Bbox_full_bottom NoOverBottom
	//Bbox_full
	//Bbox_full_1c
	//Bbox_1c
	//Bbox_in_1c
	//Bbox_in_2c
	//Bbox_in_3c
	//Bbox_in_4c
	//Bbox_in_6c
	//Bbox_in_6c_xs3
	//Bbox_in_2c_L8
	//Bbox_in_2c_L4
	//Bbox_in_2c_L3
	//Bbox_in_2c_L9
	//Bbox_sin_6_48
	//Bbox_sin_3_12
	//Bbox_sin_12_39
	//Bbox_sin_12_12

	if(file_exists(Yii::getPathOfAlias('application.views.layoutv2').'/'.$type.'.php')){
		$file = Yii::getPathOfAlias('application.views.layoutv2').'/'.$type.'.php';
	} else {
		$file = Yii::getPathOfAlias('system.frontend.views.layoutv2').'/'.$type.'.php';
	}

	//if($type == 'Bbox'){
	if(preg_match('/^group___(.*)___(.*)$/', $type, $matches) or ($type == 'group' and isset($this->data['layoutv2_param'][$key][1]) and $this->data['layoutv2_param'][$key][1] != '' and isset($this->data['layoutv2_param'][$key][2]) and $this->data['layoutv2_param'][$key][2] != '')){
		if($type == 'group'){
			$matches = array();
			$matches[1] = $this->data['layoutv2_param'][$key][1];
			$matches[2] = $this->data['layoutv2_param'][$key][2];
		}
		$file = Yii::getPathOfAlias('application').'/controllers/layoutv2/'.'layout_'.str_replace('/', '-',$matches[1]).'.php';
		if(file_exists($file)){
			$file_tmp = str_replace('<'.'?'.'php $layouts', '$tmp', file_get_contents($file));
			eval($file_tmp);
			// 1. key和pid都加上本層的編號加上特殊字元
			$tmp1 = array();
			foreach($tmp as $k => $v){
				if($v['pid'] == $matches[2]){
					$v['pid'] = $key;
				} else {
					$v['pid'] = $pid.'_'.$v['pid'];
				}
				$tmp1[$pid.'_'.$k] = $v;
			}
			// 2. 更改pid為本層
			//$tmp1[$pid.'_1']['pid'] = $key;
			//foreach($tmp1 as $k => $v){
			//	$tmp1[$pid.'_1']['pid'] = $key;
			//}

			// 3. 併回主幹
			foreach($tmp1 as $k => $v){
				$_SESSION[$this->data['session_name']][$k] = $v;
			}
			//echo $key;
			//var_dump($_SESSION[$this->data['session_name']]);
			//die;

			// 產生內容
			$tmp = $this->search_child($key, 1);
			//var_dump($tmp);
			//die;
			if(isset($tmp) and count($tmp) > 0){
				foreach($tmp as $k => $v){
					// 會連同connector也會拉進來
					$return .= $this->section_recursive($v);
				}
			}
			//if(!$this->data['editmode']){
			//}

			// 為了避免tree顯示，以及存檔誤存
			foreach($tmp1 as $k => $v){
				unset($_SESSION[$this->data['session_name']][$k]);
			}
		}
	/*
	 * connect和hole在group裡面不是唯一
	 */
	} elseif(preg_match('/^group_connect_(.*)$/', $type)){
		// do nothing
	} elseif(preg_match('/^group_hole_(.*)$/', $type, $matches)){
		if($this->data[$this->data['layout_v2_name'].'_editmode']){
			$return .= ' [G坑'.$matches[1].'] ';
		}
		//var_dump($_SESSION[$this->data['session_name']]);
		//die;
		foreach($_SESSION[$this->data['session_name']] as $k => $v){
			//var_dump($k);
			if($v['type'] == 'group_connect_'.$matches[1]
				// 雙向繫結，因為無法換版型
				and isset($this->data['layoutv2_param'][$key][1])
				and 'p1_'.$this->data['layoutv2_param'][$key][1] == $v['other2']
			){
				//echo 'cc'.$v['pid'];
				// test而以
				$tmp = $this->search_child($k, 1);
				//var_dump($tmp);
				if(isset($tmp) and count($tmp) > 0){
					foreach($tmp as $kk => $vv){
						$return .= $this->section_recursive($vv);
					}
				}
			}
		}

	// 己支援手動載入
	} elseif(preg_match('/^layout___(.*)$/', $type, $matches) or ($type == 'layout' and isset($this->data['layoutv2_param'][$key][1]) and $this->data['layoutv2_param'][$key][1] != '') ){ // layout那個是手動載入，要記得下param1
		if($type == 'layout'){
			$matches = array();
			$matches[1] = $this->data['layoutv2_param'][$key][1];
		}
		$file = Yii::getPathOfAlias('application').'/controllers/layoutv2/'.'layout_'.str_replace('/', '-',$matches[1]).'.php';
		if(file_exists($file)){
			$file_tmp = str_replace('<'.'?'.'php $layouts', '$tmp', file_get_contents($file));
			eval($file_tmp);
			// 1. key和pid都加上本層的編號加上特殊字元
			$tmp1 = array();
			foreach($tmp as $k => $v){
				if($v['pid'] == 0){
					$v['pid'] = $key;
				} else {
					$v['pid'] = $pid.'_'.$v['pid'];
				}
				$tmp1[$pid.'_'.$k] = $v;
			}
			// 2. 更改pid為本層
			//$tmp1[$pid.'_1']['pid'] = $key;
			//foreach($tmp1 as $k => $v){
			//	$tmp1[$pid.'_1']['pid'] = $key;
			//}

			// 3. 併回主幹
			foreach($tmp1 as $k => $v){
				$_SESSION[$this->data['session_name']][$k] = $v;
			}

			// 4. 看看有沒有需要外部干涉 (這裡是大干涉)
			$file2 = Yii::getPathOfAlias('application').'/controllers/layoutv2/'.'datalayout_'.str_replace('/', '-',$matches[1]).'.php';
			if(file_exists($file2)){
				include $file2;
			}

			// 5. 小干涉
			$file2 = Yii::getPathOfAlias('application').'/controllers/layoutv2/'.'datalayout_'.str_replace('/', '-',$matches[1]).'_'.$this->data['layout_v2_name'].'.php';
			if(file_exists($file2)){
				include $file2;
			}

			//var_dump($_SESSION[$this->data['session_name']]);
			//die;

			// 產生內容
			$tmp = $this->search_child($key, 1);
			if(isset($tmp) and count($tmp) > 0){
				foreach($tmp as $k => $v){
					// 會連同connector也會拉進來
					$return .= $this->section_recursive($v);
				}
			}
			//if(!$this->data['editmode']){
			//}

			// 為了避免tree顯示，以及存檔誤存
			foreach($tmp1 as $k => $v){
				unset($_SESSION[$this->data['session_name']][$k]);
			}
		}
	/*
	 * connect和hole在layout裡面是唯一
	 */
	} elseif(preg_match('/^layout_connect_(.*)$/', $type)){
		// do nothing
	} elseif(preg_match('/^layout_hole_(.*)$/', $type, $matches)){
		if($this->data[$this->data['layout_v2_name'].'_editmode']){
			$return .= ' [坑'.$matches[1].'] ';
		}
		foreach($_SESSION[$this->data['session_name']] as $k => $v){
			//var_dump($k);
			if($v['type'] == 'layout_connect_'.$matches[1]
				// 雙向繫結，目前取消，因為無法換版型
				// and isset($this->data['layoutv2_param'][$key][1])
				// and 'p1_'.$this->data['layoutv2_param'][$key][1] == $v['other2']
			){
				//echo 'cc'.$v['pid'];
				// test而以
				$tmp = $this->search_child($k, 1);
				//var_dump($tmp);
				if(isset($tmp) and count($tmp) > 0){
					foreach($tmp as $kk => $vv){
						$return .= $this->section_recursive($vv);
					}
				}
			}
		}
	} elseif(preg_match('/^Bbox(_1c|_full|_full_top|_full_1c|_full_bottom|)/', $type) OR preg_match('/^Bbox_in_(\d)c(_xs3|)$/', $type)){ 

		eval($this->run_pos_n(1,$key));
		//$return = file_get_contents(Yii::getPathOfAlias('application').'/controllers/layoutv2/sections/Bbox.html');
		$return = file_get_contents(Yii::getPathOfAlias('system.frontend').'/views/layoutv2/sections/Bbox.html');
		eval($this->run_pos_m(1));
		
// 	} elseif(preg_match('/^div$/', $type)){ // 例：Bbox_in_2c_L3
// 
// 		eval($this->run_pos_n(1,$key));
// 		$return = <<<XXX
// <div [STYLEPOS1] class="[OTHER]">
// 	[POS1]
// </div>
// XXX;
// 		eval($this->run_pos_m(1));

	} elseif(preg_match('/^Bbox_in_(\d)c_L(\d+)$/', $type) OR preg_match('/sin/', $type)){ // 例：Bbox_in_2c_L3

		eval($this->run_pos_n(1,$key));
		//eval($this->run_pos_n(2,$key));
		//$return = file_get_contents(Yii::getPathOfAlias('application').'/controllers/layout_v2/sections/Bbox_in_Xc_LY.html');
		//$return = file_get_contents(Yii::getPathOfAlias('application').'/controllers/layoutv2/sections/Bbox.html');
		$return = file_get_contents(Yii::getPathOfAlias('system.frontend').'/views/layoutv2/sections/Bbox.html');
		eval($this->run_pos_m(1));
		//eval($this->run_pos_m(2));

	} elseif($type == 'renderPartial'){

		if(isset($this->data['layoutv2_param'][$key][1]) and $this->data['layoutv2_param'][$key][1] != ''
		){
			eval($this->run_pos_n(1,$key));
			if(isset($this->data['layoutv2_param'][$key][2]) and $this->data['layoutv2_param'][$key][2] != ''){
				$this->data['layoutv2_sections_select'] = $this->data['layoutv2_param'][$key][2];
			}
			// 例如：//layoutv2/ggg
			if(preg_match('/^\/\//', $this->data['layoutv2_param'][$key][1])){
				$tmp = str_replace('//', '', $this->data['layoutv2_param'][$key][1]);
				$tmp = str_replace('/', '.', $this->data['layoutv2_param'][$key][1]);
				if(file_exists(Yii::getPathOfAlias('application.views.'.$tmp).'.php')){
					$this->data['layoutv2_param'][$key][1] = 'application.views.'.$tmp;
				} else {
					$this->data['layoutv2_param'][$key][1] = 'system.frontend.views.'.$tmp;
				}
			}
			$return = $this->renderPartial($this->data['layoutv2_param'][$key][1], $this->data, true);
			eval($this->run_pos_m(1));
		}

	} elseif($type == 'sample_text'){

		eval($this->run_pos_n(1,$key));
		$return = <<<XXX
<span [STYLEPOS1] class="[OTHER]">
	[POS1]
	範例文字
</span>
XXX;
		eval($this->run_pos_m(1));

	//} elseif(preg_match('/^view_(.*)$/', $type, $matches) and file_exists(Yii::getPathOfAlias('application').'/views/layoutv2/'.$type.'.php')){
	} elseif($type == 'view_bbox'){
		// 不這樣子做，底下的東西，會有body_start, body_end重覆載入的問題
		if(file_exists(Yii::getPathOfAlias('application.views.layoutv2').'/'.$type.'.php')){
			$return = $this->renderPartial('application.views.layoutv2.'.$type, $this->data, true);
		} else {
			$return = $this->renderPartial('system.frontend.views.layoutv2.'.$type, $this->data, true);
		}
	} elseif(preg_match('/^view_(.*)$/', $type, $matches)){

		eval($this->run_pos_n(1,$key));
		//eval($this->run_pos_n(2,$key));

		//$return = $this->renderPartial('application.views.layoutv2.'.$type, $this->data, true);

		if(file_exists(Yii::getPathOfAlias('application.views.layoutv2').'/'.$type.'.php')){
			$return = $this->renderPartial('application.views.layoutv2.'.$type, $this->data, true);
		} else {
			$return = $this->renderPartial('system.frontend.views.layoutv2.'.$type, $this->data, true);
		}

		eval($this->run_pos_m(1));
		//echo $return;
		//var_dump($other2);
		//eval($this->run_pos_m(2));

	} elseif(preg_match('/^placeholdit_(.*)_(.*)_(.*)$/', $type, $matches)){ // 例placeholdit_100_50_顯示文字
		eval($this->run_pos_n(1,$key));

		$width = $matches[1];
		$height = $matches[2];
		$text = $matches[3];

		if(isset($this->data['layoutv2_param'][$key][1])){
			$width = $this->data['layoutv2_param'][$key][1];
		}

		if(isset($this->data['layoutv2_param'][$key][2])){
			$height = $this->data['layoutv2_param'][$key][2];
		}

		$size = $width.'x'.$height;

		//$color_tmp = $matches[3];
		//$color = '';
		//if($color_tmp != ''){
		//	$color = '/'.str_replace('_', '/', $color_tmp);
		//}
		//$size .= $color;

$return = <<<XXX
$pos1
<img src="http://placehold.it/$size?text=$text">
XXX;
	} elseif(preg_match('/^placeholdit_(.*)_(.*)$/', $type, $matches)){ // 例：Bbox_in_2c_L3
		eval($this->run_pos_n(1,$key));

		$width = $matches[1];
		$height = $matches[2];

		if(isset($this->data['layoutv2_param'][$key][1])){
			$width = $this->data['layoutv2_param'][$key][1];
		}

		if(isset($this->data['layoutv2_param'][$key][2])){
			$height = $this->data['layoutv2_param'][$key][2];
		}

		$size = $width.'x'.$height;

$return = <<<XXX
$pos1
<img src="http://placehold.it/$size">
XXX;
	} else {
		echo $type.'(不支援的元件)';
	}

	if(file_exists(Yii::getPathOfAlias('application.views.layoutv2').'/'.$type.'.php')){
		$file = Yii::getPathOfAlias('application.views.layoutv2').'/'.$type.'.php';
	} else {
		$file = Yii::getPathOfAlias('system.frontend.views.layoutv2').'/'.$type.'.php';
	}
	if(file_exists($file)){
		$tmp = file_get_contents($file);
		if(preg_match('/tag_section_recursive_end/', $tmp)){
			$this->data['tag_section_recursive_end'] = '';
			include $file;
			unset($this->data['tag_section_recursive_end']);
		}
	}

	return $return;
}

// 這是讓section_recursive使用的函式
public  function run_pos_n($pos,$key)
{
	//global $editmode;

	//$currenturl = $this->data['router_class'].'/'.$this->data['router_method'];
	if(isset($_SESSION[$this->data['session_name'].'_params'])){
		$currenturl = $this->createUrl($this->data['router_class'].'/'.$this->data['router_method'],$_SESSION[$this->data['session_name'].'_params']+array('pos'=>$pos,'key'=>$key));
	}

	$run = <<<XXX
// 檢查是否選到自己，是的話，就加個框
\$stylepos$pos = '';
if(isset(\$_GET['key']) and \$key == \$_GET['key'] and $pos == \$_GET['pos'] and isset(\$_SESSION[\$this->data['session_name'].'_need_point']) and \$_SESSION[\$this->data['session_name'].'_need_point'] == '1'){
	\$stylepos$pos = ' style="border:1px red solid" ';
}

\$tmp = \$this->search_child(\$key, $pos);
\$pos$pos = '';
if(isset(\$tmp) and count(\$tmp) > 0){
	foreach(\$tmp as \$k => \$v){
		\$pos$pos .= \$this->section_recursive(\$v);
	}
}
if(!isset(\$pos$pos)){
	\$pos$pos = '';
}
XXX;
			//if($this->data['editmode'] and isset($_SESSION[$this->data['session_name'].'_only_tree']) and $_SESSION[$this->data['session_name'].'_only_tree'] == '1'){
	if(isset($this->data[$this->data['layout_v2_name'].'_editmode']) and $this->data[$this->data['layout_v2_name'].'_editmode'] and isset($_SESSION[$this->data['session_name'].'_need_point']) and $_SESSION[$this->data['session_name'].'_need_point'] == '1'){
		$run .= <<<XXX
if(isset(\$_GET['key']) and \$key == \$_GET['key'] and $pos == \$_GET['pos']){
	//\$pos$pos = '<a href="?r=$currenturl&pos=$pos&key=$key" style="color:red"><b>$key</b><!-- -\$pos -->*</a>'.\$pos$pos;
	\$pos$pos = '<a href="$currenturl" style="color:red"><b>$key</b><!-- -\$pos -->*</a>'.\$pos$pos;
} else {
	//\$pos$pos = '<a href="?r=$currenturl&pos=$pos&key=$key">$key<!-- -\$pos -->*</a>'.\$pos$pos;
	\$pos$pos = '<a href="$currenturl">$key<!-- -\$pos -->*</a>'.\$pos$pos;
}
XXX;
	}
	return $run;
}

public  function run_pos_m($pos)
{
	$run = <<<XXX
\$return = str_replace('[TAG]', \$tag, \$return);
\$return = str_replace('[TYPE]', \$type, \$return);
\$return = str_replace('[OTHER]', \$other.' '.\$other2, \$return);
\$return = str_replace('[STYLEPOS$pos]', \$stylepos$pos, \$return);
\$return = str_replace('[POS$pos]', \$pos$pos, \$return);
XXX;
	return $run;
}

// 尋找下一層的小孩(只有下一層哦，不包含下下層)
public  function search_child($pid, $pos)
{
	//global $this->data['session_name'];

	$returns = array();

	if(isset($_SESSION[$this->data['session_name']]) and count($_SESSION[$this->data['session_name']]) > 0){
		foreach($_SESSION[$this->data['session_name']] as $k => $v){
			// 加上(string)是因為，我在擴充layout功能的時候，編號都是X_X，就是字串，到這裡會異常
			//if($v['pid'] == $pid and $v['pos'] == $pos){
			if((string)$v['pid'] == (string)$pid and (string)$v['pos'] == (string)$pos){
				$returns[] = $k;
			}
		}
	}

	return $returns;
}

public  function create_section($type, $pid = 0, $pos = 0)
{
	//global $this->data['session_name'];

	if(!isset($_SESSION[$this->data['session_name']])){
		$_SESSION[$this->data['session_name']] = array();
	}
	$_SESSION[$this->data['session_name']][] = array(
		'type' => $type,
		'pid' => $pid,
		'pos' => $pos,
	);
}

// function update_section($key, $attrs = array(), $type = null, $pid = null)
// {
// 	global $this->data['session_name'];
// 
// 	if(isset($_SESSION[$this->data['session_name']][$key])){
// 		if(!is_null($type)) $_SESSION[$this->data['session_name']][$key]['type'] = $type;
// 		if(!is_null($pid)) $_SESSION[$this->data['session_name']][$key]['pid'] = $pid;
// 		if(count($attrs) > 0){
// 			foreach($attrs as $k => $v){
// 				$_SESSION[$this->data['session_name']][$key][$k] = $v;
// 			}
// 		}
// 	}
// }

/*
 * A 目標的上面
 * B 來源
 * C 目標
 * D 目標的下面
 *
 * 重組 => A + B + C + D
 */
public function move_key($source_id, $dest_id)
{
	// 先做一些錯誤判斷
	if(!isset($_SESSION[$this->data['session_name']][$source_id])) return;
	if(!isset($_SESSION[$this->data['session_name']][$dest_id])) return;

	// 要同層才有意義
	if($_SESSION[$this->data['session_name']][$source_id]['pid'] == $_SESSION[$this->data['session_name']][$dest_id]['pid']){
	} else {
		return;
	}

	// 先備份
	$old = $_SESSION[$this->data['session_name']];
	
	if($old and count($old) > 0){
		$next = false;
		$a = $d = array();
		$b = array();
		$c = array();
		$b[$source_id] = $_SESSION[$this->data['session_name']][$source_id];
		$c[$dest_id] = $_SESSION[$this->data['session_name']][$dest_id];
		foreach($old as $k => $v){

			if($k == $source_id) continue;

			if($k == $dest_id){
				$next = true;
			} else {
				if(!$next){
					$a[$k] = $v;
				} else {
					$d[$k] = $v;
				}
			}
		}
		$_SESSION[$this->data['session_name']] = array();
		$_SESSION[$this->data['session_name']] = $a + $b + $c + $d;
	}
}

// 會連小孩一起搬家，因為我這裡不想要加上sort_id的欄位
public  function switch_key($source_id, $dest_id)
{
	//global $this->data['session_name'];

	// 先備份
	$source = $_SESSION[$this->data['session_name']][$source_id];
	$dest = $_SESSION[$this->data['session_name']][$dest_id];

	if($source['pid'] == $dest['pid'] and $source['pos'] != $dest['pos']){
		/*
		 * POS交換
		 */
		$_SESSION[$this->data['session_name']][$source_id]['pos'] = $dest['pos'];
		$_SESSION[$this->data['session_name']][$dest_id]['pos'] = $source['pos'];
	} else {
		/*
		 * 本層互換
		 */

		// 覆蓋
		$_SESSION[$this->data['session_name']][$source_id] = $dest;
		$_SESSION[$this->data['session_name']][$dest_id] = $source;

		/*
		 * 整串互換
		 */

		// 把來源的pid都加上x
		foreach($_SESSION[$this->data['session_name']] as $k => $v){
			if($v['pid'] == $source_id){
				$_SESSION[$this->data['session_name']][$k]['pid'] .= 'x';
			}
		}

		foreach($_SESSION[$this->data['session_name']] as $k => $v){
			if($v['pid'] == $dest_id){
				$_SESSION[$this->data['session_name']][$k]['pid'] = $source_id;
			}
		}

		foreach($_SESSION[$this->data['session_name']] as $k => $v){
			if(preg_match('/x/', $v['pid'])){
				$_SESSION[$this->data['session_name']][$k]['pid'] = $dest_id;
			}
		}
	}
}

// Layout V2
// 後台在使用的
public function actionDemopreview($type_backend)
{
	$_GET['key'] = '0';
	$_GET['pos'] = '1';
	//$_GET['type_backend'] = 'Bbox';

	$this->data['session_name'] = 'winnie_layout_v2';
	$this->data['editmode'] = true;

	//include _BASEPATH.ds('/web').'/views/layoutv2/toolbar_preview.php';

	include Yii::getPathOfAlias('system.frontend.views.layoutv2').'/toolbar_preview.php';

	$_content = '';
	if(isset($current_return_backend)){
		$_content = $current_return_backend;
	}

	$_content .= '<hr /><br /><pre>'.str_replace('<', '&lt;', str_replace('>', '&gt;', $_content)).'</pre>';

	// 就…安全性而以
	//if(isset($this->data['admin_id']) and $this->data['admin_id'] != ''){
	//	include _BASEPATH.ds('/web').'/views/layoutv2/main.php';
	//}
	if(file_exists(Yii::getPathOfAlias('application.views.layoutv2').'/main.php')){
		include Yii::getPathOfAlias('application').'/views/layoutv2/main.php';
	} else {
		include $layout_v2_main = Yii::getPathOfAlias('system.frontend.views.layoutv2').'/main.php';
	}
	die;
}

/*
 * 以下這一大堆都是Layout V2在使用的
 */

public function actionLayout1()	{}
public function actionLayout2() {}
public function actionLayout3() {}
public function actionLayout4() {}
public function actionLayout5() {}
public function actionLayout6() {}

public function actionDemolayout1()	{}
public function actionDemolayout2()	{}
public function actionDemolayout3()	{}
public function actionDemolayout4()	{}
public function actionDemolayout5()	{}
public function actionDemolayout6()	{}

public function actionDemogroup() {}

// 展示己存在頁面的指定key的位置上的東西
public function actionDemosection() {}

// 純展示區塊
public function actionDemosection2() {}

// 展示某個編號底下(含)的東西
public function actionDemosection3() {}

public function actionDownloaddetail($id)
{
	$row = $this->db->createCommand()->from('html')->where('is_enable=1 and id=:id',array(':id'=>$id))->queryRow();
	$file = '_i/assets/file/download/'.$row['file1'];

	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename='.basename($file));
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . filesize($file));
	readfile($file);
}

public function actionProductsearch()
{
	if(!isset($_POST['keyword'])){
		unset($_SESSION['productsearch_'.$this->data['ml_key']]);
	} else {
		$_SESSION['productsearch_'.$this->data['ml_key']] = $_POST['keyword'];
	}
	$this->redirect($this->createUrl('site/product'));
}

public function actionProductinquirydelete($id)
{
	if(isset($_SESSION['productinquiry'][$id])){
		unset($_SESSION['productinquiry'][$id]);
	}
	$this->redirect($this->createUrl('site/productinquiry'));
}

public function actionProductinquiry()
{
	if(empty($_POST)){
	} else {
		// 這裡的程式碼是由連絡我們那邊複製過來的
		
		if(!isset($_POST['captcha']) or Yii::app()->session['captcha'] != $_POST['captcha']){
			$redirect_url = $this->createUrl('site/productinquiry', array('status' => '2'));
			G::alert_and_redirect(G::t(null,'驗證碼錯誤'), $redirect_url, $this->data);
		}

		// 安全性
		Yii::app()->session['captcha'] = '';
		$_POST['captcha'] = '';

		$savedata = $_POST;

		if($_SESSION['productinquiry'] and count($_SESSION['productinquiry']) > 0){
			$savedata['detail'] .= "\n\n".'洽詢商品：'."\n";
			foreach($_SESSION['productinquiry'] as $k => $v){
				$row = $this->db->createCommand()->from('html')->where('is_enable=1 and id='.$k)->queryRow();
				if($row and isset($row['id'])){
					$savedata['detail'] .= "\n\r <a href=\"/index.php?r=site/productdetail&id2=".$row['id']."&id=".$row['class_id']."\" target=\"_BLACK\"><img src=\"/_i/assets/upload/product/".$row['pic1']."\" alt=\"products name\" style=\"width: 50px;\">".$row['topic']."</a>\n\r";
				}
			}
		}

		$empty_orm_data = array(
			'table' => 'product_inquiry',
			'created_field' => 'create_time', 
			//'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				array('name, phone, email', 'required'),
			),
		);

		//$c = new Empty_orm('insert', $empty_orm_data);
		////$c->autoaddcolumn($savedata);
		//$c->setAttributes($savedata);
		//$c->save();

		// 寫入驗證碼到該會員資料表
		eval($this->data['empty_orm_eval']);
		$u = new $name('insert', $empty_orm_data);
		// 修改專用
		//$u = $c::model()->findByPk($row['id']);
		$u->setAttributes($savedata);
		if(!$u->save()){
			G::dbm($u->getErrors());
		}

		/*
		 * 載入後台的連絡我們，欄位的中文之接對應和取用
		 */
		//$contentx = file_get_contents(_BASEPATH.ds('/backend').ds('/controllers/').'ContactuswebController.php');
		$contentx = file_get_contents(Yii::getPathOfAlias('system').ds('/backend').ds('/controllers/').'ContactuswebController.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		$contentx = str_replace('extends Controller', '', $contentx);
		$contentx = str_replace('protected $def', 'static public $def', $contentx);
		eval($contentx);
		$admin_def = ContactuswebController::$def;
		$admin_field = $admin_def['updatefield']['sections'][0]['field'];

		$to = $this->data['sys_configs']['service_admin_mail'];

		// 主旨
		//$subject = $this->data['sys_configs']['admin_title'].' Contact Us 客戶聯絡信件';
		$subject = $this->data['sys_configs']['admin_title'].' 商品洽詢信件';

		$aaa_url = aaa_url;
		$aaa_name = $this->data['sys_configs']['admin_title'];

		$body = '此信為系統發出，請勿回覆'."\n\n";
		//$body .= '123';


		$body_html_content = '';
		if(count($admin_field) > 0){
			foreach($admin_field as $k => $v){
				if(isset($savedata[$k])){
					$field_name = '';
					if(isset($v['mlabel'][3]) and $v['mlabel'][3] != ''){
						$field_name = $v['mlabel'][3];
					}
					if(isset($v['label']) and $v['label'] != ''){
						$field_name = $v['label'];
					}
					$body .= $field_name.': '.strip_tags($savedata[$k])."\n";
					ob_start();
					if($k%2 == 0){
?>
<tr bgcolor="#FBF0BD">
	<td align="right"><p align="right"><?php echo $field_name?><br />
	</p></td>
	<td width="300"><?php echo strip_tags($savedata[$k])?></td>
</tr>
<? } else { ?>		
<tr bgcolor="#FFFFFF">
	<td align="right"><p align="right"><?php echo $field_name?><br />
	</p></td>
	<td width="300"><?php echo strip_tags($savedata[$k])?></td>
</tr>
<?php 
					}
					$body_html_content .= ob_get_clean();
				}
			}
		}

		$admin_field = $admin_def['updatefield']['sections'][1]['field'];
		if(count($admin_field) > 0){
			foreach($admin_field as $k => $v){
				if(isset($savedata[$k])){
					$field_name = '';
					if(isset($v['mlabel'][3]) and $v['mlabel'][3] != ''){
						$field_name = $v['mlabel'][3];
					}
					if(isset($v['label']) and $v['label'] != ''){
						$field_name = $v['label'];
					}
					$body .= $field_name.': '.strip_tags($savedata[$k])."\n";
					ob_start();
					if($k%2 == 0){
?>
<tr bgcolor="#FBF0BD">
	<td align="right"><p align="right"><?php echo $field_name?><br />
	</p></td>
	<td width="300"><?php echo strip_tags($savedata[$k])?></td>
</tr>
<? } else { ?>		
<tr bgcolor="#FFFFFF">
	<td align="right"><p align="right"><?php echo $field_name?><br />
	</p></td>
	<td width="300"><?php echo strip_tags($savedata[$k])?></td>
</tr>
<?php 
					}
					$body_html_content .= ob_get_clean();
				}
			}
		}

		$body_html = <<<XXX
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="0" cellpadding="4" cellspacing="1" bordercolorlight="#ffffff" bordercolordark="#666666" bgcolor="#CCCCCC" >
$body_html_content
</table>
<p style="font-size:13px;color:#999">$aaa_name $aaa_url</p>
XXX;

		//protected function email_send_to($to, $subject, $body, $body_html)

		// 找一下寄件人有沒有設定
		$from = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_home=1',array(':type'=>'email',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryRow();

		// 找一下收件人有沒有設定
		$tos = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_news=1',array(':type'=>'email',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();

		if($from and count($from) > 0 and isset($from['id']) and isset($from['email'])
			and $tos and count($tos) > 0 and isset($tos[0]['id'])){
			if(isset($this->data['sys_configs']['smtp_ssl']) and $this->data['sys_configs']['smtp_ssl'] == 'sendmail'){
				$this->email_send_to_by_sendmail($from,$tos, $subject, $body, $body_html);
			} else {
				$this->email_send_to_v2($from,$tos, $subject, $body, $body_html);
			}
		} else {	
			$this->email_send_to($to, $subject, $body, $body_html);
		}

		$redirect_url = $this->createUrl('site/product');

		unset($_SESSION['productinquiry']);

		G::alert_and_redirect(G::t(null,'送出成功'), $redirect_url, $this->data);
	}
}

public function actionInquiry($id = 0, $amount = 1)
{
	if($id > 0){
		if(!isset($_SESSION['productinquiry'])){
			$_SESSION['productinquiry'] = array();
		}
		$_SESSION['productinquiry'][$id] = $amount;
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript">
alert('<?php echo G::t(null,'加入詢問車')?>');
//history.back();
location.href="index.php?r=site/productinquiry";
</script>
<?php
		die;
	}
}

public function actionContact($page=0)
{
	if(empty($_POST)){
	} else {

		if(!isset($_POST['captcha']) or Yii::app()->session['captcha'] != $_POST['captcha']){
			$redirect_url = $this->createUrl('site/contact', array('status' => '2'));
			G::alert_and_redirect(G::t(null,'驗證碼錯誤'), $redirect_url, $this->data);
		}

		// 安全性
		Yii::app()->session['captcha'] = '';
		$_POST['captcha'] = '';

		$savedata = $_POST;

		$empty_orm_data = array(
			'table' => 'contactus_web',
			'created_field' => 'create_time', 
			//'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				array('name, phone, email', 'required'),
			),
		);

		//$c = new Empty_orm('insert', $empty_orm_data);
		////$c->autoaddcolumn($savedata);
		//$c->setAttributes($savedata);
		//$c->save();

		// 寫入驗證碼到該會員資料表
		eval($this->data['empty_orm_eval']);
		$u = new $name('insert', $empty_orm_data);
		// 修改專用
		//$u = $c::model()->findByPk($row['id']);
		$u->setAttributes($savedata);
		if(!$u->save()){
			G::dbm($u->getErrors());
		}

		/*
		 * 載入後台的連絡我們，欄位的中文之接對應和取用
		 */
		//$contentx = file_get_contents(_BASEPATH.ds('/backend').ds('/controllers/').'ContactuswebController.php');
		$contentx = file_get_contents(Yii::getPathOfAlias('system').ds('/backend').ds('/controllers/').'ContactuswebController.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		$contentx = str_replace('extends Controller', '', $contentx);
		$contentx = str_replace('protected $def', 'static public $def', $contentx);
		eval($contentx);
		$admin_def = ContactuswebController::$def;
		$admin_field = $admin_def['updatefield']['sections'][0]['field'];

		// 寄件人、網站管理者Mail
		$to = $this->data['sys_configs']['service_admin_mail'];

		// 主旨
		$subject = $this->data['sys_configs']['admin_title'].' Contact Us 客戶聯絡信件';

		$aaa_url = aaa_url;
		$aaa_name = $this->data['sys_configs']['admin_title'];

		$body = '此信為系統發出，請勿回覆'."\n\n";
		//$body .= '123';


		$body_html_content = '';
		if(count($admin_field) > 0){
			foreach($admin_field as $k => $v){
				if(isset($savedata[$k])){
					$field_name = '';
					if(isset($v['mlabel'][3]) and $v['mlabel'][3] != ''){
						$field_name = $v['mlabel'][3];
					}
					if(isset($v['label']) and $v['label'] != ''){
						$field_name = $v['label'];
					}
					$body .= $field_name.': '.strip_tags($savedata[$k])."\n";
					ob_start();
					if($k%2 == 0){
?>
<tr bgcolor="#FBF0BD">
	<td align="right"><p align="right"><?php echo $field_name?><br />
	</p></td>
	<td width="300"><?php echo strip_tags($savedata[$k])?></td>
</tr>
<? } else { ?>		
<tr bgcolor="#FFFFFF">
	<td align="right"><p align="right"><?php echo $field_name?><br />
	</p></td>
	<td width="300"><?php echo strip_tags($savedata[$k])?></td>
</tr>
<?php 
					}
					$body_html_content .= ob_get_clean();
				}
			}
		}

		$admin_field = $admin_def['updatefield']['sections'][1]['field'];
		if(count($admin_field) > 0){
			foreach($admin_field as $k => $v){
				if(isset($savedata[$k])){
					$field_name = '';
					if(isset($v['mlabel'][3]) and $v['mlabel'][3] != ''){
						$field_name = $v['mlabel'][3];
					}
					if(isset($v['label']) and $v['label'] != ''){
						$field_name = $v['label'];
					}
					$body .= $field_name.': '.strip_tags($savedata[$k])."\n";
					ob_start();
					if($k%2 == 0){
?>
<tr bgcolor="#FBF0BD">
	<td align="right"><p align="right"><?php echo $field_name?><br />
	</p></td>
	<td width="300"><?php echo strip_tags($savedata[$k])?></td>
</tr>
<? } else { ?>		
<tr bgcolor="#FFFFFF">
	<td align="right"><p align="right"><?php echo $field_name?><br />
	</p></td>
	<td width="300"><?php echo strip_tags($savedata[$k])?></td>
</tr>
<?php 
					}
					$body_html_content .= ob_get_clean();
				}
			}
		}

		$body_html = <<<XXX
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="0" cellpadding="4" cellspacing="1" bordercolorlight="#ffffff" bordercolordark="#666666" bgcolor="#CCCCCC" >
$body_html_content
</table>
<p style="font-size:13px;color:#999"">$aaa_name $aaa_url</p>
XXX;

		// 找一下寄件人有沒有設定
		$from = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_home=1',array(':type'=>'email',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryRow();

		// 找一下收件人有沒有設定
		$tos = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_news=1',array(':type'=>'email',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();

		if($from and count($from) > 0 and isset($from['id']) and isset($from['email'])
			and $tos and count($tos) > 0 and isset($tos[0]['id'])){
			if(isset($this->data['sys_configs']['smtp_ssl']) and $this->data['sys_configs']['smtp_ssl'] == 'sendmail'){
				$this->email_send_to_by_sendmail($from,$tos, $subject, $body, $body_html);
			} else {
				$this->email_send_to_v2($from,$tos, $subject, $body, $body_html);
			}
		} else {	
			$this->email_send_to($to, $subject, $body, $body_html);
		}

		$redirect_url = $this->createUrl('site/contact');

		G::alert_and_redirect(G::t(null,'送出成功'), $redirect_url, $this->data);

	}
}

public function actionCaptcha()
{
	$im = @ImageCreate (96, 25) or die ('Cannot Initialize new GD image stream'); 
	//$bgCol = array(
	//	array('R'=>250, 'G'=>250, 'B'=>250),
	//	array('R'=>251, 'G'=>251, 'B'=>251),
	//	array('R'=>252, 'G'=>252, 'B'=>252),
	//	array('R'=>253, 'G'=>253, 'B'=>253),
	//	array('R'=>254, 'G'=>254, 'B'=>254)
	//);
	//$n = round(rand(0, (count($bgCol)-1)));
	//$background_color = ImageColorAllocate ($im, $bgCol[$n]['R'], $bgCol[$n]['G'], $bgCol[$n]['B']);
	$background_color = ImageColorAllocate ($im, 221, 221, 221);
	$text_color = ImageColorAllocate ($im, 0, 0, 0);
	$num_color = array(
		ImageColorAllocate ($im, 128, 0, 0),
		ImageColorAllocate ($im, 0, 128, 0),
		ImageColorAllocate ($im, 0, 0, 128),
		ImageColorAllocate ($im, 255, 80, 0),
		ImageColorAllocate ($im, 0, 128, 80),
		ImageColorAllocate ($im, 0, 80, 255),
		ImageColorAllocate ($im, 255, 0, 80),
		ImageColorAllocate ($im, 80, 0, 255),
		ImageColorAllocate ($im, 128, 128, 0),
		ImageColorAllocate ($im, 0, 128, 128));

	// 將背景色(白色)
	// 改成透明(拿掉就變灰色了)
	$white = imagecolorallocate($im, 255, 255, 255);
	imagefill($im, 0, 0, $white);
	imagecolortransparent($im, $white);

	$line_color = ImageColorAllocate ($im, 128, 128, 128);
	$CheckStr = '0123456789';
	$font_file = array (
		//BASEPATH.DIRECTORY_SEPARATOR.'fonts'.DIRECTORY_SEPARATOR.'oneway.ttf',
		//BASEPATH.DIRECTORY_SEPARATOR.'fonts'.DIRECTORY_SEPARATOR.'arcade_r.ttf',
		//BASEPATH.DIRECTORY_SEPARATOR.'fonts'.DIRECTORY_SEPARATOR.'colourmepurple.ttf',
		_BASEPATH.DIRECTORY_SEPARATOR.'fonts'.DIRECTORY_SEPARATOR.'haldanor.ttf',
	);
	// 旋轉角度
	$angel_set = array(0,2,4,6,8,10,12,14,16,18,20,-2,-4,-6,-8,-10,-12,-14,-16,-18,-20);
	$SCode = '';
	for($i=0; $i<4; $i++) {
		srand((double)microtime()*1000000); 
		$rndFont = (rand() % count($font_file));
		srand((double)microtime()*1000000); 
		$dd = (rand() % strlen($CheckStr));
		srand((double)microtime()*1000000); 
		$aa = (rand() % count($angel_set));
		$ckChar = substr($CheckStr, $dd, 1);
		$SCode .= $ckChar;
		$N_color = (rand() % count($num_color));
		// 字型
		//ImageTTFText ($im, 18, $angel_set[$aa], 2+($i*rand(16, 18)), 20, $num_color[$N_color], $font_file[$rndFont], $ckChar); 
		ImageTTFText ($im, 20, $angel_set[$aa], 8+($i*rand(20, 23)), 22, $num_color[$N_color], $font_file[$rndFont], $ckChar);
	}

	Yii::app()->session['captcha'] = $SCode;

    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
    header("Cache-Control: no-store, no-cache, must-revalidate"); 
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
	header('Content-type: image/png');
	imagepng ($im);
	imagedestroy ($im);
	exit();
}

} // Layoutv2 Class end
