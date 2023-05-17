<?php

class ApplicationimportController extends Controller
{
	protected $def = array(
		'disable_index_normal_search' => true,

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
			'smarty_javascript_text' => "$('.indexgo03').hide()",
			'method' => 'update',
			'form' => array(
				'enable' => false,
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
					'form' => array(
						'enable' => false,											
					),
					'type' => '1',
					'field' => array(
						'gg' => array(
							'label' => '&nbsp;',
							'type' => 'inputn',
							'other' => array(
								'html' => '<p style="color:red">只能使用單一工作表，禁止修改第一橫列，禁止移動欄位，從第二橫列開始填寫，單一橫列只填寫一個 part number 資料，灰色底的欄，可不填資料，所有資料儲存格的內容，不得有換行或斷行</p>',
							),
						),
					),
				),
				array(
					'form' => array(
						'enable' => true,
						'attr' => array(
							'id' => 'form_data',
							'name' => 'form_data',
							'method' => 'post',
							'action' => '',
							'enctype' => 'multipart/form-data',
						),						
					),
					'type' => '1',
					'field' => array(						
						'xx01a' => array(
							'label' => 'Execl檔案匯入',
							'type' => 'inputn',
							'other' => array(
								'html' => '<input type="file" name="file1" /><button class="btn blue" type="submit"><i class="icon-ok"></i>Submit</button>',
							),
						),						
						'gg' => array(
							'label' => '&nbsp;',
							'type' => 'inputn',
							'other' => array(
								'html' => '',
							),
						),
					),
				),
				//array(
				//	'form' => array('enable' => false),
				//	'type' => '2',
				//	'field' => array(
				//		'iframe_ckfinder' =>  array(
				//		'label' => '&nbsp;',
				//		'type' => 'iframe',
				//		'attr' => array(
				//			'id' => 'iframe_ckfinder',
				//			'width' => '100%',
				//			'height' => '600',
				//			'src' => '/ckfinder/ckfinder.html',
				//		),
				//	),
//
				//							
				//		//'kc01' => array(
				//		//	'label' => '產品代表圖<br />',
				//		//	'type' => 'kcfinder_school',
				//		//	'attr' => array(
				//		//		'width' => '700',
				//		//		'height' => '400',
				//		//	),
				//		//	'other' => array(
				//		//		'uploadurl_id' => 'assetsdir_old',
				//		//		'type' => 'product',
				//		//		//'width' => '400',
				//		//		'height' => '170',
				//		//		'school_id' => 'upload',
				//		//		//'dir' => 'product2',
				//		//	),
				//		//),	
//
				//		//'kc02' => array(
				//		//	'label' => '產品CAD、型錄<br />',
				//		//	'type' => 'kcfinder_school',
				//		//	'attr' => array(
				//		//		'width' => '700',
				//		//		'height' => '400',
				//		//	),
				//		//	'other' => array(
				//		//		'uploadurl_id' => 'assetsdir_old',
				//		//		'type' => 'product',
				//		//		//'width' => '400',
				//		//		'height' => '170',
				//		//		'school_id' => 'file',
				//		//		//'dir' => 'product2',
				//		//	),
				//		//),						
				//	),
				//),
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


	public function actionIndex($param='')
	{
		if(empty($_POST)){
			$this->data['def'] = $this->def;
			//var_dump($this->data['updatecontent']);
			$this->data['updatecontent'] = array();
			$this->data['main_content'] = 'default/update';
			//$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'];//'/import.php';
			// 改用外部程式處理
			$this->data['def']['updatefield']['sections'][1]['form']['attr']['action'] = '/include/import_print.php?ml_key='.$this->data['admin_switch_data_ml_key'];//'/import.php';
			$this->display('index.htm', $this->data);
		} else {
			$save = $_POST;
			
			if(!empty($_FILES["file1"])){
				if ($_FILES["file1"]["error"] > 0) {
					//echo "Return Code: " . $_FILES["file1"]["error"] . "<br>";
					$redirect_url = '';
					G::alert_and_redirect($_FILES["file1"]["error"], $redirect_url, $this->data);
				}else{
						ini_set("auto_detect_line_endings", true);
						setlocale(LC_ALL, 'zh_TW.UTF-8 UTF-8');
						$row = 0; 
						$fp = fopen ($_FILES["file1"]["tmp_name"],"r");
						$i =1;
						$db = Yii::app()->db;
						
						while ($data = $this->_fgetcsv ($fp, 99999, ",")) {
							$num = count ($data); 							
							$pid=0;
							$row++;
							if($data[0] == '品牌') continue;
							if($row==1) continue;

							//if($data[0]=='' && $data[1]=='') continue;
							
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
							$rows1 = $this->db->createCommand()->from('product')->where('type=:type and ml_key=:ml_key and member_id=:member_id',array(':type'=>'product',':ml_key'=>$this->data['admin_switch_data_ml_key'],':member_id'=>$member_id))->queryRow();
						
							if($rows1 and count($rows1) > 0){ //如有資料則比對資料，若不一樣則更新
								if($data[2]!=''){
									if($data[2]!=$rows1['topic'] or $pid!=$rows1['class_id'] or $data[3]!=$rows1['detail']){
										$sql="UPDATE product SET topic=:topic,class_id=".$pid.",detail=:detail,update_time=:update_time WHERE ml_key=:ml_key and member_id=".$member_id;
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
									$sql="INSERT INTO product (type, ml_key, class_id, member_id, is_enable, create_time, topic, detail, field_data,other1,other2) VALUES(:type,:ml_key,$pid,$member_id,1,:create_time,:topic,:detail,:field_data,:other1,:other2)";
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
