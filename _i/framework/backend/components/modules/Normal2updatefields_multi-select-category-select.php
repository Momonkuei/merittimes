<?php

class XXXXXXXX_A extends XXXXXXXX_B
{

	public function actionUpdatefields_multi_select_category_select_dropdown()
	{
        if(!empty($_POST)){
			$this->data['def'] = G::definit($this->def, $this->data);

			$random = $_POST['random']; // 為了可以多個視窗操作，操作SESSION不會出問題的寫法
			$class_id = $_POST['id'];

			// 已選的
			$select_ids = array();
			if(isset($_SESSION['updatefields_multi-select-category-select'][$this->data['router_class']][$random]) and !empty($_SESSION['updatefields_multi-select-category-select'][$this->data['router_class']][$random])){
				foreach($_SESSION['updatefields_multi-select-category-select'][$this->data['router_class']][$random] as $k => $v){
					$select_ids[] = $k;
				}
			}

			$in = '';
			if(!empty($select_ids)){
				$in = ' or id in ('.implode(',',$select_ids).') ';
			}

			//2021/07/06 指定語系資料 by lota add
			$_ml_key = $this->data['ml_key'];
			if(isset($_POST['_ml_key'])){
				$_ml_key = $_POST['_ml_key'];
			}

			$sql = 'select * from '.str_replace('type','',$this->data['def']['table']).' where is_enable=1 and ml_key="'.$_ml_key.'" and (class_id='.$class_id.' or class_ids like "%,'.$class_id.',%" '.$in.') ';
			$rows = $this->cidb->query($sql)->result_array();

			$return = '';
			if($rows and !empty($rows)){
				foreach($rows as $k => $v){
					$selected = '';
					if(in_array($v['id'],$select_ids)){
						$selected = ' selected="selected" ';
					}
					$return .= '<option value="'.$v['id'].'" '.$selected.' >'.$v['name'].'</option>';
				}
			}

			echo $return;
			die;
		}
	}

	public function actionUpdatefields_multi_select_category_select_save()
	{
        if(!empty($_POST)){
			$this->data['def'] = G::definit($this->def, $this->data);

			// $field = $_POST['field']; // related_ids
			$action = $_POST['action']; // add, del, get
			$random = $_POST['random']; // 為了可以多個視窗操作，操作SESSION不會出問題的寫法
			$id = $_POST['id'];

			if(preg_match('/^(add|del|get)$/', $action)){
				if(!isset($_SESSION['updatefields_multi-select-category-select'][$this->data['router_class']][$random])){
					$_SESSION['updatefields_multi-select-category-select'][$this->data['router_class']][$random] = array();
				}

				if($action == 'add'){
					$_SESSION['updatefields_multi-select-category-select'][$this->data['router_class']][$random][$id] = '1';
				} elseif($action == 'del'){
					unset($_SESSION['updatefields_multi-select-category-select'][$this->data['router_class']][$random][$id]);
				} elseif($action == 'get'){
					$return = array();
					if(isset($_SESSION['updatefields_multi-select-category-select'][$this->data['router_class']][$random]) and !empty($_SESSION['updatefields_multi-select-category-select'][$this->data['router_class']][$random])){
						foreach($_SESSION['updatefields_multi-select-category-select'][$this->data['router_class']][$random] as $k => $v){
							$return[] = (string)$k;
						}
					}
					echo json_encode($return);
				}

				// debug
				// var_dump($_SESSION['updatefields_multi-select-category-select'][$this->data['router_class']][$random]);

			} // action

			die;
		}
	}

}
