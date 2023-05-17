<?php

//設定分頁基本參數 要記得在view那邊加入分頁的view
$pagew = 0; // Mysqleric
// $pagew = 1; // Splitpage
if(isset($_GET['page']) and $_GET['page'] > 0){
	$pagew = $_GET['page'];
}
$limit_count = 5;//一頁顯示幾筆
$_GET['current_page'] = $pagew;
$DataList = array();
$pageRecordInfo = array();
$db = new Mysqleric(array('table'=>'html'));

// 1 有分類
// 2 沒分類
// unset($_constant);
// eval('$_constant = '.strtoupper($this->data['router_method'].'_show_type').';');
// if($_constant == 1){

$row = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_method'].'_'.$this->data['ml_key'].'.php', ':ml_key'=>$this->data['ml_key']))->queryRow();
if($row){

	$common_is_enable = $row['is_home'];
	$common_is_category = $row['pic2']; // 是或不是分類
	$common_category = $row['is_news']; // 是或不是通用分類
	$common_item = $row['class_ids'];   // 是或不是通用分項
	$common_date_sort = $row['pic3'];
	$common_articlesingle = $row['is_top']; // 單頁專用

	if($common_is_category == 1){ // 有分類
		if($common_category == 1){ // 是通用分類

			// 如果是分類，但沒有帶分類編號，以及沒有帶搜尋參數，那自動會轉去第一個
			if(!isset($_GET['id']) && !isset($_GET['q'])){
				$tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>$this->data['router_method'].'type',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryRow();
				$url = $url_prefix.$this->data['router_method'].$url_suffix.'?id='.$tmp['id'];

				if(1){
					header('Location: '.$url);
				} else {
					// A方案，含左側選單專用
?>
<script type="text/javascript">
	window.location.href='<?php echo $url?>';
</script>
<?php
				}
			}

			$admin_field_router_class = $this->data['router_method'];
			$admin_field_section_id = 1;
			include _BASEPATH.'/../source/system/admin_field_get.php';

			if(isset($_GET['id'])){

				// 先看一下分類是否存在
				$tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and id=:id',array(':type'=>$this->data['router_method'].'type',':ml_key'=>$this->data['ml_key'],':id'=>$_GET['id']))->queryRow();
				if($tmp and isset($tmp) and isset($tmp['id'])){
					// do nothing
				} else {
					//header('Location: index_'.$this->data['ml_key'].'.php');
					//使用分頁列表資料，總經理建議這樣處理 by lota 2017/10/20
					$url = $url_prefix.$this->data['router_method'].$url_suffix.'?page=';

					$qryField = '*';
					$qryWhere = ' WHERE is_enable=1 and  type=\''.$this->data['router_method'].'\' and ml_key=\''.$this->data['ml_key'].'\'';	

					$qryWhere .=' order by start_date desc';

					$db->getData($qryField, $qryWhere, (int)$limit_count);
					if($db->total_row > 0) {
						$DataCount = $db->total_row;
						do{
							if($db->row['update_time'] == '0000-00-00 00:00:00'){
								$db->row['update_time'] = '';
							} else {
								$db->row['update_time'] = date('Y/m/d', strtotime($db->row['update_time']));
							}
							$db->row['url1'] = $db->row['url2'] = $url_prefix.$this->data['router_method'].'detail'.$url_suffix.'?id='.$db->row['id'];
							$db->row['pic'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$db->row['pic1'];
							$db->row['name'] = $db->row['topic'];
							$db->row['content'] = $db->row['field_tmp'];
							$db->row['year'] = date('Y', strtotime($db->row['start_date']));
							$db->row['month'] = date('F', strtotime($db->row['start_date']));
							$db->row['day'] = date('d', strtotime($db->row['start_date']));
							$DataList[] = $db->row;
						}while($db->row = $db->result->fetch_assoc());
						$pageRecordInfo = $db->get_page_bar($url);
						$pageBar = $db->record_info();
					}
					$data[$ID] = $DataList;
				}

				$class_id = intval($_GET['id']);

				//使用分頁列表
				//$url = $this->createUrl($this->data['router_method'].'.php', array('id'=>$class_id,'page'=>''));
				//如果有用靜態網址的話... by lota 2019/11/26
				if(isset($_GET['type'])){					
					$url = $_SERVER['REDIRECT_URL'].'?page=';
				}else{
					$url = $url_prefix.$this->data['router_method'].$url_suffix.'?id='.$class_id.'&page=';
				}

				/*
				 * 用師父的方式撰寫
				 */
				$qryField = '*';
				$qryWhere = ' WHERE is_enable=1 and type=\''.$this->data['router_method'].'\' and ml_key=\''.$this->data['ml_key'].'\'';

				//搜尋哪個分類
				$qryWhere .=' and class_id='.$class_id;

				$qryWhere .=' order by start_date desc';

				$db->getData($qryField, $qryWhere, (int)$limit_count);
				if($db->total_row > 0) {
					$DataCount = $db->total_row;
					do{
						if($db->row['update_time'] == '0000-00-00 00:00:00'){
							$db->row['update_time'] = '';
						} else {
							$db->row['update_time'] = date('Y/m/d', strtotime($db->row['update_time']));
						}
						$db->row['url1'] = $db->row['url2'] = $url_prefix.$this->data['router_method'].'detail'.$url_suffix.'?id='.$db->row['id'];
						$db->row['pic'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$db->row['pic1'];
						$db->row['name'] = $db->row['topic'];
						$db->row['content'] = $db->row['field_tmp'];

						if(isset($admin_field['field_tmp']) and isset($admin_field['field_tmp']['type'])){
							if($admin_field['field_tmp']['type'] == 'textarea'){
								$db->row['content'] = nl2br($db->row['field_tmp']); // ckeditor_js 預設編輯器輸出
							}
						}

						$db->row['year'] = date('Y', strtotime($db->row['start_date']));
						$db->row['month'] = date('F', strtotime($db->row['start_date']));
						$db->row['day'] = date('d', strtotime($db->row['start_date']));
						$DataList[] = $db->row;
					}while($db->row = $db->result->fetch_assoc());
					$pageRecordInfo = $db->get_page_bar($url);
					$pageBar = $db->record_info();
				}
				$data[$ID] = $DataList;

				/*
				 * 2017-10-17
				 * 用後台的方式撰寫
				 */
				// $o = $this->cidb->select('id');
				// $o = $o->where('is_enable',1)->where('type',$this->data['router_method'])->where('class_id',$class_id)->where('ml_key',$this->data['ml_key']);
				// // $o = $o->where('class_id', $class_id);
				// $rows = $o->get('html')->result_array();
				// $total_rows = count($rows);

				// include 'source/core/pagination.php';

				// $o = $this->cidb;
				// $o = $o->where('is_enable',1)->where('type',$this->data['router_method'])->where('ml_key',$this->data['ml_key']);
				// $o = $o->where('class_id', $class_id);
				// $o = $o->order_by('start_date','desc');
				// // $o = $o->order_by('sort_id','asc');
				// $rows = $o->get('html', $limit_count, ($page-1) * $limit_count)->result_array();

				/*
				 * 2017-11-20
				 * 減化SQL語法
				 */
				// $where = array(
				// 	'is_enable' => 1,
				// 	'type' => $this->data['router_method'],
				// 	'ml_key' => $this->data['ml_key'],
				// 	'class_id' => $class_id,
				// );
				// $rows = $this->cidb->where($where)->get('html')->result_array();
				// $total_rows = count($rows);

				// include 'source/core/pagination.php';

				// $o = $this->cidb->where($where);
				// if($common_date_sort == 1){
				// 	$o = $o->order_by('start_date','desc');
				// } else {
				// 	$o = $o->order_by('sort_id','asc');
				// }
				// $rows = $o->get('html', $limit_count, ($page-1) * $limit_count)->result_array();

				// if($rows and count($rows) > 0){
				// 	foreach($rows as $k => $v){
				// 		if($v['update_time'] == '0000-00-00 00:00:00'){
				// 			$v['update_time'] = '';
				// 		} else {
				// 			$v['update_time'] = date('Y/m/d', strtotime($v['update_time']));
				// 		}
				// 		$v['url1'] = $v['url2'] = $this->data['router_method'].'detail_'.$this->data['ml_key'].'.php?id='.$v['id'];
				// 		$v['pic'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$v['pic1'];
				// 		$v['name'] = $v['topic'];
				// 		$v['content'] = $v['field_tmp'];
				// 		$v['year'] = date('Y', strtotime($v['start_date']));
				// 		$v['month'] = date('F', strtotime($v['start_date']));
				// 		$v['day'] = date('d', strtotime($v['start_date']));
				// 		$rows[$k] = $v;
				// 	}
				// 	$data[$ID] = $rows;
				// }

				// 分類名稱
				if(isset($layoutv3_struct_map_keyname['v3/category_title'][0])){
					$tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and id=:id',array(':type'=>$this->data['router_method'].'type',':id'=>$class_id))->queryRow();
					$data[$layoutv3_struct_map_keyname['v3/category_title'][0]] = array(
						'name' => $tmp['topic'],
						'sub_name' => $tmp['detail'],
					);
				}

			}
		} else { // 是獨立分類
			// 有用到，在去產品那邊複製就好了
		}

	} else { // 無分類

		//使用分頁列表
		$url = $url_prefix.$this->data['router_method'].$url_suffix.'?page=';

		/*
		 * 用師父的方式撰寫
		 */
		$qryField = '*';
		$qryWhere = ' WHERE is_enable=1 and  type=\''.$this->data['router_method'].'\' and ml_key=\''.$this->data['ml_key'].'\'';	

		$qryWhere .=' order by start_date desc';

		$db->getData($qryField, $qryWhere, (int)$limit_count);
		if($db->total_row > 0) {
			$DataCount = $db->total_row;
			do{
				if($db->row['update_time'] == '0000-00-00 00:00:00'){
					$db->row['update_time'] = '';
				} else {
					$db->row['update_time'] = date('Y/m/d', strtotime($db->row['update_time']));
				}
				$db->row['url1'] = $db->row['url2'] = $url_prefix.$this->data['router_method'].'detail'.$url_suffix.'?id='.$db->row['id'];
				$db->row['pic'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$db->row['pic1'];
				$db->row['name'] = $db->row['topic'];
				$db->row['content'] = $db->row['field_tmp'];
				$db->row['year'] = date('Y', strtotime($db->row['start_date']));
				$db->row['month'] = date('F', strtotime($db->row['start_date']));
				$db->row['day'] = date('d', strtotime($db->row['start_date']));
				$DataList[] = $db->row;
			}while($db->row = $db->result->fetch_assoc());
			$pageRecordInfo = $db->get_page_bar($url);
			$pageBar = $db->record_info();
		}
		$data[$ID] = $DataList;

		/*
		 * 2017-09-12 
		 * 試著用後台的分類來取代原有的作法
		 */
		// $o = $this->cidb->select('id');
		// $o = $o->where('is_enable',1)->where('type',$this->data['router_method'])->where('ml_key',$this->data['ml_key']);
		// // $o = $o->where('class_id', $class_id);
		// $rows = $o->get('html')->result_array();
		// $total_rows = count($rows);

		// include 'source/core/pagination.php';

		// $o = $this->cidb;
		// $o = $o->where('is_enable',1)->where('type',$this->data['router_method'])->where('ml_key',$this->data['ml_key']);
		// // $o = $o->where('class_id', $class_id);
		// // $o = $o->order_by('sort_id','asc');
		// $o = $o->order_by('start_date','desc');
		// $rows = $o->get('html', $limit_count, ($page-1) * $limit_count)->result_array();

		// if($rows and count($rows) > 0){
		// 	foreach($rows as $k => $v){
		//     	if($v['update_time'] == '0000-00-00 00:00:00'){
		//     		$v['update_time'] = '';
		//     	} else {
		//     		$v['update_time'] = date('Y/m/d', strtotime($v['update_time']));
		//     	}
		//     	$v['url1'] = $v['url2'] = $this->data['router_method'].'detail_'.$this->data['ml_key'].'.php?id='.$v['id'];
		//     	$v['pic'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$v['pic1'];
		//     	$v['name'] = $v['topic'];
		//     	$v['content'] = $v['field_tmp'];
		//     	$v['year'] = date('Y', strtotime($v['start_date']));
		//     	$v['month'] = date('F', strtotime($v['start_date']));
		//     	$v['day'] = date('d', strtotime($v['start_date']));
		// 		$rows[$k] = $v;
		// 	}
		// 	$data[$ID] = $rows;
		// }

		/*
		 * 2017-11-20
		 * 減化SQL語法
		 */
		// $where = array(
		// 	'is_enable' => 1,
		// 	'type' => $this->data['router_method'],
		// 	'ml_key' => $this->data['ml_key'],
		// 	'class_id' => $class_id,
		// );
		// $rows = $this->cidb->where($where)->get('html')->result_array();
		// $total_rows = count($rows);

		// include 'source/core/pagination.php';

		// $o = $this->cidb->where($where);
		// if($common_date_sort == 1){
		// 	$o = $o->order_by('start_date','desc');
		// } else {
		// 	$o = $o->order_by('sort_id','asc');
		// }
		// $rows = $o->get('html', $limit_count, ($page-1) * $limit_count)->result_array();

	}
}
