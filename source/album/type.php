<?php

//設定分頁基本參數 要記得在view那邊加入分頁的view
$pagew = 0;
if(isset($_GET['page']) and $_GET['page'] > 0){
	$pagew = $_GET['page'];
}
$limit_count = 12;//一頁顯示幾筆
$_GET['current_page'] = $pagew;
$DataList = array();
$pageRecordInfo = array();
$db = new Mysqleric(array('table'=>'html'));

// ■  密碼鎖：可針對個別相簿執行密碼上鎖
// 預設這個功能是關閉的，這是加價購的功能
if(0){
	$media_password = '';
	if(isset($_SESSION['media_password']) and $_SESSION['media_password'] != ''){
		$media_password = $_SESSION['media_password'];
	}
	// 在啟用這個功能的時候，在還沒有登入前，預設會搜尋亂數密碼，也就是永遠都搜尋不到
	if($media_password == ''){
		$media_password = G::GeraHash(10);
	}
}

unset($_constant);
eval('$_constant = '.strtoupper($this->data['router_method'].'_type_later').';');
if($_constant == 1){ // 有分類

	// 通用分類列表
	if(!isset($_GET['id'])){
		//使用分頁列表
		$url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php?page=';
		$qryField = '*';
		$qryWhere = ' WHERE is_enable=1 and type=\''.$this->data['router_method'].'type\' and ml_key=\''.$this->data['ml_key'].'\'';	

		if(isset($media_password)){
			// 用多個密碼欄位的方式撰寫，但實際只有一個
			// $qryWhere .= ' and ( other1="'.$media_password.'" or other1="'.$media_password.'" ) ';
			$qryWhere .= ' and other1="'.$media_password.'" ';
		}

		$qryWhere .=' order by sort_id';


		// 使用縮圖前的準備
		// $path = 'webroot._i.assets.thumb.'.str_replace('detail','',$this->data['router_method']);
		// $ggg2 = array();
		// if(is_dir(Yii::getPathOfAlias($path))){
		// 	$ggg2 = $this->_getFiles(Yii::getPathOfAlias($path));
		// }

		$db->getData($qryField, $qryWhere, (int)$limit_count);
		if($db->total_row > 0) {
			$DataCount = $db->total_row;
			do{
				if($db->row['update_time'] == '0000-00-00 00:00:00'){
					$db->row['update_time'] = '';
				} else {
					$db->row['update_time'] = date('Y/m/d', strtotime($db->row['update_time']));
				}
				$db->row['url1'] = $db->row['url2'] = $this->data['router_method'].'detail_'.$this->data['ml_key'].'.php?id='.$db->row['id'];
				$db->row['pic'] = '_i/assets/upload/'.$this->data['router_method'].'type/'.$db->row['pic1'];

				// 如果有縮圖，就使用縮圖
				// if($ggg2){
				// 	foreach($ggg2 as $k => $v){
				// 		$ggg3 = explode('_',$v);
				// 		if($db->row['pic1'] == $ggg3[count($ggg3)-1]){
				// 			$db->row['pic'] = str_replace($_SERVER['DOCUMENT_ROOT'],'',$v);
				// 			break;
				// 		}
				// 	}
				// }

				$db->row['name'] = $db->row['topic'];
				//$db->row['content'] = $db->row['detail'];
				$db->row['year'] = date('Y', strtotime($db->row['create_time']));
				$db->row['month'] = date('F', strtotime($db->row['create_time']));
				$db->row['day'] = date('d', strtotime($db->row['create_time']));
				
				// if(is_dir(_BASEPATH.'/assets/members/'.$this->data['router_method'].$db->row['id'].'/member'))
				// 	$tmps = $this->_getFiles(_BASEPATH.'/assets/members/'.$this->data['router_method'].$db->row['id'].'/member');
				// $db->row['count'] = count($tmps);

				$tmps = $this->cidb->select('id')->where('is_enable',1)->where('type','album')->where('ml_key',$this->data['ml_key'])->where('class_id',$db->row['id'])->get('html')->result_array();
				$db->row['count'] = count($tmps);

				$DataList[] = $db->row;
			}while($db->row = $db->result->fetch_assoc());
			$pageRecordInfo = $db->get_page_bar($url);
			$pageBar = $db->record_info();
		}
		$data[$ID] = $DataList;
	} else {

	// 如果是分類，但沒有帶分類編號，那自動會轉去第一個
	if(0 and !isset($_GET['id'])){
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

	// if(isset($_GET['id'])){

		// 先看一下分類是否存在
		$tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and id=:id',array(':type'=>$this->data['router_method'].'type',':ml_key'=>$this->data['ml_key'],':id'=>$_GET['id']))->queryRow();
		if($tmp and isset($tmp) and isset($tmp['id'])){
			// do nothing
		} else {
			//header('Location: index_'.$this->data['ml_key'].'.php');
			//使用分頁列表，總經理建議這樣處理 by lota 2017/10/20
			$url = $url_prefix.$this->data['router_method'].$url_suffix.'?page=';
			$qryField = '*';
			$qryWhere = ' WHERE is_enable=1 and type=\''.$this->data['router_method'].'\' and ml_key=\''.$this->data['ml_key'].'\'';	

			if(isset($media_password)){
				// 用多個密碼欄位的方式撰寫，但實際只有一個
				$qryWhere .= ' and ( other2="'.$media_password.'" or other2="'.$media_password.'" ) ';
			}

			$qryWhere .=' order by sort_id';


			// 使用縮圖前的準備
			$path = 'webroot._i.assets.thumb.'.str_replace('detail','',$this->data['router_method']);
			$ggg2 = array();
			if(is_dir(Yii::getPathOfAlias($path))){
				$ggg2 = $this->_getFiles(Yii::getPathOfAlias($path));
			}

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

					// 如果有縮圖，就使用縮圖
					if($ggg2){
						foreach($ggg2 as $k => $v){
							$ggg3 = explode('_',$v);
							if($db->row['pic1'] == $ggg3[count($ggg3)-1]){
								$db->row['pic'] = str_replace($_SERVER['DOCUMENT_ROOT'],'',$v);
								break;
							}
						}
					}

					$db->row['name'] = $db->row['topic'];
					//$db->row['content'] = $db->row['detail'];
					$db->row['year'] = date('Y', strtotime($db->row['create_time']));
					$db->row['month'] = date('F', strtotime($db->row['create_time']));
					$db->row['day'] = date('d', strtotime($db->row['create_time']));
					
					if(is_dir(_BASEPATH.'/assets/members/'.$this->data['router_method'].$db->row['id'].'/member'))
						$tmps = $this->_getFiles(_BASEPATH.'/assets/members/'.$this->data['router_method'].$db->row['id'].'/member');
					$db->row['count'] = count($tmps);

					$DataList[] = $db->row;
				}while($db->row = $db->result->fetch_assoc());
				$pageRecordInfo = $db->get_page_bar($url);
				$pageBar = $db->record_info();
			}
			$data[$ID] = $DataList;
		}

		$class_id = intval($_GET['id']);
		//使用分頁列表
		$url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php?id='.$class_id.'&page=';
		$qryField = '*';
		$qryWhere = ' WHERE is_enable=1 and type=\''.$this->data['router_method'].'\' and ml_key=\''.$this->data['ml_key'].'\' ';

		if(isset($media_password)){
			// 用多個密碼欄位的方式撰寫，但實際只有一個
			$qryWhere .= ' and ( other2="'.$media_password.'" or other2="'.$media_password.'" ) ';
		}

		//搜尋哪個分類
		$qryWhere .=' and class_id='.$class_id;

		$qryWhere .=' order by sort_id';

		// 使用縮圖前的準備
		$path = 'webroot._i.assets.thumb.'.str_replace('detail','',$this->data['router_method']);
		$ggg2 = array();
		if(is_dir(Yii::getPathOfAlias($path))){
			$ggg2 = $this->_getFiles(Yii::getPathOfAlias($path));
		}

		$db->getData($qryField, $qryWhere, (int)$limit_count);
		if($db->total_row > 0) {
			$DataCount = $db->total_row;
			do{
				if($db->row['update_time'] == '0000-00-00 00:00:00'){
					$db->row['update_time'] = '';
				} else {
					$db->row['update_time'] = date('Y/m/d', strtotime($db->row['update_time']));
				}
				$db->row['url1'] = $db->row['url2'] = $this->data['router_method'].'detail_'.$this->data['ml_key'].'.php?id='.$db->row['id'];
				$db->row['pic'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$db->row['pic1'];

				// 如果有縮圖，就使用縮圖
				if($ggg2){
					foreach($ggg2 as $kk => $vv){
						$ggg3 = explode('_',$vv);
						if($db->row['pic1'] == $ggg3[count($ggg3)-1]){
							$db->row['pic'] = str_replace($_SERVER['DOCUMENT_ROOT'],'',$vv);
							break;
						}
					}
				}

				$db->row['name'] = $db->row['topic'];
				//$db->row['content'] = $db->row['detail'];
				$db->row['year'] = date('Y', strtotime($db->row['create_time']));
				$db->row['month'] = date('F', strtotime($db->row['create_time']));
				$db->row['day'] = date('d', strtotime($db->row['create_time']));

				if(is_dir(_BASEPATH.'/assets/members/'.$this->data['router_method'].$db->row['id'].'/member'))
					$tmps = $this->_getFiles(_BASEPATH.'/assets/members/'.$this->data['router_method'].$db->row['id'].'/member');
				$db->row['count'] = count($tmps);

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
	}
} elseif($_constant == 0){ // 無分類，但是有相簿 (相簿分項)

	//使用分頁列表
	$url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php?page=';
	$qryField = '*';
	$qryWhere = ' WHERE is_enable=1 and type=\''.$this->data['router_method'].'\' and ml_key=\''.$this->data['ml_key'].'\'';	

	if(isset($media_password)){
		// 用多個密碼欄位的方式撰寫，但實際只有一個
		$qryWhere .= ' and ( other2="'.$media_password.'" or other2="'.$media_password.'" ) ';
	}

	$qryWhere .=' order by sort_id';


	// 使用縮圖前的準備
	$path = 'webroot._i.assets.thumb.'.str_replace('detail','',$this->data['router_method']);
	$ggg2 = array();
	if(is_dir(Yii::getPathOfAlias($path))){
		$ggg2 = $this->_getFiles(Yii::getPathOfAlias($path));
	}

	$db->getData($qryField, $qryWhere, (int)$limit_count);
	if($db->total_row > 0) {
		$DataCount = $db->total_row;
		do{
			if($db->row['update_time'] == '0000-00-00 00:00:00'){
				$db->row['update_time'] = '';
			} else {
				$db->row['update_time'] = date('Y/m/d', strtotime($db->row['update_time']));
			}
			$db->row['url1'] = $db->row['url2'] = $this->data['router_method'].'detail_'.$this->data['ml_key'].'.php?id='.$db->row['id'];
			$db->row['pic'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$db->row['pic1'];

			// 如果有縮圖，就使用縮圖
			if($ggg2){
				foreach($ggg2 as $k => $v){
					$ggg3 = explode('_',$v);
					if($db->row['pic1'] == $ggg3[count($ggg3)-1]){
						$db->row['pic'] = str_replace($_SERVER['DOCUMENT_ROOT'],'',$v);
						break;
					}
				}
			}

			$db->row['name'] = $db->row['topic'];
			//$db->row['content'] = $db->row['detail'];
			$db->row['year'] = date('Y', strtotime($db->row['create_time']));
			$db->row['month'] = date('F', strtotime($db->row['create_time']));
			$db->row['day'] = date('d', strtotime($db->row['create_time']));
			
			if(is_dir(_BASEPATH.'/assets/members/'.$this->data['router_method'].$db->row['id'].'/member'))
				$tmps = $this->_getFiles(_BASEPATH.'/assets/members/'.$this->data['router_method'].$db->row['id'].'/member');
			$db->row['count'] = count($tmps);

			$DataList[] = $db->row;
		}while($db->row = $db->result->fetch_assoc());
		$pageRecordInfo = $db->get_page_bar($url);
		$pageBar = $db->record_info();
	}
	$data[$ID] = $DataList;

} elseif($_constant == 2){ // 無限層
	// 如果是分類，但沒有帶分類編號，那自動會轉去第一個大分類的第一個小分類
	if(!isset($_GET['id'])){
		$tmp = $this->db->createCommand()->from($this->data['router_method'].'multitype')->where('is_enable=1 and pid=0 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryRow();
		$tmp2 = $this->db->createCommand()->from($this->data['router_method'].'multitype')->where('is_enable=1 and pid='.$tmp['id'].' and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryRow();
		header('Location: '.$this->data['router_method'].'_'.$this->data['ml_key'].'.php?id='.$tmp2['id']);
	}

	if(isset($_GET['id'])){

		$class_id = intval($_GET['id']);
		//使用分頁列表
		$url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php?id='.$class_id.'&page=';
		$qryField = '*';
		$qryWhere = ' WHERE is_enable=1 and type=\''.$this->data['router_method'].'\' and ml_key=\''.$this->data['ml_key'].'\' ';

		if(isset($media_password)){
			// 用多個密碼欄位的方式撰寫，但實際只有一個
			$qryWhere .= ' and ( other2="'.$media_password.'" or other2="'.$media_password.'" ) ';
		}

		//搜尋哪個分類
		$qryWhere .=' and class_id='.$class_id;

		$qryWhere .=' order by sort_id';

		// 使用縮圖前的準備
		$path = 'webroot._i.assets.thumb.'.str_replace('detail','',$this->data['router_method']);
		$ggg2 = array();
		if(is_dir(Yii::getPathOfAlias($path))){
			$ggg2 = $this->_getFiles(Yii::getPathOfAlias($path));
		}

		$db->getData($qryField, $qryWhere, (int)$limit_count);
		if($db->total_row > 0) {
			$DataCount = $db->total_row;
			do{
				if($db->row['update_time'] == '0000-00-00 00:00:00'){
					$db->row['update_time'] = '';
				} else {
					$db->row['update_time'] = date('Y/m/d', strtotime($db->row['update_time']));
				}
				$db->row['url1'] = $db->row['url2'] = $this->data['router_method'].'detail_'.$this->data['ml_key'].'.php?id='.$db->row['id'];
				$db->row['pic'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$db->row['pic1'];

				// 如果有縮圖，就使用縮圖
				if($ggg2){
					foreach($ggg2 as $k => $v){
						$ggg3 = explode('_',$v);
						if($db->row['pic1'] == $ggg3[count($ggg3)-1]){
							$db->row['pic'] = str_replace($_SERVER['DOCUMENT_ROOT'],'',$v);
							break;
						}
					}
				}

				$db->row['name'] = $db->row['topic'];
				//$db->row['content'] = $db->row['detail'];
				$db->row['year'] = date('Y', strtotime($db->row['create_time']));
				$db->row['month'] = date('F', strtotime($db->row['create_time']));
				$db->row['day'] = date('d', strtotime($db->row['create_time']));

				if(is_dir(_BASEPATH.'/assets/members/'.$this->data['router_method'].$db->row['id'].'/member'))
					$tmps = $this->_getFiles(_BASEPATH.'/assets/members/'.$this->data['router_method'].$db->row['id'].'/member');
				$db->row['count'] = count($tmps);

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
	}
}
