<?php

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		//'title' => 'ml:Product',
		'table' => 'product',
		'orm' => 'G_product_orm',
		'default_sort_field' => 'sort_id', // 預設要排序的欄位
		'search_keyword_field' => array('name_en'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'name_en', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'name_en', // 要給sys_log記錄名稱欄位值的設定
		'data_multilanguage' => false, // 是否有多國語系的資料
		'data_multilanguage_update' => 'model', // 在資料內頁中，切換多國語系，依照某一個欄位
		'sortable' => array(
			//'enable' => 'true',
			//'condition' => 'class_id = 0', // 有其它條件的時候，例如有商品分類
			'url' => 'backend.php?r=product/sort', // ajax post都會有個目標
		),
		// 建立前端要顯示的欄位
		'listfield_attr' => array(
			//'smarty_include_top' => 'product/main_content_top.htm',
		),
		'listfield' => array(
		), // listfield
		// 定義修改要顯示的欄位
		'updatefield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				'jquery-validate', 'fileuploader',
				//'jquery-validate', 'jquery-ui', 'fileuploader', 'javascript-sortable', 'jyoutube', //'jstree',
			),
			//'smarty_javascript' => 'product/update_javascript.htm',
			'method' => 'update',
			'form' => array(
				'enable' => true,
				'attr' => array(
					'id' => 'form_data',
					'name' => 'form_data',
					'method' => 'post',
					'action' => '',
					'enctype' => 'multipart/form-data',
				),
				'button_style' => '2',
			),
			'sections' => array(
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'field' => array(						
						'xx01a' => array(
							'label' => 'csv檔案匯入',
							'type' => 'inputn',
							'other' => array(
								'html' => '<input type="file" name="file1" id="file1" />',
							),
						),
						'xx' => array(
							'label' => 'csv檔案匯出',
							'type' => 'inputn',
							'other' => array(
								'html' => '<a href="backend.php?r=import/export" target="_BREAK">產品資料檔案</a>',
							),
						),
						'gg' => array(
							'label' => '&nbsp;',
							'type' => 'inputn',
							'other' => array(
								'html' => '&nbsp;',
							),
						),	

						// 'xx01a' => array(
						// 	'label' => 'Execl檔案匯入',
						// 	'type' => 'inputn',
						// 	'other' => array(
						// 		'html' => '<input type="file" name="file1" />',
						// 	),
						// ),
						
						// 'xx' => array(
						// 	'label' => 'Execl檔案匯出',
						// 	'type' => 'inputn',
						// 	'other' => array(
						// 		'html' => '<a href="/include/expole.php" target="_BREAK">產品資料檔案</a>',
						// 	),
						// ),
						// 'gg' => array(
						// 	'label' => '&nbsp;',
						// 	'type' => 'inputn',
						// 	'other' => array(
						// 		'html' => '&nbsp;',
						// 	),
						// ),												
					),
				),
				// array(
				// 	'form' => array('enable' => false),
				// 	'type' => '2',
				// 	//#30719
				// 	'field' => array(
				// 			'iframe_ckfinder' =>  array(
				// 			'label' => '&nbsp;',
				// 			'type' => 'iframe',
				// 			'attr' => array(
				// 				'id' => 'iframe_ckfinder',
				// 				'width' => '100%',
				// 				'height' => '600',
				// 				'src' => '/ckfinder/ckfinder.html',
				// 			),
				// 		),
				// 	),
				// ),
				array(
					'form' => array('enable' => false),
					'type' => '2',
					'field' => array(
											
						'kc01' => array(
							'label' => '產品檔案<br />',
							'type' => 'kcfinder_school',
							'attr' => array(
								'width' => '700',
								'height' => '400',
							),
							'other' => array(
								'uploadurl_id' => 'assetsdir',
								'type' => 'member',
								//'width' => '400',
								'height' => '170',
								'school_id' => '',
								//'dir' => 'omax/',
							),
						),						
					),
				),
			),
		), // updatefield
	);

	// protected function beforeAction($action)
	// {
	// 	parent::beforeAction($action);

	// 	$tmp = $this->def['updatefield']['sections'][0]['field']['sys_config_articlesingle'];
	// 	$tmp['attr']['id'] .= '_'.$this->data['admin_switch_data_ml_key'];
	// 	$tmp['attr']['name'] .= '_'.$this->data['admin_switch_data_ml_key'];
	// 	$this->def['updatefield']['sections'][0]['field']['sys_config_articlesingle_'.$this->data['admin_switch_data_ml_key']] = $tmp;

	// 	unset($this->def['updatefield']['sections'][0]['field']['sys_config_articlesingle']);

	// 	return true;
	// }
	public function _fgetcsv($handle, $length = null, $d = ",", $e = '"') {
		$d = preg_quote($d);
		$e = preg_quote($e);
		$_line = "";
		$eof=false;
		while ($eof != true) {
			$_line .= (empty ($length) ? fgets($handle) : fgets($handle, $length));
			$itemcnt = preg_match_all('/' . $e . '/', $_line, $dummy);
			if ($itemcnt % 2 == 0)
				$eof = true;
		}
	   $_csv_line = preg_replace('/(?: |[ ])?$/', $d, trim($_line));

		$_csv_pattern = '/(' . $e . '[^' . $e . ']*(?:' . $e . $e . '[^' . $e . ']*)*' . $e . '|[^' . $d . ']*)' . $d . '/';
		preg_match_all($_csv_pattern, $_csv_line, $_csv_matches);
		$_csv_data = $_csv_matches[1];

		for ($_csv_i = 0; $_csv_i < count($_csv_data); $_csv_i++) {
			$_csv_data[$_csv_i] = preg_replace("/^" . $e . "(.*)" . $e . "$/s", "$1", $_csv_data[$_csv_i]);
			$_csv_data[$_csv_i] = str_replace($e . $e, $e, $_csv_data[$_csv_i]);
		}
		return empty ($_line) ? false : $_csv_data;
	}

	public function _fgetcsv2($handle, $length = null, $d = ",", $e = '"'){
		$d = preg_quote($d);
		$e = preg_quote($e);
		$_line = "";
		$eof=false;
		while ($eof != true) {
			$_line .= (empty ($length) ? fgets($handle) : fgets($handle, $length));
			$itemcnt = preg_match_all('/' . $e . '/', $_line, $dummy);
			if ($itemcnt % 2 == 0)
				$eof = true;
		}
	}

	public function _moveformat($param='')
	{
		$param = str_replace('"','\"',$param);
		$param = nl2br($param);
		$param = strip_tags($param);
		//#34205 
		$param = str_replace(' ','',$param);
		$param = str_replace('　 　','',$param);
		$param = str_replace('　','',$param);
		$param = str_replace(' ','',$param);
		//$param = str_replace('<br />','',$param);
		return $param;
	}

	public function _moveblank($str=''){
		//http://blog.xuite.net/coke750101/networkprogramming/31431168-%E5%8E%BB%E9%99%A4%E5%AD%97%E4%B8%B2%E4%B8%AD%E9%96%93%E7%9A%84%E9%80%A3%E7%BA%8C%E7%A9%BA%E7%99%BD
		//$str = " This line contains\tliberal \r\n use of whitespace.\n\n";
		$str = trim($str);
 
		// Now remove any doubled-up whitespace
		//去掉跟隨別的擠在一塊的空白
		$str = preg_replace('/\s(?=\s)/', '', $str);
 
		// Finally, replace any non-space whitespace, with a space
		//最後，去掉非space 的空白，用一個空格代替
		$str = preg_replace('/[\n\r\t]/', ' ', $str);
 
		// Echo out: 'This line contains liberal use of whitespace.'
		return $str;
	}

	public function actionExport($param='')
	{	
		//預先載入產品類別資料
		$rows1 = $rows2 = $this->db->createCommand()->from('producttype')->where('ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();

		$rows = $this->db->createCommand()->from('html')->where('type=:type and ml_key=:ml_key',array(':type'=>'product',':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
		if($rows and count($rows) > 0){ 			
			header("Content-type:application/vnd.ms-excel");
			header("Content-Disposition:filename=product.csv");
			echo  mb_convert_encoding('品牌,品項,貨號,馬力數,備註,'."\n","BIG5","UTF-8");
			foreach($rows as $k => $v){
				//讀取子分類資料
				foreach($rows2 as $k2 => $v2){
					if($v2['id'] == $v['class_id']){
						$s2 = array('id'=>$v2['id'],'pid'=>$v2['pid'],'name'=>$v2['name']);
					}
				}
				//讀取主分類資料
				foreach($rows1 as $k1 => $v1){
					if($v1['id'] == $s2['pid']){
						$s1= array('id'=>$v1['id'],'pid'=>$v1['pid'],'name'=>$v1['name']);
					}
				} 
				$field_ddd = ',';
				if($v['field_data']){
					$field_ddd = ',"'.$this->_moveformat($v['field_data']).'"';
				}
				echo  mb_convert_encoding('"'.$this->_moveformat($s1['name']).'","'.$this->_moveformat($s2['name']).'","'.$this->_moveformat($v['topic']).'","'.$this->_moveformat($v['detail']).'",'.$field_ddd."\n","BIG5","UTF-8");
			}
		}
	}

	public function actionIndex($param='')
	{
		if(empty($_POST)){
			$this->data['def'] = $this->def;
			//var_dump($this->data['updatecontent']);
			$this->data['updatecontent'] = array();
			$this->data['main_content'] = 'default/update';
			$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'];//'/import.php';
			// $this->data['def']['updatefield']['form']['attr']['action'] = '/include/import.php';//'/import.php';
			$this->display('index.htm', $this->data);
		} else {
			$save = $_POST;
			
			if(!empty($_FILES["file1"])){
				if ($_FILES["file1"]["error"] > 0) {
					//echo "Return Code: " . $_FILES["file1"]["error"] . "<br>";
					$redirect_url = '';
					G::alert_and_redirect($_FILES["file1"]["error"], $redirect_url, $this->data);
				}else{
						setlocale(LC_ALL, 'zh_TW.UTF-8 UTF-8');
						$row = 0; 
						$fp = fopen ($_FILES["file1"]["tmp_name"],"r");
						$i =1;
						$db = Yii::app()->db;
						
						while ($data = $this->_fgetcsv ($fp, 99999, ",")) {
							$num = count ($data); 							
							$pid=0;
							$row++;
							if($row==1) continue;
							
							//echo $data[0];

							//檢查有無主索引，若無則寫入
							$rows1 = $this->db->createCommand()->from('producttype')->where('name=:name and pid=0 and ml_key=:ml_key',array(':name'=>$data[0],':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
							
							if($rows1 and count($rows1) > 0){ //如有資料則取出ID
								$pid =  $rows1['id'];
							}else{ //沒有資料就新增		
								if($data[0]!=''){
									$sql="INSERT INTO producttype (ml_key, pid, is_enable, create_time, name) VALUES(:ml_key,0,1,:create_time,:name)";
									$command=$db->createCommand($sql);
									// PDO::PARAM_STR
									// PDO::PARAM_INT
									$time = date("Y-m-d H:i:s");
									$data_0 = trim($data[0]);
									$command->bindParam(":ml_key",$this->data['admin_switch_data_ml_key'],PDO::PARAM_STR);
									$command->bindParam(":create_time",$time,PDO::PARAM_STR);
									$command->bindParam(":name",$data_0,PDO::PARAM_STR);
									$command->execute();
									$pid = $db->getLastInsertID();//取得AutoInsertid
								}
							}

							//檢查有無子索引，若無則寫入
							$rows1 = $this->db->createCommand()->from('producttype')->where('name=:name and pid=:pid and ml_key=:ml_key',array(':name'=>$data[1],':pid'=>$pid,':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
							
							if($rows1 and count($rows1) > 0){ //如有資料則取出ID
								$pid =  $rows1['id'];
							}else{ //沒有資料就新增		
								if($data[1]!=''){
									$sql="INSERT INTO producttype (ml_key, pid, is_enable, create_time, name) VALUES(:ml_key,$pid,1,:create_time,:name)";
									$command=$db->createCommand($sql);								
									$time = date("Y-m-d H:i:s");
									$data_1 = trim($data[1]);
									$command->bindParam(":ml_key",$this->data['admin_switch_data_ml_key'],PDO::PARAM_STR);
									$command->bindParam(":create_time",$time,PDO::PARAM_STR);
									$command->bindParam(":name",$data_1,PDO::PARAM_STR);
									$command->execute();
									$pid = $db->getLastInsertID();//取得AutoInsertid
								}
							}
							$member_id = $row-1;
							//檢查有無產品資料，若無則寫入，若有則更新
							$rows1 = $this->db->createCommand()->from('html')->where('type=:type and ml_key=:ml_key and member_id=:member_id',array(':type'=>'product',':ml_key'=>$this->data['admin_switch_data_ml_key'],':member_id'=>$member_id))->queryRow();
						
							if($rows1 and count($rows1) > 0){ //如有資料則比對資料，若不一樣則更新
								if($data[2]!=''){
									if($data[2]!=$rows1['topic'] or $pid!=$rows1['class_id'] or $data[3]!=$rows1['detail']){
										$sql="UPDATE html SET topic=:topic,class_id=".$pid.",detail=:detail,update_time=:update_time WHERE ml_key=:ml_key and member_id=".$member_id;
										$command=$db->createCommand($sql);									
										$time = date("Y-m-d H:i:s");										
										$data_2 = $this->_moveblank($data[2]);
										$data_3 = $this->_moveblank($data[3]);
										$command->bindParam(":ml_key",$this->data['admin_switch_data_ml_key'],PDO::PARAM_STR);
										$command->bindParam(":update_time",$time,PDO::PARAM_STR);
										$command->bindParam(":topic",$data_2,PDO::PARAM_STR);
										$command->bindParam(":detail",$data_3,PDO::PARAM_STR);
										$command->execute();
									}
								}
							}else{ //沒有資料就新增		
								if($data[2]!=''){
									$sql="INSERT INTO html (type, ml_key, class_id, member_id, is_enable, create_time, topic, detail, field_data,other1,other2) VALUES(:type,:ml_key,$pid,$member_id,1,:create_time,:topic,:detail,:field_data,:other1,:other2)";
									$command=$db->createCommand($sql);									
									$time = date("Y-m-d H:i:s");$ttype='product';
									$data_0 = trim($data[0]);
									$data_1 = trim($data[1]);
									$data_2 = $this->_moveblank($data[2]);
									$data_3 = $this->_moveblank($data[3]);
									$data_4 = $this->_moveblank($data[4]);
									$command->bindParam(":type",$ttype,PDO::PARAM_STR);
									$command->bindParam(":ml_key",$this->data['admin_switch_data_ml_key'],PDO::PARAM_STR);
									$command->bindParam(":create_time",$time,PDO::PARAM_STR);
									$command->bindParam(":topic",$data_2,PDO::PARAM_STR);
									$command->bindParam(":detail",$data_3,PDO::PARAM_STR);
									$command->bindParam(":field_data",$data_4,PDO::PARAM_STR);
									$command->bindParam(":other1",$data_0,PDO::PARAM_STR);
									$command->bindParam(":other2",$data_1,PDO::PARAM_STR);
									$command->execute();									
								}
							}
							
							//if($row > 3) die;
							//echo $pid;
						}
						fclose ($fp);
						/*$aaa_xxx = <<<XXX
							<meta charset="utf-8" />
							<script type="text/javascript">
								alert('上傳成功');
							</script>
						XXX;
						echo $aaa_xxx;
						*/
				}
			}else
				echo "Invalid file";
		
			$this->redirect($this->createUrl($this->data['router_class'].'/'.$this->data['router_method']));
		}
	}

}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');
