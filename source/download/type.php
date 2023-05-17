<?php

//  // 其它多筆
//  $tmps = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type',array(':type'=>'news'))->limit(3)->queryAll();
//  
//  // type2_1區塊專用的多筆
//  //$tmps = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type',array(':type'=>'company'))->order('create_time desc')->queryAll();
//  
//  if($tmps and count($tmps) > 0){
//  	foreach($tmps as $k => $v){
//  		$tmps[$k]['name'] = $v['topic'];
//  		$tmps[$k]['sub_name'] = '';
//  		$tmps[$k]['content'] = $v['detail'];
//  		$tmps[$k]['pic'] = '_i/assets/upload/company/'.$v['pic1'];
//  		//$tmps[$k]['year'] = date('Y', strtotime($v['start_date']));
//  		//$tmps[$k]['month'] = date('m', strtotime($v['start_date']));
//  		$tmps[$k]['year'] = date('Y', strtotime($v['create_time']));
//  		$tmps[$k]['month'] = date('m', strtotime($v['create_time']));
//  	}
//  }
//  $data[$ID] = $tmps;

//設定分頁基本參數 要記得在view那邊加入分頁的view
$pagew = 0;
if(isset($_GET['page']) and $_GET['page'] > 0){
	$pagew = $_GET['page'];
}
$limit_count = 6;//一頁顯示幾筆
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
if($row and isset($row['pic2']) and $row['pic2'] == 1){ // 有分類
	if(isset($row['is_news']) and $row['is_news'] == 1){ // 是通用分類

		// 如果是分類，但沒有帶分類編號，那自動會轉去第一個
		if(!isset($_GET['id'])){
			$tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>$this->data['router_method'].'type',':ml_key'=>$this->data['ml_key']))->order('start_date desc')->queryRow();
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

		if(isset($_GET['id'])){

			// 先看一下分類是否存在
			$tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and id=:id',array(':type'=>$this->data['router_method'].'type',':ml_key'=>$this->data['ml_key'],':id'=>$_GET['id']))->queryRow();
			if($tmp and isset($tmp) and isset($tmp['id'])){
				// do nothing
			} else {
				//header('Location: index_'.$this->data['ml_key'].'.php');
				//使用分頁列表，總經理建議這樣處理 by lota 2017/10/20
				$url = $url_prefix.$this->data['router_method'].$url_suffix.'?page=';
				$qryField = '*';
				$qryWhere = ' WHERE is_enable=1 and  type=\''.$this->data['router_method'].'\' and ml_key=\''.$this->data['ml_key'].'\'';	

				$qryWhere .=' order by sort_id';

				$db->getData($qryField, $qryWhere, (int)$limit_count);
				if($db->total_row > 0) {
					$DataCount = $db->total_row;
					do{
						if($db->row['update_time'] == '0000-00-00 00:00:00'){
							$db->row['update_time'] = '';
						} else {
							$db->row['update_time'] = date('Y/m/d', strtotime($db->row['update_time']));
						}
						//$db->row['url1'] = $db->row['url2'] = '_i/assets/file/'.$this->data['router_method'].'/'.$db->row['file1'];
						//2017/9/1 改圖片連結如果有輸入則帶入，若無則改用檔案下載連結 by lota
						$db->row['url2'] = '_i/assets/file/'.$this->data['router_method'].'/'.$db->row['file1'];
						$db->row['url1'] = ($db->row['url1'])?$db->row['url1']:$db->row['url2'];
						$db->row['pic'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$db->row['pic1'];
						$db->row['name'] = $db->row['topic'];
						$db->row['content'] = $db->row['detail'];
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
			$url = $url_prefix.$this->data['router_method'].$url_suffix.'?id='.$class_id.'&page=';
			$qryField = '*';
			$qryWhere = ' WHERE is_enable=1 and type=\''.$this->data['router_method'].'\' and ml_key=\''.$this->data['ml_key'].'\'';

			//搜尋哪個分類
			$qryWhere .=' and class_id='.$class_id;

			$qryWhere .=' order by sort_id';

			$db->getData($qryField, $qryWhere, (int)$limit_count);
			if($db->total_row > 0) {
				$DataCount = $db->total_row;
				do{
					if($db->row['update_time'] == '0000-00-00 00:00:00'){
						$db->row['update_time'] = '';
					} else {
						$db->row['update_time'] = date('Y/m/d', strtotime($db->row['update_time']));
					}

					// 檔案下載
					$db->row['url2'] = '_i/assets/file/'.$this->data['router_method'].'/'.$db->row['file1'];

					/*
					 * 型錄連結
					 */

					// 連結或是翻書
					// $db->row['url1'] = $db->row['url2'];

					// 一樣是檔案下載
					$db->row['url1'] = '_i/assets/file/'.$this->data['router_method'].'/'.$db->row['file1'];

					// 底下是額外的功能

					/*
					 * 需要密碼的下載 2016-12-28
					 * 會有記錄在經銷商的後台功能裡面
					 */
					// $db->row['url1'] = $db->row['url2'] = 'agent.php?id='.$db->row['id'];
					// if(isset($_SESSION['agent_id']) and $_SESSION['agent_id'] > 0){
					// 	// do nothing
					// } else {
					// 	$db->row['anchor1_data_target'] = '#loginPanel_normal';
					// 	$db->row['anchor1_class'] = 'openBtn ';

					// 	$db->row['anchor2_data_target'] = '#loginPanel_normal';
					// 	$db->row['anchor2_class'] = 'openBtn ';
					// }

					/*
					 * 需要記錄的下載 2017-04-20
					 */
					// $db->row['url1'] = $db->row['url2'] = 'record.php?id='.$db->row['id'];

					// cttdemo在使用的
					$tmps = explode('.', $db->row['file1']);
					$db->row['file_type'] = strtoupper($tmps[count($tmps)-1]);

					$db->row['pic'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$db->row['pic1'];
					$db->row['name'] = $db->row['topic'];
					$db->row['content'] = $db->row['detail'];
					$DataList[] = $db->row;
				}while($db->row = $db->result->fetch_assoc());
				$pageRecordInfo = $db->get_page_bar($url);
				$pageBar = $db->record_info();
			}
			$data[$ID] = $DataList;

			// 分類名稱
			if(isset($layoutv3_struct_map_keyname['v3/category_title'][0])){
				$tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and id=:id',array(':type'=>$this->data['router_method'].'type',':id'=>$class_id))->queryRow();
				$data[$layoutv3_struct_map_keyname['v3/category_title'][0]] = array(
					'name' => $tmp['topic'],
					'sub_name' => $tmp['detail'],
				);
			}

			// if($db->row['class_id'] != 0){
			// 	$tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and id=:id',array(':type'=>$this->data['router_method'].'type',':id'=>$db->row['class_id']))->queryRow();
			// 	$data['0-0_0-0_0-1-1-1-0'] = array(
			// 		'name' => $tmp['topic'],
			// 		'sub_name' => $tmp['detail'],
			// 	);
			// }

		}
	} else { // 是獨立分類
		// 有用到，在去產品那邊複製就好了
	}

} else { // 無分類

	//使用分頁列表
	$url = $url_prefix.$this->data['router_method'].$url_suffix.'?page=';
	$qryField = '*';
	$qryWhere = ' WHERE is_enable=1 and  type=\''.$this->data['router_method'].'\' and ml_key=\''.$this->data['ml_key'].'\'';	

	$qryWhere .=' order by sort_id';

	$db->getData($qryField, $qryWhere, (int)$limit_count);
	if($db->total_row > 0) {
		$DataCount = $db->total_row;
		do{
			if($db->row['update_time'] == '0000-00-00 00:00:00'){
				$db->row['update_time'] = '';
			} else {
				$db->row['update_time'] = date('Y/m/d', strtotime($db->row['update_time']));
			}
			//$db->row['url1'] = $db->row['url2'] = '_i/assets/file/'.$this->data['router_method'].'/'.$db->row['file1'];
			//2017/9/1 改圖片連結如果有輸入則帶入，若無則改用檔案下載連結 by lota
			$db->row['url2'] = '_i/assets/file/'.$this->data['router_method'].'/'.$db->row['file1'];
			$db->row['url1'] = ($db->row['url1'])?$db->row['url1']:$db->row['url2'];
			$db->row['pic'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$db->row['pic1'];
			$db->row['name'] = $db->row['topic'];
			$db->row['content'] = $db->row['detail'];
			$DataList[] = $db->row;
		}while($db->row = $db->result->fetch_assoc());
		$pageRecordInfo = $db->get_page_bar($url);
		$pageBar = $db->record_info();
	}
	$data[$ID] = $DataList;
	// $this->data['pageinfo'] = $pageRecordInfo;
}
